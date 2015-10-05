Mukuru Technical Assessment Deployment Instructions
===================================================


Please Note
-----------
This project was developed on CentOS7 and assumes an environment that allows for setting up a relevant virtual host.
Please ensure that Sendmail is setup correctly for application emails to function correctly.
Due to time constraints the code was tested only on CentOS 7 running php 5.4 against a MySQL 5.5 database with the
latest Chrome browser.


Installation
------------
1. Setup a virtual host for the project and restart the web server.
   An example apache vhost configuration is provided in deploy/vhost_exchange.conf
   Please ensure that specified folders is corrected in the vhost config before restarting the web server.
2. Create a database for the project, assuming database name 'mukuru';
    CREATE DATABASE `mukuru` /*!40100 DEFAULT CHARACTER SET utf8 */;
3. Configure config/autoload/local.php for correct database access.
4. Create database tables and populate initial data by running the following in project root:
    4.1 chmod u+x rebuild-db.sh
        ./rebuild-db.sh
	4.2 or import the sql_import file in the config/deploy folder by running:
	    mysql -u [username] -p mukuru < config/deploy/mukuru_import.sql from the project root.
	
5. Ensure that the rebuild script / sql import executed without errors.

Users
-----
1. There are 2 client accounts that can be used to log in.
    1.1 tjaart.viljoen:12345678
	1.2 test.user:12345678
2. More users can be added in module/User/src/User/Fixture/User.php if you want to set up your own accounts for testing.
	2.1 ./rebuild-db.sh will have to be executed again for new fixture users to be inserted into the database. (Running ./rebuild-db.sh will clear all existing data and replace it with fixture data)
	
Emails
------
1. Emails are sent to the logged in user's email address should it be neccessary. You can edit any of the user email addresses in mySql or in the 
   module/User/src/User/Fixture/User.php file.

Configuration
-------------
1. Surcharge and Discount can be configured in the currency table per currency.
2. Email triggers can be set by setting the currency record's execute_after value to email.

Web application usage
---------------------
1. Click on login.
2. Enter username (tjaart.viljoen or test.user).
3. Enter password (12345678).
4. On purchase currency screen, click on one of the four currencies provided.
5. Enter a local amount or foreign amount you wish to purchase.
6. Click on the Preview order button.
7. If you're satisfied with the order, click on the Place order button.
8. The order will be placed and you will be redirected to a summary screen containing your order details.
9. If you want to make another purchase, click on the Make another purchase button and repeat from steps 4 onwards.
10.Click on the Logout button to logout.

Web service usage
---------------------
1. Authenticate User (POST)
    - /api/users/v1/authenticate (Raw Json input E.G. - {"username":"tjaart.viljoen","password":"12345678"} )
2. Get User Data (POST)
    - /api/users/v1/get-user-data (Raw Json input E.G. - {"token":"9kocgjv3e5541ide37g24i6tf4"} )
3. Release User Authentication (POST)
    - /api/users/v1/release-authentication (Raw Json input E.G. - {"token":"9kocgjv3e5541ide37g24i6tf4"} )
4. Get Currencies (GET)
    - /api/currencies/v1 (GET request E.G. - /api/currencies/v1?token=9kocgjv3e5541ide37g24i6tf4 )
5. Get Currency (GET)
    - /api/currencies/v1 (GET request E.G. - /api/currencies/v1?token=9kocgjv3e5541ide37g24i6tf4&id=1 )
6. Preview Exchange Order (POST)
    - /exchange-orders/v1 (POST request - Values: token=9kocgjv3e5541ide37g24i6tf4, currencyId=3, userId=1, foreignCurrencyAmount=100, localCurrencyAmount, preview=1)
7. Place Exchange Order (POST)
    - /exchange-orders/v1 (POST request - Values: token=9kocgjv3e5541ide37g24i6tf4, currencyId=3, userId=1, foreignCurrencyAmount=100, localCurrencyAmount, preview=0)
8. View All Orders (GET)
    - /api/exchange-orders/v1 (GET request E.G. - /api/exchange-orders/v1?token=9kocgjv3e5541ide37g24i6tf4)
8. View Order (GET)
    - /api/exchange-orders/v1 (GET request E.G. - /api/exchange-orders/v1?token=9kocgjv3e5541ide37g24i6tf4&id=1)



Scripts
-------
To fetch the latest exchange rates from jsonrates run the following command in the project root:
    - php public/index.php currencies update (This will automatically be executed when you run ./rebuild-db.sh from the project root).

