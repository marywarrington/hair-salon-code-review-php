<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    // require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Stylist::deleteAll();
        //   Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name2 = "Ed Shaver";
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function testUpdateStylistName()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $new_name = "Jenny Cutsworth";

            //Act
            $test_stylist->updateStylistName($new_name);

            //Assert
            $this->assertEquals("Jenny Cutsworth", $test_stylist->getName());

        }

        function test_deleteOneStylist()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name2 = "Ed Shaver";
            $test_stylist2 = new Stylist($name2, $id);
            $test_stylist2->save();


            //Act
            $test_stylist->deleteOneStylist();

            //Assert
            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name2 = "Ed Shaver";
            $test_stylist2 = new Stylist($name2, $id);
            $test_stylist2->save();


            //Act
            $test_stylist->deleteAll();

            //Assert
            $this->assertEquals([], Stylist::getAll());
        }

        function test_findStylistById()
        {
            //Arrange
            $name = "Jennifer Cutsworth";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name2 = "Ed Shaver";
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::findStylistById($test_stylist2->getId());

            //Assert
            $this->assertEquals($test_stylist2, $result);
        }

    }

?>
