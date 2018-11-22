<!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li> <a class="" href="{{ url('student/dashboard') }}" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard 
                    {{-- <span class="label label-rouded label-primary pull-right">2</span> --}}
                </span></a>
                    {{-- <ul aria-expanded="false" class="collapse">
                        <li><a href="index.html">Ecommerce </a></li>
                        <li><a href="index1.html">Analytics </a></li>
                    </ul> --}}
                </li>
                <li class="nav-label">Apps</li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-file-text"></i><span class="hide-menu">Exams</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/exam/list/pending'): '#'}}">Pending</a></li>
                        <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/exam/list'): '#'}}">All</a></li>
                        <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/exam/result/list'): '#'}}">Result List</a></li>
                        <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/exam/list/upcoming'): '#'}}">Upcoming</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-address-card"></i><span class="hide-menu">My Account</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/profile'): '#'}}">Profile</a></li>
                        {{-- <li><a href="{{ (bool)env('APP_MODE_DEVELOPMENT', false)? url('student/payment'): '#'}}">Make Payment</a></li> --}}
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
<!-- End Left Sidebar  -->