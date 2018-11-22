<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
       
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Create/Update Question
              </header>
              <div class="panel-body">
                <div class="form">
				@if(session()->has('questionmessge'))
					<div class="alert alert-success">
						{{ session()->get('questionmessge') }}
					</div>
				@endif
				@if(session()->has('questiofailurnmessge'))
					<div class="alert alert-failure">
						{{ session()->get('questiofailurnmessge') }}
					</div>
				@endif
                  <form class="form-validate form-horizontal" id="form_question" method="post" action="{{ url('/admin/question/update') }}">
				   {{ csrf_field() }}
				   @if( isset($data['quesid']) )						
							<input class="form-control hidden" id="quesid" name="quesid" type="text" value="{{$data['quesid']}}"/>						
					@endif
                    <div class="form-group ">
                      <label for="question" class="control-label col-lg-2">Question <span class="required">*</span></label>
                      <div class="col-lg-10">
													<textarea class="form-control ckeditor"  name="question" rows="6">{{$data['question']}}</textarea>
                        {{-- <input class="form-control" id="question" name="question" minlength="10" type="text" value="{{$data['question']}}" required /> --}}
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="questype" class="control-label col-lg-2">Question Type <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class="form-control " id="questype" name="questype" required >
                            <option value="SCQ">Single Choice Question</option>
                            {{-- <option value="MCQ">Multiple Choice Question</option>
                            <option value="NUM">Number</option>
                            <option value="TXT">Text</option> --}}
                        </select>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-lg-10">
                        <a class="btn btn-primary add_answer" href="javascript:void(0)" title="Bootstrap 3 themes generator"><span class="icon_lightbulb_alt"></span> Add answer</a>
                        </div>
						<div class="answer_failue_messge hidden" >Question need atleast 1 answer.</div>
                    </div>
					<?php $i=0; ?>
					@foreach($data['choice'] as $choice1)
                    <div class="form-group add_answer_div">
                      <label for="answer" class="control-label col-lg-2">Answer <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control "  name="answer[<?php echo $i; ?>]" type="text" answerid='<?php echo $i; ?>' value="{{ $choice1 }}" required />
						<div class="remove">Remove</div>						
                      </div> 
                    </div>
					<?php $i++; ?>
					@endforeach
					<?php $k=0;?>
					@foreach($data['choice_id'] as $choice_id1)
					 <input class="form-control hidden"  name="answerid[<?php echo $k; ?>]" type="text" answerid='<?php echo $k; ?>' value={{ $choice_id1 }} required />
					 <?php $k++;?>
					@endforeach
					<div class="form-group right_answer_div">
                      <label for="answer" class="control-label col-lg-2">Right Answer <span class="required">*</span></label>
					  <?php $j=0; ?>
                      @foreach($data['choice'] as $choice1)
						<input type="radio" name="rbtnCount" value="<?php echo $j; ?>" @if($j==$data['answer']) checked @endif/><label for="<?php echo $j; ?>"><?php echo $choice1; ?></label>
						<?php $j++; ?>
					  @endforeach
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a href="{{url('admin/question/list/'.$data['quessetid'])}}" class="btn btn-default">Cancel</a>
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
	<script>
	jQuery(document).ready(function(){
		var j=parseInt('<?php echo count($data['choice_id']); ?>');
		i=j+1;
		jQuery('.add_answer').on('click',function(){				
			jQuery('.add_answer_div:last').after('<div class="form-group add_answer_div"><label for="answer" class="control-label col-lg-2">Answer <span class="required">*</span></label><div class="col-lg-10"><input class="form-control " name="answer['+i+']" type="text" answerid='+ i + ' required><div class="remove">Remove</div></div></div>');
			i=i+1;
		});	
		jQuery(document.body).on('click','.remove',function(){
			var id= jQuery(this).prev().attr('answerid');
			 var element= jQuery('.add_answer_div').length;
			console.log(element);			
			if(element > 1)
			{
				jQuery(this).parent().parent().remove();
				jQuery('.right_answer_div input[value="'+id+'"]').remove();
			    jQuery('.right_answer_div label[for="'+id+'"]').remove();
			}
			else
			{
				jQuery('.answer_failue_messge').show();
				setTimeout(function() { jQuery(".answer_failue_messge").hide(); }, 5000);
			}				
		});
jQuery(document.body).on('blur','.add_answer_div input',function(){
	var flag=true;
			var selectval=jQuery(this).attr("answerid");
			var seltext=jQuery(this).val();
			
			jQuery('input[name="rbtnCount"]').each(function(){
				if(jQuery(this).attr("value")==selectval)
				{
					flag=false;
				}
			});
			//console.log(flag);
			if(!flag)
			{
				jQuery('input[name="rbtnCount"]').each(function(){
					if(jQuery(this).attr("value")==selectval)
					{
						if(seltext.length)
						{
							jQuery('.right_answer_div label[for='+selectval+']').html(seltext);
						}
						else
						{
							jQuery(this).remove();
							jQuery('.right_answer_div label[for='+selectval+']').remove();
						}
					}
				});
			}
			else
			{
				if(seltext.length)
				{
					var radioBtn = jQuery('<input type="radio" name="rbtnCount" value="'+selectval+'"/><label for="'+selectval+'">'+seltext+'</label>');
				   radioBtn.appendTo('.right_answer_div');
				}				
			}
			 
		});		
		
	});
	
	
	</script>