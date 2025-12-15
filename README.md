# Limit Order Exchange Mini Engine


## Setup
- PHP 8.2+
- Composer
- MySQL / Postgres


```bash
cp .env.example .env
composer install

npm install
npm run build

php artisan key:generate
php artisan migrate --seed
php artisan serve
