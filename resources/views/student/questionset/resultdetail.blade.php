@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Result Details</h3> </div>
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
							<br/>
							<h3>It seems, there is no question in the questionset. </h3>
							@else
								@include('student.questionset.resultdetail-view')
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