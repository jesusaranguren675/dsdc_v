<?php 
$alert = '';
session_start();
require_once "mysqli/conexion.php";
$conecta = new Conexion();  

$modo = $_REQUEST["modo"];
if ($modo==1) {
	if(empty($_REQUEST['usu']) || empty($_REQUEST['pass']))
	{
		echo $alert = 'Ingrese su usuario y su calve';
	}else{

		$user = $_REQUEST['usu'];
	    $pass = base64_encode($_REQUEST['pass']);
	    $st = 1;
	    $alert = "";
	    /*$pass = $_REQUEST['pass'];*/
	    $sql = "SELECT * FROM usuario WHERE nombreusu = ? AND pass = ? AND estatus = ? ";
		$bindParam = 'sss';
		$value = array($user,$pass,$st); 
		$result = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
		if (count($result) > 0):
			$_SESSION['active'] = true;
			$_SESSION['idusu'] = $result[0]['idusu']; 
			$_SESSION['nombre'] = $result[0]['nombre']; 
			$_SESSION['apellido'] = $result[0]['apellido']; 
			$_SESSION['usu']  = $result[0]['nombreusu']; 
			$_SESSION['nivel']   = $result[0]['idtipopersona']; 
			echo '1';
		else:
			echo $alert = 'El usuario esta inactivo o la clave es incorrecta';
			session_destroy();
		endif;
	}

}
	
 ?>