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
