<?php

App::uses('CakeEmail', 'Network/Email');

class EmailUtil {
    
    const EMAIL_ADMINISTRADOR = "anuario@sao.albacete.org";
    const NOMBRE_ADMINISTRADOR = "Anuario Ornitológico de Albacte Online";
    
    public static function enviarEmailNuevaCitaRareza($especie, $citaId, $usuario) {
        
        try {
            
            $nombreEspecie = $especie['Especie']['genero']." ".$especie['Especie']['especie'];
            $nombreUsuario = $usuario['username'];
            $emailUsuario = $usuario['email'];
            
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to(EmailUtil::EMAIL_ADMINISTRADOR);
            $Email->subject("[ALTA RAREZA] Nueva cita de $nombreEspecie con id $citaId");
            $Email->send("El usuario $nombreUsuario ($emailUsuario) ha dado de alta una nueva cita de $nombreEspecie con id $citaId.");
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailNuevLugar($lugar, $usuario) {
    
        try {
                
            $lugarNombre = $lugar['Lugar']['nombre'];
            $lugarId = $lugar['Lugar']['id'];
            $nombreUsuario = $usuario['username'];
            $emailUsuario = $usuario['email'];
                
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to(EmailUtil::EMAIL_ADMINISTRADOR);
            $Email->subject("[ALTA LUGAR] Nueva lugar \"$lugarNombre\" con id $lugarId");
            $Email->send("El usuario $nombreUsuario ($emailUsuario) ha dado de alta el nuevo lugar \"$lugarNombre\" con id $lugarId.");
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailBajaCita($especie, $citaId, $usuario) {
    
        try {
    
            $nombreEspecie = $especie['Especie']['genero']." ".$especie['Especie']['especie'];
            $nombreUsuario = $usuario['username'];
            $emailUsuario = $usuario['email'];
    
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to(EmailUtil::EMAIL_ADMINISTRADOR);
            $Email->subject("[BAJA CITA] Se ha dado de baja una cita de \"$nombreEspecie\" con id $citaId");
            $Email->send("El usuario $nombreUsuario ($emailUsuario) ha dado de baja una cita de \"$nombreEspecie\" con id $citaId.");
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailNuevoUsuario($usuario) {
    
        try {
    
            $nombreUsuario = $usuario['User']['username'];
            $emailUsuario = $usuario['User']['email'];
            $idUsuario = $usuario['User']['id'];
    
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to(EmailUtil::EMAIL_ADMINISTRADOR);
            $Email->subject("[ALTA USUARIO] Se ha dado de alta el nuevo usuario $nombreUsuario con id $idUsuario");
            $Email->send("El usuario $nombreUsuario ($emailUsuario) se ha dado de alta con id $idUsuario.");
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailBajaUsuario($usuario) {
    
        try {
    
            $nombreUsuario = $usuario['username'];
            $emailUsuario = $usuario['email'];
            $idUsuario = $usuario['id'];
    
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to(EmailUtil::EMAIL_ADMINISTRADOR);
            $Email->subject("[BAJA USUARIO] Se ha dado de baja el usuario $nombreUsuario con id $idUsuario");
            $Email->send("El usuario $nombreUsuario ($emailUsuario) se ha dado de baja con id $idUsuario.");
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailRegenerarPassword($email, $enlace) {
    
        try {
    
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to($email);
            $Email->subject("Recueprar contraseña");
            
$content = <<<cuerpo
    Para poder recuperar tu contraseña para el Anuario Ornitológico de Albacete Online, pincha en el siguiente enlace: 
    
    $enlace

    Si no funciona, prueba a copiar el enlace y pegarlo en la barra de navegación de tu navegador web.

    Ten en cuenta que el enlace caducará en 1 día. Transcurrido este tiempo, tendrás que volver a pedirnos que te enviemos este correo.

            
    <b>Anuario Ornitológico de Albacete Online.</b>

cuerpo;
            
            $Email->send($content);
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
    
    public static function enviarEmailActivarUsuario($email, $enlace) {
    
        try {
    
            $Email = new CakeEmail('gmail');
            $Email->from(array(EmailUtil::EMAIL_ADMINISTRADOR => EmailUtil::NOMBRE_ADMINISTRADOR));
            $Email->to($email);
            $Email->subject("Activar usuario");
                
$content = <<<cuerpo
    Para activar tu usuario, pincha en el siguiente enlace:
    
    $enlace
    
    Si no funciona, prueba a copiar el enlace y pegarlo en la barra de navegación de tu navegador web.
    
    Ten en cuenta que el enlace caducará en 1 día. Transcurrido este tiempo, tendrás que volver a pedirnos que te enviemos este correo.
    
        
    Anuario Ornitológico de Albacete Online.
    
cuerpo;
                
            $Email->send($content);
        }
        catch (Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    }
}

?>