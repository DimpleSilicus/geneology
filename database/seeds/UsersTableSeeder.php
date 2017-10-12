<?php

/**
 *  User seeder file
 *
 * @name       UsersTableSeeder.php
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
 * User seeder class
 *
 * @name UsersTableSeeder.php
 * @category Database
 * @package Package
 * @author Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license Silicus http://www.silicus.com/
 * @version GIT: $Id: cc6f2db6e0a22f780b752d2c7e5a336b9392539b $
 * @link None
 * @filesource
 *
 */
class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@silicus.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'is_admin' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
