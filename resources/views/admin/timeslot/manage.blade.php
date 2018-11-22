@extends('admin.layout')
@section('body')
<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-clock-o"></i> Time-Slot</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                  {{$data['id']>0?'Update':'Create'}} Time-Slot
              </header>
              <div class="panel-body">
                <div class="form">
				@if(session()->has('timeslotmessage'))
					<div class="alert alert-success">
						{{ session()->get('timeslotmessage') }}
					</div>
				@endif
                  <form class="form-validate form-horizontal" id="form_questionset" method="post" action="{{ url('admin/timeslot/save') }}">
				  {{ csrf_field() }}
					@if( $data['id'] >0 )						
							<input class="form-control hidden" id="timeslotid" name="timeslotid" type="text" value="{{$data['id']}}"/>						
          @endif
          <input class="hidden" id="numofnewslot" name="numofnewslot" value="0" type="text"/>
                    <div class="form-group ">
                      <label for="title" class="control-label col-lg-2">Title <span class="required">*</span></label>
                      <div class="col-lg-10">
					  @if ($errors->has('title'))
						<div class="error">{{ $errors->first('title') }}</div>
            @endif
                        <input class="form-control" id="title" name="title" type="text" placeholder="{{$data['title']==''?'Please enter title here':''}}" value="{{$data['title']}}" required />
                      </div>
                    </div>
					          <div class="form-group ">
                      <label for="select_date" class="control-label col-lg-2">Select Date <span class="required">*</span></label>
                      <div class="col-lg-10">
                      <input class="form-control " id="select_date" type="date" name="slotdate" placeholder="{{$data['slotdate']==''?'Please input date in mm/dd/yyyy format':''}}" value="{{$data['slotdate']}}">					   
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="select_date" class="control-label col-lg-2">Select Location <span class="required">*</span></label>
                      <div class="col-lg-10">
                          <select name="location">
                              <option value="rohtak" {{$data['location'] == 'rohtak'? 'selected':''}} >Rohtak</option>
                              <option value="hisar" {{$data['location'] == 'hisar'? 'selected':''}} >Hisar</option>
                          </select>
                    					   
                      </div>
                    </div>
                  <div class="row form-inline col-lg-offset-2">
                      <span  id="slotcount" style="display:none;">{{count($data['slots'])}}</span>
                    <!-- From Time -->
                    <div class="form-group col-md-3">
                    <label class="control-label">From time(hh:mm AM/PM)
                        <span class="required">*</span></label>
                        
                    </div>
                      
                      <!-- To Time -->
                      <div class="form-group col-md-3">
                      <label class="control-label">To time(hh:mm AM/PM)
                          <span class="required">*</span></label>
                      </div>
                      <!-- Number of seats -->
                      <div class="form-group col-md-3">
                        <label class="control-label">Number of seats 
                            <span class="required">*</span></label>
                        </div>
                        <div class="form-group col-md-3">
                        <label class="control-label">Number of offline seats 
                            <span class="required">*</span></label>
                        </div>
                        <!-- Add Slot -->
                        <div class="form-group col-md-3">
                            <label class="control-label">Action</label>
                          
                        </div>
                </div>

                <div class="row form-inline col-lg-offset-2">
                    <!-- From Time -->
                    <div class="form-group col-md-3">
                        <input name="fromtime" id="fromtime" type="time" placeholder="From time" />
                        
                    </div>
                      
                      <!-- To Time -->
                      <div class="form-group col-md-3">
                          <input class="" name="totime" id="totime" type="time" placeholder="To time" />
                      </div>
                      <!-- Number of seats -->
                      <div class="form-group col-md-3">
                          <input class="" name="numofseats" id="numofseats" type="text" placeholder="Please enter number of seats" />
                        </div>
                      <!-- Number of offline seats -->
                      <div class="form-group col-md-3">
                          <input class="" name="numofofflineseats" id="numofofflineseats" type="text" placeholder="Please enter number of offline seats" />
                        </div>
                        <!-- Add Slot -->
                        <div class="form-group col-md-3">
                            <a class="btn btn-primary form-control" href="#" onclick="addSlot();">Add Slot</a>
                        </div>
                </div>

                      <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                              <div id="viewslot">
                                @if( count($data['slots'])>0  )
                                <table class=" table table-hover" id="slottable">
                                  <thead>
                                    <tr>
                                      <th>From Time</th>
                                      <th>To Time</th>
                                      <th>Number of seats</th>
                                      <th>Number of offline seats</th>
                                      <th>Delete</th>
                                    </tr>
                                    @foreach($data['slots'] as $slot)
                                    <tr id="slot{{$slot['id']}}">
                                      <td>{{$slot['from']}}</td>
                                      <td>{{$slot['to']}}</td>
                                      <td>{{$slot['numofseats']}}</td>
                                      <td>{{$slot['numofofflineseats']}}</td>
                                      <td><a onclick="return deleteSlot({{$slot['id']}});" class="btn btn-danger" href="#">
                                        <i class="icon_minus_alt2"></i>
                                        </a>
                                      </td>
                                    </tr>
                                    @endforeach
                                  </thead>
                                </table>
                                @endif
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
						  <button class="btn btn-primary" type="submit">
                {{$data['id']>0?'Update':'Create'}}
              </button>
            <a class="btn btn-default" href="{{url('admin/timeslot/list')}}" type="button">Cancel</a>                  
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
    @endsection

    <script>
        function addSlot(){
          var fromTime=document.getElementById("fromtime").value;
          var toTime = document.getElementById("totime").value
          var numOfSeats = document.getElementById("numofseats").value;
          var numOfOfflineSeats = document.getElementById("numofofflineseats").value;
          var numOfNewSlot=document.getElementById('numofnewslot').value;
          
          if(fromTime=='' || toTime=='' || numOfSeats == '' || numOfOfflineSeats == ''){
            return confirm('Please enter the time and number of seats in proper format');
          }

          var countSlot=document.getElementById('slotcount').innerHTML;
          
          if(countSlot==0){
            /* Create the table */
            var table = document.createElement("table");
            var name = "table table-hover";
            arr = table.className.split(" ");
            if (arr.indexOf(name) == -1) {
              table.className += " " + name;
            }
            table.setAttribute("id", "slottable");
            /* Add the header row */
            var header = table.createTHead();
            var row = header.insertRow(0);    
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML =  "From time";
            row.appendChild(th);
            th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML =  "To time";
            row.appendChild(th);
            th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML =  "Number of seats";
            row.appendChild(th);
            th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML =  "Number of offline seats";
            row.appendChild(th);
          }else {
            var table = document.getElementById("slottable");
          }
          numOfNewSlot++;
          // ADD JSON DATA TO THE TABLE AS ROWS.
          tr = table.insertRow(-1);
          var tabCell = tr.insertCell(-1);
          tabCell.innerHTML = "<input style='border:none;' type='text' name='fromtime"+numOfNewSlot+"'  value='"+fromTime + "' readonly />";
          var tabCell = tr.insertCell(-1);
          tabCell.innerHTML = "<input style='border:none;' type='text' name='totime"+numOfNewSlot+"' value='"+toTime + "' readonly />" ;
          var tabCell = tr.insertCell(-1);
          tabCell.innerHTML = "<input style='border:none;' type='text' name='numofseats"+numOfNewSlot+"' value='"+numOfSeats + "' readonly />";
          var tabCell = tr.insertCell(-1);
          tabCell.innerHTML = "<input style='border:none;' type='text' name='numofofflineseats"+numOfNewSlot+"' value='"+numOfOfflineSeats + "' readonly />";
          // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
          if(countSlot==0){
            var divContainer = document.getElementById("viewslot");
            divContainer.appendChild(table);  
          }

          countSlot++;
          
          document.getElementById('numofnewslot').value=numOfNewSlot;
          document.getElementById('slotcount').innerHTML=countSlot;
          document.getElementById("fromtime").value=document.getElementById("totime").value=document.getElementById("numofseats").value=document.getElementById("numofofflineseats").value="";
        }

        // Call the delete slot
        function deleteSlot(id){
        $.ajax({
            type:'GET',
            url:"{{url('admin/slot/delete/')}}"+ "/" + id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
              alert(data.message);
              if(data.status==1)
              {
                document.getElementById("slot"+id).style.display = "none";
              }              
              //TODO: Delete the whole table if no row is left
              // Also, decremeent the var countSlot=document.getElementById('slotcount').innerHTML;
              // Check the increment also (if required)
            }
         });
         
      }
     </script>