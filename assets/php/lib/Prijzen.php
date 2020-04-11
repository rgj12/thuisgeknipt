<?php
class Prijzen
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPrijzen()
    {
        $this->db->query("SELECT * FROM services");

        $result = $this->db->resultSet();

        return $result;
    }
}