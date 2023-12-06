<?php
// Configura el token de acceso de tu bot
$token = '5963088482:AAH4TlK5_7thdlrF0WDvNHz5fA_7ArXYRy0';

// Configura el chat ID del grupo al que deseas enviar mensajes
$chatId = '@colfacbot';

// Configura el mensaje que deseas enviar
$message = urlencode('Hola desde php!!!');

// Construye la URL de la API de Telegram para enviar el mensaje
$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=$message";

// Envía una solicitud GET a la URL utilizando cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Imprime la respuesta de la API de Telegram para verificar que el mensaje fue enviado correctamente
var_dump($response);
?>