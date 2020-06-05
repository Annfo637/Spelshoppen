<?php
// Denna sida hämtar och ritar ut aktuella kategorier från databasen
require_once 'header_extern.php';
require_once 'config/db.php';

$stmt = $db->prepare("SELECT * FROM `webshop_categories` 
                      WHERE `categoryid` 
                      IN (SELECT categoryid 
                          FROM webshop_products
                          WHERE quantity > 0)");
$stmt->execute();

?>

<!--detta ska vara skalet för en startsida, förstasida för webbshoppen-->
<h2 class="frontpage_head">Kategorier</h2>
<section class="frontpage_links">
<h2><a href="news\news.php" class="frontpage_links__link">NYA SPEL</a></h2>
<br>
<h2><a href="lastChance\lastChance.php" class="frontpage_links__link">SISTA CHANSEN</a></h2>
<br>
</section>

<section class="frontpage_categories">
    <!--här hämtas kategorier från databas-->
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
        $category = htmlspecialchars($row['category']);
        $categoryid = htmlspecialchars($row['categoryid']);
        $image = htmlspecialchars($row['image']);

        // Skapa src till img-taggen
        if(empty($image))
            $image = "https://via.placeholder.com/200x200.jpg";

        else
            $image = "images/$image";


        echo
            "<div class='category_card img_wrapper'>
            <img class='category_img' src='$image' alt='$category'>";
        echo
            "<a href='/categorypage/categorypage.php?id=$categoryid' 
            class='category_title'>$category</a>
        </div>";

    endwhile;
    ?>
</section>