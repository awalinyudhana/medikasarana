<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @file
 *
 * Configuration for registered users
 *
 * Designed to be uses with CI-ACL
 * https://github.com/dollardad/CI-ACL
 *
 * This is a very simple ACL no database required login system.
 * The use case for this is small websites with one or two
 * users that require access to update blogs/news etc.
 * It is not designed for fully blown multiple users that can register etc.
 *
 * This has been designed to work with
 * No register function or lost password or remember me.
 *
 * Do you really need to hash the password ! If a hacker has got this far
 * they also have access to your database.php config file, your encryption key
 * in fact everything. You're basically screwed!!!
 *
 * IT IS IMPORTANT THAT THE APPLICATION DIRECTORY IS OUTSIDE OF THE WWW_ROOT or PUBLIC
 * DIRECTORY
 *
 * The password does not need to be hashed if the user has a unique password for this
 * site ie this password is not the same as their bank account password !
 */

$config['hash_password'] = TRUE; // TRUE or FALSE

// If you are going to hash the password do you want to salt it ?
$config['salt'] = 'hytuhyg&65'; // Enter a random string or NULL;

// You can change the login controller name here if you wish
$config['login_controller'] = 'login';

// Set the default landing page for users that successfully login.
// controller/method as a string or NULL, null will be the site main page 
$config['login_landing_page'] = 'users';

// Set the flash message for logging a user out, NULL for no flashdata message
$config['login_message'] = 'Success! You have been logged in.';

// Set the flash message for logging a user out, NULL for no flashdata message
$config['failed_login_message'] = 'Warning! Incorrect username or password.';

// Set the default landing page for users that logout
// string or NULL, null will be the site main page
$config['logout_landing_page'] = 'login';

// Set the flash message for logging a user out, NULL for no flashdata message
$config['logout_message'] = 'Success! You have been logged out.';

// Set the flash message for logging a user out, NULL for no flashdata message
$config['module_auth_message'] = 'please login to access this module.';

//
$config['module_list'] = ["bank_info",
    "card_stock", "credit", "customer", "debit", "delivery_order", "extract", "join", "opname", "pricing",
    "principal", "product", "product_conversion", "product_distribution", "product_return", "proposal",
    "purchase_order", "retail", "retail_return", "sales_order", "sales_order_return", "store", "users", "warehouse"];
