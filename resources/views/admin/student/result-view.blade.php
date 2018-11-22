<table class="table table-striped table-advance table-hover">
<tbody>
<tr>
<th> Name</th>
<th> Question Set</th>
<th> Attempted Date</th>
<th> Result</th>
<th> View Details</th>
</tr>

@foreach ($students as $stud)
<tr>
<td>{{$stud['name']}}</td>
<td>{{$stud['questionSet']}}</td>
<td>{{$stud['attemptDate']}}</td>
<td>{{ $stud['result'] }}</td>
<td><a href="{{ url('admin/student/result/detail/'.$stud['questionSetId']) }}" class="btn btn-success">View Details</a>
</tr>
@endforeach

</tbody>
</table>