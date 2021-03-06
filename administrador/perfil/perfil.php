<?php 
session_start();
if (!isset($_SESSION['Administrador'])) {
    header("Location: ../logout");
}
include '../../componentes/conexion.php';
include '../../componentes/funciones.php';
echo encabezado('../','Mi perfil', $_SESSION['Administrador']['nombre'].' '.$_SESSION['Administrador']['apellido'], false, $_SESSION['Administrador']['rol'], $_SESSION['Administrador']['id']);
?>

<div class="row">
  <div class="col-md-4">
    <div class="card card-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-danger">
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="<?php echo imagen_perfil('../../assets/img-admin/', '../assets/img-admin/' , $_SESSION['Administrador']['id']) ?>" alt="User Avatar">
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username"><?php echo $_SESSION['Administrador']['nombre'].' '.$_SESSION['Administrador']['apellido'] ?></h3>
        <h5 class="widget-user-desc"><?php echo $_SESSION['Administrador']['rol'] ?></h5>
      </div>
      <div class="card-footer p-0">
        <ul class="nav flex-column">
          <li class="nav-item pt-3 px-3">
            <form  role="form" id="FormImagenPerfil" name="FormImagenPerfil"  action="" method="post"   enctype="multipart/form-data">
              <div style="display: none;" class="alert alert-dismissible div_respuestai">
                <span class="span_respuestai"></span>
              </div>
              <div class="form-group">
                <label for="ImagenPerfil">Cambiar imagen</label>
                <div class="input-group">
                  <div class="custom-file pointer">
                    <input type="file" class="custom-file-input" id="ImagenPerfilAdmin" name="ImagenPerfilAdmin" accept="image/*" required>
                    <label class="custom-file-label ImagenPerfilLabel" for="ImagenPerfil">Nueva imagen</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text pointer bg-info" id="BtnImagenPerfil">Subir</span>
                  </div>
                </div>
              </div>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-7">
      <div class="callout callout-danger py-5 pl-5">
        <h4>Mis datos</h4>
        <address>
            <p class="mb-2"><label class="mb-0 mr-2">Nombre: </label><span><?php echo @$_SESSION['Administrador']['nombre'] ?></span></p>
            <p class="mb-2"><label class="mb-0 mr-2">Apellido: </label><span><?php echo @$_SESSION['Administrador']['apellido'] ?></span></p>
            <p class="mb-2"><label class="mb-0 mr-2">Correo: </label><span><?php echo @$_SESSION['Administrador']['correo'] ?></span></p>
            <p class="mb-2"><label class="mb-0 mr-2">Telefono: </label><span><?php echo @$_SESSION['Administrador']['telefono'] ?></span></p>
            <p class="mb-2"><a href="#!" data-toggle="modal" data-target="#CambiarContraseña" class="text-primary no_link" style="text-decoration: none">Cambiar contraseña</a></p>
            <p class="mb-2"><a href="#!" data-toggle="modal" data-target="#EditarInformacion" class="text-primary no_link" >Editar mi información</a></p>
        </address>
      </div>
  </div>
</div>

