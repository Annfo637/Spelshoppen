hiddenProducts();
function hiddenProducts() {
  let totalOrderPrice = localStorage.getItem("totalprice");
  console.log(totalOrderPrice);
  let freightPrice = localStorage.getItem("freight");

  let newArray = [];
  const productInput = document.querySelector("#products");
  const totalPriceInput = document.querySelector("#totalprice");
  const freightInput = document.querySelector("#freight");

  for (let i = 0; i < myProducts.length; i++) {
    newArray.push(myProducts[i]);
  }
  totalPriceInput.value = totalOrderPrice;
  freightInput.value = freightPrice;
  productInput.value = JSON.stringify(newArray);
}
