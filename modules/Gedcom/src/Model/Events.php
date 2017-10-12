<?php
/**
 * Members class to add / edit / delete Members
 *
 * @name       Events.php
 * @category   Events
 * @package    Events
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\Gedcom\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Events extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'events';

    public $timestamps = false;

    /**
     * Function to get all active events
     *
     * @name getAllActiveEvents
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getAllActiveEvents()
    {
        $arrEvents = self::select('id', 'name')->where('status', '=', '0')
            ->get()
            ->toArray();
        
        return $arrEvents;
    }
}
