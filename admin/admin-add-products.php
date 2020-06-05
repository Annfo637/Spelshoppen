<?php

require_once 'header.php';
require_once '../config/db.php';


$errors = "";
//$msg = "";

$sql = "SELECT * FROM webshop_categories";
$stmt = $db->prepare($sql);
$stmt->execute();

$option_value = "";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryid = htmlspecialchars($row['categoryid']);
    $category = htmlspecialchars($row['category']);
    $option_value .= "<option value='$categoryid'>$category</option>";
}


$error = array();
$title = $price = $quantity = $category = $description = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') :

    if (empty($_POST['title'])) {
        $error[] =  "Du måste ange produktnamn";
    } else if (!empty($_POST['title'])) {
        $title = $_POST['title'];

        //Check if the product already exists in database
        $sql_c = "SELECT * FROM webshop_products WHERE title = :title";
        $stmt_c = $db->prepare($sql_c);
        $stmt_c->bindParam(':title', $title);
        $stmt_c->execute();

        if ($stmt_c->rowCount() > 0) {
            $error[] = "Produkten " . $title . " finns redan";
        } else {
            $title = test_input($_POST['title']);
        }

        //Check if the product title contains allowed characters
        if (preg_match("/^([a-öA-Ö0-9.\s]+)$/", $title)) {
            $title = test_input($_POST['title']);
        } else {
            $error[] = "Produktnamnet får endast innehålla bokstäver, siffror och mellanslag";
        }
    }

    // if(empty($_POST['description'])){
    //     $error[] = "Du måste ange en beskrivning";
    // }
    if (!empty($_POST['description'])) {
        $description = $_POST['description'];
        if (preg_match("/^([a-öA-Ö0-9.,:!?\s]+)$/", $description)) {
            $description = test_input($_POST['description']);
        } else {
            $error[] = "Beskrivningen får endast innehålla bokstäver och siffror och vara max 1000 tecken";
        }
    }

    if (empty($_POST['price'])) {
        $error[] = "Du måste ange ett pris";
    } else if (!empty($_POST['price'])) {
        $price = filter_var($_POST['price'], FILTER_VALIDATE_INT);
        if (!$price === false) {
            $price = test_input($_POST['price']);
        } else {
            $error[] = "Priset får endast innehålla siffror";
        }
    }

    if (!isset($_POST['quantity']) && ($_POST['quantity']) !== 0) {
        $error[] = "Du måste ange lagerstatus";
    } else if (!empty($_POST['quantity'])) {

        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
        if (!$quantity === false) {
            $quantity = test_input($_POST['quantity']);
        } else {
            $error[] = "Lagerstatus får endast innehålla siffror";
        }
    }

    if (!$_POST['category'] == "") {
        $categoryid = $_POST['category'];
    } else {
        $error[] = "Du måste ange en kategori";
    }

    if (count($_FILES['productimg']['name']) <= 5) {

        $uploadFolder = '../images/';
        $imageData = array();

        foreach ($_FILES['productimg']['tmp_name'] as $key => $image) {
            $imageTmpName = $_FILES['productimg']['tmp_name'][$key];
            $imageName = $_FILES['productimg']['name'][$key];
            $result = move_uploaded_file($imageTmpName, $uploadFolder . $imageName);
            array_push($imageData, $imageName);
        };

        $imageUpload = serialize($imageData);
    } else {
        $error[] = "Du får endast ladda upp max 5 bilder";
    }



    if (count($error) == 0) {

        $sql = "INSERT INTO webshop_products (title, description, categoryid, price, quantity, productimg)
        VALUES (:title, :description, :categoryid, :price, :quantity, :productimg) ";



        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':categoryid', $categoryid);
        $stmt->bindParam(':productimg', $imageUpload);
        $stmt->execute();
    }


    if (count($error) > 0) {

        foreach ($error as $e) {
            $errors .= "<div class='error'><p> $e </p></div><br />";
        }
    } else {
        $errors = "<div class='suc'><p> Din Produkt är sparad!</p></div>";
    }
endif;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>





<?php
require_once 'admin-add-product-form.php';
require_once '../footer.php'; ?>

<script>
    function countChar(e) {
        let textEntered, countRemaining, counter;
        textEntered = document.getElementById('description').value;
        counter = (1000 - (textEntered.length));
        countRemaining = document.getElementById('text-count');
        countRemaining.textContent = counter + " tecken kvar";
    }
</script>