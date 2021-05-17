var myVar;

function loader() {
    myVar = setTimeout(showPage, 2000);
}

function showPage() {
  document.getElementById("loading").style.display = "none";
  document.getElementById("page-contents").style.display = "block";
}