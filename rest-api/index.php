<?php
$set = file_put_contents("test.txt", json_encode($_GET));
echo json_encode([
    "statusCode" => 100
]);