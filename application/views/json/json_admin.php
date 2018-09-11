<?php
header('Content-Type: application/json');

$json = array();
if (isset($cennik) && !(empty($cennik))) {
    $json["cennik"] = $cennik;
}
if (isset($mesiac) && !(empty($mesiac))) {
    $json["mesiac"] = $mesiac;
}
if (isset($udalosti) && !(empty($udalosti))) {
    $json["udalosti"] = $udalosti;
}
if (isset($okres) && !(empty($okres))) {
    $json["okres"] = $okres;
}
if (isset($stat) && !(empty($stat))) {
    $json["stat"] = $stat;
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>