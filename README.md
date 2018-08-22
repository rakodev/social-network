Social Network Demo Project
===

##### Social Network Demo Code based on Symfony 4.1+ & PHP 7.2+

## Quickstart - Installation
- Download and **Install Docker**:
https://www.docker.com/community-edition#/download
- Execute: **git clone https://github.com/rakodev/social-network.git**
- Execute: **cd social-network/**
* Install Projects API & Admin:
- docker-compose up -d
- docker-compose exec --user www-data sn-php-fpm-api bash -c 'cd /application/api && composer install'
- docker-compose exec --user www-data sn-php-fpm-admin bash -c 'cd /application2/admin && composer install'
* Create & populate database:
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && bin/console doctrine:migrations:migrate'
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && php bin/console doctrine:fixtures:load'

#### Run the project
- **That's all!** Now you can open this address on your browser:
    - [http://localhost:8011/](http://localhost:8011/)
- PhpMyAdmin, You can see the Mysql Database:
    - [http://localhost:8013/](http://localhost:8013/)
    - username: **docker**
    - password: **docker**

## Run Unit test
- docker-compose exec --user www-data sn-php-fpm-api bash -c 'cd /application/api && ./bin/phpunit'
###### If you see Doctrine ClassLoader is deprecated it will be resolve in the next version of symfony
https://github.com/symfony/symfony/pull/27609

## Docker Stop
- docker-compose stop

# Improvements to do
- Write more Tests
    - https://phpunit.readthedocs.io/en/7.3/
- Error message with Symfony Validator
- API documentation with Swager 
- Add cache to the API
- Use ajax into the Admin panel

## Project creation - Good to Know - Tips
- docker-compose up -d
- docker-compose exec --user www-data sn-php-fpm-api bash -c 'cd /application/api && composer create-project symfony/skeleton .'
- docker-compose exec --user www-data sn-php-fpm-admin bash -c 'cd /application2/admin && composer create-project symfony/website-skeleton .'
* https://symfony.com/doc/current/doctrine.html
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && composer require symfony/orm-pack'
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && composer require symfony/maker-bundle --dev'
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && php bin/console make:entity'
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && php bin/console make:migration'
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && bin/console doctrine:migrations:migrate'
* Symfony create Service
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && php bin/console make:controller UserController'
- docker-compose exec sn-php-fpm-admin bash -c 'cd /application2/admin && php bin/console make:controller IndexController'
* https://symfony.com/doc/master/bundles/DoctrineFixturesBundle/index.html
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && composer require --dev doctrine/doctrine-fixtures-bundle'
* Clear Symfony Cache
- docker-compose exec sn-php-fpm-api bash -c 'cd /application/api && php bin/console cache:clear'
- docker-compose exec sn-php-fpm-admin bash -c 'cd /application2/admin && php bin/console cache:clear'
* Install some more vendor
- docker-compose exec --user www-data sn-php-fpm-api bash -c 'cd /application/api && composer require --dev symfony/phpunit-bridge'
- docker-compose exec --user www-data sn-php-fpm-api bash -c 'cd /application/api && composer require symfony/browser-kit'
###### Don't forget to add this line into your phpunit.xml.dist file in the root of your Symfony application
`<php> ...
    <env name="DATABASE_URL" value="mysql://docker:docker@sn-mariadb:3306/test" />
... </php>`
- docker-compose exec --user www-data sn-php-fpm-admin bash -c 'cd /application2/admin && composer require guzzlehttp/guzzle'
## More about unit testing with Symfony
* https://symfony.com/doc/current/testing.html


