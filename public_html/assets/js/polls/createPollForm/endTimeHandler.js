var endDateYes = document.getElementById("endDateYes");
var endDateNo = document.getElementById("endDateNo");
var anketsure = document.getElementById("anketsure");

endDateYes.addEventListener("click", function() {
  anketsure.style.display = "block";
});

endDateNo.addEventListener("click", function() {
  anketsure.style.display = "none";
  anketsure.value = "";
});