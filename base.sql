CREATE DATABASE poste;
USE poste;

CREATE TABLE poste_zone_livraison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL
);

CREATE TABLE poste_adresse (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    id_zone INT NOT NULL,
    FOREIGN KEY (id_zone) REFERENCES poste_zone_livraison(id)
);

CREATE TABLE poste_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    immatriculation VARCHAR(50) NOT NULL UNIQUE,
    marque VARCHAR(50) NOT NULL,
    cout_journalier DECIMAL(10,2) NOT NULL CHECK (cout_journalier >= 0),
    estActif BOOLEAN DEFAULT TRUE
);

CREATE TABLE poste_livreur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    salaire_journalier DECIMAL(10,2) NOT NULL CHECK (salaire_journalier >= 0)--salaire par livraison
);

CREATE TABLE poste_colis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poids DECIMAL(5,2) NOT NULL CHECK (poids > 0),
    prix_kg DECIMAL(10,2) NOT NULL CHECK (prix_kg >= 0)
);

CREATE TABLE poste_entrepot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    id_adresse INT NOT NULL,
    FOREIGN KEY (id_adresse) REFERENCES poste_adresse(id)
);

CREATE TABLE poste_livraison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livreur INT NOT NULL,
    id_vehicule INT NOT NULL,
    id_colis INT NOT NULL,
    id_adresse INT NOT NULL,
    id_entrepot INT NOT NULL,
    date_livraison DATE NOT NULL,
    montantRecette DECIMAL(10,2) DEFAULT 0.00,
    statut ENUM('en attente', 'livre', 'annule') NOT NULL DEFAULT 'en attente',
    FOREIGN KEY (id_livreur) REFERENCES poste_livreur(id),
    FOREIGN KEY (id_vehicule) REFERENCES poste_vehicule(id),
    FOREIGN KEY (id_colis) REFERENCES poste_colis(id),
    FOREIGN KEY (id_adresse) REFERENCES poste_adresse(id),
    FOREIGN KEY (id_entrepot) REFERENCES poste_entrepot(id),
    INDEX idx_date_livreur (date_livraison, id_livreur)
);

DROP VIEW IF EXISTS vue_benefices;

CREATE VIEW vue_benefices AS
SELECT
    l.date_livraison,

    COUNT(DISTINCT l.id_livreur) AS nb_livreurs,
    COUNT(DISTINCT l.id_vehicule) AS nb_vehicules_actifs,

    -- Recette totale
    SUM(c.poids * tc.prix_kg) AS total_recette_colis,

    -- Coût des livreurs
    SUM(li.salaire_journalier) AS total_salaires_livreurs,

    -- Coût des véhicules
    SUM(v.cout_journalier) AS total_couts_vehicules_carburant,

    -- Bénéfice net
    (
        SUM(c.poids * tc.prix_kg)
        - SUM(li.salaire_journalier)
        - SUM(v.cout_journalier)
    ) AS benefice_journalier

FROM poste_livraison l
JOIN poste_colis c ON l.id_colis = c.id
JOIN poste_type_colis tc ON c.id_type_colis = tc.id
JOIN poste_livreur li ON l.id_livreur = li.id
JOIN poste_vehicule v ON l.id_vehicule = v.id

WHERE l.statut = 'livre'
GROUP BY l.date_livraison
ORDER BY l.date_livraison DESC;

INSERT INTO poste_zone_livraison (nom) VALUES ('Centre-ville'), ('Banlieue');

INSERT INTO poste_adresse(nom, id_zone) VALUES ('Analakely', 1), ('Ivandry', 2);

INSERT INTO poste_vehicule(immatriculation, marque, cout_journalier)
VALUES ('1234-TAA', 'Toyota', 50000),
       ('5678-TBB', 'Nissan', 60000);

INSERT INTO poste_livreur (nom, salaire_journalier)
VALUES ('Rakoto', 40000),
       ('Jean', 45000);

INSERT INTO poste_colis (poids, prix_kg)
VALUES (5, 3000),
       (10, 2500);

INSERT INTO poste_livraison (id_livreur, id_vehicule, id_colis, id_adresse, id_entrepot, date_livraison, statut)
VALUES (1, 1, 1, 1, 1,'2025-12-15', 'livre'),
       (2, 2, 2, 2, 2,'2025-12-15', 'livre');

INSERT INTO poste_zone_livraison (nom) VALUES ('Sud'), ('Nord');

INSERT INTO poste_adresse(nom, id_zone) VALUES ('Ankorondrano', 1), ('Tanjombato', 3);

INSERT INTO poste_entrepot (nom, id_adresse) VALUES ('Entrepôt central Ankorondrano', 3), ('Entrepôt Nord Ivandry', 2), ('Entrepôt Sud Tanjombato', 4);

ALTER TABLE poste_colis 
ADD COLUMN libelle VARCHAR(100) NOT NULL;

ALTER TABLE poste_livraison 
ADD COLUMN cout_revient DECIMAL(12,3);

