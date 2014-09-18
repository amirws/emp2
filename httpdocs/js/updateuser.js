function nuevo(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	
	return xmlhttp;
}
function update(){
    divContenido = document.getElementById('dialog-message');
    var username= document.getElementById('username').value;
    var nombre= document.getElementById('nombre').value;
    var direccion= document.getElementById('direccion').value;
    var email= document.getElementById('email').value;
	var miurl='/_updateuser.usuario';
	ajax=nuevo();
	ajax.open("POST",miurl, true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divContenido.innerHTML = ajax.responseText
			 $(function() {
   				 $( "#dialog-message" ).dialog({
      			modal: true,
      			buttons: {
       			Ok: function() {
         		$( this ).dialog( "close" );
        }
      }
    });		
  });
			 
   			 if (ajax.responseText.trim()=="<span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span>Datos actualizados correctamente"){
				setTimeout("cerrar()",2000);
			}
			

			
		}
		else{
			divContenido.innerHTML="Esperando Respuesta..";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("username="+username+"&nombre="+nombre+"&direccion="+direccion+"&email="+email)



}
function cerrar(){
				$("#dialog-message").remove();
				window.location.href="http://www.empresasveracruz.com.mx/acceso_clientes";
			}