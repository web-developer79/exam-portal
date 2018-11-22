<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Questionset;
use App\Question;
use App\Studentquestionpaper;
use App\Studentanswer;
use App\Questionchoice;
use App\Questionanswer;
use App\Studentattemp;
use Carbon\Carbon;
use App\StudentDetail;
use Intervention\Image\Facades\Image;
use Storage;

class StudentController extends Controller
{
   

    public function __construct() {

    }
    public function dashboard(){
		//TODO: Get the values from the database using queries
		$userdata=User::where('id',Auth::user()->id)->first();
        // TODO: While extracting exam information from db, add the variable of exam passed also
		$studentquespaperdata=Studentquestionpaper::where('user_id',Auth::user()->id)->get();
		$regisexamids=array();
		$i=0;
		$examTaken=array();
		foreach($studentquespaperdata as $studentquespaperdata1)
		{		
			$quesset=QuestionSet::where('id',$studentquespaperdata1->questionset_id)->first();
			
			if($studentquespaperdata1->result=='Fail')
				{
					$isexampass= false;
				}
				else
				{
					$i++;
					$isexampass= true;
				}
				
			$quesattemp=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->where('questionanswer_id','!=',NULL)->count();
				$quesCorrect=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->where('questionanswer_id','!=',NULL)->where('result',1)->count();
				$questotal=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->count();

				$rightansmark=2;
				$wrongansmarks=0;
				$wrongquestion=$quesattemp-$quesCorrect;
				$scoreWrong=$wrongquestion*$wrongansmarks;
				$scoreCorrect=$quesCorrect*$rightansmark;
				$finalmark=$scoreCorrect-$scoreWrong;
				$scoreTotal=$questotal*$rightansmark;	
				if($scoreTotal==0)
				{
					$percenttage='N.A';
				}
				else
				{
					$percenttage=($finalmark*100)/$scoreTotal;
				}
				
				
			$examTaken[]=array(            
                'name'=> $quesset->title,
                'percentage' => $percenttage,
                'isExamPass' => $isexampass,
                'result' => $studentquespaperdata1->result,
                'questionSetId'=>$studentquespaperdata1->questionset_id
            );
		}
		
        
        //$examTaken=array();
        $data = array(
            'examsPassed' => $i,
            'currentLevel' => $userdata->currlevel,
            'examTaken' => $examTaken,
			
        );
        return view('student.dashboard')->with('data', $data);
    }
    

    public function examPendingList() {
		//$userdata=User::where('id',Auth::user()->id)->first();
		$studentquespaperdata=Studentquestionpaper::where('user_id',Auth::user()->id)->get();
		$regisexamids=array();
		$examDetails=array();
		foreach($studentquespaperdata as $studentquespaperdata1)
		{
			$noofattemp= $this->checkstudentatttemp(Auth::user()->id,$studentquespaperdata1->questionset_id);
			if($noofattemp<2 && Studentquestionpaper::where('user_id',Auth::user()->id)->where('questionset_id',$studentquespaperdata1->questionset_id)->where('is_complete',0)->exists())
			{
				$this->deletestudentquestionpapers(Auth::user()->id,$studentquespaperdata1->questionset_id);	
			}
			else
			{
				$regisexamids[]=$studentquespaperdata1->questionset_id;
			}				
			
		}
		$quesset=QuestionSet::whereNotIn('id',$regisexamids)->where('status',1)->whereDate('scheduled_at','<=', Carbon::today())->get();
		foreach($quesset as $quesset1)
		{
			$examDetails[] = array (			
				"name" => $quesset1->title,
				"id" => $quesset1->id
			);
		}
		
		$data = array ('examTaken' => $examDetails);
        
		return view('student.questionset.pendinglist')->with('data', $data);
    }

