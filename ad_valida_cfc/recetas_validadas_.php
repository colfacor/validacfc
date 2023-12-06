<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>
<!-- Content area -->
<div class="content">
        <!-- Form validation -->
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
        
            <div class="click2edit">
                <div class="row">
                    <form name="form1" method="POST" action="recetas_validadas_.php" id="cdr">
                    <div class="form-group row">
                    <label class="col-form-label col-lg-6">Buscar Recetas</label>
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="" id="num_receta" name="busca">
                                <span class="input-group-prepend"><button type="submit" class="btn btn-primary btn-icon"><i class="icon-search4"></i></button></span></span>
                    </form>
                            </div>
                            <?php 
                            $busca="";
                            $busca=$_POST['busca'];
                            if($busca!=""){
                            $busqueda= mysqli_query($conexion,"SELECT a.num_receta, a.num_validacion, b.linkreceta
                            FROM validaciones a 
                            LEFT JOIN recetas b 
                            ON a.num_receta = b.num_receta
                            WHERE  a.num_receta LIKE '%".$busca."%' OR a.num_validacion LIKE '%" .$busca."%'");
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Receta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                              

                                 <?php
                                while($f=mysqli_fetch_array($busqueda)){
                                    echo "<tr>"
                                    ."<td><span class='badge bg-danger-400'>".$f['num_receta']."</span></td>"
                                    ."<td>"."<a target='_blank' href='../comprobantepdf.php?num_validacion=".base64_encode($f['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
                                    <a target='_blank' href='".$f['linkreceta']."'><button type='button' class='btn bg-warning-400 btn-icon '>Receta</button></a>
                                </td>"
                                    ."</tr>";  } } 
                                ?>
                                </tbody>
                            </table>    
                        </div>  
                    </div>
                </div><a href="home_psico.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
            </div>
        </div>
    </div>
    <?php 
    include('inc/conexion.php');
    $num_receta = base64_decode($_GET['num_receta']);
    $lista7 =("SELECT * FROM validaciones
    WHERE validaciones LIKE '$validaciones' LIMIT 1");
    $rs7 = mysqli_query($conexion,$lista7);
    $row7 = mysqli_fetch_array($rs7); 
    $validaciones = $row7['validaciones'];
   
    $lista2 =("SELECT MAX(num_receta) as num_receta FROM validaciones");
    $rs2 = mysqli_query($conexion,$lista2);
    $row = mysqli_fetch_array($rs2); 
    $num_receta = $row['num_receta'] + 1;

       
    ?>

