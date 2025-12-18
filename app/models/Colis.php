<?php

class Colis extends BaseModel {
    public function getAllColis() {
        $stmt = $this->db->prepare("SELECT * FROM poste_colis");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getColisById($id) {
        $stmt = $this->db->prepare("SELECT * FROM poste_colis WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createColis($description, $weight, $destination) {
        $stmt = $this->db->prepare("INSERT INTO poste_colis (description, weight, destination) VALUES (:description, :weight, :destination)");
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
        $stmt->bindParam(':destination', $destination, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateColis($id, $description, $weight, $destination) {
        $stmt = $this->db->prepare("UPDATE poste_colis SET description = :description, weight = :weight, destination = :destination WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
        $stmt->bindParam(':destination', $destination, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteColis($id) {
        $stmt = $this->db->prepare("DELETE FROM poste_colis WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>