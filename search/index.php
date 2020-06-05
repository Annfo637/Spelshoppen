<?php
require_once '../config/db.php';
require_once '../second_header_extern.php';


?>
</header>
<main>

<section>
<h1 class="header--center">Sökresultat</h1>
<br><br>

<!--i nedan div mha php rita ut produktkort för varje produkt i sökresultatet-->
<div id="searched-result" class="search-result">

<?php

//Hämta arrayen med produkt-id från sökresultatet 
if(isset($_GET['id'])){
  $search = htmlspecialchars($_GET['id']);
  }else {
  $search = "";
  };
  

  if ($search === ""){
    echo "<h3 id='search-noResult'>Vi har tyvärr inte det spelet du söker, testa gärna en ny sökning!</h3>";
  }else {

  
  //Hämta sökresultatets produkter från databasen
  $sql = "SELECT * 
          FROM webshop_products
          WHERE productid IN ({$search}) AND quantity > 0";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  
  //hämta outlet-produkter från databas
  $sqlDate = "SELECT * FROM webshop_products WHERE quantity > 0 ORDER BY date ASC LIMIT 3";
  $stmtDate = $db->prepare($sqlDate);
  $stmtDate->execute();
  //lägger alla outlet-produkters id i en array
  while ($outletRow = $stmtDate->fetch(PDO::FETCH_ASSOC)) :
    $outletProductid[] = $outletRow['productid'];
  endwhile;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      $title = htmlspecialchars($row['title']);
      $price = htmlspecialchars($row['price']);
      $productid = htmlspecialchars($row['productid']);
      $quantity = htmlspecialchars($row['quantity']);
      $date = htmlspecialchars($row['date']);
      $productimg = unserialize($row['productimg']); 



  //nytt outlet pris
  $percentage = 0.9;
  $outletPrice = ceil($price * $percentage);
  $savings = $price - $outletPrice;

  // om det finns i lager
  $any_items = "I lager: " . $quantity . " st";

//datumkontroll, rea eller ny
      $now = date("yy-m-d");
      $dateNow=date_create($now);
      $dateProd=date_create($date);
      $diff=date_diff($dateProd,$dateNow);
      $diffDays = $diff->format('%R%a days'); 
      //echo $diffDays;

  if($diffDays < 7){
    //echo "less then two weeks";
    echo
    "<div class='product_card'>
          <h3 class='product_price-new'>Ny!</h3>
          <a href= '../product/product_info.php? id=$productid' 
          class='product_title'>$title</a>";
          if(!empty($productimg) && $productimg[0] !== ""){
            echo "<img src='../images/$productimg[0]' width='100px' class='product_img'>";
            }
          echo "<p class='product_price'>Pris: $price kr</p>
          <p class='any-items'>$any_items</p>
          <p class='hidden-price' style='display:none'>$price</p>
          <p class='hidden-quantity' style='display:none;'>$quantity</p>
          <p class='hidden-productid' style='display:none'>$productid</p>
          <label for='cartQty'>Antal:</label>
          <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
          event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'>
           <button class='cart-btn product_card-btn'>Lägg i varukorg</button>
           </div>";

    //kollar om produkten är outlet eller ordinarie
    }else if(in_array($productid, $outletProductid)) {

    echo
    "<div class='product_card'>
          <p class='product_price-outlet'>Pris: $outletPrice kr</p>
          <a href= '../product/product_info.php? id=$productid' 
          class='product_title'>$title</a>";
          if(!empty($productimg) && $productimg[0] !== ""){
            echo "<img src='../images/$productimg[0]' width='100px' class='product_img'>";
            }
          echo "<p class='product_price-old'>Normalpris: $price kr</p>
          <p class='product_price-savings'>Du sparar: $savings kr! (-10%) </p> 
          <p class='any-items'>$any_items</p>
          <p class='hidden-price' style='display:none;'>$price</p>
          <p class='hidden-outletPrice' style='display:none;'>$outletPrice</p>
          <p class='hidden-quantity' style='display:none;'>$quantity</p>
          <p class='hidden-productid' style='display:none'>$productid</p>

          <label for='cartQty'>Antal:</label>
          <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
          event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'>
           <button class='cart-btn product_card-btn'>Lägg i varukorg</button>
           </div>";
  } else {
    
    echo
    "<div class='product_card'>
    <a href= '../product/product_info.php? id=$productid' 
    class='product_title'>$title</a>";
          if(!empty($productimg) && $productimg[0] !== ""){
            echo "<img src='../images/$productimg[0]' width='100px' class='product_img'>";
            }
    echo "<p class='product_price'>Pris: $price kr</p>
    <p class='any-items'>$any_items</p>
    <p class='hidden-price' style='display:none;'>$price</p>
    <p class='hidden-quantity' style='display:none;'>$quantity</p>
    <p class='hidden-productid' style='display:none'>$productid</p>

    <label for='cartQty'>Antal:</label>
    <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
    event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'>
     <button class='cart-btn product_card-btn'>Lägg i varukorg</button>
     </div>";
  };

    endwhile;

  }

    ?>

</div>
<br>
<br>
<a href="../index.php">
  <button class="btn-back">Tillbaka till startsidan</button>
</a>
</section>

<?php
require_once "../footer.php"
?>