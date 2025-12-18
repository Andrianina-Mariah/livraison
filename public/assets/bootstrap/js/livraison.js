function supprimerLivraison(element) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette livraison ?")) {
        // element = le bouton sur lequel on clique
        const row = element.closest("tr"); // trouve la ligne parente
        row.remove(); // supprime la ligne du tableau
        alert("Livraison supprimée visuellement !");
    }
}

// Fonction pour modifier visuellement une ligne (exemple simple)
function modifierLivraison(element) {
    if (confirm("Êtes-vous sûr de vouloir modifier cette livraison ?")) {
        const row = element.closest("tr");
        // Exemple : changer le statut en "en attente" pour montrer la modification
        const statutCell = row.querySelector("td:nth-child(7) span"); // 7ème colonne = statut
        statutCell.textContent = "modifié";
        statutCell.className = "badge bg-info"; // changer le badge en bleu
        alert("Livraison modifiée visuellement !");
    }
}
