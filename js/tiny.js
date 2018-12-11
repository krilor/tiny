var menuToggle = document.getElementById('primary-menu-toggle');
var menu = document.getElementById('primary-menu');

menuToggle.onclick = function() {
  menu.classList.toggle('active');
}