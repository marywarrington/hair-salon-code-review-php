<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array(
            'stylists' => Stylist::getAll()
        ));
    });

    $app->post("/stylists", function() use ($app) {
        $new_stylist = new Stylist($_POST['name']);
        $new_stylist->save();
        return $app['twig']->render('index.html.twig', array(
            'stylists' => Stylist::getAll()
        ));
    });

    $app->get("/stylist/{id}", function($id) use ($app) {
        $stylist = Stylist::findStylistById($id);
        return $app['twig']->render('stylist.html.twig', array(
            'stylist' => $stylist,
            'clients' => $stylist->getClients()
        ));
    });

    $app->get("/stylist/{id}/edit", function($id) use ($app) {
        $new_stylist = Stylist::findStylistById($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $new_stylist
        ));
    });

    $app->delete("/stylist/{id}/delete", function($id) use ($app) {
        $stylist = Stylist::findStylistById($id);
        $stylist->deleteOneStylist();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()
        ));
    });

    $app->patch("/stylist/{id}/stylist_name", function($id) use ($app) {
        $new_stylist_name = $_POST['stylist_name'];
        $stylist = Stylist::findStylistById($id);
        $stylist->updateStylistName($new_stylist_name);
        return $app['twig']->render('stylist.html.twig', array(
            'stylist' => $stylist,
            'clients' => $stylist->getClients()
        ));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $stylist_id = $_POST['stylist_id'];
        $new_client = new Client($client_name, $phone, $email, $id = null, $stylist_id);
        $new_client->save();
        $stylist = Stylist::findStylistById($stylist_id);
        return $app['twig']->render('stylist.html.twig', array(
            'stylist' => $stylist,
            'clients' => $stylist->getClients()
        ));
    });

    $app->get("/clients/{id}/edit", function($id) use ($app) {
        $client = Client::findClientById($id);
        return $app['twig']->render('client_edit.html.twig', array('client' => $client));
    });

    $app->patch("/clients/{id}/client_name", function($id) use ($app) {
            $new_client_name = $_POST['client_name'];
            $client = Client::findClientById($id);
            $client->updateClientName($new_client_name);
            $stylist_id = $client->getStylistId();
            $stylist = Stylist::findStylistById($stylist_id);
            return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
        });

    $app->patch("/clients/{id}/phone", function($id) use ($app) {
        $new_phone = $_POST['phone'];
        $client = Client::findClientById($id);
        $client->updateClientPhone($new_phone);
        $stylist_id = $client->getStylistId();
        $stylist = Stylist::findStylistById($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->patch("/clients/{id}/email", function($id) use ($app) {
        $new_email = $_POST['email'];
        $client = Client::findClientById($id);
        $client->updateClientEmail($new_email);
        $stylist_id = $client->getStylistId();
        $stylist = Stylist::findStylistById($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->delete("/clients/{id}/delete", function($id) use ($app) {
        $client = Client::findClientById($id);
        $stylist_id = $client->getStylistId();
        $stylist = Stylist::findStylistById($stylist_id);
        $client->deleteOneClient();
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    return $app;

?>
