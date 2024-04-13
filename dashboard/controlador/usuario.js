$(document).ready(function() {
  //$('#dtusu').DataTable();
  $('#dtusu').DataTable({
	  language: {
	      "decimal": "",
	      "emptyTable": "No hay información",
	      "info": " _START_ al _END_ de _TOTAL_ ",
	      "infoEmpty": "Mostrando 0 to 0 of 0 ",
	      "infoFiltered": "(Filtrado de _MAX_ total )",
	      "infoPostFix": "",
	      "thousands": ",",
	      "lengthMenu": "Mostrar _MENU_",
	      "loadingRecords": "Cargando...",
	      "processing": "Procesando...",
	      "search": "Ingrese datos del usuario:",
	      "zeroRecords": "Sin resultados encontrados",
	      "paginate": {
	          "first": "Primero",
	          "last": "Ultimo",
	          "next": ">>>",
	          "previous": "<<<"
	      }
	  },
  });


	$("#frmusu").validate({
		rules: {
		  ci: 'required',
		  nom: 'required',
		  ape: 'required',
		  dir: 'required',
		  fchnac: 'required',
		  nac: 'required',
		  sex: 'required',
		  lvl: 'required',
		  cmbsd: 'required',
		},
		messages: {
		  ci: 'Este campo es requerido.',
		  nom: 'Este campo es requerido.',
		  ape: 'Este campo es requerido.',
		  dir: 'Este campo es requerido.',
		  fchnac: 'Este campo es requerido.',
		  nac: 'Este campo es requerido.',
		  sex: 'Este campo es requerido.',
		  lvl: 'Este campo es requerido.',
		  cmbsd: 'Este campo es requerido.',
		}
	});

  $("#ci").mask("99999999");

});

function rg_usuario() {
	ci  = $('#ci').val()
	nom = $('#nom').val()
	ape  = $('#ape').val()
	usu = $('#usu').val()
	psw  = $('#psw').val()
	dir = $('#dir').val()
	tlf = $('#tlf').val()
	fch = $('#fchnac').val()
	nac = $('#nac').val()
	sex = $('#sex').val()
	lvl = $('#lvl').val()
	cmbsd = $('#cmbsd').val()
	valid = $("#frmusu").valid();
	if (valid) 
	{
		var data = new FormData();
		  data.append('ci',ci);
		  data.append('nom',nom);
		  data.append('ape',ape);
		  data.append('usu',usu);
		  data.append('psw',psw);
		  data.append('dir',dir);
		  data.append('tlf',tlf);
		  data.append('fch',fch);
		  data.append('nac',nac);
		  data.append('sex',sex);
		  data.append('lvl',lvl);
		  data.append('cmbsd',cmbsd);
		  data.append('modo',1);
		  $.ajax({
		    url: "modelo/usuario.php",       
		    type: "POST",             
		    data: data,               
		    contentType: false,       
		    cache: false,             
		    processData:false,        
		    success: function(data)   	
		    {
		      Swal.fire({
				  title: data,
				  icon: "success",
				  button: "Aceptar",
				}).then(function(result){
		      		window.location="usuario.php";
				});
		    }
		  });
	}

}

function ver_usu(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',2);
    $.ajax({
    url: "modelo/usuario.php",       
    type: "POST",             
    data: data,               
    contentType: false,       
    cache: false,             
    processData:false,        
    success: function(data)   
    {
    	//alert(data)
      dt = data.split('|');
      $('#muestra_modal').html(dt[0])
      $('#usuario'+dt[1]).modal('show')
	  $('#nac'+dt[1]).val(dt[2])
	  $('#sex'+dt[1]).val(dt[3])
	  $('#lvl'+dt[1]).val(dt[4])
	  $('#cmbsd'+dt[1]).val(dt[5])
	  $('#stu'+dt[1]).val(dt[6])
	  $('#tlf'+dt[1]).val(dt[7])
	  $("#frmusu"+dt[1]).validate({
		rules: {
		  ci: 'required',
		  nom: 'required',
		  ape: 'required',
		  dir: 'required',
		  fchnac: 'required',
		  nac: 'required',
		  sex: 'required',
		  lvl: 'required',
		  cmbsd: 'required',
		},
		messages: {
		  ci: 'Este campo es requerido.',
		  nom: 'Este campo es requerido.',
		  ape: 'Este campo es requerido.',
		  dir: 'Este campo es requerido.',
		  fchnac: 'Este campo es requerido.',
		  nac: 'Este campo es requerido.',
		  sex: 'Este campo es requerido.',
		  lvl: 'Este campo es requerido.',
		  cmbsd: 'Este campo es requerido.',
		}
	  });
      /*$('#cod'+id).val(dt[2])   //cdvir||txt
      $('#nom'+id).val(dt[3]) 
      $("#ci"+id).mask("99999999");*/
    }
  });
}

function act_usuario(id) {

	ci  = $('#ci'+id).val()
	nom = $('#nom'+id).val()
	ape  = $('#ape'+id).val()
	usu = $('#usu'+id).val()
	psw  = $('#psw'+id).val()
	dir = $('#dir'+id).val()
	fch = $('#fchnac'+id).val()
	nac = $('#nac'+id).val()
	sex = $('#sex'+id).val()
	lvl = $('#lvl'+id).val()
	cmbsd = $('#cmbsd'+id).val()
	stu = $('#stu'+id).val()
	tlf = $('#tlf'+dt[1]).val()

	valid = $("#frmusu"+id).valid();
	if (valid) 
	{
		Swal.fire({
	      title: "Desea actualizar usuario "+usu,   
	      text: "",   
	      icon: "info",   
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      cancelButtonText: 'Cancelar',
	      confirmButtonText: 'Aceptar'
    	}).then(function(result) 
    	{
      		if (result.value) 
      		{
		        var data = new FormData();
				  data.append('ci',ci);
				  data.append('nom',nom);
				  data.append('ape',ape);
				  data.append('usu',usu);
				  data.append('psw',psw);
				  data.append('dir',dir);
				  data.append('tlf',tlf);
				  data.append('fch',fch);
				  data.append('nac',nac);
				  data.append('sex',sex);
				  data.append('lvl',lvl);
				  data.append('cmbsd',cmbsd);
				  data.append('stu',stu);
				  data.append('id',id);
				  data.append('modo',3);
				  $.ajax({
				    url: "modelo/usuario.php",       
				    type: "POST",             
				    data: data,               
				    contentType: false,       
				    cache: false,             
				    processData:false,        
				    success: function(data)   
				    {
				    	Swal.fire({
						  title: data,
						  icon: "success",
						  button: "daridni la lacrita",
						}).then(function(result){
				      		window.location="usuario.php";
						});
				    }
				});
      		}
	    });
	}
}

function del_usu(id) {
  var data = new FormData();
  data.append('id',id);
  data.append('modo',4);
  $.ajax({
    url: "modelo/usuario.php",       
    type: "POST",             
    data: data,               
    contentType: false,       
    cache: false,             
    processData:false,        
    success: function(data)   
    {
      	alert(data)
	    window.location="usuario.php";
    }
  });
}


function valida_nivel(id) {
	val = $('#lvl'+id).val()
	if (val == 1 || val == 2) 
	{
		$('#oculto'+id).show()	
	}
	else
	{
		$('#oculto'+id).hide()
		$('#usu'+id).val('')	
		$('#psw'+id).val('')	
	}
}