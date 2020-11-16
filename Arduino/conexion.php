<?php  
    function conectar(){
        $cone = mysqli_connect('localhost','root','','estacion');
        if( $cone ){
            mysqli_query($cone,"SET NAMES 'utf8'");
            echo( "Conexion Exitosa");
            return $cone ;
        }else{
            echo( "Conexion Fallida");
        }
    }
?>