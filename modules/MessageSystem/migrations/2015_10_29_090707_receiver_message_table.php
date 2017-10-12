<?php

/**
 *  Description
 *
 * @name       2015_10_29_090707_message_receiver_table
 * @category   Database
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class Table creation
 *
 * @name     CreatePmTable
 * @category Database
 * @package  MessageSystem
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class ReceiverMessageTable extends Migration
{

    /**
     * Making table
     *
     * @name   up
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_receiver', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id');
            $table->integer('receiver_id');
            $table->string('status')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Dropping table
     *
     * @name   down
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message_receiver');
    }

}
