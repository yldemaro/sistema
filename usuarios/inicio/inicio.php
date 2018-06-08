<?php 
session_start();
if (!isset($_SESSION['Usuario'])) {
    header("Location: logout");
}
include '../../componentes/conexion.php';
include '../../componentes/funciones.php';

echo encabezado('', 'Inicio', $_SESSION['Usuario']['nombre'].' '.$_SESSION['Usuario']['apellido'], true, $_SESSION['Usuario']['rol'], $_SESSION['Usuario']['id']);
?>

<div class="col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
    <div class="panel panel-danger">
      <div class="panel-heading" style="overflow: hidden;background: #dc3545; color: white">
        <h3 class="card-title inline">
          Balance de puntos mes <span id="nombre_mes">actual</span>
        </h3>
        <div class="pull-right">
          <span class="col-sm-5 control-label" >Filtrar por: </span>
          <div class="col-sm-7">
            <select id="select_fecha" class="form-control" style="height: 34px;">
              <option value="01" <?php echo (date('m')=='01')?'selected':'' ?> >Enero</option>
              <option value="02" <?php echo (date('m')=='02')?'selected':'' ?> >Febrero</option>
              <option value="03" <?php echo (date('m')=='03')?'selected':'' ?> >Marzo</option>
              <option value="04" <?php echo (date('m')=='04')?'selected':'' ?> >Abril</option>
              <option value="05" <?php echo (date('m')=='05')?'selected':'' ?> >Mayo</option>
              <option value="06" <?php echo (date('m')=='06')?'selected':'' ?> >Junio</option>
              <option value="07" <?php echo (date('m')=='07')?'selected':'' ?> >Julio</option>
              <option value="08" <?php echo (date('m')=='08')?'selected':'' ?> >Agosto</option>
              <option value="09" <?php echo (date('m')=='09')?'selected':'' ?> >Septiembre</option>
              <option value="10" <?php echo (date('m')=='10')?'selected':'' ?> >Octubre</option>
              <option value="11" <?php echo (date('m')=='11')?'selected':'' ?> >Noviembre</option>
              <option value="12" <?php echo (date('m')=='12')?'selected':'' ?> >Diciembre</option>
            </select>      
          </div>
        </div>
      </div>
      <div class="panel-body">
        <label><i class="fa fa-circle text-success"></i> Creditos</label>
        <label><i class="fa fa-circle text-danger"></i> Debitos</label>
        <div class="chart">
          <canvas id="barChart" style="height:150px"></canvas>
        </div>
      </div>
    </div>
</div>

<?php echo pie_pagina(''); ?>                                           
<script type="text/javascript">
  $(document).ready( function () {
    var f = new Date();
    graficabalance((f.getMonth() +1))  

    $('#select_fecha').on('change', function(){
      var combo = document.getElementById("select_fecha");
      var selected = combo.options[combo.selectedIndex].text;

      $('#nombre_mes').html('de '+selected);
      graficabalance($('#select_fecha').val()) 
    })

    $(".loader").fadeOut("slow");
  });

  function graficabalance(mes){
    var movil = 0
   
      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {movil = 1}

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "componentes/ajax_balance.php", 
      data: {'GraficaBalanceFiltro':1, 'mes':mes, 'movil':movil},
      success: function(result){
        if(result.rps){
          dibujargrafica(result.datos)
        }else{
          console.log(result);
        }

      },error: function(XMLHttpRequest, textStatus, errorThrown){ 
        //alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
      }
    });
  }
  
  function dibujargrafica($datos){
      var barChartData = {
        labels  : $datos[0],
        datasets: [
          {
            label               : 'Creditos',
            fillColor           : '#28a745',
            strokeColor         : '#28a745',
            pointColor          : '#3b8bba',
            pointStrokeColor    : '#28a745',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: '#28a745',
            data                : $datos[1]
          },
          {
            label               : 'Debitos',
            fillColor           : '#dc3545',
            strokeColor         : '#dc3545',
            pointColor          : '#dc3545',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: '#dc3545',
            data                : $datos[2]
          }
        ]
      }
           //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
      var barChart                         = new Chart(barChartCanvas)
      // barChartData.datasets[1].fillColor   = '#00a65a'
      // barChartData.datasets[1].strokeColor = '#00a65a'
      // barChartData.datasets[1].pointColor  = '#00a65a'
      var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //String - A legend template
        // legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',

          //legendTemplate          : barChartData.datasets[i].label,

        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
      }

      barChartOptions.datasetFill = false
      barChart.Bar(barChartData, barChartOptions)
  }

  var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
  };
</script>
</body>

</html>
