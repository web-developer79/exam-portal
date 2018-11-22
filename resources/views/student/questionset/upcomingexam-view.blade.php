<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Exam Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $quesAns)
            <tr>
                <td>{{$quesAns['examName']}}</td>
                <td>{{$quesAns['examDate']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>