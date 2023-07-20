<?php

// Читаем данные из файла data.json
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Проверяем, существуют ли необходимые данные
if (isset($data['value']) && isset($data['apsa']) && isset($data['do'])) {
    $ipAddress = $_SERVER['REMOTE_ADDR']; // Получаем IP-адрес пользователя
    $url = 'https://ipinfo.io/' . $ipAddress . '/country/';
    $curlHandle = curl_init($url);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curlHandle);

    if ($response !== false) {
        $country = trim($response);
        $data['allowed'] = ($country === "RU");
        $data['country_code'] = $country;
    }

    header('Content-Type: application/json');
    echo json_encode($data); // Возвращаем данные в формате JSON

} else {
    echo json_encode(null);
}
