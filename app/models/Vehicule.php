<?php

class Vehicule extends BaseModel {
    public function getAllVehicules() {
        $stmt = $this->db->prepare("SELECT * FROM post_vehicule");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVehiculeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM post_vehicule WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createVehicule($model, $license_plate, $capacity) {
        $stmt = $this->db->prepare("INSERT INTO post_vehicule (model, license_plate, capacity) VALUES (:model, :license_plate, :capacity)");
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':license_plate', $license_plate, PDO::PARAM_STR);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateVehicule($id, $model, $license_plate, $capacity) {
        $stmt = $this->db->prepare("UPDATE post_vehicule SET model = :model, license_plate = :license_plate, capacity = :capacity WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':license_plate', $license_plate, PDO::PARAM_STR);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteVehicule($id) {
        $stmt = $this->db->prepare("DELETE FROM post_vehicule WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}   

?>