# Description
App to build shopping lists and document history of expenses from these lists for multiple users.

![alt text](https://kacper.tech/files/604df151b8e3f273516322.gif  "Overview")

# Development

```
docker-compose up
```

http://localhost:8082

# Requirements
- php >=7.2.5
- mysql >= 5.7
- [composer](https://getcomposer.org/download/)
- [yarn](https://classic.yarnpkg.com/en/docs/install/#debian-stable)
- [symfony cli](https://symfony.com/download)

# Installation
1. `composer install`
2. `cp .env .env.local`
3. `nano .env.local` - edit values
4. `php bin/console doctrine:database:create`
5. `php bin/console doctrine:schema:update --dump-sql --force --complete`
6. `php bin/console doctrine:fixtures:load --no-interaction`
7. `yarn install`
8. `yarn encore production`
9. `nano .env.local` - edit APP_ENV=prod