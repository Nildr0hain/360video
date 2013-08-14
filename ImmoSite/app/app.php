<?php

/**
 * @Structuur
 *          /admin
 *          /admin/login
 *          /admin/register
 *          /admin/logout
 * 
 *          /admin/realestate/browse?page={id}
 *          /admin/realestate/details?id={id}
 *          /admin/realestate/add?id={id}
 *          /admin/realestate/delete?id={id} - Doet da es me nen properen popup
 *          /admin/realestate/edit?id={id}
 * 
 *          /admin/profile
 *          /admin/profile/edit
 * 
 * @To-Do:
 *    +      Alles van admin - inloggen en rampatamp
 *    +      Overzichtjen - pagnering - filtering - db opstellen
 *    +      Detail immo - want ik ben ne fancy pants *  
 *    +      Add immo - Tiny mce olee olee
 *    +      Edit immo - Tiny mce olee olee
 *    +      Delete immo - popupke nie genoeg?
 *    +      Profile detail - ik zijn fancy en wil detail screen
 *    +      Profile edit - Tiny mce olee olee
 * 
 *    +      home search value - switch page - it dissapears         
 *          Als ge filtert en ge zet na uw ; niks loopt ie vast
 * 
 *    +      Implement fotosch in 
 *    +          add
 *    +          edit
 * 
 *    +      Overal waar delete staat moet de confirm dropdown komen
 *    +          home
 *    +          edit
 *    +          add
 * 
 *          Alles door validators rammen
 *              CSS
 *              HTML
 * 
 *          Customise tiny mce
 * 
            Er	zijn	geen	grote	beveiligingsproblemen	(SQL	Injec;e,	Cross-Site	Scrip;ng	(XSS),	Parameter	
            Tampering,	Encrypteren	van	wachtwoorden,	Onderdrukken	van	foutmeldingen)
 * 
 *    +      UW LOGO - weer nie aanklikbaar. Hoempapa.
 *    +      Check alle links / ook die in de extra footer :D
 *    -      wss kunt ge delete - twig gewoon verwijderen - checken die handel
 *    +      dont you fiddle with ny shizzle functie doet raar
 * 
 *    +      Sub screens, grats ge hebt succesvol iets gedaan :D implement @ edit delete login register add 
 *    +      Fix linkske van /home naar /admin. Make it easyyyyy
 *    +      Error pages hier vanonder uit kommentaar dankuwel alstulieft
 * 
 *          PARAMETER TAMPERING - srsly - SEARCH FIELD!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *          en ziet ook es naar SQL injectie - kan niet droppen - mss niet in de manier dant moet
 * 
 *    +      Ik zoek graag - verwijder alle "rare" tekens
 *          Zet readme proper
 *  
 *    +      Zwiert der es extra kollomen in in overzicht. Kwestie van duidelijk te zijn, evt verkleint da font en ziet da Stad enazo der staan. Kamers of bouwjaar ook welkom.
 *   -       Databank opvullen met data.
 * 
 *          Last but not least - loopt lijstjen met verreisten nog es af.
 * 
 * Bugs:
 *   +       Zoekveld danst graag. Tango enazo.
 *          Home - available - offer - zet margin 10 naar rechts
 *          Mijne footer danst oek geire. Ofwel staat hem fixed mid screen of wel random. 
 *          Mijn slide show switcht van hoogte
 * 
 * uitbreiden :       
 *   +      filteren op meerdere woorden Or / And fnctie uitwerken  - AND it is
 *          Ik ben pro en wil filteren als ge op table name klikt
 *          Live search op huidige item list
 *          Profiel kunnen verwijderen - automatisch ook alle realestate
 *          Der is niks van limitaion van aantal bestanden op multifile uploader.
 * 
 * 
 * Bronnen:
 *          http://fortawesome.github.io/Font-Awesome/cheatsheet/
 *          http://bootsnipp.com/snipps/carousel-extended
 *          http://www.rightmove.co.uk/property-to-rent/London-87490.html
 *          http://bootstrap.braincrafted.com/components#alerts
 * 
 */

// Bootstrap
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


$app->error(function (\Exception $e, $code) use ($app) {
	if ($code == 404) {
		return $app['twig']->render('errors/404.twig', array('error' => $e->getMessage()));
	} else {
                return $app['twig']->render('errors/other.twig', array('error' => "Shenanigans! Something went horribly wrong. "  . $e->getMessage()));
		//return $e->getMessage();
	}
});
    
$app->get('/', function(Silex\Application $app) {
    return $app->redirect($app['request']->getBaseUrl() . '/home');
});


 // Define routes for our static pages
$pages = array(
	'/' => 'home'
);
foreach ($pages as $route => $view) {       
        $app->get($route, function () use ($app, $view) {            
            return $app['twig']->render('static/' . $view . '.twig');
        })->bind($view);        	
}    

// Mount our ControllerProviders

$app->mount('/home', new Saradebbaut\Provider\Controller\HomeController());
$app->mount('/admin', new Saradebbaut\Provider\Controller\AdminController());
$app->mount('/admin/realestate', new Saradebbaut\Provider\Controller\RealEstateController());
$app->mount('/admin/profile', new Saradebbaut\Provider\Controller\ProfileController());

define('PASSWORD_SALT', '&JKHLUIY8YT6W>H*Â¨%Â£qsdfÃ©ze"rezt(rtÂ§t,;:,HJFHJKZrÃ¨fh!Ã§Ã kdhg^$Ã¹`Ã¹^$m,;:j)');

