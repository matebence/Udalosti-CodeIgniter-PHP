<?php
header('Content-Type: application/json');

$json = array();
if (isset($cennik) && !(empty($cennik))) {
    $json["cennik"] = $cennik;
}
if (isset($zoznam_cien) && !(empty($zoznam_cien))) {
    $json["zoznam_cien"] = $zoznam_cien;
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
if (isset($aktualne_udaje_udalosti) && !(empty($aktualne_udaje_udalosti))) {
    $json["udaje_udalosti"] = $aktualne_udaje_udalosti;
}
if (isset($aktualny_pouzivatel) && !(empty($aktualny_pouzivatel))) {
    $json["udaje_pouzivatela"] = $aktualny_pouzivatel;
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>