function ingreso() {
	usu  = $('#usu').val()
	pass = $('#pass').val()
	//alert(usu+'   '+pass)
	var data = new FormData();
  data.append('usu',usu);
  data.append('pass',pass);
  data.append('modo',1);

  $.ajax({
    url: "login.php",       
    type: "POST",             
    data: data,               
    contentType: false,       
    cache: false,             
    processData:false,        
    success: function(data)   
    {
      if (data!=1)
      {
      	alert(data)
      }
      else
      {
      	window.location="dashboard/tablero.php";
      }
    }
  });
}