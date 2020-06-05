<?php
require_once "header.php";
require_once "../config/db.php";

if(isset($_GET['id'])){
    $orderStatusId = htmlspecialchars($_GET['id']);
    }else {
    $orderStatusId = 0;
    };


if ($orderStatusId == 1){
    $orderStatus = "Ny";
} elseif ($orderStatusId == 2) {
    $orderStatus = "Behandlas";
} elseif ($orderStatusId == 3) {
    $orderStatus = "Slutförd";
} elseif ($orderStatusId == 0){
    $orderStatus = "Alla";
};


?>
<h1 class="admin-home__header">Välkommen Admin</h1>

<h2 class="orders-head">Beställningar</h2>

<form id="search-city" action="" class="search-form">
<input type="text" name="search" id="input-city" class="search-form__input-city"  onkeyup="filterCity()" placeholder="Sök efter ort">
</form>

<form id="order-status_form" class="order-status_form">
<lable id="show_lable">Sortera på orderstatus</lable>
<select id="show_order-status" name="order-status">
  <option id="current-status"><?php echo $orderStatus?></option>
  <option value="0">Alla</option>
  <option value="1">Ny</option>
  <option value="2">Behandlas</option>
  <option value="3">Slutförd</option>
</select>
</form>


<?php


if ($orderStatusId > 0){
   $sql = "SELECT * FROM webshop_orders WHERE `status` = $orderStatusId UNION ALL SELECT * FROM webshop_orderscomplete WHERE status = $orderStatusId";
} else {
    $sql = "SELECT * FROM webshop_orders UNION ALL SELECT * FROM webshop_orderscomplete"; 
};


$stmt = $db->prepare($sql);
$stmt->execute();

$productsspec;
$table = "<section class='table_container'>
                <table class='table_orders_admin' id='table-orders'>
                    <tbody>
                        <tr class='table_orders_admin-row'>
                            <th class='table_orders_admin-head'>Orderid</th>
                            <th class='table_orders_admin-head'>Kunduppgifter</th>
                            <th class='table_orders_admin-head'>Ort</th>
                            <th class='table_orders_admin-head'>Produkter</th>
                            <th class='table_orders_admin-head'><a id='sort-sum'>Summa</a></th>
                            <th class='table_orders_admin-head'><a id='sort-date'>Orderdatum</a></th>
                            <th class='table_orders_admin-head' colspan='2'><a id='sort-status'>Orderstatus</a></th>
                            </tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orderid = htmlspecialchars($row['orderid']);
    $date = htmlspecialchars($row['orderdate']);
    $name = htmlspecialchars($row['name']);
    $email = htmlspecialchars($row['email']);
    $phone = htmlspecialchars($row['phone']);
    $street = htmlspecialchars($row['street']);
    $zip = htmlspecialchars($row['zip']);
    $city = htmlspecialchars($row['city']);
    $status = htmlspecialchars($row['status']);
    $products = json_decode($row['products'], true);
    $totalprice = htmlspecialchars($row['totalprice']);
    $freight = htmlspecialchars($row['freight']);

    $zipcode = substr_replace($zip, " ", 3, 0 );

    $productsspec = "";
    foreach ($products as $key => $value) {
        $pOutlet="";
        $pPrice="";
        foreach ($value as $ky => $val) {
          if ($ky == "cartQty") {
            $productsspec .= $val . " st ";
          }
          if ($ky == "title") {
            $productsspec .= $val;
          }
          if ($ky == "outletprice") {
            $pOutlet = $val;
          }
          if ($ky == "price") {
            $pPrice = $val;
            if ($pOutlet != null) {
                $productsspec .= " pris " . $pOutlet . " kr (ord pris " . $pPrice . " kr)";
            }
            else {
                $productsspec .= " pris " . $pPrice . " kr";
            }
          }
        }
        $productsspec .= "<br>";
      }

    //Kontrollerar vilken status-siffra beställningen har i databasen,
    //för att skriva ut rätt statustext på sidan
    if ($status == 1) {
        $status = "Ny";
    } elseif ($status == 2) {
        $status = "Behandlas";
    } elseif ($status == 3) {
        $status = "Slutförd";
    }

    $onlyDate = date_format(date_create($date), "yy-m-d");

    $table .= "
        <tr class='table_orders_admin-row'>
            <td class='table_orders_admin-cell'> $orderid</td>
            <td class='table_orders_admin-cell' style='width: 20%'>
                $name <br> 
                $email <br> 
                $phone <br> 
                $street, $zipcode 
            </td>
            <td class='table_orders_admin-cell'> $city </td>
            <td class='table_orders_admin-cell products' style='width: 20%'> $productsspec <br>
                                                                        Frakt: $freight kr</td>
            <td class='table_orders_admin-cell'> $totalprice </td>
            <td class='table_orders_admin-cell'> $onlyDate</td>
            <td class='table_orders_admin-cell'> $status</td>
            <td class='table_orders_admin-cell'>";

     if($status != "Slutförd"){

    $table .=   
                "<a href='admin-update-status.php?id=$orderid'>
                <button class='btn_update-status'>Ändra status</button>
                </a>
            </td>

        </tr>";
}
}
 $table .= "</tbody></table></section>";


echo $table;

require_once "../footer.php";

