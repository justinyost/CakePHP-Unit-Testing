# [CakePHP Unit Testing](http://github.com/jtyost2/CakePHP-Unit-Testing)

Sample Unit Testing Application


## Environment

These items should be installed and available before cloning the project repo.

* [CakePHP](https://github.com/cakephp/cakephp/tree/2.4.5) v2.4.5+
* PHP v5.4+
	* PDO + MySQL
* MySQL v5+


### Development

Noted that all development (and production) dependencies are already available inside the vagrant VM (as provisioned by puhphet). There are no "optional" installs. Developers must be able to run tests, generate phpDocs and run phpcs locally before committing.

* vagrant (If you have this, you can ignore the rest of this since it is all in the VM.)
* xdebug 2+
* phpunit 3.7+
* nodejs + npm (for auto-running tests)
* phpDocumentor
* PHP Code Sniffer


### Included Libaries and Submodules

Libraries should be included with Composer whenever possible. Git submodules should be used as a fallback, and directly bundling the code into the project repo as a last resort.

* [DebugKit](https://github.com/cakephp/debug_kit/tree/2.0) v2.0
* [CakeDC Migrations](https://github.com/cakedc/migrations)
* [Loadsys Cake Shell Scripts](https://github.com/loadsys/CakePHP-Shell-Scripts)


## Installation

No installation steps as this should never be deployed as a real application.


### Development (vagrant)

Developers are expected to use the vagrant environment for all local work. Using a \_AMP stack on your machine directly is no longer advised or supported.

```bash
git clone git@github.com:jtyost2/CakePHP-Unit-Testing.git ./
vagrant up
vagrant ssh
cd /var/www
bin/deps-install
bin/run-migrations
```

The bootstrap file takes care of installing dependencies. After this process, the project should be available at http://localhost:8080/.


### Writeable Directories

Writeable directories are managed by `Config/writedirs.txt`, and they can be set by running `bin/writedirs`.



## Contributing

This is a sample app for demonstrating Unit Testing Principles. Anything done should improve the basics of testing a
CakePHP application.

### After Pulling

Things to do after pulling updates from the remote repo.

On your host:

* `bin/deps-install` (Install any changes/updated dependencies from git submodules, composer, pear, npm, etc.)
* `vagrant provision` (Make any changes to the VM's config that may be necessary.)

From inside the vagrant VM (via `vagrant ssh`):

* `bin/clear-cache` (Make sure temp files are reset between host/vm use.)
* `bin/migrations` (Set up the DB with the latest schema.)

**@TODO:** These final steps could really be rolled into the vagrant provisioning step.


### Configuration

App configuration is stored in `Config/core.php`. This configuration is then added to (or overwritten by) anything defined in the environment-specific config file, such as `Config/core-vagrant.php` or `Config/core-staging.php`.

Database configurations for all environments is stored in `Config/database.php` and switched using an environment variable.

The bundled vagrant VM automatically sets `APP_ENV=vagrant` both on the command line (via `vagrant ssh` and in the Apache context.) If you want to work with the project on your machine locally, you need to `export APP_ENV=dev` (or whatever environment you want to match for `core-*.php` and in `database.php`) before running `bin/cake`.


### Database Changes

Because the MySQL DB runs inside of the vagrant VM, you must connect to it via SSH. The easiest way to do this is using [Sequel Pro](http://sequelpro.com/).

Create a new "SSH" connection with the following settings:

* Name: vagrant@vagrant
* MySQL Host: 127.0.0.1 (This is the MySQL server's address after you've SSHed into the vagrant box.)
* Username: vagrant
* Password: vagrant (as defined in `Lib/puphpet/config.yaml`.)
* Database: vagrant (again per `Lib/puphpet/config.yaml`.)
* Port: 3306
* SSH Host: 127.0.0.1
* SSH User: vagrant
* SSH Password: vagrant (Or [some guys online](https://coderwall.com/p/yzwqvg) say you can point to your local `~/.vagrant.d/insecureprivatekey`.)
* SSH Port: 2222 (per `Lib/puphpet/config.yaml`.)

This setup is handy for backing up your data if you're about to destroy the box, or for making Schema or Seed changes before running the Shell commands in the VM.

#### Schema Migrations

* The database schema is maintained using the CakeDC Mgrations plugin.
* Once you have made changes to your development database using the process above, run `bin/cake Migrations.migration generate -f` **from inside the vagrant box** (via `vagrant ssh`).
* When prompted to update `schema.php`, choose **yes** and then choose **overwrite**.
* Then review and commit the changes to `Config/schema.php` and the new file from `Config/Migration/`.


## Testing

Unit tests should be created for all new code written in the following categories:

* Model methods
* Behaviors
* Controller actions
* AppController methods
* Components
* Helper methods
* Shells and Tasks
* Libraries in `Lib/'

Testing can be done through the browser like normal (by visiting http://localhost:8080/test.php).

Also there is a script that runs the tests

```bash
vagrant ssh
cd /var/www
bin/run-tests
```

Command line automated test running is also possible with Grunt, which is already installed in the vagrant box.

```bash
vagrant ssh
cd /var/www
grunt watch
```

This will block the terminal while it waits for file changes. New files should get picked up as well.


## License

Copyright (c) 2014 Justin Yost