filterCity();

//Filtrera på ort
function filterCity() {
  let inputCity = document.getElementById("input-city");
  let filter = inputCity.value.toUpperCase();
  let orderTable = document.getElementById("table-orders");
  let tr = orderTable.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    let td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      let txtValue = td.textContent || td.innerHTML;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
