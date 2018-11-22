@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text"></i>View Question set(s)</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                List of question set 
              </header>
				@if(session()->has('questionsetmessge'))
					<div class="alert alert-success">
						{{ session()->get('questionsetmessge') }}
					</div>
				@endif
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th> Title</th>
                    <th> Description</th>
                    <th> Num Of Questions</th>
                    <th> Total Questions</th>
                    <th> Level</th>
                    <th> Passing Score</th>
                    <th> Time(mts)</th>
                    <th> Edit</th>
                    <th> Delete</th>
                    <th> Add Question</th>
                    <th> Question List</th>
                    <th> Ready</th>

                  </tr>
                  
                  @foreach ($quessets as $qs)
                  <tr>
                    <td>{{$qs['title']}}</td>
                    <td>{!! $qs['description'] !!}</td>
                    <td>{{$qs['numofques']}}</td>
                    <td>{{$qs['totalques']}}</td>
                    <td>{{$qs['level']}}</td>
                    <td>{{$qs['passnum']}}</td>
                    <td>{{$qs['time']}}</td>
                    
                    <td><a class="btn btn-warning" href="{{url ('admin/questionset/edit/'.$qs['id'])}}">
                              <i class="icon_pencil-edit_alt"></i>
                        </a>
                    </td>
                    <td><a onclick="return confirmDelete();" class="btn btn-danger" href="{{url ('admin/questionset/delete/'.$qs['id'])}}">
                              <i class="icon_minus_alt2"></i>
                        </a>
                    </td>
                    <td><a class="btn btn-primary" href="{{url ('admin/question/create/'.$qs['id'])}}">
                              <i class="icon_plus_alt2"></i>
                        </a>
                    </td>
                    <td><a class="btn btn-primary" href="{{url ('admin/question/list/'.$qs['id'])}}">
                              <i class="icon_ol"></i>
                        </a>
                    </td>
                    <td>
                        @if ($qs['totalques'] > $qs['numofques'])
                            {{-- <a class="btn btn-success" href=""> --}}
                              <i class="icon_check_alt2"></i>
                            {{-- </a> --}}
                        @else
                            {{-- <a class="btn btn-danger" href="#"> --}}
                              <i class="icon_close_alt2"></i>
                            {{-- </a> --}}
                        @endif
                      
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