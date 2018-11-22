<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $quesAns)
            <tr>
                <td>{{!! $quesAns['question'] !!}}</td>
                <td>{{!! $quesAns['answer'] !!}}</td>
                <td>{{$quesAns['result']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>