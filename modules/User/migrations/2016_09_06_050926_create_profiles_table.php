<?php

/**
 *  Migration for Profiles table
 *
 * @name       CreateProfilesTable.php
 * @category   Migration
 * @package    Migration
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration for Profiles table
 *
 * @name     CreateProfilesTable
 * @category Migration
 * @package  Migration
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class CreateProfilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @name   up
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gender', 10)->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('position', 50)->nullable();
            $table->string('company', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('address', 1000)->nullable();
            $table->string('facebook', 1000)->nullable();
            $table->string('twitter', 1000)->nullable();
            $table->string('google', 1000)->nullable();
            $table->string('about_me', 2000)->nullable();
            $table->string('biography', 2000)->nullable();
            $table->string('avatar', 100)->nullable();
            $table->integer('news_letters')->nullable()->default(0);
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @name   down
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }

}
