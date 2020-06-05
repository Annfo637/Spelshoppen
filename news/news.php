<?php
  require_once '../second_header_extern.php';
require_once '../config/db.php';

function checkImage($productimg) {
  if(!empty($productimg) && $productimg[0] !== ""){
    return "<img src='../images/$productimg[0]' class='product_img'>";
  } else {
    return "";
  }
}

$sql = "SELECT * FROM webshop_products";
$stmt = $db->prepare($sql);
$stmt->execute();
?>

<h2 class="category_name">Nya Spel</h2>
</header>
<main>
<h3>Här hittar du våra nyaste varor</h3>
  
<div class="product_container">

<?php  
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
  $title = htmlspecialchars($row['title']);
  $price = htmlspecialchars($row['price']);
  $productid = htmlspecialchars($row['productid']);
  $quantity = htmlspecialchars($row['quantity']);
  $date = htmlspecialchars($row['date']);
  $productimg = unserialize($row['productimg']); 
 
  // HTML-variabel
  $productHTML = "";
  
  //räkna ut skillnaden mellan datens datum och produktens datum
  $now = date("yy-m-d");
  $dateNow = date_create($now);
  $dateProd = date_create($date);
  $diff = date_diff($dateProd,$dateNow);
  $diffDays = $diff->format('%R%a days'); 
  //echo $diffDays;
  
  $any_items = "I lager: " . $quantity . " st";

  if($diffDays < 7 && $quantity > 0){
    //echo "less then two weeks";
    
    $productHTML .=
    "<div class='product_card'>
          <h3 class='product_price-new'>Ny!</h3>
          <a href= '../product/product_info.php? id=$productid' 
          class='product_title'>$title</a>
          ". checkImage($productimg) ."
          <p class='product_price'>Pris: $price kr</p>
          <p class='any-items'>$any_items</p>
          <p class='hidden-price' style='display:none'>$price</p>
          <p class='hidden-quantity' style='display:none;'>$quantity</p>
          <p class='hidden-productid' style='display:none'>$productid</p>
          <label for='cartQty'>Antal:</label>
          <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
          event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'>
           <button class='cart-btn product_card-btn'>Lägg i varukorg</button>
           </div>";
  };
  echo $productHTML;

endwhile;
?>

</div>
<a href="../index.php">
  <button class="btn-back">Tillbaka till startsidan</button>
</a>
<?php
require_once "../footer.php"
?>