  <?php  
session_start();
$nom = $_SESSION['nombre']."    ".$_SESSION['apellido'];
require_once "../mysqli/conexion.php";
$conecta = new Conexion(); 
$p_espera =  $conecta->fullselect("SELECT COUNT(*) num_usu FROM usuario WHERE estatus = 1");  
$p_entreg =  $conecta->fullselect("SELECT COUNT(*) num_med FROM medicamento");  
$clientes =  $conecta->fullselect("SELECT COUNT(*) num_asig FROM asignacion");  
$esp = $p_espera->fetch_assoc();
$ent = $p_entreg->fetch_assoc();
$cli = $clientes->fetch_assoc();
$usu = $esp['num_usu'];
$med = $ent['num_med'];
$asi = $cli['num_asig'];
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';  ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include 'menu.php'; ?>

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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bienvenido <?php echo $nom;  ?>!</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $usu; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medicamentos</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $med; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-heartbeat fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Asignación</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $asi; ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

          <!-- Content Row -->

          

          <!-- Content Row -->
          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br>
      <br><br><br><br>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Hecho por la universidad Politecnica Territorial de Caracas "Mariscal Sucre"</span>
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




  <!-- DESPUES LO OCOMODAS TRABAJE SUPER RAPIDO -->
  <?php include 'script.php'; ?> 

</body>

</html>
