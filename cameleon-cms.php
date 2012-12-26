<?php 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Cameleon CMS - http://cameleon-cms.lesite.eu/
// Version 2.0.A
//
// Description :
//	V1(Uplorer) = Explorateur de fihciers & Uploader de fichiers
//	V2(Cameleon CMS) = Transformation vers un cms autonome et pouvant se greffer sur n'importe quel site (d'où "Caméléon")
//	A  = Pour Alpha, distribution en cours de conception.
//	V3 = A venir....
//
// Documentation :
//	Installation =>
//	Paramètrage =>
//	Utilisation =>
//	Copyright =>
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Démarrage du CMS, de la session et test de compatibilité de Caméléon CMS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$demarrage = (phpversion() < '5.0.0') ? exit("Cameleon-CMS à besoin de PHP5 minimum pour son bon fonctionnement. Veuillez mettre à jour votre système.") : session_start();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Configuration du CMS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Entrez le charset de votre site, fichiers (l'encodage de ceux-ci ex.: international et html5 = utf-8, europe de l'ouest = iso-8859-1 etc...)
$config_site_charset='iso-8859-1';
    // Entrez votre login séparé de virgule
$config_utilisateur=array('Laurent','demo','test');
    // Entrez votre mot de passe soit tel quel ou crypté via sha1 en respectant le même ordre avec l utilisateur
$config_password=array('a94a8fe5ccb19ba61c4c0873d391e987982fbbd3','89e495e7941cf9e40e6980d14a16bf023ccd4c91','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');
    // Entrez en respectant le même ordre que l utilisateur son niveau de fonction de 0 = admin, 9 = visionneur , 1 = utilisateur, 2 = editeur
$config_utilisateur_fonction=array('0','9','9');
    // Entrez le lien de la page d'accueil de votre site
$adr_site = 'index.php';
    // Vous pouvez si vous le désirez utiliser votre favicon de votre site, entrez alors son emplacement
$config_favicon = 'http://cameleon-cms.lesite.eu/favicon.ico'; 
    // 0 = utilisation interne à la page des styles (design sobre) / 1 = design distant (avec le lien dasn css-externe)
$config_css = '0';
    // Vous pouvez si vous le désirez utiliser votre feuille de style CSS de votre site, entrez alors son emplacement
$css_externe = 'cameleon-style.css';
    // Titre par défaut
$config_titre_page = "Cameleon CMS";
    // Fichier autorisé a modifier dans l'explorateur
$config_fichier_autorise = array('php','asp','html','htm','xhtml','xml','css','js','txt','sql');
    // Fichier qu'on ne peut modifier (comme fichier caché de windows)
$config_fichier_interdit = array('cameleon-cms.php','.htaccess');
    // Dossier interdit qu'on ne peut modifier (Attention : tous les sous dossiers sont egalement exclus. Ne pas mettre de / )
$config_dossier_interdit = array('inc','lib','controleurs','global','modeles','modules','OLD');
    // Taille maximale pour upload de fichier en octet ici 5mo (1mo = 1 024 000 octet)
$config_upload_fichier_taille_max = '5120000';
    // Extension de fichiers autorisé pour l upload
