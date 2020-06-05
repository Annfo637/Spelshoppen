<?php
require_once "../second_header_extern.php";
require_once "../config/db.php";
?>
  </header>
<main>

<?php
$productimg = "";
// Hämtar kategori-id som valdes på kategorisidan
$id = htmlspecialchars($_GET['id']);

// Hämtar alla kolumner från tabellen "webshop_products" i db
$stmt = $db->prepare("SELECT  
                    `categoryid`,
                    `productid`,
                    `title`, 
                    `description`, 
                    `quantity`, 
                    `price`,
                    `productimg`,
                    `date`
                    FROM `webshop_products` 
                    WHERE productid=:productid");
$stmt->bindParam(':productid', $id);
$stmt->execute();

//hämta outlet-produkter från databas
$sqlDate = "SELECT * FROM webshop_products WHERE quantity > 0 ORDER BY date ASC LIMIT 3";
$stmtDate = $db->prepare($sqlDate);
$stmtDate->execute();

  //lägger alla outlet-produkters id i en array
  while ($outletRow = $stmtDate->fetch(PDO::FETCH_ASSOC)) :
    $outletProductid[] = $outletRow['productid'];
  endwhile;


echo "<div class='product-info'>";

// Hämtar raderna som finns i varje kolumn
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $categoryid = htmlspecialchars($row['categoryid']);
    $productid = htmlspecialchars($row['productid']);
    $title = htmlspecialchars($row['title']);
    $description = htmlspecialchars($row['description']);
    $quantity = htmlspecialchars($row['quantity']);
    $price = htmlspecialchars($row['price']);
    $productimg = unserialize($row['productimg']);   
    $date = htmlspecialchars($row['date']);

    //nytt outlet pris
    $percentage = 0.9;
    $outletPrice = ceil($price * $percentage);
    $savings = $price - $outletPrice;

    //räkna ut skillnaden mellan dagens datum och produktens datum
    $now = date("yy-m-d");
    $dateNow = date_create($now);
    $dateProd = date_create($date);
    $diff = date_diff($dateProd,$dateNow);
    $diffDays = $diff->format('%R%a days'); 

?>

<section class="product">

<?php 
if($diffDays < 7){
    echo "<h3 class='product_price-new'>Ny!</h3>";
};     
?>

<h1 class="product__prod-title product_title"><?= $title ?></h1>
<p class="product__prod-description">
<?= $description ?>
</p>

<div class="product__img-container">
<?php

if(!empty($productimg)){
foreach ($productimg as $key => $value) {
    if($productimg[0] == ""){
        echo "ingen bildfil finns tillgänglig";
    }else{
        echo "<div class='product_img-wrapper'><img src='../images/$value' width='200px' class='product_img'></div><br>";
    }
}
    }
    else {
        echo "ingen bildfil finns tillgänglig";
  

    }
    ?>
    

</div>

<?php 


   //kollar om produkten är outlet eller ordinarie
if(!in_array($productid, $outletProductid)) {
 // Om det finns i lagret eller inte
 if ($quantity == "0") {
    $any_items = "Finns EJ i lager";
    echo "<div class='product__inventory' style='color: red'>" . $any_items . "</div>";
    echo "<button id='cart-btn$productid' class='add-to-cart' style='background-color: grey; color: black;' disabled>Lägg i varukorgen</button>";
} else {
    echo "<div class='product__prod-price'><strong>Pris:</strong> $price kr</div>";
    $any_items = "I lager: " . $quantity . " st";
    echo "<div class='product__inventory' style='color: green'>" . $any_items . "</div>
    
    <p class='hidden-price' style='display:none'>$price</p>
    <p class='hidden-quantity' style='display:none;'>$quantity</p>
    <p class='hidden-productid' style='display:none'>$productid</p>";
    echo "
    <label for='cartQty'>Antal:</label>
    <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
    event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'> 
    <button id='cart-btn$productid' class='cart-btn'>Lägg i varukorgen</button>
    <p style='display:none;'></p>";
    
}
echo "</div>";
  } else {
    if ($quantity == "0") {
        $any_items = "Finns EJ i lager";
        echo "<div class='product__inventory' style='color: red'>" . $any_items . "</div>";
        echo "<button id='cart-btn$productid' class='add-to-cart' style='background-color: grey; color: black;' disabled>Lägg i varukorgen</button>";
    } else {
        echo "<div class='product__prod-price product_price-outlet'><strong>Pris:</strong> $outletPrice kr</div>
        <p class='product_price-old'>Normalpris: $price kr</p>
        <p class='product_price-savings'>Du sparar: $savings kr! (-10%) </p>";
        $any_items = "I lager: " . $quantity . " st";
        echo "<div class='product__inventory' style='color: green'>" . $any_items . "</div>
        
        <p class='hidden-price' style='display:none'>$price</p>
        <p class='hidden-outletPrice' style='display:none'>$outletPrice</p>
        <p class='hidden-quantity' style='display:none;'>$quantity</p>
        <p class='hidden-productid' style='display:none'>$productid</p>";
        echo "
        <label for='cartQty'>Antal:</label>
        <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
        event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'> 
        <button id='cart-btn$productid' class='cart-btn'>Lägg i varukorgen</button>";
    }
    echo "</div>";

  }

?>

</section>

<?php
echo "<a href='../categorypage/categorypage.php?id=" . $categoryid ."'>
        <button class='btn-back back-product-btn' >Tillbaka</button>
        </a>";

require_once '../footer.php';
?>