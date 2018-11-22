<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="row">
        <div class="col-md-6">
            <div class="input-group">
                
                <input type="text" class="form-control"  name="search" value="{{$students['metadata']['search']}}" placeholder="{{$students['metadata']['search']==''?'Please enter your student name':''}}" autofocus=""  style="" autocomplete="off">
                <a class="btn btn-default input-group-addon" href="" title="Search student">
                      <span class="icon_search"></span> Search</a>
              </div>
          
        </div>
        <div class="col-md-4">
            <div class="btn-group">
                <a class="btn btn-info" href="#">«</a>
                @if($students['metadata']['currpagenum']-5<=0)
                  @for($i=1;$i<=5;$i++)
                        <a class="btn btn-info {{$students['metadata']['currpagenum']==$i?'active':''}}" href="#">{{$i}}</a>
                  @endfor
                @elseif(($students['metadata']['currpagenum']>5 && ($students['metadata']['pagecount']-$students['metadata']['currpagenum'] >= 5) ) )
                  @for($i=$students['metadata']['currpagenum']-2;$i<=$students['metadata']['currpagenum']+2;$i++)
                        <a class="btn btn-info {{$students['metadata']['currpagenum']==$i?'active':''}}" href="#">{{$i}}</a>
                  @endfor
                @elseif( $students['metadata']['currpagenum'] + 5 > $students['metadata']['pagecount'] )
                  @for($i=$students['metadata']['pagecount']-4;$i<=$students['metadata']['pagecount'];$i++)
                      <a class="btn btn-info {{$students['metadata']['currpagenum']==$i?'active':''}}" href="#">{{$i}}</a>
                  @endfor
                @endif
                <a class="btn btn-info" href="#">»</a>
              </div>
            
        </div>
        <div class="col-md-2">
        <a class="btn btn-info csvexport enable" href="{{ url('/admin/student/exportcsv') }}" title="Export to CSV"><span class="icon_cloud-download_alt"></span> Export to CSV</a>
        </div>
    </div>   