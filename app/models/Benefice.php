<?php
namespace app\models;

class Benefice {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Bénéfices par jour (utilisé pour le tableau journalier)
    public function getBeneficesByDay() {
        $stmt = $this->db->query("
            SELECT 
                date_livraison,
                benefice_journalier
            FROM vue_benefices 
            ORDER BY date_livraison DESC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Bénéfices par mois
    public function getBeneficesByMonth() {
        $stmt = $this->db->query("
            SELECT 
                DATE_FORMAT(date_livraison, '%Y-%m') AS periode,
                CONCAT(
                    CASE MONTH(date_livraison)
                        WHEN 1 THEN 'Janvier' WHEN 2 THEN 'Février' WHEN 3 THEN 'Mars'
                        WHEN 4 THEN 'Avril' WHEN 5 THEN 'Mai' WHEN 6 THEN 'Juin'
                        WHEN 7 THEN 'Juillet' WHEN 8 THEN 'Août' WHEN 9 THEN 'Septembre'
                        WHEN 10 THEN 'Octobre' WHEN 11 THEN 'Novembre' WHEN 12 THEN 'Décembre'
                    END,
                    ' ', YEAR(date_livraison)
                ) AS periode_libelle,
                SUM(benefice_journalier) AS total_benefice
            FROM vue_benefices
            GROUP BY YEAR(date_livraison), MONTH(date_livraison)
            ORDER BY periode DESC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Bénéfices par année
    public function getBeneficesByYear() {
        $stmt = $this->db->query("
            SELECT 
                YEAR(date_livraison) AS periode,
                SUM(benefice_journalier) AS total_benefice
            FROM vue_benefices
            GROUP BY YEAR(date_livraison)
            ORDER BY periode DESC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>