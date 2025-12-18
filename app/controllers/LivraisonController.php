<?php

namespace app\controllers;

use Flight;
use app\models\LivraisonDAO;
use app\models\Livraison;

class LivraisonController
{
    private LivraisonDAO $dao;

    public function __construct()
    {
        $this->dao = new LivraisonDAO();
    }

    public function index(): void
    {
        $livraisons = $this->dao->getAllLivraisons();
        Flight::render('livraison_list', ['livraisons' => $livraisons]);
    }

    public function create(): void
{
    // Récupérer les listes depuis le DAO
    $chauffeurList = $this->dao->getAllChauffeurs(); // méthode à créer dans DAO
    $vehiculeList = $this->dao->getAllVehicules();   // méthode à créer dans DAO
    $typeColisList = $this->dao->getAllTypeColis();
    $entrepotList = $this->dao->getAllEntrepots();
    $adresseList = $this->dao->getAllAdresse();
    Flight::render('livraison_create', [
        'typeColisList' => $typeColisList,
        'chauffeurList' => $chauffeurList,
        'vehiculeList' => $vehiculeList,
        'entrepotList' => $entrepotList,
        'adresseList' => $adresseList
    ]);

}

    // Sauvegarder une nouvelle livraison
    public function store(): void
    {
        $data = Flight::request()->data->getData();

        // 1️⃣ récupérer le prix/kg du type
        $stmt = $this->dao->getDb()->prepare(
            "SELECT prix_kg FROM poste_type_colis WHERE id = :id"
        );
        $stmt->execute(['id' => $data['id_type_colis']]);
        $prixKg = $stmt->fetchColumn();

        // 2️⃣ calcul prix total
        $prixTotal = $data['poids'] * $prixKg;

        // 3️⃣ créer le colis
        $stmt = $this->dao->getDb()->prepare(
            "INSERT INTO poste_colis (libelle, poids, id_type_colis, prix_total)
            VALUES (:libelle, :poids, :id_type, :prix)"
        );
        $stmt->execute([
            'libelle' => $data['libelle'],
            'poids' => $data['poids'],
            'id_type' => $data['id_type_colis'],
            'prix' => $prixTotal
        ]);

        $idColis = $this->dao->getDb()->lastInsertId();

        // 4️⃣ créer la livraison
        $livraison = new Livraison(
            null,
            $data['chauffeur_id'],
            $data['vehicule_id'],
            $idColis,
            $data['adresse_depart'],
            $data['adresse_arrivee'],
            $data['statut'],
            $data['date_livraison']
        );

        $this->dao->createLivraison($livraison);

        Flight::redirect('/livraisons');
    }

    public function detail(): void
    {
        $livraison = $this->dao->getLivraisonById($id);

        Flight::render('livraison_detail', ['livraison' => $livraison]);
    }
    

    // Afficher le formulaire de modification
    public function edit(int $id): void
    {
        $livraison = $this->dao->getLivraisonById($id);
        Flight::render('edit', ['livraison' => $livraison]);
    }

    // Mettre à jour le statut
    public function update(int $id): void
    {
        $data = Flight::request()->data->getData();
        $status = $data['statut'] ?? null;

        if ($status !== null) {
            $this->dao->updateStatutLivraison($id, $status);
        }

        Flight::redirect('/livraisons');
    }
    public function delete(int $id): void
    {
        $this->dao->deleteById($id);
        Flight::redirect('/livraisons');
    }
}
