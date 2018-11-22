<!DOCTYPE html>
<html lang="en">

@include('student.head')

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
       
        @include('student.header')
        @include('student.sidebar')
        

        @yield('body')

        
    </div>
    <!-- End Wrapper -->
   
@include('student.footer')
</body>

</html>