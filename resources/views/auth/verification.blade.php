<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			@if(session()->has('verificationmessage'))
					<div class="alert alert-warning">						
						{!! session('verificationmessage') !!}
					</div>
				@endif
            <div class="panel panel-default">
                <div class="panel-heading">Verification</div>
					
                <div class="panel-body">
                    <form class="form-horizontal otp" method="POST" action="{{ url('/user/verification') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile Number</label>
                            <div class="col-md-6">
                                <label class="col-md-4 control-label">{{$data['mobilenumber']}}</label>
                            </div>
							<a><div class="mobnumber">Edit Number</div></a>
                        </div>

                        <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                            <label for="otp" class="col-md-4 control-label">OTP</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control" name="otp" required autofocus>

                                @if ($errors->has('otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>    

							<div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button> 

                                <a href="{!! url('/user/resendotp') !!}">Resend OTP</a>                               
                            </div>
                        </div>
                    </form>
					
					
					<form class="form-horizontal updatenumber" method="POST" action="{{ url('/user/updatemobilenumber') }}" style="display:none;">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('mobilenumber') ? ' has-error' : '' }}">
                            <label for="mobilenumber" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobilenumber" type="text" class="form-control" name="mobilenumber" required autofocus>                                
                            </div>
                        </div>    
							<div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
<script>
jQuery(document).ready(function(){
	jQuery('.mobnumber').on('click',function(){
		jQuery('.form-horizontal.otp').hide();
		jQuery('.alert-warning').hide();
        jQuery('.form-horizontal.updatenumber').show();
        
	});
});
</script>
