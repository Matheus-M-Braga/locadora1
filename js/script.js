/* Modal */
function abrirModal(carregarModal) {
  var modal = document.getElementById(carregarModal);
  modal.style.display = "block";
}

function fecharModal(fecharModal) {
  var modal = document.getElementById(fecharModal);
  modal.style.display = "none";

  // Conforme vai abrindo o modal de editar, os options da editora vão se multiplicando. Isso limpa todos com exceção do primeiro, que é correspondente ao livro. São adicionados quando o modal é aberto novamente.
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
  if (modalId === "vis-modal") {
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
        abrirModal("vis-modal");
        resetForm("vis-modal");
      });

      var plusIcon = document.createElement("span");
      plusIcon.className = "material-symbols-outlined";
      plusIcon.textContent = "add";

      novoBtn.appendChild(plusIcon);
      wrapper.appendChild(tituloPg);
      wrapper.appendChild(novoBtn);
      gridHeader.appendChild(wrapper);
    } else {
      console.error("Elemento .grid-header não encontrado.");
    }
  }, 100);
});
