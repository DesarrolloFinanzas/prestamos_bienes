////+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: currencyFormat
// Parametros:
// Objetivo: Funcion que al escribir un monto lo formatea
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function currencyFormat(fld, milSep, decSep, e) {
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true; // Enter
	if (whichCode == 8) return true; // Enter
	if (whichCode == 46) return true; // Enter
    key = String.fromCharCode(whichCode); // Get key value from key code
    if (strCheck.indexOf(key) == -1) return false; // Not a valid key
    len = fld.value.length;
    for(i = 0; i < len; i++)
     if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
    aux = '';
    for(; i < len; i++)
     if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) fld.value = '';
    if (len == 1) fld.value = '0'+ decSep + '0' + aux;
    if (len == 2) fld.value = '0'+ decSep + aux;
    if (len > 2) {
     aux2 = '';
     for (j = 0, i = len - 3; i >= 0; i--) {
      if (j == 3) {
       aux2 += milSep;
       j = 0;
      }
      aux2 += aux.charAt(i);
      j++;
     }
     fld.value = '';
     len2 = aux2.length;
     for (i = len2 - 1; i >= 0; i--)
      fld.value += aux2.charAt(i);
     fld.value += decSep + aux.substr(len - 2, len);
    }
    return false;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: campoRequerido
// Parametros: Nombre del formulario, Nombre del objeto o campo
// Objetivo: Permite validar que el valor de un objeto tipo input se diferente de null o blanco
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function campoRequerido(formInput,campo)
{
	var resultado = true;
	var ofrmcampo = formInput;
        if (trim(ofrmcampo.value).length == 0) 
	{
			alert('Por favor introduzca un valor en ' + campo +'.');
                        resultado = false;
	}
	return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: cancelar
// Parametros: Nombre del formulario, Nombre del target del Form
// Objetivo: Regresa a la pagina Principal
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 function cancelar(frmSource,frmTarget)
            {    
                 frmSource.action = frmTarget;
                 frmSource.submit(); 
           }
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: solonumeros
// Parametros: Nombre del objeto o campo
// Objetivo: Permite que el valor de un objeto tipo input sea de tipo numerico
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function solonumeros(e)
{

 var key;

 if(window.event) // IE
 {
  key = e.keyCode;
 }
  else if(e.which) // Netscape/Firefox/Opera
 {
  key = e.which;
 }

 if (key < 48 || key > 57)
    {
      e= e.substring()  
      return false;
    }

 return true;
}       


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: solomontos
// Parametros: Nombre del objeto o campo
// Objetivo: Permite que el valor de un objeto tipo input sea de tipo monto
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function campomoneda(formInput,campo){
   var ofrmcampo = formInput;    
   
   var numeric = ofrmcampo.value;
   var regex  = /^\d+(?:\.\d{0,2})$/;
   if (regex.test(numeric)){
     return true;
   }else{
      alert('Por favor introduzca un valor Moneda en"' + campo +'" Ejem:1.587,89');
      return false;
   }
 }  
 

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: solonumeros
// Parametros: Nombre del objeto o campo
// Objetivo: Permite que el valor de un objeto tipo input sea de tipo caracter
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function soloLetras(formInput,campo)
{
var ofrmcampo = formInput;

if (ofrmcampo.value.match(/^[a-zñA-ZÑ ' ']+$/))
{
    resultado = true;
}else{
    alert('Por Favor introduzca un valor que no tenga numeros para el campo "' + campo +'".');
    ofrmcampo.focus();
    resultado = false;    
}
return resultado;
} 

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: permite
// Parametros: 
// Objetivo: Valida la tecla pulsada sea numero, caracter o ambos.
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function permite(elEvento,permitidos){
var numeros = "0123456789";
var caracteres = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ@";
var numeros_caracteres = numeros + caracteres;
var teclas_especiales = [9, 8,37, 39, 46,32,];
switch(permitidos){
case 'num':
   permitidos = numeros;
   break;
case 'car':
   permitidos = caracteres;
   break;
case 'num_car':
   permitidos = numeros_caracteres;
   break;
case 'esp':
   permitidos = teclas_especiales;
   break;
}
var evento = elEvento || window.event;
var codigoCaracter = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigoCaracter);
var tecla_especial = false;
for(var i in teclas_especiales){
  if(codigoCaracter == teclas_especiales[i]){
     tecla_especial = true;
	 break;
  }
}
return permitidos.indexOf(caracter) != -1 || tecla_especial;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: SoloUnoCheckboxInput
// Parametros: Nombre del objeto o campo
// Objetivo: Verifica que se chequee solo un elemento de la matriz de un objeto tipo checkbox .
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function SoloUnoCheckboxInput(formInput)
{
    var intChecked = 0;
    var ofrmcampo = formInput;
    var resultado = true;
    for(i = 0; i < ofrmcampo.length; i++)
    {
        if(ofrmcampo[i].checked)
        {
            intChecked ++;
        }
    }

    if(intChecked>1)
    {
         alert("Disculpe usted debe seleccionar un solo checkbox!");
         resultado = false;
    }
    return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: trim 
// Parametros: Nombre del objeto o campo
// Objetivo: Permite validar que el valor de un objeto tipo input sea diferente de espacios en blanco
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function trim(s) 
{
  // Remove leading spaces and carriage returns
  
  while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
  {
    s = s.substring(1,s.length);
  }

  // Remove trailing spaces and carriage returns

  while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
  {
    s = s.substring(0,s.length-1);
  }
  return s;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: convierte la fecha al formato plano AAAAMMDD
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function toPlano(fecha,largo) {
	largo = ( largo == null || largo < 0 || largo > 8 ? 8 : largo );
	return (fecha.substring(fecha.length-4)+fecha.substring(fecha.length-7,fecha.length-5)+fecha.substring(0,2)).substring(0,largo);
}           
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaCampoNumerico
// Parametros: Nombre del formulario + Nombre del objeto o campo,
//             Nombre con el cual se identifica el campo (para el mensaje al usuario)
//             requerido (indica si el campo es obligatorio,
//             el valor de requerido puede ser true "campo obligatorio"
//             o false "campo no obligatorio")
// Objetivo: Esta funci�n permite validar que el valor de un campo (input tipo text) sea n�merico
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaCampoNumerico(formInput,campo,requerido)
{
	var resultado = true;
	var ofrmcampo = formInput;
	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

 	if (resultado)
 	{
 		if (!validaDigitos(ofrmcampo.value))
 		{
 			alert('Por Favor introduzca un valor numerico para el campo "' + campo +'".');
			ofrmcampo.focus();
			resultado = false;
		}
	}

	return resultado;
}

function validaCampoNumerico2(formInput,campo,requerido)
{
	var resultado = true;
	var ofrmcampo = formInput;
	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

 	if (resultado)
 	{
 		if (!validaDigitos(ofrmcampo.value))
 		{
                    if( ofrmcampo.value.indexOf('-') < 0) {
 			alert('Por Favor introduzca formato correcto para el campo "' + campo +'" ejem:000-000.');
			ofrmcampo.focus();
			resultado = false;}
		}
	}

	return resultado;
}



function validaCampoNumerico3(formInput,campo,requerido)
{
	var resultado = true;
	var ofrmcampo = formInput;
	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

 	if (resultado)
 	{
 		if (!validaDigitos(ofrmcampo.value))
 		{
                    if( ofrmcampo.value.indexOf(',') < 0) {
 			alert('Por Favor introduzca un valor correcto para el campo "' + campo +'" ejem: 1000,00');
			ofrmcampo.focus();
			resultado = false;}
		}
	}

	return resultado;
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaCheckbox
// Parametros: Nombre del formulario + Nombre del objeto o campo
//             Nombre con el cual se identifica el campo (para el mensaje al usuario)
// Objetivo: Verifica que al menos un checkbox est� seleccionado en una matriz de elementos
//           de este tipo de objeto.
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaCheckbox(formInput,campo)
{
   var resultado = false;
   var ofrmcampo = formInput;

  if (ofrmcampo.length == null)
  {
     if (ofrmcampo.checked){
        resultado = true;
      }else{
         resultado = false;
      }
  }
  else {
     for (i=0, n=ofrmcampo.length; i<n; i++)
    {
           if (ofrmcampo[i].checked)
         {
                 resultado = true;
         }
    }
  }
  return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaCheck
// Parametros: Nombre del formulario + el Nombre del objeto Checkbox y el nombre del campo
// Objetivo: Ejecuta 2 funciones validaCheckbox y SoloUnoCheckboxInput
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaCheck(formInput,campo,cantreg)
{

    var ofrmcampo = formInput;
    if(!validaCheckbox(ofrmcampo,campo,cantreg)){
       	return false;
    }else if(cantreg!=1){
       if(!SoloUnoCheckboxInput(ofrmcampo)){
         return false;
       }else{
       		return true;
    			}
    }else{
       		return true;
    }

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaSelect
// Parametros: Nombre del formulario, Nombre del objeto o campo
// Objetivo: Verifica que se seleccione un valor de una lista de selecci�n o combo
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaSelect(formInput,campo)
{
     var resultado = true;
     var ofrmcampo = formInput;
     if ( ofrmcampo.selectedIndex == 0 )
     {
           resultado = false;
     }

     if (!resultado )
     {
          alert('Por Favor seleccione una opcion para el campo "' + campo +'".');
          ofrmcampo.focus();
     }
return resultado;
}

function validaSelectParro(formInput,campo)
{
     var resultado = true;
     var ofrmcampo = formInput;
     if ( ofrmcampo.selectedIndex == 0 || ofrmcampo.value==1145 )
     {
           resultado = false;
     }

     if (!resultado )
     {
          alert('Por Favor seleccione una opcion para el campo "' + campo +'".');
          ofrmcampo.focus();
     }
return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaEmail
// Parametros: Nombre del formulario, Nombre del objeto o campo,requerido (indica si el campo es
// obligatorio)
// Objetivo: Verifica que una direcci�n de correo electr�nico sea v�lida.
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaEmail(formInput,campo,requerido)
{
	var resultado = true;
	var ofrmcampo = formInput;

	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

	if (resultado && ((ofrmcampo.value.length < 3) || !validaDireccionEmail(ofrmcampo.value)) )
	{
		alert("Por favor introduzca una direccion de correo valida: usuario@mefbp.gob.ve");
		ofrmcampo.focus();
		resultado = false;
	}

  return resultado;

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaDireccionEmail
// Parametros: email (direccion de correo electronica)
// Objetivo: Verifica que una cuenta de correo electr�nico sea v�lida
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaDireccionEmail(email)
{
  var resul1 = false;  
  var resul2 = false;  
  var resultado = false;
  var strEmail = new String(email);
  var index = strEmail.indexOf("@MEFBP.GOB.VE");
  var index2 = strEmail.indexOf("@mefbp.gob.ve");
  if (index > 0 || index2 > 0)
  {
    var pindex = strEmail.indexOf(".",index);
    if ((pindex > index+1) && (strEmail.length > pindex+1))
	resul1 = true;
        
        var pindex2 = strEmail.indexOf(".",index2);
        if ((pindex2 > index2+1) && (strEmail.length > pindex2+1))
	resul2 = true;
        if (resul1 && resul2) resultado=true;
  }
  return resultado;
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaEntero
// Parametros: Nombre del formulario, Nombre del objeto o campo,requerido (indica si el campo es
// obligatorio)
// Objetivo: Verifica que el valor de un objeto tipo input sea un numero entero.
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaEntero(formInput,campo,requerido)
{
	var resultado = true;
	var ofrmcampo = formInput;

	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

 	if (resultado)
 	{
 		var num = parseInt(ofrmcampo.value,10);
 		if (isNaN(num))
 		{
 			alert('Por favor introduzca un valor entero para el campo "' + campo +'".');
			ofrmcampo.focus();
			resultado = false;
		}
	}

	return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaFecha
// Parametros: Nombre del formulario, Nombre del objeto o campo,requerido (indica si el campo es
// obligatorio)
// Objetivo: Verifica que el valor de un objeto tipo input sea una fecha v�lida,
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


function validaFecha(formInput,campo,requerido)
{
	var resultado = true;
        var ofrmcampo = formInput;

	if (requerido && !campoRequerido(ofrmcampo,campo))
		resultado = false;

 	if (resultado)
 	{
 		var elems = ofrmcampo.value.split("/");

 		resultado = (elems.length == 3);

 		if (resultado)
 		{
 			var dia = parseInt(elems[0],10);
                        var mes = parseInt(elems[1],10);
                        
                        resultado = validaDigitos(elems[0]) && (dia > 0) && (dia < 32) &&
                                    validaDigitos(elems[1]) && (mes > 0) && (mes < 13) &&
                                    validaDigitos(elems[2]) && ((elems[2].length == 2) || (elems[2].length == 4));
 		}

  		if (!resultado)
 		{
 			alert('Por favor ingrese una fecha con el formato DD/MM/AAAA para el campo "' + campo +'".');
			formInput.focus();
		}
	}

	return resultado;
}


//***********************************************************************************************
// validarFecha(dia,mes, año)
//
// Valida que el día y el mes introducidos sean correctos. Además valida que el año introducido
// sea o no bisiesto
//
//***********************************************************************************************


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaDigitos
// Parametros: str: valor del campo o cadena a validar
// Objetivo: Verifica que el valor del input contenga solo d�gitos.
//           Invoca la funcion validaInValidoCaracter
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaDigitos(str)
{
	return validaInValidoCaracter(str,"0123456789");
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaDigitosDecimal
// Parametros: str: valor del campo o cadena a validar
// Objetivo: Verifica que el valor del input contenga solo d�gitos.
//           Invoca la funcion validaInValidoCaracter
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaDigitosDecimal(str)
{
	return validaInValidoCaracter(str,"0123456789.,");
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaInValidoCaracter
// Parametros: str: valor del campo o cadena a comparar
//             charset: valor con el cual se compara.
// Objetivo: Compara una cadena de caracteres con el valor del segundo parametro que recibe en la funcion.
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaInValidoCaracter(str,charset)
{
	
	var resultado = true;

	for (var i=0;i<str.length;i++)
	if (charset.indexOf(str.substr(i,1))<0)
	{
		resultado = false;
		break;
	}
	
	return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validIgualdadCampos
// Parametros: Nombre del campo 1 y nombre del campo 2
// Objetivo: compara si dos campos son iguales
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validIgualdadCampos(campo1, campo2){
	if (campo1.value == campo2.value){
		return true;
	}else{
		alert('El campo"'+campo1+'" y el campo "'+campo2+'" deben ser iguales');
	 setvalor(campo1);
		return false;
	}
}
function validaCampoAlfanum(campo)
{
	var resultado = true;	
	
	if (resultado)
 	{
 		if (!validaAlfanum(campo))
 		{
 			alert("El codigo del medicamento solo debe tener letras y/o numeros. Por favor verifique los datos e intente de nuevo");			
			resultado = false;
		}
	}

	return resultado;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: validaCampoAlfanumerico
// Parametros: Nombre del formulario, Nombre del objeto o campo
// Objetivo: Permite validar que el valor de un objeto tipo input sea de tipo alfanumerico
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function validaCampoAlfanumerico(formInput,campo)
{
	var resultado = true;
	var ofrmcampo = formInput;
        if (!isNaN(ofrmcampo.value))
	{
			alert('Por favor introduzca un valor valido en ' + campo +'.');
                        clear(ofrmcampo);
			//ofrmcampo.focus();
                        resultado = false;
	}
	return resultado;
}

//**************************************************************************
   function esDigito(sChr){
    var sCod = sChr.charCodeAt(0);
    return ((sCod > 47) && (sCod < 58));
   }

   function valSep(oTxt){
    var bOk = false;
    bOk = bOk || ((oTxt.value.charAt(2) == "-") && (oTxt.value.charAt(5) == "-"));
    bOk = bOk || ((oTxt.value.charAt(2) == "/") && (oTxt.value.charAt(5) == "/"));
    return bOk;
   }

   function finMes(oTxt){
    var nMes = parseInt(oTxt.value.substr(3, 2), 10);
    var nAno = parseInt(oTxt.value.substr(6), 10);
    var nRes = 0;
    switch (nMes){
     case 1: nRes = 31; break;
     case 2: nRes = 28; break;
     case 3: nRes = 31; break;
     case 4: nRes = 30; break;
     case 5: nRes = 31; break;
     case 6: nRes = 30; break;
     case 7: nRes = 31; break;
     case 8: nRes = 31; break;
     case 9: nRes = 30; break;
     case 10: nRes = 31; break;
     case 11: nRes = 30; break;
     case 12: nRes = 31; break;
    }
    return nRes + (((nMes == 2) && (nAno % 4) == 0)? 1: 0);
   }

   function valDia(oTxt){
    var bOk = false;
    var nDia = parseInt(oTxt.value.substr(0, 2), 10);
    bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt)));
    return bOk;
   }

   function valMes(oTxt){
    var bOk = false;
    var nMes = parseInt(oTxt.value.substr(3, 2), 10);
    bOk = bOk || ((nMes >= 1) && (nMes <= 12));
    return bOk;
   }

   function valAno(oTxt){
    var bOk = true;
    var nAno = oTxt.value.substr(6);
    bOk = bOk && ((nAno.length == 2) || (nAno.length == 4));
    if (bOk){
     for (var i = 0; i < nAno.length; i++){
      bOk = bOk && esDigito(nAno.charAt(i));
     }
    }
    return bOk;
   }

   function valFecha(oTxt){ 
    var bOk = true;
    if (oTxt.value != ""){
     bOk = bOk && (valAno(oTxt));
     bOk = bOk && (valMes(oTxt));
     bOk = bOk && (valDia(oTxt));
     bOk = bOk && (valSep(oTxt));
    }else{ bOk = false;}
     return bOk;
   }

   function fechaMayorOIgualQue(fec0, fec1){
    var bRes = false;
    var sDia0 = fec0.value.substr(0, 2);
    var sMes0 = fec0.value.substr(3, 2);
    var sAno0 = fec0.value.substr(6, 4);
    var sDia1 = fec1.value.substr(0, 2);
    var sMes1 = fec1.value.substr(3, 2);
    var sAno1 = fec1.value.substr(6, 4);
    if (sAno0 > sAno1) bRes = true;
    else {
     if (sAno0 == sAno1){
      if (sMes0 > sMes1) bRes = true;
      else {
       if (sMes0 == sMes1)
        if (sDia0 >= sDia1) bRes = true;
      }
     }
    }
    return bRes;
   }


function comparaFecha(fecha, fecha2){
var fechaIni=fecha.split("/");
var fechaFin=fecha2.split("/");

if(parseInt(fechaIni[2],10)>parseInt(fechaFin[2],10)){
return(true);
}else{
if(parseInt(fechaIni[2],10)==parseInt(fechaFin[2],10)){
if(parseInt(fechaIni[1],10)>parseInt(fechaFin[1],10)){
return(true);
}
if(parseInt(fechaIni[1],10)==parseInt(fechaFin[1],10)){
if(parseInt(fechaIni[0],10)>parseInt(fechaFin[0],10)){
return(true);
}else{
return(false);
}
}else{
return(false);
}
}else{
return(false);
}
}

}

function convierte_monto(campo){
 var campo1=0;
 campo1 = campo.split(".").join("");
 campototal = campo1.split(",").join(".");
 return campototal;
} 


function redondear(cantidad, decimales) {
var cantidad = parseFloat(cantidad);
var decimales = parseFloat(decimales);
decimales = (!decimales ? 2 : decimales);
return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
} 


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Nombre: numero
// Parametros: Nombre del objeto o campo
// Objetivo: Permite que el valor de un objeto tipo input sea de tipo numerico
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function numero(objeto,e){ 
	var evento_key = /*window.event.keyCode; */(document.all) ?e.keyCode : e.which;
	
	switch (evento_key) 
	{ 
		case 0:/*flechas*/
		case 8:/**/
		case 48:/**/     
		case 49:/**/      
		case 50:/**/
		case 51:/**/     
		case 52:/**/      
		case 53:/**/
		case 54:/**/     
		case 55:/**/      
		case 56:/**/
		case 57:/**/    
		case 13:return true; /**/	 
		break; 
		
		default: 
		return false; 
	 } 
   return true; 
}
