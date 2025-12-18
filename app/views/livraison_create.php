<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer une Livraison</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚚 LivraisonPro</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="/livraisons">Livraisons</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Nouvelle Livraison</a></li>
                <li class="nav-item"><a class="nav-link" href="/benefices">Bénéfices</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <center>
            <h2 class="mb-4">➕ Créer une nouvelle livraison</h2>
        </center>

        <form method="POST" action="/livraison/store">
            <!-- Colis -->
            <div class="mb-3">
                <label for="id_type_colis" class="form-label">Type de colis</label>
                <select class="form-select" id="id_type_colis" name="id_type_colis" required>
                    <option value="">-- Choisir un type de colis --</option>
                    <?php foreach ($typeColisList as $type): ?>
                        <option value="<?= $type['id'] ?>">
                            <?= $type['nom'] ?> (<?= $type['prix_kg'] ?> Ar/kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé du colis</label>
                <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellle" required>
            </div>

            <div class="mb-3">
                <label for="poids" class="form-label">Poids du colis</label>
                <input type="number" class="form-control" id="poids" name="poids" placeholder="poids du colis" required>
            </div>

            <!-- Chauffeur -->
            <div class="mb-3">
                <label for="chauffeur_id" class="form-label">Chauffeur</label>
                <select class="form-select" id="chauffeur_id" name="chauffeur_id" required>
                    <option value="">-- Choisir un chauffeur --</option>
                    <?php foreach ($chauffeurList as $chauffeur): ?>
                        <option value="<?= $chauffeur['id'] ?>"><?= $chauffeur['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Véhicule -->
            <div class="mb-3">
                <label for="vehicule_id" class="form-label">Véhicule</label>
                <select class="form-select" id="vehicule_id" name="vehicule_id" required>
                    <option value="">-- Choisir un véhicule --</option>
                    <?php foreach ($vehiculeList as $vehicule): ?>
                        <option value="<?= $vehicule['id'] ?>"><?= $vehicule['immatriculation'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Adresse départ -->
            <div class="mb-3">
                <label for="adresse_depart" class="form-label">Adresse de départ</label>
                <select name="adresse_depart" id="adresse_depart" class="form-select">
                    <option value="">-- Choisir un entrepot --</option>
                    <?php foreach ($entrepotList as $entrepot): ?>
                        <option value="<?= $entrepot['id'] ?>"><?= $entrepot['nom'] ?></option>
                    <?php endforeach; ?>                
                </select>
            </div>

            <!-- Adresse arrivée -->
            <div class="mb-3">
                <label for="adresse_arrivee" class="form-label">Adresse de destination</label>
                <select name="adresse_arrivee" id="adresse_arrivee" class="form-select">
                    <option value="">-- Choisir une adresse --</option>
                    <?php foreach ($adresseList as $adresse): ?>
                        <option value="<?= $adresse['id'] ?>"><?= $adresse['nom'] ?></option>
                    <?php endforeach; ?>                
                </select>
            </div>

            <!-- Date livraison -->
            <div class="mb-3">
                <label for="date_livraison" class="form-label">Date de livraison</label>
                <input type="date" class="form-control" id="date_livraison" name="date_livraison" required>
            </div>

            <!-- Statut -->
            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" id="statut" name="statut" required>
                    <option value="en attente" selected>En attente</option>
                    <option value="livré">Livré</option>
                    <option value="annulé">Annulé</option>
                </select>
            </div>

            <!-- Boutons -->
            <center>
                <div>
                    <button type="submit" class="btn btn-success">Créer la livraison</button>
                    <a href="/livraisons" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    </center>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <small>© 2025 – Gestion des Livraisons | PHP Flight MVC</small>
    </footer>

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>