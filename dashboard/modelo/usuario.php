<?php

require_once "../../mysqli/conexion.php";
$conecta = new Conexion();  
$modo = $_REQUEST["modo"];
session_start();
if ($modo==1)
{
	$ci = $_REQUEST["ci"];
	$nom = $_REQUEST["nom"];
	$ape = $_REQUEST["ape"];
	$usu = $_REQUEST["usu"];
	$psw = base64_encode($_REQUEST["psw"]);
	$dir = $_REQUEST["dir"];
	$tlf = $_REQUEST["tlf"];
	$fch = $_REQUEST["fch"];
	$nac = $_REQUEST["nac"];
	$sex = $_REQUEST["sex"];
	$lvl = $_REQUEST["lvl"];
	if ($lvl == 3) {
		$sele = "SELECT * FROM usuario WHERE cedula = ?";
		$bindParam = 's';
		$value = array($ci); 
	}
	elseif ($lvl == 4) {
		$sele = "SELECT * FROM usuario WHERE cedula = ?";
		$bindParam = 's';
		$value = array($ci); 
	}
	else
	{
		$sele = "SELECT * FROM usuario WHERE nombreusu = ? OR pass = ? OR cedula = ?";
		$bindParam = 'sss';
		$value = array($usu,$psw,$ci); 
	}
	$cmbsd = $_REQUEST["cmbsd"];
	$stu = '1';
	$result = $conecta->mysqli_prepared_query($sele,$bindParam,$value);  
	if (count($result) > 0):
		echo $alert = 'Este usuario ya se encuentra registrado!';
	else:
		$insert = "INSERT INTO usuario(cedula,
									   nombre,
									   apellido,
									   nombreusu,
									   pass,
									   direccion,
									   telef,
									   fch_nacimi,
									   nacionalidad,
									   sexo,
									   idtipopersona,
									   idsede,
									   estatus) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$bd = 'sssssssssssss';
		$val = array($ci,$nom,$ape,$usu,$psw,$dir,$tlf,$fch,$nac,$sex,$lvl,$cmbsd,$stu); 
		$rsl = $conecta->mysqli_prepared_query($insert,$bd,$val);  
		echo 'Usuario registrado con exito';
	endif;
}

