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
                            <label for="enrollmentid" class="col-md-4 control-label">Enrollment-ID</label>
                            <div class="col-md-6">
                                <span id="vwenrollmentid"></span>
                            </div>
                        </div>

                         <div class="form-group viewdetails">
                            <label for="name" class="col-md-4 control-label">Full Name</label>
                            <div class="col-md-6">
                                <span id="fullname"></span>
                            </div>
                        </div>

                        <div class="form-group viewdetails">
                            <label for="class" class="col-md-4 control-label">Class</label>
                            <div class="col-md-6">
                                <span id="class"></span>
                            </div>
                        </div>

                        <div class="form-group viewdetails">
                            <label for="schoolname" class="col-md-4 control-label">School Name</label>
                            <div class="col-md-6">
                                <span id="schoolname"></span>
                            </div>
                        </div>
                        
                        <div class="form-group viewdetails">
                            <label for="examdate" class="col-md-4 control-label">Exam Date</label>
                            <div class="col-md-6">
                                <span id="examdate"></span>
                            </div>
                        </div>
						
						<div class="form-group viewdetails">
                            <label for="examlocation" class="col-md-4 control-label">Exam Location</label>
                            <div class="col-md-6">
                                <span id="examlocation"></span>
                            </div>
                        </div>
                        <div class="form-group viewdetails">
                            <label for="rank" class="col-md-4 control-label">Rank</label>
                            <div class="col-md-6">
                                <span id="rank"></span>
                            </div>
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
