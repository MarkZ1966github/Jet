<?php
include 'token.prod.php';
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
$csv = csv_to_array($filename='/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/product/JetGDSTL.csv', $delimiter=',');
$cnt=0;

foreach ($csv as $value)
        { 
         $product_title = $value['display_name'];
         $jetnode = $value['jetnode'];
         $msrp = $value['msrp'];
         $upc = $value['upc'];
         $brand = $value['manufacturer'];
         $manufacturer = $value['manufacturer'];
         $sku = $value['sku'];
         $product_description = $value['description'];
         $att1 = $value['att1'];
         $att2 = $value['att2'];
         $att3 = $value['att3'];
         $att4 = $value['att4'];
         $att5 = $value['att5'];
         $weight = $value['weight'];
         $dlength = $value['dlength'];
         $dwidth = $value['dwidth'];
         $dheight = $value['dheight'];
         $country = $value['country'];
         $image_url = $value['image_url'];

$request = array('product_title'=> $product_title,
    'jet_browse_node_id'=> intval($jetnode), 
    'standard_product_codes' => array(array( 'standard_product_code'=> $upc,
            'standard_product_code_type'=> UPC)),
    'multipack_quantity'=> 1,
    'brand'=> $brand,
    'manufacturer'=> $manufacturer,
    'mfr_part_number'=> $sku,
    'product_description'=> $product_description,
    'bullets' => array($att1,$att2,$att3,$att4,$att5),
    'number_units_for_price_per_unit'=> 1,
    'type_of_unit_for_price_per_unit'=> each,
    'shipping_weight_pounds'=> floatval($weight),
    'package_length_inches'=> floatval($dlength),
    'package_width_inches'=> floatval($dwidth),
    'package_height_inches'=> floatval($dheight),
    'prop_65'=> TRUE,
    'country_of_origin'=> $country,
    'start_selling_date'=> '2015-10-27T01:43:30.0000000-07:00',
    'fulfillment_time'=> 2,
    'msrp'=> floatval($msrp),
    'no_return_fee_adjustment'=> floatval(0.01),
    'exclude_from_fee_adjustments'=> FALSE,
    'ships_alone'=> FALSE,
    'main_image_url' => $image_url
);

$json = json_encode($request);

var_dump($json);
echo "<br>";

        $ch = curl_init($api_prefix . 'merchant-skus/'. $sku);
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
echo "<br>";

$cnt++;

    }
?>