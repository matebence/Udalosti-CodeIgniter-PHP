<?php
header('Content-Type: application/json');

$json = array();
if (!empty(validation_errors_array())) {
    $json["chyba"] = true;
    $json["validacia"] = validation_errors_array();
} else if ($this->session->flashdata('chyba') != null) {
    $json["chyba"] = true;
    $json["validacia"] = array("oznam" => $this->session->flashdata('chyba'));
} else if ($this->session->flashdata('uspech') != null) {
    $json["chyba"] = false;
    $json["validacia"] = array("oznam" => $this->session->flashdata('uspech'));
} else if ($this->session->flashdata('autentifikacia') != null) {
    $json["chyba"] = false;
}

if (!(empty($json))) {
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
}
?>