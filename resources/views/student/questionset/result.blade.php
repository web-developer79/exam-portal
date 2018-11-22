@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Result</h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">

<div class="row">
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-certificate f-s-40 color-primary"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['quesTotal']}}</h2>
                    <p class="m-b-0">Total Questions</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-balance-scale f-s-40 color-success"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['quesAttempt']}}</h2>
                    <p class="m-b-0">Questions Attempted</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-check f-s-40 color-success"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['quesCorrect']}}</h2>
                    <p class="m-b-0">Correct Answers</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-times f-s-40 color-danger"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['quesAttempt']-$data['quesCorrect']}}</h2>
                    <p class="m-b-0">Incorrect Answers</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-certificate f-s-40 color-primary"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{ $data['scoreTotal']}}</h2>
                    <p class="m-b-0">Total Exam Score </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-balance-scale f-s-40 color-success"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['scoreAttempt']}}</h2>
                    <p class="m-b-0">Exam Score Attempted</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-check f-s-40 color-success"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['scoreCorrect']}}</h2>
                    <p class="m-b-0">Corrected Answers Score</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-bullseye f-s-40 color-danger"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['finalMark']}}</h2>
                    <p class="m-b-0">Final Score</p>
                </div>
            </div>
        </div>
    </div>
<!-- Progress bar start -->

<div class="col-md-12 p-r-40 m-t-30 m-b-30">
    <h5 class="m-t-30">
        <a href="{{url('student/exam/resultdetail/'.$data['questionPaperId'])}}">
        {{$data['result']}}</a><span class="pull-right">{{$data['percentage']}}%</span></h5>
    <div class="progress ">
        <div class="progress-bar wow animated progress-animated {{$data['isExamPass']? 'bg-success': 'bg-danger'}}" style="width: {{$data['percentage']}}%; height:6px;" role="progressbar"> 
            <span class="sr-only">{{$data['percentage']}}% Complete</span> </div>
    </div>
</div>

    </div>
</div>

	</div>
	<!-- End Container fluid  -->
	<!-- footer -->
	@include('student.footer-message')
	<!-- End footer -->
</div>
<!-- End Page wrapper  -->

@endsection

<script>
         jQuery(document).ready(function(){
            jQuery('.btn-success.next').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/student/exam/ongoingExamquestion') }}",
                  method: 'post',
                  data: {
                     quesid: jQuery('.quesdiv').attr('data-id'),
                     studentquesid: jQuery('.quesdiv').attr('data-studentquesid'),
                     ansid: jQuery('input[name=rbtnCount]:checked').val(),
                     currpage: jQuery('.quesdiv').attr('data-currpage')
                    // price: 'hi'
                  },
                  success: function(result){
                     console.log(result);
                  }});
               });
            });
</script>