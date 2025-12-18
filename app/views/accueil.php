<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue – Gestion des Livraisons</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    </head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">🚚 LivraisonPro</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="/livraisons">Livraisons</a></li>
            <li class="nav-item"><a class="nav-link" href="/benefices">Bénéfices</a></li>
        </ul>
    </div>
</nav>

<!-- CONTENU -->
<div class="container mt-5">

    <h2 class="mb-4">📊 Tableau de bord</h2>

    <div class="row g-4">

        <!-- Carte Livraisons -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">📦 Livraisons</h5>
                    <p class="text-muted">
                        Consulter et gérer toutes les livraisons
                    </p>
                    <a href="/livraisons" class="btn btn-primary btn-sm">
                        Voir les livraisons
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte Nouvelle Livraison -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">➕ Nouvelle livraison</h5>
                    <p class="text-muted">
                        Ajouter une nouvelle livraison
                    </p>
                    <a href="livraison/create" class="btn btn-success btn-sm">
                        Créer
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte Bénéfices -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">💰 Bénéfices</h5>
                    <p class="text-muted">
                        Voir les bénéfices par période
                    </p>
                    <a href="benefices" class="btn btn-warning btn-sm">
                        Consulter
                    </a>
                </div>
            </div>
        </div>

    </div>

    
</div>

<footer class="bg-dark text-light text-center py-3 mt-5">
    <small>© 2025 – Gestion des Livraisons </small>
</footer>

<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
