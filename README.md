# Manajamen Inventaris Buku

## Images

![preview img](/preview1.png)
![preview img](/preview2.png)
![preview img](/preview3.png)

## Run Locally

Clone the project

```bash
  git clone https://github.com/RiskyOkta/E-Library
```

Go to the project directory

```bash
  cd project-name
```

-   Copy .env.example file to .env and edit database credentials there

```bash
    composer update
```

```bash
    composer install
```

```bash
    php artisan key:generate
```

```bash
    php artisan migrate:fresh --seed
```

```bash
    php artisan storage:link
```

#### Login

-   email = admin@gmail.com
-   password = rahasia123
