@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Upcoming Exam </h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						@if(count($data) == 0)
						<div>
							<h3>WOW !!, You have cleared all your exams and there is no upcoming exams. </h3>
							@else
								<h3>List of upcoming exams</h3>
								@include('student.questionset.upcomingexam-view')
							@endif
						
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