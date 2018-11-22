@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-clock-o"></i>View Time-Slot(s)</h3>
          </div>
        </div>
        <!-- page start-->
          
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                List of time slot
              </header>
				@if(session()->has('timeslotlistmessage'))
					<div class="alert alert-success">
						{{ session()->get('timeslotlistmessage') }}
					</div>
				@endif
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th> Title</th>
                    <th> Date</th>
                    <th> Location</th>
                    <th> Online Seats</th>
                    <th> Offline Seats</th>
                    <th> No of Slots</th>
                    <th> No of Bookings</th>
                    <th> Edit</th>
                    <th> Delete</th>
                    <th> Add Slot</th>
                    <th> View Slot(s)</th>
                  </tr>
                  
                  @foreach ($data as $tsDetails)
                  <tr>
                    <td>{{$tsDetails['title']}}</td>
                    <td>{{$tsDetails['date']}}</td>
                    <td>{{$tsDetails['location']}}</td>
                    <td>{{$tsDetails['totalseats']}}</td>
                    <td>{{$tsDetails['totalofflineseats']}}</td>
                    <td>{{$tsDetails['numofslot']}}</td>
                    <td>{{$tsDetails['numofbooked']}}</td>
                    <td><a class="btn btn-warning" href="{{url ('admin/timeslot/manage/'.$tsDetails['id'])}}">
                              <i class="icon_pencil-edit_alt"></i>
                        </a>
                    </td>
                    <td><a onclick="return confirmDelete();" class="btn btn-danger" href="{{url ('admin/timeslot/delete/'.$tsDetails['id'])}}">
                              <i class="icon_minus_alt2"></i>
                        </a>
                    </td>
                    <td><a onclick="addSlots({{$tsDetails['id']}});" class="btn btn-primary" data-toggle="modal"  href="#addSlot">
                              <i class="icon_plus_alt2"></i>
                        </a>
                    </td>
                    <td><a onclick="getSlots({{$tsDetails['id']}});" class="btn btn-primary" data-toggle="modal" href="#viewSlot">
                              <i class="icon_ol"></i>
                        </a>
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
   <!-- Add Slot Starts -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addSlot" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Add Slot</h4>
          </div>
          <div class="modal-body"> 
                <form class="form-validate form-horizontal" id="form_questionset" method="post" action="{{ url('admin/slot/save') }}">
                {{ csrf_field() }}
                <input type="text" class="hidden timeslotid" name="timeslotid" value=""/>
                  <div class="form-group">
                      <label for="fromTime">From time(hh:mm)</label>
                      <input type="time" class="form-control" id="fromTime" name="fromtime" placeholder="From time">
                  </div>
                  <div class="form-group">
                      <label for="toTime">To time(hh:mm)</label>
                      <input type="time" class="form-control" id="toTime" name="totime" placeholder="To time">
                  </div>
                  <div class="form-group">
                      <label for="numofstudents">Number of students</label>
                      <input type="text" class="form-control" id="numofstudents" name="numofstudents" placeholder="Number of students">
                  </div>
                  <div class="form-group">
                      <label for="numofstudents">Offline Quota</label>
                      <input type="text" class="form-control" id="numofstudents" name="numofofflineseats" placeholder="Number of offline seats">
                  </div>
                  <button type="submit" class="btn btn-primary">Add Slot</button>
                </form>
          </div>

        </div>
      </div>
    </div>
   <!-- Add Slot Ends -->

   <!-- View Slots Starts -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewSlot" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">View Slot</h4>
          </div>
          <div class="modal-body">
              <section class="panel">
                  <header class="panel-heading">
                    List of slots for <span id="timeSlotDate"></span>
                  </header>
                  <div id="slotTable"></div>
                </section>
          </div>

        </div>
      </div>
    </div>
   <!-- View Slots Ends -->

   <script>
      function getSlots(id){
         $.ajax({
            type:'GET',
            url:"{{url('admin/slot/list/')}}"+ "/" + id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
              document.getElementById("timeSlotDate").innerHTML=data.date;

              var details = data.details;
              var col = [];
              
              for (var i = 0; i < details.length; i++) {
                  for (var key in details[i]) {
                      if (col.indexOf(key) === -1) {
                          col.push(key);
                      }
                  }
              }
              
              //col = ["from", "to", "numofseats", "numofbooked", "numofvacant", "id"];
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
              th.innerHTML =  "From Time";
              row.appendChild(th);
              th = document.createElement("th");      // TABLE HEADER.
              th.innerHTML =  "To Time";
              row.appendChild(th);
              th = document.createElement("th");      // TABLE HEADER.
              th.innerHTML =  "Batch Size(Online)";
              row.appendChild(th);
              th = document.createElement("th");      // TABLE HEADER.
              th.innerHTML =  "Offline Quota";
              row.appendChild(th);
              th = document.createElement("th");      // TABLE HEADER.
              th.innerHTML =  "Batch Booked(online)";
              row.appendChild(th);
              th = document.createElement("th");      // TABLE HEADER.
              th.innerHTML =  "Batch Vacant(online)";
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
              var divContainer = document.getElementById("slotTable");
              divContainer.innerHTML = "";
              divContainer.appendChild(table);
               
            }
         });
      }

      function addSlots(id)
      {        
        $('.timeslotid').val(id);
      }
   </script>
@endsection