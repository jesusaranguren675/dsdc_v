<?php

require_once "../../mysqli/conexion.php";
$conecta = new Conexion();  
$modo = $_REQUEST["modo"];
session_start();
if ($modo==1)
{
	$fch = date('Y-m-d');
	//$fch = $_REQUEST["fch"];
	$pci = $_REQUEST["pci"];
	$med = $_REQUEST["med"];
	$can = $_REQUEST["can"];
	$des = $_REQUEST["des"];
	$usu = $_SESSION['idusu'];
	
	$str = "SELECT DATEDIFF('$fch',a.fecha) difer,
				   m.nombre no_med,
				   a.idasig asig
			FROM asignacion a
			INNER JOIN usuario u ON a.idusu = u.idusu 
			INNER JOIN detalle_asigna da ON a.idasig = da.idasig 
			INNER JOIN medicamento m ON m.idmedi = da.idmedi 
			WHERE a.idusu=$pci AND m.idmedi IN ($med)";
	$me = $conecta->fullselect($str);  
	$cant = $me->num_rows;
	$medicamentos = "";
	$diferencia = "";
	$idasignacion = "";
	for ($a=1; $a <= $cant; $a++) 
    {
      $me->data_seek($cant);
      $md = $me->fetch_assoc();
      $medicamentos .= $md['no_med'].", ";
      $diferencia = $md['difer'];
    }
    $no_med = strtoupper($medicamentos);
    $arreglo = explode(",", $med);
    $coun = count($arreglo);
    if ($diferencia > 30 || $cant == 0) {
		$medicamento =  $conecta->fullselect("SELECT cantidad FROM medicamento WHERE idmedi IN ($med)");  
		$md = $medicamento->fetch_assoc();
		$total_md = $md['cantidad'] - $can;
		if ($total_md < 0) {
			$msj = "Por favor, verifique que todos los medicamentos selecionados tengan existencia!|1";
		}
		else
		{
			$sql = "SELECT insert_asignacion (?,?,?,?,?) as id ";
			$bind = 'sssss';
			$val = array($fch,$des,$can,$usu,$pci);
			$rsl = $conecta->mysqli_prepared_query($sql,$bind,$val);
			$id = $rsl[0]['id'];

			$str_sel = "SELECT idasig FROM asignacion WHERE idasig = $id";
			$selec = $conecta->fullselect($str_sel); 
			$cant_sel = $selec->num_rows;
			if ($cant_sel > 0) {
				$str_del = "DELETE FROM detalle_asigna WHERE idasig=$id";
				$dele = $conecta->fullselect($str_del); 
			}


			$arreglo = explode(",", $med);
		    $coun = count($arreglo);
			$value = "";
			for ($i=0; $i < $coun; $i++) { 
				$value .= "($id,$arreglo[$i]),";
			}
			$sub =  substr($value,0,-1);
			$insert = "INSERT INTO detalle_asigna(idasig,idmedi)
						 VALUES $sub";
			$ins = $conecta->fullselect($insert); 
			$medi =  $conecta->fullselect("UPDATE medicamento SET cantidad='$total_md' WHERE idmedi IN ($med)");
			$msj = "Registro exitoso!|0";
		}
    }
    else
    {
    	$msj="Debe de esperar 30 dias para solicitar el mismo medicamento ($no_med)|1";
    }
    echo $msj;
}

