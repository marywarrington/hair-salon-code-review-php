<?php
    class Stylist
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getStylistId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = [];

            foreach ($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        function getClients() {
            $clients = [];
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getStylistId()};");

            foreach($returned_clients as $client)
            {
                $name = $client['name'];
                $id = $client['id'];
                $phone = $client['phone'];
                $email = $client['email'];
                $stylist_id = $client['stylist_id'];
                $new_client =  new Client($name, $phone, $email, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        function updateStylistName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getStylistId()};");
            $this->setName($new_name);
        }

        static function findStylistById($search_id)
        {
            $found_stylist = null;
            $stylists = Stylist::getAll();

            foreach ($stylists as $stylist) {
                if ($stylist->getStylistId() == $search_id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        function deleteOneStylist()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getStylistId()};");
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getStylistId()};");
        }

        static function deleteAllStylists()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        function deleteAllClients()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getStylistId()};");
        }
    }
?>
