@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-upload"></i> Result</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Upload result
              </header>
              <div class="panel-body">
                <div class="form">
				@if(session()->has('questionsetmessge'))
					<div class="alert alert-success">
						{{ session()->get('questionsetmessge') }}
					</div>
				@endif
                  <form class="form-validate form-horizontal" enctype="multipart/form-data" id="form_questionset" method="post" action="{{ url('/admin/result/save') }}">
				  {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                                    @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
					  @if( isset($data['id']) )
						  <button class="btn btn-primary" type="submit">Update</button>
					  @else
						  <button class="btn btn-primary" type="submit">Save</button>
					  @endif      
            <a class="btn btn-default" href="{{url('admin/questionset/list')}}" type="button">Cancel</a>                  
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
    @endsection