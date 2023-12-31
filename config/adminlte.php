<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Nutri</b>Soft',
    //'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'img/logo-sin-fondo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs logo-larger',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
       /* [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],*/

        // Sidebar items:
        /*[
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],*/
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        /*[
            'text'        => 'pages',
            'url'         => 'admin/pages',
            'icon'        => 'far fa-fw fa-file',
            'label'       => 4,
            'label_color' => 'success',
        ],*/
        [
            'text' => 'Página principal',
            'url'  => 'dashboard',
            'icon' => 'fas fa-home fa-fw',
        ],

        [
            'text' => 'Mis datos',
            'route'  => 'historia-clinica.index',
            'icon' => 'fas fa-notes-medical fa-fw',
            'can' => 'historia-clinica.index',
        ],

        [
            'text' => 'Turnos',
            'icon' => 'fas fa-calendar-alt fa-fw',
            'can' => 'turnos',
            'submenu' => [
                [
                    'text' => 'Mis Turnos',
                    'icon' =>'fas fa-fw fa-list',
                    'route'  => 'turnos.index',
                ],
                [
                    'text' => 'Solicitar un turno',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'turnos.create',
                ],
            ],
        ],

        [
            'text' => 'Turnos y Consultas',
            'icon' => 'fas fa-clock fa-fw',
            'can' => 'gestion-turnos-nutricionista.index',
            'submenu' => [
                [
                    'text' => 'Turnos Pendientes',
                    'icon' =>'fas fa-fw fa-list',
                    'route'  => 'gestion-turnos-nutricionista.index',
                ],
                [
                    'text' => 'Historial de turnos',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'gestion-turnos-nutricionista.showHistorialTurnos',
                ],
            ],
        ],

        [
            'text' => 'Mis Planes',
            'icon' => 'fas fa-clipboard-check fa-fw',
            'can' => 'mis-planes',
            'submenu' => [
                [
                    'text' => 'Planes de Alimentación',
                    'icon' =>'fas fa-fw fa-utensils',
                    'route'  => 'plan-alimentacion.index',
                ],
                [
                    'text' => 'Planes de Seguimiento',
                    'icon' =>'fas fa-fw fa-receipt',
                    'route'  => 'plan-seguimiento.index',
                ],
            ],
        ],

        [
            'text' => 'Gestión de planes',
            'icon' => 'fas fa-clipboard-check fa-fw',
            'can' => 'planes-a-confirmar',
            'submenu' => [
                [
                    'text' => 'Planes de Alimentación',
                    'icon' =>'fas fa-fw fa-utensils',
                    'route'  => 'plan-alimentacion.planesAlimentacionAConfirmar',
                ],
                [
                    'text' => 'Planes de Seguimiento',
                    'icon' =>'fas fa-fw fa-receipt',
                    'route'  => 'plan-seguimiento.planesSeguimientoAConfirmar',
                ],
            ],
        ],

        [
            'text' => 'Gestión Tratamientos',
            'route' => 'gestion-tratamientos.index',
            'icon' => 'fas fa-comment-medical fa-fw',
            'can' => 'gestion-tratamientos.index',
        ],

        [
            'text' => 'Pliegues Cutáneos',
            'route' => 'gestion-pliegues-cutaneos.index',
            'icon' => 'fas fa-ruler fa-fw',
            'can' => 'gestion-pliegues-cutaneos.index',
        ],

        [
            'text' => 'Horarios de Atención',
            'route'  => 'gestion-atencion.index',
            'icon' => 'fas fa-lock fa-fw',
            'can' => 'gestion-atencion.index',
        ],

        [
            'text' => 'Gestión Médica',
            'icon' => 'fas fa-laptop-medical',
            'can' => 'gestion-medica.index',
            'submenu' => [
                [
                    'text'    => 'Patologías',
                    'icon'    => 'fas fa-fw fa-stethoscope',
                    'submenu' => [
                        [
                            'text' => 'Lista de Patologías',
                            'icon' =>'fas fa-fw fa-briefcase-medical',
                            'route'  => 'gestion-patologias.index',
                        ],
                        [
                            'text' => 'Nueva Patología',
                            'icon' =>'fas fa-fw fa-file-medical',
                            'route'  => 'gestion-patologias.create',
                        ],
                        [
                            'text' => 'Alimentos prohibidos',
                            'icon' =>'fas fa-fw fa-ban',
                            'route'  => 'prohibiciones-patologias.create',
                        ],
                        [
                            'text' => 'Actividades prohibidas',
                            'icon' =>'fas fa-fw fa-ban',
                            'route'  => 'prohibiciones-patologias.actividades.create',
                        ],
                    ],
                ],
                [
                    'text'    => 'Alergias',
                    'icon'    => 'fas fa-fw fa-head-side-mask',
                    'submenu' => [
                        [
                            'text' => 'Lista de Alergias',
                            'icon' =>'fas fa-fw fa-briefcase-medical',
                            'route'  => 'gestion-alergias.index',
                        ],
                        [
                            'text' => 'Nueva Alergia',
                            'icon' =>'fas fa-fw fa-file-medical',
                            'route'  => 'gestion-alergias.create',
                        ],
                        [
                            'text' => 'Alimentos prohibidos',
                            'icon' =>'fas fa-fw fa-ban',
                            'route'  => 'prohibiciones-alergias.create',
                        ],
                    ],
                ],
                [
                    'text'    => 'Cirugías',
                    'icon'    => 'fas fa-fw fa-star-of-life',
                    'submenu' => [
                        [
                            'text' => 'Lista de Cirugías',
                            'icon' =>'fas fa-fw fa-briefcase-medical',
                            'route'  => 'gestion-cirugias.index',
                        ],
                        [
                            'text' => 'Nueva Cirugía',
                            'icon' =>'fas fa-fw fa-file-medical',
                            'route'  => 'gestion-cirugias.create',
                        ],
                        [
                            'text' => 'Actividades prohibidas',
                            'icon' =>'fas fa-fw fa-ban',
                            'route'  => 'prohibiciones-cirugias.actividades.create',
                        ],
                    ],
                ],
                [
                    'text'    => 'Intolerancias',
                    'icon'    => 'fas fa-fw fa-capsules',
                    'submenu' => [
                        [
                            'text' => 'Lista de Intolerancias',
                            'icon' =>'fas fa-fw fa-briefcase-medical',
                            'route'  => 'gestion-intolerancias.index',
                        ],
                        [
                            'text' => 'Nueva Intolerancia',
                            'icon' =>'fas fa-fw fa-file-medical',
                            'route'  => 'gestion-intolerancias.create',
                        ],
                        [
                            'text' => 'Alimentos prohibidos',
                            'icon' =>'fas fa-fw fa-ban',
                            'route'  => 'prohibiciones-intolerancias.create',
                        ],
                    ],
                ],
               /* [
                    'text'    => 'Análisis clínico',
                    'icon'    => 'fas fa-fw fa-syringe',
                    'submenu' => [
                        [
                            'text' => 'Lista de Análisis clínico',
                            'icon' =>'fas fa-fw fa-briefcase-medical',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Nuevo Análisis clínico',
                            'icon' =>'fas fa-fw fa-file-medical',
                            'url'  => '#',
                        ],
                    ],
                ],*/

            ],

        ],

        [
            'text' => 'Gestión Alimentos',
            'icon' => 'fas fa-apple-alt',
            'can' => 'gestion-alimentos',
            'submenu' => [
                [
                    'text' => 'Lista de Alimentos',
                    'icon' =>'fas fa-fw fa-list',
                    'route'  => 'gestion-alimentos.index',
                ],
                [
                    'text' => 'Nuevo Alimento',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'gestion-alimentos.create',
                ],
                [
                    'text' => 'Alimentos por Dietas',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'gestion-alimento-por-dietas.create',
                ],
            ],
        ],
        [
            'text' => 'Mi Seguimiento',
            'icon' => 'fas fa-chart-line',
            'route' => 'mi-seguimiento.index',
            'can' => 'consultar-miSeguimiento'
        ],
        [
            'text' => 'Menú Semanal',
            'icon' => 'fas fa-pizza-slice',
            'route' => 'menu-semanal.index',
            'can' => 'consultar-menuSemanal'
        ],

        [
            'text' => 'Gestión Actividades',
            'icon' => 'fas fa-running',
            'can' => 'gestion-actividades',
            'submenu' => [
                [
                    'text' => 'Lista de Actividades',
                    'icon' =>'fas fa-fw fa-list',
                    'route'  => 'gestion-actividades.index',
                ],
                [
                    'text' => 'Nueva Actividad',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'gestion-actividades.create',
                ],
                [
                    'text' => 'Recomendaciones',
                    'icon' =>'fas fa-fw fa-plus',
                    'route'  => 'gestion-actividad-por-tipo-actividad.create',
                ],
            ],
        ],

        [
            'text' => 'Gestión Recetas',
            'route' => 'gestion-recetas.index',
            'icon' => 'fas fa-utensils fa-fw',
            'can' => 'gestion-recetas.index',
        ],

        ['header' => 'GESTIÓN DE USUARIOS',
            'can' => 'gestion-usuarios.index'
        ],
        [
            'text' => 'Usuarios',
            'route'  => 'gestion-usuarios.index',
            'icon' => 'fas fa-users fa-fw',
            'can' => 'Ver usuarios - gestion-usuarios.index'
        ],
        [
            'text' => 'Nuevo usuario',
            'route'  => 'gestion-usuarios.create',
            'icon' => 'fas fa-fw fa-user-plus',
            'can' => 'Crear usuario - gestion-usuarios.create'
        ],

        [
            'text' => 'Roles y permisos',
            'route'  => 'gestion-rolesYPermisos.index',
            'icon' => 'fas fa-crown',
            'can' => 'gestion-rolesYPermisos.index'
        ],

        [
            'text' => 'Estadísticas',
            'route'  => 'gestion-estadisticas.index',
            'icon' => 'fas fa-chart-pie',
            'can' => 'gestion-estadisticas.index',
        ],

        [
            'text' => 'Auditoría',
            'route' => 'auditoria.index',
            'icon' => 'fas fa-shield-alt',
            'can' => 'auditoria.index'
        ],
        /*

        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],*/
        /*
            [
                'text' => 'change_password',
                'url'  => 'admin/settings',
                'icon' => 'fas fa-fw fa-lock',
            ],

            ['header' => 'labels'],
            [
                'text'       => 'important',
                'icon_color' => 'red',
                'url'        => '#',
            ],
            [
                'text'       => 'warning',
                'icon_color' => 'yellow',
                'url'        => '#',
            ],
            [
                'text'       => 'information',
                'icon_color' => 'cyan',
                'url'        => '#',
            ],
        */
    ],
/*
    [
        'text'    => 'level_one',
        'url'     => '#',
        'submenu' => [
            [
                'text' => 'level_two',
                'url'  => '#',
            ],
            [
                'text'    => 'level_two',
                'url'     => '#',
                'submenu' => [
                    [
                        'text' => 'level_three',
                        'url'  => '#',
                    ],
                    [
                        'text' => 'level_three',
                        'url'  => '#',
                    ],
                ],
            ],
        ],
    ],
*/

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
