<?php

/**
 *  Application configuration file
 *
 * @name       BackupConfig.php
 * @category   Configuration
 * @package    Configuration
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
return [
    /*
      |--------------------------------------------------------------------------
      | Application Folder backup status
      |--------------------------------------------------------------------------
      |
      | This value determines the status of the plugin which type of
     *  backup will be initiated i.e FOLDER_BACKUP = true or false.
      |
     */
    'FOLDER_BACKUP' => 'false', // true or false

    /*
      |--------------------------------------------------------------------------
      | Application Folder backup status
      |--------------------------------------------------------------------------
      |
      | This value determines the status of the plugin which type of
     *  backup will be initiated i.e DB_BACKUP = true or false.
      |
     */
    'DB_BACKUP'           => 'false', // true or false
    /*
      |--------------------------------------------------------------------------
      | Application Source file or folders path
      |--------------------------------------------------------------------------
      |
      | This value determines the source path of the file or folders
     *  to which it creates a zip file.
      |
     */
    'SOURCE'              => env('SOURCE'), // source folder name
    /*
      |--------------------------------------------------------------------------
      | Application Destination file or folders path
      |--------------------------------------------------------------------------
      |
      | This value determines the destination path of the file or folders
     *  to which it stores the created a zip file.
      |
     */
    'DESTINATION'         => env('DESTINATION'), // destination folder name to store
    /*
      |--------------------------------------------------------------------------
      | Application Settings Trough Commandline or Code For Folder
      |--------------------------------------------------------------------------
      |
      | This value determines wheter the backup will use commands or
     *  through the code.
      |
     */
    'THROUGH_EXEC_FOLDER' => false, // true or false
    /*
      |--------------------------------------------------------------------------
      | Application Settings Trough Commandline or Code For Database
      |--------------------------------------------------------------------------
      |
      | This value determines wheter the backup will use commands or
     *  through the code.
      |
     */
    'THROUGH_EXEC_DB'     => false, // true or false
    /*
      |--------------------------------------------------------------------------
      | Application Incremental Backup Settings
      |--------------------------------------------------------------------------
      |
      | This value determines wheter the backup will be of incremental or
     *  a regular file or folder backup
      |
     */
    'INCREMENTAL_BACKUP'  => false, // true or false
    /*
      |--------------------------------------------------------------------------
      | MySql Path on windows machine
      |--------------------------------------------------------------------------
      |
      | This value determines wheter the backup will be of incremental or
     *  a regular file or folder backup
      |
     */
    'MYSQL_PATH'          => env('MYSQL_PATH'),
    /*
      |--------------------------------------------------------------------------
      | Application Database List
      |--------------------------------------------------------------------------
      |
      | This value determines the Database listing of which it should take
     *  backup
      |
     */
    'DATABASES'           => ['mysql']
];
