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
                <div class="panel-heading">Registration Successful</div>

                <div class="panel-body">
                    {{--@include('emails.register-welcome', ['name' => $data['name'], 'examdate' => $data['examdate'], 'examtime' => $data['examtime'], 'isexaminrohtak' => $data['isexaminrohtak'] ]) --}}
                    <div class="container">
                        
                        <p>Congratulations <label>{{$data['name']}}!!!</label></p>
                        
                        <p> You have been successfully registered for <label>Admission cum Scholarship Test </label> of MindPro Academy.</p>
                        <p>Your exam details are as follows: </p>
                        <p></p>
                        <p>Enrollment-ID: <label>{{$data['enrollmentid']}}</label></p>
                        <p>Date of exam: <label>{{$data['examdate']}}</label></p>
                        <p>Time of exam: <label>{{$data['examtime']}}</label></p>
                        <p></p>
                        <p> Test Centre: <br/><label>MindPro Academy<br/>
                        @if($data['isexaminrohtak'])
                        Office - A, 1<sup>st</sup> floor, above ICICI Bank<br/>Ashoka Plaza<br/> Rohtak -124001
                        @else
                        2<sup>nd</sup> Floor, S.C.O. 56-P, Mezbaan Complex,<br/>Above Axis Bank, Sector - 13<br/> Hisar - 125004
                        @endif
                        <br/>Haryana</label></p>
                        <p> Contact: <label>
                        @if($data['isexaminrohtak'])
                        +91-7404500800, 01262-253800</p>
                        @else 
                        91-7404500700, 01662-246700</p>
                        </label>
                        @endif
                        <p>Note:</p>
                        <ol>
                        <li>Please reach test centre 30 mins prior of the scheduled exam time.</li>
                        <li>Please carry <b>ID-proof</b> & <b>Print-out of this screen</b></li>
                        </ol>
                        </div>
                    
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
         $.ajax({
            type:'GET',
            url:"{{url('/timeslot/list/view')}}",
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){                
              $.each(data.details, function(key, value) {                
                $('#exampreferdate')
                    .append($("<option></option>")
                                .attr("value",value['id'])
                                .text(value['date'])); 
                });
            }
         });
    } 
    $(document).ready(function(){
        $("select#exampreferdate").change(function(){
            var timeslotid = $(this).children("option:selected").val();           
            getSlot(timeslotid);
        });
    });
    function getSlot(id){
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
