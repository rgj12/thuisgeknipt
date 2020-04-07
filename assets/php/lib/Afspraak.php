<?php

class Afspraak
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    //kijk of de tijden al ingenomen zijn
    public function checkIfTimeIsTaken($datum, $tijd)
    {
        $this->db->query("SELECT COUNT(id) AS result FROM bevestigde_afspraken WHERE datum = :datum AND tijd = :tijd");
        $this->db->bind(":datum", $datum);
        $this->db->bind(":tijd", $tijd);

        $result = $this->db->single();

        return $result['result'];
    }
    //krijg alle tijden binnen
    public function getTijden()
    {
        $this->db->query("SELECT * FROM beschikbare_tijden");
        $result = $this->db->resultSet();
        return $result;
    }
}