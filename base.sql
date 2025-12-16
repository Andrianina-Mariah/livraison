create database poste;
use poste;

CREATE TABLE vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    immatriculation VARCHAR(50) NOT NULL,
    marque VARCHAR(50) NOT NULL,
    cout_journalier DECIMAL(10,2) NOT NULL
    estActif BOOLEAN DEFAULT TRUE
);

CREATE TABLE livreur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    salaire_journalier DECIMAL(10,2) NOT NULL
);

CREATE TABLE colis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poids DECIMAL(5,2) NOT NULL,
    prix_kg DECIMAL(10,2) NOT NULL
);

CREATE TABLE zone_livraison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL
);

CREATE TABLE adresse (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    id_zone INT NOT NULL,

    FOREIGN KEY (id_zone) REFERENCES zone_livraison(id)
);

CREATE TABLE livraison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livreur INT NOT NULL,
    id_vehicule INT NOT NULL,
    id_colis INT NOT NULL,
    id_adresse INT NOT NULL,
    entrepot_depart VARCHAR(150) NOT NULL,
    date_livraison DATE NOT NULL,
    montantRecette DECIMAL(10,2),
    montantCarburant DECIMAL(10,2),
    statut ENUM('en attente', 'livre', 'annule') NOT NULL,

    FOREIGN KEY (id_livreur) REFERENCES livreur(id),
    FOREIGN KEY (id_vehicule) REFERENCES vehicule(id),
    FOREIGN KEY (id_colis) REFERENCES colis(id),
    FOREIGN KEY (id_adresse) REFERENCES zone(id) 
);