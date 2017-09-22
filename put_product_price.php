<?php
include 'token.php';
$file = file_get_contents($file);
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
$csv = csv_to_array($filename='/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/product/Pricing-JetGDSTL.csv', $delimiter=',');
$cnt=0;

foreach ($csv as $value)
        { 
         $sku = $value['sku'];
         $price = $value['price'];
$request = array(
    'price'=> floatval($price)
);

$json = json_encode($request);

//var_dump($json);
echo "<br>";
$url = '/price';
		$ch = curl_init($api_prefix . 'merchant-skus/'. $sku . $url );
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
		
		echo (curl_error ($ch ));
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		echo $httpcode;
		curl_close($ch);
echo "<br>";
print_r($data);
echo " - ";
echo $sku;
echo " - ";
echo $price;
$cnt++;

    }
?>