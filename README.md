# Real Time Notification System

An example Laravel application with a real time notification system built using Pusher and Vue.js.

## Progress

- [x] Install Laravel Breeze with Vue
- [x] Install broadcasting with Laravel Echo and Pusher
- [x] Create event UserNotificationEvent broadcasting on private channel
- [x] Authorize broadcasting channel with currrently authenticated user
- [x] Install Laravel Sanctum
- [x] Create notification trigger through API route
- [x] Seed database with 2 users
- [x] Authorize front end to listen to private channels
- [x] Create Vue component NotificationComponent displaying list of notifications with message and timestamp
- [x] Create Vue component NotificationCount displaying a badge with number of unread (?) notifications
- [x] Write documentation how to set up and run project
- [x] Optimization: Use Pinia to share notifications state between components
- [x] Extra: Make notifications readable
- [ ] Extra: Send notifications to other users
- [ ] Extra: Persist notifications in database
- [ ] Figure out how to test broadcasting channel authorization
- [ ] Improve documentation

## Installation

Clone the repository

    git clone git@github.com:lwekuiper/real-time-notification-system.git

Switch to the repo folder

    cd real-time-notification-system

Install the Composer dependencies

    composer install

Install the NPM dependencies

    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations

    php artisan migrate

Seed the database

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone git@github.com:lwekuiper/real-time-notification-system.git
cd real-time-notification-system
cp .env.example .env
docker run -v "$(pwd)":/app composer install
docker run -v "$(pwd)":/app npm install
cd ./docker
docker-compose up -d
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed
docker-compose exec php php artisan serve --host=0.0.0.0
```
