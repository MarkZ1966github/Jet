<?php
include 'token.prod.php';
$file = file_get_contents($file);
$filedate = gmdate("Y-m-d\TH-i-s\Z");
// loop through csv file

  function csv_to_array($filename='', $delimiter=',')
                                                            {
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}
/*-----FTP to server-----*/
$ftp_server ='www.rapidretail.net';
$ftp_user_name = 'ssi_gdw701';
$ftp_user_pass = 'Golf_701!';
$local_file = '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/TrackingJetGDSTL.csv';
$server_file = '/Shipping/jet/TrackingJetGDSTL.csv';
// set up basic connection
$conn_id = ftp_connect($ftp_server); 

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
 ftp_pasv($conn_id, true);
// check connection
if ((!$conn_id) || (!$login_result)) { 
    echo "FTP connection has failed!";
    echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
    exit; 
} else {
    echo "Connected to $ftp_server, for user $ftp_user_name";
}
echo "Current directory: " . ftp_pwd($conn_id) . "\n";
if (ftp_chdir($conn_id, "/Shipping/jet/")) {
    echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";
} else { 
    echo "Couldn't change directory\n";
}
// upload the file

$upload = ftp_get($conn_id, $local_file, $server_file, FTP_BINARY); 

// check upload status
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) { 
    echo "Successfully written to $local_file\n";
} else {
    echo "There was a problem\n";
}

// close the FTP stream 
ftp_close($conn_id); 

$csv = csv_to_array($filename='/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/TrackingJetGDSTL.csv', $delimiter=',');

$csvarray = array();

foreach ($csv as $value){
         $id = $value['order_id'];
         $shipment_tracking_number = $value['shipment_tracking_number'];
         $response_shipment_date = $value['response_shipment_date'];
         $response_shipment_method = $value['response_shipment_method'];
         $expected_delivery_date = $value['expected_delivery_date'];
         $carrier_pick_up_date = $value['carrier_pick_up_date'];
         $carrier = $value['carrier'];
         $merchant_sku = $value['merchant_sku'];
         $shipment_item_id = $value['shipment_item_id'];
         $response_shipment_sku_quantity = $value['response_shipment_sku_quantity'];
         $response_shipment_cancel_qty = $value['response_shipment_cancel_qty'];
         $RMA_number = $value['RMA_number'];
         $days_to_return = $value['days_to_return'];

for($i=0; $i<count($value['order_id']); $i++){ 

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

echo $expected_delivery_date;
echo "<br>";
echo "<br>";

//////// START NEW CODE 1/15/16 - To fix Jet Style ISO 8601 

$len = strlen(substr(strrchr($expected_delivery_date, "."), 1));
echo $len;
if ($len == 8){
$expected_delivery_date = $expected_delivery_date;
}
if ($len == 7){
$expected_delivery_date = str_replace('Z','0Z',$expected_delivery_date);
}
if ($len == 6){
$expected_delivery_date = str_replace('Z','00Z',$expected_delivery_date);
}
if ($len == 5){
$expected_delivery_date = str_replace('Z','000Z',$expected_delivery_date);
}
if ($len == 4){
$expected_delivery_date = str_replace('Z','0000Z',$expected_delivery_date);
}
echo "<br>";

//////// END NEW CODE 1/15/16 - To fix Jet Style ISO 8601 

echo $carrier_pick_up_date;
echo "<br>";

//////// START NEW CODE 1/15/16 - To fix Jet Style ISO 8601 

$len = strlen(substr(strrchr($carrier_pick_up_date, "."), 1));
echo $len;
if ($len == 8){
$carrier_pick_up_date = $carrier_pick_up_date;
}
if ($len == 7){
$carrier_pick_up_date = str_replace('Z','0Z',$carrier_pick_up_date);
}
if ($len == 6){
$carrier_pick_up_date = str_replace('Z','00Z',$carrier_pick_up_date);
}
if ($len == 5){
$carrier_pick_up_date = str_replace('Z','000Z',$carrier_pick_up_date);
}
if ($len == 4){
$carrier_pick_up_date = str_replace('Z','0000Z',$carrier_pick_up_date);
}
echo "<br>";

//////// END NEW CODE 1/15/16 - To fix Jet Style ISO 8601 
$random8 = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

  $request = array('shipments' => array(array('alt_shipment_id' => $random8, 'shipment_tracking_number'=> $shipment_tracking_number, 
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

    } 
}

// START delete the Tracking File 11/13/15

//copy off file to archives first
copy("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/TrackingJetGDSTL.csv", "/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/archives/tracking/TrackingJetGDSTL-$filedate.csv");
echo "file has been archived";
echo "<br>";

//now deleted the file
unlink('/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/TrackingJetGDSTL.csv'); 
echo "TrackingJetGDSTL has been removed.";
echo "<br>";

// END delete the Tracking File 11/13/15
     

?>