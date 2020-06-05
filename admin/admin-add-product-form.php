


<!--Formulär för att lägga till produkter på admin-sidan--->



<section class="form_container">
    
        <h1 class="page-title form-container__heading-text">Lägg till en ny produkt</h1>

    <?php


    echo $errors; 
    ?>
    
    <form action="#" method="POST" enctype="multipart/form-data" class="form-container">

    <div class="product_field-name form-container__box">
        <label for="title">Produkt namn: </label><br>
        <input type="text" name="title" class="form-container__box-input" required>

    </div>

    <div class="product_field-price form-container__box">
        <label for="price">Pris: </label><br>
        <input type="number" min="0" max="10000" name="price" class="form-container__box-input" required>
    </div>

    <div class="product_field-quantity form-container__box">
        <label for="quantity">Ange lagerstatus: <br>
        <input type="number" name="quantity" class="form-container__box-input">
        
    </div>

    <div class="product_field-category form-container__box">
        <label for="category">Kategori: </label><br>
        <select name="category" class="form-container__box-input" required>
            <option value="">Välj en kategori...</option>
            <?php echo $option_value; ?>

        </select>
        
    </div>

    <div class="product_field-img form-container__image">
        <label for="product-img">Ladda upp produktbild(MAX 5 Bilder): </label><br>
        <input type="file" name="productimg[]" multiple="multiple" class="form-container__image-input">
    </div>

    <div class="product_field-description form-container__description">
        <label for="description">Beskrivning: </label><br>
        <textarea name="description" placeholder="Beskrivning av produkt(max 1000 tecken)" cols="10" rows="8" maxlength="1000" class="form-container__description-input" id="description" onkeyup="countChar()"; ></textarea>
        <div id="text-count">1000 tecken kvar</div>
    </div>

    <div class="product_field-submit form-container__submit">
        <input type="submit" value="Lägg till ny produkt" class="form-container__submit-button">
    </div>


    </form>
</section>

<a href="admin-products.php">
    <button class='back_btn'>Tillbaka</button>
</a>
