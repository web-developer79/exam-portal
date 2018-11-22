@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">

@if(session()->has('studentdashbordmsg'))
<div class="row">
  <div class="col-lg-12">        
    <div class="alert alert-warning">
			<div class="alert alert-warning">
				{!! session('studentdashbordmsg') !!}
			</div>
    </div>
  </div>
</div>
@endif


@if ((bool)env('APP_MODE_DEVELOPMENT', false))
	@include('student.dashboard-view')
@else
	@include('student.development.dashboard')
@endif


	</div>
	<!-- End Container fluid  -->
@include('student.footer-message');
</div>
<!-- End Page wrapper  -->
@endsection