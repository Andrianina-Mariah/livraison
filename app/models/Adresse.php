<?php

class Adresse extends BaseModel {
    public function getAllAdresses() {
        $stmt = $this->db->prepare("SELECT * FROM poste_adresse");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdresseById($id) {
        $stmt = $this->db->prepare("SELECT * FROM poste_adresse WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createAdresse($street, $city, $postal_code) {
        $stmt = $this->db->prepare("INSERT INTO poste_adresse (street, city, postal_code) VALUES (:street, :city, :postal_code)");
        $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateAdresse($id, $street, $city, $postal_code) {
        $stmt = $this->db->prepare("UPDATE poste_adresse SET street = :street, city = :city, postal_code = :postal_code WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteAdresse($id) {
        $stmt = $this->db->prepare("DELETE FROM poste_adresse WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>