<div class="modal fade" id="CambiarContraseña" tabindex="-1" role="dialog" aria-labelledby="CambiarContraseñaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CambiarContraseñaLabel">Cambiar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" name="FormCambiarContraseña" id="FormCambiarContraseña"  data-parsley-validate>
            <div class="card-body p-1">
                <div style="display: none;" class="alert alert-dismissible div_respuesta">
                    <span class="span_respuesta"></span>
                </div>
                <div class="form-group">
                    <label for="clave_actual">Contraseña actual</label>
                    <input type="password" class="form-control" name="clave_actual" class="clave_actual" placeholder="Ingrese su contraseña actual" data-parsley-required >
                </div>
                <div class="form-group">
                    <label for="nueva_clave">Nueva contraseña</label>
                    <input type="password" class="form-control" name="nueva_clave" id="nueva_clave" class="nueva_clave" placeholder="Ingrese la nueva contraseña" data-parsley-required  data-parsley-minlength="5">
                </div>
                <div class="form-group">
                    <label for="repetir_clave">Repetir nueva contraseña</label>
                    <input type="password" class="form-control" name="repetir_clave" class="repetir_clave" placeholder="Repita su nueva contraseña para confirmar"  data-parsley-equalto="#nueva_clave" data-parsley-required>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="CambiarContraseñaAdmin" value="1">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button  class="btn btn-success BtnCambiarContraseña">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EditarInformacion" tabindex="-1" role="dialog" aria-labelledby="EditarInformacionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditarInformacionLabel">Editar Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" name="FormEditarPerfil" id="FormEditarPerfil"  data-parsley-validate>
            <div class="card-body p-1">
                <div style="display: none;" class="alert alert-dismissible div_respuesta">
                    <span class="span_respuesta"></span>
                </div>
                <div class="form-group">
                    <label for="clave_actual">Nombre *</label>
                    <input type="text" class="form-control" name="nombre" class="nombre" value="<?php echo @$_SESSION['Administrador']['nombre'] ?>" data-parsley-required>
                </div>
                <div class="form-group">
                    <label for="nueva_clave">Apellido *</label>
                    <input type="text" class="form-control" name="apellido" class="apellido" value="<?php echo @$_SESSION['Administrador']['apellido'] ?>" data-parsley-required>
                </div>
                <div class="form-group">
                    <label for="repetir_clave">Correo *</label>
                    <input type="hidden" name="correo_actual"value="<?php echo @$_SESSION['Administrador']['correo'] ?>">
                    <input type="email" class="form-control" name="correo" class="correo" value="<?php echo @$_SESSION['Administrador']['correo'] ?>" data-parsley-required>
                </div>
                <div class="form-group">
                    <label for="repetir_clave">Telefono *</label>
                    <input type="tel" class="form-control" name="telefono" class="telefono" value="<?php echo @$_SESSION['Administrador']['telefono'] ?>" data-parsley-required data-parsley-type="number">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="EditarPerfilAdmin" value="1">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button  class="btn btn-success BtnEditarPerfil">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo pie_pagina('../'); ?>                                              
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {

        $('#ImagenPerfilAdmin').on('change', function(){
          $('.ImagenPerfilLabel').text($('#ImagenPerfilAdmin').val())
        })

        $('#BtnImagenPerfil').on('click', function(){
          var formData = new FormData($("form[name=FormImagenPerfil]")[0]);
          $('.div_respuesta').fadeOut('slow')
          if ($('#ImagenPerfilAdmin').val()!='') {
            $.ajax({
              type: "POST",
              dataType: "json",
              url: "../componentes/ajax_perfil.php",
              data: formData, 
              contentType: false,
              processData: false,
              success: function(result){
                  if(result.rps){
                    $('.div_respuestai').removeClass('alert-danger').addClass('alert-success');
                    $('.div_respuestai').removeClass('hidden');
                    $('.span_respuestai').html(result.respuesta)
                    $('.div_respuestai').fadeIn('slow');
                    document.getElementById("FormCambiarContraseña").reset();
                    $('.ImagenPerfilLabel').text('Nueva imagen')
                    setTimeout( function(){
                      $('.div_respuestai').fadeOut('slow')
                    },2000);
                  }else{
                    $('.div_respuestai').removeClass('alert-success').addClass('alert-danger');
                    $('.span_respuestai').html(result.respuesta)
                    $('.div_respuestai').fadeIn('slow');
                    setTimeout( function(){
                      $('.div_respuestai').fadeOut('slow')
                    },2000);
                  }

              },error: function(XMLHttpRequest, textStatus, errorThrown){ 
                  alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
              }
            });
          }
        })

        $("form[name=FormCambiarContraseña]").submit(function() {
            event.preventDefault()
            $('.div_respuesta').fadeOut('slow');
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "../componentes/ajax_perfil.php", 
               data: $("form[name=FormCambiarContraseña]").serialize(),
               success: function(result){
                  if(result.rps){
                    $('.div_respuesta').removeClass('alert-danger').addClass('alert-success');
                    $('.div_respuesta').removeClass('hidden');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                    document.getElementById("FormCambiarContraseña").reset();
                    setTimeout( function(){
                      $('.div_respuesta').fadeOut('slow')
                    },2000);

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

        $("form[name=FormEditarPerfil]").submit(function() {
            event.preventDefault()
            $('.div_respuesta').fadeOut('slow');
            //$('.div_respuesta').addClass('alert-success');
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "../componentes/ajax_perfil.php", 
               data: $("form[name=FormEditarPerfil]").serialize(),
               success: function(result){
                  if(result.rps){
                    $('.div_respuesta').removeClass('alert-danger').addClass('alert-success');
                    $('.div_respuesta').removeClass('hidden');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
                  }else{
                    $('.div_respuesta').removeClass('alert-success').addClass('alert-danger');
                    $('.span_respuesta').html(result.respuesta)
                    $('.div_respuesta').fadeIn('slow');
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
