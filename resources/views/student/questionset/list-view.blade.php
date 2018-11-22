<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Attempted Date</th>
                <th>Percentage</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['examTaken'] as $examDetails)
            <tr>
                <td>{{$examDetails['name']}}</td>
                <td>{{$examDetails['attemptDate']}}</td>
                <td>
                    {{$examDetails['percentage']}}
                    </td>
                <td>
                    @if($examDetails['isAttempt'])
                        <span class="badge {{($examDetails['isExamPass'])?'badge-success': 'badge-danger'}}">{{$examDetails['result']}}</span>
                    @else
                    <a class="btn btn-success" href="{{url('student/exam/start/'.$examDetails['id'])}}">Start Exam</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>