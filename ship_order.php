<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Jet Ship Single Order Confirmation</title>
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
        <a href = "http://jetpartner.sportsmanssupplyinc.com/"><img src = "product/images/ssilogo.jpg"></a>

<u><h2>Ship Single Order Confirmation</h2></u><br>
<form action="ship_single_order.prod.php" method="post">
<strong>Order ID: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - order_id" name="id">  <br>
<strong>Order Transmission Date: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - order_transmission_date" name="response_shipment_date">  <br>
<strong>Carrier: </strong><input type="text" id="boxsize" placeholder = "ie: FedEx, USPS, etc.." name="carrier"><br>
<strong>Ship Method: </strong><input type="text" id="boxsize" placeholder = "ie: FedEx SmartPost, USPS Priority, etc.." name="response_shipment_method"><br>
<strong>Tracking #: </strong><input type="text" id="boxsize" placeholder = "Tracking Number" name="shipment_tracking_number"><br>
<strong>Line Item ID: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - order_item_id" name="shipment_item_id">  <br>
<strong>SKU: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - merchant_sku" name="merchant_sku">  <br>
<strong>Quantity: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - request_order_quantity" name="response_shipment_sku_quantity">  <br>
<strong>Carrier Pick Up Date: </strong><input type="text" id="boxsize" placeholder = "yyyy-MM-ddTHH:mm:00.0000000Z" name="carrier_pick_up_date">  <br>
<strong>Expected Delivery Date: </strong><input type="text" id="boxsize" placeholder = "yyyy-MM-ddTHH:mm:00.0000000Z" name="expected_delivery_date">  <br>
  
<input type="submit" id="button" value="Ship Order"></font> 

    <br><br>
</form>
<div align = "right">
          <a href = "mailto:mzschiegner@ssisports.net?subject=Jet Single Order Confirmation Feedback">Feedback?</a>
        </div>

    </body>
</html>

 
 