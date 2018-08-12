<?php
header('Content-Type: application/json');

$json = array();
if (!(empty($udalosti))) {
    $json["udalosti"] = $udalosti;
} else if (!(empty($pouzivatelia))) {
    $json["pouzivatelia"] = $pouzivatelia;
} else if (!(empty($priatelia))) {
    $json["priatelia"] = $priatelia;
} else if (!(empty($buduce_udalosti))) {
    $json["buduce_udalosti"] = $buduce_udalosti;
} else if (!(empty($podrobnosti))) {
    $json["udalosti"] = $podrobnosti;
} else if (!(empty($oznamenia))) {
    $json["oznamenia"] = $oznamenia;
    if (!(empty($ziadosti))) {
        $json["ziadosti"] = $ziadosti;
    }
} else if (!(empty($ziadosti))) {
    $json["ziadosti"] = $ziadosti;
} else {
    $json = array("udaje" => array());
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>