# How to run
#### First clone the repo. To do that open your terminal and run bellow code

``if you use SSH ``
> git clone origin git@github.com:KOIDE-JP/FabTrace.git


``if you use HTTPS ``
> git clone origin https://github.com/KOIDE-JP/FabTrace.git

#### Run the composer command to get all the packages with into vendor directory
> composer install

#### Install NPM
>  npm install 

#### Create `` .env `` file from `` .env.example ``. To do that go to project directory and run

>  cp .env.example .env

#### Generate app key

>  php artisan key:generate


#### Changes the database configuration in `` .env `` file

>DB_DATABASE=your_database_name

>DB_USERNAME=root

>DB_PASSWORD=


#### Run the migration command to get all the table into your database
> php artisan migrate

#### Database Seeder
> php artisan db:seed

#### Role Permission
>  php artisan permission:init

#### Create symbolink link
>  php artisan storage:link

<!-- #### Create custom symbolink link -->
<!-- mklink /D C:\laragon\www\CameraUploader\public\uploads D:\CameraUploader\uploads -->







<!-- #### Run the jwt secret to generate secret for API authentication
> php artisan jwt:secret -->
<!-- 
#### Finally, Run the command to get the Bangladesh geo-location data
> php artisan BangladeshGeocode:setup -->


