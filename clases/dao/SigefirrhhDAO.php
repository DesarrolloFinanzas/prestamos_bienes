<?php

require_once $RutaDao.'/utils/ConexionPostgreSQL_sigefirrhh.php'; 

class SigefirrhhDAO{  
    
function ConsultarPorCedulaSigefirrhhDAO($c_cedula){

  $objConexionPostgreSQL_sigefirrhh = new ConexionPostgreSQL_sigefirrhh();  

    $sql="SELECT
        tipopersonal.id_tipo_personal,
        tipopersonal.nombre,
        CASE WHEN tipopersonal.id_tipo_personal = 92
        THEN 'Jubilado'
        WHEN tipopersonal.id_tipo_personal = 25
        THEN 'Jubilado'
        WHEN tipopersonal.id_tipo_personal = 20
        THEN 'Jubilado'
        WHEN tipopersonal.id_tipo_personal = 28
        THEN 'Pensionado'
        WHEN tipopersonal.id_tipo_personal = 32
        THEN 'Pensionado'
        WHEN tipopersonal.id_tipo_personal = 102
        THEN 'Pensionado'
        WHEN tipopersonal.id_tipo_personal = 29
        THEN 'Sobreviviente'
        WHEN tipopersonal.id_tipo_personal = 33
        THEN 'Sobreviviente'
        END,
          personal.primer_nombre,
          personal.segundo_nombre,
          personal.primer_apellido,
          personal.segundo_apellido,
          personal.cedula,
          personal.fecha_nacimiento,
          personal.direccion_residencia,
          personal.telefono_celular,
          personal.telefono_residencia,
          estatus
        FROM
          public.personal,
          public.trabajador,
          public.tipopersonal
        WHERE
          personal.id_personal = trabajador.id_personal AND
          trabajador.id_tipo_personal = tipopersonal.id_tipo_personal and estatus in ('A','S') AND
          tipopersonal.id_tipo_personal in (92,25,20,28,32,102,29,33) and
          personal.cedula = ".$c_cedula." order by tipopersonal.id_tipo_personal;";
          //die($sql);  
  $Resultado = $objConexionPostgreSQL_sigefirrhh->Consultar($sql);

  return $Resultado;
}


function ConsultarPorCedulaSigefirrhhEgrDAO($c_cedula){

  $objConexionPostgreSQL_sigefirrhh = new ConexionPostgreSQL_sigefirrhh();  

    $sql="SELECT 
            v_datos.primer_nombre, 
            v_datos.primer_apellido, 
            v_datos.segundo_nombre, 
            v_datos.segundo_apellido
          FROM 
            public.v_datos_personales_egresados AS v_datos
          WHERE 
            v_datos.cedula = '$c_cedula';";
  //die($sql);  
  $Resultado = $objConexionPostgreSQL_sigefirrhh->Consultar($sql);

  return $Resultado;
}


function ConsultarSigefirrhhDAO($cedula){

  $objConexionPostgreSQL_sigefirrhh = new ConexionPostgreSQL_sigefirrhh();  

    $sql="SELECT 
            v_datos.primer_nombre, 
            v_datos.primer_apellido, 
            v_datos.descripcion_cargo, 
            v_datos.dependencia,v_datos.cedula,
            v_datos.segundo_nombre, 
            v_datos.segundo_apellido
          FROM 
            public.public.personal AS v_datos
          WHERE
             v_datos.cedula =".$cedula.";";
            //die($sql);  
            $Resultado = $objConexionPostgreSQL_sigefirrhh->Consultar($sql);

  return $Resultado;
}

function SigefiPrestamo($ci){
  $objConexionPostgreSQL_sigefirrhh = new ConexionPostgreSQL_sigefirrhh(); 
  
    $sql="SELECT 
        personal.cedula,personal.primer_nombre,personal.segundo_nombre,personal.primer_apellido,personal.segundo_apellido
      FROM 
        public.personal
      WHERE 
        personal.cedula = ".$ci.";";
          $Resultado = $objConexionPostgreSQL_sigefirrhh->Consultar($sql);

        return $Resultado;
}

}