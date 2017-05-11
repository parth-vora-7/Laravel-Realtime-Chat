Prerequisite

Set BROADCAST_DRIVER to redis in .env file (And make sure you have redis installed on your machine & redis service is on)

Required commands to run the project:

1) Install composer dependencies by running composer install

2) Install node dependencies by running npm install

3) Install Laravel echo server globally by running npm install -g laravel-echo-server

4) laravel-echo-server start (keep running in background)

5) php artisan queue:work (keep running in background)

6) php artisan serve (optional)


