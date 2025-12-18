<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Livraisons</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚚 LivraisonPro</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                <li class="nav-item"><a class="nav-link active" href="/livraisons">Livraisons</a></li>
                <li class="nav-item"><a class="nav-link" href="/benefices">Bénéfices</a></li>
            </ul>
        </div>
    </nav>

    <!-- CONTENU -->
    <div class="container mt-5">

        <center>
            <h2 class="mb-4">📦 Liste des livraisons</h2>
        </center>

        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Colis</th>
                    <th>Chauffeur</th>
                    <th>Véhicule</th>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($livraisons)): ?>
                    <?php foreach ($livraisons as $l): ?>
                        <?php
                        switch ($l['statut']) {
                            case 'livre':
                                $badge = 'success';
                                break;
                            case 'annulé':
                                $badge = 'danger';
                                break;
                            case 'en attente':
                                $badge = 'warning';
                                break;
                            default:
                                $badge = 'secondary';
                        }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($l['libelle_colis'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($l['nom_chauffeur'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($l['immatriculation'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($l['nom_entrepot']) ?></td>
                            <td><?= htmlspecialchars($l['nom_adresse']) ?></td>
                            <td><?= (new DateTime(htmlspecialchars($l['date_livraison'])))->format('d/m/Y') ?></td>
                            <td>
                                <span class="badge bg-<?= $badge ?>">
                                    <?= htmlspecialchars($l['statut']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="/livraison/edit/<?= $l['id'] ?>" class="btn btn-sm btn-primary" id="edit-<?= $l['id'] ?>">
                                    Modifier
                                </a>


                                <a href="/livraison/delete/<?= $l['id'] ?>"
                                    onclick="return confirm('Etes vous sur de supprimer la livraison ?');"
                                    class="btn btn-sm btn-danger">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Aucune livraison trouvée
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <center><a href="/livraison/create" class="btn btn-success mt-3">➕ Nouvelle livraison</a></center>

    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <small>© 2025 – Gestion des Livraisons | PHP Flight MVC</small>
    </footer>

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>