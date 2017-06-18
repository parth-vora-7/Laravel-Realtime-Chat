<h3>Prerequisite</h3>

Make sure you have redis installed on your machine and redis service is on.

<h3>How to run?</h3>
sd
1) Install composer dependencies by running composer install

2) Install Laravel echo server globally by running npm install -g laravel-echo-server

3) Change database credentials into .env file according to your environment and run php artisan migrate

4) Set BROADCAST_DRIVER and QUEUE_DRIVER to redis into .env file

5) Change authHost into laravel-echo-server.json file according to your site URL

6) Run laravel-echo-server start (keep running in background)
