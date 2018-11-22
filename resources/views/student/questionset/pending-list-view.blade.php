<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['examTaken'] as $examDetails)
            <tr>
                <td>{{$examDetails['name']}}</td>
                <td>
                    <a class="btn btn-success" href="{{url('student/exam/start/'.$examDetails['id'])}}">Start Exam</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>