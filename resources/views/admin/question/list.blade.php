@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text"></i> Questions List</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Question Set: {{$data['qsDetails']['title']}}
              </header>
				@if(session()->has('messgeSuccess'))
					<div class="alert alert-success">
						{{ session()->get('messgeSuccess') }}
					</div>
				@endif
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th> Question</th>
                    <th> Question Type</th>
                    <th> Edit</th>
                    <th> Delete</th>
                    <th> Add Question</th>
                  </tr>
                  @foreach ($data['questions'] as $qs)
                  <tr>
                    <td>{!! $qs['question'] !!}</td>
                    <td>{{$qs['questiontype']}}</td>
                    <td><a class="btn btn-warning" href="{{url ('admin/question/edit/'.$qs['id'])}}">
                              <i class="icon_pencil-edit_alt"></i>
                        </a>
                    </td>
                    <td><a class="btn btn-danger" onclick="return confirmDelete();" href="{{url ('admin/question/delete/'.$qs['id'])}}">
                              <i class="icon_minus_alt2"></i>
                        </a>
                    </td>
                    <td><a class="btn btn-primary" href="{{url ('admin/question/create/'.$qs['qsid'])}}">
                              <i class="icon_plus_alt2"></i>
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