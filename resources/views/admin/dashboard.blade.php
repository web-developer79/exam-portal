@extends('admin.layout')
@section('body')

<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
            {{-- <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>
            </ol> --}}
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
              <i class="fa fa-users"></i>
              <div class="count"><a href="{{ url('/admin/student/list') }}">{{$dashboardData['totalStudents']}}</a></div>
              <div class="title">Students</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <i class="fa fa-file-text"></i>
              <div class="count"><a href="{{ url('/admin/questionset/list') }}">{{$dashboardData['totalQuestionSets']}}</a></div>
              <div class="title">Question Set</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-list"></i>
              <div class="count">{{$dashboardData['totalExamsDone']}}</div>
              <div class="title">Exam Conducted</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->
        </div>
        <!--/.row-->
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h2><i class="fa fa-flag-o red"></i><strong>Statistics</strong></h2>
                <div class="panel-actions">
                </div>
              </div>
              <div class="panel-body">
                <table class="table bootstrap-datatable countries">
                  <thead>
                    <tr>
                      <th width="40%">Stats of</th>
                      <th width="10%">Total</th>
                      <th width="10%"></th>
                      <th width="10%"></th>
                      <th width="30%">Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Registered Students</td>
                      <td>{{$dashboardData['verifiedStudentsNum'] + $dashboardData['unVerifiedStudentsNum']}}</td>
                      <td>Verified: {{$dashboardData['verifiedStudentsNum']}}</td>
                      <td>Un-verified: {{$dashboardData['unVerifiedStudentsNum']}}</td>
                      <td>
                        <div class="progress thin">
                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow={{$dashboardData['verifiedStudentsPer']}} style="width: {{$dashboardData['verifiedStudentsPer']}}%">
                          </div>
                          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$dashboardData['verifiedStudentsPer']}}" style="width: {{100-$dashboardData['verifiedStudentsPer']}}%">
                          </div>
                        </div>
                        {{-- <span class="sr-only">{{$dashboardData['verifiedStudentsPer']}}%</span> --}}
                      </td>
                    </tr>
                    <tr>
                      <td>Students Result (Pass vs Fail)</td>
                      <td>{{$dashboardData['passStudentsNum'] + $dashboardData['failStudentsNum']}}</td>
                      <td>Pass: {{$dashboardData['passStudentsNum']}}</td>
                      <td>Fail: {{$dashboardData['failStudentsNum']}}</td>
                      <td>
                        <div class="progress thin">
                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$dashboardData['passStudentsPer']}}" style="width: {{$dashboardData['passStudentsPer']}}%">
                          </div>
                          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$dashboardData['passStudentsPer']}}" style="width: {{100-$dashboardData['passStudentsPer']}}%">
                          </div>
                        </div>
                        {{-- <span class="sr-only">{{$dashboardData['passStudentsPer']}}%</span> --}}
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>

            </div>

          </div>
          <!--/col-->

        </div>
        <!-- statics end -->
      </section>
      <div class="text-right">
        <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Designed by <a href="javascript:void(0)">NH</a>
        </div>
      </div>
    </section>
    <!--main content end-->
@endsection