 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tablero.php">
        <!--div class="sidebar-brand-icon rotate-n-15"-->
        <div class="sidebar-brand-icon">
          <!--i class="fas fa-laugh-wink"></i-->
          <img src="../images/logo.png" alt="" height="40" width="80" >
        </div>
        <div class="sidebar-brand-text mx-3" ><?php  echo $_SESSION['usu']; ?> </div>
      </a>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">PRINCIPAL</div>
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="usuario.php">
          <i class="fa fa-user-circle"></i>
          <span>Usuarios</span>
        </a>
      </li>
<?php if ($_SESSION['nivel'] == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" href="medicamento.php">
          <i class="fa fa-heartbeat"></i>
          <span>Medicamentos</span></a>
      </li>
<?php } ?>

      <li class="nav-item">
        <a class="nav-link" href="asignacion.php">
          <i class="fa fa-user-plus"></i>
          <span>Asignación</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">CONFIGURACIÓN</div>
     <?php if ($_SESSION['nivel'] == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" href="tpersona.php">
          <i class="fa fa-address-card"></i>
          <span>Tipo persona</span></a>
      </li>
      <?php } ?>
<?php if ($_SESSION['nivel'] == 1) { ?>
        <li class="nav-item">
        <a class="nav-link" href="tpmedicamento.php">
          <i class="fa fa-medkit"></i>
          <span>Presentación de medicamento</span></a>
      </li>
<?php } ?>
        <?php if ($_SESSION['nivel'] == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" href="sede.php">
          <i class="fa fa-university "></i>
          <span>Sede</span></a>
      </li>
      <?php } ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->