<?php

/**
 *  This is a Migration file for user table
 *
 * @name       CreateUsersTable
 * @category   Migration
 * @package    User
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 172ac9319ea57c6ece07fd0ceccd34de3f243b54 $
 * @link       None
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * This is a Migration class for user table
 *
 * @name CreateUsersTable
 * @category Migration
 * @package User
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', [
                0,
                1
            ])->default(1);
	     $table->enum('type', [
                0,
                1
            ])->default(0);
			$table->enum('is_admin', [
                0,
                1
            ])->default(0);
			$table->enum('is_online', [
                0,
                1
            ])->default(0);	
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
