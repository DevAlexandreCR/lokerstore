# LokerStore

LokerStore is an online store developed with PHP 7.4, Laravel 7+ and Vue 2.

### Features

- Management of products, stocks, categories, colors, etc... 
- Organization of products by categories
- Orders management
- Order status management
- Admins management
- Admins roles management
- Sales reports automatic and manual
- General reports monthly automatics
- Business metrics on dashboard 
- Integrated with payment gateway [PlaceToPay](https://www.placetopay.com/web/)
- Rest API to products management
- Imports and Export a list of products on Excel
- Showcase 
- Users register
- Cart management
- More...

## Requirements 

- PHP 7.4+ `required`
- Mysql 5.7+ `required`
- Redis to cache, session and queued jobs  `optional`

## Installation

- Clone repository `git clone https://github.com/DevAlexandreCR/lokerstore`
- Use the package manager [composer](https://getcomposer.org/download/) and [npm](https://nodejs.org/es/) to install.

```bash
- composer install
- npm install
```

## Configuration
Copy file `.env.example` in `.env` file and customize your environment to database, mail, cache, etc.

```bash
- cp .env.example .env
```
- Environment variables.   
 `APP_EMAIL_SUPPORT` email to show clients.   
 `LOG_SLACK_WEBHOOK_URL` Url to webhook to slack notifications logs.   
 `P2P_BASE_URL` Url to payments gateway API [PlaceToPay](https://www.placetopay.com/web/)  
 `P2P_SECRET_KEY` Required to gateway authentication     
 `P2P_AUTH` Required to gateway authentication  
 `P2P_TIMEOUT` Max time out to gateway responses  
 `MYSQL_SSL` Required to Azure MYSQL Server always `true`   
 `CACHE_DRIVER` This value **can't** be file, because cache required `tags`   
 `MIX_MAX_PRICE_FILTER` Max product price to accept store  
 `MIX_MIN_PRICE_FILTER` Max product price to accept store  
 `MIX_TAX` Tax value to apply to invoices  
 `MIX_MIN_PRICE_FILTER` Max product price to accept store.  

- Run scripts
```bash
- php artisan migrate --seed
- npm run prod 
- php artisan storage:link
```
- To test app
```bash
- cp .env.testing.example .env.testing
- php artisan test
```
- Create super-admin user
```bash
- php artisan admin:create
```
- To test store with fake data
```bash
- php artisan db:seed --class=DummyDatabaseSeeder
- php artisan serve
```
- To execute schedule tasks like query payments, query metrics and automatics reports
```bash
- php artisan schedule:run
```

- This app use queued jobs to send emails to users about payments, to send emails to admins      
about monthly reports, to generate customized reports, to query status payments to API PlaceToPay  
and more, make sure to run `php artisan queue:work` 
    #####Installing Supervisor  
    Supervisor is a process monitor for the Linux operating system, and will automatically  
    restart your `queue:work` process if it fails. To install Supervisor on Ubuntu, you may use  
    the following command: `sudo apt-get install supervisor`  
    For more information on Supervisor, consult the [Supervisor documentation](http://supervisord.org/index.html).

- To generate metrics with previous fake data installed
```bash
- php artisan metrics:start
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
