<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/user/verify', 'Auth\RegisterController@verifyUser');
Route::post('/user/verification', 'Auth\RegisterController@verification');
Route::get('/user/resendotp', 'Auth\RegisterController@resendotp');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/loginin', 'HomeController@loginin')->name('home');
Route::get('/', 'Auth\RegisterController@homeAccess');
Route::post('/user/updatemobilenumber', 'Auth\RegisterController@updatemobilenumber');
Route::get('timeslot/list/view/{location}', 'Auth\RegisterController@timeslotlistview');
Route::get('fetchdetails/{enrollmentid}/{mobile}', 'Auth\RegisterController@fetchdetails');
Route::get('slot/list/{id}', 'Auth\RegisterController@slotlist');
Route::get('/enrollment', 'Auth\RegisterController@enrollemnt');
Route::get('/payment-initiate', 'Auth\RegisterController@paymentinitiate');
Route::post('payment-process', 'Auth\RegisterController@paymentprocess');
Route::get('/payment/{id}', 'Auth\RegisterController@payment');
Route::post('/welcome', 'Auth\RegisterController@paymentstatus');
Route::post('/payment-cancel',  'Auth\RegisterController@paymentcancel');
Route::get('/result', 'Auth\RegisterController@viewresult');
Route::get('fetchresult/{enrollmentid}/{mobile}', 'Auth\RegisterController@fetchresult');


Route::group(array('middleware' => ['auth']), function ()
  {
	  Route::get('logout', 'Auth\LoginController@logout');
	  
  });

/*Route::get('/student/dashboard', function(){
    $data = array(
        'examsTaken' => 10,
        'examsPassed' => 8,
        'currentLevel' => 2
    );
    return view('student.dashboard')->with('data', $data);
}); */

/* Student Routes */
Route::group(array('prefix'=>'student','middleware' => ['auth']), function ()
  {
     Route::get('dashboard','StudentController@dashboard');
     
     Route::get('exam/list/pending', 'StudentController@examPendingList');
     Route::get('exam/list/upcoming', 'StudentController@upcomingExam');
     Route::get('exam/list', 'StudentController@examList');
     Route::get('exam/start/{id}', 'StudentController@startExam');
     Route::post('exam/ongoing/', 'StudentController@ongoingExam');
     Route::post('exam/result/', 'StudentController@result');
     Route::get('exam/result/list', 'StudentController@resultlist');
	 Route::get('exam/resultdetail/{id}', 'StudentController@resultdetail');     
     //Route::get('logout','StudentController@logout');
     Route::get('profile','StudentController@profile');
     Route::post('update-profile','StudentController@updateProfile');
	 Route::post('exam/ongoingExamquestion/', 'StudentController@ongoingExamquestion');

  });

/* Admin Routes*/

Route::group(array('prefix'=>'admin','middleware' => ['auth', 'admin']), function ()
  {
     Route::get('dashboard','AdminController@index');
     Route::get('questionset/create','AdminController@questionsetcreate');
     Route::post('questionset/save','AdminController@questionsetsave');
     Route::get('questionset/list','AdminController@questionsetlist');
     Route::get('questionset/edit/{id}','AdminController@questionsetedit');
     Route::get('questionset/delete/{id}','AdminController@questionsetdelete');	
     Route::get('question/create/{quessetid}','AdminController@questioncreate');
     Route::get('question/edit/{id}','AdminController@questionedit');
     Route::get('question/list/{quessetid}','AdminController@questionlist');
     Route::get('question/delete/{id}','AdminController@questiondelete');	
     Route::post('question/save','AdminController@questionsave');
     Route::post('question/update','AdminController@questionupdate');	
	 Route::get('student/list','AdminController@studentlist');
     Route::get('student/result/list', 'AdminController@result');
     Route::get('student/result/detail/{id}', 'AdminController@resultdetail');
     Route::get('student/payment/{status}/{id}', 'AdminController@paymentstatus');
     Route::get('student/register/{type}/{id}', 'AdminController@registertype');
     Route::get('student/exportcsv/','AdminController@exportCsv');
     Route::get('timeslot/manage/{id}', 'AdminController@timeslotmanage');
     Route::get('timeslot/delete/{id}', 'AdminController@timeslotdelete');
     Route::post('timeslot/save', 'AdminController@timeslotsave');
     Route::get('timeslot/list', 'AdminController@timeslotlist');     
     Route::get('slot/add/{id}', 'AdminController@slotadd');     
     Route::get('slot/delete/{id}', 'AdminController@slotdelete');
     Route::get('slot/list/{id}', 'AdminController@slotlist');
     Route::post('slot/save', 'AdminController@slotsave');
     Route::get('transaction/list/{id}', 'AdminController@getTransactions');
     Route::get('result/upload', 'AdminController@resultupload');
	 Route::get('result/view', 'AdminController@resultlist');
     Route::post('result/save', 'AdminController@resultsave');
	 Route::get('result/delete/{id}', 'AdminController@resultdelete');


  });
  
 
  
  
