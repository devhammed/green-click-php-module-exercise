# Module Exercise

This is a module-aware Laravel app stub (contained in [./src](./src)), with a `Demo` module that adds a `GET /demo` endpoint. The Laravel app is a proof-of-concept host that is capable of loading modules (on startup) that extend its functionality, without direct references from the host.

## Technologies

- PHP 8.x
- Laravel 11.x
- Docker 27.x
- MySQL 8.x

## Usage

```bash
# Clone the repository
git clone git@github.com:devhammed/green-click-php-module-exercise.git

# Change directory
cd green-click-php-module-exercise

# Start the app
docker compose up

# Run the migrations
docker compose exec app sh -c "php artisan migrate"

# Seed the database
docker compose exec app sh -c "php artisan db:seed"

# Run the tests
docker compose exec app sh -c "php artisan test"
```

### Module Structure~~

The only required file in a module is a `routes.php` (as demonstrated in [./src/modules/Demo/routes.php](./src/modules/Demo/routes.php)). Controllers must be based on `Illuminate\Routing\Controller` and namespaces must be correct, per Laravel's conventions.

## Your Task

Implement a `User` module that meets the functional requirements, and cover your logic in relevant automated tests. Fork this repository, implement your solution and replace this README file with instructions for running your application.

## Instructions

1. Containerize the application with a Dockerfile in the `./src` directory. Note: There are bonus points for readability, slim container image size, multi-stage build, etc.
2. Add a `compose.yml` in the repository root with an `app` service (being the Laravel app) and a `mysql` service which the Laravel app must connect to for persistence.
3. Place your `User` module in `./src/modules`. Note: There are bonus points for binding the `User` module directory as a read-only volume in the `compose.yml` file.

> See [./docs](./docs) for the fields required in persisted user states and returned payloads.

## Functional Requirements

1. Running `docker compose up` in the repository/solution root should run and expose the app to the host machine on port `59000`. No other port should be exposed to the host machine.
2. `GET /users` should either return a JSON of all users or a view that lists the users. Both are acceptable, as long as the list the current and expected data when refreshed. 
3. `POST /users/disable/{userId}` where `userId` is an integer should disable the user's account and return the new state of the user account in JSON format.
4. `POST /users/enable/{userId}` where `userId` is an integer should enable the user's account and return the new state of the user account in JSON format.
5. The state of the user accounts should persist across app restarts.

## Constraints

1. Do not add any routes to the host app. All required routes must be provisioned in the module.
2. Do not reference ANY classes or artifacts in a module from the host app. The app is configured to dynamically load classes and controllers from modules and the routes in their `routes.php`.
