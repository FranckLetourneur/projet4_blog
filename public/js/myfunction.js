function heightSection() {
    var hauteur = window.innerHeight;
    var maxHeightSection = hauteur - 184 - 44 - 16;
    var elt = document.getElementById('section');
    elt.style.minHeight = maxHeightSection + "px";
}


function inputCheck2(event) {
    var myRegEx = /<\s*.[^>]*>|<\s*\s*.>/g;
    var loc = event.target.id;
    if (document.getElementById(loc).value.match(myRegEx)) {
        document.getElementById(loc).classList.add('border-danger');
        document.getElementById('submitButton').setAttribute("disabled", "disabled");

        var aide = loc + 'Aide';
        document.getElementById(aide).classList.replace('hidden', 'show');
    }
    else {
        var aide = loc + 'Aide';
        document.getElementById(loc).classList.remove('border-danger');

        document.getElementById(aide).classList.replace('show', 'hidden');
    }

    var form = event.target.parentElement.parentElement;
    var test = 0;
    for (let i = 0; i <= form.length - 1; i++) {
        if (form[i].value.match(myRegEx) || form[i].value === ""){
            test++;
        }

    }

    if (test == 1) {
        document.getElementById('submitButton').removeAttribute("disabled");
    }
    else
    {
        document.getElementById('submitButton').setAttribute("disabled", "disabled");
    }

}

window.addEventListener('load', heightSection);
window.addEventListener('resize', heightSection);

document.addEventListener('input', (event) => {
    inputCheck2(event);
});