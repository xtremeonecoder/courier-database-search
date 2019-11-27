<?php
/**
 * Search Engine for Finding Courier Services
 *
 * @category   Application_Core
 * @package    courier-search-engine
 * @author     Suman Barua
 * @developer  Suman Barua <sumanbarua576@gmail.com>
 */

/**
 * @category   Application_Core
 * @package    courier-search-engine
 */

return array(
    'landing_home' => array(
        'route' => '/',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'index',
            'action' => 'index'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'member_login' => array(
        'route' => 'login/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'login'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'member_logout' => array(
        'route' => 'logout/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'logout'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'member_signup' => array(
        'route' => 'register/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'register'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'account_activation' => array(
        'route' => 'activation/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'activation'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'reset_password' => array(
        'route' => 'reset/:key/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'reset'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'activate_account' => array(
        'route' => 'activate/:key/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'auth',
            'action' => 'activate'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'admin_dashboard' => array(
        'route' => 'admin/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin',
            'action' => 'index'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'user_dashboard' => array(
        'route' => 'dashboard/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'user',
            'action' => 'index'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'company_availability' => array(
        'route' => 'company/availability/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'availability',
            'action' => 'browse'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '(index|browse|add|edit|delete)'
        )
    ),
    'courier_profile' => array(
        'route' => 'profile/:id/:slug/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'profile'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'courier_send_mail' => array(
        'route' => 'courier/:id/send-email/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'send-email'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'courier_search' => array(
        'route' => 'couriers/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'browse'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '(index|browse)',
        )
    ),
    'courier_list' => array(
        'route' => 'couriers/list/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'list'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'courier_availability' => array(
        'route' => 'couriers/availability/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'availability'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'courier_availability_map' => array(
        'route' => 'couriers/availability-on-map/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'company',
            'action' => 'map-availability'
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'admin_courier_general' => array(
        'route' => 'admin/couriers/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-courier',
            'action' => 'browse'
        ),
        'reqs' => array(
            'id' => '\d+',
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'admin_courier_action' => array(
        'route' => 'admin/courier/:id/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-courier',
            'action' => ''
        ),
        'reqs' => array(
            'id' => '\d+',
            'controller' => '\D+',
            'action' => '(edit|delete|vehicles|insurance|payment-terms|services)',
        )
    ),
    'admin_courier_info' => array(
        'route' => 'admin/courier/:cid/:type/:id/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-courier-edit',
            'action' => ''
        ),
        'reqs' => array(
            'id' => '\d+',
            'cid' => '\d+',
            'controller' => '\D+',
            'action' => '(edit-vehicle|delete-vehicle|edit-insurance|delete-insurance|edit-payment-term|delete-payment-term|edit-service|delete-service)',
        )
    ),
    'admin_courier_general_info' => array(
        'route' => 'admin/courier/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-courier-edit',
            'action' => ''
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'admin_page_general' => array(
        'route' => 'admin/pages/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-pages',
            'action' => 'browse'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'admin_page_action' => array(
        'route' => 'admin/page/:id/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-pages',
            'action' => ''
        ),
        'reqs' => array(
            'id' => '\d+',
            'controller' => '\D+',
            'action' => '(edit|delete)',
        )
    ),
    'admin_mail_general' => array(
        'route' => 'admin/mails/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-mail',
            'action' => 'browse'
        ),
        'reqs' => array(
            'action' => '\D+',
            'controller' => '\D+'
        )
    ),
    'admin_mail_action' => array(
        'route' => 'admin/mail/:id/:action/*',
        'defaults' => array(
            'module' => 'default',
            'controller' => 'admin-mail',
            'action' => ''
        ),
        'reqs' => array(
            'id' => '\d+',
            'controller' => '\D+',
            'action' => '(edit|status|delete|test-mail|reset)',
        )
    ),
);
?>