    public function examList() {
		$quesset=QuestionSet::where('status',1)->whereDate('scheduled_at','<=', Carbon::today())->get();
		$examDetails=array();
		foreach($quesset as $quesset1)
		{
			$studentquespapaer=Studentquestionpaper::where('questionset_id',$quesset1->id)->where('user_id',Auth::user()->id)->first();
			if($studentquespapaer === null)
			{
				$attempt=false;
				$isexampass= true;
				$createdate='N.A';
				$percenttage='N.A.';
				$result='N.A.';
			}
			else
			{
				$attempt=true;
				$createdate=$studentquespapaer->created_at;
				$quesattemp=StudentAnswer::where('studentquestionpaper_id',$studentquespapaer->id)->where('questionanswer_id','!=',NULL)->count();
				$quesCorrect=StudentAnswer::where('studentquestionpaper_id',$studentquespapaer->id)->where('questionanswer_id','!=',NULL)->where('result',1)->count();
				$questotal=StudentAnswer::where('studentquestionpaper_id',$studentquespapaer->id)->count();

				$rightansmark=2;
				$wrongansmarks=0;
				$wrongquestion=$quesattemp-$quesCorrect;
				$scoreWrong=$wrongquestion*$wrongansmarks;
				$scoreCorrect=$quesCorrect*$rightansmark;
				$finalmark=$scoreCorrect-$scoreWrong;
				$scoreTotal=$questotal*$rightansmark;
				if($scoreTotal==0)
				{
					$scoreTotal=1;
				}
				$percenttagefl=($finalmark*100)/$scoreTotal;		
				$percenttage=number_format((float)$percenttagefl, 2, '.', '').'%';	
				
				
				
				$result=$studentquespapaer->result;
				if($studentquespapaer->result=='Fail')
				{
					$isexampass= false;
				}
				else
				{
					$isexampass= true;
				}
			}
		
			$examDetails[] = array (			
				"name" => $quesset1->title,
				"attemptDate" => $createdate,
				"percentage" => $percenttage,
				"isAttempt" => $attempt,
				"isExamPass" => $isexampass,
				"result" =>$result ,
				"id" => $quesset1->id
			);
		}
		
		$data = array ('examTaken' => $examDetails);

        return view ('student.questionset.list')->with('data', $data);
    }

    public function startExam($id){
        // TODO: Need to validate from the database that student has not given the exam.
        $userdata=User::where('id',Auth::user()->id)->first();
        $questionSetDetails=QuestionSet::where('id', $id)->first();
		if($questionSetDetails)
		{
			$data = array(
				'isExamTaken'=>false,
				'title' => $questionSetDetails->title,
				'instructions' => $questionSetDetails->description,
				'quessetid' =>$id
			);
			//echo "<pre>"; print_r($data); die;
			return view('student.questionset.startexam')->with('data', $data);	
		}
		else
		{
			return redirect('/student/dashboard')->with('studentdashbordmsg', 'Invalid Question Set.');
		}
        
    }

    public function ongoingExam(Request $request) {
		// TODO: Need to validate from the database that student has not given the exam.
		
        $userdata=User::where('id',Auth::user()->id)->first();
		$questionsetid=$request->quessetid;
        if(isset($questionsetid))
		{
			$todaydate=Carbon::today();
			$noofattemp= $this->checkstudentatttemp(Auth::user()->id,$questionsetid);
			if($noofattemp<2 && Studentquestionpaper::where('user_id',Auth::user()->id)->where('questionset_id',$questionsetid)->where('is_complete',0)->exists())
			{
				$this->deletestudentquestionpapers(Auth::user()->id,$questionsetid);	
			}				
			if(!Studentquestionpaper::where('user_id',Auth::user()->id)->where('questionset_id',$questionsetid)->exists())
			{
				$noofnextattemp=$noofattemp+1;
				$this->insertstudentattemp(Auth::user()->id,$questionsetid,$noofnextattemp,$todaydate);
				$questionsetdata=Questionset::where('id',$questionsetid)->first();
			
				$questions=Question::select('id')->where('questionset_id',$questionsetid)->limit($questionsetdata->numofques)->inRandomOrder()->get();
				$studentquestionpapdata['user_id']=Auth::user()->id;
				$studentquestionpapdata['questionset_id']=$questionsetid;
				$studentquestionpapdata['default_time']=$questionsetdata->time;
				$studentquestionpapdata['is_complete']=0;
				$studentquestionpapdata['time_spent']=0;
				$studentquestionpapdata['result']=Null;
				$studentquespap=Studentquestionpaper::create($studentquestionpapdata);
				$studentquespapid=$studentquespap->id;
				$studentans=[];
				foreach($questions as $questions1)
				{
					$studentans['studentquestionpaper_id']=$studentquespapid;
					$studentans['question_id']=$questions1->id;
					$studentans['questionanswer_id']=Null;
					$studentans['result']=Null;
					Studentanswer::create($studentans);
				}
			}
			else
			{							
				return redirect('/student/dashboard')->with('studentdashbordmsg', 'Invalid Question Set.');
			}	
			$quesidobj=StudentAnswer::where('studentquestionpaper_id',$studentquespapid)->orderBy('id')->first();	
			//echo $quesidobj->question_id; die;
			if($quesidobj === null)
			{
				return redirect('/student/dashboard')->with('studentdashbordmsg', 'Invalid Question Set.');
			}
			else
			{
				$data = $this->getQA($quesidobj->question_id);
				$data['studentquespapid']=$studentquespapid;
				$data['totoalques']=count($questions);
				$data['default_time']=$questionsetdata->time;
				return view('student.questionset.ongoingexam')->with('data', $data);
			}				
			
			
		}
		else
		{
			return redirect('/student/dashboard')->with('studentdashbordmsg', 'Invalid Question Set.');
		}
		      
    }

