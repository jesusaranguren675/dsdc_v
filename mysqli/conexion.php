<?php

/***************************************************************************************************
 NOMBRE					: conexion.php
 PARAMETROS				: (None)
 DESCRIPCION			: Conexion segura MYSQLI
 AUTOR					: Humberto Gamez
 CREACION				: 02/2020

 *****************************************************************************************************/

class Conexion 
{
	/** conectar(): Intenta establecer la conexion con la base de datos.*/
    private function conectar() {
       //require_once ('config.php');

        $host1 = '127.0.0.1';
        $dbname1 = 'dbasigacion';
        $user1 = 'root';
        $passwd1 = '';
        //$user1 = 'sigeven';
        //$passwd1 = 'segeven123++';
       
	    $mysqli=new mysqli($host1,$user1,$passwd1,$dbname1);
		if ($mysqli->connect_error):
		  	echo "Error al conectarse con My SQL debido al error".$mysqli->connect_error;
		else:
			return $mysqli;
		endif;
    }


    function mysqli_prepared_query($sql,$typeDef = FALSE,$params = FALSE)
    {
    	$con = self::conectar();
    	mysqli_set_charset($con, "utf8");
		if($stmt = mysqli_prepare($con,$sql))
		{
		    if(count($params) == count($params,1))
		    {
			    $params = array($params);
			    $multiQuery = FALSE;
		    } 
		    else 
		    {
		      	$multiQuery = TRUE;
		    } 
		    if($typeDef)
		    {
			    $bindParams = array();   
			    $bindParamsReferences = array();
			    $bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");        
			    foreach($bindParams as $key => $value)
			    {
			    	$bindParamsReferences[$key] = &$bindParams[$key]; 
			    }
			    array_unshift($bindParamsReferences,$typeDef);
			    $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
			    $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences);
		    }
		   
		    $result = array();
		    foreach($params as $queryKey => $query)
		    {
			    foreach($bindParams as $paramKey => $value)
			    {
			    	$bindParams[$paramKey] = $query[$paramKey];
			    }
			    $queryResult = array();
			    if(mysqli_stmt_execute($stmt))
			    {
			        $resultMetaData = mysqli_stmt_result_metadata($stmt);
			        if($resultMetaData)
			        {                                                                              
				        $stmtRow = array();  
				        $rowReferences = array();
				        while ($field = mysqli_fetch_field($resultMetaData)) 
				        {
				            $rowReferences[] = &$stmtRow[$field->name];
				        }                               
				        mysqli_free_result($resultMetaData);
				        $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result');
				        $bindResultMethod->invokeArgs($stmt, $rowReferences);
				        while(mysqli_stmt_fetch($stmt))
				        {
				            $row = array();
				            foreach($stmtRow as $key => $value)
				            {
				            	$row[$key] = $value;          
				            }
				            $queryResult[] = $row;
				        }
				        mysqli_stmt_free_result($stmt);
			        } 
			        else
			        {
			          	$queryResult[] = mysqli_stmt_affected_rows($stmt);
			        }
			    } 
			    else 
			    {
			    	$queryResult[] = FALSE;
			    }
			    $result[$queryKey] = $queryResult;
		    }
		    mysqli_stmt_close($stmt);  
		} 
		else 
		{
		  	$result = FALSE;
		}
		if($multiQuery){
			return $result;
		} 
		else 
		{
			return $result[0];
		}
	}

	
	function fullselect($sql)
	{
		$con = self::conectar();
		mysqli_set_charset($con, "utf8");
		$resultado = $con->query($sql);
		return $resultado;
	}

	function last_id($sql)
	{
		$con = self::conectar();
		$result = mysqli_query($con,$sql);
	    mysqli_data_seek($result,0);
	    $fin = mysqli_free_result($result);
		return $fin;
	}


 




}               
?>