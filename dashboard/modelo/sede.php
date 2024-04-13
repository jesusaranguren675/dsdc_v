<?php

require_once "../../mysqli/conexion.php";
$conecta = new Conexion();  
$modo = $_REQUEST["modo"];
session_start();
if ($modo==1)
{
	$des = $_REQUEST["des"];
	$insert = "INSERT INTO sede(descripcion) VALUES (?)";
	$bd = 's';
	$val = array($des);
	$rsl = $conecta->mysqli_prepared_query($insert,$bd,$val);  
	echo 'Registro exitoso!';
}

//consultar
if ($modo==2)
{
	$id = $_REQUEST["id"];
	$sql = "SELECT * FROM sede WHERE idsede = ? ";
	$bindParam = 's';
	$value = array($id); 
	$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	$id = $rsl[0]['idsede']; 
	$des = $rsl[0]['descripcion']; 
	$modal = "<div class='modal fade' id='sede$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
		    <div class='modal-dialog modal-lg' role='document'>
		      <div class='modal-content'>
		        <div class='modal-header'>
		          <h5 class='modal-title' id='exampleModalLabel'>Actualizar sede</h5>
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
		                      <label>Descripcion:</label>
		                      <input type='text' class='form-control form-control-user' name='des' id='des$id'>
		                      <br>
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
		          <a class='btn btn-primary' href='#' onclick='act_tperson($id)'>
		            <i class='fas fa-check'></i>   Aceptar
		          </a>
		        </div>
		      </div>
		    </div>
		  </div>";
	echo $modal.'|'.$id.'|'.$des.'|';
}

/*--Ver datos del pago--*/
if ($modo==3)
{
	
	$id = $_REQUEST["id"];
	$des = $_REQUEST["des"];
	$sql = "UPDATE sede SET descripcion=? WHERE idsede=?";
	$bindParam = 'ss';
	$value = array($des,$id);
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