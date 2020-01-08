<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

### Installation

Clone repository and set Apache's or Nginx's document root to public folder.

Run following commands

```
composer install
yarn
yarn dev (for production yarn prod)
```

Copy `.env.example` to `.env` file and edit your db and other configs. Set `APP_DEBUG` to `false` and `APP_ENV` to `production`
```
cp .env.example .env
```

After that, run artisan commands (generate key, migrations and seeders)
```
php artisan key:generate
php artisan migrate --seed
```

**NOTE!** If website fails to run, then run
```
chmod -R 777 storage
```