----Les views utiliser dans le projet
--creation de view pour avoir toutes les livraison
CREATE OR REPLACE VIEW view_livraisons_completes AS
SELECT
    l.id AS id,
    l.id_colis,          
    l.id_livreur,      
    l.id_vehicule,      
    c.libelle AS libelle_colis,
    ch.nom AS nom_chauffeur,
    v.immatriculation AS immatriculation,
    e.nom AS nom_entrepot,
    a.nom AS nom_adresse,
    l.id_adresse,
    l.id_entrepot,
    l.date_livraison,
    l.statut,
    l.montantRecette,
    l.cout_revient
FROM poste_livraison l
JOIN poste_colis c ON l.id_colis = c.id
JOIN poste_livreur ch ON l.id_livreur = ch.id
JOIN poste_vehicule v ON l.id_vehicule = v.id
JOIN poste_adresse a ON l.id_adresse = a.id
JOIN poste_entrepot e ON l.id_entrepot = e.id;


-- view pour les colis en attente
CREATE OR REPLACE VIEW view_livraisons_en_attente AS
SELECT * FROM view_livraisons_completes
WHERE statut = 'en attente';
--view pour les colis livre
CREATE OR REPLACE VIEW view_livraisons_livrees AS
SELECT * FROM view_livraisons_completes
WHERE statut = 'livre';
--view pour les colis en attente
CREATE OR REPLACE VIEW view_livraisons_livrees AS
SELECT * FROM view_livraisons_completes
WHERE statut = 'en attente';
--view pour les chiffres d affaire du jour
CREATE OR REPLACE VIEW view_chiffre_affaire_jour AS
SELECT 
    date_livraison,
    SUM(montantRecette) AS total_chiffre_affaire,
    SUM(cout_revient) AS total_cout_revient,
    SUM(montantRecette - cout_revient) AS benefice
FROM poste_livraison
WHERE statut = 'livre'
GROUP BY date_livraison
ORDER BY date_livraison DESC;
--view pour les chiffres d affaire du mois

CREATE OR REPLACE VIEW view_chiffre_affaire_mois AS
SELECT 
    DATE_FORMAT(date_livraison, '%Y-%m') AS mois,
    SUM(montantRecette) AS total_chiffre_affaire,
    SUM(cout_revient) AS total_cout_revient,
    SUM(montantRecette - cout_revient) AS benefice
FROM poste_livraison
WHERE statut = 'livre'
GROUP BY mois
ORDER BY mois DESC;

--chiffre d affaire de l année

CREATE OR REPLACE VIEW view_chiffre_affaire_annee AS
SELECT 
    YEAR(date_livraison) AS annee,
    SUM(montantRecette) AS total_chiffre_affaire,
    SUM(cout_revient) AS total_cout_revient,
    SUM(montantRecette - cout_revient) AS benefice
FROM poste_livraison
WHERE statut = 'livre'
GROUP BY annee
ORDER BY annee DESC;

-- Les performances du livreurs

CREATE OR REPLACE VIEW view_livraisons_par_chauffeur AS
SELECT 
    ch.id AS id_livreur,
    ch.nom,
    COUNT(l.id) AS nb_livraisons,
    SUM(l.montantRecette) AS total_chiffre_affaire,
    SUM(l.cout_revient) AS total_cout_revient,
    SUM(l.montantRecette - l.cout_revient) AS benefice
FROM poste_livraison l
JOIN poste_livreur ch ON l.id_livreur = ch.id
GROUP BY ch.id, ch.nom;

INSERT INTO poste_colis (poids, prix_kg, libelle)
VALUES (25, 3000, 'Fruits'),
       (50, 5000, 'Ciment');


INSERT INTO poste_livraison (id_livreur, id_vehicule, id_colis, id_adresse, id_entrepot, date_livraison, statut)
VALUES (1, 2, 3, 2, 1,'2025-12-18', 'en attente'),
       (2, 1, 1, 3, 3,'2025-12-18', 'annule');

CREATE TABLE poste_type_colis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix_kg DECIMAL(10,2) NOT NULL CHECK (prix_kg >= 0)
);

INSERT INTO poste_type_colis (nom, prix_kg) VALUES
('Aliment périssable', 3000),
('Aliment non périssable', 2000),
('Textile', 2500),
('Matériel', 4000),
('Matériel de construction', 5000),
('Produit fragile', 4500);


ALTER TABLE poste_colis
DROP COLUMN prix_kg;

ALTER TABLE poste_colis
MODIFY poids DECIMAL(10,2) NOT NULL CHECK (poids > 0);

ALTER TABLE poste_colis
ADD COLUMN id_type_colis INT;

ALTER TABLE poste_colis
ADD CONSTRAINT fk_poste_colis_type
FOREIGN KEY (id_type_colis)
REFERENCES poste_type_colis(id);

ALTER TABLE poste_colis
ADD COLUMN prix_total DECIMAL(10,2);

UPDATE poste_colis
SET libelle = 'Colis standard'
WHERE libelle IS NULL;
