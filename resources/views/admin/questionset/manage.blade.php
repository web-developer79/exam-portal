@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-files-o"></i> Question Set</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Create/Update Question Set(Paper)
              </header>
              <div class="panel-body">
                <div class="form">
				@if(session()->has('questionsetmessge'))
					<div class="alert alert-success">
						{{ session()->get('questionsetmessge') }}
					</div>
				@endif
                  <form class="form-validate form-horizontal" id="form_questionset" method="post" action="{{ url('/admin/questionset/save') }}">
				  {{ csrf_field() }}
					@if( isset($data['id']) )						
							<input class="form-control hidden" id="quesid" name="quesid" type="text" value="{{$data['id']}}"/>						
					@endif
                    <div class="form-group ">
                      <label for="title" class="control-label col-lg-2">Title <span class="required">*</span></label>
                      <div class="col-lg-10">
					  @if ($errors->has('title'))
						<div class="error">{{ $errors->first('title') }}</div>
					  @endif
                        <input class="form-control" id="title" name="title" minlength="5" type="text" value="@if(isset($data['title'])){{$data['title']}} @endif" required />
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="description" class="control-label col-lg-2">Description <span class="required">*</span></label>
                      <div class="col-lg-10">
						@if ($errors->has('description'))
							<div class="error">{{ $errors->first('description') }}</div>
						@endif
                        <textarea class="form-control ckeditor" id="description" name="description" required> @if(isset($data['description'])){{$data['description']}} @endif</textarea>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="numofques" class="control-label col-lg-2">Number of Questions <span class="required">*</span></label>
                      <div class="col-lg-10">
						@if ($errors->has('numofques'))
							<div class="error">{{ $errors->first('numofques') }}</div>
						@endif
                        <input class="form-control " id="numofques" name="numofques" type="text" value="@if(isset($data['numofques'])){{$data['numofques']}} @endif" required />
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="level" class="control-label col-lg-2">Level <span class="required">*</span></label>
                      <div class="col-lg-10">
						@if ($errors->has('level'))
							<div class="error">{{ $errors->first('level') }}</div>
						@endif
                        <select class="form-control " id="level" name="level" required >
                          <option value="1" @if(isset($data['level']) && $data['level'] =='1')selected="selected" @endif >First</option>
                          <option value="2" @if(isset($data['level']) && $data['level'] =='2')selected="selected" @endif>Second</option>
                          <option value="3" @if(isset($data['level']) && $data['level'] =='3')selected="selected" @endif>Third</option>
                          <option value="4" @if(isset($data['level']) && $data['level'] =='4')selected="selected" @endif>Fourth</option>
                          </select>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="passnum" class="control-label col-lg-2">Passing Score <span class="required">*</span></label>
                      <div class="col-lg-10">
						@if ($errors->has('passnum'))
							<div class="error">{{ $errors->first('passnum') }}</div>
						@endif
                        <input class="form-control " id="passingscore" name="passnum" type="text" value="@if(isset($data['passnum'])){{$data['passnum']}} @endif" required />
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="time" class="control-label col-lg-2">Time (in mins) <span class="required">*</span></label>
                      <div class="col-lg-10">
						@if ($errors->has('time'))
							<div class="error">{{ $errors->first('time') }}</div>
						@endif
                        <input class="form-control " id="time" name="time" type="text" value="@if(isset($data['time'])){{$data['time']}} @endif" required />
                      </div>
                    </div>
					
					<div class="form-group ">
                      <label for="scheduled_at" class="control-label col-lg-2">Schedule Date <span class="required">*</span></label>					 
                      <div class="col-lg-10">
                       <input class="form-control " id="scheduled_at" name="scheduled_at" type="date" value="@if(isset($data['scheduled_at'])){{$data['scheduled_at']}} @endif">					   
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