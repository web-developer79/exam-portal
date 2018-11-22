@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i>Registered Students</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                List of registered students - {{$students['summary']['total']}}, 
                Verified: {{$students['summary']['verified']}}, Scholarship:  {{$students['summary']['scholar']}}, Paymented: {{$students['summary']['payment']}}
                 
              </header>
              @include('admin.student.list-pagination')
              @if(session()->has('messgeSuccess'))
              <div class="alert alert-success">
                {{ session()->get('messgeSuccess') }}
              </div>
            @endif
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th> Name</th>
                    <th> Mobile No</th>
                    <th> Enrollment No.</th>
                    <th> School Name</th>
					<th> Location </th>
                    <th> Registration date</th>
                    <th> Class</th>
                    <th> Exam Scheduled</th>
                    <th> Verified</th>
                    <!--<th> Registered for</th>-->
                    <th> Payment Done</th>
                    <th> Get Trxns</th>
                  </tr>
                  
                  @foreach ($students['studentlist'] as $stud)
                  <tr>
                    <td>{{$stud['name']}}</td>
                    <td>{{$stud['mobile']}}
                    @if($stud['altmobile']!="")
                    , {{$stud['altmobile']}}
                    @endif
                    
                    </td>
                    
                    <td>{{$stud['enrollmentid']}}</td>
                    <td>{{$stud['schoolname']}}</td>
                    <td>{{ucfirst($stud['prefer_location'])}}</td>
					<td>{{$stud['regdate']}}</td>
                    <td>{{$stud['class']}}</td>
                    <td>{{$stud['examdate']}}<br/> {{$stud['examtime']}}</td>
                    
                    
                    <td>
                        <span class="btn {{$stud['status']?'btn-primary':'btn-danger'}}" href="#">
                          <i class="{{$stud['status']?'icon_check_alt2':'icon_close_alt2'}}"></i>
                        </span>
                    </td>
                    
                    {{--
                    <td> <div class="btn-group">
                        <a class="btn btn-primary" href="" title="Registered for">{{$stud['registeredfor']}}</a>
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="" ><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          @if($stud['ismock'])
                          <li><a href="{{url('admin/student/register/scholarship/'.$stud['id'])}}" title="scholarship">Scholar-Ship</a></li>
                          @else
                            <li><a href="{{url('admin/student/register/mock/'.$stud['id'])}}" title="mock">Mock</a></li>
                          @endif
                          
                        </ul>
                      </div>
                </div></td>
                --}}
                  <td>
                      <div class="btn-group">
                          <a class="btn btn-primary {{$stud['paymentstatus']?'btn-primary':'btn-danger'}}" href="" title="Payment Status"><i class="{{$stud['paymentstatus']?'icon_check_alt2':'icon_close_alt2'}}"></i></a>
                          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="" ><span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            @if($stud['paymentstatus'])
                            <li><a href="{{url('admin/student/payment/unpaid/'.$stud['id'])}}" title="unpaid">Un-paid</a></li>
                            @else
                              <li><a href="{{url('admin/student/payment/paid/'.$stud['id'])}}" title="paid">Paid</a></li>
                            @endif
                            
                          </ul>
                        </div>
                  </div>
                    </td>
                    <td>
                        <div class="btn-group">
                          <a onclick="getTxns({{$stud['id']}});" class="btn btn-primary"  data-toggle="modal"  href="#viewTxns" 
                          title="Get Transactions">Get Trxns</a>
                          </div>
                        
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
              @include('admin.student.list-pagination')
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->


   <!-- View Transaction Starts -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewTxns" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">View Transactions</h4>
          </div>
          <div class="modal-body">
              <section class="panel">
                  <header class="panel-heading">
                    Number of transactions - <b><span id="txnCount"></span></b>
                  </header>
                  <div id="txnTable"></div>
                </section>
          </div>

        </div>
      </div>
    </div>
   <!-- View Transaction Ends -->

<script>
      function getTxns(id){
         $.ajax({
            type:'GET',
            url:"{{url('admin/transaction/list/')}}"+ "/" + id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
              var details= data.details;
              var count=data.count;
              $("#txnCount").text(count);
              if(count==0){
                $("#txnTable").html("<p></p><p>There is no transaction done by the student.</p><p></p>");
              }
              else {
                  var col = [];
                  col = ["txnid", "payu_status", "payumoneyid", "mihpayid", "id"];
                  /*
                  for (var i = 0; i < details.length; i++) {
                      for (var key in details[i]) {
                          if (col.indexOf(key) === -1) {
                              col.push(key);
                          }
                      }
                  }
                  */
                  //for (var j = 0; j < col.length; j++) {
                    //console.log(col[j]);
                  //}
                  // CREATE DYNAMIC TABLE.
                  var table = document.createElement("table");
                  var name = "table table-hover";
                  arr = table.className.split(" ");
                  if (arr.indexOf(name) == -1) {
                    table.className += " " + name;
                  }
                  // Create an empty <thead> element and add it to the table:
                  var header = table.createTHead();
                  // Create an empty <tr> element and add it to the first position of <thead>:
                  var row = header.insertRow(0);    
                  var th = document.createElement("th");      // TABLE HEADER.
                  th.innerHTML =  "Txn-ID";
                  row.appendChild(th);
                  th = document.createElement("th");      // TABLE HEADER.
                  th.innerHTML =  "Txn Status";
                  row.appendChild(th);
                  th = document.createElement("th");      // TABLE HEADER.
                  th.innerHTML =  "PayU Money ID";
                  row.appendChild(th);
                  th = document.createElement("th");      // TABLE HEADER.
                  th.innerHTML =  "PayU ID(mihpayid)";
                  row.appendChild(th);
    
                  // ADD JSON DATA TO THE TABLE AS ROWS.
                  for (var i = 0; i < details.length; i++) {
                      tr = table.insertRow(-1);
                      for (var j = 0; j < col.length-1; j++) {
                          var tabCell = tr.insertCell(-1);
                          tabCell.innerHTML = details[i][col[j]];
                      }
                  }
                  // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
                  var divContainer = document.getElementById("txnTable");
                  divContainer.innerHTML = "";
                  divContainer.appendChild(table);
              
              }
              
               
            }
         });
      }

      function addSlots(id)
      {        
        $('.timeslotid').val(id);
      }
   </script>
@endsection