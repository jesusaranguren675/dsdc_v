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
          <h1 class="h3 mb-2 text-gray-800">Tipo de medicamento</h1>
          <p class="mb-4"></p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Registro tipo de medicamentos</h6>
              <a href="#" class="btn btn-success btn-circle float-right" data-toggle="modal" data-target="#tmedicamento">
                <i class="fas fa-plus"></i>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dtmedica" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th> 
                      <th>DESCRIPCIÓN</th>
                      <th>ACCIÓN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     $tbt =  $conecta->fullselect("SELECT * FROM tipo_medicamento ");  
                    $row = $tbt->num_rows;
                    for ($j=1; $j <= $row; $j++) 
                    {
                      $tbt->data_seek($row);
                      $fact = $tbt->fetch_assoc();
                      $id = $fact['idtipo'];
                      $des = $fact['descripcion'];
                      
                     ?>
                      <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $des; ?></td>
                        <td class="td-actions text-left">
                          <a href="#" class="btn btn-info btn-circle btn-sm" title='editar' alt='editar' onclick="ver_tpmedica(<?php echo $id; ?>)">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
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
  <div class="modal fade" id="tmedicamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registro de tipo de medicamento</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-12">

                <form class="user" id="frmtp">

                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Descripción:</label>
                      <input type="text" class="form-control form-control-user" name="desc" id="desc" placeholder="Descripcion">
                    </div>

                  </div>

                </form>

            </div>
          </div>



        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">
            <i class="fas fa-times"></i>   Cancelar
          </button>
          <a class="btn btn-primary" href="#" onclick="rg_tpmedica()">
            <i class="fas fa-check"></i>   Aceptar
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include 'script.php'; ?>
<script src="controlador/tpmedicamento.js"></script>

</body>

</html>
