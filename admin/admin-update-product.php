<?php
require_once '../config/db.php';
require_once 'header.php';

$imageold = "";
$msg = "";

//Hämtar information från databasen om produkten
if(isset($_GET['id'])){
    $id = htmlspecialchars($_GET['id']);
    $sql = "SELECT * FROM webshop_products WHERE productid =:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $productid = htmlspecialchars($row['productid']);
        $title = htmlspecialchars($row['title']); 
        $price = htmlspecialchars($row['price']);
        $quantity = htmlspecialchars($row['quantity']);
        $description = htmlspecialchars($row['description']);
        $product_categoryid = htmlspecialchars($row['categoryid']);
        $imageold = unserialize($row['productimg']);   
        
    }else {
        header('Location:admin-products.php');
        exit;
    }
}else {
    header('Location:admin-products.php');
    exit;
}


//Hämtar kategorier från databasen
$query ="SELECT * FROM webshop_categories WHERE categoryid = :categoryid";
$statment = $db->prepare($query);
$statment->bindParam(':categoryid', $product_categoryid);
$statment->execute();

while($row = $statment->fetch(PDO::FETCH_ASSOC)){
    $product_category = htmlspecialchars($row['category']);
}

$sql = "SELECT * FROM webshop_categories WHERE NOT categoryid = :categoryid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':categoryid', $product_categoryid);
$stmt->execute();

//Kategorierna för att kunna lägga in dessa i selectbox i formuläret
$option_value = "";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $categoryid = htmlspecialchars($row['categoryid']);
    $category = htmlspecialchars($row['category']);
    $option_value .= "<option value='$categoryid'>$category</option>";
}

//Hämtar värden från formuläret
if($_SERVER['REQUEST_METHOD'] === 'POST') :

    $title = htmlspecialchars($_POST['title']);
    $id = htmlspecialchars($_POST['id']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $description = htmlspecialchars($_POST['description']);
    $categoryid = $_POST['category'];
    $image = $_FILES['productimg']['name'];


    $sql = "UPDATE webshop_products SET title = :title, price = :price, quantity = :quantity, description = :description, categoryid = :categoryid   WHERE productid = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':categoryid', $categoryid);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    //header('Location:admin-products.php');
    
    $msg = "Din produkt är uppdaterad!";




    $imgArrayTest = array_filter($image);
    
    if(!empty($imgArrayTest)){

        if(count($_FILES['productimg']['name']) <= 5){

            $id = htmlspecialchars($_POST['id']);
            $uploadFolder = '../images/';
            $imageData = array();
    
            foreach ($_FILES['productimg']['tmp_name'] as $key => $image) {
                $imageTmpName = $_FILES['productimg']['tmp_name'][$key];
                $imageName = $_FILES['productimg']['name'][$key];
                $result = move_uploaded_file($imageTmpName,$uploadFolder.$imageName);
                array_push($imageData, $imageName);
            }
            $imageUpload = serialize($imageData);
    
            
        $sql = "UPDATE webshop_products SET productimg = :productimg WHERE productid = :id";
        $stmt = $db->prepare($sql);   
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':productimg', $imageUpload);
        $stmt->execute();
    
                
        //header("Location:admin-products.php");
        }
        else if(count($_FILES['productimg']['name']) > 5){
            
           

      $msg = "Du får ladda upp max 5 bilder!";
           
           
        }
    
        }
    

    endif;
    require_once "admin-update-product-form.php";
    if(!empty($imageold)){

        echo "<h3 class='product_img-head'>Produktbilder</h3><br>";
        echo "<div class='product_img-container'>";

        foreach ($imageold as $key => $value) {
            if($imageold[0] == ""){
                echo "ingen bildfil finns tillgänglig";
            }else
            echo "<div class='product_img-wrapper'><img src='../images/$value' width='200px' class='product_img'></div><br>
            ";
        }
       echo "</div>";
       echo "<a href='admin-delete-img.php?id=$productid' onclick='return myFunction()' id='delete'>
            <button class='btn_delete-img'>Radera bilder</button></a><br>";
        
    }
    

?>
<script>
    function myFunction() {
        
                let remove = confirm("Är du säker på att du vill radera alla bilder?");
                if (remove == false) {
                    return false;
                } 
            }
</script> 

<a href="admin-products.php">
    <button class="back_btn">Tillbaka</button>
</a>
<?php  require_once '../footer.php'; ?>

<script>

window.onload = countChar();
function countChar(e){
    let textEntered, countRemaining, counter; 
    textEntered = document.getElementById('description').value; 
    counter = (1000 - (textEntered.length)); 
    countRemaining = document.getElementById('text-count');
    countRemaining.textContent = counter + " tecken kvar";  
}

</script>

