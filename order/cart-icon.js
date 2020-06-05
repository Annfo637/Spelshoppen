let counters = document.querySelector("#counter");
let btn1 = document.querySelectorAll(".cart-btn");
let btnLess = document.querySelectorAll(".delete");
let products;
products = JSON.parse(localStorage.getItem("products"));

for (let i = 0; i < btn1.length; i++) {
  btn1[i].addEventListener("click", updateCartCount);
}

for (let j = 0; j < btnLess.length; j++) {
  btnLess[j].addEventListener("click", updateCartCount);
}

updateCartCount();

function updateCartCount() {
  let products;
  let cartValue = 0;
  let sum = 0;
  if (JSON.parse(localStorage.getItem("products")) !== null) {
    products = JSON.parse(localStorage.getItem("products"));
    for (let x = 0; x < products.length; x++) {
      let cartValue = products[x].cartQty;
      sum += parseInt(cartValue);
    }

    counters.textContent = sum;
  } else {
    products = 0;
    counters.textContent = products;
  }
}
