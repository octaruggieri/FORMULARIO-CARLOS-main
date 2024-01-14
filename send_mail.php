<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

// Incluir el autoload de Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
	// Configuración del servidor SMTP
	$mail = new PHPMailer(true);
	$mail->SMTPDebug = 2;  // Puedes cambiar a 2 para obtener información de depuración detallada
	$mail->isSMTP();
	$mail->Host = 'smtp.titan.email';
	$mail->SMTPAuth = true;
	$mail->Username = 'system@1-xactimate.com';
	$mail->Password = 'F0rmul4r10_';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	// Destinatarios y contenido del correo
	$mail->setFrom('system@1-xactimate.com', 'No-Reply');
	$mail->addAddress('octavior128@gmail.com', 'Octavio');
	$mail->addAddress('nunezjuliot@gmail.com', 'Juliot');
	$mail->isHTML(true);
	$mail->Subject = 'Form Filled';
	$mail->Body = '
        Hello, attached to this email is a PDF file with the completed form results.
        Please do not reply to this email, as it was sent by an automated system and there will be no response.
        For questions and/or clarifications, please contact us at josemarcomg@gmail.com or octavior128@gmail.com
    ';

	// Recibir el archivo enviado
	if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
		$nombre_temporal = $_FILES["archivo"]["tmp_name"];
		$nombre_archivo = $_FILES["archivo"]["name"];

		// Mover el archivo al directorio deseado
		$ruta_del_servidor = __DIR__ . "/pdfs/";  // Usar __DIR__ para obtener la ruta del directorio actual
		$filename = $ruta_del_servidor . $nombre_archivo;
		move_uploaded_file($nombre_temporal, $filename);

		// Verificar que el archivo se ha movido correctamente
		if (file_exists($filename)) {
			// Adjuntar el archivo al correo
			$mail->addAttachment($filename, 'sample.pdf');

			// Enviar el correo
			$mail->send();
			echo json_encode(['status' => 'success', 'message' => 'Correo enviado correctamente.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo.1']);
		}
	} else {
		echo json_encode(['status' => 'error', 'message' => 'Error al recibir el archivo.2']);
	}
} catch (Exception $e) {
	echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo. ' . $mail->ErrorInfo]);
} catch (SMTPException $e) {
	echo json_encode(['status' => 'error', 'message' => 'Error SMTP: ' . $e->getMessage()]);
}
