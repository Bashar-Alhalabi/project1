<?php

return [
    /**
     * Default route to see the UML diagram.
     */
    'route' => '/uml',

    /**
     * You can turn on or off the indexing of specific types
     * of classes. By default, LTU processes only controllers
     * and models.
     */
    'casts' => false,
    'channels' => false,
    'commands' => false,
    'components' => false,
    'controllers' => false,
    'events' => false,
    'exceptions' => false,
    'jobs' => false,
    'listeners' => false,
    'mails' => false,
    'middlewares' => false,
    'models' => true,
    'notifications' => false,
    'observers' => false,
    'policies' => false,
    'providers' => false,
    'requests' => false,
    'resources' => false,
    'rules' => false,

    /**
     * You can define specific nomnoml styling.
     * For more information: https://github.com/skanaar/nomnoml
     */
    'style' => [
        'background' => '#fff',
        'stroke' => '#A0A0A0',
        'arrowSize' => 1,
        'bendSize' => 0.6,
        'direction' => 'down',
        'gutter' => 9,
        'edgeMargin' => 20,
        'gravity' => 7,
        'edges' => 'rounded',
        'fill' => '#fff',
        'fillArrows' => false,
        'font' => 'Calibri',
        'fontSize' => 28,
        'leading' => 3.25,
        'lineWidth' => 4,
        'padding' => 8,
        'spacing' => 90,
        'title' => 'Filename',
        'zoom' => 1,
        'acyclicer' => 'greedy',
        'ranker' => 'longest-path'
    ],

    /**
     * Specific files can be excluded if need be.
     * By default, all default Laravel classes are ignored.
     */
    'excludeFiles' => [
        'Http/Kernel.php',
        'Console/Kernel.php',
        'Exceptions/Handler.php',
        'Http/Controllers/Controller.php',
        'Http/Middleware/Authenticate.php',
        'Http/Middleware/EncryptCookies.php',
        'Http/Middleware/PreventRequestsDuringMaintenance.php',
        'Http/Middleware/RedirectIfAuthenticated.php',
        'Http/Middleware/TrimStrings.php',
        'Http/Middleware/TrustHosts.php',
        'Http/Middleware/TrustProxies.php',
        'Http/Middleware/VerifyCsrfToken.php',
        'Providers/AppServiceProvider.php',
        'Providers/AuthServiceProvider.php',
        'Providers/BroadcastServiceProvider.php',
        'Providers/EventServiceProvider.php',
        'Providers/RouteServiceProvider.php',
    ],

    /**
     * In case you changed any of the default directories
     * for different classes, please amend below.
     */
    'directories' => [
        'casts' => 'Casts/',
        'channels' => 'Broadcasting/',
        'commands' => 'Console/Commands/',
        'components' => 'View/Components/',
        'controllers' => 'Http/Controllers/',
        'events' => 'Events/',
        'exceptions' => 'Exceptions/',
        'jobs' => 'Jobs/',
        'listeners' => 'Listeners/',
        'mails' => 'Mail/',
        'middlewares' => 'Http/Middleware/',
        'models' => 'Models/',
        'notifications' => 'Notifications/',
        'observers' => 'Observers/',
        'policies' => 'Policies/',
        'providers' => 'Providers/',
        'requests' => 'Http/Requests/',
        'resources' => 'Http/Resources/',
        'rules' => 'Rules/',
    ],
];
