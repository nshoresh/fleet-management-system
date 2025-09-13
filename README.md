# PNG Road Fund Fleet Management System

## Technology Stacks
1. Laravel 
2. Livewire
3. Tailwind CSS

## TODO List
   - [ ]  Database Models and Migration `#InProgress`
   - [ ]  Livewire Views and Component development `#InProgress`
   - [ ]  Tailwind Class Refactoring  on all views for Consistency- `#Pending`
   - [ ]  Gracefull Error Handling for Backend Codes `#Pending`
   - [ ]  GUI Layouts Refactoring `#InProgress`
   - [ ]  Billing Fetures Development `#Pending`
   - [ ]  Notifications  systems and Chunels Integrations `#Pending`
   - [ ]  Digital PayMent Methods Integration `#Pending`
   - [ ]  QA Testing and Feedback `#Ongoing` `#Pending`
   - [ ]  Web Routes Refactiring and Standardization `#Pending`
   - [ ]  Web Routes Indexing and Search Query Optimization

## Local Development Prerequisite
In oder to install the Project  and run a local devlepment environment for this project, the following tools are needs to be installed on your machine
1.  PHP vesion (Version: >=8.2)
2.  Composer (Version:  2.6.3)
3.  Nodejs (Version: >=20)
4.  NPM (Version:>=10)

## Local Development Guide
1. Clone this repository to  your local Director  with ssh: ```git clone git@github.com:yumicode-png/pngrf-fleet-management.git <project-directory>``` or  https: ```git clone https://github.com/yumicode-png/pngrf-fleet-management.git <project-directory> ```
2. cd into the your Local project Directory ``cd <project-directory>``
3. Install all the composer dependencies with ``composer install``
4. Install  all frontend assets dependencies with ``npm install``
5.  Create a .env file and copy the contents of .env.example into .env file
6.  Generate the Application Secrete Key with ```php artisan key:generate```
7.  Initialize the Database by running ``php artisan migrate:fresh --seed``
8.  Initialize and build fronted assets with ``npm run build`` or start development server for frontend with ```npm run dev```  on a seperate terminal window
9.  Start the Development web server with ```php artisan server --port=33034 --host=localhost``` to start local development server on port 33034 
    - Note: you can choose any port your prefer

# pngrf-fleet-management
