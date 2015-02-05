<?php
class Error {
    static public $errorArray = array();

    const errorInfo     = "Info";
    const errorFaible   = "Faible";
    const errorMoyen    = "Moyen";
    const errorCritique = "Critique";

    function __construct() {
        $this->addError('Initialisation des erreurs',self::errorInfo);
    }

    function addError($txtError, $importanceError){
        $tab = array(
            "errorText" => $txtError,
            "errorType" => $importanceError
        );

        array_push(self::$errorArray, $tab);
    }

    
}
?>