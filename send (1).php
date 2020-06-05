<?php
function send_email($from, $to, $subject, $message_html, $message_txt = '')
{

    $email = $to;

    //create a boundary for the email. This 
    $boundary = uniqid('np');

    //headers - specify your from email address and name here
    //and specify the boundary for the email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: $from \r\n";
    $headers .= "To: $email\r\n";
    //'Reply-To: ' . $from,
    //'Return-Path: ' . $from,
    $headers .= 'Date: ' . date('r', $_SERVER['REQUEST_TIME']) . "\r\n";
    $headers .= 'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME'] . $subject) . '@' . $_SERVER['SERVER_NAME'] . '>' . "\r\n";
    $headers .= 'X-Mailer: PHP v' . phpversion() . "\r\n";
    $headers .= 'X-Originating-IP: ' . $_SERVER['SERVER_ADDR'] . "\r\n";

    $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

    //here is the content body
    $message = "This is a MIME encoded message.";

    //Plain text body
    $message .= "\r\n\r\n--" . $boundary . "\r\n";
    $message .= "Content-type: text/plain;charset=iso-8859-1\r\n\r\n";


    if ($message_txt == '') {
        $message_txt = nl2br($message_html);
        $message_txt = strip_tags($message_txt);
    }
    $message .= $message_txt;
    //Html body
    $message .= "\r\n\r\n--" . $boundary . "\r\n";
    $message .= "Content-type: text/html;charset=uiso-8859-1\r\n\r\n";
    $message .= $message_html;

    $message .= "\r\n\r\n--" . $boundary . "--";

    //invoke the PHP mail function
    mail('', $subject, $message, $headers);
}

if ( ! isset($_POST['email']) ) {
	exit;
}

// Construimos el mensaje
$to = 'informes@qoppaperu.com';
$reply1 = 'no-responder@qoppaperu.com';
$reply2 = 'contactanos@qoppaperu.com';
$user_email = $_POST['email'];
$subject1 = 'Mensaje automático:Confirmación ';
$subject2 = 'Mensaje automático:Base de datos ';

$message1 = '<div> <h3>Nos estaremos comunicando con usted pronto.</h3><table> <tr><td>Nombre</td><td>' . $_POST['name'] . '</td></tr><tr><td>Celular</td><td>' . $_POST['phone'] . '</td></tr><tr><td>Email</td><td>' . $_POST['email'] . '</td></tr><tr><td>Mensaje</td><td>' . $_POST['message'] . '</td></tr></table></div>';
$message2 = '<div> <h3>Hay una persona que quiere comunicarse con "qoppaperu.com".</h3><table> <tr><td>Nombre</td><td>' . $_POST['name'] . '</td></tr><tr><td>Celular</td><td>' . $_POST['phone'] . '</td></tr><tr><td>Email</td><td>' . $_POST['email'] . '</td></tr><tr><td>Mensaje</td><td>' . $_POST['message'] . '</td></tr></table></div>';


echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje de confirmación</title>
</head>
<body style="background: #a0ce4e">
   <div style="position: center;
   background: white;
   border: 1px solid #398b87;
   padding: 50px;">  
   <img style="display:block;
   margin:auto; width: 80%; height : 40%" src="images/logo-qoppa.png" alt="">
	<p style="text-align:center;font-size:20px">Revisaremos su solicitud y le estaremos respondiendo a la mayor brevedad posible.</p>
    <a href="index.html" style="font-size:20px">Regresar a página principal</a>
	</div>
</body>
</html>';


send_email($reply1, $user_email, $subject1, $message1);
send_email($reply2, $to, $subject2, $message2);

?>
