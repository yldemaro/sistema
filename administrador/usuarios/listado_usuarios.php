<?php 
session_start();
if (!isset($_SESSION['Administrador'])) {
    header("Location: ../logout");
}
include '../../componentes/conexion.php';
include '../../componentes/funciones.php';

echo encabezado('../', 'Listado de Usuarios', $_SESSION['Administrador']['nombre'].' '.$_SESSION['Administrador']['apellido'], true, $_SESSION['Administrador']['rol'], $_SESSION['Administrador']['id']);
?>
    <div class="col">
        <div class="card card-danger">
            <div class="card-header py-3">
                <h3 class="card-title inline">
                    <i class="fa fa-users mr-2"></i> Usuarios
                </h3>
                <div class="pull-right">
                    <a href="usuario-nuevo" class="btn btn-xs btn-success"><em class="fa fa-plus"></em>  Nuevo usuario</a>
                </div>
            </div>
            <div class="card-body px-5 py-5">              
               <div>
                    <table style="width: 100%;" id="tabla-lista-usuarios"  class="table responsive">
                        <thead>
                            <tr>
                                <th class="all" style="width: 50px">Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Estado</th>
                                <th class="all">Puntos</th>
                                <th>Fecha</th>
                                <th class="all" style="width: 80px;">Acciones</th>
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
        $(".loader").fadeOut("slow");
    });//FIN READY

    var table = $("#tabla-lista-usuarios").DataTable({
                        "processing": true,
                        ajax: "../componentes/ajax_tablas.php?tipo=ListaUsuarios",
                        "order": [[5, "desc"]],
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
                // $('#tabla-lista-usuarios_filter').css('position','absolute')
                // $('#tabla-lista-usuarios_filter').css('right','10px')
                // $('#tabla-lista-usuarios_filter').css('top','0')

                // $('#tabla-lista-usuarios_paginate').css('position','absolute')
                // $('#tabla-lista-usuarios_paginate').css('right','8px')
                // $('#tabla-lista-usuarios_paginate').css('bottom','0')

                // $('#tabla-lista-usuarios_wrapper .dt-buttons').css('margin-left','10px')
                // $('#tabla-lista-usuarios_wrapper select').css('margin-left','5px')
                // $('#tabla-lista-usuarios_wrapper select').css('margin-right','5px')

            } );

    function eliminarUsuario($user, $nombre){

        swal("¡Atención!", "¿Esta seguro de eliminar al usuario "+$nombre+"? Recuerde que este proceso es irreversible.", {
            buttons: {
                cancel: {
                    text: "Cancelar",
                    className: "bg-danger",
                    closeModal: true,
                    visible: true,
                    value: false
                },
                confirm: {
                    text: "Sí, eliminarlo",
                    className: "bg-success",
                    value: true,
                    visible: true,
                },
            }
        })
        .then((value) => {
            if (value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "../componentes/ajax_perfil.php",
                    data: {'EliminarUsuario': $user }, 
                    success: function(result){
                        if(result.rps){
                          swal("Bien", result.respuesta, "success");
                          table.ajax.reload( null, false );
                        }else{
                          swal("¡Ups!", result.respuesta, "error");
                        }

                    },error: function(XMLHttpRequest, textStatus, errorThrown){ 
                        alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
                    }
                });
            }
        });
    }
</script>
</body>

</html>
