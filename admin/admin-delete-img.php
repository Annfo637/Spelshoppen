<?php

require_once '../config/db.php';


if(isset($_GET['id'])){
    
    $id = htmlspecialchars($_GET['id']);

    $sql = "UPDATE webshop_products SET productimg = '' WHERE webshop_products.productid = $id";
    $stmn = $db->prepare($sql);
    $stmn->bindParam(':id', $id);
    $stmn->execute();
    
   
    }?>
    
    <script> location.replace("admin-update-product.php");</script>
   