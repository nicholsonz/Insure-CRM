// Open and close sidebar
let btnopen = document.getElementById("w3open");
btnopen.onclick = function w3open() {
  document.getElementById("mySidebar").style.display = "block";
}
let btnclose = document.getElementById("w3close");
btnclose.onclick = function w3close() {
  document.getElementById("mySidebar").style.display = "none";
}
