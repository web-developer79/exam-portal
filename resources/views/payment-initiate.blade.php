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
                <div class="panel-heading">Make Payment</div>

                <div class="panel-body">
                    
                    <div class="form-horizontal" >
                        <div class="form-group ">
                            <label for="enrollmentid" class="col-md-4 control-label">Enrollment-ID</label>
                            <div class="col-md-6">
                                <input id="enrollmentid" name="enrollmentid" type="text" class="form-control" required autofocus>
                            </div>
                        </div>
                    	<div class="form-group">
                            <label for="mobilenumber" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobilenumber" type="mobilenumber" class="form-control" name="mobilenumber" required autofocus>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" onclick="fetchDetails();">
                                    Fetch Details
                                </button>
                            </div>
                        </div>
                        
                        
                         <div class="form-group viewdetails">
                            <label for="name" class="col-md-4 control-label">Full Name</label>
                            <div class="col-md-6">
                                <span id="fullname"></span>
                            </div>
                        </div>
                        <div class="form-group viewdetails">
                            <label for="schoolname" class="col-md-4 control-label">School Name</label>
                            <div class="col-md-6">
                                <span id="schoolname"></span>
                            </div>
                        </div>
                        
                        <div class="form-group viewdetails">
                            <label for="dob" class="col-md-4 control-label">Date of birth</label>
                            <div class="col-md-6">
                                <span id="dob"></span>
                            </div>
                        </div>
                         
                        <div class="form-group viewdetails">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <span id="email"></span>
                            </div>
                        </div>
                       
                       <form class="form-horizontal " method="POST" action="{{ url('payment-process') }}" name="frmPayProcess">
                            {{csrf_field()}}
                             <input id="frm_enrollmentid" name="enrollmentid" type="text" class="form-control hidden">
                             <input id="frm_mobile" name="mobile" type="text" class="form-control hidden">
                             <input id="frm_fullname" name="fullname" type="text" class="form-control hidden">
                             <div class="form-group">
                                <div class="col-md-6 col-md-offset-4 viewdetails">
                                    <button type="submit" class="btn btn-primary" onclick="submitFrm()" id="btnPay">
                                        Pay
                                    </button>
                                </div>
                            </div>
                       </form> 
                        
                        
                        
                       
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
        $('#btnPay').hide();
        
    });
    
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
            url:"{{url('/fetchdetails')}}" + "/"+enrollmentid+"/"+mobile,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data, textStatus, xhr){
                if(xhr.status==200){
                $('.viewdetails').show();
                    var details=data.details;
                    $("#fullname").text(details.fullname);
                    $("#schoolname").text(details.schoolname);
                    $("#dob").text(details.dob);
                    $("#email").text(details.email);
                    $("#frm_enrollmentid").val(enrollmentid);
                    $("#frm_mobile").val(mobile);
                    $("#frm_fullname").val(details.fullname);
                    $('#btnPay').show();
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
