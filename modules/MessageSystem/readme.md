MessageSystem
===========

A simple and clean Laravel 5.2 Message system is used for send message to another user.**

# Table of Contents
* [Team Members](#team-members)
* [Requirements](#requirements)
* [Getting Started](#getting-started)
* [Documentation](#documentation)

# <a name="team-members"></a>Team Members

* Vivek Bansal (vivek.bansal@silicus.com)

# <a name="requirements"></a>Requirements

* This package requires following things
* PHP 5.5+
* MySQL 5.5+
* Laravel 5.2
* MySQL 5.5+
* Laravel 5.2 scaffold Authentication using php artisan make:auth command.

# <a name="getting-started"></a>Getting Started

To install MessageSystem, make sure "modules/MessageSystem" has been added to Laravel 5's `composer.json` file.

	"psr-4": {
            "Modules\\MessageSystem\\": "modules/MessageSystem/src/"
        }

Then run `php composer update` from the command line. Composer will install the MessageSystem package. Now, all you have to do is register the
service provider . In `config/app.php`, add this to the `providers` array:

	Modules\MessageSystem\MessageServiceProvider::class

**Publishing migrations and configuration:**

To publish this package's configuration and migrations, run this from the command line:

	php artisan vendor:publish

> **Note:** Migrations are only published; remember to run them when ready.

To run migration to create Messages, store css,js files run this from the command line:

	php artisan migrate

# <a name="documentation"></a>Documentation

1- Message system is used for sending and receiving message between logged in users.
2- When we want to send message there is drop down for users list.
3- we can select users from drop down and send them message.
4- User can reply/forward message.