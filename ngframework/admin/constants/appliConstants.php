<?php
define("_TITLE_SITE",	"Mon agence");
define("_DESCRIPTION_SITE",	"Mon agence");
define("_KEYWORD_SITE",	"Projet, Nans");
define("_LANGUAGE_SITE", "fr-FR");
define("_AUTHOR_SITE","Nans GIGAN");
define("_AUTHOR_MAIL_SITE", "nans@gigan.fr");
define("_CONTACT_MAIL","nans@gigan.fr");

define("_PATH","../framework/");
define("_PATH_SPE","");
define("_URL", "http://admin.immextenso.fr");

define("_NB_SS_DOSSIER", 1); // il faut compter un de plus
define("_SS_DOSSIER", ''); //sous dossier precedé d'un / avant et non apres ex : /proto

define("_FULL_URL", _SS_DOSSIER);

define("_PATH_CONSTANTS_GENE",	_PATH_SPE."constants/");
define("_PATH_MODULE_GENE",	_PATH."modules/");
define("_PATH_INCLUDE_GENE",	_PATH."include/");
define("_PATH_GLOBALS_GENE",	_PATH_SPE."_globals/");
define("_PATH_EXTRA_GENE",	_PATH."_extra/");
define("_PATH_IMG_GENE",	_PATH_SPE."_img/");
define("_PATH_CLASS_GENE", _PATH_SPE."Class/");

define("_FONTS_", _PATH."_font/");

define("_PATH_CACHE",           _PATH_SPE."ngCache/");
define("_PATH_CACHE_GADGET",    _PATH_CACHE."gadget/");
define("_PATH_CACHE_GLOBAL",    _PATH_CACHE."global/");

define("_ULTRA_GLOBAL",			false);
define("_PATH_ULTRA_GLOBAL",	_PATH_CACHE."ultraGlobals/");

define("_PATH_CONTROLLERS_GENE",	_PATH_SPE."controllers/");
define("_PATH_GADGETS_GENE",            _PATH_SPE."gadgets/");
define("_PATH_VIEWS_GENE",		"_views/");
define("_PATH_IMG",			"_img/");

//parametre dans le site
define("_AUTO_CHANGE_CACHE",true);			//Le cache se regenere a chaque modification de la page

//config SQL
define("_DATABASE_CONNECT",true);
define("_SERVER_SQL","db518663977.db.1and1.com");  // nom du serveur (ex: sql.free.fr ou localhost) | server name
define("_USER_SQL","dbo518663977");          // nom de l'utilisateur de la base de données | database user name
define("_PASSWORD_SQL","sitebyNans");          // mot de passe de l'utilisateur de la base de données | password
define("_BASENAME_SQL","db518663977");          // nom de la base de données | database name
?>
