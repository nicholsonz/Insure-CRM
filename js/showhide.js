
// Onclick show/hide tables /////////////////////////////////////////////////////////////
let btn = document.getElementById("showhide");
btn.onclick = function myFunction() {
  let t = document.getElementById("show");
  -1 == t.className.indexOf("w3-show")
    ? (t.className += " w3-show")
    : (t.className = t.className.replace(" w3-show", ""));
}
// Onclick show/hide tables - 2nd Occurrence on same page
let btn2 = document.getElementById("showhide2");
btn2.onclick = function myFunction() {
  let t = document.getElementById("show2");
  -1 == t.className.indexOf("w3-show")
    ? (t.className += " w3-show")
    : (t.className = t.className.replace(" w3-show", ""));
}
// Onclick show/hide tables
let btn3 = document.getElementById("showhide3");
btn3.onclick = function myFunction() {
  let t = document.getElementById("show3");
  -1 == t.className.indexOf("w3-show")
    ? (t.className += " w3-show")
    : (t.className = t.className.replace(" w3-show", ""));
}
