<?php 
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
$user =("SELECT nombre, apellido, perfil FROM usuarios WHERE dni = '$dni'");
$r = mysqli_query($conexion,$user);
$rs = mysqli_fetch_array($r); 
$nombre = $rs['nombre'];
$apellido = $rs['apellido'];
$perfil = $rs['perfil'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ADMIN VALIDADOR CFC</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
    
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="global_assets/js/main/jquery.min.js"></script>
    <script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="global_assets/js/plugins/ui/slinky.min.js"></script>
    <script src="global_assets/js/plugins/ui/fab.min.js"></script>

    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="global_assets/js/plugins/pickers/daterangepicker.js"></script>
    <script src="global_assets/js/demo_pages/components_modals.js"></script>
    <script src="global_assets/js/plugins/notifications/bootbox.min.js"></script>
    
    <script src="assets/js/app.js"></script>
    <script src="global_assets/js/demo_pages/dashboard.js"></script>

        <!-- Theme JS files -->
    <script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="global_assets/js/demo_pages/form_select2.js"></script>

        <script src="global_assets/js/plugins/forms/inputs/typeahead/handlebars.min.js"></script>
    <script src="global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
    <script src="global_assets/js/plugins/forms/inputs/alpaca/alpaca.min.js"></script>
    <script src="global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="global_assets/js/plugins/ui/prism.min.js"></script>
    <!-- /theme JS files -->


        <script src="global_assets/js/plugins/forms/wizards/steps.min.js"></script>
    <script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="global_assets/js/plugins/forms/inputs/inputmask.js"></script>
    <script src="global_assets/js/plugins/forms/validation/validate.min.js"></script>
    <script src="global_assets/js/plugins/extensions/cookie.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <!-- /theme JS files -->
    <script src="assets/js/app.js"></script>
    <script src="global_assets/js/demo_pages/form_wizard.js"></script>
    
    <script src="global_assets/js/demo_pages/alpaca_basic.js"></script>







    <!-- Theme JS files -->
    <script src="../../../../global_assets/js/plugins/forms/inputs/typeahead/handlebars.min.js"></script>
    <script src="../../../../global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
    <script src="../../../../global_assets/js/plugins/forms/inputs/alpaca/alpaca.min.js"></script>
    <script src="../../../../global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="../../../../global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/prism.min.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="../../../../global_assets/js/demo_pages/alpaca_basic.js"></script>
    <!-- /theme JS files -->
</head>
<body>
<!-- Page header -->
<div class="page-header page-header-dark">
    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark border-transparent">
        <div class="navbar-brand wmin-0 mr-5">
            <a href="home.php" class="d-inline-block">
                <img src="" alt="">
            </a>
        </div>
        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-mobile">
            <span class="badge bg-success-400">Admin Validador CFC</span>
            <ul class="navbar-nav ml-md-auto">  
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <span><?php echo $apellido ?> <?php echo $nombre ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="cambiarcontrasena.php" class="dropdown-item"><i class="icon-lock"></i> Cambiar Contraseña</a>
                        <a href="logout.php" class="dropdown-item"><i class="icon-switch2"></i> Salir</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>Inicio <small class="font-size-base opacity-50">Bienvenido al Admin Validacion CFC</small></h4>
            <a href="#" class="header-elements-toggle text-white d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="navbar navbar-expand-md navbar-dark border-top-0">
        <div class="d-md-none w-100">
            <button type="button" class="navbar-toggler d-flex align-items-center w-100" data-toggle="collapse" data-target="#navbar-navigation">
                <i class="icon-menu-open mr-2"></i>
                Menu
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-navigation">
            <ul class="navbar-nav navbar-nav-highlight">
                <li class="nav-item">
                    <a href="home.php" class="navbar-nav-link active">
                        <i class="icon-home4 mr-2"></i>
                        Inicio
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-highlight">
                <li class="nav-item">
                    <a href="home_psico.php" class="navbar-nav-link active">
                        <i class="icon-file-check2 mr-2"></i>
                        PROGRAMA MUNICIPALIDAD MEJORAR
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="content-wrapper">
        <div class="content">
            <!-- Main charts -->
            <div class="row">
                <div class="col-xl-7">
                </div>              
            </div>
<?php
$num_cierre = base64_decode($_GET['num_cierre']);


$obr =("SELECT a.id_obrasocial, a.periodo, a.cuit_farm, a.suc_farm, b.num_receta, b.tf, c.num_validacion, d.obra_social, e.farmacia
                                FROM cierres_lotes a 
                                LEFT JOIN detalle_cierres b 
                                ON a.num_cierre = b.num_cierre
                                LEFT JOIN validaciones c 
                                ON b.num_receta = c.num_receta
                                LEFT JOIN obras_sociales d 
                                ON a.id_obrasocial = d.id
                                LEFT JOIN users e 
                                ON e.cuit = a.cuit_farm AND e.idsucursal = a.suc_farm
                                WHERE a.num_cierre = '$num_cierre'");
$r1 = mysqli_query($conexion, $obr);
$rs1 = mysqli_fetch_array($r1); 
$periodo = $rs1['periodo'];
$obra_social = $rs1['obra_social'];
$farmacia = $rs1['farmacia'];
$cuit_farm = $rs1['cuit_farm'];
$suc_farm = $rs1['suc_farm'];



$obr =("SELECT COUNT(num_receta) as tot_rec
FROM detalle_cierres 
WHERE num_cierre = '$num_cierre'");
$r1 = mysqli_query($conexion, $obr);
$rs1 = mysqli_fetch_array($r1); 
$tot_rec = $rs1['tot_rec'];
?>
<style>
    .highlight {
        color: red;
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <script>
        // Arreglo para llevar un registro de los códigos ya escaneados
        var codigosEscaneados = [];

        // Función para manejar la verificación del número de validación y marcar el checkbox si coincide
        function handleValidationNumber(inputId) {
            var input = document.getElementById(inputId);
            var validationNumber = input.value;

            // Verificar si el código ya fue escaneado
            if (codigosEscaneados.includes(validationNumber)) {
                alert("Este código ya ha sido escaneado anteriormente.");
            } else {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    var dataValidationNumber = checkbox.getAttribute('data-validation-number');
                    if (dataValidationNumber === validationNumber) {
                        checkbox.checked = true;
                        input.value = ''; // Limpiar el campo de entrada
                        // Registrar el código escaneado
                        codigosEscaneados.push(validationNumber);
                    }
                });
            }

            setTimeout(function() {
                input.focus(); // Enfocar nuevamente el campo de entrada después de un breve retraso
            }, 0);
        }
    </script>


<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">FARMACIA: <?php echo $farmacia ?> | CUIT: <?php echo $cuit_farm ?> SUC: <?php echo $suc_farm ?></h5>
        <div class="header-elements">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <label class="d-block font-weight-semibold">SELECCIONE RECETAS QUE INCLUIRÁ EN EL CIERRE DE <?php echo $obra_social ?></label><br>
                <label class="highlight"  class="d-block font-weight-semibold">Periodo Cerrado:  <?php echo $periodo ?>   |    TOTAL RECETAS CERRADAS: <?php echo $tot_rec ?></label><br><br>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 font-weight-semibold text-success">ESCANEAR CODIGO AQUI</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control border-success" id="validationInput" oninput="handleValidationNumber('validationInput')" placeholder="Escanea Aqui" >
                    </div>
                </div>
 
                <form action="" method="POST">
                    <div class="form-group">

                         <?php
                            $registros = mysqli_query($conexion, "SELECT a.id_obrasocial, a.periodo, a.cuit_farm, a.suc_farm, b.num_receta, b.tf, c.num_validacion, c.num_receta
                                FROM cierres_lotes a 
                                LEFT JOIN detalle_cierres b 
                                ON a.num_cierre = b.num_cierre
                                LEFT JOIN validaciones c 
                                ON b.num_receta = c.num_receta
                                WHERE a.num_cierre = '$num_cierre'");
                            while ($rs = mysqli_fetch_array($registros)) {
                                echo '
                            <div class="custom-control custom-checkbox">
                                <td>' . $rs['num_validacion'] . ' | ' . $rs['num_receta'] . ' | $ ' . $rs['tf'] . '</td>
                                <td><input type="checkbox" id="checkbox' . $rs['num_receta'] . '" data-validation-number="'.$rs['num_receta'].'"></td>
                             </div>
                             <input type="hidden" name="tf[]" value="'.$reg['tf'].'">
                            <hr>';
                            } ?>
                    </div>
                    <br>
                    <div class="form-group">
                        <a href="auditoria_cierre.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>