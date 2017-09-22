<?php
include 'token.prod.php';
$file = file_get_contents($file);


/*-----FTP to server-----*/

$ftp_server ='www.rapidretail.net';
$ftp_user_name = 'ssi_gdw701';
$ftp_user_pass = 'Golf_701!';
$local_file = '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/*';
$remote_file = '/Shipping/jet/*';
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
echo "Current directory: " . ftp_pwd($conn_id) . "<br>";
if (ftp_chdir($conn_id, "/Shipping/jet/")) {
    echo "Current directory is now: " . ftp_pwd($conn_id) . "<br>";
} else { 
    echo "Couldn't change directory\n";
}

$contents = ftp_nlist($conn_id, ".");

        foreach ($contents as $value) 
    
                {   $id = $value;
                        echo "<br>";
                        echo $id;
                        echo "<br>";
                        
                        $local_file = '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/'.$id;
                        $remote_file = '/Shipping/jet/'.$id;
                        
                        $result = ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY);
                        
                            $json = file_get_contents($local_file);
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

                            echo "<br>";
                            
                                
    }

    
// close the FTP stream 
ftp_close($conn_id); 

    /*-----START -- Connect to delete files on FTP to server-----*/

$ftp_server ='www.rapidretail.net';
$ftp_user_name2 = 'ssi_RapidRetailAdmin';
$ftp_user_pass2 = 'Rapid_rra!';
$local_file = '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/*';
$remote_file = '/Shipping/jet/*';
// set up basic connection
$conn_id2 = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id2, $ftp_user_name2, $ftp_user_pass2);
ftp_pasv($conn_id2, true);
// check connection
if ((!$conn_id2) || (!$login_result)) {
    echo "FTP connection has failed!";
    echo "Attempted to connect to $ftp_server for user $ftp_user_name2";
    exit;
} else {
    echo "Connected to $ftp_server, for user $ftp_user_name2";
}
echo "Current directory: " . ftp_pwd($conn_id2) . "<br>";
if (ftp_chdir($conn_id2, "/LocalUser/ssi_gdw701/Shipping/jet/")) {
    echo "Current directory is now: " . ftp_pwd($conn_id2) . "<br>";
} else {
    echo "Couldn't change directory\n";
}
$contents = ftp_nlist($conn_id2, ".");

    foreach ($contents as $value)

        {   $id = $value;
                echo "<br>";
                echo $id;
                echo "<br>";

                if (ftp_delete($conn_id2, $id)) {
                    echo "$id deleted successful\n";
                        } else {
                        echo "could not delete $id\n";
                }
    }
    
    /*-----END -- Connect to delete files on FTP to server-----*/

?>