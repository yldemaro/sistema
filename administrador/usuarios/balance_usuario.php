<?php 
session_start();
if (!isset($_SESSION['Administrador'])) {
    header("Location: ../logout");
}
include '../../componentes/conexion.php';
include '../../componentes/funciones.php';
include '../../componentes/consultas.php';
$BD = new BD();
$conexiondb = $BD->conectar();
$id   = trim($conexiondb->real_escape_string($_GET["id"]));
$DatosUsuario = SELECT_datos_usuario_id($id);
$conexiondb->close();
echo encabezado('../', 'Balance de puntos de '.$DatosUsuario['nombre_completo'], $_SESSION['Administrador']['nombre'].' '.$_SESSION['Administrador']['apellido'], true, $_SESSION['Administrador']['rol'], $_SESSION['Administrador']['id']);  
?>
    <div class="col-md-12">
        <div class="col-md-3">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><span class="balance_puntos"><?php echo number_format(balance_puntos_usuario($DatosUsuario['id']),2,'.',',') ?></span><sup style="font-size: 20px">Pts.</sup></h3>

                <p>Disponible</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart"></i>
              </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-body">
                    <form role="form" name="FormRecargarPuntos" id="FormRecargarPuntos">
                <div class="card-body p-1">
                    <div style="display: none;" class="alert alert-dismissible div_respuesta">
                        <span class="span_respuesta"></span>
                    </div>
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" class="form-control" name="monto" class="monto" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label for="concepto">Concepto</label>
                        <input type="text" class="form-control" name="concepto" class="concepto"  required>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="tipo" value="1" class="flat-green" checked required>
                            Credito
                        </label>
                        <label>
                            <input type="radio" name="tipo" value="2" class="flat-red">
                            Debito
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="RecargarPuntos" value="<?php echo $_GET['id'] ?>">
                        <button class="btn btn-sm btn-success">Enviar</button>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"><a href="lista-usuarios"><i class="fas fa-undo-alt"></i></a> Movimientos</h3>
            </div>
            <div class="card-body px-5 py-5">
                <form name="FormConsultarMovimientos">
                    <div class="row">
                        <div class="col">
                            <label>Desde:</label>
                            <input type="text" name="desde" id="desde"  class="form-control" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Hasta:</label>
                            <input type="text" name="hasts" id="hasta"  class="form-control" autocomplete="off">
                        </div>
                        <div class="col pt-1">
                            <br>
                            <button class="btn btn-block btn-success" id="BtnConsultarMovimientos">Consultar</button>
                        </div>
                    </div>
                </form>
                <hr>
               
               <div>
                    <table style="width: 100%;" id="tabla-lista-balance-puntos-usuario"  class="table">
                        <thead>
                            <tr>
                                <th class="all" style="width: 50px">Fecha</th>
                                <th>Administrador</th>
                                <th>Concepto</th>
                                <th class="all">Credito</th>
                                <th class="all">Debito</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                   </div>
            </div>
          <!-- /.card-body -->
        </div>
    </div>

    

<?php echo pie_pagina('../'); ?>                                           
<script type="text/javascript">
    $(document).ready( function () {

        ICheck()
        $('#desde').datepicker({
            language: "es", 
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
         });

        $('#hasta').datepicker({
            language: "es", 
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        var table = $("#tabla-lista-balance-puntos-usuario").DataTable({
                        "processing": true,
                        ajax: "../componentes/ajax_tablas.php?tipo=ListaPuntos&id=<?php echo $_GET['id'] ?>",
                        "order": [[0, "desc"]],
                        "pageLength": 50,
                        dom:"lBfrtip",

                        "columnDefs": [{
                            "targets": 'no-sort',
                            "orderable": false
                        }],
                        buttons:[{
                            extend:"excel",
                            className:"btn-sm",
                            exportOptions: {
                            columns: ':not(:last-child)',
                            }
                        },{
                            extend:"pdf",
                            className:"btn-sm",
                            exportOptions: {
                            columns: ':not(:last-child)',
                            }
                        },{
                            extend:"print",
                            className:"btn-sm",
                            exportOptions: {
                            columns: ':not(:last-child)',
                            }
                        }],
                        responsive:1,
                        autoFill:!0,
                        colReorder:!0,
                        keys:!0,
                        rowReorder:!0,
                        select:!0}
                    )
        
            table.on( 'init.dt', function ( e, settings ) {
                // $('#tabla-lista-balance-puntos-usuario_filter').css('position','absolute')
                // $('#tabla-lista-balance-puntos-usuario_filter').css('right','10px')
                // $('#tabla-lista-balance-puntos-usuario_filter').css('top','0')

                // $('#tabla-lista-balance-puntos-usuario_paginate').css('position','absolute')
                // $('#tabla-lista-balance-puntos-usuario_paginate').css('right','8px')
                // $('#tabla-lista-balance-puntos-usuario_paginate').css('bottom','0')

                // $('#tabla-lista-balance-puntos-usuario_wrapper .dt-buttons').css('margin-left','10px')
                // $('#tabla-lista-balance-puntos-usuario_wrapper select').css('margin-left','5px')
                // $('#tabla-lista-balance-puntos-usuario_wrapper select').css('margin-right','5px')

                

            } );

        $("form[name=FormConsultarMovimientos]").submit(function() {
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();

            table.ajax.url( '../componentes/ajax_tablas.php?tipo=ListaPuntos&id=<?php echo $_GET['id'] ?>&desde='+desde+'&hasta='+hasta ).load();
            return false
        })

        $("form[name=FormRecargarPuntos]").submit(function() {
            event.preventDefault()
            $('.div_respuesta').fadeOut('slow');
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "../componentes/ajax_balance.php", 
               data: $("form[name=FormRecargarPuntos]").serialize(),
               success: function(result){
                  if(result.rps){
                    $('.div_respuesta').removeClass('alert-danger').addClass('alert-success');
                    $('.div_respuesta').removeClass('hidden');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                    $('.balance_puntos').html(result.puntos)
                    document.getElementById("FormRecargarPuntos").reset();
                    setTimeout( function(){
                      $('.div_respuesta').fadeOut('slow')
                    },2000);
                    table.ajax.reload( null, false );
                  }else{
                    $('.div_respuesta').removeClass('alert-success').addClass('alert-danger');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                    setTimeout( function(){
                      $('.div_respuesta').fadeOut('slow')
                    },2000);

                  }

               },error: function(XMLHttpRequest, textStatus, errorThrown){ 
                  alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
               }
            });
        })

        $(".loader").fadeOut("slow");
    } );
</script>
</body>

</html>
