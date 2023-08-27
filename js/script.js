/* Script Modal */
function abrirModal(carregarModal) {
  var modal = document.getElementById(carregarModal);
  modal.style.display = "block";
}

function fecharModal(fecharModal) {
  var modal = document.getElementById(fecharModal);
  modal.style.display = "none";
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
    cell.dataset.title = title;
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
}

// Máscaras 
