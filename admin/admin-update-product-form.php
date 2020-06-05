<!---Formulär för uppdatera produkt--->

<section class="form_container">

<h1 class="page-title form-container__heading-text">Uppdatera produkt</h1>
<?php 
echo $msg; ?>
<form action="#" method="POST" enctype="multipart/form-data" class="form-container">

<div class="product_field-name form-container__box">
<label for="title">Produkt namn: </label><br>
<input type="text" name="title"value='<?php echo $title; ?>' class="form-container__box-input" required>
</div>

<div class="product_field-price form-container__box">
<label for="price">Pris: </label><br>
<input type="text" name="price" value='<?php echo $price; ?>' class="form-container__box-input"required>
</div>

<div class="product_field-quantity form-container__box">
<label for="quantity">Ange lagerstatus: <br>
<input type="number" min="0" max="500" name="quantity" value='<?php echo $quantity; ?>' class="form-container__box-input">
</div>

<div class="product_field-category form-container__box">
<label for="category">Kategori: </label><br>
<select name="category" class="form-container__box-input">
<option value='<?php echo $product_categoryid;?>'><?php echo $product_category;?></option>
<?php echo $option_value; ?>

</select>
</div>
<div class="product_field-img form-container__image">
<label for="product-img">Ladda upp produktbild(MAX 5 Bilder): </label><br>
<input type="file" name="productimg[]" multiple="multiple" class="form-container__image-input">

</div>

</div>
<div class="product_field-description form-container__description">
<label for="description">Beskrivning: </label><br>
<textarea name="description" Placeholder="Beskrivning av produkt" class="form-container__description-input" cols="10" rows="8" maxlength="1000" id="description" onkeyup="countChar()"; onload='countChar()';><?php echo $description; ?></textarea>
<div id="text-count">1000 tecken kvar</div>
</div>

<div class="product_field-submit form-container__submit">
<input type="submit" name="submit" value="Uppdatera produkt" class="form-container__submit-button">
</div>
<input type="hidden" name="id" value="<?php echo $id ?>"> 


</form>
</section>

