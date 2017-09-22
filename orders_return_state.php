<?php
include 'token.php';
$file = file_get_contents($file);
$filedate = gmdate("Y-m-d\TH-i-s\Z");
        echo "======================== START of Return =================================="; 
        echo "<br>";
                echo "<br>";
//echo "-- begin handle --";
//echo "<br>";

        if (($handle = fopen("/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/test/return/jetreturn.csv", "r")) !== FALSE){ 
//echo "-- start while loop --";
//echo "<br>";       
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $num = count($data);
//echo $num;
//echo "<br>"; 
//echo "-- begin shipment for c loop --";
//echo "<br>"; 
                        $urlarray = array();
                        $idarray = array();
                        for ($c=0; $c < $num; $c++) {


                            $data[$c] = str_replace("returns/state/","",$data[$c]);
                            $id = $data[$c];
                            $idarray[] = $id;
                            $url = "returns/state/$id";
                            $urlarray[] = $url;


//echo "<br>";
            }
//echo "-- end of c loop --";
//echo "<br>";
//echo "<br>";
//print_r($urlarray);
//echo "<br>";                            
                        foreach ($urlarray as $value){
//echo "-- begin urlarray foreach loop --";
//echo "<br>";
//echo $value;
//echo "<br>";

                        $api_call_data = array();
                            $request = null;
//echo $file;
//echo "<br>";
                            $ch = curl_init($api_prefix . $value);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $file ) );
                                    if($request){
                                        $request = json_encode($request);  
//echo $request;                                           
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                                        $api_call_data["request_data"] = (string)var_export($request, true);
                                    }
                            $data = utf8_encode (curl_exec($ch));
                            $obj = json_decode($data, TRUE);
                //print_r($obj);
               //$arr = json_encode($obj);
             //print_r($arr);
             //var_dump($obj);
            // ksort($obj);
             print_r($obj);
echo "<br><br>";

        echo "======================== END of Return ==================================";   
 echo "<br>";          
                        }
                         
                    }
                }
                        
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Jet Returns</title>
         <script type='text/javascript' src='http://code.jquery.com/jquery-1.4.4.min.js'></script>
        <style>
        body {
            background: #fff;
        }
#boxsize {
  font-size: 100%;
  outline: none;
  width: 300px;
  height: 30px;
  display: table-cell; 
  vertical-align: middle;
  border: 1px solid #ccc;
}
#button {
    width: 125px;
    height: 30px;
}
table.upctable tr, td {
border: 1px solid #ccc;
}
a:hover {
background-color: #F2DE41;
color: #fff;
text-decoration: none;
font-size: 150%;
}
a:link {
text-decoration: none;
font-size: 150%;
}
        </style>
    </head>
        <body>
        <a href = "http://jetpartner.sportsmanssupplyinc.com/"><img src = "/product/images/ssilogo.jpg"></a>

<u><h2>Acknowledge Returns</h2></u><br>
<form action="orders_return_acknowledge.php" method="post">
<strong>Merch Auth ID: </strong><input type="text" id="boxsize" placeholder = "merchant_return_authorization_id" name="id">  <br>
<strong>Return Authorization ID: </strong><input type="text" id="boxsize" placeholder = "reference_return_authorization_id" name="auth_id">  <br>
<strong>Order Item ID: </strong><input type="text" id="boxsize" placeholder = "order_item_id" name="order_item_id">  <br>
  
<input type="submit" id="button" value="Ack Returns"></font> 

    <br><br>
</form>

<u><h2>Complete Returns</h2></u><br>
<form action="orders_return_complete.php" method="post">
<strong>Merch Auth ID: </strong><input type="text" id="boxsize" placeholder = "merchant_return_authorization_id" name="id">  <br>
<strong>Merch Order ID: </strong><input type="text" id="boxsize" placeholder = "merchant_order_id" name="ord_id">  <br>
<strong>Order Item ID: </strong><input type="text" id="boxsize" placeholder = "order_item_id" name="order_item_id">  <br>
<strong>Return Qty: </strong><input type="text" id="boxsize" placeholder = "return_quantity" name="qty">  <br> 
<strong>Amount: </strong><input type="text" id="boxsize" placeholder = "principal" name="amt">  <br>  
<strong>Shipping: </strong><input type="text" id="boxsize" placeholder = "shipping_cost" name="ship">  <br> 
<input type="submit" id="button" value="Complete Returns"></font> 

    <br><br>
</form>
<div align = "right">
          <a href = "mailto:mzschiegner@ssisports.net?subject=Jet Order Return Feedback">Feedback?</a>
        </div>

    </body>
</html>