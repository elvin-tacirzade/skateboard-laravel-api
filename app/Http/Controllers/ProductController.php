<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Orders;
use App\Models\Skateboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function products()
    {
        $skateboards = Skateboard::paginate(15);
        $count = $skateboards->count();
        $array = array();

        if ($count == 0) {
            $array["products"] = "Unfortunately. No active products";
        } else {

            $array["current_page"] = $skateboards->currentPage();
            if ($skateboards->nextPageUrl() != null) {
                $array["next_page_url"] = $skateboards->nextPageUrl();
            }
            if ($skateboards->previousPageUrl() != null) {
                $array["previous_page_url"] = $skateboards->previousPageUrl();
            }
            $array["all_pages"] = $skateboards->lastPage();
            $array["total_product"] = $count;

            for ($i = 0; $i < $count; $i++) {
                $color_json = json_decode($skateboards[$i]->color_id, true);
                $color = array();
                for ($j = 0; $j < count($color_json); $j++) {
                    $name = Color::find($color_json[$j])->name;
                    array_push($color, $name);
                }
                $array["products"][$i] = array(
                    "name" => $skateboards[$i]->name,
                    "type" => $skateboards[$i]->type()->name,
                    "color" => $color,
                    "price" => $skateboards[$i]->price,
                    "print_price" => $skateboards[$i]->print_price
                );
            }
        }

        return response()->json($array, 200);
    }

    public function add_product(Request $request)
    {
        /* color_id db-də (skateboard) array formasında saxladığım üçün validation istifadə edən zaman
           exist olub olmadığını validation ilə yoxlaya bilmədim. Ona görə aşağıda manuel olaraq yoxlama apardım */

        $rules = [
            'product_id' => 'required | numeric | exists:skateboard,id',
            'color_id' => 'required | numeric| exists:color,id',
            'amount' => 'required | numeric | min:1 | max:10',
            'print_photo' => 'nullable | image | max:2048',
            'email' => 'required_if:phone,=,null',
            'phone' => 'required_if:email,=,null',
            'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        /* required_if sadecə null variantı üçün işlədi.
           Əgər email ve phone hər ikisini yazmayıb post edirsə bu post success olurdu.
           Onun üçün aşağıdakı şərti verdim */

        if (!$request->email and !$request->phone) {
            return response()->json(array("error" => ["Any of the email or phone fields are required"]), 400);
        }

        $skateboard = Skateboard::where('id', $request->product_id)->first();
        $skateboard_color = json_decode($skateboard->color_id, true);

        if (in_array($request->color_id, $skateboard_color)) {

            $new_order = new Orders();
            $new_order->product_id = $request->product_id;
            $new_order->color_id = $request->color_id;
            $new_order->amount = $request->amount;

            if ($request->hasFile('print_photo')) {
                //image
                $image = $request->file('print_photo');
                $name = Str::random(16) . '.' . $image->getClientOriginalExtension();
                $directory = public_path('assets/print_photo');
                $image->move($directory, $name);
                $new_order->print_photo = $name;
                //price
                $price = $skateboard->price * (int)$request->amount + $skateboard->print_price;
            } else {
                $price = $skateboard->price * (int)$request->amount;
            }

            $new_order->total_price = $price;
            $new_order->email = $request->email;
            $new_order->phone = $request->phone;
            $new_order->address = $request->address;
            $new_order->created_at = date("Y-m-d H:i:s");
            $new_order->updated_at = date("Y-m-d H:i:s");
            if ($new_order->save()) {
                return response()->json(array("success" => ["The product has been successfully added"]), 201);
            } else {
                return response()->json(array("error" => ["An error occurred. Please try again"]), 400);
            }
        } else {
            return response()->json(array("color_id" => ["The selected color id is invalid"]), 400);
        }
    }
}
