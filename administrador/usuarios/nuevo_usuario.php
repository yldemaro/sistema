<?php 
session_start();
if (!isset($_SESSION['Administrador'])) {
    header("Location: ../logout");
}
include '../../componentes/conexion.php';
include '../../componentes/funciones.php';
echo encabezado('../','Nuevo usuario', $_SESSION['Administrador']['nombre'].' '.$_SESSION['Administrador']['apellido'], false, $_SESSION['Administrador']['rol'], $_SESSION['Administrador']['id']);
?>
<div class="col-md-6 offset-md-3">
  <div class="card card-danger">
    <div class="card-header">
      <h5 class="card-title inline" style="font-size: .9rem;">
        <a href="lista-usuarios"><i class="fas fa-undo-alt"></i></a> Nuevo Usuarios
      </h5>
    </div>
    <div class="card-body px-3 py-3"> 
      <form role="form" name="FormNuevoUsuario" id="FormNuevoUsuario" data-parsley-validate>
        <div class="card-body p-1">
            <div style="display: none;" class="alert alert-dismissible div_respuesta">
                <span class="span_respuesta"></span>
            </div>
            <div class="form-group">
                <label for="clave_actual">Nombre *</label>
                <input type="text" class="form-control" name="nombre" class="nombre" data-parsley-required>
            </div>
            <div class="form-group">
                <label for="nueva_clave">Apellido *</label>
                <input type="text" class="form-control" name="apellido" class="apellido" data-parsley-required>
            </div>
            <div class="form-group">
                <label for="repetir_clave">Correo *</label>
                <input type="email" class="form-control" name="correo" class="correo" data-parsley-required>
            </div>
            <div class="form-group">
                <label for="clave">Contraseña *</label>
                <input type="password" class="form-control" name="clave" id="clave" class="clave" placeholder="Ingrese la nueva contraseña" data-parsley-required data-parsley-minlength="5">
            </div>
            <div class="form-group">
                <label for="repetir_clave">Repetir contraseña *</label>
                <input type="password" class="form-control" name="repetir_clave" class="repetir_clave" placeholder="Repita su nueva contraseña para confirmar"  data-parsley-equalto="#clave" data-parsley-required >
            </div>
            <div class="form-group">
                <label for="repetir_clave">Telefono *</label>
                <input type="tel" class="form-control" name="telefono" class="telefono" data-parsley-required data-parsley-type="number">
            </div>
            <div class="form-group">
                <label for="repetir_clave">Direccion *</label>
                <input type="text" class="form-control" name="direccion" class="direccion"  data-parsley-required>
            </div>
            <div class="form-group">
                <input type="hidden" name="NuevoUsuario" value="1">
                <button  class="btn btn-success BtnNuevoUsuario">Guardar</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php echo pie_pagina('../'); ?>                                              
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {

        $("form[name=FormNuevoUsuario]").submit(function() {
            event.preventDefault()
            $('.div_respuesta').fadeOut('slow');
            //$('.div_respuesta').addClass('alert-success');
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "../componentes/ajax_perfil.php", 
               data: $("form[name=FormNuevoUsuario]").serialize(),
               success: function(result){
                  if(result.rps){
                    $('.div_respuesta').removeClass('alert-danger').addClass('alert-success');
                    $('.div_respuesta').removeClass('hidden');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                    document.getElementById("FormNuevoUsuario").reset();
                    ScrollTop()
                  }else{
                    $('.div_respuesta').removeClass('alert-success').addClass('alert-danger');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                    ScrollTop()
                  }

               },error: function(XMLHttpRequest, textStatus, errorThrown){ 
                  alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
               }
            });
        })
        $(".loader").fadeOut("slow");
    });
</script>
</body>

</html>
