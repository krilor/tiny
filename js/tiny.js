// Tiny toggle toggles the elements who's id is in the tiny-toggle attribute
const toggles = document.querySelectorAll('[tiny-toggle]');
for (var i = 0; i < toggles.length; i++) {
  toggles[i].onclick = function() {
    document.getElementById(this.getAttribute('tiny-toggle')).classList.toggle('active');
    
  }
}
