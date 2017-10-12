<?php

/**
 *  File Description
 *
 * @name       Table create file
 * @category   Module
 * @package    Activity-Log
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class description
 *
 * @category Module
 * @package  Activity-Log
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://google.com
 * @name     CreateActivityLogTable
 * @version  Release:<v.1>
 * @link     http://google.com
 */
class CreateActivityLogTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('email_id')->nullable();
            $table->string('controller')->nullable();
            $table->string('module', 72)->nullable();
            $table->string('action', 32)->nullable();
            $table->string('description')->nullable();
            $table->string('ip_address', 64);
            $table->string('user_agent');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activity_log');
    }

}
