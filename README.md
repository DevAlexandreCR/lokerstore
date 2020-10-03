# LokerStore

LokerStore is an online store development with PHP, Laravel and Vue.

## Instalation

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
- php artisan migrate
- npm run dev
- php artisan storage:link
```
To test app
```bash
- cp .env.testing.example .env.testing
- php artisan test
```
 To test store with fake data
```bash
- php artisan db:seed
- php artisan serve
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
