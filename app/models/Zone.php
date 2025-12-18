<?php
class Zone extends BaseModel {
    public function getAllZones() {
        $stmt = $this->db->prepare("SELECT * FROM poste_zone_livraison");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getZoneById($id) {
        $stmt = $this->db->prepare("SELECT * FROM poste_zone_livraison WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createZone($name, $description) {
        $stmt = $this->db->prepare("INSERT INTO poste_zone (name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateZone($id, $name, $description) {
        $stmt = $this->db->prepare("UPDATE poste_zone SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteZone($id) {
        $stmt = $this->db->prepare("DELETE FROM poste_zone WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>