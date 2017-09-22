<?php
$id = $_POST['id'];
$authid = $_POST['auth_id'];
$itemid = $_POST['order_item_id'];
include 'token.prod.php';
$url = "returns/$id/acknowledge";
$json = "{
  \"alt_return_authorization_id\": \"$authid\",
  \"return_status\": \"acknowledged\",
  \"jet_pick_return_location\": false,
  \"return_location\": [
    {
      \"order_item_id\": \"$itemid\",
      \"location_name\": \"Sportsmans Supply Inc\",
      \"location_address_1\": \"2219 Hitzert Court\",
      \"location_address_2\": \"\",
      \"location_city\": \"Fenton\",
      \"location_state\": \"MO\",
      \"location_postal_code\": \"63026\"
    }
  ]
}";

echo "<br>";
echo $url;
echo "<br>";
echo $json;
echo "<br>";
$file = file_get_contents($file);
echo $file;
echo "<br>";

        $ch = curl_init($api_prefix . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');            
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json),
             //CHANGE THIS TO WHERE YOU SAVED YOUR TOKEN
            'Authorization: Bearer ' . $file  )                                                                       
        );       
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
        $data = curl_exec($ch);
        print_r($data);
        echo (curl_error ($ch ));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "<br>";
echo $httpcode;
echo "<br>";
        curl_close($ch);
        return json_decode($data);
 header("Refresh:2; url=orders_return_state.prod.php");
?>