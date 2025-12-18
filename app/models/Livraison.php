<?php

namespace app\models;

class Livraison
{
    private $id;
    private $id_livreur;
    private $id_vehicule;
    private $id_colis;
    private $id_adresse;
    private $id_entrepot;
    private $statut;
    private $date_livraison;
    private $montantRecette;

    /**
     * Constructeur pour créer un objet Livraison
     */
    public function __construct(
        $id = null,
        $id_livreur = null,
        $id_vehicule = null,
        $id_colis = null,
        $id_adresse = null,
        $id_entrepot = null,
        $statut = null,
        $date_livraison = null,
    ) {
        $this->id = $id;
        $this->id_livreur = $id_livreur;
        $this->id_vehicule = $id_vehicule;
        $this->id_colis = $id_colis;
        $this->id_adresse = $id_adresse;
        $this->id_entrepot = $id_entrepot;
        $this->statut = $statut;
        $this->date_livraison = $date_livraison;
    }

    // -------- Getters --------
    public function getId() { return $this->id; }
    public function getId_livreur() { return $this->id_livreur; }
    public function getId_vehicule() { return $this->id_vehicule; }
    public function getId_colis() { return $this->id_colis; }
    public function getId_adresse() { return $this->id_adresse; }
    public function getId_entrepot() { return $this->id_entrepot; }
    public function getStatut() { return $this->statut; }
    public function getDateLivraison() { return $this->date_livraison; }

    // -------- Setters --------
    public function setColisId($id_livreur) { $this->id_livreur = $id_livreur; }
    public function setChauffeurId($id_vehicule) { $this->id_vehicule = $id_vehicule; }
    public function setVehiculeId($id_colis) { $this->id_colis = $id_colis; }
    public function setAdresseDepart($id_adresse) { $this->id_adresse = $id_adresse; }
    public function setAdresseArrivee($id_entrepot) { $this->id_entrepot = $id_entrepot; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setDateLivraison($date_livraison) { $this->date_livraison = $date_livraison; }
}
