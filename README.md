# Simple CRM Web App 
![Screenshot 2024-04-03 at 20-09-01 Home](https://github.com/nicholsonz/clients/assets/77360596/43b1cfa6-9748-4da8-99aa-40313e58ef4a)


## Requirements - May or may not work on earlier versions of apps
* Apache or Nginx
* PHP 7.4 +
* MariaDB 10 + 

## Installation

No fancy package managers are needed here. Just create the "clientdb" database and then import the clientdb.sql file into your database, and then edit the dbconfig.php file for your database variables. 

Create a user and assign a password for the database. Be sure to change the user and password for your system.

(MySQL/MariaDB)

Login to your server and run the code below or use phpMyAdmin instead:

    sudo mysql
Then
    
    CREATE DATABASE clientdb; 
    GRANT SELECT, INSERT, UPDATE, DELETE ON clientdb.* to 'user'@'localhost' IDENTIFIED BY 'password';
    FLUSH PRIVILEGES;
    EXIT;

Next, import the clientdb.sql file

    sudo mysql clientdb < clientdb.sql
