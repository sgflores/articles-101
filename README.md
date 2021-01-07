# articles-101

# Installation

**Step 1:** Open CMD and run command

`$ git clone https://github.com/sgflores/articles-101.git`

**Step 2:** Move into the new folder  `articles-101` 

`$ cd articles-101`

**Step 3:** Install composer dependencies. 

`$ composer install`

**Step 4:** Next, create a .env file. NOTE: You will also have to update your db credentials

`$ cp .env.example .env`

**Step 5:** Then generate the application key for this project 

`$ php artisan key:generate`

**Step 6:** Now lets run our migrations and seeders

`$ php artisan migrate --seed`

`$ php artisan passport:install`

**Step 7:** Install npm dependencies and build the app

`$ npm install`

`$ npm run production`

**Step 8:** Run the project

`php artisan serve`

# Default Login Credentials

email: admin@gmail.com

password: admin

### TESTING

`$ ./vendor/bin/phpunit`
