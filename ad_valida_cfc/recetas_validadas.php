<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Recetas Validadas</h5>
            
            <div class="header-elements">
                <div class="list-icons">                    
                <a class="list-icons-item" data-action="reload"></a>            
                </div>
            </div>
        </div>

    <div class="card-body">
        <div class="form-group row">    
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">      
            </div>
            <div class="col-md-2">
                <input type="text" name="caja_busqueda" id="buscador" class="form-control rounded-round" placeholder="Buscar...."></input>
            </div>
      </div>    
    <div class="card-body">
    <?php 
    if(base64_decode($_GET['msj']) == 'md'){
    echo'
    <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        <span class="font-weight-semibold">ATENCION!</span> El Efector se modifico con exito.
    </div>'; }
    if(base64_decode($_GET['msj']) == 'ex'){
    echo'
    <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        <span class="font-weight-semibold">ATENCION!</span> El Efector se creo con exito.
    </div>'; } ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable-highlight">
            <thead>
                <tr class="bg-dark">
                    <th>RECETA</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
                <tbody id="tabla">
                <?php
                $registros = mysqli_query($conexion," SELECT * FROM validaciones ORDER BY id DESC");
                while ($reg=mysqli_fetch_array($registros)){         
                    echo "<tr>"
                    ."<td><span class='badge bg-danger-400'>".$reg['num_receta']."</span></td>"
                    ."<td>"."<a target='_blank' href='../comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
                    <a target='_blank' href='https://aplicaciones.cmpc.org.ar/receta/tmp/".$reg['num_receta'].".pdf'><button type='button' class='btn bg-warning-400 btn-icon '>Receta</button></a>
                </td>"
                    ."</tr>";
                    } ?>
                </tbody>
            </table>
        </div>                    
        <br>
        <div class="form-group">
            <a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $("#buscador").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabla tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>