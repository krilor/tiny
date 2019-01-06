// Tiny toggle toggles the elements who's id is in the tiny-toggle attribute
const tinyToggles = document.querySelectorAll('[tiny-toggle]');
for (var i = 0; i < tinyToggles.length; i++) {
  tinyToggles[i].onclick = function() {
    document.getElementById(this.getAttribute('tiny-toggle')).classList.toggle('active');
    
  }
}
