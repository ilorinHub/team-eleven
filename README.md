# Wholesale E-commerce Platform for Garment Factory

## Requirements
- PHP 8.1
- Laravel 9.x
- MySQL/MariaDB or Postgres
- Composer


## Setup Instructions.

1. Clone the project by running ```git clone git@github.com:ilorinHub/team-eleven.git``` or ```git clone https://github.com/ilorinHub/team-eleven.git``` from your CLI of choice.
2. Run ```cd team-eleven``` to change into the project's directory.
3. Run ```composer install``` to install all php dependencies.
4. Run ```php artisan kit:install```.
5. change all DB_~ configurations in the newly created .env file to the required values for your machine.
6. Create a database with the value of the ```DB_DATABASE``` environment variable as the database name.
7. Run ```php artisan migrate:fresh --seed``` in you CLI to seed the database with sample products, categories and prices.
8. Run ```npm install``` to intall all JavaScript dependencies.
9. Run ``` php artisan serve``` to start the application.
11. Run ```npm run dev``` to compile all frontend assets.
