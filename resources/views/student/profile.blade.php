@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Profile</h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Profile</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="card-body">
                    @if(session()->has('manageprofile'))
                        <div class="alert alert-success">
                            {{ session()->get('manageprofile') }}
                        </div>
                    @endif
                        <form class="form-horizontal" method="POST" action="{{ url('/student/update-profile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-6">
                                        <label for="name" class="col-md-4 control-label">Full Name</label>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="{{$data['name']}}" required autofocus>
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif    
                                        </div>
                                </div>
                                <div class="form-group col-md-6">
                                        <label for="enroll" class="col-md-12">Enrollment ID</label>
                                        <div class="col-md-12">
                                            <input id="email" disabled type="email" name="email" placeholder="{{$data['enrollmentid']}}" class="form-control" value="{{$data['enrollmentid']}}" autofocus/>
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input id="email" type="email" name="email" placeholder="{{$data['email']}}" class="form-control" value="{{$data['email']}}" name="example-email" required autofocus/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile" class="col-md-12">Mobile</label>
                                        <div class="col-md-12">
                                            <input id="mobile" type="text" name="mobilenumber" placeholder="{{$data['mobilenumber']}}" value="{{$data['mobilenumber']}}" class="form-control" required autofocus/>
                                            @if ($errors->has('mobilenumber'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('mobilenumber') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3">Registered For</label>
                                <input type="radio" name="registeredfor" value="mock" @if($data['registeredfor']=='mock') checked @endif disabled /><label for="mock">&nbsp;Mock Test</label>
                                &nbsp;&nbsp;
                                <input type="radio" name="registeredfor" value="scholarship" @if( $data['registeredfor']=='scholarship') checked @endif disabled /><label for="scholarship">&nbsp;Scholarship Test</label>
                               
                            </div>
                           

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="altmob" class="col-md-12">Alternate Mobile No.</label>
                                        <div class="col-md-12">
                                                <input id="altmob" type="text" name="altermobilenumber" placeholder="{{ $data['altermobilenumber']== '' ? 'Please enter your alternate mobile number': ''  }}" value="{{$data['altermobilenumber']}}" class="form-control form-control-line" required autofocus>
                                                @if ($errors->has('altermobilenumber'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('altermobilenumber') }}</strong>
                                                    </span>
                                                @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="dob" class="col-md-12">Date of Birth</label>
                                        <div class="col-md-12">
                                                <input id="dob" type="date" name="dob" placeholder="{{ $data['dob']== '' ? 'Please enter your date of birth': ''  }}" value="{{$data['dob']}}" class="form-control form-control-line" required autofocus>
                                                @if ($errors->has('dob'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('dob') }}</strong>
                                                    </span>
                                                @endif 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="fatherName" class="col-md-12">Father Name</label>
                                            <div class="col-md-12">
                                                    <input id="fatherName" type="text" name="fatherName" placeholder="{{ $data['fatherName']== '' ? 'Please enter your father name': ''  }}" value="{{$data['fatherName']}}" class="form-control form-control-line">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="fatherOccupation" class="col-md-12">Father Occupation</label>
                                            <div class="col-md-12">
                                                    <input id="fatherOccupation" type="text" name="fatherOccupation" placeholder="{{ $data['fatherOccupation'] == '' ? 'Please enter your father occupation': ''  }}" value="{{$data['fatherOccupation']}}" class="form-control form-control-line">    
                                            </div>
                                        </div>
                                    </div>
                            </div>

							<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label class="col-md-12">Gender</label>
                                            <div class="col-md-12">
                                            	<select class="form-control form-control-line" name="gender">
                                            		<option value="" {{ $data['gender'] == '' ? 'selected': '' }}>Please select</option>
	                                           		<option value="male" {{ $data['gender'] == 'male' ? 'selected': '' }} >Male</option>
	                                           		<option value="female" {{ $data['gender'] == 'female' ? 'selected': '' }}>Female</option>
	                                        	</select>
                                                @if ($errors->has('gender'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label class="col-md-12">Currently studying in</label>
                                            <div class="col-md-12">
                                                 <select class="form-control form-control-line" name="current_class">
                                            		<option value="" {{ $data['current_class'] == '' ? 'selected': '' }}>Please select</option>
	                                           		<option value="8" {{ $data['current_class'] == '8' ? 'selected': '' }} >VIII</option>
	                                           		<option value="9" {{ $data['current_class'] == '9' ? 'selected': '' }}>IX</option>
	                                           		<option value="10" {{ $data['current_class'] == '10' ? 'selected': '' }}>X</option>
	                                        	</select> 
                                                @if ($errors->has('current_class'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('current_class') }}</strong>
                                                    </span>
                                                @endif    
                                            </div>
                                        </div>
                                    </div>
                            </div>
                           
                           <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="genaddressder" class="col-md-12">Address</label>
                                            <div class="col-md-12">
                                                  <input type="text" id="genaddressder"  name="genaddressder" placeholder="{{ $data['genaddressder']== '' ? 'Please enter your street address': ''  }}" value="{{$data['genaddressder']}}"  class="form-control form-control-line"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                 <label for="city" class="col-md-12">City</label>
                                            <div class="col-md-12">
                                                    <input id="city" type="text" name="city" placeholder="{{ $data['city'] == '' ? 'Please enter your city': ''  }}" value="{{$data['city']}}" class="form-control form-control-line">    
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            
                             <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="state" class="col-md-12">State</label>
                                            <div class="col-md-12">
                                                  <input id="state" type="text" name="state" placeholder="{{ $data['state']== '' ? 'Please enter your state': ''  }}" value="{{$data['state']}}"  class="form-control form-control-line"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                 <label for="pincode" class="col-md-12">Pin Code</label>
                                            <div class="col-md-12">
                                                    <input id="pincode" type="text" name="pincode" placeholder="{{ $data['pincode'] == '' ? 'Please enter your pin code': ''  }}" value="{{$data['pincode']}}" class="form-control form-control-line">    
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="schoolName" class="col-md-12">School Name</label>
                                <div class="col-md-6">
                                    <input id="schoolName" type="text" name="schoolName" placeholder="School Name" value="{{$data['schoolName']}}" class="form-control form-control-line" required autofocus>
                                    @if ($errors->has('schoolName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('schoolName') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="schoolAddress" class="col-md-12">School Address</label>
                                <div class="col-md-12">
                                    <input id="schoolAddress" type="text" name="schoolAddress" placeholder="School Address" value="{{$data['schoolAddress']}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label class="col-md-3">How did you know about MindPro?</label>
                                    <div class="col-md-9">
                                        <select class="form-control col-md-9" name ="source" id="source">
                                        	<option value =''>Please select</option>
                                            <option value="online" @if( $data['source']=='online') selected @endif>Online promotion</option>
                                            <option value="door" @if( $data['source']=='door') selected @endif>Door to door activity</option>
                                            <option value="ntse" @if( $data['source']=='ntse') selected @endif>NTSE Workshop</option>
                                            <option value="other" @if( $data['source']=='other') selected @endif>Other</option>
                                        </select>
                                        @if($data['source'] == 'other')
                                        	<input type="text" name="sourcedetail" value="{{$data['sourcedetail']}}" class="col-md-3 form-control sourcedetail" />
                                            @else
                                            <input type="text" name="sourcedetail" style="display:none;" value="{{$data['sourcedetail']}}" class="col-md-3 form-control sourcedetail" />
                                        @endif
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="col-md-12">Upload photo</label>
                                <div class="col-md-12 row">
                                    <input type="file" name="photo" class="col-md-6 form-control form-control-line">
                                    <input type="hidden" name="profilepic" class="form-control form-control-line" />
                                    @if($data['profilepic'] != "")
                                    	<img style="padding-left:20px;" src="{{ $data['profilepic'] }}" height="150px" width="150px" />
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Update Profile</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content ends -->
	</div>
	<!-- End Container fluid  -->
	<!-- footer -->
	@include('student.footer-message')
	<!-- End footer -->
</div>
<!-- End Page wrapper  -->

@endsection
