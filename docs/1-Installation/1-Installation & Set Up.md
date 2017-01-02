# Installation & Set Up

- [Clone](#clone)
- [Get Dependencies](#dependencies)
- [Run migrations](#migrations)
- [Set up front end](#frontend)

<a name="clone"></a>
## Clone
```
cd <your code dir>
git clone git@github.com:NukaSRB/TheLab.git ./TheLab
```

<a name="dependencies"></a>
## Get dependencies
```
composer install
yarn
php artisan key:generate
```

<a name="migrations"></a>
## Run migrations
```
php artisan migrate
php artisan db:seed --class=RBACSeeder
php artisan db:seed --class=UserStatusSeeder
```

<a name="frontend"></a>
## Set up front end
```
gulp
```
