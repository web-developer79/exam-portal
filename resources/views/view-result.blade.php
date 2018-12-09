@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(session()->has('pymntinitmsg'))
					<div class="alert alert-warning">						
						{!! session('pymntinitmsg') !!}
					</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading">MindPro Admission cum Scholarship exam result</div>

                <div class="panel-body">
                    
                    <div class="form-horizontal" >
                        <div class="form-group ">
                            <label for="enrollmentid" class="col-md-4 control-label">Enrollment-ID</label>
                            <div class="col-md-6">
                                <input id="enrollmentid" name="enrollmentid" type="text" class="form-control" placeholder="Please enter your enrollment id" required autofocus>
                            </div>
                        </div>
                    	<div class="form-group">
                            <label for="mobilenumber" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobilenumber" type="mobilenumber" class="form-control" placeholder="Please enter your registered mobile number" name="mobilenumber" required autofocus>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" onclick="fetchDetails();">
                                    View Result
                                </button>
                                <button type="submit" class="btn btn-primary" onclick="reset();">
                                    Reset
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group viewdetails">
                            <label class="col-md-12 ">Congratulations <span id="fullname"></span>!!! <br/> 
							Visit to MindPro Academy for detail analysis of performance and for career counselling.</label>
                        </div>

						<div class="form-group viewdetails">
                            <label class="col-md-4 control-label" style="font-weight:normal;" >Enrollment-ID</label>
							<label class="col-md-6 control-label" style="text-align:left;" id="vwenrollmentid"></label>
                        </div>

                        <div class="form-group viewdetails">
                            <label for="class" class="col-md-4 control-label" style="font-weight:normal;">Class</label>
                            <label class="col-md-6 control-label" style="text-align:left;"  id="class"></label>
                        </div>

                        <div class="form-group viewdetails">
                            <label for="schoolname" class="col-md-4 control-label" style="font-weight:normal;" >School Name</label>
                            <label class="col-md-6 control-label" style="text-align:left;"  id="schoolname"></label>
                        </div>
                        
						{{-- 
                        <div class="form-group viewdetails">
                            <label for="examdate" class="col-md-4 control-label" style="font-weight:normal;" >Exam Date</label>
                            <label class="col-md-6 control-label" style="text-align:left;"  id="examdate"></label>
                        </div>
						--}}
						<div class="form-group viewdetails">
                            <label for="examlocation" class="col-md-4 control-label" style="font-weight:normal;" >Exam Location</label>
                            <label class="col-md-6 control-label" style="text-align:left;"  id="examlocation"></label>
							
                        </div>
                        <div class="form-group viewdetails">
                            <label for="rank" class="col-md-4 control-label" style="font-weight:normal;" >Rank</label>
                            <label class="col-md-6 control-label" style="text-align:left;"  id="rank"></label>
                        </div>

						<div class="form-group viewdetails">
                            <label class="col-md-4 control-label" style="font-weight:normal;" ></label>
                            <button type="submit" class="btn btn-primary" id="bookappointment" onclick="bookAppointment();">
                                    Book Appointment
                            </button>
							
							<label class="col-md-12 " id="bookAppointmentMessage"></label>
                        </div>
						

                       </div> 
                     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{Html::script("js/jquery-1.8.3.min.js")}}
<script>
    $(document).ready(function () {
        $('.viewdetails').hide();
        
    });

	function reset() {
        $('.viewdetails').hide();
		$("#enrollmentid").val("");
		$("#mobilenumber").val("");
	}

	function bookAppointment() {

        var enrollmentid=$("#enrollmentid").val();
        var mobile=$("#mobilenumber").val();
        if(enrollmentid == '' || mobile==''){
            alert("Please provide the enrollment-id and mobile number to get details");
            return;
        }
        
         $.ajax({
            type:'GET',
            url:"{{url('/bookappointment')}}" + "/"+enrollmentid+"/"+mobile,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data, textStatus, xhr){
                if(xhr.status==200){
					var details=data.details;
					$('#bookAppointmentMessage').show();
					$('#bookappointment').hide();
                    $("#bookAppointmentMessage").text(details.bookingmessage);
                } else if(xhr.status==201) {
                    alert(data.message);
                }
            }
         });
	}

    function fetchDetails(){
        
        $('.viewdetails').hide();
        $('#btnPay').hide();
        var enrollmentid=$("#enrollmentid").val();
        var mobile=$("#mobilenumber").val();
        if(enrollmentid == '' || mobile==''){
            alert("Please provide the enrollment-id and mobile number to get details");
            return;
        }
        
         $.ajax({
            type:'GET',
            url:"{{url('/fetchresult')}}" + "/"+enrollmentid+"/"+mobile,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data, textStatus, xhr){
                if(xhr.status==200){
                $('.viewdetails').show();
                    var details=data.details;
                    $("#fullname").text(details.fullname);
                    $("#schoolname").text(details.schoolname);
                    $("#class").text(details.class);
                    $("#rank").text(details.rank);
					$("#examdate").text(details.examdate);
					$("#examlocation").text(details.examlocation);
                    $("#vwenrollmentid").text(enrollmentid);
					$("#bookAppointmentMessage").text(details.bookingmessage);

					if(details.isbookingdone == 1) {
						$('#bookAppointmentMessage').show();
						$('#bookappointment').hide();
					} else {
						$('#bookAppointmentMessage').hide();
						$('#bookappointment').show();
					}
					
                } else if(xhr.status==201) {
                    alert(data.message);
                }
            }
         });
    }
    
    function submitFrm(){
        document.forms.frmPayProcess.submit();
    }
</script>
