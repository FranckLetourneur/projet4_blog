function heightSection (){
    console.log('pouet');
    var hauteur = window.innerHeight;
    var maxHeightSection = hauteur - 184 - 44 -16;
    var elt = document.getElementById('section');
    elt.style.minHeight = maxHeightSection + "px";
  

}

window.addEventListener('load', heightSection);
window.addEventListener('resize', heightSection);