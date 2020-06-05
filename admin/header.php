<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="../styles/main.css" />
    <title>Adminpanelen</title>
</head>

<body>
    <main id="home">
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php">Admin - Hem</a>
        <a href="admin-category.php">Kategorier</a>
        <a href="admin-products.php">Produkter</a>
        <a href="../index.php" class="sidenav__webshop-link">WEBBSHOPPEN</a>
      </div>

        <button id="toggle-menu" onclick="openNav()">Meny</button>    
    
        <!-- Ska denna section vara här? -->
        <section class="admin_container">



<script>

/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

</script>
        

