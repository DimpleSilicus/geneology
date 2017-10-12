<?php

/**
 * Backup class to set application meta data.
 *
 * @name       CreateBackup.php
 * @category   ToolKit
 * @package    CreateBackup
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\ToolKit\Backup;

/**
 * Backup class to set application meta data.
 *
 * @name       CreateBackup.php
 * @category   ToolKit
 * @package    CreateBackup
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
class CreateBackup extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:backup {backupType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This command will check which type of backup it should take
     * e.g php artisan create:backup folder
     * e.g php artisan create:backup database
     * e.g php artisan create:backup incrementalFolder
     * e.g php artisan create:backup incrementalDB
     *
     * @name   handle
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     * @return mixed
     */
    public function handle()
    {
        $option = $this->argument('backupType');
        $backup = new Backup;
        switch ($option) {
            case "folder":
                $backup->getFolderBackup();
                break;
            case "database":
                $backup->getDatabaseBackup();
                break;
            case "incrementalFolder":
                $backup->getIncrementalBackupFolder();
                break;
            case "incrementalDB":
                $backup->getIncrementalBackupDB();
                break;
            default:
                $backup->getDatabaseBackup();
        }
    }

}