    public function result(Request $request){
        //TODO: Get the questionset id and student id from the session 				
		if(isset($request->studentquespapid))
		{			
			$quesattemp=StudentAnswer::where('studentquestionpaper_id',$request->studentquespapid)->where('questionanswer_id','!=',NULL)->count();
			$quesCorrect=StudentAnswer::where('studentquestionpaper_id',$request->studentquespapid)->where('questionanswer_id','!=',NULL)->where('result',1)->count();
			$studentquespapdata=Studentquestionpaper::select('questionset_id')->where('id',$request->studentquespapid)->first();			
			$quessetdata=QuestionSet::where('id',$studentquespapdata->questionset_id)->first();
			
			$rightansmark=2;
			$wrongansmarks=0;
			$scoreTotal=$request->totoalques*$rightansmark;	
			$scoreAttempt=$quesattemp*$rightansmark;	
			$wrongquestion=$quesattemp-$quesCorrect;
			$scoreWrong=$wrongquestion*$wrongansmarks;
			$scoreCorrect=$quesCorrect*$rightansmark;
			$finalmark=$scoreCorrect-$scoreWrong;
			
			if($quessetdata->passnum>$finalmark)
			{
				$result='Fail';
			}
			else
			{
				$result='Pass';
			}
			
			$percentagemark=($finalmark*100)/$scoreTotal;
			$data = array(
            'quesTotal'=> $request->totoalques,
            'quesAttempt'=> $quesattemp,
            'quesCorrect'=>$quesCorrect,
            'scoreTotal'=> $scoreTotal,
            'scoreAttempt'=> $scoreAttempt,
            'scoreCorrect'=> $scoreCorrect,
			'finalMark' =>$finalmark,
            'result' => $result,
            'percentage' => $percentagemark,
            'isExamPass' => true,
			'questionPaperId'=>$request->studentquespapid
        );
		Studentquestionpaper::where('id',$request->studentquespapid)->update(['result'=>$result,'is_complete'=>1]);
		}
		else
		{
			return redirect('/student/dashboard')->with('studentdashbordmsg', 'Invalid Request');
		}
        
        return  view('student.questionset.result')->with('data', $data);

    }
    public function getQA($id=null){
		
        //StudentAnswer::where('id')->first();
        $quesobj=Question::select('question')->where('id',$id)->first();		
		//echo "<pre>"; print_r($quesobj); die;
        $qs=$quesobj->question;
		
		$quesansobj=Questionchoice::where('question_id',$id)->get();
		$i=0;
		$answer=array();
		foreach($quesansobj as $quesansobj1)
		{
			$answer[$i]['choice_id']=$quesansobj1->id;
			$answer[$i]['choice']=$quesansobj1->choice;
			$i++;
		}   
        
        return array('question_id'=>$id,'question'=>$qs, 'answers'=>$answer);

    }
	
	public function ongoingExamquestion(Request $request)
	{
		if(isset($request->ansid))
		{
			$ansobj=Questionanswer::select('questionchoice_id')->where('question_id',$request->quesid)->first();
			if($ansobj->questionchoice_id==$request->ansid)
			{
				$result=1;
			}
			else
			{
				$result=0;
			}
			Studentanswer::where('studentquestionpaper_id',$request->studentquesid)->where('question_id',$request->quesid)->update(['questionanswer_id'=>$request->ansid, 'result'=>$result]);
				
		}
		$currpage=(int)$request->currpage;
		if($request->type=='next')
		{
			$pageid=$currpage;
		}
		elseif( $request->type=='prev')
		{
			$pageid=$currpage-2;
		}
		else
		{
			$pageid=$currpage-1;
		}
		$studentquespapaerobj = Studentanswer::select('question_id','questionanswer_id')->where('studentquestionpaper_id',$request->studentquesid)->orderBy('id')->skip($pageid)->take(1)->get();
		$data = $this->getQA($studentquespapaerobj[0]->question_id);
		$data['page_id']=$pageid+1;
		$data['questionanswer_id']=$studentquespapaerobj[0]->questionanswer_id;
		return response()->json(['filter' => $data]);
	}
	
