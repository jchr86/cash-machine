# Cash Machine

## Requirements

- PHP 7.1.3 or higher.
- and the [usual Symfony application requirements](https://symfony.com/doc/current/reference/requirements.html).

## Installation.

Clone & install composer.

```bash
$ git clone git@github.com:jchr86/cash-machine.git
$ cd cash-machine
$ composer install
```

Configure & create DB.

```bash
$ echo "DATABASE_URL=mysql://root:root@127.0.0.1:3306/cash_machine" > .env.local
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
```

Create super admin

```bash
$ php bin/console fos:user:create admin admin@jchr.name admin --super-admin
```

Start server

```bash
$ symfony server:start --no-tls
```

## Admin

http://127.0.0.1:8000/admin/

> User: admin
> 
> Password: admin

1. Create a client.

2. Create an account.

## Front.

- Log in with the created account.
  
  - Card number.
  
  - PIN

- Add movements.
