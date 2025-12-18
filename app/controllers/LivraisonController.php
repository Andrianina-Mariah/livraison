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
    $colisList = $this->dao->getAllColis();          // méthode à créer dans DAO
    $chauffeurList = $this->dao->getAllChauffeurs(); // méthode à créer dans DAO
    $vehiculeList = $this->dao->getAllVehicules();   // méthode à créer dans DAO

    // Passer les listes à la vue
    Flight::render('livraison_create', [
        'colisList' => $colisList,
        'chauffeurList' => $chauffeurList,
        'vehiculeList' => $vehiculeList
    ]);
}

    // Sauvegarder une nouvelle livraison
    public function store(): void
    {
        $data = Flight::request()->data->getData();
    
        // // Afficher les IDs reçus pour debug
        // var_dump(
        //     $data['id_colis'] ?? null,
        //     $data['id_livreur'] ?? null,
        //     $data['id_vehicule'] ?? null
        // );
        // die(); // stoppe le script pour voir le résultat
    
        // Créer un objet Livraison à partir des données reçues
        $livraison = new Livraison(
            null,
            $data['id_colis'],
            $data['id_livreur'],
            $data['id_vehicule'],
            $data['id_entrepot'],
            $data['id_adresse'],
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
