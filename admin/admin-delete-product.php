<?php

require_once '../config/db.php';


if(isset($_GET['id'])){
    
    $id = htmlspecialchars($_GET['id']);

    $sql = "DELETE FROM webshop_products WHERE productid = :id";
    $stmn = $db->prepare($sql);
    $stmn->bindParam(':id', $id);
    $stmn->execute();
    
   
    }?>
    
    <script> location.replace("admin-products.php");</script>
   