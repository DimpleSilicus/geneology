<?php

/**
 *  Model file for activitylog module
 *
 * @name       Activitylog.php
 * @category   Model
 * @package    Activity-Log
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ActivityLog\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\BaseModel;
use File;
use Auth;
use Carbon\Carbon;

/**
 * Activitylog model for database access.
 *
 * @category Model
 * @package  Activity-Log
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://google.com
 * @name     Activitylog
 * @version  Release:<v.1>
 * @link     http://google.com
 */
class ActivityLog extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * Insert logs into file or database
     *
     * @name   insertLog
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $dataLog It is an array to insert data
     *
     * @return void
     */
    static function insertLog($dataLog)
    {
        $userId      = Auth::user()->id;
        $userEmail   = Auth::user()->email;
        $controller  = $dataLog['controller'];
        $action      = $dataLog['action'];
        $module      = $dataLog['module'];
        $description = $dataLog['description'];
        $ipAddress   = Request::getClientIp();
        $userAgent   = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'No User Agent';
        $environment = config('app.env');

        $storeActivity = config('app.storeActivity');
        if ($storeActivity == 'database') {
            activitylog::insert(['user_id' => $userId, 'email_id' => $userEmail, 'controller' => $controller, 'module' => $module, 'action' => $action, 'description' => $description, 'ip_address' => $ipAddress, 'user_agent' => $userAgent, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
            $filename = storage_path() . '/logs/activity/activity_' . date('Y-m-d') . '.log';
            $msg      = '[' . date('Y-m-d H:i:s') . ']' . ' |' . $environment . '| |' . $ipAddress . '| |' . $userId . '| |' . $userEmail . '| |' . $controller . '| |' . $module . '| |' . $action . '| |' . $userAgent . '| |' . $description . "\n";
            File::append($filename, $msg);
        }
    }

    /**
     * Getting all activitylog using ajax
     *
     * @name   getAllActivityLog
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $filter filter data using parameters
     *
     * @return void
     */
    static function getAllActivityLog($filter)
    {
        $query = self::select('user_id', 'email_id', 'controller', 'module', 'description', 'action', 'ip_address', 'created_at')
                ->where('created_at', '>=', Carbon::today()->subDays($filter['duration']));

        if ($filter['search']) {
            $query->where('email_id', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('controller', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('module', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('description', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('action', 'like', '%' . $filter['search'] . '%');
        }

        $query->offset($filter['start']);
        $query->limit($filter['length']);
        $query->orderBy($filter['sortBy'], $filter['sortOrder']);

        $result = $query->get();

        return $result;
    }

    /**
     * Getting Activities Count
     *
     * @name   getActivitiesCount
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $filter filter data using parameters
     *
     * @return void
     */
    static function getActivitiesCount($filter)
    {
        if ($filter['search']) {
            $query  = self::where('created_at', '>=', Carbon::today()->subDays($filter['duration']));
            $query->where('email_id', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('controller', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('module', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('description', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('action', 'like', '%' . $filter['search'] . '%');
            $result = $query->count();
        } else {
            $result = self::where('created_at', '>=', Carbon::today()->subDays($filter['duration']))->count();
        }
        return $result;
    }

}
