# Php Challenge 

    Laravel Framework 7.30.4
    Mysql
    
## Kurulum
    .env dosyasından change APP_URL değiştir.
    APP_URL = http://localhost 

#### Database - Sql
    import __db__/php-challenge.sql
    php artisan db:seed
    
#### Database - Migration 
    php artisan migrate --seed  

## Routes
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    | Domain | Method   | URI                               | Name                          | Action                                                          | Middleware            |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    |        | POST     | api/register                      | register                      | App\Http\Controllers\Api\RegisterController                     | api                   |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    |        | POST     | api/purchase                      | purchase.purchase             | App\Http\Controllers\Api\PurchaseController                     | api                   |
    |        | POST     | api/purchase/verification/android | purchase.verification.android | App\Http\Controllers\Api\PurchaseVerificationController@android | api, HttpBasicAuth    |
    |        | POST     | api/purchase/verification/ios     | purchase.verification.ios     | App\Http\Controllers\Api\PurchaseVerificationController@ios     | api, HttpBasicAuth    |
    |        | POST     | api/3rd-party-app/send            | thirdPartyApp.send            | App\Http\Controllers\Api\ThirdPartyAppController                | api                   |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    |        | POST     | api/subscription                  | subscription                  | App\Http\Controllers\Api\SubscriptionController                 | api                   |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    |        | GET|HEAD | api/report                        | report                        | App\Http\Controllers\Api\ReportController                       | api                   |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+
    |        | GET|HEAD | api/worker                        | worker                        | App\Http\Controllers\Api\WorkerController                       | api                   |
    +--------+----------+-----------------------------------+-------------------------------+-----------------------------------------------------------------+-----------------------+


## Postman
    __postman__/php_challenge_postman.json dosyasnı kullanabilirsiniz.