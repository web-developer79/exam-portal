@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			@if(session()->has('registermessage'))
					<div class="alert alert-warning">						
						{!! session('registermessage') !!}
					</div>
				@endif
            <div class="panel panel-default">
                <div class="panel-heading">MindPro admission cum scholarship test</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <!--<div class="form-group">
                            <label class="col-md-4  control-label">Registered For</label>
                            <div class="col-md-6">
                                <input type="radio" name="registeredfor" value="mock" /><label for="mock">&nbsp;Mock Test</label>
                                <input type="radio" checked name="registeredfor" value="scholarship" /><label for="scholarship">&nbsp;Admin cum Scholarship Test</label>
                            </div>
                        </div>-->
						 <input id="registeredfor" type="text" class="form-control hidden" name="registeredfor" value="scholarship" />
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group scholarshipview {{ $errors->has('schoolName') ? ' has-error' : '' }}">
                            <label for="schoolname" class="col-md-4 control-label">School Name</label>
                            <div class="col-md-6">
                                <input id="schoolName" type="text" class="form-control" name="schoolName" value="{{ old('schoolName') }}" required autofocus>

                                @if ($errors->has('schoolName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('schoolName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group scholarshipview {{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob" class="col-md-4 control-label">Date of birth (mm/dd/yyyy)</label>
                            <div class="col-md-6">
                                <input id="dob" type="text" name="dob" placeholder="Please enter your date of birth in (mm/dd/yyy) format" value="{{old('dob')}}" class="form-control form-control-line" required autofocus>
                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group scholarshipview">
                            <label for="gender" class="col-md-4 control-label">Gender</label>
                            <div class="col-md-6">
                                <select class="form-control form-control-line" name="gender">
                                    <option value="male" selected >Male</option>
                                    <option value="female" >Female</option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group scholarshipview">
                            <label for="class" class="col-md-4 control-label">Class</label>
                            <div class="col-md-6">
                                <select class="form-control form-control-line" name="current_class">
                                    <option value="8">VIII</option>
                                    <option value="9">IX</option>
                                    <option value="10">X</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group scholarshipview">
                                <label for="class" class="col-md-4 control-label">Exam centre</label>
                                <div class="col-md-6">
                                    <select class="form-control form-control-line" name="prefer_location" id="prefer_location">
                                        <option value="rohtak" selected>Rohtak</option>
                                        <option value="hisar">Hisar</option>
                                    </select>
                                </div>
                            </div>

                        <div class="form-group scholarshipview">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                    <input type="text" id="genaddressder"  name="genaddressder" placeholder="Please enter your street address" value="{{ old('genaddressder') }}" class="form-control form-control-line"/>
                            </div>
                        </div>
                        <div class="form-group scholarshipview {{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input type="text" id="city" name="city" placeholder="Please enter your city" value="{{ old('city') }}" class="form-control form-control-line" /> 
								@if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group scholarshipview {{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input type="text" id="state" name="state" placeholder="Please enter your state" value="{{ old('state') }}" class="form-control form-control-line" /> 
								@if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group scholarshipview{{ $errors->has('pincode') ? ' has-error' : '' }}">
                            <label for="pincode" class="col-md-4 control-label">Pin-Code</label>
                            <div class="col-md-6">
                                <input type="text" id="pincode" name="pincode" placeholder="Please enter your pin-code"  value="{{ old('pincode') }}" class="form-control form-control-line" /> 
								@if ($errors->has('pincode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pincode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="form-group scholarshipview">
                            <label for="exampreferdate" class="col-md-4 control-label">Examination Date</label>
                            <div class="col-md-6">
                                <select class="form-control form-control-line" id="exampreferdate" name="exampreferdate">
                                <option value="" >Please select</option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group scholarshipview">
                            <label for="exampreferslot" class="col-md-4 control-label">Preferred time slot</label>
                            <div class="col-md-6">
                                <select class="form-control form-control-line" id="exampreferslot" name="exampreferslot">
                                    
                                </select> 
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-4 control-label"></span>
                            <div class="col-md-6">
                                <input type="checkbox" onclick="showPassword()"><label for="password-confirm" class="col-md control-label">&nbsp;Show Password</label>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
								@if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						  {{-- <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control" name="username" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  --}}
						
						<div class="form-group{{ $errors->has('mobilenumber') ? ' has-error' : '' }}">
                            <label for="mobilenumber" class="col-md-4 control-label">Mobile Number<sup>#</sup></label>

                            <div class="col-md-6">
                                <input id="mobilenumber" type="mobilenumber" class="form-control" name="mobilenumber"  value="{{ old('mobilenumber') }}" required>

                                @if ($errors->has('mobilenumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobilenumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group scholarshipview{{ $errors->has('altcontactnum') ? ' has-error' : '' }}">
                            <label for="altcontactnum" class="col-md-4 control-label">Alt. Mobile No.</label>
                            <div class="col-md-6">
                                <input type="text" id="altcontactnum" name="altcontactnum" placeholder="Please enter your alternate mobile number"  value="{{ old('altcontactnum') }}" class="form-control form-control-line" /> 
								@if ($errors->has('altcontactnum'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('altcontactnum') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group" style="font-size:12px;">
                            <label for="mobilenumber" class="col-md-4 control-label"></label>
                            <div class="col-md-8">
                                Note: All fields are mandatory<br/>
                                <sup>#</sup> An OTP(One Time Password) will be sent for account verification<br/>
                                Password Complexity: 1 upper case, 1 lower case, 1 special case, 1 digit with total length of 6-14 chars.
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{Html::script("js/jquery-1.8.3.min.js")}}
<script>
function showPassword() {
		var x = document.getElementById("password");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}

    $(document).ready(function () {
        getTimeSlot();
        //$('.scholarshipview').hide();
        $('input[type=radio][name=registeredfor]').change(function() {
            if (this.value == 'mock') {
                $('.scholarshipview').hide();
                $('#schoolName').attr("required", false);
				$('#dob').attr("required", false);
            }
            else if (this.value == 'scholarship') {
                $('.scholarshipview').show();
                $('#schoolName').attr("required", true);
				$('#dob').attr("required", true);
            }
        });
    });
    // Call the delete slot
    function getTimeSlot(){
        var location=$("select#prefer_location").children("option:selected").val();
         $.ajax({
            type:'GET',
            url:"{{url('/timeslot/list/view')}}" + "/"+location,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){ 
                $('#exampreferdate').empty();
              $.each(data.details, function(key, value) {                
                $('#exampreferdate')
                    .append($("<option></option>")
                                .attr("value",value['id'])
                                .text(value['date'])); 
                });
                getSlot();
            }
         });
    } 
    $(document).ready(function(){
        $("select#prefer_location").change(function(){
            getTimeSlot();
        });

        $("select#exampreferdate").change(function(){
            getSlot();
        });
    });
    function getSlot(){
        
        var id = $("select#exampreferdate").children("option:selected").val();
         $.ajax({
            type:'GET',
            url:"{{url('slot/list/')}}"+ "/" + id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){   
                $('#exampreferslot').empty();                          
              $.each(data.details, function(key, value) { 
                 if(value['id'] !=0)
                 {                    
                    $('#exampreferslot')
                    .append($("<option></option>")
                                .attr("value",value['id'])
                                .text(value['from']+'-'+value['to']));
                 }  
                
                });
            }
         });
    }
</script>
