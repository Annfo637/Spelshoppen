<?php
require_once '../config/db.php';
require_once 'header.php';

$imageold = "";

if(isset($_GET['id'])){
    $id = htmlspecialchars($_GET['id']);
    $sql = "SELECT * FROM webshop_categories WHERE categoryid =:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $category = $row['category'];   
        $imageold = $row['image'];
        
    }else {
        header('Location:admin-category.php');
        exit;
    }
}else {
    header('Location:admin-category.php');
    exit;
}
$msg = "";
$nameErr = "";
if($_SERVER['REQUEST_METHOD'] === 'POST') :

    $category = htmlspecialchars($_POST['category']);
    $id = htmlspecialchars($_POST['id']);
    if ($_FILES['image']['name'] ==''){
        $image = $imageold;
    }
    $image = $_FILES['image']['name'];
    $target = "../images/".basename($image);

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $msg = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $msg = "File is not an image.";
            $uploadOk = 0;
        }
    }
   
    // // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        $image = "";
    }

    else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target) && $uploadOk == true) {
            $msg = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            $image = $_FILES['image']['name'];
            $target = "../images/".basename($image);
        } else {
            $msg =  "No file was uploaded";
            
        }
    }
    if (empty($_POST["category"])) {
        $nameErr = "Kategorinamn måste fyllas i";
      }
    else if (!empty($_POST["category"])) {
        $category = test_input($_POST["category"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^([a-öA-Ö0-9.,:!?\s]+)$/",$category)) {
          $nameErr = "Endast bokstäver och mellanslag är tillåtet";
      }
         else {
       
            $sql = "UPDATE webshop_categories SET category=:category, image=:image WHERE categoryid=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header('Location:admin-update-category.php');

        }
    }

endif;
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<section class="form_container">

        <h3 class="page-title form-container__heading-text">Uppdatera kategori</h3>
        

<form action="#" method="POST" enctype="multipart/form-data" class="form-container">
    <div class="form-container__box">
    <label for="category">Namn på kategori: </label><br>
        <input type="text" value='<?php echo $category; ?>' name="category" class="form-container__box-input update_category-box">
        <p class="error"><?php echo $nameErr;?></p>
    </div>
    <div class="form-container__image update_category-box">
        <label for="image">Ladda upp en bild:</label><br>
        <input type="file" name="image" class="form-container__image-input">     
       
    </div>
    <div class="form-container__submit">
            <input type="submit" value="Uppdatera" class="form-container__submit-button">
    </div>
<input type="hidden" name="id" value="<?php echo $id ?>"> 
</form>

</section>
<?php 
if (!$imageold === false){
    echo "<h2 class='category_img-head'>Kategori bild</h2><div class ='category_img-container'>";
    echo "<div class='category_img-wrapper'><img src='../images/$imageold' width='200px'></div></div><br>
    ";
}
?>
<br><br>
<a href="admin-category.php">
    <button class="back_btn">Tillbaka</button>
</a>
<?php  require_once '../footer.php'; ?>
<!-- <a href='delete-img.php?id=$id' class='btn btn-danger'>Ta bort bild</a> -->