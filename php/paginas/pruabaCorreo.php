<?php   
    use PHPMailer\PHPMailer\PHPMailer;
    require "vendor/autoload.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    // cambiar a 0 para no ver mensajes de error
    $mail->SMTPDebug  = 2;                          
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";                 
    $mail->Host       = "smtp.gmail.com";    
    $mail->Port       = 587;                 
    // introducir usuario de google
    $mail->Username   = "2alejandroibanezhurtado@gmail.com"; 
    // introducir clave
    $mail->Password   = "leire123";       
    $mail->SetFrom('2alejandroibanezhurtado@gmail.com', 'Test');
    // asunto
    $mail->Subject    = "Asunto correo php";
    // cuerpo
    /*$foto = file_get_contents("fotoPrueba.jpg");
    $foto=base64_encode($foto);*/
    $mail->AddEmbeddedImage('fotoPrueba.jpg', 'foto', 'inen_header.png');
    $mail->MsgHTML("Imagen de prueba<br> <img src='cid:foto' alt='' width='600'/>");
    // adjuntos
    $mail->addAttachment("adjunto.txt");
    // destinatario
    //$address = "jve@ieslasfuentezuelas.com";
    $address = "alejandroibanezhurtado@gmail.com";
    $mail->AddAddress($address, "Test");
    // enviar
    $resul = $mail->Send();
    if(!$resul) {
      echo "Error" . $mail->ErrorInfo;
    } else {
      echo "Enviado";
    }