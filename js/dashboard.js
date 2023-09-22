// Gerar os gráfico foda e os card
import "https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js";
import "https://code.jquery.com/jquery-3.7.0.js";
import "https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js";

$(document).ready(function () {
  function loadDataFromServer() {
    $.ajax({
      url: "../php/getdatadashboard.php",
      type: "GET",
      dataType: "json",
      success: function (DashData) {
        console.log(DashData);
        GenerateCharts(DashData);
        GetCardsData(DashData);
      },
      error: function (xhr, status, error) {
        console.error(
          "Erro na solicitação AJAX: " + status + " - " + error + " - " + xhr
        );
      },
    });
  }
  function GenerateCharts(DashData) {
    // BarChart
    const BarChart = document.getElementById("grafico01");
    const noDataInfo = document.getElementById("grafico1Warnning");
    var BarInfo = DashData["mostRented"];
    var Barlabels = BarInfo["nomes"];
    var Bardata = BarInfo["infos"];

    if (Barlabels == null || Bardata == null) {
      noDataInfo.style.display = "block";
    } else {
      new Chart(BarChart, {
        type: "bar",
        data: {
          labels: Barlabels,
          datasets: [
            {
              label: "",
              data: Bardata,
              backgroundColor: [
                "rgba(128, 0, 0)",
                "rgb(65, 69, 94)",
                "rgb(182, 143, 43)",
              ],
              borderWidth: 0,
            },
          ],
        },
        options: {
          plugins: {
            legend: {
              display: false,
            },
            title: {
              display: true,
              text: 'Livros Mais Alugados',
              color: 'rgb(87, 87, 87)',
              font: {
                size: 30, 
                weight: 'bold', 
                family: 'Arial, sans-serif', 
              },
            },
          },
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    }

    // PieChart
    const PieChart = document.getElementById("grafico02");
    const noDataInfo2 = document.getElementById("grafico1Warnning");
    var PieInfo = DashData["rentalStatus"];
    var Piedata = [
      PieInfo["pendentes"],
      PieInfo["noprazo"],
      PieInfo["atrasados"],
    ];
    
    if (PieInfo == null || Piedata == null) {
      noDataInfo2.style.display = "block";
    } else {
      new Chart(PieChart, {
        type: "pie",
        data: {
          labels: ["Pendentes", "No prazo", "Atrasados"],
          datasets: [
            {
              label: "",
              data: Piedata,
              backgroundColor: [
                "rgb(182, 143, 43)",
                "rgb(0, 110, 0)",
                "rgba(110, 0, 0)",
              ],
              borderColor: [
                "rgb(182, 143, 43)",
                "rgb(0, 110, 0)",
                "rgba(110, 0, 0)",
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          plugins: {
            legend: {
              display: true,
            },
            title: {
              display: true,
              text: 'Status De Aluguéis',
              color: 'rgb(87, 87, 87)',
              font: {
                size: 30, 
                weight: 'bold', 
                family: 'Verdana, sans-serif', 
              },
            },
          },
          scales: {
            y: {
              display: false,
            },
          },
        },
      });
    }
  }
  function GetCardsData(DashData) {
    var cardIds = ["lastRented", "usersCount", "booksCount", "publishersCount"];

    cardIds.forEach(function (cardId) {
      var card = document.getElementById(cardId);
      var cardData = DashData[cardId];
      var cardContent = card.querySelector(".content");
      var aviso = card.querySelector(".aviso");

      if (cardContent && aviso) {
        if (
          cardData !== undefined &&
          cardData !== null &&
          cardData !== "" &&
          cardData != 0
        ) {
          cardContent.textContent = cardData;
          aviso.style.display = "none";
        } else {
          cardContent.textContent = "";
          aviso.style.display = "block";
        }
      }
    });
  }
  loadDataFromServer();
});
