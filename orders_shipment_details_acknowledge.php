<?php
include 'token.php';
$file = file_get_contents($file);
$filedate = gmdate("Y-m-d\TH-i-s\Z");
echo "-- begin handle --";
echo "<br>";

        if (($handle = fopen("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/ready/jetorders.csv", "r")) !== FALSE){ 
echo "-- start while loop --";
echo "<br>";       
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $num = count($data);
echo $num;
echo "<br>"; 
echo "-- begin shipment for c loop --";
echo "<br>"; 
                        $urlarray = array();
                        $idarray = array();
                        for ($c=0; $c < $num; $c++) {


                            $data[$c] = str_replace("/orders/withoutShipmentDetail/","",$data[$c]);
                            $id = $data[$c];
                            $idarray[] = $id;
                            $url = "orders/withoutShipmentDetail/$id";
                            $urlarray[] = $url;


echo "<br>";
            }
echo "-- end of c loop --";
echo "<br>";
echo "<br>";
print_r($urlarray);
echo "<br>";                            
                        foreach ($urlarray as $value){
echo "-- begin urlarray foreach loop --";
echo "<br>";
echo $value;
echo "<br>";



                        $api_call_data = array();
                            $request = null;
echo $file;
echo "<br>";
                            $ch = curl_init($api_prefix . $value);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $file ) );
                                    if($request){
                                        $request = json_encode($request);  
echo $request;                                           
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                                        $api_call_data["request_data"] = (string)var_export($request, true);
                                    }
                            $data = utf8_encode (curl_exec($ch));
                            $obj = json_decode($data, TRUE);

                                            for($i=0; $i<count($obj['order_items']); $i++) {
                                                    $order_item_id = $obj['order_items'][$i]['order_item_id'];
                                                    $merchid = $obj['merchant_order_id'];
echo $order_item_id;
echo "<br>";
echo $merchid;
echo "<br>";
                                                $orderinfo = array(order_item_acknowledgement_status => "fulfillable", order_item_id  => $order_item_id );
                                                $orderinfo = json_encode($orderinfo);
                                                $orderinfo = "[$orderinfo]";
echo $orderinfo;
 
                                                $json = "{\"acknowledgement_status\":\"accepted\", \"order_items\":$orderinfo}";
                                                json_encode($json);
echo "<br>";


                                                $url2 = "/acknowledge";
                                                    //      foreach ($idarray as $id){
                                                $ch = curl_init($api_prefix . 'orders/'. $merchid . $url2);

                                                    //          }


                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                                                'Content-Type: application/json',                                                                                
                                                'Content-Length: ' . strlen($json),
                                                'Authorization: Bearer ' . $file  )                                                                       
                                                        );       
                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                                curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
                                                $data = curl_exec($ch);
                                                echo (curl_error ($ch ));
                                                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo $httpcode;                    

echo "<br>";
echo "-- writing files --";
echo "<br>";

echo "-- create order file --";
echo "<br>";
$fp = fopen('jet-order-'.$merchid.'-'.$filedate.'.json', 'a+');
fwrite($fp, json_encode($obj));

    fclose($fp);
echo "-- drop order file --";
echo "<br>";
    $log = fopen("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/log/jet-orders.log", "a+");
    $timestamp = date('l jS \of F Y h:i:s A');
    $fileis = "jet-order-".$merchid."-".$filedate.".json";
    $result = $timestamp . ' ' . $fileis;
    fwrite($log, $result . PHP_EOL);
    foreach ($data as $line)
        {
            fwrite($log,explode(',',$line . PHP_EOL));
        }
    fclose($log);

echo "wrote log entry - $timestamp $fileis";
/*-----FTP to server-----*/
$ftp_server ='www.rapidretail.net';
$ftp_user_name = 'ssi_gdw701';
$ftp_user_pass = 'Golf_701!';
$destination_file = 'jet-order-'.$merchid.'-'.$filedate.'.json';
$source_file = 'jet-order-'.$merchid.'-'.$filedate.'.json';
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
if (ftp_chdir($conn_id, "/Orders/jet/")) {
    echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";
} else { 
    echo "Couldn't change directory\n";
}
// upload the file

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_ASCII); 

// check upload status
if (!$upload) { 
    echo "FTP upload has failed!";
} else {
    echo "Uploaded $source_file to $ftp_server as $destination_file";
}

// close the FTP stream 
ftp_close($conn_id); 

copy("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/jet-order-$merchid-$filedate.json", "/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/archives/orders/jet-order-$merchid-$filedate.json");

unlink("jet-order-$merchid-$filedate.json");

echo "-- create ack file --";
echo "<br>";

$fp = fopen('jet-ack-'.$merchid.'-'.$filedate.'.json', 'a+');
fwrite($fp, json_encode($orderinfo));
   //added 11/4/15
 $log = fopen("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/log/jet-ack.log", "a+");
    $timestamp = date('l jS \of F Y h:i:s A');
    $fileis = "jet-ack-".$merchid."-".$filedate.".json";
    $result = $timestamp . ' ' . $fileis;
    fwrite($log, $result . PHP_EOL);
    foreach ($data as $line)
        {
            fwrite($log,explode(',',$line . PHP_EOL));
        }
    fclose($log);

echo "wrote log entry - $timestamp $fileis";

copy("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/jet-ack-$merchid-$filedate.json", "/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/archives/ack/jet-ack-$merchid-$filedate.json");

unlink("jet-ack-$merchid-$filedate.json"); 

                            curl_close($ch);
echo "-- curl close i loop --";
echo "<br>";    

                                        }
echo "-- end of for i loop --";
echo "<br>";

print_r($obj);



                            curl_close($ch);
echo "-- curl close urlarray loop --";
echo "<br>";

            }
echo "-- end urlarray foreach loop --";
echo "<br>";


        }
echo "--- end of while loop ---";
echo "<br>";
 }
echo "-- outside of handle --";
echo "<br>";

echo "<br>";

?>