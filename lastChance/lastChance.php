<?php
  require_once '../second_header_extern.php';
require_once '../config/db.php';
$sqlDate = "SELECT * FROM `webshop_products` WHERE quantity > 0 ORDER BY date ASC LIMIT 3";
$stmtDate = $db->prepare($sqlDate);
$stmtDate->execute();
?>
<h2 class="category_name">Outlet</h2>
</header>
<main>
</header>
<main>
<h3>Sista chansen, passa på!</h3>

<div class="product_container">

<?php

while ($row = $stmtDate->fetch(PDO::FETCH_ASSOC)) :
  $outletTitle = htmlspecialchars($row['title']);
  $outletOrigPrice = htmlspecialchars($row['price']);
  $outletProductid = htmlspecialchars($row['productid']);
  $outletQuantity = htmlspecialchars($row['quantity']);
  $outletDate = htmlspecialchars($row['date']);
  $productimg = unserialize($row['productimg']); 

  //nytt outlet pris
  $percentage = 0.9;
  $outletPrice = ceil($outletOrigPrice * $percentage);
  $savings = $outletOrigPrice - $outletPrice;

  //finns eller inte i lager
  if ($outletQuantity == "0") {
    $any_items = "<span>Finns EJ i lager</span>";
  } else {
    $any_items = "I lager: " . $outletQuantity . " st";
  }

    echo
    "<div class='product_card'>
          <p class='product_price-outlet'>Pris: $outletPrice kr</p>
          <a href= '../product/product_info.php? id=$outletProductid' 
          class='product_title'>$outletTitle</a>";
          if(!empty($productimg) && $productimg[0] !== ""){
            echo "<img src='../images/$productimg[0]' class='product_img'>";
            }
          echo "<p class='product_price-old'>Normalpris: $outletOrigPrice kr</p>
          <p class='product_price-savings'>Du sparar: $savings kr! (-10%) </p> 
          <p class='any-items'>$any_items</p>
          <p class='hidden-price' style='display:none;'>$outletOrigPrice</p>
          <p class='hidden-outletPrice' style='display:none;'>$outletPrice</p>
          <p class='hidden-quantity' style='display:none;'>$outletQuantity</p>
          <p class='hidden-productid' style='display:none'>$outletProductid</p>

          <label for='cartQty'>Antal:</label>";
          if ($outletQuantity == "0") {
            echo "";
        }else{
          echo "<input type='number' onkeydown='javascript: return event.keyCode === 8 ||
          event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$outletQuantity' value='1'>
           <button class='cart-btn product_card-btn'>Lägg i varukorg</button>";
        }
      echo "</div>";

endwhile;
?>
</div>
<a href="../index.php">
  <button class="btn-back">Tillbaka till startsidan</button>
</a>
<?php
require_once "../footer.php"
?>