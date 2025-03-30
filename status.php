<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ip'], $data['city'], $data['region'], $data['version'], $data['org'], $data['userAgent'], $data['os'], $data['osVersion'])) {
    http_response_code(400);
    echo json_encode(["error" => "Bad Request"]);
    exit;
}

$webhook_url = "https://discord.com/api/webhooks/1353904494613631077/wiQKhN_1BPcP9LVdHz4uJDpQYpkHYh1-5Pym_NZo1qFTvqMIDjuJMtHQBi7gZUZwnyDU";

$payload = [
    "username" => "I love Internet Information Services 7",
    "avatar_url" => "https://ih1.redbubble.net/image.5547675143.6419/raf,360x360,075,t,fafafa:ca443f4786.jpg",
    "embeds" => [
        [
            "color" => 11730954,
            "author" => [
                "name" => "New Server Website Visitor",
                "url" => "http://server1.ilovetech0629.epizy.com"
            ],
            "title" => "Someone viewed the server ip",
            "url" => "http://server1.ilovetech0629.epizy.com:4556",
            "thumbnail" => [
                "url" => "https://ih1.redbubble.net/image.5547675143.6419/raf,360x360,075,t,fafafa:ca443f4786.jpg"
            ],
            "description" => "IP: " . htmlspecialchars($data['ip']),
            "fields" => [
                ["name" => "City", "value" => htmlspecialchars($data['city']), "inline" => true],
                ["name" => "Region", "value" => htmlspecialchars($data['region']), "inline" => true],
                ["name" => "Network Type", "value" => htmlspecialchars($data['version']), "inline" => true],
                ["name" => "Carrier", "value" => htmlspecialchars($data['org']), "inline" => true],
                ["name" => "User Agent", "value" => htmlspecialchars($data['userAgent']), "inline" => false],
                ["name" => "Operating System", "value" => htmlspecialchars($data['os']), "inline" => true],
                ["name" => "OS", "value" => htmlspecialchars($data["osVersion"]), "inline"=> true]
            ]
        ]
    ]
];

$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error_msg = curl_error($ch);
curl_close($ch);

if ($http_status == 200) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Failed to send data. HTTP Status: $http_status";
    if (!empty($error_msg)) {
         echo " | cURL Error: $error_msg";
    } else {
         echo "An error ourcurred getting blacklist info" . htmlspecialchars($response);
    }
}



