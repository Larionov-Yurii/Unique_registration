Brief description about the project and how to start it

1. Download and install Composer on your computer from the official (https://getcomposer.org/) website, considering what OS you have (Windows, Linux or macOS)
2. Install a relational database management system (RDBMS) like a Mysql and create a database locally with unicode like a utf8mb4_general_ci or utf8_general_ci and named Unique_registration or how you want
3. Open your IDE and create a folder and using Git, clone the repository there: git clone https://github.com/Larionov-Yurii/Unique_registration.git
4. After cloning the repository, using terminal in IDE, we need to use the command (cd) change to the directory: cd Unique_registration
5. After that we need to run (composer install) or (php composer.phar install)
6. Using the command (cp) copy the (.env.example) file and create a new (.env) file in the same directory: cp .env.example .env
7. After that we need to set (.env) file and namely:
   7.1 DB_DATABASE - your database name,
   7.2 DB_USERNAME - username in Mysql ,
   7.3 DB_PASSWORD - password in Mysql,
   7.4 APP_KEY - to get this key, we need to run command in terminal like: php artisan key:generate
8. We also need to run migrations: php artisan migrate
9. And finally we can start the project: php artisan serve
10. The launch of the project begins with the fact that we get to the start page, namely the page with user registration
11. After registration, you will be redirected to an intermediate page, on which there will be a button with a unique link to page A
12. Page A, where various events will take place, such as: generating a random number, getting history, creating a new link or deleting an old link
13. Page A and all its events will be available for the lifetime of the link, that is, when it expires, after refreshing the page, you will be redirected to the login page, where you can re-enter page A
