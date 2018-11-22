<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
            <a class="" href="{{ url('/admin/dashboard') }}">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
          </li>
           <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Question Set</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="{{ url('/admin/questionset/create') }}">Create</a></li>
              <li><a class="" href="{{ url('/admin/questionset/list') }}">List</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_group"></i>
                          <span>Students</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="{{ url('/admin/student/list') }}">List</a></li>
              <li><a class="" href="{{ url('admin/student/result/list') }}">Result List</a></li>
            </ul>
          </li>

          <li class="sub-menu">
              <a href="javascript:;" class="">
                            <i class="icon_clock"></i>
                            <span>Time-Slot</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
              <ul class="sub">
                <li><a class="" href="{{ url('admin/timeslot/manage/new') }}">Create</a></li>
                <li><a class="" href="{{ url('admin/timeslot/list') }}">List</a></li>
              </ul>
            </li>
        
          

        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>