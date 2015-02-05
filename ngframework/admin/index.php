<?php
require("constants/appliConstants.php");
require(_PATH_INCLUDE_GENE."GateKeeper.class.php");

$front = GateKeeper::singleton()->dispatch();
?>