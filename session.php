<?
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://situ.cybers-s.net/mikrotik/session/JOi6y8JTfF6fsWNmmdOoUjr3rgSAKiG94LtolQzWjbZ.oE8Y0dM98%60DNw3RisTlmwJmarOMi9eR4MhX6ra8tWw__'
));
$resp = curl_exec($curl);
// Close request to clear up some resources
echo $resp;
curl_close($curl);
?>