//consultar
if ($modo==2)
{
	$id = $_REQUEST["id"];
	$sql = "SELECT a.idasig id,
	                a.fecha fe,
	                a.descripcion de,
	                a.cat_peticion can,
	                CONCAT(u2.nombre, ' ', u2.apellido, ' ', u2.cedula) usuari,
	                u.idusu paci,
	                s.descripcion sde
	        FROM asignacion a
	        INNER JOIN usuario u ON a.idusu = u.idusu
	        INNER JOIN usuario u2 ON a.usuario = u2.idusu
	        INNER JOIN sede s ON u.idsede = s.idsede
	        INNER JOIN tipo_persona pe ON u.idtipopersona = pe.idtipopersona
            WHERE a.idasig =  ? ";
	$bindParam = 's';
	$value = array($id); 
	$rsl = $conecta->mysqli_prepared_query($sql,$bindParam,$value);  
	$id = $rsl[0]['id']; 
	$pa = $rsl[0]['paci']; 
	$de = $rsl[0]['de']; 

	$sql2 = "SELECT idmedi
	        FROM detalle_asigna
            WHERE idasig = $id ";
	$val = $conecta->fullselect($sql2); 
	$num = $val->num_rows; 
	for ($i=0; $i < $num; $i++) { 
		$val->data_seek($num);
      	$medic = $val->fetch_assoc();
		$idmed[] = $medic['idmedi']; 
	}
	$id_json = json_encode($idmed);

	$usu =  $conecta->fullselect("SELECT idusu,
                                  CONCAT(nombre, ' ', apellido, ' ', cedula) as paci 
                                  FROM usuario WHERE idtipopersona = 3");  
    $r = $usu->num_rows;
    $cmb_usu = "";
    for ($a=1; $a <= $r; $a++) 
    {
      $usu->data_seek($r);
      $us = $usu->fetch_assoc();
      $cmb_usu .= "<option value='".$us['idusu']."'>".$us['paci']."</option>";
    }


    $medi =  $conecta->fullselect("SELECT idmedi,
                                          nombre
                                  FROM medicamento");  
    $r2 = $medi->num_rows;
    $cmb_mdi = "";
    for ($t=1; $t <= $r2; $t++) 
    {
      $medi->data_seek($r2);
      $md = $medi->fetch_assoc();
      $cmb_mdi .= "<option value='".$md['idmedi']."'>".$md['nombre']."</option>";
    }

	$modal = "<div class='modal fade' id='mdlasig$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
		                <form class='user' id='frmasig$id'>
		                  <!--div class='col-sm-12'>
		                    <div class='form-group'>
		                      <label>Fecha:</label>
		                      <input type='date' class='form-control form-control-user' name='fech' id='fech$id'>
		                    </div>
		                  </div-->
		                  <div class='col-sm-12'>
		                    <div class='form-group'>
		                      <label>Paciente:</label>
		                      <select class='custom-select' name='cmbpaci' id='cmbpaci$id'>
		                        $cmb_usu
		                      </select>
		                    </div>
		                  </div>
		                  <div class='col-sm-12'>
		                    <div class='form-group'>
		                      <label>Medicamento:</label>
		                      <select id='cmbmed$id' multiple='multiple' class='form-control select2 select2-container-multi'>
		                        $cmb_mdi
		                      </select>
		                    </div>
		                  </div>
		                  <!--div class='col-sm-12'>
		                    <div class='form-group'>
		                      <label>Cantidad:</label>
		                      <input type='text' class='form-control form-control-user' name='can' id='can$id' placeholder='Cantidad'>
		                    </div>
		                  </div-->
		                  <div class='col-sm-12'>
		                    <div class='form-group'>
		                      <label>Descripción:</label>
		                      <input type='text' class='form-control form-control-user' name='des' id='des$id' placeholder='Descripción'>
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
		          <a class='btn btn-primary' href='#' onclick='act_asig($id)'>
		            <i class='fas fa-check'></i>   Aceptar
		          </a>
		        </div>
		      </div>
		    </div>
		  </div>";
	echo "$modal|$id|$pa|$de|$id_json|";
}

/*--Ver datos del pago--*/
if ($modo==3)
{
	$des = $_REQUEST["des"];
	$usu = $_SESSION['idusu'];
	$med = $_REQUEST["med"];
	$pci = $_REQUEST["pci"];
	$id = $_REQUEST["id"];
	$sql = "UPDATE asignacion SET 
				   descripcion=?,usuario=?,idusu=? 
			WHERE idasig=?";
	$bindParam = 'ssss';
	$value = array($des,$usu,$pci,$id);
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

/*Buscar Factura*/
if ($modo==5)
{
	$str = $_REQUEST["str"];
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
            WHERE pe.idtipopersona = 3 $str ";
	$tbt =  $conecta->fullselect($sql);  
    $row = $tbt->num_rows;
    $tabla = "";
    for ($j=1; $j <= $row; $j++) 
    {
        $tbt->data_seek($row);
        $rs = $tbt->fetch_assoc();
        $id = $rs['idasg'];
        $fe = $rs['fe'];
        $ca = $rs['can'];
        $us = $rs['usuari'];
        $sd = $rs['sde'];
        $de = $rs['de'];
        $pa = $rs['paci'];
        $str = "SELECT da.idmedi idm,
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
        $tabla .= "<tr>
              <td class='td-actions text-center'>$id</td>
              <td>$fe</td>
              <td>$pa</td>
              <td>$med_str</td>
              <td>$tipo</td>
              <td>$ca C/U</td>
              <td>$us</td>
              <td>$sd</td>
              <td>$de</td>
            </tr>";


    }
    echo $tabla;
}

/*


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

 */

 ?>



