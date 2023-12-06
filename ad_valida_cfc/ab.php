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
           <h5 class="card-title">Medicamentos AlfaBeta <a href="reporte_ab.php"><button type="button" class="btn btn-info"> Exportar Excel</button></a></h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>
        <div class="card-body">     
        
            <div class="click2edit">
                <div class="row">
                    <form name="form1" method="POST" action="ab.php" id="cdr">
                    <div class="form-group row">
                    <label class="col-form-label col-lg-6">Buscar Medicamento AB</label>
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
                            $busqueda= mysqli_query($conexion,"SELECT *
                            FROM alfabeta_articulos
                            WHERE  nom LIKE '%".$busca."%' OR reg LIKE '%" .$busca."%' OR tro LIKE '%" .$busca."%' OR pres LIKE '%" .$busca."%'");
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicamento</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                              

                                 <?php
                                while($f=mysqli_fetch_array($busqueda)){
                                    echo "<tr>"
                                    ."<td><span class='badge bg-danger-400'>Vigencia ".$f['reg']." | ".$f['troquel']." | ".$f['nom']." | ".$f['pres']." | $ ".$f['prc']."</span></td>"
                                    ."<td>"."<a href=''><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
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