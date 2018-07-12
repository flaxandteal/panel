<?php

return array(

    /**
     * Controllers in the Panel
     *
     * @var array
     **/
    'panelControllers' => array(
       'Admin',
       'Permission',
       'Role',
       'Link'
    ),

    // Uncomment the section below to use links specified here rather than in the DB table "links"
    // 'links' => [
    //     'Links'       => [ // use the display name as the key
    //         'model'     => 'Link', // model name, same as "url" in the database
    //         'custom'    => false, // not "main"? defaults to true
    //         'show_menu' => true, // defaults to true
    //     ],
    //     'Roles'       => [
    //         'model'     => 'Role',
    //         'custom'    => false,
    //         'show_menu' => true,
    //     ],
    //     'Permissions' => [
    //         'model'     => 'Permission',
    //         'custom'    => false,
    //         'show_menu' => true,
    //     ],
    //     'Admins'      => [
    //         'model'     => 'Admin',
    //         'custom'    => false,
    //         'show_menu' => true,
    //     ],
    // ],

    // Example of short notation style:
    // 'links' => [
    //     'Customers'
    // ],

    // This is equivalent to
    // 'links' => [
    //     'Customers' => [
    //         'model'     => 'Customer',
    //         'custom'    => true,
    //         'show_menu' => true,
    //     ],
    // ],

    /**
     * Excel export available
     *
     * @var bool
     **/
    'excel' => false,

    /**
     * Logo of the Panel
     *
     * @var filePath
     **/
    'logo'=>'packages/serverfireteam/panel/img/logo.png',

    /**
     * Specific model path in the app folder e.g. 'Models'
     *
     * @var string
     **/
    'modelPath' => '',
);
