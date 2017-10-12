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

class RegisterUser extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'transactions';

      

    /**
     * Get list of packages based on selected Gedcam file
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    static function saveUserDetails($user_id, $package_id,$date, $amount, $transaction_id, $status, $transaction_response, $payment_type)
    {
        $userDetails = new self();
        $userDetails->user_id = $user_id;
        $userDetails->package_id = $package_id;
        $userDetails->transaction_date = $date;
        $userDetails->amount = $amount;
        $userDetails->transaction_id = $transaction_id;
        $userDetails->status = $status;
        $userDetails->transaction_response = $transaction_response;
       $userDetails->payment_type =  $payment_type;
        $userDetails->save();
        return back();
    }
	
    
}
