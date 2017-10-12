<?php
/**
 * UserNetwork class to add / edit / delete UserNetwork
 *
 * @name       UserNetwork.php
 * @category   UserNetwork
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ContactUs extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'contact_us';

      

    /**
     * Get list of packages based on selected Gedcam file
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function SaveContactDetail($ContactDetails)
    {
        self::insert($ContactDetails);
        return back();
    }
	
    
}
