# My-Library
Formation Symfony 4
# How to install project
```sh
composer install
php bin/console doctrine:database:create
doctrine:schema:update --force
php bin/console doctrine:fixtures:load 
php bin/console server:run
```
