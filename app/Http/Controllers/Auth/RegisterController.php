<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
//use App\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\StudentDetail;
use App\LastEnrollment;
use App\Timeslot;
use App\Slot;
use App\Usertimeslot;
use App\StudentTransaction;
use App\PayuResponseTransaction;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
	
	//use Session;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/loginin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|regex:/^[a-z\sA-Z]+$/u|max:255',
			'schoolName' => 'required|regex:/^[a-z\sA-Z]+$/u|max:255',
			'dob' => 'required|date_format:m/d/Y',
			'city' => 'required|regex:/^[a-z\sA-Z]+$/u|max:30',
			'state' => 'required|regex:/^[a-z\sA-Z]+$/u|max:30',
			'pincode' => 'required|regex:/^[0-9]{6}$/u|max:6',
			'email' => 'required|string|email|max:255|unique:users',
            'password'=> array ('required','regex:/^\S*(?=\S{6,14})(?=\S*[a-z])(?=\S*[!@#$%^&])(?=\S*[A-Z])(?=\S*[\d])\S*$/'),
			'password_confirmation' => 'same:password',
			'altcontactnum' => 'nullable|regex:/^[0-9]{10}+$/u|max:10',
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {       
		$otp=$this->generateOTP();
			if($otp=="") {
				return redirect('/register')->with('registermessage', 'There is some error in generating OTP, please try after some time.');
			}
			$dobFormatted = \DateTime::createFromFormat('m/d/Y', $data['dob']);
			/* Redirect to register page with validation/format problem */
			if($dobFormatted === false) {
				return redirect('/register')->with('registermessage', 'There is some error in checking the date of birth format, please re-check and submit the form.');
			}

			$userdetail= User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'password' => bcrypt($data['password']),
				'username' => $data['email'],
				'mobilenumber' => $data['mobilenumber'],
				'otp' => $otp,
				'currlevel'=>1
			]);
            //generate enrollment id
            $enrollmentid= $this->generateEnrollmentId();
           // echo $enrollmentid; die;
           $userdata['user_id']=$userdetail->id;
           $userdata['registeredfor']=$data['registeredfor'];
           $userdata['enrollmentid']=$enrollmentid;
           if($data['registeredfor']=='scholarship')
           {				
			   $dob = $dobFormatted->format('Y-m-d');
               $userdata['prefer_location']=$data['prefer_location'];
               $userdata['schoolName']=$data['schoolName'];
               $userdata['dob']=$dob ;
               $userdata['current_class']=$data['current_class'];            
               $userdata['genaddressder']=$data['genaddressder'];
               $userdata['city']=$data['city'];
               $userdata['state']=$data['state'];
               $userdata['pincode']=$data['pincode'];
               $userdata['altermobilenumber']=$data['altcontactnum'];
               $userdata['gender']=$data['gender'];
           }
           StudentDetail::create($userdata);
			if($data['registeredfor']=='scholarship')
			{
				$userslot['slotid']=$data['exampreferslot'];
				$userslot['userid']=$userdetail->id;
				Usertimeslot::create($userslot);
            }
            //send otp code
			$this->sendOTPCodeOnMobile($data['mobilenumber'], $otp);
            return $userdetail;
        
    }    

    public function enrollemnt()
    {
        $this->generateEnrollmentId();
    }
    protected function generateEnrollmentId()
    {
        $year = ( date('m') > 4) ? date('Y') + 1 : date('Y');
        $prevyear=   $year-1; 
        $curryear=substr($year, -2);
        $prevyear = substr($prevyear, -2);        
        
       $lastenrollmentidobj= LastEnrollment::first();
       if(isset($lastenrollmentidobj))
       {        
        $lastenrollmentid=$lastenrollmentidobj->enrollment_id;
        $lastenrollmentid=$lastenrollmentid+1;
        if($lastenrollmentidobj->currentyear != $year)
        {
            $lastenrollmentid=1;
            LastEnrollment::where('id',$lastenrollmentidobj->id)->update(['enrollment_id'=>$lastenrollmentid,'currentyear'=>$year]);
        }
        else
        {
            LastEnrollment::where('id',$lastenrollmentidobj->id)->update(['enrollment_id'=>$lastenrollmentid]);
        }
        
       }
       else
       {
        $lastenrollmentid=1;
        LastEnrollment::create(['enrollment_id'=>$lastenrollmentid,'currentyear'=>$year]);
       }
      $finalenrollmentid=$prevyear.$curryear.'OL'.str_pad($lastenrollmentid, 3, "0", STR_PAD_LEFT);         
       return $finalenrollmentid;
       
    }

	protected function verification(Request $request)
	{		
		$data = Session::get('userdetail');
		$userdata=User::select('otp')->where('username',$data['username'])->first();
		if($request['otp'] == $userdata->otp)
		{
			User::where('username',$data['username'])->update(['isverified'=>1]);
            $userdata=User::where('username',$data['username'])->first();
            $studentDetail=StudentDetail::where('user_id', $userdata->id)->first();  
            if($studentDetail->registeredfor =='scholarship') 
            {
                $userTimeSlotDetail=Usertimeslot::where('userid', $userdata->id)->first();
                $slotId = $userTimeSlotDetail->slotid;
                $slotDetails=Slot::where('id', $slotId)->first();
                $timeslotDetails=Timeslot::where('id', $slotDetails->timeslotid)->first();
                $isExamInRohtak=true;
			    if($studentDetail['prefer_location']!="rohtak")
			        $isExamInRohtak=false;
            $name=$userdata->name;
            $mobilenumber=$userdata->mobilenumber;
            $email=$userdata->email;            
            $date=$timeslotDetails->slotdate;
            $batch=$this->getBatchTimingsView($date, $slotDetails->fromtime, $slotDetails->totime);
            $this->sendRegistrationMessages($name, $mobilenumber, $email, $date, $batch, $isExamInRohtak,$studentDetail->enrollmentid) ;
            }      
			
			//Auth()->loginUsingId($userdata->id) ;
			
            //return redirect('/loginin');
            $txnid=$this->getTrxnId($name);
        
    		$data=array(
    		    'user_id' => $userdata->id,
    		    'enrollmentid' => $studentDetail->enrollmentid,
    		    'phone' => $mobilenumber,
    		    'email' => $email,
    		    'txnid' => $txnid,
    		    
    		    );
            // TODO: Create the transaction, once the student clicks on Pay button
            StudentTransaction::create($data);
            $encrypted = Crypt::encrypt($txnid);
    		return redirect("/payment/$encrypted");
    		
            //return redirect('/landing-page');
		}
		else
		{
			return redirect('/login')->with('verificationmessage', 'Invalid OTP Please send it once again');
		}
	}
	
	protected function getBatchTimingsView($date, $fromTime, $toTime){
	    
	    $fromDateTime = "$date $fromTime";
	    $fromFormat='Y-m-d G:i:s';
	    $toFormat='h:ia';
	    $formattedFromTime = \DateTime::createFromFormat($fromFormat, $fromDateTime)->format($toFormat);

        $toDateTime = "$date $toTime";
        $formattedToTime = \DateTime::createFromFormat($fromFormat, $toDateTime)->format($toFormat);
            //dd("$formattedFromTime-$formattedToTime");
        return "$formattedFromTime-$formattedToTime";
	}
	
	protected function verifyUser()
	{	
		
		if (Session::has('userdetail'))
		{
			$userdetail = Session::get('userdetail');
			$usermob=User::select('mobilenumber')->where('username',$userdetail['username'])->first();
			$data['mobilenumber']=$usermob->mobilenumber;
			return view('auth.verification',compact('data'));
			
		}
		else
		{
			return redirect('/login')->with('otpmessage', 'You need to confirm your account. We have sent you an activation code, please check your mobile and click <a href="'.url('/user/verify').'">Here</a>.');
		}	
	}
	
	 protected function registered(Request $request, $user)
    {
		//$data['email']= $user->email;
		$data['username']=$user->username;
        $this->guard()->logout();
		Session::put('userdetail', $data);
        return redirect('/user/verify')->with('verificationmessage', 'We sent you an activation code. please check your mobile.');
    }

	protected function homeAccess()
	{
		return redirect('/loginin');
	}

	protected function updatemobilenumber(Request $request)
	{
		$data=array();
		if (Session::has('userdetail'))
		{
			$data = Session::get('userdetail');
			
		}
		$userdata=User::where('username',$data['username'])->first();
		$otp=$this->generateOTP();	
		//send otp code
		$this->sendOTPCodeOnMobile($userdata->mobilenumber, $otp);
		$userdata=User::where('username',$data['username'])->update(['mobilenumber'=>$request->mobilenumber,'otp'=>$otp]);
		 return redirect('/user/verify')->with('verificationmessage', 'We sent you an activation code. please check your mobile.');
	}		

    protected function generateOTP(){
        $otp = "";
        for($i=0;$i<6;$i++) {
            $otp.=rand(1,9);
        }
            
        return $otp;
    }

    protected function sendOTPCodeOnMobile($mobile, $otp){

        $message="Your OTP is $otp for verification of your account registration.";
        $this->sendSMS($mobile, $message);
    }
	
	public function resendotp(Request $request)
	{
		$data=array();
		if (Session::has('userdetail'))
		{
			$data = Session::get('userdetail');
			
		}
		$userdata=User::where('username',$data['username'])->first();
		$otp=$this->generateOTP();	
		//send otp code
		$this->sendOTPCodeOnMobile($userdata->mobilenumber, $otp);//
		$userdata=User::where('username',$data['username'])->update(['otp'=>$otp]);
		 return redirect('/user/verify')->with('verificationmessage', 'We sent you an activation code. please check your mobile.');
    }
    
	protected function sendSMS($mobile, $message){

		$curl = curl_init();
		$url="http://hissarsms.com/API/SMSHttp.aspx?";
        
		$urlData=array(
            'UserId'=>'info@mindpro.ac.in',
            'pwd'=>'mindpro@123',
            'Message'=>$message,
            'Contacts'=>$mobile,
            'SenderId'=>'MNDPRO',
            'ServiceName'=>'SMSOTP'
        );
        //$mobile
		$url.=http_build_query($urlData);
        
		curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_ENCODING => "",
            //CURLOPT_TIMEOUT => 3000000,
            CURLOPT_CONNECTTIMEOUT => 0,
            //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_FOLLOWLOCATION => true,


        ));
        
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
        //$response = curl_exec($curl);
        //$err = curl_error($curl);
        //curl_close($curl);
         if ($response === false || $err) {
             echo "cURL Error ($url) #:" . $err;
         }
        // } else {
        //     print_r(json_decode($response));
        // }
        //dd($url);
       // dd($response);
    }
	
	protected function sendRegistrationSMS ($name, $mobile, $examdate, $examtime, $isexaminrohtak,$enrollmentId) {
	
		$sms = "Congratulations $name!!!. You have been successfully registered for Admission cum Scholarship Test of MindPro Academy. Exam details will be shared shortly.";
		
		$this->sendSMS($mobile, $sms);
		
		$sms = "$name, your exam is scheduled on $examdate at $examtime. Test-centre is "; 
		
		if($isexaminrohtak) {
			$sms .= "MindPro Academy, Office - A, 1st Floor, above ICICI Bank, Ashoka Plaza, Rohtak.";
		} else {
			$sms .= "MindPro Academy, 2nd Floor, S.C.O. 56-P, Mezbaan Complex, Above Axis Bank, Sector - 13, Hisar.";
		}

		$this->sendSMS($mobile, $sms);
        $sms = "Your enrollment-id is $enrollmentId. In case of any query, contact at ";
		
		if($isexaminrohtak) {
			$sms .= "+91-7404500800, 01262-253800.";
		} else {
			$sms .= "+91-7404500700, 01662-246700.";
		}
		$sms .= "Note: Please reach test centre 30 mins prior of the scheduled exam time with your ID-proof and SMS containing enrollment-id.";
		
		$this->sendSMS($mobile, $sms);

	}

	protected function sendRegistrationEmail($name, $email, $examdate, $examtime, $isexaminrohtak){
	
		//TODO: Send an email
		// Mail::send('emails.register-welcome', ['name' => $name, 
		// 			'examdate' => $examdate, 
		// 			'examtime' => $examtime, 
		// 			'isexaminrohtak' => $isexaminrohtak
		// 			], function ($message)
        // {

        //     $message->from('alerts@mindpro.ac.in', 'Mind Pro Academy');

        //     $message->to($email);

        // });
	}
	
	protected function sendRegistrationMessages($name, $mobile, $email, $examdate, $examtime, $isexaminrohtak,$enrollmentId) {

		$this->sendRegistrationEmail($name, $email, $examdate, $examtime, $isexaminrohtak);
		$this->sendRegistrationSMS($name, $mobile, $examdate, $examtime, $isexaminrohtak,$enrollmentId);
	
	}
	
        public function timeslotlistview($location){
		
		//TODO: Himanshu - 02-Nov-2018
		// Use location value
		
		//$timeslots=Timeslot::where([['prefer_location','=',$location],['status','=', 1]])->get();
		$timeslots=Timeslot::where('prefer_location', $location)->get();
		$i=0;
		$data=[];
		foreach($timeslots as $timeslot)
		{
			$timeslotid = $timeslot->id;
			$slots = $this->getSlotList($timeslotid);
			$numOfSeats=0;
			foreach($slots as $slot) 
				$numOfSeats += $slot["numofseats"];
			if($numOfSeats == 0)
				continue;
			
			$slotDateTime = \DateTime::createFromFormat('Y-m-d', $timeslot->slotdate);
			$todayDateTime = new \DateTime("now");
			$tmrwDateTime = $todayDateTime->add(new \DateInterval('P1D'));
			$interval=$slotDateTime->diff($todayDateTime);
			
			if($tmrwDateTime > $slotDateTime) 
				continue;

			$data[$i]['id']=$timeslotid;
			$data[$i]['date']=$slotDateTime->format('m/d/Y');
			$data[$i]['days']=$interval->days;
			$i++;
		}		
		
		return response()->json(
			array(
				'details'=> $data,
				)
		, 200);

    }
    
    public function slotlist($id){
		$data=$this->getSlotList($id);
		return response()->json(
			array(
				'details'=> $data,
				'id' => $id,
				)
		, 200);
     }
     
     public function getSlotList($timeSlotID){

		
        $slotarr=Slot::where('timeslotid',$timeSlotID)->get();       
		foreach($slotarr as $slotarr1)
		{
            $allocatedseat= Usertimeslot::where('slotid',$slotarr1->id)->count()+$slotarr1->offlineseat;           
            if($allocatedseat<$slotarr1->totalseat)
            {
                $data[]=array(
                    'from' => $slotarr1->fromtime,
                    'to' => $slotarr1->totime,
                    'numofseats' => $slotarr1->totalseat,
                    'id' => $slotarr1->id,
                );
            }
            else
            {
                $data[]=array(
                    'from' =>0,
                    'to' => 0,
                    'numofseats' =>0,
                    'id' => 0,
                );
            }			
		}
		return $data;
	}
	
	public function landingPage(Request $request)
	{
		if (Session::has('userdetail'))
		{			
			$userdetail = Session::get('userdetail');
			$user=User::select('id','name')->where('username',$userdetail['username'])->first();
			$studentdetail=StudentDetail::select('enrollmentid','prefer_location')->where('user_id',$user->id)->first();
			$usertimeslot=Usertimeslot::select('slotid')->where('userid',$user->id)->first();
			$slot=Slot::select('timeslotid','fromtime','totime')->where('id',$usertimeslot->slotid)->first();
			$timeslot=Timeslot::select('slotdate')->where('id',$slot->timeslotid)->first();
			
			$isexaminrohtak=true;
			if($studentdetail->prefer_location!='rohtak')
				$isexaminrohtak=false;

            $batch=$this->getBatchTimingsView($timeslot->slotdate, $slot->fromtime, $slot->totime);
            
			Session::flush(); 
			return view('landing-page')->with('data',['name' => $user->name, 
		 			'examdate' => $timeslot->slotdate, 
		 			'examtime' => $batch, 
		 			'isexaminrohtak' => $isexaminrohtak,
		 			'enrollmentid'=>$studentdetail->enrollmentid
		 			]);
			
			
		}
		else
		{
			return redirect('/register')->with('otpmessage', 'You need to confirm your account. We have sent you an activation code, please check your mobile and click <a href="'.url('/user/verify').'">Here</a>.');
		}	
	   
		
	}
	
	protected function getTrxnId($name){
	    
	    return "MD-".substr($name, 0, 2)."-" .substr(hash('sha256', mt_rand() . microtime()), 0, 5);
	}
	
	public function payment($id, Request $request){
	    
	    $baseUrl=env("PAYU_BASE_URL");
	    $merchantKey=env("PAYU_MERCHANT_KEY");
	    $salt=env("PAYU_SALT");
        $appUrl=env("APP_URL");

        // Get the transaction details
        try {
            $txnid=decrypt($id);
        } catch (DecryptException $e) {
            return redirect('payment-initiate')->with('pymntinitmsg', 'The transction-id is invalid. Please re-try the payment.');
        }
        
        $stdntTrnsMdl=StudentTransaction::where('txnid', $txnid);
        
        if($stdntTrnsMdl->count() == 0){
            return redirect()->back()->with('pymntinitmsg', 'Please re-try the payment transction.');
        }
        
        $studentTransactionDetails=$stdntTrnsMdl->first();
        
        $studentTransactionDetails=DB::table('student_details')
            ->join('users', 'student_details.user_id', '=', 'users.id')
            ->where('student_details.user_id', $studentTransactionDetails->user_id)->first();
        
        $fullName=$studentTransactionDetails->name;
        $fullNameDtls=explode(" ", $fullName);
        $firstName=$fullNameDtls[0];
        $email=$studentTransactionDetails->email;
        $phone=$studentTransactionDetails->mobilenumber;
        if(count($fullNameDtls)>1)
        	$lastName=$fullNameDtls[1];
        else
        	$lastName="";
        $address1=$studentTransactionDetails->genaddressder;
        $city=$studentTransactionDetails->city;
        $state=$studentTransactionDetails->state;
        $pinCode=$studentTransactionDetails->pincode;
        $enrollmentid=$studentTransactionDetails->enrollmentid;
	    $action=$baseUrl.  '/_payment'; 
        
        $amount=env("PAYU_REGISTER_AMOUNT");
        $productInfo=env("PAYU_REGISTER_INFO");
        
        $udf1=$enrollmentid;
        $udf2=$phone;
        $udf3=$email;
        $udf4=$udf5=$udf6=$udf7=$udf8=$udf9=$udf10="";
        $surl=$appUrl."welcome";
        $furl=$appUrl."welcome";
        $curl=$appUrl."payment-cancel";
        
        $hashString = "$merchantKey|$txnid|$amount|$productInfo|$firstName|$email|$udf1|$udf2|$udf3|$udf4|$udf5|$udf6|$udf7|$udf8|$udf9|$udf10|$salt";
        
        $hash = strtolower(hash('sha512', $hashString));
	    $stdntTrnsMdl->update(['hash'=>$hash]);
	    $data = array(
	        'action' => $action,
            'merchantkey' => $merchantKey,
            'hash' => $hash,
            'txnid' => $txnid,
            'amount' => $amount,
            'productinfo' => $productInfo,
            'firstname' => $firstName,
            'email' => $email,
            'phone' => $phone,
            'surl' => $surl,
            'furl' => $furl,
            'lastname' => $lastName,
            'curl' => $curl,
            'address1' => $address1,
            'city' => $city,
            'state' => $state,
            'zipcode' => $pinCode,
            'udf1' => $udf1,
            'udf2' => $udf2,
            'udf3' => $udf3,
            'udf4' => $udf4,
            'udf5' => $udf5,
            'pg' => '',
	        );
	    
	    
	    return view('payment')->with('data', $data);
	    
	}
	
	protected function getUserSlotDetails($userid){
	    
        $userTimeSlotDetail=Usertimeslot::where('userid', $userid)->first();
        $slotId = $userTimeSlotDetail->slotid;
        $slotDetails=Slot::where('id', $slotId)->first();
        $timeslotDetails=Timeslot::where('id', $slotDetails->timeslotid)->first();
        
        $date=$timeslotDetails->slotdate;
        $batch=$this->getBatchTimingsView($date, $slotDetails->fromtime, $slotDetails->totime);
        
        return [
            'examdate' => $date,
            'examtime' => $batch,
            'fromtime' => $slotDetails->fromtime,
            'totime' => $slotDetails->totime
            ];
	}
	
	/* Verifies the user transaction details based upon enrollmentid */
	protected function verifyUserTransaction($enrollmentid, $phone, $email, $txnid, $hash){
	    
	    
	    return ;
	    
	}
	
	public function paymentstatus(Request $request){

        $status=$request->status;
        $txnid=$request->txnid;
        $posted_hash=$request->hash;
        $email=$request->email;
        $phone=$request->phone;
        // Get Enrollmentid
        $enrollmentid=$request->udf1;
        $requestPhone=$request->udf2;
        $requestEmail=$request->udf3;
        //dd($request->all());
        $stdntTrxnDtlsMdl=StudentTransaction::select('user_id')->where([
	                                ['enrollmentid','=',$enrollmentid],
	                                ['phone','=',$requestPhone],
	                                ['email','=',$requestEmail],
	                                ['txnid','=', $txnid]
	                            ]);

        if($stdntTrxnDtlsMdl->count()<=0){
            $msg="Unable to process the payment having Transaction-ID: <b>$txnid</b>. Please re-try the payment.";
            if(PayuResponseTransaction::where('txnid', $txnid)->count() == 0){
                PayuResponseTransaction::create([
                        'txnid' => $txnid,
                        'tracking_message' =>"invalid_userid:User details not matched with PayU response ($enrollmentid:$phone:$email:$txnid)"
                    ]);
            }
            StudentTransaction::where('txnid', $txnid)->update(['payu_status'=> $status]);
            return redirect('payment-initiate')->with('pymntinitmsg', $msg);
        }
	   
        if(PayuResponseTransaction::where('txnid', $txnid)->count() == 0){
            PayuResponseTransaction::create([
                    'txnid' => $txnid,
                    'payumoneyid' =>$request->payuMoneyId,
                    'status'=>$status,
                    'unmappedstatus'=>$request->unmappedstatus,
                    'addedon'=>$request->addedon,
                    'field9'=>$request->field9,
                    'bankrefnum'=> $request->bank_ref_num,
                    'bankcode'=>$request->bankcode,
                    'error'=>$request->error,
                    'errormessage'=> $request->error_Message,
                    'mihpayid'=> $request->mihpayid,
                ]);
        }
        

	    $stdntTrxnDtlsMdl->update(['payu_status'=> $status]);
        $trxnDetails=$stdntTrxnDtlsMdl->first();
        
        $userid=$trxnDetails->user_id;
        $dbHash=$trxnDetails->hash;
        
        $firstname=$data['firstname']=$request->firstname;
        $amount=$data['amount']=$request->amount;
        $key=$data['key']=$request->key;
        $productinfo=$data['productinfo']=$request->productinfo;
        $data['lastname']=$request->lastname;
        $data['unmappedstatus'] = $request->unmappedstatus;
        $data['txnid']=$txnid;
        $salt=env("PAYU_SALT");
        $retHashSeq="";
        
        // Salt should be same Post Request 
        if (isset($request->additionalCharges)) {
            $additionalCharges=$request->additionalCharges;
            $retHashSeq = $additionalCharges.'|';
    		
        }
        
        $retHashSeq.=$salt.'|'.$status.'||||||||'.$requestEmail.'|'.$requestPhone.'|'.$enrollmentid.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        $hash = hash("sha512", $retHashSeq);
    	
    	$prnt=array(
    	    'retHashSeq'=>$retHashSeq,
    	    'hash' => $hash,
    	    'posted_hash' =>$posted_hash
    	    );
    	
    	//dd($prnt);
    	
		if ($hash != $posted_hash) {
		    $msg="Payment for the transaction-id: <b>$txnid</b> is incomplete. Please re-try the payment.";
            PayuResponseTransaction::where('txnid', $txnid)->update(['tracking_message' =>"invalid_payu_hash:HashGenerated:$hash, RcvdHash:$posted_hash"]);
            return redirect('payment-initiate')->with('pymntinitmsg', $msg);
		}
        
        $slotDetails=$this->getUserSlotDetails($userid);
        $data['orderstatus']=$status;
        $data['examdate'] = $slotDetails['examdate'];
		$data['examtime'] = $slotDetails['examtime'];
		$data['isexaminrohtak'] = true;
        $data['enrollmentid']=$enrollmentid;

        if($status == "success"){
            $data['istrxnsuccess']=true;
            StudentDetail::where('user_id', $userid)->update(['ispaymentdone'=> 1]);
        } else if($status == "failure"){
            $data['istrxnsuccess']=false;
        }
        
        return view('welcome')->with('data', $data);
        
    }
    
    public function paymentcancel(Request $request) {
        
        return view('payment-cancel');
        
    }
    
    public function paymentinitiate(){
         $data=array();
        return view('payment-initiate')->with('data', $data);
    }
    
    protected function getUserDetails($enrollmentid, $mobilenumber){

        //TODO: Replace the actual model
        
        $stdntDtlMdl=DB::table('student_details')
            ->join('users', 'student_details.user_id', '=', 'users.id')
            ->where([
                            ['enrollmentid', '=', $enrollmentid],
                            ['mobilenumber', '=', $mobilenumber]
                            ]);

        if($stdntDtlMdl->count()<=0) {
            return null;
        }
        
        return $stdntDtlMdl->first();
    }

    public function fetchdetails($enrollmentid, $mobilenumber, Request $request){

        
        $studentDetails=$this->getUserDetails($enrollmentid, $mobilenumber);
        
        if( $studentDetails === null) {
            return response()->json(
			    array(
				    'message'=> "Mis-match between the mobile number and enrollment-id",
				)
		        , 201);
        }

        $data = array('fullname' => $studentDetails->name, 'schoolname' => $studentDetails->schoolName,
                        'dob' => $studentDetails->dob, 'email' => $studentDetails->email);
        return response()->json(
			array(
				'details'=> $data,
				)
		, 200);
    }
    
    public function paymentprocess(Request $request){
        
        $enrollmentid=$request->enrollmentid;
        $mobile=$request->mobile;
        
        $studentDetails=$this->getUserDetails($enrollmentid, $mobile);
        if( $studentDetails === null) {
            return redirect()->back()->with('pymntinitmsg', 'Mis-match between the mobile number and enrollment-id');
        }
        
        $txnid=$this->getTrxnId($request->fullname);
        
		$data=array(
		    'user_id' => $studentDetails->user_id,
		    'enrollmentid' => $enrollmentid,
		    'phone' => $mobile,
		    'email' => $studentDetails->email,
		    'txnid' => $txnid,
		    
		    );
        // TODO: Create the transaction, once the student clicks on Pay button
        StudentTransaction::create($data);
        $encrypted = Crypt::encrypt($txnid);
		return redirect("/payment/$encrypted");
    }
}
