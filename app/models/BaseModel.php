<?php

namespace app\models;

use flight\database\PdoWrapper;

abstract class BaseModel
{
    protected static string $table = '';
    protected static string $primary_key = 'id';
    protected static bool $is_view = false;

    protected \flight\database\PdoWrapper $db;

    public function __construct()
    {
        $this->db = \Flight::db();
    }

    /** 
     * Retourne un nouveau query builder pour cette modèle
     */
    public static function query()
    {
        $instance = new static();
        $table = static::$table ?: strtolower((new \ReflectionClass(static::class))->getShortName()) . 's';

        return $instance->db->from($table);
    }

    /**
     * Récupère tous les enregistrements
     */
    public static function all()
    {
        return static::query()->fetchAll();
    }

    /**
     * Récupère un enregistrement par ID
     */
    public static function find($id)
    {
        return static::query()->where(static::$primary_key, $id)->fetch();
    }

    /**
     * Exécute une requête personnalisée et retourne les résultats sous forme de collection
     */
    public static function get()
    {
        return collect(static::query()->fetchAll());
    }

    /**
     * Protège les opérations d'écriture sur les vues
     */
    protected static function checkWriteAllowed()
    {
        if (static::$is_view ?? false) {
            throw new \Exception("Opération d'écriture interdite sur une vue en lecture seule.");
        }
    }

    public function save()
    {
        static::checkWriteAllowed();
        // À implémenter plus tard si besoin (insert/update)
        throw new \Exception("Méthode save() non implémentée.");
    }

    public static function create(array $data)
    {
        static::checkWriteAllowed();
        throw new \Exception("Méthode create() non implémentée.");
    }
}