# My-Library
Formation Symfony 4
# How to install project
```sh
git clone https://github.com/medjalil/My-Library.git
cd My-Library
composer install
php bin/console doctrine:database:create
doctrine:schema:update --force
php bin/console doctrine:fixtures:load 
php bin/console server:run
```
