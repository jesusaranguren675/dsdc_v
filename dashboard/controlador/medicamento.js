$(document).ready(function() {
  //$('#dtusu').DataTable();
  $('#dtmedi').DataTable({
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

  $("#exportar_pdf").click(function(){
    window.location ="pdf_medicamento.php"
  }); 

  $("#frmedi").validate({
    rules: {
      nom: 'required',
      cnt: 'required',
      cmbmed: 'required',
    },
    messages: {
      nom: 'Este campo es requerido.',
      cnt: 'Este campo es requerido.',
      cmbmed: 'Este campo es requerido.',
    }
  });

  $("#cant").mask("99999999");

});

function rg_medica() {
	nom  = $('#nom').val()
  cnt  = $('#cant').val()
  cmbmed  = $('#cmbmed').val()
  valid = $("#frmedi").valid();
  if (valid) 
  {
  	var data = new FormData();
  	  data.append('nom',nom);
      data.append('cnt',cnt);
      data.append('cmbmed',cmbmed);
  	  data.append('modo',1);
  	  $.ajax({
  	    url: "modelo/medicamento.php",       
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
  	         window.location="medicamento.php";
          });
  	    }
  	  });
  }
}

function ver_medica(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',2);
    $.ajax({
    url: "modelo/medicamento.php",       
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
      $('#mdlmedi'+dt[1]).modal('show')
	    $('#cmbmed'+dt[1]).val(dt[2])
      $("#frmedi"+dt[1]).validate({
        rules: {
          nom: 'required',
          cnt: 'required',
          cmbmed: 'required',
        },
        messages: {
          nom: 'Este campo es requerido.',
          cnt: 'Este campo es requerido.',
          cmbmed: 'Este campo es requerido.',
        }
      });
      $("#cant"+id).mask("99999999");
    }
  });
}

function act_medicamento(id) {
  nom  = $('#nom'+id).val()
  cnt  = $('#cant'+id).val()
  cmbmed  = $('#cmbmed'+id).val()


  Swal.fire({
      title: "Desea actualizar este tipo "+nom,
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
          data.append('nom',nom);
          data.append('cnt',cnt);
          data.append('cmbmed',cmbmed);
          data.append('id',id);
          data.append('modo',3);
          $.ajax({
            url: "modelo/medicamento.php",       
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
                window.location="medicamento.php";
              });
            }
          });
        }
      }
    });


}


function del_tpersona(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',4);
    $.ajax({
      url: "modelo/medicamento.php",       
      type: "POST",             
      data: data,               
      contentType: false,       
      cache: false,             
      processData:false,        
      success: function(data)   
      {
        alert(data)
	     window.location="medicamento.php";
      }
    });
}