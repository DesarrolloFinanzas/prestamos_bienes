<?php
function traduce_fecha($fecha){
		$str=explode("/",$fecha);
                if ($str[0]<>''){
		$str_final = $str[0]."/".$str[1]."/".$str[2];}
                else{$str_final='';}
		return $str_final;
}
function traduce_fecha_eng($fecha){
		$str=explode("/",$fecha);
                if ($str[0]<>''){
		$str_final = $str[0]."/".$str[1]."/".$str[2];}
                else{$str_final='';}
		return $str_final;
}
/*portatil*/

function convierte_fecha($fecha){
		$str=explode("-",$fecha);
		if ($str[0]<>''){
		$str_final = $str[2]."/".$str[1]."/".$str[0];}
                else{$str_final='';} 
		return $str_final;
}
/* pc */
function convierte_fecha2($fecha){
		$str=explode("/",$fecha);
                if ($str[0]<>''){
		$str_final = $str[0]."/".$str[1]."/".$str[2];}
                else{$str_final='';} 
	return $str_final;
}


function convierte_monto($monto){
  $monto3=str_replace(".","",$monto);
  $monto=str_replace(",",".",$monto3);  
  return $monto;
}
      

function caracteres_especiales($texto){

  $texto = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ":",
             ".", " "),
        '',
        $texto
    );
  return $texto;
}


function conexion_ldap($usuario,$password) {
    
    $domname = '@mppbf.gob.ve';
    $username = $usuario.$domname;
    $ldapconfig['host'] = '10.5.13.93';
    $ldapconfig['port'] = '389';
    $ldapconfig['basedn'] = 'dc=mppbf,dc=gob,dc=ve';

    $ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

    $dn="".$username."";
    if ($bind=ldap_bind($ds, $dn, $password)) {
        $read = ldap_search($ds,'dc=mppbf,dc=gob,dc=ve',"samAccountName=$usuario")
        or exit(">>Unable to search ldap server<<");
        $info = ldap_get_entries($ds, $read);
        $data =  'description';
        return $info[0][$data][0];
    }else{
        return 0;
    }
}

?>