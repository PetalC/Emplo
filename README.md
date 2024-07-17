# EMPLO

This repository is created based on TALL stack - Tailwind CSS & Alpine.js & Livewire & Laravel

## Working in This Repo

1. Clone this repo.
2. Copy .env.example to .env
3. Change any esttings as required e.g. database, mail service, etc
4. Run `php atisan key:generate`.
5. Run `composer install` and `npm install && npm run dev`.
6. Once you get assigned new issue, please create a new branch with naming convention(e.g: issue name => [EMPLO/UI] xxxxx and issue number => 1, then please create a new branch like this - EMPLO-1-xxxxx)
7. If you want to raise a new issue, please keep this naming convention - [EMPLO/UI(or Backend or whatever)] xxxxxx

## Automation (Highly preferred to run this command before you push any commits.)

1. Run `composer lint` to fix code style for minimalists.
2. Run `composer stan` to find bugs automatically without tests.

### Local Dev Environment
Docker compose is used for running the app locally. Laravel also ships a convenience tool to make it super easy called Sail
```
# spin up containers
./vendor/bin/sail up -d
# run migrations if necessary
./vendor/bin/sail artisan migrate
# build assets
./vendor/bin/sail npm run dev
```

### Integration Testing
If you want to run integration tests you just need to:
1. Setup a testing db
   ```bash
mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
CREATE DATABASE IF NOT EXISTS testing;
GRANT ALL PRIVILEGES ON \`testing%\`.* TO '$MYSQL_USER'@'%';
EOSQL
   ```
2. Run migrations on your testing db
   ```bash
   artisan migrate:fresh --env=testing
   ```
3. Run your tests
   ```bash
   artisan test
   ```

(If you want to talk more about testing generally or TDD contact Nate <nathaniel.rogers@humanpixel.com.au- Peace)
