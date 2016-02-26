<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_getName()
        {
            $name = "Mary";
            $id = 1;
            $phone = "503-347-2222";
            $email = "mary@email.com";
            $stylist_id = 1;

            $test_client = new Client($name, $phone, $email, $id = null, $stylist_id);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getClientId()
        {
            //Arrange
            $stylist_name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            $name = "Mary";
            $phone = "503-347-2222";
            $email = "mary@email.com";
            $id = 1;
            $stylist_id = $test_stylist->getStylistId();
            // var_dump($stylist_id);

            $test_client = new Client($name, $phone, $email, $id, $stylist_id);

            //Act
            $result = $test_client->getClientId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //Arrange
            $stylist_name = "Jennifer Cutsworth";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $name = "Mary";
            $phone = "503-347-2222";
            $email = "mary@email.com";
            $stylist_id = $test_stylist->getStylistId();
            $test_restaurant = new Client($name, $phone, $email, $id, $stylist_id);

            //Act
            $result = $test_restaurant->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

    }
?>
