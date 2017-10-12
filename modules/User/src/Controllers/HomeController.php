<?php

/**
 *  This file handle user profile as well as change password functionality
 *
 * @name       UserController.php
 * @category   User
 * @package    Controller
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: da75e564ffb4f7fd67bad71778009e8c02067ce9 $
 * @link       None
 * @filesource
 */
namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use mikehaertl\wkhtmlto\Pdf;
use Modules\ToolKit\PDFTemplates;

use Modules\User\Model\ContactUs;
/**
 * This class handle user profile as well as change password functionality
 *
 * @name UserController
 * @category Controller
 * @package User
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		
		/* signature code start */
        $jsFiles[] = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js';
        $jsFiles[] = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/jquery.signature.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/assets/html2canvas.js';
        $cssFiles[] = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/south-street/jquery-ui.css';
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/css/jquery.signature.css';
        /* signature code end */
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/user.js';
        $jsFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/moment.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/fileinput.min.js';
        
        $cssFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css';
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/css/fileinput.min.css';
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/css/profile.css';
        
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        parent::__construct();
    }

    /**
     * User can view and chnage his/her profile details
     *
     * @name showProfileForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
	 
    public function aboutGNH()
    {
		return view('user::about-gnh');     
    }
	
	public function familyHistory()
	{
		return view('user::family-history');   	
	}
	
	public function aboutAplication()
	{
		return view('user::about-app');   	
	}
	
	public function aboutService()
	{
		return view('user::about-service');   	
	}

	public function contactUs()
	{
		return view('user::contact-us');   	
	}	
        
        //for coming Soon Page.
        public function ComingSoon()
	{
		return view('user::coming-soon');   	
	}
	
    /**
     * show forgot password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        $metadata = ['title' => 'Forgot Password', 'description' => 'Forgot Password', 'keywords' => 'Forgot Password'];
        $this->addMetadata($metadata);

        return view('Admin::auth.passwords.email');
    }
    
    /**
     * To submit contact details to contact table and send mail.
     *
     * @name showProfileForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function SubmitContactUs(Request $request)
    {
        $this->validate($request,[
            'ContactFName' => 'required',
            'ContactLName' => 'required',
            'ContactEmail' => 'required|email',
            'ContactNo' => 'required|numeric',
            'ContactMsg'=>'required'
            ], [                    
                    'ContactFName.required' => 'First Name is required.',                    
                    'ContactLName.required' => 'Last Name is required.',
                    'ContactEmail.required' => 'Email ID is required.',
                    'ContactEmail.email' => 'The Email must be a valid email address.',
                    'ContactNo.required' => 'Contact Number is required.',
                    'ContactMsg.required' => 'Contact Message is required.',
        ]);
        
        $ContactDetails =array(
                    'name' => $request['ContactFName'],
                    'lname' => $request['ContactLName'],
                    'email' => $request['ContactEmail'],
                    'phoneno' => $request['ContactNo'],
                    'message' => $request['ContactMsg'],
        );
//        $EmailId=$request['ContactEmail'];
//        $EmailId = $EmailId;
//               
//        $body = "Details of User<br>"
//                . "Name of User: ".$request['ContactFName']." ".$request['ContactLName']
//                ."<br>Email Id: ".$EmailId
//                ."<br>Contact No: ".$request['ContactNo']
//                ."<br>Message : ".$request['ContactMsg'];
//
//        $mailArr = [
//            'body' => $body
//        ];
//
//        \Mail::send(Config::get('app.theme') . '.emails.registration', $mailArr, function ($m) use ($EmailId,$body) {
//            $m->from($EmailId);
//            $m->to("samtg@genealogynetworkhub.com");
////                $m->to("dimple.agarwal@silicus.com");
//            $m->subject("Registration confirmation.");
//            $m->setBody($body,'text/html');
//        });
            
        $Returnvalue=ContactUs::SaveContactDetail($ContactDetails);
        if ($Returnvalue) {
            return redirect('/page/contact-us')->with('success', 'Your message is sent successfully.');
        }
        

    }
}
