$(document).ready(function() {
  //$('#dtusu').DataTable();
  $('#dtasig').DataTable({
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
    window.location ="asignacion_medicamento_pdf.php"
  }); 

  $("#frmasig").validate({
    rules: {
      fech: 'required',
      cmbpaci: 'required',
      "cmbmed[]": 'required',
      can: 'required',
      des: 'required',
    },
    messages: {
      fech: 'Este campo es requerido.',
      cmbpaci: 'Este campo es requerido.',
      "cmbmed[]": 'Este campo es requerido.',
      can: 'Este campo es requerido.',
      des: 'Este campo es requerido.',
    }
  });

  $('#cmbmed').select2({
    theme: 'bootstrap4',
    width: 'style',
    placeholder: $('#select-single').attr('placeholder'),
    allowClear: Boolean($('#select-single').data('allow-clear')),
    maximumSelectionLength: 3
  });

  $("#can").mask("99999999");


   $('#date_range').daterangepicker({
    locale: {
      "format": "YYYY-MM-DD",
      "separator": "   |   ",
      "applyLabel": "Guardar",
      "cancelLabel": "Cancelar",
      "fromLabel": "Desde",
      "toLabel": "Hasta",
      "customRangeLabel": "Personalizar",
      "daysOfWeek": [
        "Do",
        "Lu",
        "Ma",
        "Mi",
        "Ju",
        "Vi",
        "Sa"
      ],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Setiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
      ],
      firstDay: 1
    },
    opens: "center"
  });

});

function rg_asig() {
	//fch  = $('#fech').val()
  pci  = $('#cmbpaci').val()
  med  = $('#cmbmed').val()
  can  = $('#can').val()
  des  = $('#des').val()
  valid = $("#frmasig").valid();
  if (valid) 
  {
  	var data = new FormData();
  	  //data.append('fch',fch);
      data.append('pci',pci);
      data.append('med',med);
      data.append('can',can);
      data.append('des',des);
  	  data.append('modo',1);
  	  $.ajax({
  	    url: "modelo/asignacion.php",       
  	    type: "POST",             
  	    data: data,               
  	    contentType: false,       
  	    cache: false,             
  	    processData:false,        
  	    success: function(data)   
  	    {
          // "success", "error", "warning", "info" o "question"
          dt = data.split("|");
          tipo = dt[1].trim() == '0' ? 'success' : 'error';
          Swal.fire({
            title: 'Respuesta',
            text: dt[0],
            icon: tipo,
            button: "Aceptar",
          }).then(function(result){
  	        window.location="asignacion.php";
          });
  	    }
  	  });
  }
}

function ver_asig(id) {
    var data = new FormData();
    data.append('id',id);
    data.append('modo',2);
    $.ajax({
    url: "modelo/asignacion.php",       
    type: "POST",             
    data: data,               
    contentType: false,       
    cache: false,             
    processData:false,        
    success: function(data)   
    {
      dt = data.split('|');
      $('#muestra_modal').html(dt[0])
      $('#mdlasig'+dt[1]).modal('show')
      $('#cmbpaci'+dt[1]).val(dt[2])
      $('#des'+dt[1]).val(dt[3])
      /*Funcion para selecionar un selec multiple*/
      dis1 = $('#cmbmed'+dt[1]).select2({
        theme: 'bootstrap4',
        width: 'style',
        tags: true,
        maximumSelectionLength: 3
      });
      array = dt[4];
      val1 = JSON.parse(array);
      val1.forEach(function(e){
        if(!dis1.find('option:contains(' + e + ')').length) 
          dis1.append($('<option>').html(e[2]));
      });
      dis1.val(val1).trigger("change"); 
      /*Fin de la funcion*/
      $("#frmasig"+dt[1]).validate({
        rules: {
          fech: 'required',
          cmbpaci: 'required',
          cmbmed: 'required',
          can: 'required',
          des: 'required',
        },
        messages: {
          fech: 'Este campo es requerido.',
          cmbpaci: 'Este campo es requerido.',
          cmbmed: 'Este campo es requerido.',
          can: 'Este campo es requerido.',
          des: 'Este campo es requerido.',
        }
      });
      $("#can").mask("99999999");
    }
  });
}

function act_asig(id) {
  fch  = $('#fech'+id).val()
  pci  = $('#cmbpaci'+id).val()
  med  = $('#cmbmed'+id).val()
  can  = $('#can'+id).val()
  des  = $('#des'+id).val()

  Swal.fire({
      title: "Desea actualizar?",
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
        valid = $("#frmasig"+id).valid();
        if (valid) 
        {
          var data = new FormData();
          data.append('fch',fch);
          data.append('pci',pci);
          data.append('med',med);
          data.append('can',can);
          data.append('des',des);
          data.append('id',id);
          data.append('modo',3);
          $.ajax({
            url: "modelo/asignacion.php",       
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
                button: "Registro actualizado",
              }).then(function(result){
                window.location="asignacion.php";
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
      url: "modelo/asignacion.php",       
      type: "POST",             
      data: data,               
      contentType: false,       
      cache: false,             
      processData:false,        
      success: function(data)   
      {
        alert(data)
	     window.location="asignacion.php";
      }
    });
}



function buscar(val) {
  fecha = $('#date_range').val()
  datos = fecha.split('|')
  fh_dsd = datos[0].trim()
  fh_hst = datos[1].trim()
  console.log(fh_dsd+'    '+fh_hst)
  if (val) 
    str = " AND a.fecha >= '"+fh_dsd+"' AND a.fecha <= '"+fh_hst+"' ";
  else
    str = " ";

  var data = new FormData();
  data.append('str',str);
  data.append('modo',5);
  $.ajax({
    url: "modelo/asignacion.php",       
    type: "POST",             
    data: data,               
    contentType: false,       
    cache: false,             
    processData:false,        
    success: function(data)   
    {
      $('#carga').html(data)
    }
  });
}