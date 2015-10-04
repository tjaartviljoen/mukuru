Mukuru Technical Assessment Deployment Instructions
===================================================


Notes
-----
This project was developed on CentOS7 and assumes an environment that allows for setting up a relevant virtual host.
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

Scripts
-------
To fetch the latest exchange rates from jsonrates run the following command in the project root:
 php public/index.php retrieve rates

