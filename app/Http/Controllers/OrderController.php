<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Orders::orderBy('id', 'DESC')->paginate(10);
        $count = $orders->count();
        $array = array();

        if ($count == 0) {
            $array["orders"] = "Unfortunately, there are no orders yet.";
        } else {

            $array["current_page"] = $orders->currentPage();
            if ($orders->nextPageUrl() != null) {
                $array["next_page_url"] = $orders->nextPageUrl();
            }
            if ($orders->previousPageUrl() != null) {
                $array["previous_page_url"] = $orders->previousPageUrl();
            }
            $array["all_pages"] = $orders->lastPage();
            $array["total_orders"] = $count;

            for ($i = 0; $i < $count; $i++) {

                $array["orders"][$i] = array(
                    "name" => $orders[$i]->product()->name,
                    "color" => $orders[$i]->color()->name,
                    "amount" => $orders[$i]->amount,
                    "total_price" => $orders[$i]->total_price,
                    "print_photo" => $orders[$i]->print_photo == null ? "No Print Photo" : asset('assets/print_photo/' . $orders[$i]->print_photo),
                    "email" => $orders[$i]->email == null ? "No email address" : $orders[$i]->email,
                    "phone" => $orders[$i]->phone == null ? "No phone number" : $orders[$i]->phone,
                    "address" => $orders[$i]->address,
                    "created_at" => $orders[$i]->created_at,
                    "preparation_date" => $orders[$i]->preparation_date == null ? "No preparation date" : $orders[$i]->preparation_date,
                    "delivery_date" => $orders[$i]->delivery_date == null ? "No delivery date" : $orders[$i]->delivery_date,
                    "updated_at" => $orders[$i]->updated_at,
                );
            }
        }

        return response()->json($array, 200);
    }

    public function order_update(Request $request)
    {
        $order = Orders::find($request->order_id);
        $rules = [
            'order_id' => 'required | numeric | exists:orders,id',
            'preparation_date' => 'required | date | after:'.($order ? $order->created_at :  "null"),
            'delivery_date' => 'required | date | after:preparation_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $order->preparation_date = $request->preparation_date;
        $order->delivery_date = $request->delivery_date;
        $order->updated_at = date('Y-m-d H:i:s');
        if ($order->save()){
            return response()->json(array("success" => ["Order successfully updated"]), 201);
        }else{
            return response()->json(array("error" => ["An error occurred. Please try again"]), 400);
        }
    }
}
