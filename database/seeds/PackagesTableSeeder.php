<?php

/**
 *  User seeder file
 *
 * @name       PackagesTableSeeder.php
 * @category   Database
 * @package    Package
 * @author     Dimple Agarwal<dimple.agarwal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: cc6f2db6e0a22f780b752d2c7e5a336b9392539b $
 * @link       None
 * @filesource
 */
use Illuminate\Database\Seeder;

/**
 * User seeder class
 *
 * @name PackagesTableSeeder.php
 * @category Database
 * @package Package
 * @author Dimple Agarwal<dimple.agarwal@silicus.com>
 * @license Silicus http://www.silicus.com/
 * @version GIT: $Id: cc6f2db6e0a22f780b752d2c7e5a336b9392539b $
 * @link None
 * @filesource
 *
 */
class PackagesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('packages')->insert([[
            'name' => 'gedcom1',
            'description' => 'first gedcom package',
            'status' => '1',
            'amount' => '5',
            'gedcom' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'name' => 'gedcom2',
            'description' => 'second gedcom package',
            'status' => '1',
            'amount' => '10',
            'gedcom' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
        
        //`packages`(`name`, `description`, `status`, `amount`, `gedcom`, `created_at`, `updated_at`
    }
}
