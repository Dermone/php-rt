<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;

/**
 * Controller My
 **/
class My extends ControllerBase{

    /**
     * Mes services
     * Hosts et virtualhosts de l'utilisateur connecté
     */
    public function index(){
        if(Auth::isAuth()) {
            $user = Auth::getUser();
            $hosts = DAO::getAll("models\Host", "idUser=" . $user->getId());
            $virtualhost = DAO::getAll("models\Virtualhost", "idUser=" . $user->getId());

            $hostsItems = $this->semantic->htmlItems("list-hosts");
            $hostsItems->fromDatabaseObjects($hosts, function ($host) {
                $item = new HtmlItem("");
                $item->addImage("public/img/host.png")->setSize("tiny");
                $item->addItemHeaderContent($host->getName(), $host->getIpv4(), "");
                return $item;
            });
            //A faire : ajouter virtualhosts
            $virtualhostItems = $this->semantic->htmlItems("list-virtualhost");
            $virtualhostItems->fromDatabaseObjects($virtualhost, function ($virtualhost) {
                $item = new HtmlItem("");
                echo "<div class=\"eight wide column\"><button class=\"ui basic button\"><i class=\"icon user\"></i>Add Friend</button></div>";
                $item->addImage("public/img/virtualhost.png")->setSize("tiny");
                $item->addItemHeaderContent($virtualhost->GetName(), "nginX sur srv2");
                return $item;
            });
            $this->jquery->compile($this->view);
            $this->loadView("My/index.html");
        }
    }
}