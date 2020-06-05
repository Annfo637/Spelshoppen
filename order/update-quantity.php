<?php
//Hämta produkt-id och antal för varje beställd produkt
//för att kunna uppdatera lagersaldo i tabellen webshop_products i databasen

$productId = "";
$productQty = "";
//Hämta varje produkt i arrayen
foreach ($products as $key => $value) {
  //och för varje produkt - hämta produkt-id och antal
  foreach ($value as $ky => $val) {
    if ($ky == "productid") {
      $productId = $val;
    }

    if ($ky == "cartQty") {
      $productQty = $val;
    }
  }

  //skickar sql-fråga till databasen 
  //sätter aktuell produktrads quantity till befintligt antal minus beställt antal ($productQty)
  $sql = "UPDATE webshop_products SET quantity = quantity - $productQty WHERE productid = $productId";
  $stmt = $db->prepare($sql);
  $stmt->execute();
}
