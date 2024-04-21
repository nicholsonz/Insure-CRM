# Simple CRM Web App 
![Screenshot from 2024-04-21 11-21-38](https://github.com/nicholsonz/Simple-CRM/assets/77360596/b4dd1a81-b89c-48ac-beaf-a74396c39424)


## Requirements - May or may not work on earlier versions of apps
* Apache or Nginx
* PHP 7.4 +
* MariaDB 10 + 

## Installation

You don't need any fancy package managers here. Just create the "clientdb" database, import the clientdb.sql file into your database, and then edit the dbconfig.php file for your database variables. 

Create a user and assign a password for the database. Be sure to change the username and password for your system.

(MySQL/MariaDB)

Login to your server and run the code below or use phpMyAdmin instead:

    sudo mysql
Then
    
    CREATE DATABASE clientdb; 
    GRANT SELECT, INSERT, UPDATE, DELETE ON clientdb.* to 'user'@'localhost' IDENTIFIED BY 'password';
    FLUSH PRIVILEGES;
    EXIT;

Next, import the clientdb.sql file

    sudo mysql clientdb < clientdb.sqlf

Visit the login page and select SignUp at the bottom. You will be  greeted with a new user registration page.

That's it!
