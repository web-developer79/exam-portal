<!-- Start Page Content -->
<div class="row">
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-certificate f-s-40 color-primary"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{count($data['examTaken'])}}</h2>
                    <p class="m-b-0">Exams Taken</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-30">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-check f-s-40 color-success"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2>{{$data['examsPassed']}}</h2>
                    <p class="m-b-0">Exams Passed</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Recent Exams </h4>
            </div>
            <div class="card-body">
                @if(count($data['examTaken']) == 0)
                <div>
                    <br/>
                    <h5>There is no exam given by you. <h5><br/>Please start your exam under Pending in Exams section or  <a href="{{url('student/exam/list/pending')}}" >click here</a> to show the list of pending exam.
                    @else
                        @include('student.dashboard-exam-list')
                    @endif
                
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
