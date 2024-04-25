
# Acsoftware Back-end developer test


## 🚀 About Me
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/fernando-gobetti/)


Hello, I am a PHP programmer with over five years of experience. Throughout the years, I have honed my skills in PHP and gained a deep understanding of the WordPress, Laravel, and proprietary software ecosystems.

I have experience with popular PHP frameworks such as Laravel and Zend Framework, as well as another CMS for E-commerce, Magento.

In addition to PHP, I also have knowledge in HTML 5, CSS, Sass, JavaScript, jQuery, JAVA, Springboot, React JS, and React-Native.

I am also familiar with relational databases such as MySQL, MariaDB, PostgreSQL, and SQL Server.


## 1. Technologies used in this project

- Laravel Version 11.4.0
    - Laravel Sanctun
- MySQL Version 8.2.8
- Docker
- Nginx

## 2. Steps to run the project

Clone Repository

```bash

```

Builds, (re)creates, starts, and attaches to containers for a service.
```bash
docker-compose up -d
```

Open the container app
```bash
docker-compose exec app bash
```

Install project dependencies
```bash
composer install
```
Creates all tables in the database
```bash
php artisan migrate
```
Generate keys
```bash
php artisan key:generate
```
Now you can access the project via the link
[http://localhost:8989](http://localhost:8989), has only one page. Laravel's wellcome default page .

## 3. API Documentation
[![Swagger](https://app.swaggerhub.com/img/swaggerhub-logo.svg)](https://app.swaggerhub.com/apis-docs/FernandoGobetti/Acsoftware/1.0.0)

## 4. To run the tests

To run the tests, run the following command in app-buzzvel folder

If docker is not running, run this command to turn it on.

```bash
docker-compose up -d
```
This command will enter the container app

```bash
docker-compose exec app bash
```

To run the tests, just run this command

```bash
php artisan test
```
