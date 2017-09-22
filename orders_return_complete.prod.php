<?php
$id = $_POST['id'];
$ordid = $_POST['ord_id'];
$authid = $_POST['auth_id'];
$itemid = $_POST['order_item_id'];
$qty = $_POST['qty'];
$amt= $_POST['amt'];
$ship= $_POST['ship'];
include 'token.prod.php';
$file = file_get_contents($file);
$url = "returns/$id/complete";
$json = "{
  \"merchant_order_id\": \"$ordid\",
  \"items\": [
    {
      \"order_item_id\": \"$itemid\",
      \"total_quantity_returned\": $qty,
      \"order_return_refund_qty\": $qty,
      \"return_refund_feedback\": \"customer opened item\",
      \"refund_amount\": {
        \"principal\": $amt,
        \"tax\": 0.00,
        \"shipping_cost\": $ship,
        \"shipping_tax\": 0.00 
      }
    }
    ],
  \"agree_to_return_charge\": true
}";

echo "<br>";
echo $url;
echo "<br>";
echo $json;
echo "<br>";
echo $file;
echo "<br>";

        $ch = curl_init($api_prefix . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');            
        /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json),
             //CHANGE THIS TO WHERE YOU SAVED YOUR TOKEN
            'Authorization: Bearer ' . $file  )                                                                       
        ); 
        */
           curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $file ) );
                                    if($request){
                                        $request = json_encode($request);  
//echo $request;                                           
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                                        $api_call_data["request_data"] = (string)var_export($request, true);
                                    }      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
        $data = curl_exec($ch);
        print_r($data);
        echo (curl_error ($ch ));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "<br>";
echo $httpcode;
echo "<br>";
        curl_close($ch);
        return json_decode($data);
                header("Refresh:2; url=orders_return_state.prod.php");
?>