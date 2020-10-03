# LokerStore

LokerStore is an online store developed with PHP 7.4, Laravel 7+ and Vue 2.

## Installation

Use the package manager [composer](https://getcomposer.org/download/) and [npm](https://nodejs.org/es/) to install.

```bash
composer install
```
```node
npm install
```

## Configuration

```bash
- cp .env.example .env
- php artisan migrate --seed
- npm run dev
- php artisan storage:link
```
 To test app
```bash
- cp .env.testing.example .env.testing
- php artisan test
```
 Create super-admin user
```bash
- php artisan admin:create
```
 To test store with fake data
```bash
- php artisan db:seed --class=DummyDatabaseSeeder
- php artisan serve
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
