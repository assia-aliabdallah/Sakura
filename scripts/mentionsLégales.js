document.addEventListener('DOMContentLoaded', function () {
    var titreFooter = document.querySelector("footer h3"); //J'initialise les variables que je vais utiliser à savoir le titre 3 et le contenu à masquer
    var contenuFooter = document.querySelector(".content-footer");

    titreFooter.addEventListener("click", function () { //C'est un évènement qui se réalise au clique
        if (contenuFooter.style.display == "none") { //Si mon contenu n'est pas affiché je l'affiche
            contenuFooter.style.display = "block";
            document.querySelector('footer').scrollIntoView({ behavior: 'smooth', block: 'end' }); //et je descend dans le bas du footer
        } else {
            contenuFooter.style.display = "none"; //Sinon je le cache
            titreFooter.scrollIntoView({ behavior: 'smooth', block: 'end' }); //et je remonte au niveau du titre
        }
    });
});