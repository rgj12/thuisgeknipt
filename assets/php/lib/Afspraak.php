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
        $this->db->query("SELECT COUNT(id) AS result FROM bookings WHERE datum = :datum AND tijd = :tijd AND ingeboekt = 0");
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

    //krijg services binnen die aan de keuze van de bezoeker voldoet
    public function getServices($soort_service)
    {
        $this->db->query("SELECT * FROM services WHERE soort = :soort_service");
        $this->db->bind(':soort_service', $soort_service);
        $result = $this->db->resultSet();
        return $result;
    }

    //krijg prijs van service
    public function getServicePrijs($id){
        $this->db->query('SELECT prijs FROM services WHERE id = :service');
        $this->db->bind(':service', $id);
        $prijs = $this->db->single();
        return $prijs['prijs'];
    }

    public function bevestigAfspraak($data)
    {
        $this->db->query("INSERT INTO bookings (naam,datum,tijd,email,telefoonnummer,aantal_personen,service,opmerkingen,locatie,totaal) VALUES (:naam,:datum,
        :tijd,:email,:tel,:aantal,:service,:opmerk,:loc,:totaal)");

        $this->db->bind(":naam", $data['naam']);
        $this->db->bind(":datum", $data['datum']);
        $this->db->bind(":tijd", $data['tijd']);
        $this->db->bind(":email", $data['email']);
        $this->db->bind(":tel", $data['tel']);
        $this->db->bind(":aantal", $data['aantal']);
        $this->db->bind(":service", $data['service']);
        $this->db->bind(":opmerk", $data['opmerk']);
        $this->db->bind(":loc", $data['loc']);
        $this->db->bind(":totaal", $data['prijs']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}