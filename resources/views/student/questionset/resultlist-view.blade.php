<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Percentage</th>
                <th>Result</th>
                <th>View Detail</th>            
            </tr>
        </thead>
        <tbody>
            @foreach($data as $quesAns)
            <tr>
                <td>{{$quesAns['examName']}}</td>
                <td>{{$quesAns['percentage']}}</td>
                <td>{{$quesAns['result']}}</td>
                <td><a href="{{url('student/exam/resultdetail/'.$quesAns['questionSetId'])}}" class="btn btn-success">View Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>