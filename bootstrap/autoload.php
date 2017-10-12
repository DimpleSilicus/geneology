<?php

/**
 *  This is a base autoload file provided by Laravel
 *
 * @name       Autoload
 * @category   Autoload
 * @package    Autoload
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
define('LARAVEL_START', microtime(true));

/*
  |--------------------------------------------------------------------------
  | Register The Composer Auto Loader
  |--------------------------------------------------------------------------
  |
  | Composer provides a convenient, automatically generated class loader
  | for our application. We just need to utilize it! We'll require it
  | into the script here so that we do not have to worry about the
  | loading of any our classes "manually". Feels great to relax.
  |
 */

require __DIR__ . '/../vendor/autoload.php';

/*
  |--------------------------------------------------------------------------
  | Include The Compiled Class File
  |--------------------------------------------------------------------------
  |
  | To dramatically increase your application's performance, you may use a
  | compiled class file which contains all of the classes commonly used
  | by a request. The Artisan "optimize" is used to create this file.
  |
 */

$compiledPath = __DIR__ . '/cache/compiled.php';

if (file_exists($compiledPath)) {
    include $compiledPath;
}
