<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Livraison #<?= $livraison['id'] ?></title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Modifier Livraison #<?= $livraison['id'] ?></h2>

    <form action="/livraison/update/<?= $livraison['id'] ?>" method="POST" class="border p-4 bg-white rounded">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom_entrepot" class="form-label">Adresse départ</label>
                <input type="text" class="form-control" id="nom_entrepot" name="nom_entrepot" value="<?= htmlspecialchars($livraison['nom_entrepot']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="nom_adresse" class="form-label">Adresse arrivée</label>
                <input type="text" class="form-control" id="nom_adresse" name="nom_adresse" value="<?= htmlspecialchars($livraison['nom_adresse']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="date_livraison" class="form-label">Date livraison</label>
                <input type="date" class="form-control" id="date_livraison" name="date_livraison" value="<?= htmlspecialchars($livraison['date_livraison']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="statut" class="form-label">Statut</label>
                <select id="statut" name="statut" class="form-select" required>
                    <option value="en attente" <?= $livraison['statut'] === 'en attente' ? 'selected' : '' ?>>En attente</option>
                    <option value="livré" <?= $livraison['statut'] === 'livré' ? 'selected' : '' ?>>Livré</option>
                    <option value="annulé" <?= $livraison['statut'] === 'annulé' ? 'selected' : '' ?>>Annulé</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            <a href="/livraisons" class="btn btn-secondary">Annuler</a>
        </div>

    </form>
</div>

<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
