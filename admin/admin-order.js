filterOrders()
//Filtrera på beställningsstatus
function filterOrders() {

    let orderStatus = document.getElementById("show_order-status");
    let orderStatusForm = document.getElementById("order-status_form")

    orderStatusForm.addEventListener("input", function (event) {
        location.href = "../admin/admin-order.php?id=" + orderStatus.value
    })
}
/////////



/////////Sortera på status
let sortStatus = document.querySelector("#sort-status")
sortStatus.addEventListener("click", function (event) {
    event.preventDefault();
    sort(6, sortStatus)
})

//////////Sortera på summa
let sortSum = document.querySelector("#sort-sum")
sortSum.addEventListener("click", function (event) {
    event.preventDefault();
    sort(4, sortSum)
});

////////////sortera på datum
let sortDate = document.querySelector("#sort-date")
sortDate.addEventListener("click", function (event) {
    event.preventDefault();

    sort(5, sortDate)
});

function sort(num, caller) {
    let table = document.getElementById("table-orders")
    let rows, x, y, i, z, o, switching, shouldSwitch, dir;
    let switchcount = 0;
    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.rows
        for (i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[num];
            y = rows[i + 1].getElementsByTagName("td")[num];

            if (caller === sortSum) {
                z = Number(x.innerHTML);
                o = Number(y.innerHTML)
            } else if (caller === sortStatus) {
                z = x.innerHTML.toLowerCase()
                o = y.innerHTML.toLowerCase()
            } else if (caller === sortDate) {
                z = new Date(x.innerHTML)
                o = new Date(y.innerHTML)
                z = z.getTime();
                o = o.getTime();
            }
            if (dir == "asc") {
                if (z > o) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (z < o) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}