
## Set up

#### First step: clone repo

```
$ git clone https://github.com/Upsas/ba-laravel-uzduotis.git
```
#### Second step: go to /application directory and run

```
$ composer install
```
#### Third step: set up env variables in docker-compose.yml file
```
MYSQL_ROOT_PASSWORD: root
MYSQL_DATABASE: [your db name]
MYSQL_USER: [your db user]
MYSQL_PASSWORD: [your db user password]
```
#### Change ./application/env.example to ./application/env and set same env variables in file

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=[your db name]
DB_USERNAME=[your db user]
DB_PASSWORD=[your db user password]
```

#### Fourth step: build and run docker container

```
$ docker-compose build --no-cache && docker-compose up -d && docker exec -it ba_laravel_task bash
```

#### Fifth step: after container build you will be automatically inside container run key generation and migrations with seed in container

```
root@[your_container_id]:/var/www/html# php artisan key:generate && php artisan migrate:fresh --seed
```
#### Final step: after db migration and seeding you can log in

```
go to http://localhost/

test account:
email: test@gmail.com
password: password
```

