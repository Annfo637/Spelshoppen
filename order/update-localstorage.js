//*******Lägger till produkter i localstorage*********** */

let cartBtn = document.querySelectorAll(".cart-btn");
let addToCartBtn = document.querySelectorAll(".add-to-cart");
let arrayToSend;

if (JSON.parse(localStorage.getItem("products")) !== null) {
  arrayToSend = JSON.parse(localStorage.getItem("products"));
} else {
  arrayToSend = [];
}

//Loopar över alla knappar med klassen cart-btn och lägger till eventlisteners
for (let j = 0; j < cartBtn.length; j++) {
  let product = cartBtn[j];

  cartBtn[j].addEventListener("click", function (e) {
    product = cartBtn[j];
    //Kollar på knappens parentElement som är själva produktkortet/diven som produkten ligger i
    let parent = product.parentElement;
    let prodTitle;
    let prodPrice;
    let prodQuantity;
    let prodId;
    let prodCartQuantity;
    let prodOutletPrice;

    prodTitle = parent.querySelector(".product_title");
    prodPrice = parent.querySelector(".hidden-price");
    prodQuantity = parent.querySelector(".hidden-quantity");
    prodId = parent.querySelector(".hidden-productid");
    prodCartQuantity = parent.querySelector(".cartQty");
    prodOutletPrice = parent.querySelector(".hidden-outletPrice");

    //kollar om input är tomt
    if (prodCartQuantity.value === "") {
      alert("Minst en produkt måste läggas till");
      return false;
    }

    if (prodOutletPrice !== null) {
      product = {
        cartQty: prodCartQuantity.value,
        title: prodTitle.textContent,
        outletprice: prodOutletPrice.textContent,
        price: prodPrice.textContent,
        quantity: prodQuantity.textContent,
        productid: prodId.textContent,
      };
    } else {
      product = {
        cartQty: prodCartQuantity.value,
        title: prodTitle.textContent,
        price: prodPrice.textContent,
        quantity: prodQuantity.textContent,
        productid: prodId.textContent,
      };
    }

    if (parseInt(product.cartQty) > parseInt(product.quantity)) {
      alert(
        "Det går inte att lägga till fler produkter än vad som finns i lager"
      );
      return false;
    } else if (parseInt(product.cartQty) <= 0) {
      alert("Minst en produkt måste läggas till");
      return false;
    }
    let checkproductQty = "";
    let sum = 0;
    let productSame;
    for (let j = 0; j < arrayToSend.length; j++) {
      if (arrayToSend[j].productid == product.productid) {
        checkproductQty = arrayToSend[j].cartQty;
        productSame = arrayToSend[j];
      }
    }
    if (checkproductQty != "") {
      let cartQ = productSame.cartQty;
      let productQ = product.cartQty;
      productSame.cartQty = parseInt(cartQ) + parseInt(productQ);
      if (productSame.cartQty > product.quantity) {
        alert(
          "Det går inte att lägga till fler produkter än vad som finns i lager, produkten finns redan i varukorgen"
        );
        return false;
      } else if (parseInt(product.cartQty) <= 0) {
        alert("Minst en produkt måste läggas till");
        return false;
      }
    } else {
      arrayToSend.push(product);
    }

    //skickar in arraYToSend till localstorage med nyckeln products.
    localStorage.setItem("products", JSON.stringify(arrayToSend));
  });
}

// INSERT INTO webshop_orderscomplete SELECT * FROM webshop_orders WHERE status = 2;

// DELETE FROM webshop_orders WHERE status = 2;
