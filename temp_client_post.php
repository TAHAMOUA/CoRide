<?php
$data = json_encode([
    'email' => 'admin@techrecrut.test',
    'password' => 'password',
]);
$opts = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
        'content' => $data,
        'ignore_errors' => true,
    ],
];
$context = stream_context_create($opts);
$result = file_get_contents('http://localhost:8000/api/login', false, $context);
if ($result === false) {
    echo "REQUEST FAILED\n";
    var_dump($http_response_header);
    exit(1);
}
echo $http_response_header[0] . PHP_EOL;
echo $result . PHP_EOL;
