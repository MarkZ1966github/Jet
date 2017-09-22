<?php
include 'token.prod.php';
$file = file_get_contents($file);
$filedate = gmdate("Y-m-d\TH-i-s\Z");
         $id = $_POST['id'];
         $response_shipment_date = $_POST['response_shipment_date'];
         $carrier = $_POST['carrier'];
         $response_shipment_method = $_POST['response_shipment_method'];
         $shipment_tracking_number = $_POST['shipment_tracking_number'];
         $shipment_item_id = $_POST['shipment_item_id'];
         $merchant_sku = $_POST['merchant_sku'];
         $response_shipment_sku_quantity = $_POST['response_shipment_sku_quantity'];
         $carrier_pick_up_date = $_POST['carrier_pick_up_date'];
         $expected_delivery_date = $_POST['expected_delivery_date'];

////// START Fix Time to ISO 8601 Jet Style 11/13/15
echo "<br>";
// removed the below on 11/16/15 as they sent the proper 7 microseconds
// $response_shipment_date = str_replace('Z','00Z',$response_shipment_date);

//////// START NEW CODE 11/30/15 - To fix Jet Style ISO 8601 

$len = strlen(substr(strrchr($response_shipment_date, "."), 1));
echo $len;
if ($len == 8){
$response_shipment_date = $response_shipment_date;
}
if ($len == 7){
$response_shipment_date = str_replace('Z','0Z',$response_shipment_date);
}
if ($len == 6){
$response_shipment_date = str_replace('Z','00Z',$response_shipment_date);
}
if ($len == 5){
$response_shipment_date = str_replace('Z','000Z',$response_shipment_date);
}
if ($len == 4){
$response_shipment_date = str_replace('Z','0000Z',$response_shipment_date);
}
echo "<br>";

//////// END NEW CODE 11/30/15 - To fix Jet Style ISO 8601 

echo $response_shipment_date;
echo "<br>";
echo "<br>";
//removed this on 7/12/16 as the 4 zero's are no longer taking
//$expected_delivery_date = str_replace('Z','0000Z',$expected_delivery_date);
echo $expected_delivery_date;
echo "<br>";
//removed this on 7/12/16 as the 4 zero's are no longer taking
//$carrier_pick_up_date = str_replace('Z','0000Z',$carrier_pick_up_date);
echo $carrier_pick_up_date;
echo "<br>";
////// END Fix Time to ISO 8601 Jet Style 11/13/15

  $request = array('shipments' => array(array('shipment_tracking_number'=> $shipment_tracking_number, 
    'response_shipment_date'=> $response_shipment_date, 
    'response_shipment_method'=> $response_shipment_method,
    'expected_delivery_date'=> $expected_delivery_date,
    'ship_from_zip_code'=> "63026",
    'carrier_pick_up_date'=> $carrier_pick_up_date,
    'carrier'=> $carrier,"shipment_items" => array(array('shipment_item_id'=> $shipment_item_id,'merchant_sku'=> $merchant_sku,'response_shipment_sku_quantity'=> intval($response_shipment_sku_quantity),'response_shipment_cancel_qty' => intval($response_shipment_cancel_qty),'RMA_number'=> $RMA_number,'days_to_return'=>intval($days_to_return), 'return_location' => array('address1'=>"2219 Hitzert Court",'city'=>"Fenton",'state'=> "MO",'zip_code'=>"63026"),'shipment_item_id'=>$shipment_item_id,'merchant_sku'=>$merchant_sku,'response_shipment_sku_quantity'=>intval($response_shipment_sku_quantity),'response_shipment_cancel_qty'=>intval($response_shipment_cancel_qty))))));

$json = json_encode($request);
echo "<br>";
echo $json;
echo "<br>";

        $url = "orders/$id/shipped";
        echo $url;
        echo "<br>";

        $ch = curl_init($api_prefix . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json),
            'Authorization: Bearer ' . $file  )                                                                       
        );       
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
                          header("Refresh:5; url=ship_order.php");
?>