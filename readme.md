## Bet API

### Dependencies
* PHP 7.3
* [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)

### Installation
* Clone repository `git clone git@github.com:GvidasR/bet-api.git`
* Setup database connection in `env.local` file `DATABASE_URL=mysql://<db_user>:<db_password>@<db_host>:<db_port>/<db_name>`
* Install composer dependencies `composer install`
* Create database `php bin/console doctrine:database:create --if-not-exists`
* Migrate doctrine migrations `php bin/console doctrine:migrations:migrate`
* Clear cache `php bin/console cache:clear`
* Start local server `php bin/console server:start` _(optional)_
