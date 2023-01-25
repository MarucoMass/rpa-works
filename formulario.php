<?php
/**
 * @version 1.0
 */

require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];

    $errors = array();
    
    $ip = $_SERVER['REMOTE-ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $secretkey = "recaptcha secretkey";
    
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretkey}&response={$captcha}&remoteip={$ip}");
    $atribute = json_decode($response, TRUE);


    if($atribute['success']){

        $msj = "De: $nombre <a href='mailto:$email'>$email</a><br>";
        $msj .= "Cuerpo del mensaje:";
        $msj .= '<p>Teléfono:' . $phone . '</p>';
        $msj .= '<p>Compañía:' . $company . '</p>';
        $msj .= "--<p>Este mensaje se ha enviado desde un formulario de contacto de RPA Works</p>";
    
        
        // Datos de la cuenta de correo utilizada para enviar vía SMTP
        $smtpHost = "Host";  // Dominio alternativo brindado en el email de alta 
        $smtpUsuario = "User";  // Mi cuenta de correo
        $smtpClave = "Key";  // Mi contraseña
        
        // Email donde se enviaran los datos cargados en el formulario de contacto
        $emailDestino = "Mail de destino";
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 465; 
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true); 
        $mail->CharSet = "utf-8";
        
        
        // VALORES A MODIFICAR //
        $mail->Host = $smtpHost; 
        $mail->Username = $smtpUsuario; 
        $mail->Password = $smtpClave;
        
        $mail->From = $email; // Email desde donde envío el correo.
        $mail->FromName = $name;
        $mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario
        
        $mail->Subject = "Formulario de contacto de sitio web"; // Este es el titulo del email.
        $mail->Body = $msj; // Texto del email en formato HTML
        $mail->AltBody = $msj; // Texto sin formato HTML
        // FIN - VALORES A MODIFICAR //
        
        $estadoEnvio = $mail->Send(); 
        if($estadoEnvio){
            header('Location: gracias.html');
        } else {
            header('Location: error.html');
        }
        
    } else {
        echo "<script>
            alert('Debes completar el capctha');
            window.location= 'https://www.rpa-works.com'
        </script>";
    }


?>
