<?php
include 'token.prod.php';
set_time_limit(0);
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
        while (($row = fgetcsv($handle, $delimiter)) !== FALSE)
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
$ftp_server ='your ftp server';
$ftp_user_name = 'your ftp user name';
$ftp_user_pass = 'your ftp password';
$local_file = 'path to your local file';
$server_file = 'path to your server file';
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
if (ftp_chdir($conn_id, "/Inventory/jet/")) {
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
$csv = csv_to_array($filename='server file path', $delimiter=',');
$cnt=0;

foreach ($csv as $value)
        { 
         $sku = $value['sku'];
         $qty = $value['quantity'];
$request = array(
    'fulfillment_nodes' => array(array('fulfillment_node_id' => "83a0e69cc2974c8684e20b47b2ce2417", 'quantity' => intval($qty)))
);

$json = json_encode($request);

$url = '/inventory';
$jeturl = ($api_prefix . 'merchant-skus/'. $sku . $url );

        $ch = curl_init($jeturl);
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        $data = curl_exec($ch);
        
        echo (curl_error ($ch ));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "<br>";

        curl_close($ch);
echo "<br>";
//print_r($data);
//echo " - ";
echo $sku;
echo " - ";
echo $qty;
echo " - ";
echo $httpcode;
echo " - ";
echo $jeturl;
echo " - ";
var_dump($json);
$cnt++;

    }
// START delete the Inventory File 11/13/15

//copy off file to archives first
copy("path to file", "path to archive");
echo "file has been archived";
echo "<br>";

//now deleted the file
unlink('path to file'); 
echo "inventory file has been removed.";
echo "<br>";

// END delete the Inventory File 11/13/15

?>