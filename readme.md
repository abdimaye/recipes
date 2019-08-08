### Requirements

PHP 7.1.3+

PHP Sqlite Driver

Composer

### Setup

```
composer install
cp .env.example .env
```

### Load/Refresh test data

The project uses sqlite as the db driver. You can reload the migration and test data:

`php artisan migrate:refresh && php artisan db:seed`

### Automated tests

Use PHPUnit from the vendor folder:

`./vendor/bin/phpunit` 

### API

Serve the application: `php -S localhost:8000 -t public`

**Fetch a recipe by id**: `GET '/api/v1/recipes/{id}'`

```
curl -X GET http://localhost:8000/api/v1/recipes/1
```

**Fetch all recipes (paginated)**: `GET '/api/v1/recipes'` 

**You can also filter - e.g. by cuisine (paginated)**: `GET '/api/v1/recipes?recipe_cuisine=british'` 

```
curl -X GET http://localhost:8000/api/v1/recipes?recipe_cuisine=british
```

**Update an existing recipe**: `PATCH: '/api/v1/recipes/{id}'`

(**PATCH** because we only want to return the updated fields)

Required fields: `Any fields you'd like to update`

### Potential Improvements
Given more time, the following immediate improvements come to mind:
- Use Repository pattern to abstract the data layer
- Make validation testing more exhaustive
- Add more failure test cases
- Change 'season' field to enum
- Change pagination from hardcoded figure to a user specified number
- Implement authentication (potentially)

### Assumptions

- Authentication could be applied at the API Gateway layer so no user authentication required this excercise
