<?php
function buildJWTClient() {
    $payload = [
        "userToken" => "312e6170696e695f73616e64626f78",
        "clientToken" => "6170696e695f73616e64626f78",
        "time" => time(),
        "mode" => "normal" //or "god"
    ];
    return jwtEncode($payload, "1d86945f8efd8a90d3b3");
}


function jwtEncode($payload, $key){
    $header = ['typ' => 'JWT', 'alg' => 'HS256'];
    $segments = [];
    $segments[] = base64UrlEncode(json_encode($header));
    $segments[] = base64UrlEncode(json_encode($payload));
    $signing_input = implode('.', $segments);
    $signature = hash_hmac('SHA256', $signing_input, $key, true);
    $segments[] = base64UrlEncode($signature);
    return implode('.', $segments);
}

function base64UrlEncode($input) {
    return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
}

$curl = curl_init('https://ui.boondmanager.com/api');
curl_setopt($curl, CURLOPT_CAINFO, buildJWTClient());
$data = curl_exec($curl);
if ($data === false){
    var_dump(curl_error($curl));
} else {

}
curl_close($curl);