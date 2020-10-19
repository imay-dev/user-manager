## User Manager API

#### Project Description
- The following project is a **User Manager** API that allows user to register, login, and see their User data. 
- The *super-admin* user can create roles, permissions, assign **roles & permissions** to one another, also assign *roles/permissions* to users. 

#### Installation
- Create `.env` file using `.env.example`
- Install dependencies
```
composer install
```
- Generate a random 32 characters string and set it as your application key under `APP_KEY` variable of your `.env` file. 
- Run the project (e.g. on Port 8000)
```
php -S localhost:8000 -t public
```
