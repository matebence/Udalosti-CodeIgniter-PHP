<?php
header('Content-Type: application/json');

$json = array();
if (isset($cennik) && !(empty($cennik))) {
    $json["cennik"] = $cennik;
}
if (isset($mesiac) && !(empty($mesiac))) {
    $json["mesiac"] = $mesiac;
}
if (isset($okres) && !(empty($okres))) {
    $json["okres"] = $okres;
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>