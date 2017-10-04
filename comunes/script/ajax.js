function objetoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (e) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


function cargar(e,url){
	var contenedor;
	contenedor = document.getElementById(e);
	ajax=objetoAjax();
	ajax.open("GET", url);
	ajax.onreadystatechange=function() {    
	if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}
	}
        ajax.send(null);
}     

