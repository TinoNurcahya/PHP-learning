const keyword = document.getElementById("keyword");
const dataTable = document.getElementById("dataTable");

keyword.addEventListener("input", () => {
  let value = keyword.value.trim();

  fetch("search_ajax.php?keyword=" + encodeURIComponent(value))
    .then(res => res.text())
    .then(data => {
      dataTable.innerHTML = data;
    })
    .catch(err => console.error(err));
});