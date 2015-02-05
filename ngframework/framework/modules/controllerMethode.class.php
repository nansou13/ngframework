<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class controllerMethode{

    private $CMmethode;
    private $CMcontroller;

    private $repController;
    private $repMethode;

    private $GoodController;
    private $GoodMethode;

    public function __construct($controller, $methode){
        $this->CMcontroller = $controller;
        $this->CMmethode = $methode;

        $this->setFolderController();
        $this->setFileMethode();
    }

    private function getGoodController(){
        return $this->GoodController;
    }
    private function getGoodMethode(){
        return $this->GoodMethode;
    }

    public function getFullIncludeUrl(){
        if($this->getGoodController() == ''){
            echo 'error 404';
        }else{
            if($this->getGoodMethode() == ''){
                return 'error 404';
            }elseif($this->CMmethode == ''){
                return $this->getGoodController().'/00-index.php';
            }else{
                return $this->getGoodController().'/'.$this->getGoodMethode();
            }
        }
    }

    private function setFolderController(){
        //list les dossiers
        $this->repController = _PATH_CONTROLLERS_GENE;
        $dir = opendir($this->repController);

        while ($f = readdir($dir)) {
           if(is_dir($this->repController.$f) && $f != '.' && $f != '..'){
               //recup le mini et le maxi name
               $arrayControllerNameComplet = explode('-',$f);
               $miniControllerName = $arrayControllerNameComplet[0];
               $maxiControllerName = $arrayControllerNameComplet[1];

               //verifie si le lien est compressé
               if(strlen($this->CMcontroller) == 2){
                    if($this->CMcontroller == $miniControllerName){
                        //Controller trouvé
                        $this->GoodController = $f;
                    }
               }elseif(strlen($this->CMcontroller) > 2){
                    if($this->CMcontroller == $maxiControllerName){
                        //Controller trouvé
                        $this->GoodController = $f;
                    }
               }
           }
        }

        closedir($dir);
    }


    private function setFileMethode(){
        //list les fichiers
        $this->repMethode = _PATH_CONTROLLERS_GENE.$this->GoodController.'/';
        $dir = opendir($this->repMethode);

        while ($f = readdir($dir)) {
           if(is_file($this->repMethode.$f)) {
               //recup le mini et le maxi name
               $arrayMethodeNameComplet = explode('-',$f);
               $miniMethodeName = $arrayMethodeNameComplet[0];

               $arrayMaxiMethodeName = explode('.',$arrayMethodeNameComplet[1]);
               $maxiMethodeName = $arrayMaxiMethodeName[0];

               //verifie si le lien est compressé
               if(strlen($this->CMmethode) == 2){
                    if($this->CMmethode == $miniMethodeName){
                        //Controller trouvé
                        $this->GoodMethode = $f;
                    }
               }elseif(strlen($this->CMmethode) > 2){
                    if($this->CMmethode == $maxiMethodeName){
                        //Controller trouvé
                        $this->GoodMethode = $f;
                    }
               }
           }
        }

        closedir($dir);
    }

}

?>
