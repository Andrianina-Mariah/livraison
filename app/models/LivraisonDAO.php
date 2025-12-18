<?php

namespace app\models;

use app\models\Connexion;
use PDO;

class LivraisonDAO
{
    private $db;

    public function __construct()
    {
        // On récupère directement l'instance PDO depuis Connexion.php
        $this->db = Connexion::getConn();
    }

    // Créer une nouvelle livraison
    /**
     * Crée une nouvelle livraison et retourne l'objet Livraison créé
     */
    public function createLivraison(Livraison $livraison): Livraison
    {
        $sql = "INSERT INTO poste_livraison 
        (id_livreur, id_vehicule, id_colis, id_adresse, id_entrepot, statut, date_livraison) 
        VALUES 
        (:id_livreur, :id_vehicule, :id_colis, :id_adresse, :id_entrepot, :statut, :date_livraison)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_livreur' => $livraison->getId_livreur(),
            ':id_vehicule' => $livraison->getId_vehicule(),
            ':id_colis' => $livraison->getId_colis(),
            ':id_adresse' => $livraison->getId_adresse(),
            ':id_entrepot' => $livraison->getId_entrepot(),
            ':statut' => $livraison->getStatut(),
            ':date_livraison' => $livraison->getDateLivraison()
        ]);

        $id = $this->db->lastInsertId();
        $row = $this->getLivraisonById($id);

        // Transformer le tableau en objet Livraison
        return new Livraison(
            $row['id'],
            $row['id_livreur'],
            $row['id_vehicule'],
            $row['id_colis'],
            $row['id_adresse'],
            $row['id_entrepot'],
            $row['statut'],
            $row['date_livraison']
        );
    }
    public function updateStatutLivraison(int $id, string $status)
    {
        $sql = "UPDATE poste_livraison SET statut = :statut WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':statut' => $status,
            ':id' => $id
        ]);

        // Retourner la livraison mise à jour
        return $this->getLivraisonById($id);
    }

    // Récupérer toutes les livraisons avec infos complètes
    public function getAllLivraisons()
    {
        $sql = "SELECT * FROM view_livraisons_completes ORDER BY date_livraison ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getLivraisonById($id)
    {
        $sql = "SELECT *
                FROM view_livraisons_completes
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM poste_livraison WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => (int)$id
        ]);

        return $stmt->rowCount();
    }



    // Calcul du chiffre d'affaires global
    public function calculChiffreAffaire()
    {
        $sql = "SELECT SUM(montantRecette) AS total_ca FROM poste_livraison WHERE statut='livré'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_ca'] ?? 0;
    }

    // Calcul du coût de revient global
    public function calculCoutRevient()
    {
        $sql = "SELECT SUM(cout_revient) AS total_cout FROM poste_livraison WHERE statut='livré'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_cout'] ?? 0;
    }

    // Bénéfice par jour
    public function beneficeParJour()
    {
        $sql = "SELECT * FROM view_chiffre_affaire_jour ORDER BY date_livraison DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bénéfice par mois
    public function beneficeParMois()
    {
        $sql = "SELECT * FROM view_chiffre_affaire_mois ORDER BY mois DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bénéfice par année
    public function beneficeParAnnee()
    {
        $sql = "SELECT * FROM view_chiffre_affaire_annee ORDER BY annee DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Livraisons par chauffeur
    public function livraisonsParChauffeur()
    {
        $sql = "SELECT * FROM view_livraisons_par_chauffeur ORDER BY benefice ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllColis()
    {
        $stmt = $this->db->query("SELECT id, libelle FROM poste_colis ORDER BY libelle ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllChauffeurs()
    {
        $stmt = $this->db->query("SELECT id, nom FROM poste_livreur ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllVehicules()
    {
        $stmt = $this->db->query("SELECT id, immatriculation FROM poste_vehicule ORDER BY immatriculation ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
