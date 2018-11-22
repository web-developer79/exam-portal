@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i>Students Exam Result</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                List of students who appeared for exams
              </header>
                @if (count($data) == 0)
                    <h3>No question exists in the exam.</h3>
                @else
                    @include('student.questionset.resultdetail-view')
                @endif
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

@endsection
