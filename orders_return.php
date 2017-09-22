<?php
$filedate = gmdate("Y-m-d\TH-i-s\Z");
include 'token.php';
$url = "returns/created";
$api_call_data = array();
$request = null;
//$request = array('order_urls' => '[]'  ); 
$file = file_get_contents($file);
echo "<br>";
        $ch = curl_init($api_prefix . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $file ) );
        //If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
        if($request){
            $request = json_encode($request);  
            echo $request;                                           
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            $api_call_data["request_data"] = (string)var_export($request, true);
        }
        $data = utf8_encode (curl_exec($ch));

        $obj = json_decode($data);
        echo "<br>";

foreach ($obj as $element){
if(count($element) == 0){ echo "No new return orders";
fopen('/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/return/jetreturn.csv', 'w');
header("Refresh:2; url=returns.php");
        }else{
        echo "Creating Returns File.... ";
        header("Refresh:2; url=returns2.php");
copy("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/return/jetreturn.csv", "/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/archives/return/jetreturn-$filedate.csv");
unlink("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/return/jetreturn.csv"); 
      $fp = fopen('/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/return/jetreturn.csv', 'w');
        foreach ($obj as $fields) {
                fputcsv($fp, $fields);
            }
    fclose($fp);  
    }
}

        echo (curl_error ($ch ));
  
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "<br>";
//echo $httpcode;
echo "<br>";
        curl_close($ch);
        return json_decode($data)
?>