	public function resultdetail(Request $request, $id)
	{
		if (Studentquestionpaper::where('questionset_id', $id)->where('user_id',Auth::user()->id)->exists()) {
		   $studentquespap=Studentquestionpaper::select('id')->where('questionset_id', $id)->where('user_id',Auth::user()->id)->first();
		   $studentans = Studentanswer::join('questions', 'studentanswers.question_id', '=', 'questions.id')->leftJoin('questionchoices', 'studentanswers.questionanswer_id', '=', 'questionchoices.id')->where('studentquestionpaper_id',$studentquespap->id)->get();
		   $i=0;
		   foreach($studentans as $studentans1)
		   {
			   $data[$i]['question_id']=$studentans1->question_id;
			   $data[$i]['question'] = $studentans1->question;
			   $data[$i]['answer'] = $studentans1->choice;
			   $data[$i]['questionanswer_id']=$studentans1->questionanswer_id;			   
			   if($studentans1->result  == '1')
			   {
				   $data[$i]['result']='correct';
			   }
			   elseif($studentans1->result == '0')
			   {
				   $data[$i]['result']='incorrect';
			   }
			   else
			   {
				   $data[$i]['result']='Un Attempt';
				   $data[$i]['answer']='N.A.';
			   }
			   $i++;
		   }
		   return view('student.questionset.resultdetail')->with('data', $data);
		   //echo "<pre>"; print_r($data);
		}
		else
		{
			return redirect('/student/dashboard')->with('studentdashbordmsg', 'You have not attempted the exam');
		}
	}
	
	public function resultlist(){
		$studentquespaperdata=Studentquestionpaper::where('user_id',Auth::user()->id)->get();	
       $data=array();		
		foreach($studentquespaperdata as $studentquespaperdata1)
		{			
			$quesionset = Questionset::where('id',$studentquespaperdata1->questionset_id)->first();
			$quesattemp=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->where('questionanswer_id','!=',NULL)->count();
			$quesCorrect=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->where('questionanswer_id','!=',NULL)->where('result',1)->count();
			$questotal=StudentAnswer::where('studentquestionpaper_id',$studentquespaperdata1->id)->count();

				$rightansmark=2;
				$wrongansmarks=0;
				$wrongquestion=$quesattemp-$quesCorrect;
				$scoreWrong=$wrongquestion*$wrongansmarks;
				$scoreCorrect=$quesCorrect*$rightansmark;
				$finalmark=$scoreCorrect-$scoreWrong;
				$scoreTotal=$questotal*$rightansmark;
				if($scoreTotal==0)
				{
					$scoreTotal=1;
				}
				$percenttagefl=($finalmark*100)/$scoreTotal;		
				$percenttage=number_format((float)$percenttagefl, 2, '.', '').'%';
			if($studentquespaperdata1->result)
			{
				$result= $studentquespaperdata1->result;
			}
			else
			{
				$result ='Incomplete';
			}
			
			$data[] = array(			
				'examName' => $quesionset->title,
				'percentage' => $percenttage,
				'result' => $result,
				'questionSetId' => $studentquespaperdata1->questionset_id
			);
		}
		
		return view('student.questionset.resultlist')->with('data', $data);
	}
	
	public function upcomingExam(Request $request) {
	$quesset=QuestionSet::where('status',1)->whereDate('scheduled_at','>=', Carbon::today())->get();
	$data=array();
	foreach($quesset as $quesset1)
	{
		$data[]=array(			
				"examName" => $quesset1->title,
				"examDate" => $quesset1->scheduled_at,
				);
	}		
		return view('student.questionset.upcomingexam')->with('data', $data);
	}

	private function insertstudentattemp($user_id,$questionset_id,$attempt,$last_attemptdate )
	{
		$data['user_id']=$user_id;
		$data['questionset_id']=$questionset_id;
		$data['attempt']=$attempt;
		$data['last_attemptdate']=$last_attemptdate;
		Studentattemp::insert($data);
	}

	private function deletestudentquestionpapers($user_id,$questionset_id)
	{
		Studentquestionpaper::where('user_id',$user_id)->where('questionset_id',$questionset_id)->where('is_complete',0)->delete();
	}

	private function checkstudentatttemp($user_id,$questionsetid)
	{
		$attemobj=Studentattemp::select('attempt')->where('user_id',$user_id)->where('questionset_id',$questionsetid)->orderBy('id', 'DESC')->first();
		if(isset($attemobj->attempt))
		{
			return $attemobj->attempt;
		}
		else
		{
			return 0;
		}
	}

