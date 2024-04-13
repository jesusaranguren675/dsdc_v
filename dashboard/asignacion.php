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
          <h1 class="h3 mb-2 text-gray-800">Asignacion</h1>
          <p class="mb-4"></p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Asinacion de medicamentos</h6>
              <br>
              <div class="row">
                <div class="col-9">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="text" id="date_range" name="date_range"  class="form-control text-center">
                      <div class="input-group-append">
                        <a href="#" class="btn btn-success input-group-text" title="Buscad" onclick="buscar(true)">
                          <i class="fas fa-search"></i>
                        </a>
                      </div>
                      <div class="input-group-append">
                        <a href="#" class="btn btn-primary input-group-text" title="Refrescar" onclick="buscar(false)">
                          <i class="fas fa-redo"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class='col-lg-2'>
                  <a href="#" class="btn btn-danger float-right" id="exportar_pdf">
                    <i class="fas fa-file-pdf"></i> Exportar a PDF
                  </a>
                </div>

                <div class='col-lg-1'>
                  <a href="#" class="btn btn-success btn-circle" data-toggle="modal" data-target="#mdlasig">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>


              </div>
              

              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dtasig" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th> 
                      <th>FECHA</th>
                      <th>PACIENTE</th>
                      <th>MEDICAMENTO</th>
                      <th>TIPO</th>
                      <th>CANTIDAD</th>
                      <th>USUARIO</th>
                      <th>SEDE</th>
                      <th>NOTA</th>
                      <?php if ($_SESSION['nivel'] == 1) { ?>
                        <th>ACCIÓN</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody id="carga">
                    <?php 
                    $sql = "SELECT a.idasig idasg,
                                    a.fecha fe,
                                    a.descripcion de,
                                    a.cat_peticion can,
                                    CONCAT(u2.nombre, ' ', u2.apellido, ' ', u2.cedula) usuari,
                                    CONCAT(u.nombre, ' ', u.apellido, ' ', u.cedula)  paci,
                                    s.descripcion sde
                            FROM asignacion a
                            INNER JOIN usuario u ON a.idusu = u.idusu
                            INNER JOIN usuario u2 ON a.usuario = u2.idusu
                            INNER JOIN sede s ON u.idsede = s.idsede
                            INNER JOIN tipo_persona pe ON u.idtipopersona = pe.idtipopersona
                            WHERE pe.idtipopersona = 3";
                     $tbt =  $conecta->fullselect($sql);  
                    $row = $tbt->num_rows;
                    for ($j=1; $j <= $row; $j++) 
                    {
                      $tbt->data_seek($row);
                      $fact = $tbt->fetch_assoc();
                      $id = $fact['idasg'];
                      $fe = $fact['fe'];
                      $ca = $fact['can'];
                      $us = $fact['usuari'];
                      $sd = $fact['sde'];
                      $de = $fact['de'];
                      $pa = $fact['paci'];

                     ?>
                      <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $fe; ?></td>
                        <td><?php echo $pa; ?></td>
                        <?php $str = "SELECT da.idmedi idm,
                                             da.idasig ida,
                                             m.nombre m_nom,
                                             tp.descripcion des
                                      FROM detalle_asigna da
                                      INNER JOIN medicamento m ON da.idmedi= m.idmedi
                                      INNER JOIN tipo_medicamento tp ON m.idtipo= tp.idtipo
                                      WHERE da.idasig = $id"; 
                            $me =  $conecta->fullselect($str);  
                            $num = $me->num_rows;
                            $tipo = "";
                            $med_str = "";
                            for ($x=0; $x < $num; $x++) 
                            {
                              $me->data_seek($num);
                              $si = $me->fetch_assoc();
                              $tipo .= $si['des'].", ";
                              $med_str .= $si['m_nom'].", ";
                            }
                        ?>
                        <td><?php echo $med_str; ?></td>
                        <td><?php echo $tipo; ?></td>
                        <td><?php echo "$ca C/U"; ?></td>
                        <td><?php echo $us; ?></td>
                        <td><?php echo $sd; ?></td>
                        <td><?php echo $de; ?></td>
                        <?php if ($_SESSION['nivel'] == 1) { ?>
                          <td class="td-actions text-left">
                            <a href="#" class="btn btn-info btn-circle btn-sm" title='editar' alt='editar' onclick="ver_asig(<?php echo $id; ?>)">
                              <i class="fas fa-edit"></i>
                            </a>
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
  <div class='modal fade' id='mdlasig' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='exampleModalLabel'>Asignación de medicamentos</h5>
          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>×</span>
          </button>
        </div>
        <div class='modal-body'>
          <div class='row'>
            <div class='col-lg-12'>
                <form class='user' id='frmasig'>
                  <!--div class='col-sm-12'>
                    <div class='form-group'>
                      <label>Fecha:</label>
                      <input type='date' class='form-control form-control-user' min="<?php echo date('Y-m-d'); ?>" name='fech' id='fech'>
                    </div>
                  </div-->
                  <div class='col-sm-12'>
                    <div class='form-group'>
                      <label>Paciente:</label>
                      <select class='custom-select' name='cmbpaci' id='cmbpaci'>
                        <option selected value=''>--> SELECIONE <--</option>
                        <?php 
                        $tari =  $conecta->fullselect("SELECT idusu,
                                                      CONCAT(nombre, ' ', apellido, ' ', cedula) as paci 
                                                      FROM usuario WHERE idtipopersona = 3");  
                        $ro2 = $tari->num_rows;
                        for ($t=1; $t <= $ro2; $t++) 
                        {
                          $tari->data_seek($ro2);
                          $ta = $tari->fetch_assoc();
                          echo "<option value='".$ta['idusu']."'>".$ta['paci']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='col-sm-12'>
                    <div class='form-group'>
                      <label>Medicamento:</label>
                      <select name="cmbmed[]" id="cmbmed" multiple="multiple" class="form-control select2 select2-container-multi required">
                        <?php 
                        $tari =  $conecta->fullselect("SELECT m.idmedi idme,
                                                              m.nombre nom,
                                                              t.descripcion des
                                                      FROM medicamento m
                                                      INNER JOIN tipo_medicamento t ON m.idtipo = t.idtipo");  
                        $ro2 = $tari->num_rows;
                        for ($t=1; $t <= $ro2; $t++) 
                        {
                          $tari->data_seek($ro2);
                          $ta = $tari->fetch_assoc();
                          $nom = $ta['nom'].'  '.$ta['des'];
                          echo "<option value='".$ta['idme']."'>".$nom."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class='col-sm-12'>
                    <div class='form-group'>
                      <label>Cantidad:</label>
                      <input type='text' class='form-control form-control-user' name='can' id='can' placeholder='Cantidad'>
                    </div>
                  </div>
                  <div class='col-sm-12'>
                    <div class='form-group'>
                      <label>Descripción:</label>
                      <input type='text' class='form-control form-control-user' name='des' id='des' placeholder='Descripción'>
                    </div>
                  </div>
                </form>
            </div>
          </div>
        </div>
        <div class='modal-footer'>
          <button class='btn btn-secondary' type='button' data-dismiss='modal'>
            <i class='fas fa-times'></i>   Cancelar
          </button>
          <a class='btn btn-primary' href='#' onclick='rg_asig()'>
            <i class='fas fa-check'></i>   Aceptar
          </a>
        </div>
      </div>
    </div>
  </div>


<?php include 'script.php'; ?>
<script src="controlador/asignacion.js"></script>

</body>

</html>
