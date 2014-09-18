function objetoAjax(){
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
function logo(id, url, nombre){
	if (confirm('Se perderán los cambios. ¿Desea continuar?')) {
		document.location.href='http://www.e/usuario/cpanel/logoupdate/'+id;
		
	}
	else{}
	
	
}

function valor(nombre, id, url){
	var OSX = {
		container: null,
		init: function () {
				$("#osx-modal-content").modal({
					overlayId: 'osx-overlay',
					containerId: 'osx-container',
					closeHTML: null,
					minHeight: 80,
					opacity: 65, 
					position: ['0',],
					overlayClose: true,
					onOpen: OSX.open,
					onClose: OSX.close
				});
		},
		open: function (d) {
			var self = this;
			self.container = d.container[0];
			d.overlay.fadeIn('slow', function () {
				$("#osx-modal-content", self.container).show();
				var title = $("#osx-modal-title", self.container);
				title.show();
				d.container.slideDown('slow', function () {
					setTimeout(function () {
						var h = $("#osx-modal-data", self.container).height()
							+ title.height()
							+ 20; 	
							 divContenido=document.getElementById('dos');
							 title=document.getElementById('osx-modal-title');
							 var url2="'"+url+"'";
							 var nombre2="'"+nombre+"'";
							 if (url=='editarbasico'){title.innerHTML='Modificar: '+nombre+    '<button type="button" class="btn btn-default btn-sm" onclick="logo('+id+','+url2+','+nombre2+');">Modificar Logo</button>';}
			           		 else if (url=='editarestandar'){title.innerHTML='Modificar: '+nombre+    '<button type="button" class="btn btn-default btn-sm" onclick="logo('+id+','+url2+','+nombre2+');">Modificar Logo</button>';}
			           		 else if (url=='editarpremium'){title.innerHTML='Modificar: '+nombre+    '<button type="button" class="btn btn-default btn-sm" onclick="logo('+id+','+url2+','+nombre2+');">Modificar Logo</button>';}
			            		else {
			            			title.innerHTML='Modificar: '+nombre + ' - <button type="button" class="btn btn-sm btn-default" disabled="disabled"> Modificar Logo</button> (Inhabilitado Cuenta: Gratuita)';
			            		}
							
							 
							 ajax=objetoAjax();
								ajax.open("POST", "/usuario/cpanel/editar",true);
								ajax.onreadystatechange=function() {
									if (ajax.readyState==4) {
										divContenido.innerHTML = ajax.responseText
									}
									else{
										divContenido.innerHTML= "...";
									}
								}
								ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
								ajax.send("id="+id)
						    d.container.animate(
							{height: h }, 
							200,
							function () {
								$("div.close", self.container).show();
								$("#osx-modal-data", self.container).show();
							}
						);
					}, 300);
				});
			})
		},
		close: function (d) {
			var self = this; // this = SimpleModal object
			d.container.animate(
				{top:"-" + (d.container.height() + 20)},
				500,
				function () {
					self.close(); // or $.modal.close();
				}
			);
		}
	};

	OSX.init();

}

