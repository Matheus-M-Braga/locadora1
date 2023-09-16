// Arquivo responsável pela consulta AJAX e DataTable.

// Importar o arquivo jquery-3.1.0.js
import "https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js";

// Importar o arquivo jquery-3.7.0.js
import "https://code.jquery.com/jquery-3.7.0.js";

// Importar o arquivo jquery.dataTables.min.js
import "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js";

// Importar o arquivo dataTables.bootstrap5.min.js
import "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js";

// Consulta ajax
$(document).ready(function () {
  function loadDataFromServer() {
    var currentPage = window.location.pathname.split("/").pop().replace(".php", "");
    var baseUrl = "../php/";
    var url = baseUrl + "getdata" + currentPage + ".php";
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      success: function (data) {
        setupEditAndDeleteEvents(data);
      },
      error: function (xhr, status, error) {
        console.error(
          "Erro na solicitação AJAX: " + status + " - " + error + " - " + xhr
        );
      },
    });
  }
  function setupEditAndDeleteEvents(data) {
    $("#tabela").off("click", ".edit");
    $("#tabela").off("click", ".exclu");

    $("#tabela").on("click", ".edit", function () {
      var UserFields = new Array("id",
        "nome",
        "cidade",
        "endereco",
        "email"
      );
      var BookFields = new Array(
        "id",
        "nome",
        "autor",
        "editora",
        "lancamento",
        "quantidade"
      );
      var PublisherFields = new Array(
        "id",
        "nome",
        "cidade",
        "email",
        "telefone"
      );
      var RentalsFields = new Array(
        "id",
        "livro",
        "usuario",
        "data_aluguel",
        "data_previsao"
      );
      var fields;
      if (window.location.pathname.includes("user.php")) {
        fields = UserFields;
      } else if (window.location.pathname.includes("livro.php")) {
        fields = BookFields;
      } else if (window.location.pathname.includes("editora.php")) {
        fields = PublisherFields;
      } else if (window.location.pathname.includes("aluguel.php")) {
        fields = RentalsFields;
      }
      var id = $(this).data("id");
      var Entitydata = data[id]; 
      for (var i = 0; i < fields.length; i++) {
        var fieldName = fields[i];
        var fieldValue = Entitydata[fieldName];
        $("." + fieldName).val(fieldValue);
      }
    });
    $("#tabela").on("click", ".exclu", function () {
      var btnID = $(this).data("id");
      $(".confirm_exclu")
        .off("click")
        .on("click", function () {
          window.location.href = ".delete/delet-user.php" + "?id=" + btnID;
        });
    });
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
