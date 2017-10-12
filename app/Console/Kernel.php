<?php

/**
 *  This will register all console commands
 *
 * @name       Kernel.php
 * @category   Commands
 * @package    Console
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * This will register all console commands
 *
 * @name     Kernel
 * @category Commands
 * @package  Console
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\Crud::class,
        Commands\Model::class,
        Commands\CreateBackup::class,
        Commands\SendEmails::class,
        Commands\SendNotifications::class,
        Commands\SendSms::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @name   view
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Schedule object
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

}
