<!-- javascripts -->

  {{Html::script("js/jquery.js")}}
  {{Html::script("js/jquery-ui-1.10.4.min.js")}}
  {{Html::script("js/jquery-1.8.3.min.js")}}
  {{Html::script("js/jquery-ui-1.9.2.custom.min.js")}}
  <!-- bootstrap -->
  {{Html::script("js/bootstrap.min.js")}}
  <!-- nice scroll -->
  {{Html::script("js/jquery.scrollTo.min.js")}}
  {{Html::script("js/jquery.nicescroll.js")}}
  <!-- charts scripts -->
  {{Html::script("assets/jquery-knob/js/jquery.knob.js")}}
  {{Html::script("js/jquery.sparkline.js")}}
  {{Html::script("assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js")}}
  {{Html::script("js/owl.carousel.js")}}
  <!-- jQuery full calendar -->
  <{{Html::script("js/fullcalendar.min.js")}}
    <!-- Full Google Calendar - Calendar -->
    {{Html::script("assets/fullcalendar/fullcalendar/fullcalendar.js")}}
    <!--script for this page only-->
    {{Html::script("js/calendar-custom.js")}}
    {{Html::script("js/jquery.rateit.min.js")}}
    <!-- custom select -->
    {{Html::script("js/jquery.customSelect.min.js")}}
    {{Html::script("assets/chart-master/Chart.js")}}
    <!-- ck editor -->
    {{Html::script("assets/ckeditor/ckeditor.js")}}
    <!--custome script for all page-->
    {{Html::script("js/scripts.js")}}
    <!-- custom script for this page-->
    {{Html::script("js/sparkline-chart.js")}}
    {{Html::script("js/easy-pie-chart.js")}}
    {{Html::script("js/jquery-jvectormap-1.2.2.min.js")}}
    {{Html::script("js/jquery-jvectormap-world-mill-en.js")}}
    {{Html::script("js/xcharts.min.js")}}
    {{Html::script("js/jquery.autosize.min.js")}}
    {{Html::script("js/jquery.placeholder.min.js")}}
    {{Html::script("js/gdp-data.js")}}
    {{Html::script("js/morris.min.js")}}
    {{Html::script("js/sparklines.js")}}
    {{Html::script("js/charts.js")}}
    {{Html::script("js/jquery.slimscroll.min.js")}}
    <script type="text/javascript">
      function confirmDelete(){
        return confirm("Are you sure want to delete?");
      }
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script>