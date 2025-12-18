<?php

class Livreur extends BaseModel{
   function getAllLivreurs(){
       $stmt = $this->db->prepare("SELECT * FROM poste_livreur");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
   function getLivreurById($id){
       $stmt = $this->db->prepare("SELECT * FROM poste_livreur WHERE id = :id");
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
       return $stmt->fetch(PDO::FETCH_ASSOC);
   }
    function createLivreur($name, $email){
         $stmt = $this->db->prepare("INSERT INTO poste_livreur (name, email) VALUES (:name, :email)");
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->bindParam(':email', $email, PDO::PARAM_STR);
         return $stmt->execute();
    }
    function updateLivreur($id, $name, $email){
         $stmt = $this->db->prepare("UPDATE poste_livreur SET name = :name, email = :email WHERE id = :id");
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->bindParam(':email', $email, PDO::PARAM_STR);
         return $stmt->execute();
    }
    function deleteLivreur($id){
            $stmt = $this->db->prepare("DELETE FROM poste_livreur WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
    }

}
?>