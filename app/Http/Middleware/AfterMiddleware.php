<?php

/**
 * This middleware run after compleation of all other middleware.
 *
 * @name       AfterMiddleware
 * @category   Middleware
 * @package    Middleware
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: ccf39425f6276d99a30df67ac044632bfc260f26 $
 * @link       None
 * @filesource
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

/**
 * This middleware run after compleation of all other middleware.
 *
 * @name     AfterMiddleware
 * @category Middleware
 * @package  Middleware
 * @author   Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  Release:<v.1>
 * @link     None
 */
class AfterMiddleware
{

    /**
     * This is a default laravel handler
     *
     * @name   handle
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $request Page request
     * @param string $next    Page next action
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (\Config::get('app.queryLog') == true) {

            $queries['db1'] = DB::connection('mysql')->getQueryLog();

            $logData = '';
            foreach ($queries as $database => $cmsQueries) {
                for ($i = 0; $i < count($cmsQueries); $i++) {
                    $query = $cmsQueries[$i]['query'] . '';
                    $time  = date('Y-m-d H:i:s', time());
                    //loop through all bindings
                    for ($j = 0; $j < sizeof($cmsQueries[$i]['bindings']); $j++) {

                        $cmsQueries[$i]['bindings'][$j] = $cmsQueries[$i]['bindings'][$j] == '' ? "''" : $cmsQueries[$i]['bindings'][$j];
                        $query                          = $this->_strReplaceFirst('?', $cmsQueries[$i]['bindings'][$j], $query);
                    }
                    $query  = trim(preg_replace("/\r\n|\n/", "", $query));
                    $newArr = array (date('Y-m-d H:i:s', time()), $database . ' : ' . $query);
                    $logData .= implode("\t", $newArr) . "\n";
                }
            }
            if ($logData != '') {
                $logFile = fopen(storage_path('logs/queries/' . date('Y-m-d') . '_query.log'), 'a+');
                fwrite($logFile, $logData);
                fclose($logFile);
            }
        }
        return $response;
    }

    /**
     * Replace subject with given word
     *
     * @name   _strReplaceFirst
     * @access public
     * @author Ajay Bhosale <ajay.bhosalesilicus.com>
     *
     * @param string $from    Data that has to be replace
     * @param string $to      Data which want to be replace
     * @param string $subject Message
     *
     * @return void
     */
    private function _strReplaceFirst($from, $to, $subject)
    {
        $from = '/' . preg_quote($from, '/') . '/';
        return preg_replace($from, $to, $subject, 1);
    }

}
