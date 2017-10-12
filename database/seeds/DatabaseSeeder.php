<?php

/**
 *  Laravel database seeder file
 *
 * @name       DatabaseSeeder.php
 * @category   Database
 * @package    Package
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: cc6f2db6e0a22f780b752d2c7e5a336b9392539b $
 * @link       None
 * @filesource
 */
use Illuminate\Database\Seeder;

/**
 * Laravel database seeder class
 *
 * @name DatabaseSeeder
 * @category Database
 * @package DatabaseSeeder
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @name run
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(PackagesTableSeeder::class);
    }
}
