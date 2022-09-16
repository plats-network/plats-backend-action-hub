<p align="center"><img alt="Plats Network" src=""></p>


## 1. About Plats Network

Plats Network is a pioneering on-chain marketing platform, aiming to change how a brand approaches the potential customers and how regular customers interact with a brand ads. Both are in an ACTIVE manner.

## 2. Deploy (thủ công)
```shell
    composer install
```

```shell
    npm install
```

```shell
    npm run prod
```

```shell
    php artisan storage:link
```

## 3. Deploy command (auto from local)

### production
```shell
dep deploy production
```

### staging
```shell
dep deploy staging
```

### development
```shell
dep deploy development
```

#### Note: Check routes api
```shell
php artisan route:list --path=api
```
