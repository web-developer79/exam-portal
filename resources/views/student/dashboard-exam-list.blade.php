<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Percentage</th>
                {{-- <th>ProPercentage</th> --}}
                <th>Result</th>
                <th>Result Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['examTaken'] as $examDetails)
            <tr>
                <td>{{$examDetails['name']}}</td>
                <td>{{$examDetails['percentage']}}</td>
                {{-- <td>
                    <div class="progress">
                        <div role="progressbar" style="width: {{$examDetails['percentage']}}%; height:8px;" class="progress-bar wow animated progress-animated {{($examDetails['isExamPass'])? 'bg-success':'bg-danger' }}"></div>
                    </div>
                    </td> --}}
                <td>
                    <span class="badge {{($examDetails['isExamPass'])?'badge-success': 'badge-danger'}}">{{$examDetails['result']}}</span></td>
                <td><a class="btn btn-success" href="{{url('student/exam/resultdetail/'.$examDetails['questionSetId'])}}">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>