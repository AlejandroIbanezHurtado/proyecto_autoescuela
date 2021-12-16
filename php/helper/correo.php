<?php
    use PHPMailer\PHPMailer\PHPMailer;
class correo{
    private static $correo="autoescuelaproyecto2021@gmail.com";
    private static $pass = "autoescuela123";

    public static function enviaCorreo($asunto, $mensaje, $destinatario){
        require "vendor/autoload.php";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 2;                          
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";//tls                 
        $mail->Host       = "smtp.gmail.com";    
        $mail->Port       = 465;//587                 
        // introducir usuario de google
        $mail->Username   = self::$correo; 
        // introducir clave
        $mail->Password   = self::$pass;       
        $mail->SetFrom(self::$correo, 'Autoescuela Proyecto');
        // asunto
        $mail->Subject    = $asunto;
        // cuerpo
        /*$foto = file_get_contents("fotoPrueba.jpg");
        $foto=base64_encode($foto);*/
        //$mail->AddEmbeddedImage('fotoPrueba.jpg', 'foto', 'inen_header.png');
        //$mail->MsgHTML("Imagen de prueba<br> <img src='cid:foto' alt='' width='600'/>");
        $mail->MsgHTML($mensaje);
        // adjuntos
        
        //$mail->addAttachment("adjunto.txt");
        
        // destinatario
        $address = $destinatario;
        $mail->AddAddress($address, "Destinatario");
        // enviar
        $resul = $mail->Send();
        if(!$resul) {
          echo "Error" . $mail->ErrorInfo;
        } else {
          echo "Enviado";
        }
    }
    
}