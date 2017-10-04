<?php

include("../../comunes/script/JasperClient.php");
// ** Los valores de las variales se agregan en el archivo settings.yml **
            //**desarrollo y calidad**//
            $jasper_url = "http://10.5.13.51:8080/jasperserver/services/repository";
            $jasper_username = "jasperadmin";
            $jasper_password = "jasperadmin";
    
            $client = new JasperClient($jasper_url, $jasper_username, $jasper_password);
            /**desarrollo**/
            $report_unit = "/BIENES/acta_prestamo";
        
            $report_params = array('id_solicitud' => 62 , 'cedula'=>'65498496489','ciudadano'=>'asddasiodj asoijdaosijd');
            $report_format = "PDF";
            $result = $client->requestReport($report_unit, $report_format,$report_params);
            header("Content-type: application/pdf");
            echo $result;
?>