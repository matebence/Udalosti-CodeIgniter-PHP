<?php

class Firebase
{

    public function posli_jednemu($komu, $sprava)
    {
        $udaje = array(
            'to' => $komu,
            'data' => $sprava,
        );
        return $this->posli_spravu($udaje);
    }

    public function posli_kazdemu($komu, $sprava)
    {
        $udaje = array(
            'to' => '/topics/' . $komu,
            'data' => $sprava,
        );
        return $this->posli_spravu($udaje);
    }

    public function posli_skupine($id_telefonu, $sprava)
    {
        $udaje = array(
            'to' => $id_telefonu,
            'data' => $sprava,
        );

        return $this->posli_spravu($udaje);
    }

    private function posli_spravu($udaje)
    {
        $adresa = 'https://fcm.googleapis.com/fcm/send';

        $hlavicka = array(
            'Authorization: key=' . FIREBASE_API_KLUC,
            'Content-Type: application/json'
        );
        $kanal = curl_init();

        curl_setopt($kanal, CURLOPT_URL, $adresa);

        curl_setopt($kanal, CURLOPT_POST, true);
        curl_setopt($kanal, CURLOPT_HTTPHEADER, $hlavicka);
        curl_setopt($kanal, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($kanal, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($kanal, CURLOPT_POSTFIELDS, json_encode($udaje));

        $odpoved = curl_exec($kanal);
        if ($odpoved === FALSE) {
            die('Curl failed: ' . curl_error($kanal));
        }

        curl_close($kanal);
        return $odpoved;
    }
}
?>