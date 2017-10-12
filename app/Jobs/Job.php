<?php

/**
 *  This is a base Job file provided by Laravel
 *
 * @name       Job
 * @category   Job
 * @package    Job
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;

/**
 * This is a base Job Class provided by Laravel
 *
 * @name     Job
 * @category Job
 * @package  Job
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
abstract class Job
{
    /*
      |--------------------------------------------------------------------------
      | Queueable Jobs
      |--------------------------------------------------------------------------
      |
      | This job base class provides a central location to place any logic that
      | is shared across all of your jobs. The trait included with the class
      | provides access to the "onQueue" and "delay" queue helper methods.
      |
     */

use Queueable;
}
