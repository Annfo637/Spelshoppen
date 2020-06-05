//Öppnar ett skriv-ut-fönster vid klick på Skriv-ut-knappen
const printOrderBtn = document.querySelector("#print-order-btn")
printOrderBtn.addEventListener("click", function () {
	window.print()
})

//Tömmer localstorage och varukorgen
localStorage.clear()
updateCartCount()
