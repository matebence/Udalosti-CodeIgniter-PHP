<?php
header('Content-Type: application/json');

$json = array();
if ($this->session->flashdata('uspech') != null) {
    $json["uspech"] = $this->session->flashdata('uspech');
} else if ($this->session->flashdata('chyba') != null) {
    $json["chyba"] = $this->session->flashdata('chyba');
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>