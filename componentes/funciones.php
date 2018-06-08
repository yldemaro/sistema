<?php

function encabezado($ruta, $titulo, $nombre_usuario,$b3 = 0, $rol, $id){
  return '
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>'.$titulo.'</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" >
    <!-- Theme style -->
    <link rel="stylesheet" href="'.$ruta.'assets/dist/css/adminlte.css">
    <!-- Theme style personalizados -->
    <link rel="stylesheet" href="'.$ruta.'assets/dist/css/estilos_personalizados.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    '.(($b3)?'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">':'').'
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.css"/>
    <link rel="stylesheet" href="'.$ruta.'assets/plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="'.$ruta.'assets/plugins/iCheck/all.css">
 
  </head>
  <body class="hold-transition sidebar-mini">
  <div class="loader"></div>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link ml-4" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#!" class="brand-link">
      <span class="brand-text font-weight-light">Sistema</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          '.(($rol=='Empleado')?'
                <img src="'.imagen_perfil('../../assets/img-usuario/', 'assets/img-usuario/' , $id).'" class="img-circle elevation-2" alt="User Image">
            ':'<img src="'.imagen_perfil('../../assets/img-admin/', '../assets/img-admin/' , $id).'" class="img-circle elevation-2" alt="User Image">').'
          
        </div>
        <div class="info">
          <a href="mi-perfil" class="d-block">'.$nombre_usuario.'</a>
          <span class="label label-success">'.$rol.'</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 

          '.(($rol == 'Administrador')?
            '
            <li class="nav-item">
              <a href="lista-usuarios" class="nav-link">
                <i class="fa fa-users mr-2"></i>
                <p>
                  Lista de Usuarios
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="balance-general" class="nav-link">
                <i class="fa fa-list-alt mr-2"></i>
                <p>
                  Balance General
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="mi-perfil" class="nav-link">
                <i class="fa fa-user-tie mr-2"></i>
                <p>
                  Mi perfil
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="../logout" class="nav-link">
                <i class="fa fa-sign-out-alt mr-2"></i>
                <p>
                  Salir
                </p>
              </a>
            </li>
            ':
            '
            <li class="nav-item">
              <a href="principal" class="nav-link">
                <i class="fa fa-home mr-2"></i>
                <p>
                  Inicio
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="balance" class="nav-link">
                <i class="fa fa-list-alt mr-2"></i>
                <p>
                  Balance
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="mi-perfil" class="nav-link">
                <i class="fa fa-user-tie mr-2"></i>
                <p>
                  Mi perfil
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="logout" class="nav-link">
                <i class="fa fa-sign-out-alt mr-2"></i>
                <p>
                  Salir
                </p>
              </a>
            </li>
            ').'

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

  ';

}

function pie_pagina($ruta){
  return '  
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer" style="font-size: 8px">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <small>
        <strong>Copyright © 2014-2016 <a target="_blank" href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
      reserved.
      </small>
    </footer>
    <!-- Add the sidebar"s background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="'.$ruta.'assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SlimScroll -->
    <script src="'.$ruta.'assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="'.$ruta.'assets/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="'.$ruta.'assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="'.$ruta.'assets/dist/js/demo.js"></script>
    
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/sc-1.4.4/datatables.min.css"/>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.js"></script>

    <!-- bootstrap time picker -->
    <script src="'.$ruta.'assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="'.$ruta.'assets/plugins/iCheck/icheck.min.js"></script><!-- ChartJS 1.0.1 -->
    <script src="'.$ruta.'assets/plugins/chartjs-old/Chart.min.js"></script>
    <script src="'.$ruta.'assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script type="text/javascript">
      $(document).ready( function () {
        
      })
      function ScrollTop(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
      }
      function ICheck(){
        //iCheck for checkbox and radio inputs
        $(\'input[type="checkbox"].minimal, input[type="radio"].minimal\').iCheck({
          checkboxClass: \'icheckbox_minimal-blue\',
          radioClass   : \'iradio_minimal-blue\'
        })
        //Red color scheme for iCheck
        $(\'input[type="checkbox"].minimal-red, input[type="radio"].minimal-red\').iCheck({
          checkboxClass: \'icheckbox_minimal-red\',
          radioClass   : \'iradio_minimal-red\'
        })
        //Flat red color scheme for iCheck
        $(\'input[type="checkbox"].flat-green, input[type="radio"].flat-green\').iCheck({
          checkboxClass: \'icheckbox_flat-green\',
          radioClass   : \'iradio_flat-green\'
        })

        $(\'input[type="checkbox"].flat-red, input[type="radio"].flat-red\').iCheck({
          checkboxClass: \'icheckbox_flat-red\',
          radioClass   : \'iradio_flat-red\'
        })
      }
    </script>
    </body>
    </html>';
}

function Fecha(){
  date_default_timezone_set('America/Los_Angeles');
  return date('Y-m-d H:i:s');
}

function imagen_perfil($ruta_b, $ruta_m , $id){
  if(file_exists($ruta_b.$id.'.jpg')){

    return $ruta_m.$id.'.jpg';

  }else if(file_exists($ruta_b.$id.'.png')){

    return $ruta_m.$id.'.png';

  }else if(file_exists($ruta_b.$id.'.jpeg')){

    return $ruta_m.$id.'.jpeg';
  }else{
    return $ruta_m.'default.png';
  }
}

function enviar_email($usuario, $email, $asunto, $mensaje){

  $cuerpo = "
  
  <p>Hola $usuario</p>

  <p>
    ".$mensaje."
  </p>

  <p>
    Saludos<br>
  </p>";
  //para el envio en formato HTML
  $headers = "MIME-Version: 1.0\r\n";
  $headers.= "Content-type: text/html; charset=utf-8\r\n";
  //direccion del remitente
  $headers.= "From: RetailsPOS <noresponder@gmail.com>\r\n";
  //direccion de respuesta, si queremos que sea distinta que la del remitente
  $headers.= "Reply-To: noresponder@gmail.com\r\n";
  //ruta del mensaje desde origen a destino
  $headers.= "Return-path: noresponder@gmail.com\r\n";
  mail($email,$asunto,$cuerpo,$headers);
}

function generar_contrasena(){

  $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $str1 = "abcdefghijklmnopqrstuvwxyz";
  $str2 = "1234567890";

  $clave = "";

  for($i=0;$i<2;$i++){
    $clave .= substr($str,rand(0,26),1);
  }

  for($i=0;$i<1;$i++){
    $clave .= substr($str2,rand(0,10),1);
  }

  for($i=0;$i<3;$i++){
    $clave .= substr($str1,rand(0,26),1);
  }

  return $clave;
}

?>
