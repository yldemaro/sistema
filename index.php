<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/dist/css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-8" style="padding: 32px;">
        <h3 class="text-center texto">Noticias</h3>
        <div class="card">
          <div class="card-body">
            <div class="card-title">Titulo de Texto 1</div>
            <div class="card-subtitle">Subtitulo 1</div>
          </div>
          <div class="pad card-text">
            <a href=""><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet assumenda, ad velit consequatur fuga molestias, fugiat, nihil ducimus optio tempore explicabo sapiente, nobis nulla neque unde incidunt nisi veniam minima.</p></a>
            <small>06/06/2018</small>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="card-title">Titulo de Texto 2</div>
            <div class="card-subtitle">Subtitulo 2</div>
          </div>
          <div class="pad card-text">
            <a href=""><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut laudantium minima itaque in neque eum qui consequuntur voluptas consectetur, sunt similique soluta odio? Nam molestias consectetur laborum assumenda vel quod!</p></a>
            <small>06/06/2018</small>
          </div>

        </div>
      </div>
      <div class="pad col-xs-12 col-md-4">
        <div class="contenedorsesion" class="card">
          <div style="padding: 3em;" class="card-body">
           <div class="text-center my-2">
            <img class="imgsesion" width="80" height="80" src="assets/img-usuario/default.png" alt="">
            <p class="iniciar login-box-msg">Iniciar Sesión</p>
            <form name="FormIniciarSesion" class="md-float-material" >
              <div style="display: none;" class="alert alert-dismissible div_respuesta">
                <span class="span_respuesta"></span>
              </div>

              <p class="texto text-inverse b-b-default text-left p-b-5">Ingresa tus datos</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="far fa-envelope"></i></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Correo electronico">
                <span class="md-line"></span>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="password">
                <span class="md-line"></span>
              </div>


              <div class="row m-t-30">
                <div class="col-md-12">
                  <input type="hidden" name="IniciarSesion" value="1">
                  <button type="submit" class="boton btn btn-primary btn-md waves-effect text-center m-b-20">ACCEDER</button>
                </div>
              </div>
              <p class="mb-2 mt-2">
                <a  href="#!" data-toggle="modal" data-target="#RecuperarContraseña" >¿Olvidaste tu contraseña?</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="RecuperarContraseña" tabindex="-1" role="dialog" aria-labelledby="RecuperarContraseñaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="recuperar modal-content">
      <div class="modal-header">
        <h5 class="text-white modal-title" id="RecuperarContraseñaLabel">Recuperar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" name="FormRecuperarContraseña" id="FormRecuperarContraseña" data-parsley-validate>
          <p class="texto">Por favor ingrese su correo para iniciar el proceso de recuperacion de contraseña.</p>
          <div class="card-body p-1">
            <div style="display: none;" class="alert alert-dismissible div_respuestar">
              <span class="span_respuestar"></span>
            </div>
            <div class="form-group">
              <label class="texto" for="correo">Correo Electrónico</label>
              <input type="email" class="form-control" name="correo" class="correo" data-parsley-required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="RecuperarContraseña" value="1">
          <button  class="botonrecuperar btn btn-success BtnRecuperarContraseña">Recuperar</button>
          <button type="button" class="boton2 btn btn-danger" data-dismiss="modal">Cerrar</button>
          
        </form>
      </div>
    </div>
  </div>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })

    $("form[name=FormIniciarSesion]").submit(function() {

      $("button[type=submit]").attr('disabled', 'disabled').html("<em class='fa fa-spin fa-spinner'></em> Accediendo");
      $('.div_respuesta').fadeOut('slow');
      $.ajax({
       type: "POST",
       dataType: "json",
       url: "componentes/ajax_login.php", 
       data: $("form[name=FormIniciarSesion]").serialize(),
       success: function(result){
        if(result.rps){
          if (result.tipo=='1') {
            window.location='admin/lista-usuarios'
          }else{
            window.location='principal'
          }

        }else{
          $("button[type=submit]").removeAttr('disabled').html('ACCEDER')
          $('.div_respuesta').removeClass('alert-success').addClass('alert-danger');
          $('.div_respuesta').removeClass('hidden');
          $('.span_respuesta').html(result.respuesta)
          $('.div_respuesta').fadeIn('slow');
        }

      },error: function(XMLHttpRequest, textStatus, errorThrown){ 
        alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
      }
    });

      return false;
    });


    $("form[name=FormRecuperarContraseña]").submit(function() {

      $(".BtnRecuperarContraseña").attr('disabled', 'disabled').html("Enviando...");
      $('.div_respuestar').fadeOut('slow');
      $.ajax({
       type: "POST",
       dataType: "json",
       url: "componentes/ajax_login.php", 
       data: $("form[name=FormRecuperarContraseña]").serialize(),
       success: function(result){
        if(result.rps){
          $("button[type=submit]").removeAttr('disabled').html('ACCEDER')
          $('.div_respuestar').removeClass('alert-danger').addClass('alert-success');
          $('.div_respuestar').removeClass('hidden');
          $('.span_respuestar').html(result.respuesta)
          $('.div_respuestar').fadeIn('slow');
        }else{
          $("button[type=submit]").removeAttr('disabled').html('ACCEDER')
          $('.div_respuestar').removeClass('alert-success').addClass('alert-danger');
          $('.div_respuestar').removeClass('hidden');
          $('.span_respuestar').html(result.respuesta)
          $('.div_respuestar').fadeIn('slow');
        }
        $(".BtnRecuperarContraseña").removeAttr('disabled').html("Recuperar");
      },error: function(XMLHttpRequest, textStatus, errorThrown){ 
        alert('Ha ocurrido un error inesperado, por favor contacte a soporte')
      }
    });

      return false;
    });
  });

</script>
</body>
</html>