//consultar
if ($modo==2)
{
	$id = $_REQUEST["id"];
	$sql = "SELECT u.idusu id,
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
                  u.telef tlf,
                  u.estatus st,
                  tp.descripcion lv,
                  tp.idtipopersona idt,
                  s.idsede ids,
                  s.descripcion de
             FROM usuario u
             INNER JOIN sede s ON u.idsede = s.idsede
             INNER JOIN tipo_persona tp ON u.idtipopersona = tp.idtipopersona 
             WHERE idusu = ? ";
	$bindParam = 's';
	$value = array($id); 
	$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	$id = $rsl[0]['id']; 
	$no = $rsl[0]['nom']; 
	$ap = $rsl[0]['ap']; 
	$ci = $rsl[0]['ce']; 
	$us = $rsl[0]['us']; 
	$ps = base64_decode($rsl[0]['pa']); 
	$st = $rsl[0]['st']; 
	$lv = $rsl[0]['idt']; 
	$na = $rsl[0]['nc']; 
	$se = $rsl[0]['se']; 
	$fc = $rsl[0]['fc']; 
	$sd = $rsl[0]['ids']; 
	$de = $rsl[0]['di']; 	
	$tlf = $rsl[0]['tlf']; 	
	$st = $rsl[0]['st']; 
	$cmb = "";
	$cmb2 = "";
	$tari =  $conecta->fullselect("SELECT * FROM sede");  
    $ro2 = $tari->num_rows;
    for ($t=1; $t <= $ro2; $t++) 
    {
      $tari->data_seek($ro2);
      $ta = $tari->fetch_assoc();
      $cmb .= "<option value='".$ta['idsede']."'>".$ta['descripcion']."</option>";
    }
    $tip =  $conecta->fullselect("SELECT * FROM tipo_persona");  
    $row = $tip->num_rows;
    for ($t=1; $t <= $row; $t++) 
    {
      $tip->data_seek($row);
      $te = $tip->fetch_assoc();
      $cmb2 .= "<option value='".$te['idtipopersona']."'>".$te['descripcion']."</option>";
    }

	$modal = "<div class='modal fade' id='usuario$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
		    <div class='modal-dialog modal-lg' role='document'>
		      <div class='modal-content'>
		        <div class='modal-header'>
		          <h5 class='modal-title' id='exampleModalLabel'>Actualizar de usuario $us</h5>
		          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
		            <span aria-hidden='true'>×</span>
		          </button>
		        </div>
		        <div class='modal-body'>
		          <form class='user' id='frmusu$id'>
		            <div class='row'>
		              <div class='col-6'>
		                <div class='form-group'>
		                  <label>Cédula:</label>
		                  <input type='text' class='form-control form-control-user' name='ci$id' id='ci$id'  value='$ci' require>
		                </div>
		                <div class='form-group'>
		                  <label>Nombre:</label>
		                  <input type='text' class='form-control form-control-user' name='nom$id' id='nom$id'  value='$no' require>
		                </div>
		                <div class='form-group'>
		                  <label>Apellido:</label>
		                  <input type='text' class='form-control form-control-user' name='ape$id' id='ape$id'  value='$ap' require>
		                </div>
						<div id='oculto$id'>
			                <div class='form-group'> 
			                  <label>Usuario:</label>
			                  <input type='text' class='form-control form-control-user' name='usu$id' id='usu$id'  value='$us' require>
			                </div>
			                <div class='form-group'>
			                  <label>Clave:</label>
			                  <input type='text' class='form-control form-control-user' name='psw$id' id='psw$id'  value='$ps' require>
			                </div>
		                </div>
		                <div class='form-group'>
		                  <label>Dirección:</label>
		                  <input type='text' class='form-control form-control-user' name='dir$id' id='dir$id'  value='$de' require>
		                </div>
		                <div class='form-group'>
		                  <label>Telefono:</label>
		                  <input type='text' class='form-control form-control-user' name='tlf$id' id='tlf$id'  value='$tlf' require>
		                </div>
		              </div>

		              <div class='col-6'>
		                <div class='form-group'>
		                  <label>Fecha de nacimiento</label>
		                  <input type='date' class='form-control form-control-user' name='fchnac$id' id='fchnac$id' value='$fc'>
		                </div>
		                <div class='form-group'>
		                  <label>Estatus</label>
		                  <select class='custom-select' name='stu$id' id='stu$id' required>
		                    <option value='1'>ACTIVO</option>
		                    <option value='2'>INACTIVO</option>
		                  </select>
		                </div>
		                <div class='form-group'>
		                  <label>Nacionalidad</label>
		                  <select class='custom-select' name='nac$id' id='nac$id' required>
		                    <option selected value=''>--> SELECIONE <--</option>
		                    <option value='1'>VENEZOLANO</option>
		                    <option value='2'>EXTRANJERO</option>
		                  </select>
		                </div>
		                <div class='form-group'>
		                  <label>Sexo</label>
		                  <select class='custom-select' name='sex$id' id='sex$id' required>
		                    <option selected value=''>--> SELECIONE <--</option>
		                    <option value='1'>MASCULINO</option>
		                    <option value='2'>FEMENINO</option>
		                  </select>
		                </div>
		                <div class='form-group'>
		                  <label>Nivel</label>
		                  <select class='custom-select' name='lvl$id' id='lvl$id' onchange='valida_nivel($id)'>
		                    <option selected value=''>--> SELECIONE <--</option>
		                    $cmb2
		                  </select>
		                </div>
		                <div class='form-group'>
		                  <label>Sede</label>
		                  <select class='custom-select' name='cmbsd$id' id='cmbsd$id'>
		                    <option selected value=''>--> SELECIONE <--</option>
		                    $cmb
		                  </select>
		                </div>
		              </div>
		            </div>
		          </form>
		        </div>
		        <div class='modal-footer'>
		          <button class='btn btn-secondary' type='button' data-dismiss='modal'>
		            <i class='fas fa-times'></i>   Cancelar
		          </button>
		          <a class='btn btn-primary' href='#' onclick='act_usuario($id)'>
		            <i class='fas fa-check'></i>   Aceptar
		          </a>
		        </div>
		      </div>
		    </div>
		  </div>";
	echo "$modal|$id|$na|$se|$lv|$sd|$st|$tlf|";
}

/*--Ver datos del pago--*/
if ($modo==3)
{
	$ci = $_REQUEST["ci"];
	$nom = $_REQUEST["nom"];
	$ape = $_REQUEST["ape"];
	$usu = $_REQUEST["usu"];
	$psw = base64_encode($_REQUEST["psw"]);
	$dir = $_REQUEST["dir"];
	$tlf = $_REQUEST["tlf"];
	$fch = $_REQUEST["fch"];
	$nac = $_REQUEST["nac"];
	$sex = $_REQUEST["sex"];
	$lvl = $_REQUEST["lvl"];
	$cmbsd = $_REQUEST["cmbsd"];
	$stu = $_REQUEST["stu"];
	$id = $_REQUEST["id"];
	$sql = "UPDATE usuario SET cedula=?,
							   nombre=?,
							   apellido=?,
							   nombreusu=?,
							   pass=?,
							   direccion=?,
							   telef=?,
							   fch_nacimi=?,
							   nacionalidad=?,
							   sexo=?,
							   idtipopersona=?,
							   idsede=?,
							   estatus=?
						 WHERE idusu=?";
	$bindParam = 'ssssssssssssss';
	$value = array($ci,$nom,$ape,$usu,$psw,$dir,$tlf,$fch,$nac,$sex,$lvl,$cmbsd,$stu,$id); 
	$result = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	echo 'Usuario actualizado con exito';
}
/*--Ver participante--*/
if ($modo==4)
{
	$id = $_REQUEST["id"];
	$sql = "DELETE FROM usuario WHERE idusu = ? ";
	$bindParam = 's';
	$value = array($id); 
	$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	echo "Usuario eliminado con exito";
}

 ?>