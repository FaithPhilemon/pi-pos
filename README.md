# Radmin: Laravel Dashboard Template Starter
Radmin Laravel Starter revolutionizes website management with advanced user and role management, a flexible REST API, server-side datatables, data editing, and export options. The Themekit Bootstrap 4 interface makes managing websites a breeze.

## Basic Installation
1. Create a database in phpmyadmin. Open `.env` file and change following credentials
```
DB_HOST=127.0.0.1
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
2. You have two options to add the database schema: 
    - either import the `database.sql` file found in the `database` directory 
    - or execute the migration command `php artisan migrate:refresh --seed`

3. Run `php artisan serve` to access the website at http://127.0.0.1:8000/ or http://localhost:8000


## Run inside Docker 🐳
Before running Laravel inside Docker, please make sure you have installed `docker`.

1. Copy environment, docker-compose and Dockerfile

```bash
cp .env.docker.example .env
cp docker-conf/php/local.example docker-conf/php/Dockerfile
cp docker-compose.yml.example docker-compose.yml
```

2. Run the following command to build the Docker image:
```bash
docker compose build
```
This command will download all the necessary dependencies and build the Docker image according to the specifications in the Dockerfile.

3. Once the build is complete, run the following command to start the Docker container: 
```bash
docker-compose up -d
```

4. Run migration and seeder to migrate database. Note this command will refresh your databse also.
```bash
docker compose exec php php artisan migrate:refresh --seed
```
If you dont wan't to refresh databse run
```bash
docker compose exec php php artisan migrate --seed
```
5. Once done, you can visit your website at http://localhost:8900/