<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Opdrachten

Deze repository is voor studenten die aan de slag willen met het leren van Laravel11. De opdrachten zijn gekoppeld aan de lessenserie die
geschreven is om stap voor stap het framework te leren. De eisen van de opdrachten staan dan ook in het document beschreven, met daarbij
het commando wat je kan uitvoeren als controle.

## De opdracht

Voor de opdracht zal je aan de slag gaan met een project tool. Dit is om bij te houden hoever een project staat, welke taken er zijn en
wie de taken moeten uitvoeren. De functionaliteit bestaat uit het volgende:

<ul>
<li>Studenten kunnen een project aanmaken</li>
<li>Bij een project kunnen allerlei taken horen</li>
<li>Een taak heeft een status, bijvoorbeeld: Todo, Doing, Testing, Verify, Done</li>
<li>Een taak kan verschillende labels hebben, zoals: front-end, backend, documentation, bug, feature</li>
</ul>

En ja, het ziet er misschien lastig uit, maar de opdrachten zullen steeds een klein stapje zijn. De opdrachten zullen ook heel precies zijn,
er zijn namelijk automatische testen beschikbaar waar op alle details wordt gelet.

## Wijzigingen

Let op, de volgende wijzigingen zijn doorgevoerd bij de opdrachten:
<ol>
<li>Bij opdracht1 is nu een aparte test. Test is uit te voeren met: .\vendor\bin\pest --group=Opdracht1 </li>
<li>Bij opdracht2 is nu een aparte test. Test is uit te voeren met: .\vendor\bin\pest --group=Opdracht2
<ul>
<li>De Factory moet de volgende naam hebben: ProjectFactory</li>
<li>De Seeder moet de volgende naam hebben: ProjectSeeder</li>
</ul></li>
<li>Bij opdracht3 is nu een nieuwe test. Test is uit te voeren met: .\vendor\bin\pest --group=Opdracht3 
<ul>
<li>De naam van de masterpage moet zijn: adminlayout.blade.php</li>
<li>Op de pagina moet ergens de volgende tekst staan: Laravel Opdrachten</li>
<li>Zorg dat deze layout zichtbaar op de pagina komt als in de url alleen een ‘/admin’ staat.</li>
</ul></li>
<li>Bij opdracht4 is nu een nieuwe test. Test is uit te voeren met: .\vendor\bin\pest --group=Opdracht4 
<ul>
<li>De named route moet zijn: projects.index</li>
<li>De id's worden nu ook werkelijk gecontrolleerd, met nieuwe projects en door middel van seed.</li>
</ul></li>
<li>Bij opdracht5 is de test aangepast. Test is uit te voeren met: .\vendor\bin\pest --group=Opdracht5 
<ul><li>Het formulier:<ul>
<li>Er is een input voor: name.</li>
<li>Er is een textarea voor: description.</li>
<li>De action gebruikt de correcte named route.</li>
</ul></li>
<li>Het bewaren van data:<ul>
<li>Er is een name en description. </li>
<li>Mass assignment mag niet mogelijk zijn.</li>
<li>In de model wordt gebruik gemaakt van $fillable.</li>
<li>In de database komt de correcte name & description.</li>
<li>Nadat het is opgeslagen word je automatisch naar de index gestuurd met de melding dat het project is toegevoegd.</li>
</ul></li></ul>
<li>Bij opdracht6 wordt nu getest of :
<ul><li>je werkelijk gebruik maakt van een aparte validatie request: ProjectStoreRequest</li>
<li>De foutmeldingen bij validatie errors op het scherm komen</li>
<li>Na correct opslaan er een redirect naar project.index wordt gebruikt, met gebruik van een flash message</li>
<li>De melding bij opslaan in de index getoond wordt: Project {projectnaam} is aangemaakt</li>
</ul></li>
<li>Opdracht7: niets aangepast</li>
<li>Bij opdracht8 wordt nu getest of :
<ul>
<li>De correcte action in het formulier staat naar 'projects.update'</li>
<li>De input velden voor name & description er correct in staan</li>
<li>je werkelijk gebruik maakt van een aparte validatie request: ProjectUpdateRequest</li>
<li>De foutmeldingen bij validatie errors op het scherm komen</li>
<li>Na correct opslaan er een redirect naar project.index wordt gebruikt, met gebruik van een flash message</li>
<li>De melding bij update in de index getoond wordt: Project {projectnaam} is gewijzigd</li>
</ul></li>
<li>Bij opdracht9 wordt nu getest of :
<ul>
<li>De correcte action in het formulier staat naar 'projects.update'</li>
<li>De input velden voor name & description er correct in staan</li>
<li>Na correct verwijderen er een redirect naar project.index wordt gebruikt, met gebruik van een flash message</li>
<li>De melding bij delete in de index getoond wordt: Project {projectnaam} is verwijderd</li>
</ul></li>
<li>Opdracht10: niets aangepast</li>
<li>Bij opdracht11 wordt nu getest of :
<ul>
<li>De controller moet in de map staan: App/Http/Controllers/Open/ </li>
<li>De naam van de controller is: ProjectController</li>
<li>De view moet in de map staan: Resources/views/open/projects/ </li>
<li>De naam van de view is: index.blade.php</li>
<li>Op de pagina moeten de id, name en description staan.</li>
<li>Er moet met pagina's worden gewerkt, met 10 projecten per pagina, waarbij de correcte data wordt getoond.</li>
</ul></li>
<li>Bij opdracht12 wordt nu getest of :
<ul>
<li>Rollen en permissies correct zijn aangemaakt en toegewezen.</li>
<li>Permissies correct zijn ingesteld in de controllers.</li>
</ul></li>
<li>Bij opdracht13 wordt nu getest of :
<ul>
<li>Gebruikers correct zijn aangemaakt en toegewezen aan de juiste rollen.</li>
<li>De gebruiker correct kan inloggen en de juiste permissies heeft.</li>
</ul></li>
<li>Bij opdracht14 wordt nu getest of :
<ul>
<li>De middleware correct is ingesteld voor de routes.</li>
<li>De routes correct zijn beveiligd met de juiste permissies.</li>
</ul></li>
<li>Bij opdracht15 wordt nu getest of :
<ul>
<li>Rollen en permissies correct zijn ingesteld voor toegang tot projectbeheer.</li>
<li>De projectbeheerfunctionaliteit correct werkt voor gebruikers met de juiste rollen en permissies.</li>
</ul></li>
<li>Bij opdracht16 wordt nu getest of :
<ul>
<li>De tabel 'tasks' correct is aangemaakt met de juiste kolommen en datatypes.</li>
<li>De relaties tussen 'tasks', 'users', 'projects' en 'activities' correct zijn gedefinieerd met de juiste foreign key constraints.</li>
<li>De juiste migraties en modellen zijn aangemaakt voor 'tasks' en 'activities'.</li>
</ul></li>
<li>Bij opdracht17 wordt nu getest of :
<ul>
<li>De factory voor 'tasks' correct is aangemaakt en data kan genereren die voldoet aan de kolomgrootte en validatievoorwaarden.</li>
<li>De gegenereerde data wordt opgeslagen in de database en voldoet aan de vereisten.</li>
</ul></li>
<li>Bij opdracht18 wordt nu getest of :
<ul>
<li>De seeder voor 'tasks' correct is aangemaakt en minimaal 10 taken genereert.</li>
<li>De gegenereerde data correct in de database wordt opgeslagen.</li>
<li>De juiste volgorde van seeding is gewaarborgd.</li>
</ul></li>
<li>Bij opdracht19 wordt nu getest of :
<ul>
<li>De resource controller voor 'tasks' correct is aangemaakt met de juiste named routes.</li>
<li>De indexpagina voor taken binnen de masterpage correct wordt weergegeven.</li>
<li>De indexpagina de juiste taken weergeeft met alle vereiste kolommen en data.</li>
<li>De paginering op de indexpagina correct werkt.</li>
<li>De show-, edit-, en delete-links correct worden weergegeven op de indexpagina.</li>
</ul></li>
<li>Bij opdracht20 wordt nu getest of :
<ul>
<li>De permissies voor 'tasks' correct zijn aangemaakt en toegewezen aan de juiste rollen.</li>
<li>De toegang tot de verschillende methoden van de 'tasks' controller correct is beveiligd met de juiste permissies.</li>
<li>De juiste middleware voor permissiebeheer wordt gebruikt in de controller.</li>
</ul></li>
<li>Bij opdracht21 wordt nu getest of :
<ul>
<li>De create methode van de 'tasks' controller correct werkt en de juiste view retourneert.</li>
<li>Het create formulier de juiste inputvelden bevat en de correcte dropdown opties toont voor 'users', 'projects' en 'activities'.</li>
<li>De juiste action en method voor het formulier zijn ingesteld.</li>
</ul></li>
<li>Bij opdracht22 wordt nu getest of :
<ul>
<li>De store methode van de 'tasks' controller correct werkt en de gegevens valideert en opslaat in de database.</li>
<li>De juiste validatieregels worden toegepast en foutmeldingen correct worden weergegeven bij validatie errors.</li>
<li>Mass assignment niet mogelijk is door het correct instellen van de guarded eigenschappen in het model.</li>
<li>Na correct opslaan er een redirect naar de indexpagina wordt gebruikt met een flash message.</li>
</ul></li>
<li>Bij opdracht23 wordt nu getest of :
<ul>
<li>De show methode van de 'tasks' controller correct werkt en de juiste view retourneert.</li>
<li>De show view de correcte gegevens van de taak weergeeft.</li>
</ul></li>
<li>Bij opdracht24 wordt nu getest of :
<ul>
<li>De edit methode van de 'tasks' controller correct werkt en de juiste view retourneert.</li>
<li>Het edit formulier de juiste inputvelden bevat met de correcte vooraf ingevulde gegevens van de taak.</li>
<li>De correcte dropdown opties toont voor 'users', 'projects' en 'activities' met de huidige waarden geselecteerd.</li>
<li>De juiste action en method voor het formulier zijn ingesteld.</li>
</ul></li>
<li>Bij opdracht25 wordt nu getest of :
<ul>
<li>De update methode van de 'tasks' controller correct werkt en de gegevens valideert en bijwerkt in de database.</li>
<li>De juiste validatieregels worden toegepast en foutmeldingen correct worden weergegeven bij validatie errors.</li>
<li>Mass assignment niet mogelijk is door het correct instellen van de guarded eigenschappen in het model.</li>
<li>Na correct bijwerken er een redirect naar de indexpagina wordt gebruikt met een flash message.</li>
<li>De update methode de TaskStoreRequest gebruikt voor validatie.</li>
</ul></li>
<li>Bij opdracht26 wordt nu getest of :
<ul>
<li>De delete methode van de 'tasks' controller correct werkt en de juiste view retourneert.</li>
<li>De delete view de correcte gegevens van de taak weergeeft met alle inputvelden disabled.</li>
<li>De juiste action en method voor het formulier zijn ingesteld.</li>
</ul></li>
<li>Bij opdracht27 wordt nu getest of :
<ul>
<li>De destroy methode van de 'tasks' controller correct werkt en de taak verwijdert uit de database.</li>
<li>Na correct verwijderen er een redirect naar de indexpagina wordt gebruikt met een flash message.</li>
</ul></li>
</ol>

## De installatie (bijv wampserver)
Voer de volgende stappen uit om met deze opdrachten aan de slag te gaan.
<ul>
    <li>Clone het project in een directory</li>
    <li>Maak in wampserver een virtualhost aan en zet de document root op de public map. Gebruik minimaal php versie 8.2</li>
    <li>Zorg dat je bij de phpMyAdmin kan komen</li>
    <li>Maak 1 databases aan: laravelopdr</li>
    <li>Maak een .env file aan, en kopier de .env.example daar naartoe</li>
    <li>In de .env file, check de database naam (laravelopdr) en de username (root)</li>
    <li>Ga naar je root directory van je project in de terminal, en voer daar uit: composer install</li>
    <li>Voer dan in de terminal uit: php artisan key:generate</li>
    <li>Voer dan in de terminal uit: php artisan migrate</li>
</ul>

Gebruik je een andere omgeving, dan zal je soortgelijke stappen moeten nemen om de opdrachten klaar te zetten.

## Contact
Wil je ook aan de slag met deze opdrachten en heb je hiervoor de lessenserie met opdracht beschrijvingen nodig. Neem dan contact op met mij via m.koningstein@tcrmbo.nl 
