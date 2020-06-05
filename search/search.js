let searchResult = document.querySelector("#searched-result");
let searchField = document.querySelector("#search-Field");
let searchBtn = document.querySelector("#search_btn");
let searchLink = document.querySelector("#search-link");
let searchForm = document.querySelector("#search-form");
let output = new Array();
let productId = new Array();

// anropa ajax
let ajax = new XMLHttpRequest();

//let url = "read.php";
ajax.open("GET", "../search/read.php", true);
//skicka ajax request
ajax.send();
//ta emot svar från php fil
ajax.onreadystatechange = function () {
  if (this.readyState === 4 && this.status === 200) {
    //konvertera JSON tillbaka till array
    let games = JSON.parse(this.responseText);
    let gamesTitle = new Array();

    for (let i = 0; i < games.length; i++) {
      gamesTitle.push(games[i].title);
    }

    function validate(input) {
      let re = /[^a-zåäöA-Zåäö0-9 ]/i;
      return re.test(input);
    }

    //eventlistener på sökfältt
    searchField.addEventListener("input", function (event) {
      emptySearch();
      //eventlistener på formulär, skickar id istället för form value
      searchForm.addEventListener("submit", function (event) {
        event.preventDefault();

        //valideringar
        if (searchField.value.length < 2) {
          searchResult.innerHTML = "OBS! Du måste skriva mer än 2 bokstäver";
        } else if (searchField.value.length > 20) {
          searchResult.innerHTML = "OBS! Max 20 bokstäver tillåtet"
        } else if (!isNaN(searchField.value)) {
          searchResult.innerHTML = "OBS! Endast text tillåtet";
        } else if (validate(searchField.value)) {
          searchResult.innerHTML = "OBS! Otillåten sökning";
        }
        else {
          location.href = "../search/index.php?id=" + productId;
        }

      })

      //minst två tecken validering
      if (searchField.value.length >= 2) {
        filter();
      } else {
        searchResult.innerHTML = null;
      }
    });


    //filtrerar och loopar igenom titel och beskrivning föra tt hitta matchning
    //om matchning hittas - skickas vidare för att ritas ut
    function filter() {
      let searchedGame = gamesTitle.filter(function (game) {
        return game.toLowerCase().includes(searchField.value.toLowerCase());
      });

      //töm båda arrayerna varje gång tanget trycks, annars ritas inte förfinade sökningen om
      output.splice(0, output.length);
      productId.splice(0, productId.length);

      for (let i = 0; i < games.length; i++) {
        for (let j = 0; j < searchedGame.length; j++) {
          if (
            games[i].title === searchedGame[j]
          ) {
            if (productId.includes(games[i].productid)) {
              display(productId, output);
            } else {
              output.push(
                " | " + games[i].title + " " + games[i].price + " kr " + " | "
              );
              productId.push(games[i].productid);
            }
          }
        }
      }
    }

    function display() {
      //töm div innerhtml för att kunna rita om när en förfinad sökning görs
      searchResult.innerHTML = " ";

      for (let i = 0; i < output.length; i++) {
        let listedGames = document.createElement("a");
        listedGames.textContent = output[i];
        listedGames.href = "../product/product_info.php?id= " + productId[i];
        listedGames.id = productId[i];

        //kontroll av id på a-tagg - om den finns rita inte ut en ny
        let element = document.getElementById(productId[i]);
        if (element !== null) {
        } else {
          searchResult.appendChild(listedGames);
        }
      }
    }
  }

  function emptySearch() {
    if (searchField.value === "") {
      output.splice(0, output.length);
      productId.splice(0, productId.length);
    }
  }
};
