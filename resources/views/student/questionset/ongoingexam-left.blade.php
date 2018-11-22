<div class="col-lg-8">
    <div class="card card-outline-primary">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{ url('/student/exam/result/') }}">
                {{ csrf_field() }}
                <input class="form-control hidden" id="studentquespapid" name="studentquespapid" type="text" value="{{$data['studentquespapid']}}"/>
            <input class="form-control hidden" id="totoalques" name="totoalques" type="text" value="{{$data['totoalques']}}"/>
            
                <div class="form-body">
                    <h3 class="card-title m-t-15">
                        <div class="form-group quesdiv" data-id="{{$data['question_id']}}" data-studentquesid="{{$data['studentquespapid']}}" data-currpage="1" data-time="{{$data['default_time']}}">
                        <span class="qsnum">1</span>{!! $data['question'] !!}
            </div>
        </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <div class="form-group answerset">
                            @foreach($data['answers'] as $answerid=>$answerarr)
                                <div class="row answeroptionrow">
                                    <div class="col-sm-1"> 
                                        <input type="radio" name="rbtnCount" value="{{$answerarr['choice_id']}}"/>
                                    </div>
                                    <div class="col-md-11 quesanschoice">
                                        <label for="{{$answerarr['choice_id']}}">{{$answerarr['choice']}}</label>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    
                </div>
                <div class="form-actions">
                    <button class="btn btn-success prev" style="display:none"><i class="fa fa-arrow-circle-left"></i>
    Prev
</button>
<button class="btn btn-success submit" style="display:none"><i class="fa fa-check"></i>
    Submit
</button>
<button class="btn btn-success next"><i class="fa fa-arrow-circle-right"></i>
    Next
</button>
                </div>
            </form>
        </div>
    </div>
</div>