$config_upload_extension_autorise = array('pdf', 'png', 'gif', 'jpg', 'jpeg', 'ico', 'flv', 'swf', 'htm', 'html', 'xhtml', 'php', 'asp', 'css', 'xml', 'js', 'txt', 'sql');  
// Fin de la configuration du CMS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Variables & fonctions d'utilisations
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$version = '2.0.A';
$annee_courante = date("Y");
//Temps au démarrage de la page
function getmtime()
{
    $temps = microtime();
    $temps = explode(' ', $temps);
    return $temps[1] + $temps[0];
}
$temps_debut = getmtime();
///////////////////////////////////////
// Fonction de structure
///////////////////////////////////////
function pageHtmlDebut($titrePage, $charset)
{

    echo '  <!DOCTYPE html>
	    <html lang="fr-BE">
	    <head>
	    <meta http-equiv="content-type" content="text/html; charset='.$charset.'" >
	    <meta name="author" content="Laurent @ Easy Services" >
	    <meta name="keywords" content="Easy Services, ESS, Easy Web Services, Cameleon-CMS, cms, cameleon, cam&eacute;l&eacute;on" >
	    <meta name="description" content="Easy Services vous fait découvrir Cam&eacute;l&eacute;on-CMS, un cms unique tenant en un seul fichier et permet d\'&ecirc;tre utilis&eacute; par tous sites internet, facilement et sans connaissance particuli&egrave;re.">
	    <title>'.$titrePage.'</title>
	    <!--[if lt IE 9]>
	    <script type="text/javascript">
	    document.createElement("header");
	    document.createElement("footer");
	    document.createElement("section");
	    document.createElement("aside");
	    document.createElement("nav");
	    document.createElement("article");
	    document.createElement("figure");
	    document.createElement("figcaption");
	    document.createElement("hgroup");
	    document.createElement("time");
	    </script>
	    <![endif]-->
		<style type="text/css">
		    a img, img{border:0;}
		    *{margin: 0px;padding:0px;}
		    .clear{clear:both;}
		    body
		    {
			font-family: Georgia, sans-serif;
			font-size:0.625em;
			font-style:italic;
			color:#202020;
		    }
		    #page
		    {
		        width:980px;
		        margin:auto;
		    }
		    header
		    {
		        margin-top: 20px;
			padding:4px;
			background:#717171; /* Pour les anciens navigateurs le fond sera blanc est opaque */
			background: rgba(113,113,113,0.3); /* Pour les navigateurs récents, plus bas petit soluce pour IE8 est inférieur */
			border:1px solid #666;
			border-radius: 7px;
			box-shadow:0 0 19px #888;
		    }
		    hgroup
		    {
		        height:70px;
			background: #beced5; /* Old browsers */
			background: -moz-linear-gradient(top, #beced5 0%, #d6dfe3 44%, #edf1f2 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#beced5), color-stop(44%,#d6dfe3), color-stop(100%,#edf1f2)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top, #beced5 0%,#d6dfe3 44%,#edf1f2 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top, #beced5 0%,#d6dfe3 44%,#edf1f2 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top, #beced5 0%,#d6dfe3 44%,#edf1f2 100%); /* IE10+ */
			background: linear-gradient(top, #beced5 0%,#8f0222 44%,#d6dfe3 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#beced5\', endColorstr=\'#edf1f2\',GradientType=0 ); /* IE6-9 */
			padding:25px;
			border:1px solid #5B0000;		
			border-radius: 7px;
		    }
		    header h1
		    {
		        color:#fff;
		        text-align:center;
		        font-size:40px;
			text-shadow:0 0 10px #333;
		    }
		    header h2
		    {
			color:#444;
		        text-align:center;
			text-shadow:1px 1px 1px #777;
		    }
		    nav
		    {
			margin-top:15px;
			margin-left:30px;
			margin-right:30px;
			height:37px;
		    }
		    nav ul
		    {   
			list-style-type:none;
		    }
		    nav li a
		    {
			float:left;
			display:block;
			width:100px;
			height:25px;
			padding-top:12px;
			background:#cccccc; /* Pour les anciens navigateurs le fond sera blanc est opaque */
			border:1px solid #999;
			border-right:none;
			color:#202020;
			text-align:center;
			text-decoration:none;
			font-size:11px;
			/* Fonctionne déjà sur webkit */
			-webkit-transition-property: margin;
			-webkit-transition-duration: 0.2s;
			-webkit-transition-timing-function: ease-in;
	    			
			/* Bientôt supporté par Firefox */
			-moz-transition-property: margin;
			-moz-transition-duration: 0.2s;
			-moz-transition-timing-function: ease-in;
				
			/* … et lorsque ce sera standardisé */
			transition-property: margin;
			transition-duration: 0.2s;
			transition-timing-function: ease-in;
		    }
		    nav li a:hover
		    {
		        background:#fff;
			color:#0067a0;
			font-weight:bold;
			margin-top:-3px;
			box-shadow:0 5px 5px #333;
		    }
		    nav .debut
		    {
			border-top-left-radius:7px;
			border-bottom-left-radius:7px;
			border-right:none;
		    }
		    nav .fin
		    {
			width:auto;
			padding-left:5px;
			padding-right:5px;
			border-right:1px solid #999;
			border-top-right-radius:7px;
			border-bottom-right-radius:7px;
		    }
		    #corps
		    {
			margin-top:20px;
			padding:10px;
			background:#fff; /* Pour les anciens navigateurs le fond sera blanc est opaque */
			background: rgba(255,255,255,0.5); /* Pour les navigateurs récents, plus bas petit soluce pour IE8 est inférieur */
			border:1px solid #999;
			border-radius: 7px;
			box-shadow:0 0px 10px #555;
			font-size:13px;
			line-height:25px;
		    }
		    #corps section
		    {
			padding:10px;
			background: #fff;
			border:1px solid #fff;
			border-radius: 10px;
		    }
		    #corps h1, #corps h2, #corps h3{margin:10px;}
		    #corps ul{margin-left:50px;}
		    #corps p{margin:5px 0 5px 0;}
		    footer
		    {
			margin-top:10px;
		        padding-right:10px;    
			text-align:right;
		    }
		    /********** CSS Internet Explorer *********/
		    header, hgroup, nav, footer, figure, section /* Permet à IE 6 à 8 d\'attribuer le format block à ces nouvelles balises html5 */
		    {
			display: block;
		    }
		    .old_ie header, .ie8 header, .old_ie nav, .ie8 nav, .old_ie #corps, .ie8 #corps /* Permet à IE d\'afficher la transparence de fond */
		    {
		        background:transparent;
		        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#80717171,endColorstr=#80717171);
		        zoom: 1;
		    }
		    .old_ie #connecter form, .ie8 #connecter form /* Permet à IE d\'afficher la transparence de fond */
		    {
		        background:transparent;
		        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#80000000,endColorstr=#80000000);
		        zoom: 1; 
		    }
		    /* Permet de rendre les image png transparente sous IE6 */
		    * html img,
		    * html .png
		    {
		        position:relative;
			behavior: expression((this.runtimeStyle.behavior="none")&&(this.pngSet?this.pngSet=true:(this.nodeName == "IMG" && this.src.toLowerCase().indexOf(\'.png\')>-1?(this.runtimeStyle.backgroundImage = "none",
			this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'" + this.src + "\', sizingMethod=\'image\')",
			this.src = "transparent.gif"):(this.origBg = this.origBg? this.origBg :this.currentStyle.backgroundImage.toString().replace(\'url("\',\'\').replace(\'")\',\'\'),
			this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'" + this.origBg + "\', sizingMethod=\'crop\')",
			this.runtimeStyle.backgroundImage = "none")),this.pngSet=true)
			);
		    }
		    /*********************************************************/
		    /* 			Police de caractère                  */
		    /*********************************************************/		    
		    @font-face
		    {
				font-family: "RieslingRegular";
				src: url("riesling-webfont.eot");
				src: url("riesling-webfont.eot?#iefix") format("embedded-opentype"),
				     url("riesling-webfont.woff") format("woff"),
				     url("riesling-webfont.ttf") format("truetype"),
				     url("riesling-webfont.svg#RieslingRegular") format("svg");
				font-weight: normal;
				font-style: normal;
		    }
		    header h1
		    {
			font-family: "RieslingRegular", "comic sans ms";
		    }
		    /*********************************************************/
		    /*         	   Mise en forme  EXPLORER                   */
		    /*********************************************************/
		    #explorer h4{font-weight:normal;font-style:normal;text-align:left;border:1px solid #ccc;border-bottom:none;color:#333;width:500px;padding:0 10px 0 10px;background:#ffcc33;border-top-left-radius:5px;border-top-right-radius:5px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;}
		    .explorer {box-shadow:0 0 8px #fff;border:1px solid #EEE;border-bottom:none;border-top-left-radius:0px;border-top-right-radius:5px;border-bottom-left-radius:5px;border-bottom-right-radius:7px;}
		    .explorer .master {border-collapse:collapse;}
		    .explorer .master .largeurDossier, .explorer .master .largeurFichier{width:340px;text-align:left;text-indent:10px;font-size:10px;}
		    .explorer .master .largeurFichier{width:600px;text-align:right;padding-right:10px;}
		    .explorer .dossier {background:#eee;border-top-right-radius:25px;border-bottom-right-radius:25px;margin-right:10px;}
		    .explorer .dossier {vertical-align:top;padding-top:10px;font-style:normal;}
		    .explorer .dossier a {display:block;margin-right:10px;height:18px;text-indent:5px;text-decoration:none;color:#444;border-left:18px solid #CCC;margin-bottom:4px;border-top-left-radius:9px;
			/* Fonctionne déjà sur webkit */
			-webkit-transition-property: background;
			-webkit-transition-duration: 0.3s;
			-webkit-transition-timing-function: ease-in;
	    			
			/* Bientôt supporté par Firefox */
			-moz-transition-property: background;
			-moz-transition-duration: 0.3s;
			-moz-transition-timing-function: ease-in;
				
			/* … et lorsque ce sera standardisé */
			transition-property: background;
			transition-duration: 0.3s;
			transition-timing-function: ease-in;}
		    .explorer .dossier a:hover {background:#ffcc33;border-left:18px solid #ffcc33;border-radius:6px;border-bottom:1px solid #ffcc33;}
		    .explorer .dossier a:active {background:#FFF;}
		    .explorer .dossier ul li{list-style-type:none;margin-left:-40px;}
		    .explorer .titre_fichier td {text-align:center;font-size:11px;border-bottom:1px solid #DDD;}
		    .explorer .fichier {padding-left:8px;}
		    .explorer .fichier a, .explorer .fichier a:visited {color:#3399CC;text-decoration:none;font-style:italic;}
		    .explorer .fichier .lien_fichier a:hover {padding-left:20px;}
		    .explorer .fichier .lien_fichier a:hover:before {content:"Editer -> ";color:#66CC33;}
		    .explorer .fichier .lien_fichier_interdit:hover {color:#660000;cursor: none;}
		    .optionExplorer label {display:inline-block;width:280px;}
		    /*********************************************************/
		    /* 			Mise en Editeur                      */
		    /*********************************************************/
		    .editeur .retour {display:block;width:auto;text-align:right;}
		    .editeur .retour a, .editeur .retour a:visited {text-decoration:none;color:#000;}
		    .editeur .retour a:hover {color:#66CC33;}
		    .editeur .contenu {padding:5px;}
		    .editeur .contenu textarea {background:#cbc5c0;border:none;border-radius:5px;color:#202020;}
		    .editeur .contenu textarea:hover {background:#7d7a77;}
		    .editeur .contenu textarea:focus {background:#7d7a77;color:#fff;}
		    .editeur .boutonEditeur .bouton {display:block;width:80px;height:30px;text-align:center;background:#EEE;border:1px solid #999;padding-top:3px;border-radius:5px;}
		    .editeur .boutonEditeur .bouton:hover {background:#CCC;color:#66CC33;font-weight:bold;}
		    /*********************************************************/
		    /* 			Mise en Style                        */
		    /*********************************************************/
		    .styleCss table {float:left;margin:4px;padding:2px;background:#eee;border-radius:5px;border:1px dashed #aaa;}
		    .styleCss table:hover {background:#bababa; border:1px dashed #000;}
		    .styleCss tr td {text-align:center;font-size:14px;font-weight:bold;height:70px;}
		    .styleCss tr td span {font-weight:normal;}
		    .styleCss tr + tr td {text-align:left;font-size:10px;font-weight:normal;height:10px;border-top:1px solid #aaa;}
		    .styleCss a {color:inherit;}
		    /*********************************************************/
		    /* 			Mise en forme                        */
		    /*********************************************************/
		    #connecter { text-align:center; }
		    #connecter h1 { color:#202020;font-size:18px;margin:0 0 10px 0; }
		    .parametres {box-shadow:0 0 8px #fff;border:1px solid #ccc;padding:10px;background:#ddd;border-top-left-radius:0px;border-top-right-radius:5px;border-bottom-left-radius:5px;border-bottom-right-radius:7px;}
		    .parametres form {font-weight:bold;font-size:10px;}
		    input, input[type=file] {border-radius:4px;}
		    #corps h2 {border-bottom:1px solid #333;}
		    h4{font-weight:normal;font-style:normal;text-align:center;border:1px solid #ccc;border-bottom:none;color:#333;width:180px;padding:0 10px 0 10px;background:#ffcc33;border-top-left-radius:5px;border-top-right-radius:5px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;}

		    .messageErreur {display:block;padding:5px;background:#EDEDED;border:1px solid #BABABA;text-align:center;font-weight:bold;font-size:14px;color:red;}
		    .messageOk {display:block;padding:5px;background:#EDEDED;border:1px solid #BABABA;text-align:center;font-weight:bold;font-size:14px;color:green;}
		    .bouleRouge {display:inline-block;height:8px;width:8px;border:1px solid #777;border-radius:5px;background:red;box-shadow:1px 1px 0 #777;}
		    .bouleVerte {display:inline-block;height:8px;width:8px;border:1px solid #777;border-radius:5px;background:green;box-shadow:1px 1px 0 #777;}
		</style>
	    </head>
	    <!--[if IE 6 ]><body class="ie6 old_ie"><![endif]-->
	    <!--[if IE 7 ]><body class="ie7 old_ie"><![endif]-->
	    <!--[if IE 8 ]><body class="ie8"><![endif]-->
	    <!--[if IE 9 ]><body class="ie9"><![endif]-->
	    <!--[if !IE]><!--><body><!--<![endif]-->    
	    <div id="page">
	    <header>
            <hgroup>
            <h1>Cameleon-CMS</h1>
	    <h2>L\'outil indispensable pour la gestion de votre site internet simplement et en 1 FICHIER !!!</h2>
            </hgroup>
            </header>';
    if ((isset($_SESSION['ccmsAuth'])) && ($_SESSION['ccmsAuth'] == TRUE))
    {
	echo'
		<nav>
		<ul>
		<li><a class="debut" href="'.$_SERVER['SCRIPT_NAME'].'">Accueil</a></li>
		<li><a href="'.$_SERVER['SCRIPT_NAME'].'?action=explorer">Explorer</a></li>
		<li><a href="'.$_SERVER['SCRIPT_NAME'].'?action=style">Style</a></li>
		<li><a href="'.$_SERVER['SCRIPT_NAME'].'?action=parametres">Param&egrave;tres</a></li>
		<li><a class="fin" href="'.$_SERVER['SCRIPT_NAME'].'?action=deconnexion">Deconnexion de '.$_SESSION['ccmsUtilisateur'].'</a></li>
		</ul>
		</nav>
	    ';
    }
    echo'
	    <div id="corps">
	    <section>
	';
}

function pageHtmlFin()
{
    global $temps_debut, $annee_courante;
    echo '
	    </section>
	    </div> <!--Fermeture DIV CORPS -->
	    <footer>
            <p>
	    Cette page &agrave; &eacute;t&eacute; g&eacute;n&eacute;r&eacute;e en '. round(getmtime() - $temps_debut,4) .' secondes <br>
            Copyright @ Easy Services 2009 - '.$annee_courante.'.
            </p>
            </footer>        
	    </div> <!--Fermeture DIV PAGE -->
	    </body>
	    </html>
	';
}

///////////////////////////////////////
// Fonction d'utilisation
///////////////////////////////////////
function ccmsFormConnexion($type) // Affichage du formulaire de connexion ou de création d'utilisateur
{
    
    echo '<section id="connecter">
	  <p>
          <form method="POST">';
    
    if(isset($type) and !empty($type) and $type=='creationAdmin')
    {
	echo '
	    <h1>Zone de cr&eacute;ation de l\'administrateur</h1>
	    <input type="hidden" name="ccmsCreerAuth">
	    <input type="hidden" name="fonction" value="0">';
    }
    elseif(isset($type) and !empty($type) and $type=='connexion')
    {
	echo '
	    <h1>Zone d\'identification</h1>
	    <input type="hidden" name="ccmsValiderAuth">';
    }
    else { exit('Une erreur est survenu dans l\'application Cam&eacute;l&eacute;on-CMS, veuillez prendre contact sur le site du cr&eacute;ateur.');}
    
    echo'
         <!-- placeholder="Numéro ID" -->
        <input type="text" name="utilisateur" id="utilisateur" value="Nom utilisateur" onfocus="if (this.value==\'Nom utilisateur\') this.value=\'\'" onblur="if(this.value==\'\') { this.value=\'Nom utilisateur\'; return false; }" required autocomplete="on" > 
        <input type="password" name="password" id="password" value="Password" onfocus="if (this.value==\'Password\') this.value=\'\'" onblur="if(this.value==\'\') { this.value=\'Password\'; return false; }" required >
        <input type="submit" value="Connexion">
        </form>
        </p>
        </section>
	';
}
function ccmsCreerAuth($utilisateur, $password, $fonction) // Création d'un utilisateur
{
    global $authSauver; //Afin d'afficher ensuite le formulaire de connexion sans rafraicir la page
    //Sauvegarde de utilisateur admin
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace('$config_utilisateur=array(\'\');', '$config_utilisateur=array(\''.$utilisateur.'\');', $contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    //Sauvegarde du mot de passe admin
    $password = sha1($password);
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace('$config_password=array(\'\');', '$config_password=array(\''.$password.'\');', $contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    //Sauvegarde du niveau de fonction de l'admin =0
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace('$config_utilisateur_fonction=array(\'\');', '$config_utilisateur_fonction=array(\''.$fonction.'\');', $contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    $authSauver=TRUE;
}
function ccmsValiderAuth($utilisateur,$password,$utilisateurs,$passwords) // Vérification de connexion d'un utilisateur
{    
    $utilisateur = htmlspecialchars($utilisateur);
    $password = htmlentities($password);
    global $message;
    
    if(in_array($utilisateur,$utilisateurs))
    {
	$key = array_search($utilisateur, $utilisateurs);
	if(isset($key) and $passwords[$key] == sha1($password))
	{
	    $_SESSION['ccmsAuth'] = TRUE;
	    $_SESSION['ccmsUtilisateur'] = $utilisateur;
	}
	else
	{
	    $_SESSION['ccmsAuth'] = FALSE;
	    unset($_POST);
	    $message = '<div id="message"><span class="messageErreur">Erreur : Le mot de passe n\'est pas valide ou erron&eacute;.</span></div>';
	}
    }
    else
    {
	$_SESSION['ccmsAuth'] = FALSE;
	unset($_POST);
	$message = '<div id="message"><span class="messageErreur">Erreur : L\'utilisateur n\'est pas existant, veuillez v&eacute;rifier le nom d\'utilisateur.</span></div>';
    }
}
function ccmsCreerNouvelAuth($utilisateur,$password,$fonction,$utilisateurs,$passwords,$fonctions)
{
    //SAUVE NOUVEAU NOM UTILISATEUR   
    //Pré-Création de la chaine des utilisateurs actuel
    $utilisateursAremplacer = '$config_utilisateur=array(';
    $count=count($utilisateurs);
    $c = $count-1;
    for($i=0;$i<$count;$i++)
    {
	if($i == $c)
	{
	    $utilisateursAremplacer .= '\''.$utilisateurs[$i].'\'';
	}
	else
	{
	    $utilisateursAremplacer .= '\''.$utilisateurs[$i].'\',';
	}
    }
    //Rajout dans la chaine a remplacer le nouvel utilisateur
    $nouveauxUtilisateurs = $utilisateursAremplacer.',\''.$utilisateur.'\');';
    $utilisateursAremplacer .= ');';
    //Sauvegarde du nom du nouvel utilisateur
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace($utilisateursAremplacer,$nouveauxUtilisateurs,$contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    //////////////////////////////////////////////////////////////////////////////////////
    //SAUVE NOUVEAU PASSWORD UTILISATEUR   
    //Pré-Création de la chaine des utilisateurs actuel
    $passwordsAremplacer = '$config_password=array(';
    $count=count($passwords);
    $c = $count-1;
    for($i=0;$i<$count;$i++)
    {
	if($i == $c)
	{
	    $passwordsAremplacer .= '\''.$passwords[$i].'\'';
	}
	else
	{
	    $passwordsAremplacer .= '\''.$passwords[$i].'\',';
	}
    }
    //Rajout dans la chaine a remplacer le nouvel utilisateur
    $nouveauxPasswords = $passwordsAremplacer.',\''.sha1($password).'\');';
    $passwordsAremplacer .= ');';
    //Sauvegarde du nom du nouvel utilisateur
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace($passwordsAremplacer,$nouveauxPasswords,$contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    //////////////////////////////////////////////////////////////////////////////////////
    //SAUVE NOUVEAU FONCTION UTILISATEUR   
    //Pré-Création de la chaine des utilisateurs actuel
    $fonctionsAremplacer = '$config_utilisateur_fonction=array(';
    $count=count($fonctions);
    $c = $count-1;
    for($i=0;$i<$count;$i++)
    {
	if($i == $c)
	{
	    $fonctionsAremplacer .= '\''.$fonctions[$i].'\'';
	}
	else
	{
	    $fonctionsAremplacer .= '\''.$fonctions[$i].'\',';
	}
    }
    //Rajout dans la chaine a remplacer le nouvel utilisateur
    $nouveauxFonctions = $fonctionsAremplacer.',\''.$fonction.'\');';
    $fonctionsAremplacer .= ');';
    //Sauvegarde du nom du nouvel utilisateur
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace($fonctionsAremplacer,$nouveauxFonctions,$contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    
    $action='parametres';
}
function ccmsModifierAuth($position,$password,$fonction,$passwords,$fonctions) // Modification de la fonction ou du mot de passe d'un utilisateur
{
    if(!empty($fonction) or $fonction=='0') //Modifier sa fonction
    {
	//Pré-Création de la chaine des fonctions actuel
	$fonctionsAremplacer = '$config_utilisateur_fonction=array(';
	$fonctionQuiRemplace = $fonctionsAremplacer; //Pré création de la chaine qui remplace
	//On remplie la chaine a remplacer
	$count=count($fonctions);
	$c = $count-1;
	for($i=0;$i<$count;$i++)
	{
	    if($i == $c)
	    {
	        $fonctionsAremplacer .= '\''.$fonctions[$i].'\'';
	    }
	    else
	    {
	        $fonctionsAremplacer .= '\''.$fonctions[$i].'\',';
	    }
	}
	$fonctionsAremplacer .= ');';//on termine la chaine a remplacer	
	//on modifie la fonction de l utilisateur
	$fonctions[$position]=$fonction;
	//on remplie la chaine qui remplace
	$count=count($fonctions);
	$c = $count-1;
	for($i=0;$i<$count;$i++)
	{
	    if($i == $c)
	    {
	        $fonctionQuiRemplace .= '\''.$fonctions[$i].'\'';
	    }
	    else
	    {
	        $fonctionQuiRemplace .= '\''.$fonctions[$i].'\',';
	    }
	}
	$fonctionQuiRemplace .= ');';//on termine la chaine qui remplace
    	//Sauvegarde la nouvel fonction
	$contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
	$updatedContenu = str_replace($fonctionsAremplacer,$fonctionQuiRemplace,$contenu);
	file_put_contents('cameleon-cms.php', $updatedContenu);
    }
    elseif(!empty($password)) //Modifier son mot de passe
    {
	//Pré-Création de la chaine des mot de passe actuel
	$passwordAremplacer = '$config_password=array(';
	$passwordQuiRemplace = $passwordAremplacer; //Pré création de la chaine qui remplace
	//On remplie la chaine a remplacer
	$count=count($passwords);
	$c = $count-1;
	for($i=0;$i<$count;$i++)
	{
	    if($i == $c)
	    {
	        $passwordAremplacer .= '\''.$passwords[$i].'\'';
	    }
	    else
	    {
	        $passwordAremplacer .= '\''.$passwords[$i].'\',';
	    }
	}
	$passwordAremplacer .= ');';//on termine la chaine a remplacer	
	//on modifie la fonction de l utilisateur
	$passwords[$position]=sha1($password);
	//on remplie la chaine qui remplace
	$count=count($passwords);
	$c = $count-1;
	for($i=0;$i<$count;$i++)
	{
	    if($i == $c)
	    {
	        $passwordQuiRemplace .= '\''.$passwords[$i].'\'';
	    }
	    else
	    {
	        $passwordQuiRemplace .= '\''.$passwords[$i].'\',';
	    }
	}
	$passwordQuiRemplace .= ');';//on termine la chaine qui remplace
    	//Sauvegarde la nouvel fonction
	$contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
	$updatedContenu = str_replace($passwordAremplacer,$passwordQuiRemplace,$contenu);
	file_put_contents('cameleon-cms.php', $updatedContenu);
    }
}
function ccmsDeconnexion() // Déconnexion d'un utilisateur
{
    session_destroy();
    header($_SERVER['SCRIPT_NAME']);
}
function ccmsRedirectionAccueil($message)
{
    echo '<a href="">'.$message.'</a>';
}
function ccmsTitrePage($string)
{
    global $config_titre_page;
    return $config_titre_page.' - '.ucfirst($string);
}
function ccmsModifierCharset($newCharset,$oldCharset)
{
    //Création de la chaine des mot de passe actuel
    $charsetAremplacer = '$config_site_charset=\''.$oldCharset.'\';';
    $charsetQuiRemplace = '$config_site_charset=\''.$newCharset.'\';'; //Création de la chaine qui remplace
    //Sauvegarde le nouveau charset
    $contenu = file_get_contents('cameleon-cms.php'); //Lecture du fichier dans variable
    $updatedContenu = str_replace($charsetAremplacer,$charsetQuiRemplace,$contenu);
    file_put_contents('cameleon-cms.php', $updatedContenu);
    return $newCharset;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Démarrage du coeur du CMS sur l'action demandée
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ((isset($_SESSION['ccmsAuth'])) && ($_SESSION['ccmsAuth'] == TRUE)) // On est identifié ALORS on vérifie l'action
{
    $action = (isset($_GET['action'])) ? htmlspecialchars($_GET['action']) : $action='';

    switch($action)
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case 'deconnexion':
            ccmsDeconnexion();
        break;
    
	case 'explorer':
	    $config_titre_page = ccmsTitrePage($action);
	    
	    // CREATION NEW FICHIER
	    if (isset($_POST['creerNouveauFichier']) && $_SESSION['cameleon_session_valid'] = "1" && $_POST["sessionid"] == session_id())
	    {
		if (!empty($_POST['creerNouveauFichier']))
		{
		    $dossier = htmlspecialchars($_POST['dossierCourant']);
		    $fichier = htmlspecialchars($_POST['creerNouveauFichier']);
		    if(!file_exists($dossier.$fichier))
		    {
			$f = fopen($dossier.$fichier, "x+");
			fclose($f);
		    }
		    else
		    {
			$message = '<div id="message"><span class="messageErreur">Nouveau fichier : Le fichier est d&eacute;j&agrave; existant.</span></div>';
			unset($_POST);
		    }
		}
		else
		{
		    $message = '<div id="message"><span class="messageErreur">Nouveau fichier : Vous devez entrer un nom de fichier.</span></div>';
		    unset($_POST); 
		}
	    }
	    
	    //UPLOAD FICHIER
	    if(isset($_POST['upload']) && $_POST['upload'] = 'upload' )
	    {
		if(($_FILES['uploadFichier']['error'] > 0) && $_SESSION['cameleon_session_valid'] = "1" && $_POST["sessionid"] == session_id())
		{
		    $message = '<div id="message"><span class="messageErreur">Une erreur s\'est produite pendant l\'upload du fichier.</span></div>';
		    unset($_POST); 
		}
		else
		{
		    if ($_FILES['uploadFichier']['size'] > $config_upload_fichier_taille_max)
		    {
		    $message = '<div id="message"><span class="messageErreur">Le fichier est trop volumineux (Taille maximum = '.$config_upload_fichier_taille_max.').</span></div>';
		    unset($_POST); 
		    }
		    else
		    {
			$extension_upload = strtolower(  substr(  strrchr($_FILES['uploadFichier']['name'], '.')  ,1)  );
			if(!in_array($extension_upload,$config_upload_extension_autorise))
			{
			    $extValide = '';
			    foreach($config_upload_extension_autorise as $x)
			    {
				$extValide .= $x.' ';
			    }
			    $message = '<div id="message"><span class="messageErreur">Extension non autoris&eacute;e <br>(Extension valide = '.$extValide.').</span></div>';
			    unset($_POST);
			}
			else
			{
			    $repDest = htmlspecialchars($_POST['uploadDestination']);
			    $fileUpload = htmlspecialchars($_FILES['uploadFichier']['name']);
			    $resultatUpload = move_uploaded_file($_FILES['uploadFichier']['tmp_name'],$repDest.$fileUpload);
			    if ($resultatUpload)
			    {
				$message = '<div id="message"><span class="messageOk">Le fichier a bien &eacute;t&eacute; transf&eacute;r&eacute;.</span></div>';
				unset($_POST);
			    }
			    else
			    {
				$message = '<div id="message"><span class="messageErreur">Une erreur s\'est produite pendant le transf&eacute;re du fichier.</span></div>';
				unset($_POST);
			    }
			}
		    }
		}
	    }
	    
	    //CREER UN NOUVEAU DOSSIER
	    if(isset($_POST['creerNouveauDossier']))
	    {
		if($_POST['creerNouveauDossier'] == null)
		{
		    $message = '<div id="message"><span class="messageErreur">Vous devez entrer un nom de dossier.</span></div>';
		    unset($_POST);
		}
		else
		{
		    $nouveauDossier = htmlspecialchars($_POST['creerNouveauDossier']);
		    $dossierDestination = htmlspecialchars($_POST['dossierCourant']);
		    if(mkdir($dossierDestination.$nouveauDossier, 0777, true))
		    {
			$message = '<div id="message"><span class="messageOk">La cr&eacute;ation du dossier a bien &eacute;t&eacute; effectu&eacute;e.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		    else
		    {
			$message = '<div id="message"><span class="messageErreur">Une erreur est parvenu pendant la cr&eacute;ation du dossier.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		}
	    }
	    
	    //SUPPRIMER UN DOSSIER
	    if(isset($_POST['supprimerDossier']))
	    {
		if($_POST['supprimerDossier'] == null)
		{
		    $message = '<div id="message"><span class="messageErreur">Vous devez choisir un dossier.</span></div>';
		    unset($_POST);
		}
		else
		{
		    $supprimerDossier = htmlspecialchars($_POST['supprimerDossier']);
		    $dossierDestination = htmlspecialchars($_POST['dossierCourant']);
		    if(@rmdir($dossierDestination.$supprimerDossier))
		    {
			$message = '<div id="message"><span class="messageOk">La suppression du dossier a bien &eacute;t&eacute; effectu&eacute;e.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		    else
		    {
			$message = '<div id="message"><span class="messageErreur">Une erreur est parvenu pendant la suppression du dossier.<br>Celui-ci est soit invalide ou non vide.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		}
	    }
	    
	    //SUPPRIMER UN FICHIER
	    if(isset($_POST['supprimerFichier']))
	    {
		if($_POST['supprimerFichier'] == null)
		{
		    $message = '<div id="message"><span class="messageErreur">Vous devez choisir un fichier.</span></div>';
		    unset($_POST);
		}
		else
		{
		    $supprimerFichier = htmlspecialchars($_POST['supprimerFichier']);
		    $dossierDestination = htmlspecialchars($_POST['dossierCourant']);
		    if(@unlink($dossierDestination.$supprimerFichier))
		    {
			$message = '<div id="message"><span class="messageOk">La suppression du fichier a bien &eacute;t&eacute; effectu&eacute;e.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		    else
		    {
			$message = '<div id="message"><span class="messageErreur">Une erreur est parvenu pendant la suppression du fichier.</span></div>';
			unset($_POST);
			$dossier = $dossierDestination;
		    }
		}
	    }
	    
	    //Affichage des fichiers
	    $cache = ''; //Initialisation de la variable cache pour les tests de choix et de mémoire de dossier et de fichier
	    if (isset($_GET['dossier'])) //si on a choisi de parcourir un dossier
	    { 
		$cache = $_GET["dossier"].'/'; //le cache garde alors le nom du nouveau dossier de destination en cours
		$repertoireEnCours = substr($_GET["dossier"],strrpos($_GET["dossier"],"/"),strlen($_GET["dossier"])); //ne garde que le nom du dossier en cours
	    }
	    elseif (isset($dossier))
	    {
		$cache = $dossier;
		$repertoireEnCours = substr($dossier,strrpos($dossier,"/"),strlen($dossier)); //ne garde que le nom du dossier en cours
	    }
	    $repertoireEnCours = basename(getcwd()).'/'.$cache;
	    $repertoireDestination = $cache; //pour upload et la modification de dossier
	    
	    // Listage des répertoires grâce à glob_onlydir
	    $repertoires = glob($cache."*",GLOB_ONLYDIR); 
	    // Triage des dossiers récupérés par ordre alphabétique
	    sort($repertoires);
	    // On liste les répertoires de $repertoires
	    foreach ($repertoires as $rep) 
	    {
		if(!in_array($rep, $config_dossier_interdit) and is_dir($rep))
		{
		    $repertoiresValide[] = $rep;
		}
	    }
	    
	    // listage des fichiers grâce a glob_brace
	    $fichiers = glob($cache."{,.}*", GLOB_BRACE);
	    // triage des fichiers récupéres par ordre alphabétique
	    sort($fichiers);
	    // On liste les fichiers de $fichiers pour garder que ceux que l'on peut modifier
	    foreach ($fichiers as $fichier) 
	    {
		if(!in_array($fichier, $config_fichier_interdit) and is_file($fichier))
		{
		    $fichiersValide[] = basename($fichier);
		    //On attribue le type de fichie a ext
		    $extension=strrchr($fichier,'.');
		    $extension=substr($extension,1);
		    $ext[]= $extension;
		}
	    }

	break;
    
	case 'editer':
	    $config_titre_page = ccmsTitrePage($action);
	    if (isset($_POST['nom_fichier']) or isset($_GET['fichier']))
	    {
		if (isset($_POST['nom_fichier']) && $_SESSION['cameleon_session_valid'] = "1" && $_POST["sessionid"] == session_id())
		{
		    $fichierNom = $_POST['nom_fichier'];
		    $contenu = stripslashes($_POST['contenu']);
		    $fichier = @fopen($fichierNom, 'w');
		    if ($fichier)
		    {
			fwrite($fichier, $contenu);
			fclose($fichier);
		    }
		    $message = '<div id="message"><span class="messageOk">Le fichier '.$fichierNom.' a bien &eacute;t&eacute; sauv&eacute;.</span></div>';
		}
		if (isset($_GET['fichier']) && $_SESSION['cameleon_session_valid'] = "1") 
		{
		    $fichierNom = stripslashes($_GET['fichier']);
		    if (file_exists($fichierNom)) 
		    {
			//On attribue le type de fichie a extension
			$extension=strrchr($fichierNom,'.');
			$extension=substr($extension,1);
			
			if(!in_array($fichierNom, $config_fichier_interdit) && in_array($extension, $config_fichier_autorise))
			{
			    $fichier = @fopen($fichierNom, "r");
			    if (filesize($fichierNom) !== 0) 
			    {
				$contenu = fread($fichier, filesize($fichierNom));
				$contenu = htmlspecialchars($contenu);
			    }
			    fclose($fichier);
			}
			else
			{
			    $message = '<div id="message"><span class="messageErreur">Le fichier est impossible &agrave; modifier.</span></div>';
			    $interdit=''; // Création variable interdit pour interdire l'acces au fichier
			    unset($fichierNom);
			}
		    } 
		    else 
		    {
			$message = '<div id="message"><span class="messageErreur">Le fichier n\'existe pas.</span></div>';
			$interdit=''; // Création variable interdit pour interdire l'acces au fichier
			unset($fichierNom);
			
		    }
		}
	    }
	    // RENOMER
	    elseif(isset($_POST['nouveauNomFichier']) && $_SESSION['cameleon_session_valid'] = "1" && $_POST["sessionid"] == session_id())
	    {
		$nouveauNomFichier = htmlspecialchars($_POST['nouveauNomFichier']);
		$nouveauNom = str_replace($_POST['nomFichier'],$nouveauNomFichier,$_POST['dossierFichier']);
		rename($_POST['dossierFichier'] , $nouveauNom);
		
		$message = '<div id="message"><span class="messageOk">Le fichier '.$_POST['nouveauNomFichier'].' &agrave; bien &eacute;t&eacute; renom&eacute;.</span></div>';
		unset($_POST);
		
		$fichierNom = $nouveauNom; //pour que l'editeur ouvre le bon fichier
		if (file_exists($fichierNom)) 
		{
		    //On attribue le type de fichie a extension
		    $extension=strrchr($fichierNom,'.');
		    $extension=substr($extension,1);
		    
		    if(!in_array($fichierNom, $config_fichier_interdit) && in_array($extension, $config_fichier_autorise))
		    {
			$fichier = @fopen($fichierNom, "r");
			if (filesize($fichierNom) !== 0) 
			{
			    $contenu = fread($fichier, filesize($fichierNom));
			    $contenu = htmlspecialchars($contenu);
			}
			fclose($fichier);
		    }
		    else
		    {
			$message = '<div id="message"><span class="messageErreur">Ce fichier ne plus &ecirc;tre modifi&eacute; d&ucirc; a sa nouvelle extension.</span></div>';
			$interdit=''; // Création variable interdit pour interdire l'acces au fichier
			unset($fichierNom);
		    }
		} 
	    }
	    // SUPPRIMER
	    elseif(isset($_POST['nomFichierASupprimer']) && $_SESSION['cameleon_session_valid'] = "1" && $_POST["sessionid"] == session_id())
	    {
		$dossierParent = substr($_POST['nomFichierASupprimer'],0,strrpos($_POST['nomFichierASupprimer'],'/'));
		unlink($_POST['nomFichierASupprimer']);
		$message = '<div id="message"><span class="messageOk">Le fichier '.$_POST['nomFichierASupprimer'].' &agrave; bien &eacute;t&eacute; supprim&eacute;.</span></div>';
		$interdit=''; // Création variable interdit pour interdire l'acces au fichier
		unset($_POST);
	    }
	    else 
	    {
		$message = '<div id="message"><span class="messageErreur">Le fichier n\'existe pas.</span></div>';
		$interdit=''; // Création variable interdit pour interdire l'acces au fichier
		unset($fichierNom);
	    }
	break;
    
	case 'parametres':
	    $config_titre_page = ccmsTitrePage($action);
	break;
    
	case 'nouvelUtilisateur':
	    $nomUtilisateur = htmlspecialchars($_POST['nomNouvelUtilisateur']);
	    $passwordUtilisateur = htmlspecialchars($_POST['passwordNouvelUtilisateur']);
	    $fonctionUtilisateur = htmlspecialchars($_POST['fonctionNouvelUtilisateur']);
	    
	    if(in_array($nomUtilisateur,$config_utilisateur))
	    {
		$message = '<div id="message"><span class="messageErreur">L\'utilisateur '.$nomUtilisateur.' est d&eacute;j&agrave; enregistr&eacute;, merci d\'utiliser un autre nom.</span></div>';
	    }
	    else
	    {
		if($_SESSION['ccmsAuth']==TRUE) // Si authentifié 
		{
		    $key = array_search($_SESSION['ccmsUtilisateur'], $config_utilisateur); // Récupération de la clé global de l'utilisateur
		    if($config_utilisateur_fonction[$key]=='0') // Si la fonction permet cette action
		    {
			ccmsCreerNouvelAuth($nomUtilisateur,$passwordUtilisateur,$fonctionUtilisateur,$config_utilisateur,$config_password,$config_utilisateur_fonction);
			$message = '<div id="message"><span class="messageOk">Le nouvel utilisateur '.$nomUtilisateur.' est bien enregistr&eacute;.</span></div>';
		    }
		    else
		    {
			$message='<div id="message"><span class="messageErreur">Vous n\'avez pas les droits pour cette action.</span></div>';
		    }
		}
		else
		{
		    $message='<div id="message"><span class="messageErreur">Vous n\'&ecirc;tes pas authentifier.</span></div>'; //Cloture de la boucle de vérification
		}
	    }
	    $action='parametres';
	    
	break;
    
	case 'style':
	    function recursiveListeRepertoire ($dir)
	    {
		global $config_dossier_interdit;
		if (is_dir ($dir)) // si c'est un repertoire
		{
		    $dh = opendir ($dir); // on l'ouvre
		}
		else
		{
		    //$dir, n\'est pas un repertoire valide - sinon on sort! Appel de fonction non valide
		    exit;
		}
		while (($file = readdir ($dh)) !== false ) //boucle pour parcourir le repertoire
		{ 
		    if ($file !== '.' && $file !== '..')
		    { // no comment
			$path =$dir.'/'.$file; // construction d'un joli chemin...
			if (is_dir ($path)) //si on tombe sur un sous-repertoire
			{ 
			    recursiveListeRepertoire ($path); // appel recursif pour lire a l'interieur de ce sous-repertoire
			}
			else
			{
			    $extension=strrchr($path,'.');
			    $extension=substr($extension,1);
			    if($extension == 'css')
			    {
				$dossier=explode('/',$path);
				if(!in_array($dossier[1],$config_dossier_interdit))
				{
				    echo
				    '<div class="styleCss">
					<a href="?action=editer&amp;fichier='.$path.'">
					    <table>
						<tr>
						    <td>
							Feuille de style<br>
							<span>'.$file.'</span>
						    </td>
						</tr>
						<tr>
						    <td>'
						    .$path.
						    '</td>
						</tr>
					    </table>
					</a>
				    </div>';
				}
			    }
			}
		    }
		}
		closedir ($dh); // on ferme le repertoire courant
	    } 
	break;
    
	case 'modifierFonctionUtilisateur':
	    $utilisateur = (isset($_POST['utilisateur'])) ? htmlspecialchars($_POST['utilisateur']) : '';
	    $fonction = (isset($_POST['fonction'])) ? htmlspecialchars($_POST['fonction']) : '';
	    $password = (isset($_POST['password'])) ? htmlspecialchars($_POST['password']) : '';
	    
	    $position = array_search($utilisateur, $config_utilisateur);
	    
	    if($_SESSION['ccmsAuth']==TRUE) // Si authentifié 
		{
		    $key = array_search($_SESSION['ccmsUtilisateur'], $config_utilisateur); // Récupération de la clé global de l'utilisateur
		    if($config_utilisateur_fonction[$key]=='0') // Si la fonction permet cette action
		    {
			ccmsModifierAuth($position,$password,$fonction,$config_password,$config_utilisateur_fonction);
			$message = '<div id="message"><span class="messageOk">La modification de '.$utilisateur.' est bien enregistr&eacute;.</span></div>';
		    }
		    else
		    {
			$message='<div id="message"><span class="messageErreur">Vous n\'avez pas les droits pour cette action.</span></div>';
		    }
		}
		else
		{
		    $message='<div id="message"><span class="messageErreur">Vous n\'&ecirc;tes pas authentifier.</span></div>'; //Cloture de la boucle de vérification
		}
	    
	    $action='parametres';
	    
	break;
    
	case 'modifierCharsetSite':
	    if($_SESSION['ccmsAuth']==TRUE)
	    {
		$key = array_search($_SESSION['ccmsUtilisateur'], $config_utilisateur); // Récupération de la clé global de l'utilisateur
		if($config_utilisateur_fonction[$key]=='0') // Si la fonction permet cette action
		{
		    $nouveauCharset = htmlspecialchars($_POST['charset']);
		    ccmsModifierCharset($nouveauCharset,$config_site_charset);
		    $message = '<div id="message"><span class="messageOk">La modification du charset est bien enregistr&eacute;.</span></div>';
		}
		else
		{
		    $message='<div id="message"><span class="messageErreur">Vous n\'avez pas les droits pour cette action.</span></div>';
		}
	    }
	    else
	    {
		$message='<div id="message"><span class="messageErreur">Vous n\'&ecirc;tes pas authentifier.</span></div>'; //Cloture de la boucle de vérification
	    }
	    $action='parametres';
	break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    
}
elseif (isset($_POST['ccmsValiderAuth'])) // On s'essaie de s'identifier
{
    ccmsValiderAuth($_POST['utilisateur'],$_POST['password'],$config_utilisateur,$config_password);
}
elseif (isset($_POST['ccmsCreerAuth'])) // On crée l administrateur du cms
{
    $fonction = (is_numeric($_POST['fonction'])) ? $fonction = $_POST['fonction'] : exit('Une erreur est survenu dans l\'application Cam&eacute;l&eacute;on-CMS, veuillez prendre contact sur le site du cr&eacute;ateur.');
    
    if($fonction==0)
    {
	$message='';
        if(!empty($_POST['utilisateur']) and $_POST['utilisateur'] != 'Nom utilisateur'){ $util = htmlspecialchars($_POST['utilisateur']); } else { $message .= '<div id="message"><span class="messageErreur">Nom d\'utilisateur manquant ou erron&eacute;</span></div>';}
        if(!empty($_POST['password']) and $_POST['password'] != 'Password'){ $pass = htmlspecialchars($_POST['password']); } else { $message .= '<div id="message"><span class="messageErreur">Mot de passe manquant ou erron&eacute;</span></div>';}
        if(empty($message))
        {
	    ccmsCreerAuth($util, $pass, $fonction);
	    $message .= '<div id="message"><span class="messageOk">Le compte administrateur '.$util.' est cr&eacute;&eacute;</span></div>';
        }
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Affichage du CMS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
pageHtmlDebut($config_titre_page, $config_site_charset);

if ((isset($_SESSION['ccmsAuth'])) && ($_SESSION['ccmsAuth'] == TRUE)) // On est identifié
{
    if(!isset($action))$action = (isset($_GET['action'])) ? htmlspecialchars($_GET['action']) : $action='';
    
    switch($action)
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//EXPLORER
	case 'explorer';?>
	    <div id="explorer">
		<?php if(isset($message) and !empty($message)) { echo $message; } // Si message on l'affiche ?>
		
		<h2>Gestionnaire d'environnement Web</h2>
		<h4> <u>R&eacute;pertoire en cours :</u><i> <?php echo $repertoireEnCours; ?></i></h4> <!-- Affichage du dossier de travail (basename récupére ainsi l'url de l'emplacement de notre cms et getcwd nettoie pour ne garder que le répertoire courant) puis le cache si un dossier ou pas -->
		<!-- On créé un tableau de 2 colonnes comme un explorateur -->
		<div class="explorer">
		    <table class="master">
			<thead><tr> <th class="largeurDossier">Dossiers</th> <th class="largeurFichier">Fichiers</th></tr></thead>
			<tr>
			    <td class="dossier"> <!-- Colonne pour les dossiers -->
				<ul>
				    <?php
				    //Vérification demande de dossier si oui lien de retour en arrière est créé
				    if ((isset($_GET['dossier'])) or isset($dossier)) //Si un autre dossier est demandé (var dossier est différent de rien) on crée le lien de retour en arrière d'un dossier car c'est qu'on est monté d'un répertoire	
				    {
					$tab = explode(DIRECTORY_SEPARATOR, substr($repertoireEnCours,0,-1));
					$nbre = count($tab) - 1;
					$dossierParent ='';
					for($x=1 ; $x < $nbre ; $x++)
					{
					    $dossierParent .= $tab[$x].'/';
					}
					$dossierParent = substr($dossierParent,0,-1);
					
					if(!empty($dossierParent))
					{
					?>
					    <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?action=explorer&amp;dossier='.$dossierParent; ?>" >.. </a></li> <!-- affichage du lien de retour a la racine-->
					<?php
					}
					else
					{
					?>
					    <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?action=explorer'; ?>" >.. </a></li> <!-- affichage du lien de retour a la racine-->
					<?php 
					}
				    };
				    if(isset($repertoiresValide))
				    {
					foreach($repertoiresValide as $rep)
					{
					    $dossierEnfant = explode(DIRECTORY_SEPARATOR, $rep);
					    $dossierEnfant = array_pop($dossierEnfant);
					?>
					    <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?action=explorer&amp;dossier='.$rep.'">'.$dossierEnfant; ?></a></li> <!-- On crée le lien pour aller dans un répertoire enfant -->
					<?php
					}
				    }
				    ?>
				</ul>
			    </td> <!-- Fermeture de la liste des dossiers -->
			    
			    <td class="fichier"> <!-- Ouverture colonne des fichiers -->
				<table>
				    <tr class="titre_fichier"><td width="275px">Nom</td><td width="100px">Taille</td><td width="75px">Type</td><td width="150px">Date de modification</td></tr> <!-- Création du tableau pour le listing des fichiers -->
				    <?php
				    if(isset($fichiersValide))
				    {
				    foreach($fichiersValide as $key => $fichier)
				    {?>
					<tr>
					    <?php if(in_array($ext[$key], $config_fichier_autorise)) { ?>
					    <td class="lien_fichier"><a href="<?php echo $_SERVER["SCRIPT_NAME"].'?action=editer&amp;fichier='.$cache.$fichier; ?>"><?php echo basename($fichier); ?></a></td>
					    <?php } else { ?>
					    <td class="lien_fichier"><?php echo basename($fichier); ?></td> <?php } ?>
					    <td align="right"> <?php echo round(filesize($cache.$fichier)/1000,2);?> kb</td>
					    <td align="center"><?php echo strtoupper($ext[$key]); ?></td>
					    <td align="center"> <?php echo date("j/n/y G:i", filemtime($cache.$fichier)); ?></td>
					</tr>
				    <?php }
				    }
				    else
				    {?>
					<tr><td rowspan="5">Le r&eacute;pertoire est vide</td></tr>
				    <?php }?>
				</table>
			    </td>
			</tr>
		    </table>
		</div>
		
		<div class="optionExplorer">
		    <table>
			<tr>
			    <td width="340px"> <!-- affichage des liens pour renomer, créer et effacer un dossier -->
				<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"].'?action=explorer'; ?>">
				    <label>Cr&eacute;er un nouveau dossier</label>
				    <input type="text" name="creerNouveauDossier">
				    <input type="hidden" name="dossierCourant" value="<?php echo $repertoireDestination; ?>">
				    <input type="submit" value="Cr&eacute;er">
				</form>
				    <?php
				    if(isset($repertoiresValide))
				    { ?>
					<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"].'?action=explorer'; ?>">
					<select name="supprimerDossier">
					<option value="#">Choisir un dossier a</option>
					<?php
					foreach($repertoiresValide as $rep)
					{
					    $dossierEnfant = explode(DIRECTORY_SEPARATOR, $rep);
					    $dossierEnfant = array_pop($dossierEnfant);
					    echo '<option name="'.$rep.'">'.$dossierEnfant.'</option>';
					}
					echo '</select>';?>
					<input type="hidden" name="dossierCourant" value="<?php echo $repertoireDestination; ?>">
					<input type="submit" value="Supprimer">
				    <?php
				    }
				    ?>
				</form>
			    </td>
			    <td>
				<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"].'?action=explorer'; ?>">
				    <input type="hidden" name="sessionid" value="<?php echo session_id(); ?>"><!-- Sauvegarde la session de l'utilisateur pour etre sur que c'est bien lui qui fait la demande -->
				    <input type="hidden" name="dossierCourant" value="<?php echo $repertoireDestination; ?>">
				    <p>
				        <label>Cr&eacute;er un nouveau fichier &agrave; ce r&eacute;pertoire :</label>
				        <input name="creerNouveauFichier" type="text">
				        <input type="submit" value="Cr&eacute;er">
				    </p>
				</form>
		
				<form enctype="multipart/form-data" action="<?php echo $_SERVER['SCRIPT_NAME'].'?action=explorer'; ?>" method="post">
				    <input type="hidden" name="upload" value="upload" />
				    <input type="hidden" name="sessionid" value="<?php echo session_id(); ?>" /> <!-- Sauvegarde la session de l'utilisateur pour etre sur que c'est bien lui qui fait la demande -->
				    <input type="hidden" name="uploadTailleMax" value="<?php echo $config_upload_fichier_taille_max; ?>" /><!-- Taille maximum autorise pour l upload -->
				    <input type="hidden" name="uploadDestination" value="<?php echo $repertoireDestination; ?>" />
				    <p>
				        <label>Uploader un fichier &agrave; ce r&eacute;pertoire :</label> 
				        <input name="uploadFichier" type="file">
				        <input type="submit" value="Upload">
				    </p>
				</form>
				<?php
				if(isset($fichiersValide))
				{ ?>
				    <form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"].'?action=explorer'; ?>">
				    <select name="supprimerFichier">
				    <option value="#">Choisir un fichier a</option>
				    <?php
				    foreach($fichiersValide as $key => $fichier)
				    {?>
					<option name="<?php echo $cache.$fichier; ?>"><?php echo basename($fichier); ?></option>
				    <?php
				    }
				    echo '</select>';?>
				    <input type="hidden" name="dossierCourant" value="<?php echo $repertoireDestination; ?>">
				    <input type="submit" value="Supprimer">
				    <?php
				}?>
			    </td>
			</tr>
		    </table>
		</div>
	    </div>
	    <?php
	break;
    
//EDITER FICHIER
	case 'editer': ?>
	    <div class="editeur">
		<?php if(isset($message) and !empty($message)) { echo $message; } // Si message on l'affiche ?>
		
		<?php if(!isset($interdit))
		{ ?>		
		    <h2>Edition du fichier &ldquo;<a href="<?php echo $fichierNom; ?>"><?php echo $fichierNom; ?></a>&rdquo;</h2>

		    <?php
		    if(dirname($fichierNom) != '.')
		    {?>
			<span class="retour"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=explorer&amp;dossier=<?php echo dirname($fichierNom); ?>"><<< RETOUR</a></span>
		    <?php
		    }
		    else
		    { ?>
			<span class="retour"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=explorer"><<< RETOUR</a></span>
		    <?php			
		    }
		    ?>
		    <form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=editer&amp;fichier=<?php echo $fichierNom;?>">
			
			<div class="contenu">
				<input type="hidden" name="sessionid" value="<?php echo session_id(); ?>"><!-- Sauvegarde la session de l'utilisateur pour etre sur que c'est bien lui qui fait la demande -->
				<input type="hidden" name="nom_fichier" value="<?php echo $fichierNom; ?>">
				<textarea onkeyup="preview(this, 'previewDiv');" onselect="preview(this, 'previewDiv');" name="contenu" id="textarea" cols="115" rows="25"><?php if(isset($contenu)){echo $contenu;} ?></textarea>
			</div>
			
			<div class="boutonEditeur">
			    <input type="submit" value="Sauver">
			</div>
		    
		    </form>
		    <br>
		    <hr>
		    <h3>Actions disponibles sur le fichier</h3>
			<?php
			    $tab = explode('/',$fichierNom);
			    $nomFichier = array_pop($tab);
			?>
			<form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=editer">Renomer le fichier <input type="hidden" value="<?php echo $fichierNom; ?>" name="dossierFichier"> <input type="hidden" value="<?php echo $nomFichier; ?>" name="nomFichier"> <input type="text" value="<?php echo $nomFichier; ?>" name="nouveauNomFichier"><input type="submit" value="Renomer"><input type="hidden" name="sessionid" value="<?php echo session_id(); ?>"><!-- Sauvegarde la session de l'utilisateur pour etre sur que c'est bien lui qui fait la demande --></form>
			<form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=editer">Supprimer le fichier <input type="hidden" value="<?php echo $fichierNom; ?>" name="nomFichierASupprimer"><input type="submit" value="Supprimer"><input type="hidden" name="sessionid" value="<?php echo session_id(); ?>"><!-- Sauvegarde la session de l'utilisateur pour etre sur que c'est bien lui qui fait la demande --></form>
		<?php
		}
		else
		{?>
		    <h2>Edition du fichier impossible</h2>
		    <?php
		    if(isset($dossierParent) and $dossierParent != null)
		    {?>
			<span class="retour"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=explorer&amp;dossier=<?php echo $dossierParent; ?>"><<< RETOUR</a></span>
		    <?php
		    }
		    else
		    { ?>
			<span class="retour"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?action=explorer"><<< RETOUR</a></span>
		    <?php			
		    }
		} ?>
	    </div>
	<?php 
	break;
    
//STYLE
	case 'style':
	    recursiveListeRepertoire ('.');
	    echo '<div class="clear"></div>';
	break;

//PARAMETRES
	case 'parametres':
	    if(isset($message) and !empty($message)) { echo $message; } // Si message on l'affiche
	    echo '
		<section id="parametres">
		<h2>Param&egrave;tres du CMS</h2>
		<h3>Vos options</h3>';
		
	    $key = array_search($_SESSION['ccmsUtilisateur'], $config_utilisateur); // Récupération de la clé global de l'utilisateur
	    if($config_utilisateur_fonction[$key]=='0') // Si la fonction permet cette action
	    {
		echo '
		<h4>Cr&eacute;er un nouvel utilisateur</h4>
		<div class="parametres">
		    <form method="post" action="?action=nouvelUtilisateur">
		        Nom <input type="text" name="nomNouvelUtilisateur"> 
			Mot de passe <input type="password" name="passwordNouvelUtilisateur">
			Fonction <select name="fonctionNouvelUtilisateur">
			    <option value="0">Administrateur</option>
		            <option value="1">Utilisateur</option>
			    <option value="2">Editeur</option>
			    <option value="9">Visionneur</option>
			    </select>
			<input type="submit" value="Cr&eacute;er">
		    </form>
		    <p>
			L\'administrateur &agrave; tous les droits sur le CMS et il peut g&eacute;rer les droits utilisateurs<br>
			L\'utilisateur peut g&eacute;rer l\'ensemble des options du CMS hormis la gestion des droits.<br>
			L\'&eacute;diteur poss&egrave;de le droit &agrave; la modification des fichiers html, php,.. et uploader des fichiers sans en effacer.<br>
			Le Visionneur ne peut que visionner sans rien cr&eacute;er ni &eacute;diter.<br>
		    </p>
		</div>
		<br>
		<h4>Modifier un utilisateur</h4>
		<div class="parametres">
		    <form method="post" action="?action=modifierFonctionUtilisateur"> 
		    Nom <select name="utilisateur">';
		    foreach($config_utilisateur as $element)
		    {
			echo 	'<option value="'.$element.'">'.$element.'</option>';
		    }
		    echo '
		    </select>
		    Fonction <select name="fonction">
			<option value="0">Administrateur</option>
			<option value="1">Utilisateur</option>
			<option value="2">Editeur</option>
			<option value="9">Visionneur</option>
			</select>
		    <input type="submit" value="Modifier sa fonction">
		    </form>
		    <form method="post" action="?action=modifierFonctionUtilisateur"> 
			Nom <select name="utilisateur">';
			foreach($config_utilisateur as $element)
			{
			echo 	'<option value="'.$element.'">'.$element.'</option>';
			}
			echo '
			</select>
			Nouveau mot de passe <input type="password" name="password">
			    
			<input type="submit" value="Modifier son mot de passe">
			 </form><br>';
			echo '<table><caption>Utilisateur(s) enrgistr&eacute;(s)</caption><thead><tr><th>Utilisateur</th><th>Fonction</th><tbody>';    
			foreach($config_utilisateur as $cle => $element)
			{
			    echo '<tr><td>'.$element.'</td><td>';
			    switch($config_utilisateur_fonction[$cle])
			    {
			        case '0':
			    	echo 'Administrateur';
			        break;
			        case '1':
			    	echo 'Utilisateur';
			        break;
			        case '2':
				echo 'Editeur';
				break;
				case '9':
				echo 'Visionneur';
				break;
			    }
			    echo '</td>';
			}
			echo '</tbody></table></div>';?>
		<br>
		<h4>Choisir l'encodage (charset) de ses fichiers</h4>
		<div class="parametres">
		    <p>
			Encodage (Charset) actuel : "<?php if(isset($newCharset)){echo $newCharset;}else{echo $config_site_charset;} ?>"
		    </p>
		    <form method="post" action="?action=modifierCharsetSite">
			Nouveau type d'encodage 
			<select name="charset">
			    <optgroup label="Unicode">
				<option value="utf-8">Universal Alphabet (UTF-8)</option>
				<option value="utf-7">Universal Alphabet (UTF-7)</option>
				<option value="iso-10646-ucs-2">Universal Alphabet (ISO-10646-UCS-2)</option>
				<option value="us-ascii">Universal Alphabet (US-ASCII)</option>
			    </optgroup>
			    <optgroup label="Western European">
				<option value="iso-8859-1">Alphabet ISO (ISO-8859-1)</option>
				<option value="x-mac-roman">Alphabet MAC (X-MAC-ROMAN)</option>
				<option value="macintosh">Alphabet MAC (MACINTOSH)</option>
				<option value="windows-1254">Alphabet WINDOWS (WINDOWS-1254)</option>
			    </optgroup>
			    <optgroup label="Central European">
				<option value="iso-8859-2">Alphabet ISO (ISO-8859-2)</option>
				<option value="x-mac-ce">Alphabet MAC (X-MAC-CE)</option>
				<option value="windows-1250">Alphabet WINDOWS (WINDOWS-1250)</option>
			    </optgroup>
			</select>
			<input type="submit" value="Modifier">
		    </form>
		</div>
		<?php
		}
		
		echo '
		    <h3>Pour bient&ocirc;t</h3>
		    <ul>
		        <li>Ouverture d\'un fichier par un seul utilisateur.</li>
		        <li>Gestion de sa base de donn&eacute;es Mysql.</li>
		    </ul>
		    </section>
		';
		
	break;
// ACCUEIL    
	default:
	    echo '
		<section id="accueil">
		<h2>Page d\'accueil du CMS</h2>
		<p>
		    Vous poss&egrave;dez la version '.$version.' de Cam&eacute;l&eacute;on-CMS , visitez <a href="http://cameleon-cms.lesite.eu" title="Cameleon CMS Website">cameleon-cms.lesite.eu</a> pour une &eacute;ventuelle mise &agrave; jour.<br>
		</p>
		<p>
		    Rendez-vous dans l\'onglet param&egrave;tres pour g&eacute;rer la configuration du CMS et de ces utilisateurs.<br>
		</p>
		<p>
		    Ce CMS vous permet une gestion compl&egrave;te des fonctions le plus utilis&eacute;s sur un environnement web.<br>
		    Votre environnement web est unique, Cam&eacute;l&eacute;on-CMS s\'y adaptera, d&eacute;couvrez sa simplicit&eacute; r&eacute;volutionnaire :
		    <ul>
			<li>Naviguez &agrave; travers vos dossiers et fichiers &agrave; l\'aide de l\'<a href='.$_SERVER['SCRIPT_NAME'].'?action=explorer>Explorer</a></li>
			<li>Changez l\'apparence de votre site &agrave; l\'aide du menu <a href='.$_SERVER['SCRIPT_NAME'].'?action=style>Style</a> qui vous permet de modifi&eacute; vos CSS</li>
		    </ul>
		</p>
		</section>
		';
	break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
}
else // On n'est pas encore identifié
{
    if(!empty($config_utilisateur['0']) or (isset($authSauver) and $authSauver==TRUE)) // Si il y a un au moins un utilisateur OU si l'on viens de crer l'admin on affiche le formulaire de connexion
    {
	if(isset($message) and !empty($message)) { echo $message; } // Si message on l'affiche
	ccmsFormConnexion('connexion'); //Affichage du formulaire de connexion
	if(isset($authSauver)){$authSauver==FALSE;}
    }
    else // Si pas encore d'utilisateur alors affichae formulaire de création de l'admin
    {
	if(isset($message) and !empty($message)) { echo $message; } // Si message on l'affiche
	ccmsFormConnexion('creationAdmin'); //Affichage du formulaire de creation de l admin
    }
}
pageHtmlFin();
?>

<!-- Chargement du script externe JQUERY via Google pour la disparaition des messages.-->
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">google.load("jquery", "1.2.6");</script>
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){if ( $("#message").length > 0 ) { $("#message").animate({opacity: 1.0}, 5000).fadeOut(); };});
//]]>
</script>