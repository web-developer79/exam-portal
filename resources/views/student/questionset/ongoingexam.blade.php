<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@extends('student.layout')
@section('body')

<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Exam On-Going</h3> </div>
    </div>
    <!-- End Bread crumb -->

	<!-- Container fluid  -->
	<div class="container-fluid">


<!-- Panel starts -->
		<div class="row">
			@include('student.questionset.ongoingexam-left')
            @include('student.questionset.ongoingexam-right') 
                </div>

<!-- Panel ends -->

<div class="tab-pane" id="settings" role="tabpanel">
    <div class="card-body">
		
        {{-- <form class="form-horizontal form-material" method="POST" action="{{ url('/student/exam/result/') }}">
			{{ csrf_field() }}
			<input class="form-control hidden" id="studentquespapid" name="studentquespapid" type="text" value="{{$data['studentquespapid']}}"/>
			<input class="form-control hidden" id="totoalques" name="totoalques" type="text" value="{{$data['totoalques']}}"/>
			<div class="form-group quesdiv" data-id="{{$data['question_id']}}" data-studentquesid="{{$data['studentquespapid']}}" data-currpage="1" data-time="{{$data['default_time']}}">
             --}}
            {{-- <div class="form-group answerset">
            @foreach($data['answers'] as $answerid=>$answerarr)
                <br/><br/>
                <input type="radio" name="rbtnCount" value="{{$answerarr['choice_id']}}"/>
                <label for="{{$answerarr['choice_id']}}">{{$answerarr['choice']}}</label>
            @endforeach
            </div> --}}
            {{-- <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success prev" style="display:none">
                        Prev
                    </button>
                    <button class="offset-sm-4 btn btn-success submit" style="display:none">
                        Submit
                    </button>
                    <button class="offset-sm-4 btn btn-success next">
                        Next
                    </button>
                </div>
            </div> --}}
        </form>
    </div>
</div>
{{-- @for ($i = 1; $i <= $data['totoalques']; $i++)
        <div class="quesnum{{ $i }} quessel"  data-id="{{ $i }}">{{ $i }}</div>
@endfor --}}
	</div>
	<!-- End Container fluid  -->
	<!-- footer -->
	@include('student.footer-message');
	<!-- End footer -->
</div>
<!-- End Page wrapper  -->

@endsection

