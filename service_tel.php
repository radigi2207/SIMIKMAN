<?php


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://situ.cybers-s.net/telegram/service'
));
$resp = curl_exec($curl);
// Close request to clear up some resources
echo $resp;
curl_close($curl);
?>