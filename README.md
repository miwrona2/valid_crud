# Valid CRUD  
## Simple application based on Framework Phalcon 3, with mySQL database  
Allows you to add new `Products`, display list of them, edit and delete them.    
You can do the same with `Partners`, who additionally possess their products.   
The main point of this project is to test validation of form's fields and database operations in php.   


**MySQL configuration**  
* tables from database in ```app/db``` (just create new database 'phalcon_valid_crud' in your phpMyAdmin panel, 
create 2 empty tables: `'partners'` and `'products'` and paste code from `partners.sql` and `products.sql` respectively)  
* don't forget to change your credentials for connection with mySQL in ```app/config/config.php```  

## Installation

Needed any local server (for example Xampp or Wamp).  
Download or clone repo and put in your localhost direction 
(for example `c:/xampp/htdocs/` default for xampp )