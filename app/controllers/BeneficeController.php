<?php
namespace app\controllers;

use app\models\Benefice;

class BeneficeController {
    
    public function index() {
        $beneficeModel = new Benefice(\Flight::db());

        $byDay   = $beneficeModel->getBeneficesByDay();
        $byMonth = $beneficeModel->getBeneficesByMonth();
        $byYear  = $beneficeModel->getBeneficesByYear();

        \Flight::render('index', [
            'byDay'   => $byDay,
            'byMonth' => $byMonth,
            'byYear'  => $byYear
        ]);
    }

    // Optionnel : si tu veux un filtre par date précise plus tard
    // public function filtre() { ... }
}
?>