<script>
         jQuery(document).ready(function(){
			 var totoalques='<?php echo $data['totoalques']; ?>';
			 var prevques=totoalques;			 
			 console.log(prevques);
            jQuery('.btn-success.next').click(function(e){
				var curpage=jQuery('.quesdiv').attr('data-currpage');
				if(jQuery('input[name=rbtnCount]:checked').val())
				{
					jQuery('.quesnum'+curpage).addClass('selected');
				}
				else
				{
					jQuery('.quesnum'+curpage).removeClass('selected');
				}
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/student/exam/ongoingExamquestion') }}",
                  method: 'post',
				  dataType: 'json',
                  data: {
                     quesid: jQuery('.quesdiv').attr('data-id'),
                     studentquesid: jQuery('.quesdiv').attr('data-studentquesid'),
                     ansid: jQuery('input[name=rbtnCount]:checked').val(),
                     currpage: jQuery('.quesdiv').attr('data-currpage'),
					 type:'next'
                    // price: 'hi'
                  },
                  success: function(result){
					  jQuery('.quesdiv').html('<span class="qsnum">'+result.filter.page_id+'</span>'+result.filter.question);
					  jQuery('.quesdiv').attr('data-id',result.filter.question_id);
					  jQuery('.quesdiv').attr('data-currpage',result.filter.page_id);
					  var radiohtml='';
					  jQuery.each(result.filter.answers, function (index, value1) {
						  if(value1.choice_id==result.filter.questionanswer_id)
						  {					
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'" checked="checked"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  }
						  else
						  {
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  } 
						
						});
                     jQuery('.answerset').html(radiohtml);
					 if(result.filter.page_id>=prevques)
					  {
						  jQuery('.next').hide();
						  jQuery('.submit').show();
					  }
					  else
					  {
						  jQuery('.next').show();
					  }
					  if(result.filter.page_id>1)
					  {
						  jQuery('.prev').show();
					  }
					  else
					  {
						  jQuery('.prev').hide();
					  }
                  }});
               });
			   
			   jQuery('.btn-success.prev').click(function(e){
               e.preventDefault();
			   var curpage=jQuery('.quesdiv').attr('data-currpage');
			   if(jQuery('input[name=rbtnCount]:checked').val())
				{
					jQuery('.quesnum'+curpage).addClass('selected');
				}
				else
				{
					jQuery('.quesnum'+curpage).removeClass('selected');
				}
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/student/exam/ongoingExamquestion') }}",
                  method: 'post',
				  dataType: 'json',
                  data: {
                     quesid: jQuery('.quesdiv').attr('data-id'),
                     studentquesid: jQuery('.quesdiv').attr('data-studentquesid'),
                     ansid: jQuery('input[name=rbtnCount]:checked').val(),
                     currpage: jQuery('.quesdiv').attr('data-currpage'),
					 type:'prev'
                    // price: 'hi'
                  },
                  success: function(result){
					  jQuery('.quesdiv').html('<span class="qsnum">'+result.filter.page_id+'</span>'+result.filter.question);
					  jQuery('.quesdiv').attr('data-id',result.filter.question_id);
					  jQuery('.quesdiv').attr('data-currpage',result.filter.page_id);
					  
					  var radiohtml='';
					  jQuery.each(result.filter.answers, function (index, value1) {
						  if(value1.choice_id==result.filter.questionanswer_id)
						  {
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'" checked="checked"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  }
						  else
						  {
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  }
						
						});
                     jQuery('.answerset').html(radiohtml);
					 if(result.filter.page_id>=prevques)
					  {
						  jQuery('.next').hide();
						  jQuery('.submit').show();
					  }
					  else
					  {
						  jQuery('.next').show();
					  }
					 if(result.filter.page_id>1)
					  {
						  jQuery('.prev').show();
					  }
					  else
					  {
						  jQuery('.prev').hide();
					  }
                  }});
               });
			   
			   
			   jQuery('.quesnumresult').click(function(e){
				var curpage=jQuery('.quesdiv').attr('data-currpage');
				//console.log(curpage);
				if(jQuery('input[name=rbtnCount]:checked').val())
				{
					jQuery('.quesnum'+curpage).addClass('selected');
				}
				else
				{
					jQuery('.quesnum'+curpage).removeClass('selected');
				}
				
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/student/exam/ongoingExamquestion') }}",
                  method: 'post',
				  dataType: 'json',
                  data: {
                     quesid: jQuery('.quesdiv').attr('data-id'),
                     studentquesid: jQuery('.quesdiv').attr('data-studentquesid'),
                     ansid: jQuery('input[name=rbtnCount]:checked').val(),
                     currpage: jQuery(this).attr('data-id'),
					 type:'random'                    
                  },
                  success: function(result){
					  console.log(result);
					  jQuery('.quesdiv').html('<span class="qsnum">'+result.filter.page_id+'</span>'+result.filter.question);
					  jQuery('.quesdiv').attr('data-id',result.filter.question_id);
					  jQuery('.quesdiv').attr('data-currpage',result.filter.page_id);
					  var radiohtml='';
					  jQuery.each(result.filter.answers, function (index, value1) {
						  if(value1.choice_id==result.filter.questionanswer_id)
						  {					
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'" checked="checked"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  }
						  else
						  {
							  radiohtml=radiohtml+'<div class="row answeroptionrow"><div class="col-sm-1"><input type="radio" name="rbtnCount" value="'+value1.choice_id+'"></div><div class="col-md-11 quesanschoice"><label for="'+value1.choice_id+'">'+value1.choice+'</label></div></div>';
						  } 
						
						});
                     jQuery('.answerset').html(radiohtml);
					 if(result.filter.page_id>=prevques)
					  {
						  jQuery('.next').hide();
						  jQuery('.submit').show();
					  }
					  else
					  {
						  jQuery('.next').show();
					  }
					  if(result.filter.page_id>1)
					  {
						  jQuery('.prev').show();
					  }
					  else
					  {
						  jQuery('.prev').hide();
					  }
                  }});
               });
			   
			   
            });
</script>