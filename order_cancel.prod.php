<?php
include 'token.prod.php';
$file = file_get_contents($file);

         $id = $_POST['id'];
         $alt_shipment_id = 'cancelled';
         $response_shipment_date = $_POST['response_shipment_date'];
         $expected_delivery_date = $_POST['expected_delivery_date'];
         $carrier_pick_up_date = $_POST['carrier_pick_up_date'];
         $merchant_sku = $_POST['merchant_sku'];
         $response_shipment_cancel_qty = $_POST['response_shipment_cancel_qty'];

  $request = array('shipments' => array(array('shipment_tracking_number'=> $shipment_tracking_number, 'alt_shipment_id' => $alt_shipment_id, 
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
                          header("Refresh:5; url=cancel_order.php");
?>