$config['module_router'] =
    [
        [
            'title' => 'Master',
            'icon' => 'icon-settings',
            'child' => [
                [
                    'title' => 'Users',
                    'child' => [
                        [
                            'title' => 'Staff List',
                            'url' => 'users',
                            'module' => 'users'
                        ], [
                            'title' => 'Staff Kategori',
                            'url' => 'users/group',
                            'module' => 'users'
                        ]
                    ]
                ], [
                    'title' => 'Store',
                    'url' => 'store',
                    'module' => 'store'
                ], [
                    'title' => 'Gudang',
                    'child' => [[
                        'title' => 'Gudang',
                        'url' => 'warehouse',
                        'module' => 'warehouse'
                    ], [
                        'title' => 'Rack',
                        'url' => 'warehouse/rack',
                        'module' => 'warehouse'
                    ]
                    ]
                ], [
                    'title' => 'Principal',
                    'child' => [
                        [
                            'title' => 'Principal List',
                            'url' => 'principal',
                            'module' => 'principal'
                        ], [
                            'title' => 'Bank Info',
                            'url' => 'bank-info',
                            'module' => 'bank_info'
                        ],
                    ]
                ], [
                    'title' => 'Customer',
                    'url' => 'customer',
                    'module' => 'customer'
                ], [
                    'title' => 'Produk',
                    'child' => [
                        [
                            'title' => "Produk List",
                            'url' => 'product',
                            'module' => 'product'
                        ], [
                            'title' => "Kategori Produk",
                            'url' => 'product/category',
                            'module' => 'product'
                        ], [
                            'title' => "Produk Unit",
                            'url' => 'product/unit',
                            'module' => 'product'
                        ]
                    ]
                ]
            ]
        ],
        [
            'title' => 'Produk',
            'child' => [
                [
                    'title' => "Produk Opname",
                    'url' => 'stock-opname',
                    'module' => 'product_opname'
                ], [
                    'title' => "Produk Opname Store",
                    'url' => 'stock-opname/store',
                    'module' => 'product_opname_store'
                ], [
                    'title' => "Distribusi Produk",
                    'url' => 'product-distribution',
                    'module' => 'product_distribution'
                ], [
                    'title' => "Produk Return",
                    'url' => 'product-returns',
                    'module' => 'product_return'
                ], [
                    'title' => "Produk Pricing",
                    'url' => 'pricing',
                    'module' => 'pricing'
                ], [
                    'title' => "Konversi Produk",
                    'url' => 'product-conversion',
                    'module' => 'product_conversion'
                ], [
                    'title' => 'Product Placing',
                    'url' => 'warehouse/productPlacing',
                    'module' => 'warehouse'
                ]
            ]
        ],
        [
            'title' => 'Purchase Order',
            'icon' => 'icon-tag',
            'child' => [
                [
                    'title' => 'Purchase Order',
                    'url' => 'purchase-order',
                    'module' => 'purchase_order'
                ], [
                    'title' => 'Invoice',
                    'url' => 'purchase-order/invoice',
                    'module' => 'purchase_order'
                ]
            ]
        ],
        [
            'title' => 'Sales Order',
            'icon' => 'icon-cart',
            'child' => [
                [
                    'title' => 'Proposal',
                    'child' => [
                        [
                            'title' => "Proposal",
                            'url' => 'proposal',
                            'module' => 'proposal'

                        ],
                        [
                            'title' => "Proposal List",
                            'url' => 'proposal/list',
                            'module' => 'proposal'

                        ]
                    ]
                ],
                [
                    'title' => 'Sales Order',
                    'child' => [
                        [
                            'title' => "Sales Order",
                            'url' => 'sales-order/search',
                            'module' => 'proposal'
                        ],
                        [
                            'title' => 'Invoice',
                            'url' => 'sales-order/invoice',
                            'module' => 'proposal'
                        ],
                        [
                            'title' => "Return",
                            'url' => 'sales-order/returns',
                            'module' => 'proposal'
                        ],
                        [
                            'title' => 'Invoice Return',
                            'url' => 'sales-order/returns/invoice',
                            'module' => 'proposal'
                        ]
                    ]
                ],
                [
                    'title' => 'Delivery Order',
                    'url' => 'delivery-order',
                    'module' => 'delivery_order'
                ],
                [
                    'title' => 'Faktur',
                    'child' => [
                        [
                            'title' => "Join Faktur",
                            'url' => 'join',
                            'module' => 'join'

                        ],
                        [
                            'title' => "Pisah Faktur",
                            'url' => 'extract',
                            'module' => 'extract'

                        ]
                    ]
                ]
            ]
        ],
        [
            'title' => 'Debit & Credit',
            'icon' => 'icon-book2',
            'child' => [
                [
                    'title' => " Hutang",
                    'url' => 'credit',
                    'module' => 'credit'
                ], [
                    'title' => "Piutang",
                    'url' => 'debit',
                    'module' => 'debit'

                ]
            ]

        ],
        [
            'title' => " Retail",
            'icon' => 'icon-cart',
            'child' => [
                [
                    'title' => 'retail',
                    'url' => 'retail',
                    'module' => 'retail'
                ],
                [
                    'title' => 'Invoice',
                    'url' => 'retail/invoice',
                    'module' => 'retail'
                ],
                [
                    'title' => "Return",
                    'url' => 'retail/returns',
                    'module' => 'retail'
                ],
                [
                    'title' => 'Invoice Return',
                    'url' => 'retail/returns/invoice',
                    'module' => 'retail'
                ]
            ]
        ]
    ];
