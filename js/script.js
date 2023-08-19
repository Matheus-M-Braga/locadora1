/* Script Modal */
function abrirModal(carregarModal) {
    var modal = document.getElementById(carregarModal)
    modal.style.display = "block"
}

function fecharModal(fecharModal) {
    var modal = document.getElementById(fecharModal)
    modal.style.display = "none"
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

tableRows.forEach(row => {
    const cells = row.querySelectorAll(".itens");
    cells.forEach((cell, index) => {
        const title = tableHeaders[index].textContent;
        cell.dataset.title = title;
    });
});