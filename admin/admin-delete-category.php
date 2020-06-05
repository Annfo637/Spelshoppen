<?php
require_once '../config/db.php';


if(isset($_GET['id'])){

    
    $id = htmlspecialchars($_GET['id']);
    $query = "SELECT * FROM webshop_products WHERE categoryid = :id" ;
    $statement = $db->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute(); 
    if($statement->fetch(PDO::FETCH_ASSOC) == 0){

        $sql = "DELETE FROM webshop_categories WHERE categoryid = :id";
        $stmn = $db->prepare($sql);
        $stmn->bindParam(':id', $id);
        $stmn->execute();
        header('Location:admin-category.php');
    }
    else { ?>

    <script>alert("Du måste ta bort alla produkter från kategorin innan du raderar")
            location.replace("admin-category.php");
    </script><?php   
        
    }

   
 }?>
    