//    [
//        'title' => 'Users',
//        'icon' => 'icon-user',
//        'child' => [
//            [
//                'title' => 'Staff List',
//                'url' => 'users',
//                'module' => 'users'
//            ],
//            [
//                'title' => 'Staff Kategori',
//                'url' => 'users/group',
//                'child' => [
//                    [
//                        'title' => 'Staff List',
//                        'url' => 'users',
//                        'module' => 'users'
//                    ],
//                    [
//                        'title' => 'Staff Kategori',
//                        'url' => 'users/group',
//                        'module' => 'users'
//                    ]
//                ]
//            ]
//        ]
//    ],
//    [
//        'title' => 'Warehouse',
//        'icon' => 'icon-arrow2',
//        'child' => [
//            [
//                'title' => 'Warehouse List',
//                'url' => 'warehouse',
//                'module' => 'warehouse'
//            ],
//            [
//                'title' => 'Warehouse Rack',
//                'url' => 'warehouse/rack',
//                'module' => 'warehouse'
//            ],
//            [
//                'title' => 'Product Placing',
//                'url' => 'warehouse/productPlacing',
//                'module' => 'warehouse'
//            ]
//        ]
//    ],
//    [
//        'title' => 'Store',
//        'icon' => '',
//        'url' => 'store',
//        'module' => 'store'
//    ],
//    'product' => [
//        'title' => "Produk",
//        'icon' => 'icon-connection',
//        'child' => [
//            [
//                'title' => "Produk List",
//                'url' => 'product',
//                'module' => 'product'
//            ],
//            [
//                'title' => "Kategori Produk",
//                'url' => 'product/category',
//                'module' => 'product'
//            ],
//            [
//                'title' => "Produk Unit",
//                'url' => 'product/unit',
//                'module' => 'product'
//            ],
//            [
//                'title' => "Produk Opname",
//                'url' => 'stock-opname',
//                'module' => 'product_opname'
//            ],
//            [
//                'title' => "Produk Opname Store",
//                'url' => 'stock-opname/store',
//                'module' => 'product_opname_store'
//            ],
//            [
//                'title' => "Distribusi Produk",
//                'url' => 'product-distribution',
//                'module' => 'product_distribution'
//            ],
//            [
//                'title' => "Produk Return",
//                'url' => 'product-returns',
//                'module' => 'product_return'
//            ],
//            [
//                'title' => "Produk Pricing",
//                'url' => 'pricing',
//                'module' => 'pricing'
//            ],
//            [
//                'title' => "Konversi Produk",
//                'url' => 'product-conversion',
//                'module' => 'product_conversion'
//            ],
//        ]
//    ],
//    [
//        'title' => 'Principal',
//        'icon' => '',
//        'url' => 'principal',
//        'module' => 'principal'
//    ],
//    [
//        'title' => 'Bank Info',
//        'icon' => '',
//        'url' => 'bank_info',
//        'module' => 'bank_info'
//    ],
//    [
//        'title' => 'Customer',
//        'icon' => '',
//        'url' => 'customer',
//        'module' => 'customer'
//    ],
//    [
//        'title' => 'Purchase Order',
//        'icon' => 'icon-tag',
//        'child' => [
//            [
//                'title' => 'Purchase Order',
//                'url' => 'purchase-order',
//                'module' => 'purchase_order'
//            ],
//            [
//                'title' => 'Invoice',
//                'url' => 'purchase-order/invoice',
//                'module' => 'purchase_order'
//            ],
//            [
//                'title' => " Hutang",
//                'url' => 'credit',
//                'module' => 'credit'
//            ]
//        ]
//    ],
//    [
//        'title' => " Retail",
//        'icon' => 'icon-arrow2',
//        'child' => [
//            [
//                'title' => 'retail',
//                'url' => 'retail',
//                'module' => 'retail'
//            ],
//            [
//                'title' => 'Invoice',
//                'url' => 'retail/invoice',
//                'module' => 'retail'
//            ],
//            [
//                'title' => "Return",
//                'url' => 'retail/returns',
//                'module' => 'retail'
//            ],
//            [
//                'title' => 'Invoice Return',
//                'url' => 'retail/returns/invoice',
//                'module' => 'retail'
//            ]
//        ]
//    ],
//    [
//        'title' => 'Sales Order',
//        'icon' => 'icon-arrow2',
//        'child' => [
//            [
//                'title' => "Proposal",
//                'url' => 'proposal',
//                'module' => 'proposal'
//
//            ],
//            [
//                'title' => "Sales Order",
//                'url' => 'proposal/list',
//                'module' => 'proposal'
//
//            ],
//            [
//                'title' => "Piutang",
//                'url' => 'debit',
//                'module' => 'debit'
//
//            ],
//            [
//                'title' => "Return",
//                'url' => 'sales-order/returns',
//                'module' => 'proposal'
//            ],
//            [
//                'title' => 'Invoice Return',
//                'url' => 'sales-order/returns/invoice',
//                'module' => 'proposal'
//            ]
//        ]
//    ],
//    [
//        'title' => 'Delivery Order',
//        'icon' => '',
//        'url' => 'delivery-order',
//        'module' => 'delivery_order'
//    ],
//    [
//        'title' => 'Sales Order',
//        'icon' => 'icon-arrow2',
//        'child' => [
//            [
//                'title' => "Join Faktur",
//                'url' => 'join',
//                'module' => 'join'
//
//            ],
//            [
//                'title' => "Pisah Faktur",
//                'url' => 'extract',
//                'module' => 'extract'
//
//            ]
//        ]
//    ],
//];
/*
// You must reset this admin user
// The second element in the array is the username  $config['users']['username'];
// Don't use admin as the username - please reset   
$config['users']['admin'] = array(
    // Unique Integer for uid
    'uid' => 1,
    'email' => 'admin@example.com', 
    // Roles comes from the roles you set in the acl.php config file.
    // $config[ 'roles' ] = array( 'user', 'blogger', 'editor', 'umpire', 'admin' ).
    // Apply the roles you want this user to have.
    'roles' => array('user','cricket', 'umpire', 'admin'),
    // Remember to make it strong, if you are using hashed password then use the login controller
    // To create a hashed password
    // http://domain.com/login/display_hashed_password/thepassword
    // Copy and paste the result here as a string
    'password' => 'mypassword',
);

// A Second User - change it or delete it.
$config['users']['bob'] = array(
    // Unique Integer for uid
    'uid' => 2,
    'email' => 'bob@example.com',
    'roles' => array('user'),
    'password' => 'd7d5dfdbf69fd107accb7e7a0d842058635d85af',  // bobthebuilder
);
*/
/* Template for more users

$config['users'][] = array(
    'username' => '',
    'email' => '',
    'roles' => array(),
    'password' => '',
);

*/
/* End of login.php */
/* application/config/login.php */
