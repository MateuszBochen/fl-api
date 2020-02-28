## DDD CQRS ES Boilerplate for Symfony

A Boilerplate that uses Domain Driven Design, Command Query Responsibility Segregation and
Event Sourcing for symfony.

## How to install

```bash
composer install
```


Run migration when all container are ready

```bash
php bin/console doctrine:migrations:migrate
```

Now you can access the site using http://your-vhost/

You can access the api doc using http://your-vhost/api/doc
