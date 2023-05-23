**Laravel test assignment**
==================

Code pricing module for online wholesale store. 

Every product has its own base price.

While every client can have special price for each product if set by admin

Every client (not admin user) will get to see the base price if his/her for that product is not being set up.

Therefore, each product can have different price for EVERY client. 

In case a special price is assigned for that client he / she will see a special price. 

You need to code a module where the admin can set up a special price for Multiple products via one form for EACH client.

Flow will be list of client -> set prices -> that will open list of products and prices can be set there. 

Since it is a Laravel based assignment please also write migrations. 

You can use a starter kit if you wish to or keep the open for public user. 

What we need to see is
--------------------------

* Migrations for the table structure
* How you write code 
* Quality of comments 

Instructions
===============================
* Laravel Version 9 
* Create Migrations
* Fork this repo 
* Push code in your forked repo
* Inform us when done, we will review the code and get back to you. 



## How to run

git clone
composer install
php artisan migrate
php artisan db:seed --class=RoleTableSeeder  
php artisan db:seed --class=UsersTableSeeder  
php artisan serve
 npm run dev
 