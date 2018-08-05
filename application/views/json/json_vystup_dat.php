<?php
header('Content-Type: application/json');

$json = array();
if (!(empty($udalosti))) {
    $json["udalosti"] = $udalosti;
} else {
    $json = array("udaje" => array());
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>