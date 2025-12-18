<?php
use app\controllers\LivraisonController;
use app\controllers\BeneficeController;
use flight\net\Router;
use flight\Engine;

/**
 * @var Router $router
 * @var Engine $app
 */
    //accueil
    $router->get('/', function () {
		Flight::render('accueil', ['message' => 'Bienvenue dans le tableau de bord !']);
	});

    //livraison
	$router->get('/livraisons', [LivraisonController::class, 'index']);          // Liste des livraisons
	$router->get('/livraison/create', [LivraisonController::class, 'create']);  // Formulaire création
	$router->get('/livraison/detail', [LivraisonController::class, 'detail']);  // Formulaire création
	$router->post('/livraison/store', [LivraisonController::class, 'store']);   // Création en base
	$router->get('/livraison/edit/@id:[0-9]+', [LivraisonController::class, 'edit']);    // Formulaire modification
	$router->post('/livraison/update/@id:[0-9]+', [LivraisonController::class, 'update']); // Mise à jour en base
	$router->get('/livraison/delete/@id:[0-9]+', [LivraisonController::class, 'delete']); // Supprimer une livraison

// Route principale : Affichage des bénéfices par jour / mois / année
$router->get('/benefices', [BeneficeController::class, 'index']);

// Route pour tester rapidement la base de données (à supprimer en production)
$router->get('/testdb', function() use ($app) {
    try {
        $db = $app->db();
        $db->query('SELECT 1');
        echo '<h1 style="color:green;">Connexion à la base de données : OK !</h1>';
        echo '<p>Date actuelle : ' . date('d/m/Y H:i:s') . '</p>';
    } catch (Exception $e) {
        echo '<h1 style="color:red;">Erreur de connexion DB :</h1>';
        echo '<pre>' . $e->getMessage() . '</pre>';
    }
});

// Exemple de routes supplémentaires que tu pourras ajouter plus tard
/*
$router->get('/livraisons', [LivraisonController::class, 'index']);
$router->get('/livreurs', [LivreurController::class, 'liste']);
$router->post('/livraison/ajouter', [LivraisonController::class, 'ajouter']);
*/

// Route 404 personnalisée (recommandé)
Flight::map('notFound', function() use ($app) {
    // Optionnel : forcer le code HTTP 404
    Flight::response()->status(404);
    $app->render('errors/404', ['title' => 'Page non trouvée']);
});
?>