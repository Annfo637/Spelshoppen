<?php
require_once "../second_header_extern.php";
require_once "send-order.php";
?>
</header>

<?php 

//HÄMTA ORDERINFO FRÅN DATABASEN (hämtar bara senaste beställningen baserat på orderid)
$sql = "SELECT * FROM webshop_orders ORDER BY orderid DESC LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute();

//Skapa tabellhuvud med rubriker
$orderedProducts;
$table = "<table class='table_orders table_orders-container'>
            <tbody>
               <tr class='table_orders-row table_orders-head-row'>
                  <th class='table_orders-head-text'>Orderid</th>
                  <th class='table_orders-head-text'>Orderdatum</th>
                  <th class='table_orders-head-text'>Kunduppgifter</th>
                  <th class='table_orders-head-text'>Produkter</th>
                  <th class='table_orders-head-text'>Summa</th>
               </tr>";


//För varje orderrad i databasen - hämta all orderinfo och spar ner i variabler
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $orderId = htmlspecialchars($row['orderid']);
  $orderDate = htmlspecialchars($row['orderdate']);
  $orderDate = substr($orderDate, 0, 10); //Hämtar de 10 första tecknen = bara datumet, utan tidsangivelsen)
  $totalPrice = htmlspecialchars($row['totalprice']);
  $name = htmlspecialchars($row['name']);
  $email = htmlspecialchars($row['email']);
  $phone = htmlspecialchars($row['phone']);
  $street = htmlspecialchars($row['street']);
  $zip = htmlspecialchars($row['zip']);
  $city = htmlspecialchars($row['city']);
  $products = json_decode($row['products'], true);
  $freight = htmlspecialchars($row['freight']);

  $zipcode = substr_replace($zip, " ", 3, 0 );


  //Hämta värden från produktarrayen för att kunna skriva ut dem i orderbekräftelsen
  $orderedProducts = ""; //fylls på med titel, antal och pris för varje produkt
  
  foreach ($products as $key => $value) {
    $pOutlet="";
    $pPrice="";
    foreach ($value as $ky => $val) {
      if ($ky == "cartQty") {
        $orderedProducts .= $val . " st ";
      }
      if ($ky == "title") {
        $orderedProducts .= $val;
      }
      if ($ky == "outletprice") {
        $pOutlet = $val;
      }
      if ($ky == "price") {
        $pPrice = $val;
        if ($pOutlet != null) {
          $orderedProducts .= " pris " . $pOutlet . " kr (ord pris " . $pPrice . " kr)";
        }
        else {
          $orderedProducts .= " pris " . $pPrice . " kr";
        }
      }
    }
    $orderedProducts .= "<br>";
  }

  //Uppdatera lagersaldot i databasen 
  require_once "update-quantity.php";


  //Skapa en tabell med orderdetaljerna som hämtats från databasen
  $table .= "
        <tr class='table_orders-row'>
            <td class='table_orders-cell conf-cell'> $orderId</td>
            <td class='table_orders-cell conf-cell'> $orderDate</td>
            <td class='table_orders-cell conf-cell'>
                $name <br> 
                <span class='email-style'>$email </span><br> 
                $phone <br> 
                $street, $zipcode $city
            </td>
            <td class='table_orders-cell conf-cell products'> $orderedProducts </td>
            <td class='table_orders-cell conf-cell'> $totalPrice kr <br>
                                                    varav frakt: $freight kr</td>
        </tr>";
}

$table .= "</tbody></table>";
?>

<section class="order-confirmation-page">
<h1 class="order-confirmation-heading">Orderbekräftelse</h1>
<br>
<br>
<h2 class="order-confirmation-text">Tack för din beställning!</h2>
<br>
<section class='table_container'>
  <!-- här skrivs tabellen ut med all orderinfo -->
  <?php echo $table ?>
</section>
<br><br>
<button id="print-order-btn">Skriv ut orderbekräftelsen</button>
</section>
</main>
<?php

require_once "../footer.php"
?>