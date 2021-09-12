# Skateboard rest api
## Bütün məhsullara baxış
Method: get
``` 
http://127.0.0.1:8000/api/products
```
## Yeni məhsul əlavəsi
Method: post
``` 
http://127.0.0.1:8000/api/add-product 
```
Body: form-data
1. product_id 
2. color_id
3. amount 
4. print_photo ( optional ) 
5. email 
6. phone 
7. address 
## Bütün sifarişlərə baxış 
Method: get 
```
http://127.0.0.1:8000/api/orders
``` 
## Seçilmiş sifarişin redaktəsi
Method: put 
``` 
http://127.0.0.1:8000/api/order-update
``` 
Body: x-www-form-urlencoded
1. order_id 
2. preparation_date 
3. delivery_date
