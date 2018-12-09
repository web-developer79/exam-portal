@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text"></i>View Result</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Result uploaded for {{count($studentresults)}} students
              </header>
				@if(session()->has('resultlistmessage'))
					<div class="alert alert-success">
						{{ session()->get('resultlistmessage') }}
					</div>
				@endif
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th> Enrollment ID</th>
                    <th> Mobile Number</th>
                    <th> Student Name</th>
                    <th> School Name</th>
                    <th> Class</th>
                    <th> Rank</th>
                    <th> Exam Center</th>
                    <th> Exam Date</th>
					<th> Appointment Status</th>
                    <th> Delete</th>
                  </tr>
                  
                  @foreach ($studentresults as $studres)
                  <tr>
                    <td>{{ $studres['enrollmentid'] }}</td>
                    <td>{{ $studres['mobilenumber'] }}</td>
                    <td>{{ $studres['studentname'] }}</td>
                    <td>{{ $studres['schoolname'] }}</td>
					<td>{{ $studres['class'] }}</td>
                    <td>{{ $studres['rank'] }}</td>
                    <td>{{ $studres['examlocation'] }}</td>
                    <td>{{ $studres['examdate'] }}</td>
                    <td>{{ $studres['isbookingdone'] == 1? "Booked":"-" }}</td>
                    <td><a onclick="return confirmDelete();" class="btn btn-danger" href="{{url ('admin/result/delete/'.$studres['id'])}}">
                              <i class="icon_minus_alt2"></i>
                        </a>
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

@endsection