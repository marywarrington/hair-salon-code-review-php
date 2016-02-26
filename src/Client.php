<?php
    class Client
    {
        private $name;
        private $phone;
        private $email;
        private $id;
        private $stylist_id;

        function __construct($name, $phone, $email, $id = null, $stylist_id)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
            $this->id = $id;
            $this->stylist_id = $stylist_id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function setEmail($new_email)
        {
            $this->email = $new_email;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getClientId()
        {
            return $this->id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name, phone, email, stylist_id) VALUES ('{$this->getName()}', '{$this->getPhone()}', '{$this->getEmail()}', {$this->getStylistId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateClientName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE id = {$this->getClientId()};");
            $this->setName($new_name);
        }

        function updateClientPhone($new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET phone = '{$new_phone}' WHERE id = {$this->getClientId()};");
            $this->setName($new_phone);
        }

        function updateClientEmail($new_email)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET email = '{$new_email}' WHERE id = {$this->getClientId()};");
            $this->setName($new_email);
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = [];

            foreach ($returned_clients as $client) {
                $name = $client['name'];
                $id = $client['id'];
                $phone = $client['phone'];
                $email = $client['email'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($name, $phone, $email, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function findClientById($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();

            foreach ($clients as $client) {
                if ($client->getClientId() == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        function deleteOneClient()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getClientId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getStylistId()};");
        }

    }
?>
