/* Modal */
function abrirModal(modalId, action) {
  var modal = document.getElementById(modalId);
  modal.style.display = "block";

  var title = document.getElementById("modalTitle");
  title.textContent = action + " " + GetPageName().slice(0, -1);

  var form = document.getElementById("form");
  var currentPage = window.location.pathname.split("/").pop();
  var select = document.getElementById("select");
  var disabledOption = Object.assign(document.createElement("option"), {
    value: "",
    innerText: "Selecione:",
    selected: true,
    disabled: true,
  });
  var selectedOption = Object.assign(document.createElement("option"), {
    selected: true,
    className: "editora",
  });
  if (action === "Cadastrar") {
    form.action = ".create/create" + currentPage;
    if (select) {
      select.classList.remove("is-valid");
      select.classList.add("is-invalid");

      $.ajax({
        url: "../php/getregistersdata.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
          var publishersList = data["Publisher"];

          select.innerHTML = "";
          select.appendChild(disabledOption);

          var keys = Object.keys(publishersList);
          for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            var option = document.createElement("option");

            option.textContent = publishersList[key].nome;
            select.appendChild(option);
          }
        },
        error: function (xhr, status, error) {
          console.error(
            "Erro na solicitação AJAX: " + status + " - " + error + " - " + xhr
          );
        },
      });
    }
  } else if (action === "Editar") {
    form.action = ".update/update" + currentPage;
    if (select) {
      select.classList.add("is-valid");
      select.classList.remove("is-invalid");

      select.innerHTML = "";
      select.appendChild(selectedOption);
    }
  }
}

function fecharModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = "none";
  this.resetForm(modalId);

  // Conforme vai abrindo o modal de editar, os options da editora vão se multiplicando.
  // Isso limpa todos com exceção do primeiro, que é correspondente ao livro.
  // São adicionados quando o modal é aberto novamente.
  var select = document.getElementById("select");
  while (select.children.length > 1) {
    select.removeChild(select.children[1]);
  }
}

// Dropdown
window.addEventListener("resize", function () {
  var dropdownContent = document.getElementById("dropdownContent");
  dropdownContent.style.display = "none";
});
function toggleDropdown() {
  var dropdownContent = document.getElementById("dropdownContent");
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
  }
}

// preenchimento dos itens com data-title
const tableHeaders = document.querySelectorAll(".titulos");
const tableRows = document.querySelectorAll("tbody tr");

tableRows.forEach((row) => {
  const cells = row.querySelectorAll(".itens");
  cells.forEach((cell, index) => {
    const title = tableHeaders[index].textContent;
    if (cell.textContent !== "Nenhum registro encontrado") {
      cell.dataset.title = title.replace("arrow_drop_down", "");
    }
  });
});

// Validação
(function () {
  "use strict";
  var forms = document.querySelectorAll(".needs-validation");
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// Reset
function resetForm(modalId) {
  var form = document.querySelector(`#${modalId} form`);
  form.classList.remove("was-validated");
  if (modalId === "modal") {
    form.reset();
  }
}

// Nome da página pra gerar o header
function GetPageName() {
  var titulo = document.getElementById("pageTitle");
  return titulo.textContent;
}

// Monta o header da tabela
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    var gridHeader = document.querySelector(".grid-header");

    if (gridHeader) {
      var wrapper = document.createElement("div");
      wrapper.className = "wrapper";

      var tituloPg = document.createElement("span");
      tituloPg.className = "titulo-pg";
      tituloPg.textContent = GetPageName();

      var novoBtn = document.createElement("div");
      novoBtn.className = "novobtn";
      novoBtn.textContent = "NOVO";
      novoBtn.addEventListener("click", function () {
        abrirModal("modal", "Cadastrar");
        resetForm("modal");
      });

      var plusIcon = document.createElement("span");
      plusIcon.className = "material-symbols-outlined";
      plusIcon.textContent = "add";

      novoBtn.appendChild(plusIcon);
      wrapper.appendChild(tituloPg);
      wrapper.appendChild(novoBtn);
      gridHeader.appendChild(wrapper);
    } else {
      // a classe .grid-header não foi achada (tenso)
    }
  }, 100);
});
