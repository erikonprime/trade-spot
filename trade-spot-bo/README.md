# Trade spot backoffice. Work in progress!!!

## Short description
Project created for education purpose
### Tips & Tricks
 ```
docker compose up --force-recreate --build
bo url - http://localhost:8080/
elastic - http://localhost:9200/
elasticsearch gui - https://elasticvue.com/
 ```

# If using the MakerBundle:
 ```
php bin/console make:migration
php bin/console make:entity
 ```

# Without the MakerBundle:
 ```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:drop --full-database --force
php bin/console doctrine:fixtures:load
 ```
### Useful posts
 ```
https://www.binaryboxtuts.com/php-tutorials/symfony-6-json-web-tokenjwt-authentication/
https://rojas.io/how-to-store-a-jwt-in-a-cookie-and-auto-refresh-the-token-using-lexikjwtauthenticationbundle/
https://dev.to/jszutkowski/securing-api-with-jwt-in-symfony-36dk
https://www.geeksforgeeks.org/jwt-authentication-with-refresh-tokens/
https://ourcodeworld.com/articles/read/1516/how-to-create-your-search-engine-with-elasticsearch-7-and-foselasticabundle-in-symfony-5
 ```
