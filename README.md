# shop-checkout


docker-compose up -d --build

docker-compose exec server bash

composer install

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load