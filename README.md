## User Manager API

### Project Description
- The following project is a **User Manager** API that allows user to register, login, and see their User data. 
- The *super-admin* user can create roles, permissions, assign **roles & permissions** to one another, also assign *roles/permissions* to users. 
<br>
### Installation
- Create `.env` file using `.env.example`
- Generate a random 32 characters string and set it as your application key under `APP_KEY` variable of your `.env` file.
- Install dependencies
```
composer install
``` 
- Run Migrations and Seeders to create dummy data
```
php artisan migrate --seed
```
- The seeders will get admin info in CLI to create a super admin user, also it will seed how many sample users you need.
- Create Passport Clients
```
php artisan passport:install
```
- Run the project (e.g. on Port 8000)
```
php -S localhost:8000 -t public
```

<br>
### Built With
* [laravel/lumen-framework](https://github.com/laravel/lumen-framework)
* [laravel/passport](https://github.com/laravel/passport)
* [dusterio/lumen-passport](https://github.com/dusterio/lumen-passport)
* [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
* [pearl/lumen-request-validate](https://github.com/pearlkrishn/lumen-request-validate)

<br>
### Further Information 
- I used ***laravel/passport*** package for authentication along with ***dusterio/lumen-passport*** wrapper to fix the library for **Lumen**.
- I used ***spatie/laravel-permission*** package for roles and permissions.
- I created some pre-defined *permissions/roles* inside *permissions_data/role_data* config files which will be seeded while you use artisan seeding commands.
- The Role *super.admin* will be assigned to the admin user which will get registered by `AdminTableSeeder` automatically.
- Exceptions have been handled inside `Handler` file
- CRUD Methods have specific validations
- `Repositories` have been designed to use over Eloquent Models, and they are bound to their `contracts` inside `RepositoryProvider`, you can check `RepositoryAbstract` to see more. 
- There is a `JsonResponseService` to control format of the responses, it is used inside `MainController` that is implemented inside other controllers.
- There are `Resource Collections` to control the way entities' data will be retrieved.

<br><br>
### API Documents
- [Postman Documentation](https://documenter.getpostman.com/view/4043238/TVYCB1Gk)
- [Postman Collection](https://www.getpostman.com/collections/aed4b1bf14d994ceb73a)
<br>**Note:** *Postman Document and Collection have sample requests/responses inside methods, but feel free to ask about anything that you find not obvious enough.*
