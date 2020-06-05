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


$productimg = "";
  if(isset($_GET['id'])){
  $currentCategory = htmlspecialchars($_GET['id']);
} else {
  $currentCategory = 1;
};

$stmt = $db->prepare("SELECT * FROM webshop_products WHERE categoryid = $currentCategory AND quantity > 0");
$stmt->execute();

$statement = $db->prepare("SELECT `categoryid`, `category`
FROM `webshop_categories` WHERE categoryid = $currentCategory");
$statement->execute();

while ($rowCategory = $statement->fetch(PDO::FETCH_ASSOC)){
$category = htmlspecialchars($rowCategory['category']);
}

//hämta outlet-produkter från databas
$sqlDate = "SELECT * FROM webshop_products WHERE quantity > 0 ORDER BY date ASC LIMIT 3";
$stmtDate = $db->prepare($sqlDate);
$stmtDate->execute();

?>

<!--sektion för produkter-->

<section>
  <h1 class="category_name"><?php echo $category ?></h1>
  </header>

  <main>
  <!--här hämtas kategoriens produkter från databas-->
  <div class="product_container">
    <?php

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

      // HTML-variabel
      $productHTML = "";

     //nytt outlet pris
      $percentage = 0.9;
      $outletPrice = ceil($price * $percentage);
      $savings = $price - $outletPrice;

      //finns eller inte i lager
        $any_items = "I lager: " . $quantity . " st";

            //datum kontroll, rea eller new
            $now = date("yy-m-d");
            $dateNow=date_create($now);
            $dateProd=date_create($date);
            $diff=date_diff($dateProd,$dateNow);
            $diffDays = $diff->format('%R%a days'); 

            if($diffDays < 7){
              //echo "less then two weeks";
              
              $productHTML .=
                    "<div class='product_card'>
                    <h3 class='product_price-new'>Ny!</h3>
                          <a href= '../product/product_info.php? id=$productid' 
                          class='product_title'>$title</a>
                          ". checkImage($productimg) ."
                          <span class='product_price'>Pris: $price kr</span>
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

              $productHTML .=
              "<div class='product_card'>
              <p class='product_price-outlet'>Pris: $outletPrice kr</p>
                    <a href= '../product/product_info.php? id=$productid' 
                    class='product_title'>$title</a>
                    " . checkImage($productimg) . "
                    <p class='product_price-old'>Normalpris: $price kr</p>
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
      
              $productHTML .=
              "<div class='product_card'>
              <a href= '../product/product_info.php? id=$productid' 
                class='product_title'>$title</a>
                ". checkImage($productimg) . "
                <p class='product_price'>Pris: $price kr</p>
                <p class='any-items'>$any_items</p>
                <p class='hidden-price' style='display:none;'>$price</p>
                <p class='hidden-quantity' style='display:none;'>$quantity</p>
                <p class='hidden-productid' style='display:none'>$productid</p>

                <label for='cartQty'>Antal:</label>
                <input type='number' onkeydown='javascript: return event.keyCode === 8 ||
                event.keyCode === 46 ? true : !isNaN(Number(event.key))' id='cartQty' name='cartQty' class='cartQty' min='1' max='$quantity' value='1'>
                 <button class='cart-btn product_card-btn'>Lägg i varukorg</button>
                 </div>";

            }
            echo $productHTML;
    endwhile;
   
    ?>

  </div>
  <br>
  <br>
  <a href="../index.php">
    <button class="btn-back">Tillbaka till startsidan</button>
  </a>
</section>


<?php require_once '../footer.php'; ?>
