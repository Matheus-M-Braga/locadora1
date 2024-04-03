import "https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js";
import "https://code.jquery.com/jquery-3.7.0.js";
import "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js";
import "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js";

// Consulta ajax
// Tabelas
$(document).ready(function () {
  function loadDataFromServer() {
    $.ajax({
      url: "php/getEntitiesData.php",
      type: "GET",
      dataType: "json",
      success: function (data) {
        var entity = window.location.pathname
          .split("/")
          .pop()
          .replace(".php", "");
        setupEditAndDeleteEvents(data[entity], data);
      },
      error: function (xhr, status, error) {
        console.error(
          "Erro na solicitação AJAX: " + status + " - " + error + " - " + xhr
        );
      },
    });
  }
  function setupEditAndDeleteEvents(data, data2) {
    $("#tabela").off("click", ".edit");
    $("#tabela").off("click", ".exclu");
    $("#tabela").off("click", ".devol");

    $("#tabela").on("click", ".edit", function () {
      var UserFields = new Array("id", "nome", "cidade", "endereco", "email");
      var BookFields = new Array(
        "id",
        "nome",
        "autor",
        "editora_id",
        "lancamento",
        "quantidade"
      );
      var PublisherFields = new Array("id", "nome", "cidade", "email");
      var RentalsFields = new Array(
        "id",
        "livro",
        "usuario",
        "data_aluguel",
        "data_previsao"
      );
      var fields;
      if (window.location.pathname.includes("User.php")) {
        fields = UserFields;
      } else if (window.location.pathname.includes("Book.php")) {
        fields = BookFields;
      } else if (window.location.pathname.includes("Publisher.php")) {
        fields = PublisherFields;
      } else if (window.location.pathname.includes("Rental.php")) {
        fields = RentalsFields;
      }

      var id = $(this).data("id");
      var Entitydata = data[id];
      for (var i = 0; i < fields.length; i++) {
        var fieldName = fields[i];
        var fieldValue = Entitydata[fieldName];

        // Exceção para o campo de editora, que é um select
        if (fieldName === "editora_id") {
          (function (fieldName, fieldValue) {
            // Criando uma função anônima para capturar o valor atual de fieldName
            $.ajax({
              url: "../php/getEntitiesData.php",
              type: "GET",
              dataType: "json",
              success: function (data) {
                fillPublisher(data.Publisher, fieldName, fieldValue);
                fillPublisherSelectOptions(fieldValue, data2);
              },
              error: function (status, error) {
                console.error(
                  "Erro na solicitação AJAX: " + status + " - " + error
                );
              },
            });
          })(fieldName, fieldValue);
        } else {
          $("." + fieldName).val(fieldValue);
        }
      }
      function fillPublisher(publisher, fieldName, fieldValue) {
        $("." + fieldName).text(publisher[fieldValue]["nome"]);
        $("." + fieldName).val(publisher[fieldValue]["nome"]);
      }
    });

    $("#tabela").on("click", ".exclu", function () {
      var btnID = $(this).data("id");
      $(".confirm_exclu")
        .off("click")
        .on("click", function () {
          var currentPage = window.location.pathname
            .split("/")
            .pop()
            .replace(".php", "");
          window.location.href =
            ".delete/delete" + currentPage + ".php" + "?id=" + btnID;
        });
    });
    // Devolução (Aluguel)
    $("#tabela").on("click", ".devol", function () {
      var btnID = $(this).data("id");
      $(".confirm_devol")
        .off("click")
        .on("click", function () {
          var currentPage = window.location.pathname
            .split("/")
            .pop()
            .replace(".php", "");
          window.location.href =
            ".update/update" + currentPage + ".php" + "?id=" + btnID;
        });
    });
  }
  function fillPublisherSelectOptions(fieldValue, data) {
    var publishersList = data["Publisher"];
    var select = document.getElementById("select");
    var selected = fieldValue; // Esse parâmetro é passado pra pegar a editora do livro correspondente e comparar com a listagem pra não duplicar as opções (foda)

    var keys = Object.keys(publishersList);
    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var option = document.createElement("option");
      if (publishersList[key].id === selected) {
      } else {
        option.textContent = publishersList[key].nome;
        select.appendChild(option);
      }
    }
  }
  loadDataFromServer();
});

// DataTable
$(document).ready(function () {
  $("#tabela").DataTable({
    language: {
      sEmptyTable: "Nenhum registro encontrado",
      sInfo: "",
      sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
      sInfoFiltered: "(Filtrados de _MAX_ registros)",
      sInfoPostFix: "",
      sInfoThousands: ".",
      sLengthMenu: "Registros por página: _MENU_",
      sLoadingRecords: "Carregando...",
      sProcessing: "Processando...",
      sZeroRecords: "Nenhum registro encontrado",
      sSearch:
        "<span class='material-symbols-outlined' style='vertical-align: middle; color: grey;'>search</span>",
      oPaginate: {
        sNext: ">",
        sPrevious: "<",
        sFirst: "<<",
        sLast: ">>",
      },
      oAria: {
        sSortAscending: ": Ordenar colunas de forma ascendente",
        sSortDescending: ": Ordenar colunas de forma descendente",
      },
      select: {
        rows: {
          _: "Selecionado %d linhas",
          0: "Nenhuma linha selecionada",
          1: "Selecionado 1 linha",
        },
      },
    },
    dom: '<"grid-header"f>rt<"bottom"lp>',
    lengthMenu: [5, 10, 15, 30],
  });
});
