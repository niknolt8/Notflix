// Récupérer les boutons de filtre
const boutons = document.querySelectorAll(".filter-btn");

// Récupérer toutes les cartes qui possèdent data-genre
const cartes = document.querySelectorAll(".card[data-genre]");


// Pour chaque bouton
boutons.forEach(function (bouton) {

    bouton.addEventListener("click", function () {

        // Genre choisi
        const genre = bouton.dataset.genre;


        // Parcourir toutes les cartes
        cartes.forEach(function (carte) {

            const genreCarte = carte.dataset.genre;


            // Si "Tous", afficher toutes les cartes
            if (genre === "Tous") {

                carte.style.display = "";

            }

            // Si le genre correspond
            else if (genreCarte === genre) {

                carte.style.display = "";

            }

            // Sinon cacher la carte
            else {

                carte.style.display = "none";

            }

        });


        // Retirer active de tous les boutons
        boutons.forEach(function (btn) {

            btn.classList.remove("active");

        });


        // Mettre active sur le bouton cliqué
        bouton.classList.add("active");

    });

});