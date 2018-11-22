@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Exam</h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">

    <div class="row">
    <div class="col-lg-12">
        <div class="card"><div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{ url('/student/exam/ongoing') }}">
            {{ csrf_field() }}
            <input class="form-control hidden" id="quessetid" name="quessetid" type="text" value="{{$data['quessetid']}}"/>	
                <div class="form-group">
                    {{$data['title']}}
                </div>
                <hr class="m-t-0 m-b-40">
                <div class="form-group">
                {!! $data['instructions'] !!}    
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button {{ $data['isExamTaken'] ? 'disabled' : '' }} class="btn btn-success">
                            {{ $data['isExamTaken'] ? 'Exam Completed' : 'Start Exam' }}
                        </button>
                    </div>
                </div>
            </form>
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