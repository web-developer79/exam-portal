<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Questionset;
use App\Question;
use App\Questionanswer;
use App\Questionchoice;
use App\User;
use App\Studentquestionpaper;
use App\Studentanswer;
use App\StudentDetail;
use App\Slot;
use App\Timeslot;
use App\Usertimeslot;
use Response;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

	public function index()
    {		
		$totalStudents=User::where('user_type','User')->count();
		$verifiedStudentsNum=User::where('user_type','User')->where('isverified',1)->count();
		$unVerifiedStudentsNum=User::where('user_type','User')->where('isverified',0)->count();
		$totalExamConducted=Studentquestionpaper::count();
		$passStudents=Studentquestionpaper::where('result','Pass')->count();
		$failStudents=Studentquestionpaper::where('result','Fail')->count();;
		
		$dashboardData['totalQuestionSets']=Questionset::count();
		$dashboardData['totalExamsDone']=$totalExamConducted;
		if($totalStudents==0)
			$verifiedStudentsPer = 0;
		else
		      $verifiedStudentsPer=($verifiedStudentsNum/$totalStudents)/100;
		$dashboardData['verifiedStudentsNum']=$verifiedStudentsNum;
		
		$dashboardData['verifiedStudentsPer']=$verifiedStudentsPer;
		$dashboardData['unVerifiedStudentsNum']=$unVerifiedStudentsNum;
		$dashboardData['totalStudents']=$totalStudents;
		$dashboardData['failStudentsNum']=$failStudents;
		$dashboardData['passStudentsNum']=$passStudents;
		if($totalExamConducted==0) 
		    $dashboardData['passStudentsPer']=0;
		else
		  $dashboardData['passStudentsPer']=($passStudents/$totalExamConducted)*100;
        return view('admin.dashboard')->with('dashboardData', $dashboardData);
		
    }
	
	public function questionsetcreate(Request $request)
    {
        return view('admin.questionset.manage');
        //return view('admin.dashboard');
    }
	
	public function questionsetlist(Request $request)
    {
        $quesset=Questionset::get();
		$i=0;
		$data=[];
		foreach($quesset as $quesset1)
		{
			$noofques= Question::where('questionset_id',$quesset1->id)->count();
			$data[$i]['id']=$quesset1->id;
			$data[$i]['title']=$quesset1->title;
			$data[$i]['description']=$quesset1->description;
			$data[$i]['numofques']=$quesset1->numofques;
			$data[$i]['totalques']=$noofques;
			$data[$i]['level']=$quesset1->level;
			$data[$i]['passnum']=$quesset1->passnum;
			$data[$i]['time']=$quesset1->time;
			$i++;
		}		
		
		return view('admin.questionset.list')->with('quessets', $data) ;
    }
	
	public function questionsetedit($id, Request $request)
    {	
		$quesset= Questionset::where('id',$id)->first();
		$data['id']=$quesset->id;
		$data['title']=$quesset->title;
		$data['description']=$quesset->description;
		$data['numofques']=$quesset->numofques;
		$data['level']=$quesset->level;
		$data['passnum']=$quesset->passnum;
		$data['time']=$quesset->time;
		$data['scheduled_at']=$quesset->scheduled_at;
		//echo "<pre>"; print_r($data); die;
        return view('admin.questionset.manage',compact('data'));		
    }
	
	public function questioncreate($quessetid, Request $request)
	{
		$data['quesid']= $quessetid;
		return view('admin.question',compact('data'));
	}
	public function questionedit($id, Request $request)
	{		
		$data['quesid']= $id;
		$questdata= Question::where('id',$id)->first();
		$queschoice= Questionchoice::where('question_id',$id)->get();
		$questans=Questionanswer::where('question_id',$id)->first();
		//echo "<pre>"; print_r($questans); die;
		$data['question']=$questdata->question;
		$data['questiontype']=$questdata->questiontype;
		$data['quessetid']=$questdata->questionset_id;
		$i=0;
		$answer=$questans->questionchoice_id;
		foreach($queschoice as $queschoice1)
		{
			$data['choice'][]=$queschoice1->choice;
			$data['choice_id'][]=$queschoice1->id;
			if($queschoice1->id==$answer)
			{
				$data['answer']=$i;
			}
			$i++;
		}		
 		return view('admin.questionedit',compact('data'));	
	}

	public function questionsetdelete($id, Request $request) {
		Questionset::where('id',$id)->delete();
		return redirect()->back()->with('questionsetmessge', 'Questionset deleted Successfully');
	}
	
	public function questionsetsave(Request $request)
	{		
		$data = $request->all();
		
		$validate = Validator::make($data, [
            'title'    => 'required',
            'description' => 'required',
            'numofques' => 'required',
            'level' => 'required',
            'passnum' => 'required',
            'time' => 'required',
        ]);
		if (!$validate->passes()) {
			return redirect()->back()->withErrors($validate->errors());			
        }
		else
		{
			if(isset($data['quesid']))
			{
				Questionset::where('id',$data['quesid'])->update([
            'title'    => $data['title'],
            'description' => $data['description'],
            'numofques' => $data['numofques'],
            'level' => $data['level'],
            'passnum' => $data['passnum'],
            'time' => $data['time'],
			'scheduled_at' => $data['scheduled_at'],
			]);
			return redirect()->back()->with('questionsetmessge', 'Questionset Updated Successfully');
			}
			else
			{
				//insert
				Questionset::create($data);
			    return redirect()->back()->with('questionsetmessge', 'Questionset Save Successfully');
			}				
			
		}
	}
	
	public function questionlist($quesSetID, Request $request)
	{
		/* Need improvement */
		$qsDetails=Questionset::where('id',$quesSetID)->first();
		$quesList = Question::where('questionset_id' ,$quesSetID)->get();
		$i=0;
		$data['qsDetails']=array(
								'title'=>$qsDetails->title,
							);
		$quesData=array();
		foreach($quesList as $question)
		{
			$quesData[$i]['id']=$question->id;
			$quesData[$i]['question']=$question->question;
			$quesData[$i]['questiontype']=$question->questiontype;
			$quesData[$i]['qsid']=$quesSetID;
			$quesData[$i]['qstitle']=$qsDetails->title;
			$i++;
		}		
		$data['questions']=$quesData;
		
		return view('admin.question.list')->with('data', $data) ;
	}
	
	public function questiondelete($id, Request $request)
	{
		Question::where('id',$id)->delete();
		return redirect()->back()->with('messgeSuccess', 'Question deleted successfully');
	}

	public function paymentstatus($status, $id, Request $request){		
		if($status=='paid')
		{
			StudentDetail::where('user_id',$id)->update(['ispaymentdone'=>1]);
		}
		else
		{
			StudentDetail::where('user_id',$id)->update(['ispaymentdone'=>0]);
		}
		return redirect()->back()->with('messgeSuccess', "Student payment changed successfully to $status");
	}
	public function registertype($type, $id, Request $request){		
		StudentDetail::where('user_id',$id)->update(['registeredfor'=>$type]);
		return redirect()->back()->with('messgeSuccess', "Student registered for $type successfully");

	}
	
	public function questionsave(Request $request)
	{
		$data=$request->all();
		//echo "<pre>"; print_r($data);
		$validate = Validator::make($data, [
            'question'    => 'required',
            'questype' => 'required',
            'quessetid' => 'required',
            'answer' => 'required',
            'rbtnCount' => 'required',            
        ]);
		if (!$validate->passes()) {
			return redirect()->back()->with('questiofailurnmessge', 'In validate data');	
        }
		else
		{
			$ques['question']=$data['question'];
			$ques['questiontype']=$data['questype'];
			$ques['questionset_id']=$data['quessetid'];
			$quesdata=Question::create($ques);
			$questid=$quesdata->id;
			
			//echo "<pre>"; print_r($data['answer']); die;
			foreach($data['answer'] as  $key =>$answer1)
			{
				$queschoice['question_id']= $questid;
				$queschoice['choice']= $answer1;
				$queschoiceobj=Questionchoice::create($queschoice);				
				if($data['rbtnCount']==$key)
				{					
					$quesid=$queschoiceobj->id;
				}							
				
				
			}
			
			$questionanswers['question_id']=$quesdata->id;
			$questionanswers['questionchoice_id']=$quesid;
			Questionanswer::create($questionanswers);
			return redirect()->back()->with('questionmessge', 'Question Saved Successfully');
		}		
	}
	
	
	public function questionupdate(Request $request)
	{		
		$data=$request->all();
		//echo "<pre>"; print_r($data); die;
		$validate = Validator::make($data, [
            'question'    => 'required',
            'questype' => 'required',            
            'answer' => 'required',
            'rbtnCount' => 'required',            
        ]);
		if (!$validate->passes()) {
			return redirect()->back()->withErrors($validate->errors());			
        }
		else
		{		
			$quesdata=Question::where('id',$data['quesid'])->update(['question'=>$data['question'], 'questiontype'=>$data['questype']]);
			$questionansidsobj=Questionchoice::select('id')->where('question_id',$data['quesid'])->get();
			foreach($questionansidsobj as $questionansidsobj1)
			{
				$questionansids[]=$questionansidsobj1->id;
			}
			
			foreach($data['answer'] as $key =>$answer1)
			{
				$queschoice['question_id']= $data['quesid'];
				$queschoice['choice']= $answer1;
				if(isset($data['answerid'][$key]))
				{
					//update choice
					$queschoiceobj=Questionchoice::where('id',$data['answerid'][$key])->update(['choice'=>$answer1]);
					$queschoid=$data['answerid'][$key];
					if (($key = array_search($data['answerid'][$key], $questionansids)) !== false) {
						unset($questionansids[$key]);
					}
				}
				else
				{
					//add choice
					$queschoiceobj=Questionchoice::create($queschoice);
					$queschoid=$queschoiceobj->id;
				}
				//echo "<pre>"; print_r($data['rbtnCount']); die;
				if($data['rbtnCount']==$key)
				{					
					$queschoiceid=$queschoid;
				}							
				
			}
			//remove old choice
			if(isset($questionansids) && !empty($questionansids))
			{
				foreach($questionansids as $questionansids1)
				{
					Questionchoice::where('id',$questionansids1)->delete();
				}
			}
			
			Questionanswer::where('question_id',$data['quesid'])->update(['questionchoice_id'=>$queschoiceid]);
			return redirect()->back()->with('questionmessge', 'Question Updated Successfully');
		}
	}

	public function logout() {
		// Add the functionality of logout
		return redirect('login.html');
	}
	
	public function studentlist()
	{
		$userlist=User::where('user_type','User')->orderBy('name', 'asc')->get();
		$i=0;
		$data=array();
		$paymentDone=$scholarRegistered=$verifiedStudents=0;
		$studentList=array();
		$timeslotdtls=TimeSlot::get();
		$slotdtls=Slot::get();
		$timeslotlist=$slotlist=array();
		foreach($timeslotdtls as $timeslot) {
		    $timeslotlist[$timeslot->id]=$timeslot->slotdate;
		}
		
	    $fromFormat='Y-m-d G:i:s';
	    $toFormat='h:ia';
	    
		foreach($slotdtls as $slot){
		    
    	    $formattedFromTime = \DateTime::createFromFormat($fromFormat, "2018-11-14 $slot->fromtime")->format($toFormat);
            $formattedToTime = \DateTime::createFromFormat($fromFormat, "2018-11-14 $slot->totime")->format($toFormat);
		    $slotlist[$slot->id] = array(
		                "timeslotid"=>$slot->timeslotid,
		                "fromtime"=>$slot->fromtime,
		                "totime" => $slot->totime,
		                "formattedtime" => $formattedFromTime."-".$formattedToTime
		                );
		}
		
		$fromFormat='Y-m-d G:i:s';
		$dateFormat='d-M-y';
		
		foreach($userlist as $userlist1)
		{			
		    $stdntMdl = DB::table('student_details')
            ->join('usertimeslots', 'student_details.user_id', '=', 'usertimeslots.userid')
            ->where('student_details.user_id', $userlist1->id);
			
			if($stdntMdl->count() == 0)
				continue;
			$studentdetail=$stdntMdl->first();
			//$studentdetail=StudentDetail::where('user_id',$userlist1->id)->first();
			//$usertimeslotlist=Usertimeslot::where('userid', $userlist1->id)->first();
			$slotid=$studentdetail->slotid;//['slotid'];
			
			$timeslotid=null;
			if(array_key_exists($slotid, $slotlist))
			    $timeslotid=$slotlist[$slotid]["timeslotid"];
			
			$studentList[$i]['id']=$userlist1->id;
			$studentList[$i]['name']=$userlist1->name;
			$studentList[$i]['mobile']=$userlist1->mobilenumber;
			$studentList[$i]['email']=$userlist1->email;			
			$studentList[$i]['registeredfor']=$studentdetail->registeredfor;
			$studentList[$i]['enrollmentid']=$studentdetail->enrollmentid;
			$studentList[$i]['schoolname']=$studentdetail->schoolName;
			$studentList[$i]['altmobile']=$studentdetail->altermobilenumber;
			
	        $formattedRegDate = \DateTime::createFromFormat($fromFormat, $studentdetail->created_at);
	        
	        if($formattedRegDate != false)
	            $formattedRegDate=$formattedRegDate->format($dateFormat);
	        else
	            $formattedRegDate =$studentdetail->created_at;
	    
			$studentList[$i]['regdate']=$formattedRegDate;
			$studentList[$i]['class']=$studentdetail->current_class;
			
			$studentList[$i]['examdate']="N.A.";
			if($timeslotid !=null){
			    
			    
			    $studentList[$i]['examdate']=\DateTime::createFromFormat('Y-m-d', $timeslotlist[$timeslotid])->format($dateFormat);
			}
			$studentList[$i]['examtime']= "N.A.";
			if(array_key_exists($slotid, $slotlist))
			    $studentList[$i]['examtime']= $slotlist[$slotid]["formattedtime"];
			
			$studentList[$i]['fathername']=$studentdetail->fatherName;
			
			if($userlist1->isverified=='1')
			{
				$studentList[$i]['status']=true;
				$verifiedStudents++;
			}
			else
			{
				$studentList[$i]['status']=false;
			}			
			if($studentdetail->ispaymentdone=='1')
			{
				$studentList[$i]['paymentstatus']=true;
				$paymentDone++;
			}
			else
			{
				$studentList[$i]['paymentstatus']=false;
			}
			$studentList[$i]['ismock']=true;
			if($studentdetail->registeredfor=='scholarship'){
				$studentList[$i]['ismock']=false;
				$scholarRegistered++;
			}				
			$i++;
		}
		$summary=array(
			'verified' => $verifiedStudents,
			'scholar' => $scholarRegistered,
			'payment' => $paymentDone,
			'total' => $i
		);		
		$metadata = array(
			'search' => '',
			'sortorder' => 'asc',
			'sortby' => 'name',
			'currpagenum'=>16,
			'pagecount'=>20,
			'studentperpage'=>10,
		);
		$data= array(
			'studentlist'=>$studentList,
			'summary'=> $summary,
			'metadata' => $metadata
		);
		return view('admin.student.list')->with('students', $data) ;
	}

	public function result(){
		$studentquespap= Studentquestionpaper::get();
		$data=array();
		foreach($studentquespap as $studentquespap1)
		{
			if(User::select('name')->where('id',$studentquespap1->user_id)->exists())
			{
				if($studentquespap1->result=='Pass')
				{
					$result='Pass';
				}
				elseif($studentquespap1->result=='Fail')
				{
					$result='Fail';
				}
				else
				{
					$result='Incomplete';
				}
				$studentdata= User::select('name')->where('id',$studentquespap1->user_id)->first();			
				$questionsetdata= Questionset::select('title')->where('id',$studentquespap1->questionset_id)->first();
				$data[] = array(			
					'name' => $studentdata->name,
					'questionSet' => $questionsetdata->title,
					'attemptDate' => $studentquespap1->created_at,
					'result' => $result,
					'questionSetId' => $studentquespap1->id // Question set given by the student 
					);
			}
			
		}		
		//$data=array();
		return view('admin.student.result')->with('students', $data);
	}

	public function resultdetail($id){
		$studentquespap= Studentquestionpaper::where('id',$id)->first();
		$studentans= Studentanswer::where('studentquestionpaper_id',$id)->get();
		foreach($studentans as $studentans1)
		{
			$questiondata=Question::where('id',$studentans1->question_id)->first();
			$questionans= Questionanswer::where('question_id',$studentans1->question_id)->first();
			$questionchoice=Questionchoice::where('id',$questionans->questionchoice_id)->first();
			if($studentans1->result=='0')
			{
				$result='Incorrect';
			}
			elseif($studentans1->result=='1')
			{
				$result='correct';
			}
			else
			{
				$result='Un Attempt';
			}
		
			$data[] = array(				
					'question' => $questiondata->question,
					'answer' => $questionchoice->choice,
					'result'=>$result
				);
		}
		
		return view('admin.student.resultdetail')->with('data', $data);

	}

	public function exportCsv()
	{
		$txt = array("name",'mobilenumber','email','registerfor','paymentstatus');
		$path= base_path().'\storage\app\public\csv\student.csv'; 
		$myfile = fopen($path, "w") or die("Unable to open file 1!");
		if(fputcsv($myfile, $txt) == true) {			
			$userlist=User::where('user_type','User')->get();
			foreach($userlist as $userlist1)
			{	
				$studentdetail=StudentDetail::where('user_id',$userlist1->id)->first();					
				$name=$userlist1->name;
				$mobilenum=$userlist1->mobilenumber;
				$email=$userlist1->email;			
				$registerfor=$studentdetail->registeredfor;
				if($studentdetail->ispaymentdone=='1')
				{
					$paymentstatus='1';					
				}
				else
				{
					$paymentstatus='0';
				}
				$data_mod1 = array($name,$mobilenum,$email,$registerfor,$paymentstatus);
				fputcsv($myfile, $data_mod1);
				unset($name);
				unset($mobilenum);
				unset($email);
				unset($registerfor);
				unset($paymentstatus);
				
			}			
			fclose($myfile);			
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename=student.csv');
			header('Pragma: no-cache');
			readfile($path);
		}
	}
	//TODO:Himanshu
	//Make the functions working
	public function timeslotmanage($id, Request $request){
		
		$data = array(
			'id'=>-1,
			'title' => '',
			'slotdate'=>'',
			'slots'=>array(),
			'location' => 'rohtak'
		);
		
		if($id !='new' && $id>0) {
			//TODO: Himanshu
			//Add the query here
			$timeslots=Timeslot::where('id',$id)->first();
			$data['id']=$id;
			$data['title']=$timeslots->title;
			$data['slotdate']=$timeslots->slotdate;
			$data['location']=$timeslots->location;
			$data['slots']=$this->getSlotList($id);
		}
		
		return view('admin.timeslot.manage')->with('data',$data);

	}

	public function timeslotlist(){
		
		$timeslots=Timeslot::get();
		$i=0;
		$data=[];
		foreach($timeslots as $timeslot)
		{
			$noofslot= Slot::where('timeslotid',$timeslot->id)->count();
			$totalseat=Slot::where('timeslotid',$timeslot->id)->sum('totalseat');
			$offlineseat=Slot::where('timeslotid',$timeslot->id)->sum('offlineseat');
			$slotobj=Slot::select('id')->where('timeslotid',$timeslot->id)->get();
			$totalbookseat=0;
			foreach($slotobj as $slotobj1)
			{
				
				$totalbookseat=$totalbookseat+Usertimeslot::where('slotid',$slotobj1->id)->count();
			}
			
			//TODO: Himanshu - 02-Nov-2018
			$data[$i]['id']=$timeslot->id;
			$data[$i]['title']=$timeslot->title;
			$data[$i]['date']=$timeslot->slotdate;
			$data[$i]['location']=$timeslot->prefer_location;
			$data[$i]['totalseats']=$totalseat;
			$data[$i]['totalofflineseats']=$offlineseat;
			$data[$i]['numofslot']=$noofslot;
			$data[$i]['numofbooked']=$totalbookseat;
			$i++;
		}		
		
		return view('admin.timeslot.list')->with('data', $data) ;
	}	

	public function timeslotsave(Request $request){
		$data=$request->all();	
		$timeslot['title']=$request->title;
		$timeslot['slotdate']=$request->slotdate;
		$timeslot['prefer_location']=$request->location;
		if(isset($request->timeslotid))
		{
			$timeslotobj=Timeslot::where('id',$request->timeslotid)->update(['title'=>$timeslot['title'],'slotdate'=>$timeslot['slotdate']]);
			$timmelineslotid=$request->timeslotid;
		}
		else
		{
			$timeslotobj=Timeslot::create($timeslot);	
			$timmelineslotid=$timeslotobj->id;		
		}
		//echo "<pre>"; print_r($data); die;
		for($i=1; $i<=$request->numofnewslot; $i++)
		{
			$fromtime= 'fromtime'.$i;
			$totime= 'totime'.$i;
			$totalseat= 'numofseats'.$i;
			$offlineseat='numofofflineseats'.$i;
			//echo $request->$totime; die;		
			$slot['timeslotid']=$timmelineslotid;
			$slot['fromtime']=$request->$fromtime;
			$slot['totime']=$request->$totime;
			$slot['totalseat']=$request->$totalseat;
			$slot['offlineseat']=$request->$offlineseat;
			Slot::create($slot);
		}				
		return redirect('admin/timeslot/list')->with('timeslotlistmessage', 'Timeslot saved Successfully');
	}

	public function timeslotdelete($id, Request $request){
		if(Slot::where('timeslotid',$id)->exists())
		{
			return redirect()->back()->with('timeslotlistmessage', "Timeslot ($id) can't be deleted");
		}
		else
		{
			Timeslot::where('id',$id)->delete();
			return redirect()->back()->with('timeslotlistmessage', "Timeslot ($id) deleted Successfully");
		}
		
	}	

	public function slotadd($id){
		$data=$this->getSlotList($id);
		return response()->json(
			array(
				'details'=> $data,
				'id' => $id
				)
		, 200);
	 }

	 public function slotsave(Request $request){
		$data=$request->except('_token','numofstudents');
		$data['totalseat']=$request->numofstudents;
		$data['offlineseat']=$request->numofofflineseats;
		Slot::create($data);
		return redirect()->back()->with('timeslotlistmessage', 'Timeslot saved Successfully');;
	 
	}

	 public function slotdelete($id, Request $request){
		 //check if slot has any student
		if(Usertimeslot::where('slotid',$id)->exists())
		{
			return response()->json(
				array(
					'status'=>0,
					'message'=> "Slot $id cann't deleted",
					'id' => $id
					)
			, 201);
		}
		else{
			Slot::where('id',$id)->delete();
			return response()->json(
				array(
					'status'=>1,
					'message'=> "Slot $id deleted successfully",
					'id' => $id
					)
			, 200);
		}
		
	 }
	 
	 public function slotlist($id){
		 $timeslot=Timeslot::where('id',$id)->first();
		$data=$this->getSlotList($id);
		return response()->json(
			array(
				'details'=> $data,
				'id' => $id,
				//TODO: Himanshu - 02-Nov-2018
				'date' => $timeslot->slotdate
				)
		, 200);
     }

	public function getSlotList($timeSlotID){
		$data=array();
		$slotarr=Slot::where('timeslotid',$timeSlotID)->get();
		foreach($slotarr as $slotarr1)
		{
		    $numofbooked=Usertimeslot::where('slotid',$slotarr1->id)->count();
		    $onlineseats=$slotarr1->totalseat;
		    $offlineseat=$slotarr1->offlineseat;
		    $numofvacant=$onlineseats-($numofbooked+$offlineseat);
			$data[]=array(
				'from' => $slotarr1->fromtime,
				'to' => $slotarr1->totime,
				'numofseats' => $onlineseats,
				'numofofflineseats' => $offlineseat,
                //TODO: Himanshu - 02-Nov-2018
				'numofbooked'=>$numofbooked,
				'numofvacant'=>$numofvacant,
				'id' => $slotarr1->id,
			);
		}
		return $data;
	}
	
	/* Get the list of transactions done by student */
	public function getTransactions($id) {
	    
        $stdntTxnDtlMdl=DB::table('student_transactions')
            ->join('payu_response_transactions', 'student_transactions.txnid', '=', 'payu_response_transactions.txnid')
            ->where('student_transactions.user_id', $id);

        $count=$stdntTxnDtlMdl->count();
        if($count<=0) {
            $data=null;
        }
        
        $data=$stdntTxnDtlMdl->get();

		return response()->json(
			array(
				'details'=> $data,
				'count' => $count
				)
		, 200);
		
	}
}
