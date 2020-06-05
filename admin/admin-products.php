<?php

require_once 'header.php';
require_once '../config/db.php';

?>

<h2 class="product-head">Produkter</h2>

<?php



$sql="SELECT `productid`, `title`, `category` 
FROM `webshop_products` 
LEFT JOIN webshop_categories 
ON webshop_products.categoryid = webshop_categories.categoryid 
ORDER BY `webshop_categories`.`category` ASC";

$stmt = $db->prepare($sql);
$stmt->execute();


$output ="<section class='table_container'><table class='table_products'><tr class='table_products-row' >
                    <th class='table_products-head'>Produkt</th>
                    <th class='table_products-head'>Kategori</th>
                    <th class='table_products-head'>Redigera</th></tr>";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $productid = htmlspecialchars($row['productid']);
    $categories = htmlspecialchars($row['category']);
    $product = htmlspecialchars($row['title']);
    $category = strtoupper($categories);

    $output .= "<tr class='table_products-row'>
                <td class='table_products-cell'> $product </td>
                <td class='table_products-cell'>$category</td>
                <td><a href='admin-update-product.php?id=$productid'>
                    <button class='btn_update-product'>Uppdatera</button>
                    </a>
                    <a href='admin-delete-product.php?id=$productid' onclick='return myFunction()' id='delete'>
                    <button class='btn_delete-product'>Radera</button>
                    </a></td>
                </tr> ";


}

$output.= "</table></section>";

echo $output;

?>



<script>
    function myFunction() {
        
                let remove = confirm("Är du säker på att du vill radera produkten?");
                if (remove == false) {
                    return false;
                } 
                
            }
                    

</script> 

<a href="admin-add-products.php">
    <button class="btn-add-product">Lägg till produkt</button>
</a>
<?php require_once "../footer.php";?>