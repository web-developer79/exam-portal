
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$data['istrxnsuccess']? 'Registration Successful':'Payment Pending' }}</div>
                <div class="panel-body">
                    <div class="container">
                        @if($data['istrxnsuccess'])
                            <p>Congratulations <label>{{$data['firstname']}}!!!</label></p>
                            <p> You have been successfully registered for <label>Admission cum Scholarship Test</label> of MindPro Academy.</p>
                            <p>Your exam details are as follows: </p>
                            <p></p>
                            <p>Enrollment-ID: <label>{{$data['enrollmentid']}}</label></p>
                            <p>Date of exam: <label>{{$data['examdate']}}</label></p>
                            <p>Time of exam: <label>{{$data['examtime']}}</label></p>
    						<p>Payment Transaction ID: <label>{{$data['txnid']}}</label></p>
    						<p>Payment Status: <label>{{$data['orderstatus']}}</label></p>
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
                        @else
                            <!-- Payment failure -->
                            <p>Dear <label>{{$data['firstname']}}!!!</label></p>
                            <p>You have been successfully registered for <label>Admission cum Scholarship Test</label> of MindPro Academy.</p>
                            <p>Your payment is pending to reserve the seat for test. You can re-initiate the payment, by <a href="{{url('payment-initiate')}}">click here</a></p>
                            <p></p>
                            <p>Enrollment-ID: <label>{{$data['enrollmentid']}}</label></p>
    						<p>Payment Transaction ID: <label>{{$data['txnid']}}</label></p>
    						<p>Payment Status: <label>{{$data['orderstatus']}}</label></p>
                            <p></p>
                            
                            <p>Facing difficulties in registration?<br/> Please call at our online helpline number: 7404500800 between 08:00 am to 08:00 pm</p>
                            
                        @endif
                        <!-- end of trxn -->
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection