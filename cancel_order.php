<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Jet Order Cancel</title>
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

<u><h2>Cancel Order</h2></u><br>
<form action="order_cancel.prod.php" method="post">
<strong>Order ID: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - order_id" name="id">  <br>
<strong>Order Transmission Date: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - order_transmission_date" name="response_shipment_date">  <br>
<strong>SKU: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - merchant_sku" name="merchant_sku">  <br>
<strong>Quantity: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - request_order_quantity" name="response_shipment_cancel_qty">  <br>
<strong>Carrier Pick Up Date: </strong><input type="text" id="boxsize" placeholder = "Copy and Paste - request_ship_by" name="carrier_pick_up_date">  <br>
<strong>Request Delivery By: </strong><input type="text" id="boxsize" placeholder = "request_delivery_by + .0000000Z" name="expected_delivery_date">  <br>
  
<input type="submit" id="button" value="Cancel Order"></font> 

    <br><br>
</form>
<div align = "right">
          <a href = "mailto:mzschiegner@ssisports.net?subject=Jet Order Cancel Feedback">Feedback?</a>
        </div>

    </body>
</html>

 
 