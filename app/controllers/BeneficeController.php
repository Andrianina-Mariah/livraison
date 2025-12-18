<?php
namespace app\controllers;

use app\models\Benefice;
use app\models\Connexion;

class BeneficeController {

    public function index() {
        $db = Connexion::getConn();   // ✅ connexion directe PDO
        $beneficeModel = new Benefice($db);

        $byDay   = $beneficeModel->getBeneficesByDay();
        $byMonth = $beneficeModel->getBeneficesByMonth();
        $byYear  = $beneficeModel->getBeneficesByYear();

        \Flight::render('index', [
            'byDay'   => $byDay,
            'byMonth' => $byMonth,
            'byYear'  => $byYear
        ]);
    }
}
