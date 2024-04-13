<?php 
session_start(); 
require_once "../mysqli/conexion.php";
$conecta = new Conexion(); 
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';  ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include 'menu.php';  ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include 'menu_horizotal.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
          <p class="mb-4"></p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Registro de usuario</h6>
              <a href="#" class="btn btn-success btn-circle float-right" data-toggle="modal" data-target="#usuario">
                <i class="fas fa-plus"></i>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dtusu" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>CÉDULA</th>
                      <th>NOMBRE Y APELLIDO</th>
                      <th>USUARIO</th>
                      <th>NACIONALIDAD</th>
                      <th>SEXO</th>
                      <th>FECHA DE NACIMIENTO</th>
                      <th>DIRECCIÓN</th>
                      <th>SEDE</th>
                      <th>NIVEL</th>
                      <th>ESTATUS</th>
                      <?php if ($_SESSION['nivel'] == 1) { ?>
                      <th>ACCIÓN</th>
                       <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     $tbt =  $conecta->fullselect("SELECT u.idusu id,
                                                          u.nombre nom,
                                                          u.apellido ap,
                                                          u.cedula ce,
                                                          u.nombreusu us,
                                                          u.pass pa,
                                                          u.estatus st,
                                                          u.nacionalidad nc,
                                                          u.sexo se,
                                                          u.fch_nacimi fc,
                                                          u.direccion di,
                                                          tp.descripcion lv,
                                                          s.descripcion de
                                                     FROM usuario u
                                                     INNER JOIN sede s ON u.idsede = s.idsede
                                                     INNER JOIN tipo_persona tp ON u.idtipopersona = tp.idtipopersona 
                                                     ORDER BY tp.descripcion");  
                    $row = $tbt->num_rows;
                    for ($j=1; $j <= $row; $j++) 
                    {
                      $tbt->data_seek($row);
                      $fact = $tbt->fetch_assoc();
                      $id = $fact['id'];
                      $no = $fact['nom'].'  '.$fact['ap'];
                      $ci = $fact['ce'];
                      $us = $fact['us'];
                      $pa = base64_decode($fact['pa']);
                      $st = $fact['st'] == 2 ? 'INACTIVO' : 'ACTIVO';
                      $lv = $fact['lv'];
                      $na = $fact['nc'] == 1 ? 'V' : 'E';
                      $se = $fact['se'] == 1 ? 'MASCULINO' : 'FEMENINO';
                      $fc = $fact['fc'];
                      $sd = $fact['de'];
                      $di = $fact['di'];
                     ?>
                      <tr>
                        <td><?php echo $ci; ?></td>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $us; ?></td>
                        <td><?php echo $na; ?></td>
                        <td><?php echo $se; ?></td>
                        <td><?php echo $fc; ?></td>
                        <td><?php echo $di; ?></td>
                        <td><?php echo $sd; ?></td>
                        <td><?php echo $lv; ?></td>
                        <td><?php echo $st; ?></td>
                        <?php if ($_SESSION['nivel'] == 1) { ?>
                        <td class="td-actions text-left">
                          <a href="#" class="btn btn-info btn-circle btn-sm" title='editar' alt='editar' onclick="ver_usu(<?php echo $id; ?>)">
                            <i class="fas fa-edit"></i>
                          </a>
                          <!--a href="#" class="btn btn-danger btn-circle btn-sm" title='editar' alt='editar' onclick="del_usu(<?php// echo $id; ?>)">
                            <i class="fas fa-trash"></i>
                          </a-->
                        </td>
                        <?php } ?>
                      </tr>


                  <?php } ?>
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="muestra_modal"></div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class='modal fade' id='usuario'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title'>Registro de usuario</h5>
          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>×</span>
          </button>
        </div>
        <div class='modal-body'>
          <form class='user' id='frmusu'>
            <div class='row'>
              <div class='col-6'>
                <div class='form-group'>
                  <label>Nivel</label>
                  <select class='custom-select' name='lvl' id='lvl' onchange="valida_nivel('')">
                    <option selected value=''>--> SELECIONE <--</option>
                    <?php

                      $sql = $_SESSION['nivel'] == 1 ? 
                            'SELECT * FROM tipo_persona' : 
                            'SELECT * FROM tipo_persona WHERE idtipopersona IN (3,4)';
                     
                      $tip =  $conecta->fullselect($sql);  
                      $row = $tip->num_rows;
                      for ($t=1; $t <= $row; $t++) 
                      {
                        $tip->data_seek($row);
                        $te = $tip->fetch_assoc();
                        echo "<option value='".$te['idtipopersona']."'>".$te['descripcion']."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class='form-group'>
                  <label>Cédula:</label>
                  <input type='text' class='form-control form-control-user' name='ci' id='ci' placeholder='Ingrese cedula' require>
                </div>

                <div class='form-group'>
                  <label>Nombre:</label>
                  <input type='text' class='form-control form-control-user' name='nom' id='nom' placeholder='Ingrese nombre' require>
                </div>

                <div class='form-group'>
                  <label>Apellido:</label>
                  <input type='text' class='form-control form-control-user' name='ape' id='ape' placeholder='Ingrese apellido' require>
                </div>
                <div class='form-group'>
                  <label>Dirección:</label>
                  <input type='text' class='form-control form-control-user' name='dir' id='dir' placeholder='Ingrese direccion ' require>
                </div>
                <div class='form-group'>
                  <label>Telefono:</label>
                  <input type='text' class='form-control form-control-user' name='tlf' id='tlf' placeholder='Ingrese telefono' require>
                </div>
                <div class='form-group'>
                  <label>Fecha de nacimiento</label>
                  <input type='date' class='form-control form-control-user' max='2021-01-01' name='fchnac' id='fchnac' placeholder=''>
                </div>
              </div>
              <div class='col-6'>                
                <div class='form-group'>
                  <label>Nacionalidad</label>
                  <select class='custom-select' name='nac' id='nac' required>
                    <option selected value=''>--> SELECIONE <--</option>
                    <option value='1'>V</option>
                    <option value='2'>E</option>
                  </select>
                </div>
                <div class='form-group'>
                  <label>Sexo</label>
                  <select class='custom-select' name='sex' id='sex' required>
                    <option selected value=''>--> SELECIONE <--</option>
                    <option value='1'>MASCULINO</option>
                    <option value='2'>FEMENINO</option>
                  </select>
                </div>                
                <div class="form-group">
                  <label>Sede</label>
                  <select class='custom-select' name='cmbsd' id='cmbsd'>
                    <option selected value=''>--> SELECIONE <--</option>
                    <?php 
                    $tari =  $conecta->fullselect("SELECT * FROM sede");  
                    $ro2 = $tari->num_rows;
                    for ($t=1; $t <= $ro2; $t++) 
                    {
                      $tari->data_seek($ro2);
                      $ta = $tari->fetch_assoc();
                      echo "<option value='".$ta['idsede']."'>".$ta['descripcion']."</option>";
                    }
                    ?>
                  </select>
                </div>
                <?php if ($_SESSION['nivel'] == 1) { ?>
                  <div id="oculto">
                    <div class='form-group'> 
                      <label>Usuario:</label>
                      <input type='text' class='form-control form-control-user' name='usu' id='usu' placeholder='Ingrese usuario' require>
                    </div>
                    <div class='form-group'>
                      <label>Clave:</label>
                      <input type='password' class='form-control form-control-user' name='psw' id='psw' placeholder='Ingrese clave ' require>
                    </div>
                  </div>
                <?php }?>
              </div>
            </div>
          </form>
        </div>
        <div class='modal-footer'>
          <button class='btn btn-secondary' type='button' data-dismiss='modal'>
            <i class='fas fa-times'></i>   Cancelar
          </button>
          <a class='btn btn-primary' href='#' onclick='rg_usuario()'>
            <i class='fas fa-check'></i>   Aceptar
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include 'script.php'; ?>
<script src="controlador/usuario.js"></script>

</body>

</html>
