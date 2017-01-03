<?php
// Guardar los datos recibidos en variables:

$email = $_POST['email'];



if($email != '' ){

	// Definir el correo de destino:
	$dest = "humberto@2gom.com.mx";
	 
	// Estas son cabeceras que se usan para evitar que el correo llegue a SPAM:
	$headers = "From: Portal Charlenetas <$email>\r\n";  
	$headers .= "X-Mailer: PHP5\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Aqui definimos el asunto y armamos el cuerpo del mensaje
	$asunto = "Suscripcción a lista de Mailing";
	$cuerpo .= "El usuario ".$email." se ha registrado en JuanCorriente";



	// Agregar datos a CSV
	$lista =  array($email);

	
	$fp = fopen('registros/lista.csv', 'a');
	fputcsv($fp, $lista);
	fclose($fp);

    mail($dest,$asunto,$cuerpo,$headers); //ENVIAR!

}
else{ 
	echo "Error al momento de guardar tu correo";
}
?>