	public function profile() {		
		$userdata=User::where('id',Auth::user()->id)->first();
		$studentDetail=StudentDetail::where('user_id',Auth::user()->id)->first();
		$sourceArray=array('online','door','ntse');
		if($studentDetail->sourcedetail ==NULL)
		{
			$source='';
			$otherDetail='';
		}
		else
		{
			if(in_array($studentDetail->sourcedetail,$sourceArray))
			{
				$source=$studentDetail->sourcedetail;
				$otherDetail='';
			}
			else
			{
				$source='other';
				$otherDetail=$studentDetail->sourcedetail;
			}
		}	
		$profilepic=env('STORAGE_URL').'/user/'. $studentDetail->profilepic;	
        $data = array(
			'name' => $userdata->name,
			'enrollmentid'=>$studentDetail->enrollmentid,
            'email' => $userdata->email,
			'mobilenumber' => $userdata->mobilenumber,
			'registeredfor' => $studentDetail->registeredfor,
			'altermobilenumber' => $studentDetail->altermobilenumber,
			'fatherName' => $studentDetail->fatherName,
			'fatherOccupation' => $studentDetail->fatherOccupation,
			'dob' => $studentDetail->dob,
			'gender' => $studentDetail->gender,
			'current_class' => $studentDetail->current_class,
			'genaddressder' => $studentDetail->genaddressder,
			'city' => $studentDetail->city,
			'state' => $studentDetail->state,
			'pincode' => $studentDetail->pincode,
			'schoolName' => $studentDetail->schoolName,
			'schoolAddress' => $studentDetail->schoolAddress,
			'profilepic' => $profilepic,
			'source' =>  $source,
			'sourcedetail'=>$otherDetail		
		);		
        return view('student.profile')->with('data', $data);
	}

	public function updateProfile(Request $request)
	{
		
		$data=$request->all();
		//echo "<pre>"; print_r($data); die;
		$validate = Validator::make($data, [
			'name' => 'required|max:255',
            'email' => 'required|string|email|max:255',
			'mobilenumber'=> 'required',
			'altermobilenumber'=> 'required',
			'dob'=> 'required',
			'gender'=> 'required',
			'current_class'=> 'required',
			'schoolName'=> 'required',
		]);		
		if (!$validate->passes()) {		
			return redirect()->back()->withErrors($validate->errors());			
		}
		else
		{
			if(User::where('email',$request->email)->where('id', '!=',Auth::user()->id)->exists())
			{
				return redirect('/student/profile')->with('manageprofile', 'An account is associated with this email id.');
				die;
			}	
			if(User::where('mobilenumber',$request->mobilenumber)->where('id', '!=',Auth::user()->id)->exists())
			{
				return redirect('/student/profile')->with('manageprofile', 'An account is associated with this mobile number.');
				die;
			}
			if($request->source=='other')
			{
				$sourceDetail=$request->sourcedetail;
			}
			else
			{
				$sourceDetail=$request->source;
			}	
			if ($request->hasFile('photo')) {				
				$image      = $request->file('photo');				
				$fileName   = time() . '.' . $image->getClientOriginalExtension();
	
				$img = Image::make($image->getRealPath());
				$img->resize(120, 120, function ($constraint) {
					$constraint->aspectRatio();                 
				});		
				$img->stream();					
				Storage::disk('public')->put('user'.'/'.$fileName, $img, 'public');
		}
			StudentDetail::where('user_id',Auth::user()->id)->update(['registeredfor'=>$request->registeredfor,'dob'=>$request->dob,'fatherName'=>$request->fatherName,'fatherOccupation'=>$request->fatherOccupation,'genaddressder'=>$request->genaddressder,'city'=>$request->city,'state'=>$request->state,'pincode'=>$request->pincode,'schoolName'=>$request->schoolName,'schoolAddress'=>$request->schoolAddress,'profilepic'=>$request->profilepic,'altermobilenumber'=>$request->altermobilenumber,'gender'=>$request->gender,'current_class'=>$request->current_class, 'sourcedetail'=>$sourceDetail,'profilepic'=>$fileName]);
			User::where('id',Auth::user()->id)->update(['name'=>$request->name,'email'=>$request->email,'mobilenumber'=>$request->mobilenumber]);
			

			return redirect('/student/profile')->with('manageprofile', 'You have updated profile successfully.');
		}	
	}
	
}
