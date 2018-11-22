<!DOCTYPE html>
<html lang="en">

@include('admin.head')

<body>
  <!-- container section start -->
  <section id="container" class="">


   @include('admin.header')

    <!--sidebar start-->
    @include('admin.sidebar')
    <!--sidebar end-->

    @yield('body')
  </section>
  <!-- container section start -->

  @include('admin.footer')

</body>

</html>
