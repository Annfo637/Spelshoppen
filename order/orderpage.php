<?php
require_once '../second_header_extern.php';
require_once '../config/db.php';
?>

</header>
<main>

<!--Varukorgen-->
<section class="shopping_container">
  <section id="shoppingcart">

    <h1 class="page-title form-container__heading-text">Din varukorg</h1>

    <!--Här visas produkter i varukorgen via JS alternativt Varukorgen är tom.-->

    <h3 id="emptyCartText">Varukorgen är tom.</h3>
    <div class="shopping-btn"> <a href="../frontpage.php"><button id="shopping-btn">Börja shoppa!</button></a></div>

    <div id="shoppingCartContainer" class="hideCart">
      <section class='table_container'>
        <table class='table_orders'>

          <thead>
            <tr class='table_orders-row'>

              <th class='table_orders-head'>Produkt</th>
              <th class='table_orders-head'>Pris/st</th>
              <th class='table_orders-head'>Ta bort</th>
              <th class='table_orders-head' colspan="3">Antal</th>
            </tr>

          </thead>
          <tbody id="cartItems">
            <!--här jobbar drawCart()-->
          </tbody>
        </table>
        <button id="empty-cart" class="align-button-right">Töm varukorgen</button>
        <br>
        <br>
        <h3>Produktvärde totalt: <span id="productValue"></span> kr</h3>
        <br>
        <h3>Frakt: <span id="freightValue"></span> kr</h3>
        <br>
        <h3>Ordervärde totalt: <span id="orderValue"></span> kr</h3>

    </div>
    <br>
    <br>
  </section>

  <section id="order-form" class="form_container order-container hideCart">

    <h1 class="page-title form-container__heading-text">Dina uppgifter</h1>


    <form name="orderForm" action="send-order.php" method="POST" id="contact-form" class="form-container" onsubmit="return hiddenProducts()">

      <!--Hidden input-fields för de uppgifter som ska skickas med automatiskt,
      utan input från kunden -->
      <input type="hidden" id="products" name="products">
      <input type="hidden" id="freight" name="freight">
      <input type="hidden" id="totalprice" name="totalprice">
      <input type="hidden" name="status" id="status" value="1">

      <!--Input-fält som kunden fyller i-->
      <div class="order_field-name form-container__box">
        <label for="name">För- och efternamn:</label><br>
        <input type="text" name="name" id="name" onblur="validateName()" class="form-container__box-input" required>
        <br>
        <span class="nameValidationText"></span>
      </div>

      <div class="order_field-email form-container__box">
        <label for="email">E-post:</label><br>
        <input type="text" name="email" id="email" onblur="validateEmail()" class="form-container__box-input" placeholder="exempel@test.com" required>
        <br>
        <span class="emailValidationText"></span>
      </div>

      <div class="order_field-phone form-container__box">
        <label for="phone">Mobilnummer:</label><br>
        <input type="text" name="phone" id="phone" onblur="validatePhone()" class="form-container__box-input" placeholder="(ex. 0701234567)" required>
        <br>
        <span class="phoneValidationText"></span>
      </div>

      <div class="order_field-street form-container__box">
        <label for="street">Gatuadress:</label><br>
        <input type="text" name="street" id="street" onblur="validateStreet() " class="form-container__box-input" required>
        <br>
        <span class="streetValidationText"></span>
      </div>

      <div class="order_field-postalcode form-container__box">
        <label for="zip">Postnr:</label><br>
        <input type="text" name="zip" id="zip" oninput="validateZipcode()" placeholder="(ex. 123 45)" class="form-container__box-input" required>
        <br>
        <span class="zipcodeValidationText"></span>
      </div>

      <div class="order_field-city form-container__box">
        <label for="city">Ort:</label><br>
        <input type="text" name="city" id="city" onblur="validateCity()" class="form-container__box-input" required>
        <br>
        <span class="cityValidationText"></span>
      </div>

      <div class="order_field-submit form-container__submit">
        <input type="submit" value="Skicka beställning" class="form-container__submit-button" id="form-container__submit-button">

      </div>
    </form>

  </section>
</section>


<?php
require_once "../footer.php";
?>