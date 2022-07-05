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

    'title' => '',
    'title_prefix' => 'Pesquera | ',
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
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => 'Pesquera <b>HL</b>',
    'logo_img' => 'static/images/logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Pesquera',

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
    'usermenu_header' => true,
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
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,

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

    'sidebar_mini' => false,
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
    'dashboard_url' => 'admin',
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
        // [
        //     'text' => 'Busqueda',
        //     'search' => true,
        //     'topnav' => true,
        // ],

        // [
        //     'text' => 'Lista',
        //     'url' => '#',
        //     'topnav' => true
        // ],

        // [
        //     'text' => 'blog',
        //     'url'  => 'admin/blog',
        //     'can'  => 'manage-blog',
        // ],
        [
            'text' => 'Inicio',
            'url' => 'admin',
            'icon' => 'fas fa-home',
            'icon_color' => 'yellow',
            'can'  => 'admin.inicio',
        ],
        [
            'text' => 'Proveedor | Cliente',
            'route' => 'admin.clientes.index',
            'icon' => 'fas fa-address-card',
            'icon_color' => 'yellow',
            'can'  => 'admin.clientes.index',
            'active' => ['admin/clientes','admin/clientes/create','admin/clientes/*/edit'],
        ],

        // ['header' => 'COMPRAS'],
        [
            'text'    => 'COMPRAS',
            'icon'    => 'fas fa-cart-plus',
            'icon_color' => 'yellow',
            'can'  => 'admin.compras',
            'submenu' => [
                [
                    'text' => 'Compras | Servicios',
                    'icon'    => 'fas fa-cart-plus',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.rcompras.index',
                    'can'  => 'admin.rcompras.index',
                    'active' => ['admin/rcompras','admin/rcompras/*','admin/rcompras/create'
                                ,'admin/rcompras/*/edit'],
                ],
                [
                    'text' => 'Ingresos Almacen',
                    'icon'    => 'fas fa-plus-circle',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.ingresos.index',
                    'can'  => 'admin.ingresos.index',
                    'active' => ['admin/ingresos','admin/ingresos/*','admin/ingresos/create'
                                ,'admin/ingresos/*/edit'],
                ],
                [
                    'text' => 'Ingresos Materia Prima',
                    'icon'    => 'fas fa-fish',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.materiaprimas.index',
                    'can'  => 'admin.materiaprimas.index',
                    'active' => ['admin/materiaprimas','admin/materiaprimas/*','admin/materiaprimas/create'
                                ,'admin/materiaprimas/*/edit'],
                ],
                [
                    'text' => 'Cotizaciones',
                    'icon'    => 'fas fa-file-alt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.cotizacions.index',
                    'can'  => 'admin.cotizacions.index',
                    'active' => ['admin/cotizacions','admin/cotizacions/*','admin/cotizacions/create'
                                ,'admin/cotizacions/*/edit'],
                ],
                [
                    'text' => 'Orden de Compra',
                    'icon'    => 'fas fa-file-import',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.ordcompras.index',
                    'can'  => 'admin.ordcompras.index',
                    'active' => ['admin/ordcompras','admin/ordcompras/*','admin/ordcompras/create'
                                ,'admin/ordcompras/*/edit'],
                ],
                [
                    'text' => 'Reportes',
                    'icon'    => 'fas fa-print',
                    'icon_color' => 'cyan',
                    'submenu' => [
                        [
                            'text' => 'Mensual Tolvas',
                            'icon'    => 'fas fa-print',
                            'icon_color' => 'white',
                            'route'  => 'admin.excel.tolvasindex',
                            // 'can'  => 'admin.rcompras.index',
                            'active' => ['admin/excel/tolvasindex'],
                        ],
                    ],
                ]
            ],
        ],
        // ['header' => 'VEMTAS'],
        [
            'text'    => 'VENTA | CONSUMO',
            'icon'    => 'fa fa-file-invoice-dollar',
            'icon_color' => 'yellow',
            'can'  => 'admin.ventas',
            'submenu' => [
                [
                    'text' => 'Registro de Ventas',
                    'icon'    => 'fas fa-cash-register',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.rventas.index',
                    'can'  => 'admin.rventas.index',
                    'active' => ['admin/rventas','admin/rventas/*','admin/rventas/create'
                                ,'admin/rventas/*/edit'],
                ],
                [
                    'text' => 'Consumos',
                    'icon'    => 'fas fa-cart-arrow-down',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.consumos.index',
                    'can'  => 'admin.consumos.index',
                    'active' => ['admin/consumos','admin/consumos/*','admin/consumos/create'
                                ,'admin/consumos/*/edit'],
                ],
                [
                    'text' => 'Guías de Remisión',
                    'icon'    => 'fas fa-receipt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.guias.index',
                    'can'  => 'admin.guias.index',
                    'active' => ['admin/guias','admin/guias/*','admin/guias/create'
                                ,'admin/guias/*/edit'],
                ],          
                [
                    'text' => 'Pedidos',
                    'icon'    => 'fas fa-file-archive',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.pedidos.index',
                    'can'  => 'admin.pedidos.index',
                    'active' => ['admin/pedidos','admin/pedidos/*','admin/pedidos/create'
                                ,'admin/pedidos/*/edit'],
                ],              
                [
                    'text' => 'Reportes',
                    'icon'    => 'fas fa-print',
                    'icon_color' => 'cyan',
                ]
            ],
        ],
        // ['header' => 'TESORERIA'],
        [
            'text'    => 'TESORERIA',
            'icon'    => 'fas fa-dollar-sign',
            'icon_color' => 'yellow',
            'can'  => 'admin.compras',
            'submenu' => [
                [
                    'text' => 'Caja y Bancos',
                    'icon'    => 'fas fa-funnel-dollar',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.tesorerias.index',
                    'can'  => 'admin.tesorerias.index',
                    'active' => ['admin/tesorerias','admin/tesorerias/*','admin/tesorerias/create'
                                ,'admin/tesorerias/*/edit'],
                ],
                [
                    'text' => 'Pagos Masivos',
                    'icon'    => 'fas fa-file-invoice-dollar',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.masivos.index',
                    'can'  => 'admin.masivos.index',
                    'active' => ['admin/masivos','admin/masivos/*','admin/masivos/create'
                                ,'admin/masivos/*/edit'],
                ],
                [
                    'text' => 'Transferencias entre Cuenta',
                    'icon'    => 'fas fa-money-bill-wave',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.transferencias.index',
                    'can'  => 'admin.transferencias.index',
                    'active' => ['admin/transferencias','admin/transferencias/*','admin/transferencias/create'
                                ,'admin/transferencias/*/edit'],
                ],
                [
                    'text' => 'Reportes',
                    'icon'    => 'fas fa-print',
                    'icon_color' => 'cyan',
                    'url'  => '#',
                ]
            ],
        ],
        [
            'text'    => 'PROCESO',
            'icon'    => 'fas fa-industry',
            'icon_color' => 'yellow',
            'can'  => 'admin.proceso',
            'submenu' => [
                [
                    'text' => 'Planilla de Envasado',
                    'icon'    => 'far fa-clipboard',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.envasados.index',
                    'can'  => 'admin.envasados.index',
                    'active' => ['admin/envasados','admin/envasados/*','admin/envasados/create'
                                ,'admin/envasados/*/edit'],
                ],
                [
                    'text' => 'Planilla de Envasado Crudo',
                    'icon'    => 'far fa-clipboard',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.envasadocrudos.index',
                    'can'  => 'admin.envasadocrudos.index',
                    'active' => ['admin/envasadocrudos','admin/envasadocrudos/*','admin/envasadocrudos/create'
                                ,'admin/envasadocrudos/*/edit'],
                ],
                [
                    'text' => 'Guía de Ingreso a Cámaras',
                    'icon'    => 'fas fa-clipboard-check',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.ingcamaras.index',
                    'can'  => 'admin.ingcamaras.index',
                    'active' => ['admin/ingcamaras','admin/ingcamaras/*','admin/ingcamaras/create'
                                ,'admin/ingcamaras/*/edit'],
                ],
                [
                    'text' => 'Residuos Sólidos',
                    'icon'    => 'far fa-trash-alt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.residuos.index',
                    'can'  => 'admin.residuos.index',
                    'active' => ['admin/residuos','admin/residuos/*','admin/residuos/create'
                                ,'admin/residuos/*/edit'],
                ],
                [
                    'text' => 'Parte de Producción',
                    'icon'    => 'fas fa-industry',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.partes.index',
                    'can'  => 'admin.partes.index',
                    'active' => ['admin/partes','admin/partes/*','admin/partes/create'
                                ,'admin/partes/*/edit'],
                ],
            ],
        ],

        // [
        //     'text'        => 'pages',
        //     'url'         => 'admin/pages',
        //     'icon'        => 'far fa-fw fa-file',
        //     'label'       => 4,
        //     'label_color' => 'success',
        // ],
        
        ['header' => 'VARIOS'],
        // ['header' => 'Tablas del Sistema'],
        [
            'text'    => 'Tablas del Sistema',
            'icon'    => 'fas fa-folder-open',
            'icon_color' => 'yellow',
            'can'  => 'admin.tablas',
            'submenu' => [
                [
                    'text' => 'Lotes',
                    'icon'    => 'fas fa-barcode',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.lotes.index',
                    'active' => ['admin/lotes','admin/lotes/*','admin/lotes/create'
                                ,'admin/lotes/*/edit'],
                    'can'  => 'admin.lotes.index',
                ],
                [
                    'text' => 'Categorías',
                    'icon'    => 'fas fa-folder-open',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.categorias.index',
                    'active' => ['admin/categorias','admin/categorias/*','admin/categorias/create'
                                ,'admin/categorias/*/edit'],
                    'can'  => 'admin.categorias.index',
                ],
                [
                    'text' => 'Categoría Productos',
                    'icon'    => 'fas fa-folder-open',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.catproductos.index',
                    'active' => ['admin/catproductos','admin/catproductos/*','admin/catproductos/create'
                                ,'admin/catproductos/*/edit'],
                    'can'  => 'admin.catproductos.index',
                ],
                [
                    'text' => 'Producto | Servicio',
                    'icon'    => 'fas fa-window-restore',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.productos.index',
                    'active' => ['admin/productos','admin/productos/*','admin/productos/create'
                                ,'admin/productos/*/edit'],
                    'can'  => 'admin.productos.index',
                ],
                [
                    'text' => 'Saldos Iniciales de Productos',
                    'icon'    => 'fas fa-window-restore',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.saldos.index',
                    'active' => ['admin/saldos','admin/saldos/create'
                                ,'admin/saldos/*/edit'],
                    'can'  => 'admin.saldos.index',
                ],
                [
                    'text' => 'Unidad Medida',
                    'icon'    => 'fas fa-ruler-combined',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.umedidas.index',
                    'active' => ['admin/umedidas','admin/umedidas/*','admin/umedidas/create'
                                ,'admin/umedidas/*/edit'],
                    'can'  => 'admin.umedidas.index',
                ],
                [
                    'text' => 'Tipo Producto',
                    'icon'    => 'fas fa-tablets',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.tipoproductos.index',
                    'active' => ['admin/tipoproductos','admin/tipoproductos/*','admin/tipoproductos/create'
                                ,'admin/tipoproductos/*/edit'],
                    'can'  => 'admin.tipoproductos.index',
                ],
                [
                    'text' => 'Tipo Comprobante',
                    'icon'    => 'fas fa-list-alt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.tipocomprobantes.index',
                    'active' => ['admin/tipocomprobantes','admin/tipocomprobantes/*','admin/tipocomprobantes/create'
                                ,'admin/tipocomprobantes/*/edit'],
                    'can'  => 'admin.tipocomprobantes.index',
                ],
                [
                    'text' => 'Cuentas',
                    'icon'    => 'fas fa-money-check-alt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.cuentas.index',
                    'active' => ['admin/cuentas','admin/cuentas/*','admin/cuentas/create'
                                ,'admin/cuentas/*/edit'],
                    'can'  => 'admin.cuentas.index',
                ],
                [
                    'text' => 'Destinos',
                    'icon'    => 'fas fa-chart-bar',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.destinos.index',
                    'active' => ['admin/destinos','admin/destinos/*','admin/destinos/create'
                                ,'admin/destinos/*/edit'],
                    'can'  => 'admin.destinos.index',
                ],
                // [
                //     'text' => 'Centros de Costo',
                //     'icon'    => 'fas fa-grip-horizontal',
                //     'icon_color' => 'cyan',
                //     'route'  => 'admin.ccostos.index',
                //     'active' => ['admin/ccostos','admin/ccostos/*','admin/ccostos/create'
                //                 ,'admin/ccostos/*/edit'],
                //     'can'  => 'admin.ccostos.index',
                // ],
                [
                    'text' => 'Empresas Acopiadoras',
                    'icon'    => 'fas fa-newspaper',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.empacopiadoras.index',
                    'active' => ['admin/empacopiadoras','admin/empacopiadoras/*','admin/empacopiadoras/create'
                                ,'admin/empacopiadoras/*/edit'],
                    'can'  => 'admin.empacopiadoras.index',
                ],                
                [
                    'text' => 'Transportistas',
                    'icon'    => 'fas fa-truck-moving',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.transportistas.index',
                    'active' => ['admin/transportistas','admin/transportistas/*','admin/transportistas/create'
                                ,'admin/transportistas/*/edit'],
                    'can'  => 'admin.transportistas.index',
                ],
                [
                    'text' => 'Embarcaciones',
                    'icon'    => 'fas fa-anchor',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.embarcaciones.index',
                    'active' => ['admin/embarcaciones','admin/embarcaciones/*','admin/embarcaciones/create'
                                ,'admin/embarcaciones/*/edit'],
                    'can'  => 'admin.embarcaciones.index',
                ],
                [
                    'text' => 'Muelles',
                    'icon'    => 'fab fa-docker',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.muelles.index',
                    'active' => ['admin/muelles','admin/muelles/*','admin/muelles/create'
                                ,'admin/muelles/*/edit'],
                    'can'  => 'admin.muelles.index',
                ],
                [
                    'text' => 'Materia Prima Obtenida',
                    'icon'    => 'fab fa-docker',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.mpobtenidas.index',
                    'active' => ['admin/mpobtenidas','admin/mpobtenidas/*','admin/mpobtenidas/create'
                                ,'admin/mpobtenidas/*/edit'],
                    'can'  => 'admin.mpobtenidas.index',
                ],
                [
                    'text' => 'Despiece',
                    'icon'    => 'fas fa-dice-d20',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.despieces.index',
                    'active' => ['admin/despieces','admin/despieces/*','admin/despieces/create'
                                ,'admin/despieces/*/edit'],
                    'can'  => 'admin.despieces.index',
                ],
                [
                    'text' => 'Productos Proceso',
                    'icon'    => 'fas fa-dolly-flatbed',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.pprocesos.index',
                    'active' => ['admin/pprocesos','admin/pprocesos/*','admin/pprocesos/create'
                                ,'admin/pprocesos/*/edit'],
                    'can'  => 'admin.pprocesos.index',
                ],
                [
                    'text' => 'Supervisores',
                    'icon'    => 'fas fa-chalkboard-teacher',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.supervisors.index',
                    'active' => ['admin/supervisors','admin/supervisors/*','admin/supervisors/create'
                                ,'admin/supervisors/*/edit'],
                    'can'  => 'admin.supervisors.index',
                ],
                [
                    'text' => 'Equipo de Envasado',
                    'icon'    => 'fas fa-inbox',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.equipoenvasados.index',
                    'active' => ['admin/equipoenvasados','admin/equipoenvasados/*','admin/equipoenvasados/create'
                                ,'admin/equipoenvasados/*/edit'],
                    'can'  => 'admin.equipoenvasados.index',
                ],
                [
                    'text' => 'Contratas',
                    'icon'    => 'fas fa-people-carry',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.contratas.index',
                    'active' => ['admin/contratas','admin/contratas/*','admin/contratas/create'
                                ,'admin/contratas/*/edit'],
                    'can'  => 'admin.contratas.index',
                ],
                [
                    'text' => 'Paises',
                    'icon'    => 'fas fa-globe-americas',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.countries.index',
                    'active' => ['admin/countries','admin/countries/*','admin/countries/create'
                                ,'admin/countries/*/edit'],
                    'can'  => 'admin.countries.index',
                ],
                [
                    'text' => 'Detracciones',
                    'icon'    => 'fas fa-receipt',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.detraccions.index',
                    'active' => ['admin/detraccions','admin/detraccions/*','admin/detraccions/create'
                                ,'admin/detraccions/*/edit'],
                    'can'  => 'admin.detraccions.index',
                ],
                [
                    'text' => 'Usuarios',
                    'icon'    => 'fas fa-user-friends',
                    'icon_color' => 'cyan',
                    // 'url'  => 'admin/usuarios',
                    'route'  => 'admin.usuarios.index',
                    'active' => ['admin/usuarios/all','admin/usuarios/1','admin/usuarios/2','admin/usuario/create'
                                ,'admin/usuario/*/edit','admin/usuario/*/editpermission'],
                    'can'  => 'admin.usuarios.index',
                ],
                [
                    'text' => 'Roles',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.roles.index',
                    'active' => ['admin/roles/index','admin/roles/create','admin/roles/*/edit'],
                    'can'  => 'admin.roles.index',
                ],
                [
                    'text' => 'Destinatarios e-mail',
                    'icon'    => 'fas fa-envelope',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.mensajerias.index',
                    'active' => ['admin/mensajerias/index','admin/mensajerias/create','admin/mensajerias/*/edit'],
                    'can'  => 'admin.mensajerias.index',
                ],
            ],
        ],
        // ['header' => 'Utilitarios'],
        [
            'text'    => 'Utilitarios',
            'icon'    => 'fas fa-cogs',
            'icon_color' => 'yellow',
            'can'  => 'admin.util',
            'submenu' => [
                [
                    'text' => 'Parámetros',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'can' => 'admin.parametros.index',
                    'route'  => 'admin.parametros.index',
                ],
                [
                    'text' => 'Cierre Mes',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'can' => 'admin.utils.cierre',
                    'route'  => 'admin.saldos.cierremes',
                ],
                [
                    'text' => 'Regenerar Saldos',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'can' => 'admin.utils.regenerasaldo',
                    'route'  => 'admin.saldos.gregenera',
                ],                
                [
                    'text' => 'Vencimientos',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'can' => 'admin.utils.vencimiento',
                    'url'  => '#',
                ],
                [
                    'text' => 'Import',
                    'icon'    => 'fas fa-cog',
                    'icon_color' => 'cyan',
                    'route'  => 'admin.imports.index',
                ],
            ],
        ],
        // [
        //     'text' => 'profile',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-user',
        // ],
        // [
        //     'text' => 'change_password',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-lock',
        // ],
        // [
        //     'text'    => 'multilevel',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //         [
        //             'text'    => 'level_one',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text'    => 'level_two',
        //                     'url'     => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //     ],
        // ],
        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
    ],

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
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
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
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
