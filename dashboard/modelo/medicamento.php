<?php

require_once "../../mysqli/conexion.php";
$conecta = new Conexion();  
$modo = $_REQUEST["modo"];
session_start();
if ($modo==1)
{
	$nom = $_REQUEST["nom"];
	$cnt = $_REQUEST["cnt"];
	$cmbmed = $_REQUEST["cmbmed"];
	$insert = "INSERT INTO medicamento(nombre,cantidad,idtipo) VALUES (?,?,?)";
	$bd = 'sss';
	$val = array($nom,$cnt,$cmbmed);
	$rsl = $conecta->mysqli_prepared_query($insert,$bd,$val);  
	echo 'Registro exitoso!';
}

//consultar
if ($modo==2)
{
	$id = $_REQUEST["id"];
	$sql = "SELECT m.idmedi id,
                  m.nombre no,
                  m.cantidad ca,
                  m.idtipo idt,
                  tp.descripcion de
          FROM medicamento m
          INNER JOIN tipo_medicamento tp ON m.idtipo = tp.idtipo
          WHERE m.idmedi = ? ";
	$bindParam = 's';
	$value = array($id); 
	$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	$id = $rsl[0]['id']; 
	$no = $rsl[0]['no']; 
	$ca = $rsl[0]['ca']; 
	$idt = $rsl[0]['idt']; 
	$tari =  $conecta->fullselect("SELECT * FROM tipo_medicamento");  
    $ro2 = $tari->num_rows;
    $cmb = "";
    for ($t=1; $t <= $ro2; $t++) 
    {
      $tari->data_seek($ro2);
      $ta = $tari->fetch_assoc();
      $cmb .= "<option value='".$ta['idtipo']."'>".$ta['descripcion']."</option>";
    }
	$modal = "<div class='modal fade' id='mdlmedi$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
		    <div class='modal-dialog modal-lg' role='document'>
		      <div class='modal-content'>
		        <div class='modal-header'>
		          <h5 class='modal-title' id='exampleModalLabel'>Actualizar medicamento $no</h5>
		          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
		            <span aria-hidden='true'>×</span>
		          </button>
		        </div>
		        <div class='modal-body'>
		          <div class='row'>
		            <div class='col-lg-12'>
		                <form class='user' id='frmtp$id'>
		                  <div class='form-group'>
		                    <div class='col-sm-12'>
		                      <label>Nombre:</label>
		                      <input type='text' class='form-control form-control-user' name='nom$id' id='nom$id' value='$no'>
		                      <br>
		                    </div>
		                  </div>
		                  <div class='form-group'>
		                    <div class='col-sm-12'>
		                      <label>Cantidad:</label>
		                      <input type='text' class='form-control form-control-user' name='cant$id' id='cant$id' value='$ca'>
		                      <br>
		                    </div>
		                  </div>
		                  <div class='form-group'>
		                    <label>Tipo medicamento:</label>
		                    <select class='custom-select' name='cmbmed$id' id='cmbmed$id'>
		                      <option selected value=''>--> SELECIONE <--</option>
		                      $cmb
		                    </select>
		                  </div>
		                </form>
		            </div>
		          </div>
		        </div>
		        <div class='modal-footer'>
		          <button class='btn btn-secondary' type='button' data-dismiss='modal'>
		            <i class='fas fa-times'></i>   Cancelar
		          </button>
		          <a class='btn btn-primary' href='#' onclick='act_medicamento($id)'>
		            <i class='fas fa-check'></i>   Aceptar
		          </a>
		        </div>
		      </div>
		    </div>
		  </div>";
	echo "$modal|$id|$idt|";
}

/*--Ver datos del pago--*/
if ($modo==3)
{
	
	$nom = $_REQUEST["nom"];
	$cnt = $_REQUEST["cnt"];
	$cmbmed = $_REQUEST["cmbmed"];
	$id = $_REQUEST["id"];
	$sql = "UPDATE medicamento SET nombre=?,cantidad=?,idtipo=? WHERE idmedi=?";
	$bindParam = 'ssss';
	$value = array($nom,$cnt,$cmbmed,$id);
	$result = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	echo 'Actualizacion con exito';
}
/*--Ver participante--*/
if ($modo==4)
{

	$id = $_REQUEST["id"];
	$tari =  $conecta->fullselect("SELECT * FROM persona WHERE idsede = $id");  
    $ro2 = $tari->num_rows;
    if ($ro2 > 0) {
    	echo "Error. este tipo ya se encuentra asignado a una persona!";
    } else {
    	$sql = "DELETE FROM sede WHERE idsede = ? ";
		$bindParam = 's';
		$value = array($id); 
		$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
		echo "Dato eliminado con exito!";
    }
    
	
}

 ?>