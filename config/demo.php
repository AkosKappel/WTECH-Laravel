<?php

/*
|--------------------------------------------------------------------------
| Demo Shop
|--------------------------------------------------------------------------
|
| SmartTech is a portfolio project, not a real shop. These settings feed the
| demo notice, the About and Contact pages and the footer links. Links that
| are left empty are not shown.
|
*/

return [

    'author' => env('DEMO_AUTHOR', 'Ákos Kappel'),

    'links' => [
        'github' => env('DEMO_GITHUB_URL', 'https://github.com/AkosKappel'),
        'repository' => env('DEMO_REPOSITORY_URL', 'https://github.com/AkosKappel/WTECH-Laravel'),
        'linkedin' => env('DEMO_LINKEDIN_URL'),
        'portfolio' => env('DEMO_PORTFOLIO_URL'),
    ],

];
