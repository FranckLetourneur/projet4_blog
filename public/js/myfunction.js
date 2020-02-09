function heightSection (){
    var hauteur = window.innerHeight;
    var maxHeightSection = hauteur - 184 - 44 -16;
    var elt = document.getElementById('section');
    elt.style.minHeight = maxHeightSection + "px";
}

function inputCheck(event, loc){
    var myRegEx = /<\s*.[^>]*>|<\s*\s*.>/g;

    if (document.getElementById(loc).value.match(myRegEx)) {
        document.getElementById(loc).classList.add('border-danger');
        document.getElementById('submitComment').setAttribute("disabled", "disabled");
        if (loc == 'pseudoId') {
            document.getElementById('pseudoAide').classList.replace('hidden', 'show');
        } else if (loc == 'commentaire'){
            document.getElementById('commentaireAide').classList.replace('hidden', 'show');
        }
       
    }
    else {
        if (loc == 'pseudoId') {
            document.getElementById('pseudoAide').classList.replace('show', 'hidden');
            document.getElementById('pseudoId').classList.remove('border-danger');
        } else if (loc == 'commentaire'){
            document.getElementById('commentaireAide').classList.replace('show', 'hidden');
            document.getElementById('commentaire').classList.remove('border-danger');
        }
    }
     if (!document.getElementById('pseudoId').value.match(myRegEx) && !document.getElementById('commentaire').value.match(myRegEx)) {
         document.getElementById('submitComment').removeAttribute("disabled");
     }
}


window.addEventListener('load', heightSection);
window.addEventListener('resize', heightSection);

document.getElementById('pseudoId').addEventListener('input', (event) => {
    inputCheck(event, 'pseudoId');
});

document.getElementById('commentaire').addEventListener('input', (event) => {
    inputCheck(event, 'commentaire');
});
