$(document).ready(function(){
    $('.premium').load('/a-a-index/ajax');
    setInterval(banner260, 5000);
	$('.active').bind("click", function() {
		$('.muestra').text('');
		$('.muestra').html('<h3>!Registrate <span>GRATIS</span> ahora!</h3> <form action="registro" method="post" name="registro" id="registro"><br><label>Correo Electr&oacutenico:</label><br><input name="email" type="email" placeholder="Correo Electrónico" class="input" id="email" required="required" value=""></label><br><label>Contrase&ntildea:</label><br><input name="password" type="password" placeholder="Contraseña" class="input" required="required" value=""></label><br><label>Repite Contrase&ntildea:</label><br><input name="repeatPassword" type="password" placeholder="Repite Contraseña" class="input" required="required" value=""></label><hr /><input name="send" type="submit" class="btn btn-sm btn-primary btn-block" value="REGISTRARME"></form>');
		$('.span2').addClass('active');
		$('.active').removeClass('span2');
		$('.muestra').removeClass('muestra2');
		$('.span3').removeClass('span4');
		$('.muestra > h3').removeClass('redes');
	});
	
	$('.span3').bind("click", function (){
		$('.active').addClass('span2');
		  $('.muestra').addClass('muestra2');
		  $('.span3').addClass('span4');
		  $('.muestra > h3').addClass('redes');
		  $('.active').removeClass('active');
  		
  		$('.muestra').html('<div id="fb-root"></div><script>(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));</script><html xmlns:fb="http://ogp.me/ns/fb#"><fb:like href="https://www.facebook.com/empresasver" width="300" layout="standard" action="recommend" show_faces="true" share="true"></fb:like><br><!-- Inserta esta etiqueta donde quieras que aparezca widget. --><div class="g-page" data-href="https://plus.google.com/105952444338815732712" data-layout="landscape" data-rel="publisher"></div><!-- Inserta esta etiqueta después de la última etiqueta de widget. --><script type="text/javascript">window.___gcfg = {lang: "es"};(function() {var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/platform.js";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);})();</script>');

	});  
});
function banner260(){
	$('.premium').load('/a-a-index/ajax');
}
	  
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
function registrar(){
    divContenido = document.getElementById('dialog-message');
    var email= document.getElementById('email').value;
    var password= document.getElementById('password').value;
    var repeatPassword= document.getElementById('repeatPassword').value;
	var miurl='/registro_nuevo.usuario';
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
			
		}
		else{
			divContenido.innerHTML="Esperando Respuesta..";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("email="+email+"&password="+password+"&repeatPassword="+repeatPassword)



}

function enviar() {

}



