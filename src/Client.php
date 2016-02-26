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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

    }
?>
