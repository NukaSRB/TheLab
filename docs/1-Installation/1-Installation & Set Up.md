# Installation & Set Up

## Clone
```
cd <your code dir>
git clone git@github.com:NukaSRB/TheLab.git ./TheLab
```

## Get dependencies
```
composer install
yarn
php artisan key:generate
```

## Run migrations
```
php artisan migrate
php artisan db:seed --class=RBACSeeder
php artisan db:seed --class=UserStatusSeeder
```

## Set up front end
```
gulp
```
