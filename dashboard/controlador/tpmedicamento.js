$(document).ready(function() {
  //$('#dtusu').DataTable();
  $('#dtmedica').DataTable({
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

  $("#frmtp").validate({
    rules: {
      desc: 'required',
    },
    messages: {
      desc: 'Este campo es requerido.',
    }
  });

});

function rg_tpmedica() {
	desc  = $('#desc').val()
  valid = $("#frmtp").valid();
  if (valid) 
  {
  	var data = new FormData();
  	  data.append('des',desc);
  	  data.append('modo',1);
  	  $.ajax({
  	    url: "modelo/tpmedicamento.php",       
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
  	         window.location="tpmedicamento.php";
          });
  	    }
  	  });
  }
}

function ver_tpmedica(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',2);
    $.ajax({
    url: "modelo/tpmedicamento.php",       
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
      $('#tpmedicamento'+dt[1]).modal('show')
	   nom = $('#des'+dt[1]).val(dt[2])
     $("#frmtp"+dt[1]).validate({
        rules: {
          des: 'required',
        },
        messages: {
          des: 'Este campo es requerido.',
        }
      });

    }
  });
}

function act_tpmedica(id) {
  desc  = $('#des'+id).val()


  Swal.fire({
      title: "Desea actualizar este tipo "+desc,
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
        valid = $("#frmtp"+id).valid();
        if (valid) 
        {
          var data = new FormData();
          data.append('des',desc);
          data.append('id',id);
          data.append('modo',3);
          $.ajax({
            url: "modelo/tpmedicamento.php",       
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
                window.location="tpmedicamento.php";
              });
            }
          });
        }
      }
    });


}


function del_tpmedica(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',4);
    $.ajax({
      url: "modelo/tpmedicamento.php",       
      type: "POST",             
      data: data,               
      contentType: false,       
      cache: false,             
      processData:false,        
      success: function(data)   
      {
        alert(data)
	     window.location="tpmedicamento.php";
      }
    });
}