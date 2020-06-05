<?php 
require_once 'header.php';
require_once '../config/db.php';

$sql = "SELECT * FROM webshop_categories"; 
$stmt = $db->prepare($sql);
$stmt->execute();

$list = "<section class='table_categories-container'><table class='table_categories'><tr class='table_category-row' >
        <th class='table_category-head'>Kategori</th>
        <th class='table_category-head'>Redigera</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){  
    $category = htmlspecialchars($row['category']);
    $id = htmlspecialchars($row['categoryid']);
    $list .= "<tr class='table_category-row'>
    <td class='table_category-cell'> $category</td>
    <td class='table_category-cell'><a href='admin-update-category.php?id=$id'>
                                    <button class='btn_update-category'>Uppdatera</button>
                                    </a>
                                    <a href='admin-delete-category.php?id=$id' onclick='return myFunction()' id='delete'>
                                    <button class='btn_delete-category'>Ta bort</button>
                                    </a></td></tr>";

    }

    $list .= '</table></section>';  

    if($_SERVER['REQUEST_METHOD'] === 'POST') :
        
        $sql = "INSERT INTO webshop_categories (category, image)
                VALUES (:category, :image) ";
           
        $stmt = $db->prepare($sql);

        
        $category = htmlspecialchars($_POST['category']);
        $image = $_FILES['category-img']['name'];
        $target = "../images/".basename($image);
        

        
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $image);

    endif;
    echo "<div class='page__backround'>
    <h1 class='category-head'>Kategorier</h1>";
    echo $list;
    require_once "admin-create-category.php";

 ?>
 
<!-- <div class="page__backround">
<h1 class="category-head">Kategorier</h1> -->
 <?php 
 //echo $list;?> 

<?php
require_once "../footer.php"?>
 <script>
    function myFunction() {
        let remove = confirm("Är du säker på att du vill radera kategorin");
        if (remove == false) {
            return false;
        } 
    }  
</script> 

