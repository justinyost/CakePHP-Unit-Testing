# Loadsys Cake Unit Testing #

## Installation

```
git clone https://github.com/jtyost2/CakePHP-Unit-Testing.git
cd CakePHP-Unit-Testing
vagrant up
vagrant ssh
cd /var/www
composer install
```
If you have trouble with composer prompting for a username/password, you can add a GitHub token following these instructions: https://coderwall.com/p/kz4egw

## Running tests

Make sure you are still inside your VM and at /var/www.

```
Console/cake test app Model/Blog
```

You should now be able to start writing tests.
