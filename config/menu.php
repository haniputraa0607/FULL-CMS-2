<?php 

return [
	'sidebar' => [
		/** SAMPLE AVAILABLE PARAMETER
		[
			'type' => 'tree', // 'group' / 'tree' / 'heading' / 'single'
			'label' => 'Menu Title',
			'icon' => 'fa fa-home',
			'url' => '/',
			'active' => '\View::shared("menu_active") == "user"',
			'children' => [],
			'required_configs' => [1,2],
			'required_configs_rule' => 'or',
			'required_features' => [1,2],
			'required_features_rule' => 'or',
		],
		*/

		[
			'type' => 'group',
			'label' => 'Home',
			'required_features' => [1],
			'children' => [
				[
					'type' => 'single',
					'label' => 'Home',
					'icon' => 'icon-home',
					'url' => 'home',
					'active' => '\View::shared("menu_active") == "home"',
				],
				[
					'type' => 'single',
					'label' => 'Home Setting',
					'icon' => 'fa fa-cog',
					'url' => 'setting/home/user',
					'active' => '\View::shared("menu_active") == "setting-home-user"',
				],
			]
		],

		[
			'type' => 'group',
			'label' => 'Accounts',
			'children' => [
				[
					'type' => 'tree',
					'label' => 'User',
					'icon' => 'icon-home',
					'url' => 'home',
					'children' => [
						[
							'label' => 'New User',
							'url' => 'user/create',
							'required_features' => [4],
						],
						[
							'label' => 'User List',
							'url' => 'user/list',
							'required_features' => [2],
							'active' => '\View::shared("submenu_active") == "user-list"'
						],
						[
							'type' => 'tree',
							'label' => 'User Role',
							'children' => [
								[
									'label' => 'Job Level List',
									'url' => 'job-level',
									'required_features' => [323,325,326,327],
								],
								[
									'label' => 'Departement List',
									'url' => 'user/departement',
									'required_features' => [328,329,330,331,332],
								],
								[
									'label' => 'New Role',
									'url' => 'role/create',
									'required_features' => [334],
								],
								[
									'label' => 'Role List',
									'url' => 'role',
									'required_features' => [333,335,336,337],
								],
							],
						],
						[
							'label' => 'Log Activity',
							'url' => 'user/activity',
							'required_features' => [7],
						],
						[
							'type' => 'group',
							'required_configs' => [40],
							'required_features' => [92],
							'children' => [
								[
									'label' => '[Response] Pin Sent',
									'url' => 'user/autoresponse/pin-sent',
									'required_configs' => [41],
								],
								[
									'label' => '[Response] Pin Create',
									'url' => 'user/autoresponse/pin-create',
									'required_configs' => [131],
								],
								[
									'label' => '[Response] Pin Verified',
									'url' => 'user/autoresponse/pin-verify',
									'required_configs' => [42],
								],
								[
									'label' => '[Response] Email Verify',
									'url' => 'user/autoresponse/email-verify',
									'required_configs' => [106],
								],
								[
									'label' => '[Response] Pin Changed First Time',
									'url' => 'user/autoresponse/pin-changed',
									'required_configs' => [43],
								],
								[
									'label' => '[Response] Pin Changed Forgot Password',
									'url' => 'user/autoresponse/pin-changed-forgot-password',
									'required_configs' => [43],
								],
								[
									'label' => '[Response] Pin Forgot',
									'url' => 'user/autoresponse/pin-forgot',
									'required_configs' => [83],
								],
								[
									'label' => '[Response] Login Success',
									'url' => 'user/autoresponse/login-success',
									'required_configs' => [44],
								],
								[
									'label' => '[Response] Login Failed',
									'url' => 'user/autoresponse/login-failed',
									'required_configs' => [45],
								],
								[
									'label' => '[Response] Login First Time',
									'url' => 'user/autoresponse/login-first-time',
									'required_configs' => [43],
								],
								[
									'label' => '[Response] Claim Point Existing Member',
									'url' => 'autoresponse/user/claim-point-existing-member',
									'required_configs' => [41],
								],
							],
						],
					],
				],
				[
					'label' => 'Admin Outlet',
					'type' => 'tree',
					'icon' => 'icon-eye',
					'required_configs' => [5],
					'children' => [
						[
							'label' => 'New Admin Outlet',
							'url' => 'user/adminoutlet/create',
							'required_features' => [4],
						],
						[
							'label' => 'Admin Outlet List',
							'url' => 'user/adminoutlet',
							'required_features' => [9],
						],
					],
				],
				[
					'label' => 'Membership',
					'url' => 'membership',
					'icon' => 'icon-badge',
					'required_configs' => [20],
					'required_features' => [11, 13],
				],
				[
					'label' => 'Setting Point Reset',
					'url' => 'setting/point_reset',
					'icon' => 'fa fa-refresh',
					'required_configs' => [18,77],
					'required_configs_rule' => 'and',
					'required_features' => [457],
				],
				[
					'label' => 'Profile Completion',
					'type' => 'tree',
					'icon' => 'icon-users',
					'children' => [
						[
							'label' => 'User Profile Completion',
							'url' => 'setting/complete-profile',
							'required_features' => [148],
						],
						[
							'label' => '[Response] User Profile Completion Point Bonus',
							'url' => 'user/autoresponse/complete-user-profile-point-bonus',
							'required_features' => [120],
						],
					],
				],
				[
					'type' => 'group',
					'required_configs' => [19,78],
					'required_features' => [457],
					'required_configs_rule' => 'and',
					'children' => [
						[
							'label' => 'Setting ' . env('POINT_NAME', 'Points') . ' Reset',
							'url' => 'setting/balance_reset',
						],
						[
							'label' => '[Email] ' . env('POINT_NAME', 'Points') . ' Reset',
							'url' => 'user/autoresponse/complete-user-profile-point-bonus',
						],
					],
				],
				[
					'type' => 'tree',
					'label' => 'Employee',
					'icon' => 'fa fa-users',
					'children' => [
						[
							'type' => 'tree',
							'label' => 'Office Hours',
							'children' => [
								[
									'label' => 'New Office Hour',
									'url' => 'employee/office-hours/create',
									'required_features' => [444],
								],
								[
									'type' => 'group',
									'required_features' => [442, 443, 445, 446],
									'children' => [
										[
											'label' => 'Office Hour List',
											'url' => 'employee/office-hours',
										],
										[
											'label' => 'Assigned Office Hour List',
											'url' => 'employee/office-hours/assign',
										]
									]
								]
							]
						]
					]
				],
				[
					'type' => 'tree',
					'label' => 'User Mitra',
					'icon' => 'fa fa-user-plus',
					'children' => [
						[
							'label' => 'User Mitra List',
							'url' => 'user/user-franchise',
							'required_features' => [301,302,304],
						],
						[
							'label' => 'New User Mitra',
							'url' => 'user/user-franchise/create',
							'required_features' => [303],
						],
						[
							'type' => 'group',
							'required_features' => [304],
							'children' => [
								[
									'label' => 'Export & Import',
									'url' => 'user/user-franchise/import',
								],
								[
									'label' => '[Response] New User Mitra',
									'url' => 'user/autoresponse-franchise/new-user-franchise',
								],
								[
									'label' => '[Response] Reset Password User Mitra',
									'url' => 'user/autoresponse-franchise/reset-password-user-franchise',
								]
							]
						]
					]
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Browse',
			'children' => [
				[
					'label' => 'News',
					'type' => 'tree',
					'icon' => 'icon-feed',
					'required_configs' => [34],
					'children' => [
						[
							'label' => 'New News',
							'url' => 'news/create',
							'required_features' => [21],
						],
						[
							'label' => 'News List',
							'url' => 'news',
							'required_features' => [19],
						],
						[
							'type' => 'group',
							'required_configs' => [124],
							'children' => [
								[
									'label' => 'News Category',
									'url' => 'news/category',
									'required_features' => [164,166,167],
								],
								[
									'label' => 'New News Category',
									'url' => 'news/category/create',
									'required_features' => [165],
								],
							],
						],
						[
							'label' => 'Manage Position',
							'url' => 'news/position/assign',
							'required_features' => [22,166],
						],
						[
							'type' => 'group',
							'required_features' => [120,122],
							'children' => [
								[
									'label' => '[Forward] Create News',
									'url' => 'autoresponse/news/create-news',
								],
								[
									'label' => '[Forward] Update News',
									'url' => 'autoresponse/news/update-news',
								],
							],
						],
					]
				],
				[
					'label' => 'Brand',
					'type' => 'tree',
					'icon' => 'icon-badge',
					'required_configs' => [95],
					'children' => [
						[
							'label' => 'New Brand',
							'url' => 'brand/create',
							'required_features' => [156],
						],
						[
							'label' => 'List Brand',
							'url' => 'brand',
							'required_features' => [155,157,158,159],
						],
						[
							'label' => 'Inactive Brand Image',
							'url' => 'brand/inactive-image',
							'required_features' => [157],
							'required_configs' => [132],
						],
					]
				],
				[
					'label' => 'Outlet',
					'icon' => 'icon-pointer',
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Outlet',
							'url' => 'outlet/create',
							'required_features' => [26],
							'required_configs' => [82],
						],
						[
							'label' => 'List User Franchise',
							'url' => 'outlet/list/user-franchise',
							'required_configs' => [133],
							'required_features' => [247],
						],
						[
							'label' => 'Outlet List',
							'url' => 'outlet/list',
							'required_features' => [24],
						],
						[
							'label' => 'Online Shop Outlet',
							'url' => 'setting/default_outlet',
							'required_features' => [199],
						],
						[
							'label' => 'QR Code Outlet',
							'url' => 'outlet/qrcode',
							'required_features' => [24,27],
						],
						[
							'label' => 'Outlet Holiday Setting',
							'url' => 'outlet/holiday',
							'required_configs' => [4],
							'required_features' => [34],
						],
						[
							'label' => 'Manage Location',
							'url' => 'outlet/manage-location',
							'required_configs' => [2,3],
							'required_features' => [27],
						],
						[
							'label' => 'Export Import Outlet',
							'url' => 'outlet/export-import',
							'required_configs' => [2,3],
							'required_features' => [32,33],
						],
						[
							'label' => 'Export Import PIN',
							'url' => 'outlet/export-outlet-pin',
							'required_features' => [261],
						],
						[
							'label' => 'Outlet Apps Access Feature',
							'url' => 'outlet/autoresponse/request_pin',
							'required_configs' => [5,101],
							'required_features' => [24,40],
						],
						[
							'type' => 'group',
							'required_features' => [120,122],
							'children' => [
								[
									'label' => '[Response] Outlet Pin Sent',
									'url' => 'autoresponse/outlet/outlet-pin-sent',
									'required_configs' => [134],
								],
								[
									'label' => '[Response] Outlet Pin Sent User Franchise',
									'url' => 'autoresponse/outlet/outlet-pin-sent-user-franchise',
								],
								[
									'label' => '[Response] Request Admin User Franchise',
									'url' => 'autoresponse/outlet/request-admin-user-franchise',
								],
								[
									'label' => '[Forward] Incomplete Outlet Data',
									'url' => 'outlet/autoresponse/incomplete-outlet-data',
								],
							],
						],
						[
							'label' => 'Outlet Group Filter',
							'url' => 'brand/create',
							'children' => [
								[
									'label' => 'New Outlet Group Filter',
									'url' => 'outlet-group-filter/create',
									'required_features' => [296],
								],
								[
									'label' => 'Outlet Group Filter List',
									'url' => 'outlet-group-filter',
									'required_features' => [294, 295, 297, 298],
								],
							],
						],
					]
				],
				[
					'label' => 'Office Branch',
					'icon' => 'fa fa-building-o',
					'type' => 'tree',
					'required_configs' => [128],
					'children' => [
						[
							'label' => 'New Office Branch',
							'url' => 'office-branch/create',
							'required_features' => [449],
						],
						[
							'label' => 'Office Branch List',
							'url' => 'office-branch/list',
							'required_features' => [447],
						],
						[
							'label' => 'Office Holiday Setting',
							'url' => 'office-branch/holiday',
							'required_features' => [450],
						],
					]
				],
				[
					'label' => 'Product',
					'icon' => 'icon-wallet',
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Category',
							'url' => 'product/category/create',
							'required_features' => [45],
						],
						[
							'label' => 'Category List',
							'url' => 'product/category',
							'required_features' => [43],
						],
						[
							'label' => 'New Promo Category',
							'url' => 'product/promo-category/create',
							'required_features' => [239],
						],
						[
							'label' => 'Promo Category List',
							'url' => 'product/promo-category',
							'required_features' => [236],
						],
						[
							'label' => 'Tag List',
							'url' => 'product/tag',
							'required_configs' => [135],
							'required_features' => [458],
						],
						[
							'label' => 'New Product',
							'url' => 'product/create',
							'required_configs' => [1],
							'required_features' => [50],
						],
						[
							'type' => 'tree',
							'label' => 'Export & Import Product',
							'required_configs' => [10,11],
							'required_features' => [56,57],
							'children' => [
								[
									'label' => 'Global',
									'url' => 'product/import/global',
								],
								[
									'label' => 'Product Detail',
									'url' => 'product/import/detail',
								],
								[
									'label' => 'Product Price',
									'url' => 'product/import/price',
								],
							],
						],
						[
							'label' => 'Product List',
							'url' => 'product',
							'required_features' => [48],
						],
						[
							'label' => 'Product ICount List',
							'required_features' => [],
							'url' => 'product/icount'
						],
						[
							'label' => 'Product Catalog',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => 'Create Product Catalog',
									'required_features' => [],
									'url' => 'product/catalog/create'
								],
								[
									'label' => 'List Product Catalog',
									'required_features' => [],
									'url' => 'product/catalog'
								],
							],
						],
						[
							'label' => 'Image Product',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => 'Upload Image',
									'required_features' => [],
									'url' => 'product/image/add'
								],
								[
									'label' => 'Image List',
									'required_features' => [],
									'url' => 'product/image/list'
								],
							],
						],
						[
							'label' => 'Visible Product List',
							'required_features' => [],
							'url' => 'product/visible'
						],
						[
							'label' => 'Hidden Product List',
							'required_features' => [],
							'url' => 'product/hidden'
						],
						[
							'label' => 'Manage Position',
							'required_features' => [],
							'url' => 'product/position/assign'
						],
						[
							'label' => 'Product Photo Default',
							'required_features' => [],
							'url' => 'product/photo/default'
						],
						[
							'label' => 'Product Group',
							'required_features' => [],
							'url' => 'product/product-group'
						],
						[
							'label' => 'Featured Product Group',
							'required_features' => [],
							'url' => 'product/product-group/featured'
						],
					]
				],
				[
					'label' => 'Product Service',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Product Service List',
							'required_features' => [],
							'url' => 'product-service'
						],
						[
							'label' => 'Visible Product Service List',
							'required_features' => [],
							'url' => 'product-service/visible'
						],
						[
							'label' => 'Hidden Product Service List',
							'required_features' => [],
							'url' => 'product-service/hidden'
						],
						[
							'label' => 'Manage Position',
							'required_features' => [],
							'url' => 'product-service/position/assign'
						],
					],
					'icon' => 'fa fa-cut'
				],
				[
					'label' => 'Product Academy',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Product Academy List',
							'required_features' => [],
							'url' => 'product-academy'
						],
						[
							'label' => 'Visible Product Academy List',
							'required_features' => [],
							'url' => 'product-academy/visible'
						],
						[
							'label' => 'Hidden Product Academy List',
							'required_features' => [],
							'url' => 'product-academy/hidden'
						],
						[
							'label' => 'Manage Position',
							'required_features' => [],
							'url' => 'product-academy/position/assign'
						],
					],
					'icon' => 'fa fa-graduation-cap'
				],
				[
					'label' => 'Outlet Starter Bundling',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Outlet Starter Bundling List',
							'required_features' => [],
							'url' => 'outlet-starter-bundling'
						],
						[
							'label' => 'New Outlet Starter Bundling',
							'required_features' => [],
							'url' => 'outlet-starter-bundling/create'
						],
					],
					'icon' => 'fa fa-dropbox'
				],
				[
					'label' => 'Theory',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Category Theory',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
							],
						],
						[
							'label' => 'New Category Theory',
							'required_features' => [],
							'url' => 'theory/category/create'
						],
						[
							'label' => 'Category Theory List',
							'required_features' => [],
							'url' => 'theory/category'
						],
						[
							'label' => 'New Theory',
							'required_features' => [],
							'url' => 'theory/create'
						],
						[
							'label' => 'Theory List',
							'required_features' => [],
							'url' => 'theory'
						],
					],
					'icon' => 'fa fa-book'
				],
				[
					'label' => 'Topping',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Topping',
							'required_features' => [],
							'url' => 'product/modifier/create'
						],
						[
							'label' => 'Topping List',
							'required_features' => [],
							'url' => 'product/modifier'
						],
						[
							'label' => 'Manage Position',
							'required_features' => [],
							'url' => 'product/modifier/position'
						],
						[
							'label' => 'Topping Price',
							'required_features' => [],
							'url' => 'product/modifier/price'
						],
						[
							'label' => 'Topping Detail',
							'required_features' => [],
							'url' => 'product/modifier/detail'
						],
						[
							'label' => 'Topping Inventory Brand',
							'required_features' => [],
							'url' => 'product/modifier/inventory-brand'
						],
						[
							'label' => 'Export & Import Topping',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
							],
						],
						[
							'label' => 'Import Topping',
							'required_features' => [],
							'url' => 'product/import/modifier'
						],
						[
							'label' => 'Import Topping Price',
							'required_features' => [],
							'url' => 'product/import/modifier-price'
						],
					],
					'icon' => 'fa fa-puzzle-piece'
				],
				[
					'label' => 'Product Variant NON PRICE (NO SKU)',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Product Variant NON PRICE (NO SKU)',
							'required_features' => [],
							'url' => 'product/modifier-group/create'
						],
						[
							'label' => 'Product Variant NON PRICE (NO SKU) List',
							'required_features' => [],
							'url' => 'product/modifier-group'
						],
						[
							'label' => 'Product Variant NON PRICE (NO SKU) Price',
							'required_features' => [],
							'url' => 'product/modifier-group/price'
						],
						[
							'label' => 'Product Variant NON PRICE (NO SKU) Detail',
							'required_features' => [],
							'url' => 'product/modifier-group/detail'
						],
						[
							'label' => 'Manage Position Product Variant NON PRICE (NO SKU)',
							'required_features' => [],
							'url' => 'product/modifier-group/position'
						],
						[
							'label' => 'Export & Import Product Variant NON PRICE (NO SKU)',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
							],
						],
						[
							'label' => 'Import Product Variant NON PRICE (NO SKU)',
							'required_features' => [],
							'url' => 'product/modifier-group/import'
						],
						[
							'label' => 'Import Product Variant NON PRICE (NO SKU) Price',
							'required_features' => [],
							'url' => 'product/modifier-group/import-price'
						],
						[
							'label' => 'Inventory Brand',
							'required_features' => [],
							'url' => 'product/modifier-group/inventory-brand'
						],
					],
					'icon' => 'fa fa-glass'
				],
				[
					'label' => 'Product Variant (SKU)',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Variant',
							'required_features' => [],
							'url' => 'product-variant/create'
						],
						[
							'label' => 'Variant List',
							'required_features' => [],
							'url' => 'product-variant'
						],
						[
							'label' => 'Variant Position',
							'required_features' => [],
							'url' => 'product-variant/position'
						],
						[
							'label' => 'Remove Product Variant (SKU)',
							'required_features' => [],
							'url' => 'product-variant-group/list-group'
						],
						[
							'label' => 'Product Variant (SKU) List',
							'required_features' => [],
							'url' => 'product-variant-group/list'
						],
						[
							'label' => 'Product Variant (SKU) Price',
							'required_features' => [],
							'url' => 'product-variant-group/price'
						],
						[
							'label' => 'Product Variant (SKU) Detail',
							'required_features' => [],
							'url' => 'product-variant-group/detail'
						],
						[
							'label' => 'Export & Import',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
							],
						],
						[
							'label' => 'Import Variant',
							'required_features' => [],
							'url' => 'product-variant/import'
						],
						[
							'label' => 'Import Product Variant (SKU)',
							'required_features' => [],
							'url' => 'product-variant-group/import'
						],
						[
							'label' => 'Import Product Variant (SKU) Price',
							'required_features' => [],
							'url' => 'product-variant-group/import-price'
						],
					],
					'icon' => 'fa fa-coffee'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Partner & Hairstylist',
			'children' => [
				[
					'label' => 'Partners',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Partner List',
							'required_features' => [],
							'url' => 'businessdev/partners'
						],
						[
							'label' => 'Candidate List',
							'required_features' => [],
							'url' => 'businessdev/partners/candidate'
						],
						[
							'label' => 'Request Data Partner List',
							'required_features' => [],
							'url' => 'businessdev/partners/request-update'
						],
						[
							'label' => '[Response] Candidate Approved',
							'required_features' => [],
							'url' => 'user/autoresponse/updated-candidate-partner-to-partner'
						],
					],
					'icon' => 'fa fa-users'
				],
				[
					'label' => 'Partner Locations',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Location List',
							'required_features' => [],
							'url' => 'businessdev/locations'
						],
						[
							'label' => 'Candidate Location List',
							'required_features' => [],
							'url' => 'businessdev/locations/candidate'
						],
						[
							'label' => '[Response] Approved Candidate Location',
							'required_features' => [],
							'url' => 'user/autoresponse/updated-candidate-location-to-location'
						],
					],
					'icon' => 'fa fa-institution'
				],
				[
					'label' => 'Project',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Project List',
							'required_features' => [],
							'url' => 'project'
						],
						[
							'label' => 'Ongoing Project',
							'required_features' => [],
							'url' => 'project/process'
						],
						[
							'label' => '[Response] New Project',
							'required_features' => [],
							'url' => 'user/autoresponse/new-project'
						],
						[
							'label' => '[Response] Update Steps Project',
							'required_features' => [],
							'url' => 'user/autoresponse/update-project'
						],
						[
							'label' => '[Response] Approve Project',
							'required_features' => [],
							'url' => 'user/autoresponse/approve-project'
						],
						[
							'label' => '[Response] Reject Project',
							'required_features' => [],
							'url' => 'user/autoresponse/reject-project'
						],
					],
					'icon' => 'fa fa-file'
				],
				[
					'label' => 'Hair Stylist',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Category',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => 'New Category',
									'required_features' => [],
									'url' => 'hair-stylist/category/create'
								],
								[
									'label' => 'Category List',
									'required_features' => [],
									'url' => 'hair-stylist/category'
								],
							],
						],
						[
							'label' => 'Hair Stylist List',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist'
						],
						[
							'label' => 'Candidate List',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/candidate'
						],
						[
							'label' => 'Setting Requirements',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/candidate/setting-requirements'
						],
						[
							'label' => '[Response] Register Candidate Hair Stylist',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist/register-candidate-hair-stylist'
						],
						[
							'label' => '[Response] Rejected Candidate Hair Stylist',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist/rejected-candidate-hair-stylist'
						],
						[
							'label' => '[Response] Approve Candidate Hair Stylist',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist/approve-candidate-hair-stylist'
						],
						[
							'label' => '[Response] Reset Password User Hair Stylist',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist/reset-password-user-hair-stylist'
						],
						[
							'label' => 'Hair Stylist Schedule',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => 'Create Schedule',
									'required_features' => [],
									'url' => 'recruitment/hair-stylist/schedule/create'
								],
								[
									'label' => 'Schedule List',
									'required_features' => [],
									'url' => 'recruitment/hair-stylist/schedule'
								],
							],
							'icon' => 'fa fa-calendar'
						],
						[
							'label' => 'Attendance Setting',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/attendance-setting'
						],
						[
							'label' => 'Attendance',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/attendance'
						],
						[
							'label' => 'Attendance Pending',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/attendance-pending'
						],
						[
							'label' => 'Create Request Time Off',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/timeoff/create'
						],
						[
							'label' => 'List Request Time Off',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/timeoff'
						],
						[
							'label' => 'Create Request Overtime',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/overtime/create'
						],
						[
							'label' => 'List Request Overtime',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/overtime'
						],
						[
							'label' => '[Response] Approve Hairstylist Schedule',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist-schedule/approve-hairstylist-schedule'
						],
					],
					'icon' => 'fa fa-cut'
				],
				[
					'label' => 'Request Hair Stylist',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Request Hair Stylist',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/request/new'
						],
						[
							'label' => 'List Request Hair Stylist',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/request'
						],
					],
					'icon' => 'fa fa-male'
				],
				[
					'label' => 'Hair Stylist Group',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Hair Stylist Group',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/group/create'
						],
						[
							'label' => 'List Hair Stylist Group',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/group'
						],
					],
					'icon' => 'fa fa-life-ring'
				],
				[
					'label' => 'Default Income HS',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Salary Incentive Default HS',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/default/insentif'
						],
						[
							'label' => 'Salary Cuts Default HS',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/default/potongan'
						],
					],
					'icon' => 'fa fa-money'
				],
				[
					'label' => 'Request Product',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Create Request Product',
							'required_features' => [],
							'url' => 'req-product/create'
						],
						[
							'label' => 'List Request Product',
							'required_features' => [],
							'url' => 'req-product'
						],
						[
							'label' => '[Response] Create Request Product',
							'required_features' => [],
							'url' => 'user/autoresponse/create-request-product'
						],
						[
							'label' => '[Response] Update Request Product',
							'required_features' => [],
							'url' => 'user/autoresponse/update-request-product'
						],
						[
							'label' => '[Response] Product Request Approved By Admin',
							'required_features' => [],
							'url' => 'user/autoresponse/product-request-approved-by-admin'
						],
						[
							'label' => '[Response] Product Request Rejected By Admin',
							'required_features' => [],
							'url' => 'user/autoresponse/product-request-rejected-by-admin'
						],
						[
							'label' => '[Response] Product Request Approved By Finance',
							'required_features' => [],
							'url' => 'user/autoresponse/product-request-approved-by-finance'
						],
						[
							'label' => '[Response] Product Request Rejected By Finance',
							'required_features' => [],
							'url' => 'user/autoresponse/product-request-rejected-by-finance'
						],
					],
					'icon' => 'fa fa-dropbox'
				],
				[
					'label' => 'Delivery Product',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Create Delivery Product',
							'required_features' => [],
							'url' => 'dev-product/create'
						],
						[
							'label' => 'List Delivery Product',
							'required_features' => [],
							'url' => 'dev-product'
						],
						[
							'label' => '[Response] Create Delivery Product',
							'required_features' => [],
							'url' => 'user/autoresponse/create-delivery-product'
						],
						[
							'label' => '[Response] Confirmation Delivery Product',
							'required_features' => [],
							'url' => 'user/autoresponse/confirmation-delivery-product'
						],
					],
					'icon' => 'fa fa-truck'
				],
				[
					'label' => 'Request Update Data',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'List Request',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/update-data'
						],
						[
							'label' => '[Response] Approve Request',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist-update-data/approve-hairstylist-request-update-data'
						],
						[
							'label' => '[Response] Reject Request',
							'required_features' => [],
							'url' => 'autoresponse/hairstylist-update-data/reject-hairstylist-request-update-data'
						],
					],
					'icon' => 'fa fa-edit'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Order',
			'children' => [
				[
					'label' => 'Product Transaction',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Transaction Outlet Service',
							'required_features' => [],
							'url' => 'transaction/outlet-service'
						],
						[
							'label' => 'Transaction Home Service',
							'required_features' => [],
							'url' => 'transaction/home-service'
						],
						[
							'label' => 'Transaction Shop',
							'required_features' => [],
							'url' => 'transaction/shop'
						],
						[
							'label' => 'Transaction Academy',
							'required_features' => [],
							'url' => 'transaction/academy'
						],
						[
							'label' => 'Manage Outlet Service',
							'required_features' => [],
							'url' => 'transaction/outlet-service/manage'
						],
						[
							'label' => 'Manage Home Service',
							'required_features' => [],
							'url' => 'transaction/home-service/manage'
						],
						[
							'label' => '[Response] Transaction Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/transaction-success'
						],
						[
							'label' => '[Response] Transaction Expired',
							'required_features' => [],
							'url' => 'transaction/autoresponse/transaction-expired'
						],
						[
							'label' => '[Response] Order Accepted',
							'required_features' => [],
							'url' => 'transaction/autoresponse/order-accepted'
						],
						[
							'label' => '[Response] Order Ready',
							'required_features' => [],
							'url' => 'transaction/autoresponse/order-ready'
						],
						[
							'label' => '[Response] Order Taken',
							'required_features' => [],
							'url' => 'transaction/autoresponse/order-taken'
						],
						[
							'label' => '[Response] Transaction Point Achievement',
							'required_features' => [],
							'url' => 'transaction/autoresponse/transaction-point-achievement'
						],
						[
							'label' => '[Response] Transaction Failed Point Refund',
							'required_features' => [],
							'url' => 'transaction/autoresponse/transaction-failed-point-refund'
						],
						[
							'label' => '[Response] Rejected Order Point Refund',
							'required_features' => [],
							'url' => 'transaction/autoresponse/rejected-order-point-refund'
						],
						[
							'label' => '[Response] Transaction Rejected',
							'required_features' => [],
							'url' => 'autoresponse/transaction/transaction-rejected'
						],
						[
							'label' => '[Response] Transaction Completed',
							'required_features' => [],
							'url' => 'autoresponse/transaction/transaction-completed'
						],
						[
							'label' => '[Response] Delivery Status Update',
							'required_features' => [],
							'url' => 'transaction/autoresponse/delivery-status-update'
						],
						[
							'label' => '[Forward] Delivery Rejected',
							'required_features' => [],
							'url' => 'autoresponse/transaction/delivery-rejected'
						],
						[
							'label' => 'Outlet Service Response',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => '[Response] Transaction Service Completed',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/transaction-service-completed'
								],
								[
									'label' => '[Response] Transaction Product Taken',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/transaction-product-taken'
								],
								[
									'label' => '[Response] HS - Transaction Service Created',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-created'
								],
								[
									'label' => '[Response] HS - Transaction Service Rejected',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-rejected'
								],
								[
									'label' => '[Response] HS - Transaction Service Completed',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-completed'
								],
								[
									'label' => '[Response] SPV - Transaction Product Created',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-created'
								],
								[
									'label' => '[Response] SPV - Transaction Product Rejected',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-rejected'
								],
								[
									'label' => '[Response] SPV - Transaction Product Taken',
									'required_features' => [],
									'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-taken'
								],
							],
						],
					],
					'icon' => 'fa fa-shopping-cart'
				],
				[
					'label' => 'Manual Complete Payment',
					'required_features' => [],
					'url' => 'transaction/complete-payment',
					'icon' => 'fa fa-check'
				],
				[
					'label' => 'Response With Code',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => '[Response] Order Taken With Code',
							'required_features' => [],
							'url' => 'transaction/autoresponse/order-taken-with-code'
						],
						[
							'label' => '[Response] Order Taken Delivery With Code',
							'required_features' => [],
							'url' => 'transaction/autoresponse/order-taken-delivery-with-code'
						],
						[
							'label' => 'New Code',
							'required_features' => [],
							'url' => 'response-with-code/create'
						],
						[
							'label' => 'Code List',
							'required_features' => [],
							'url' => 'response-with-code'
						],
					],
					'icon' => 'fa fa-qrcode'
				],
				[
					'label' => 'Failed Void Payment',
					'required_features' => [],
					'url' => 'transaction/failed-void-payment',
					'icon' => 'fa fa-exclamation-triangle'
				],
				[
					'label' => 'Point Log History',
					'required_features' => [],
					'url' => 'transaction/point',
					'icon' => 'fa fa-history'
				],
				[
					'label' => 'Points Log History',
					'required_features' => [],
					'url' => 'transaction/balance',
					'icon' => 'fa fa-clock-o'
				],
				[
					'label' => 'Order Settings',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Chart Of Account',
							'required_features' => [],
							'url' => 'chartofaccount'
						],
						[
							'label' => 'Calculation Rule',
							'required_features' => [],
							'url' => 'transaction/setting/rule'
						],
						[
							'label' => 'Internal Courier',
							'required_features' => [],
							'url' => 'transaction/internalcourier'
						],
						[
							'label' => 'Global Points Setting',
							'required_features' => [],
							'url' => 'transaction/setting/cashback'
						],
						[
							'label' => 'Setting Free Delivery',
							'required_features' => [],
							'url' => 'transaction/setting/free-delivery'
						],
						[
							'label' => 'Credit Card Payment Gateway',
							'required_features' => [],
							'url' => 'setting/credit_card_payment_gateway'
						],
						[
							'label' => 'Setting Payment Method',
							'required_features' => [],
							'url' => 'transaction/setting/available-payment'
						],
						[
							'label' => 'Setting Timer Payment Gateway',
							'required_features' => [],
							'url' => 'transaction/setting/timer-payment-gateway'
						],
						[
							'label' => 'Setting Refund Reject Order',
							'required_features' => [],
							'url' => 'transaction/setting/refund-reject-order'
						],
						[
							'label' => 'Setting Auto Reject Time',
							'required_features' => [],
							'url' => 'transaction/setting/auto-reject'
						],
						[
							'label' => 'Transaction Messages',
							'required_features' => [],
							'url' => 'transaction/setting/transaction-messages'
						],
					],
					'icon' => 'fa fa-cogs'
				],
				[
					'label' => 'Delivery Settings',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Available Delivery',
							'required_features' => [],
							'url' => 'transaction/setting/available-delivery'
						],
						[
							'label' => 'Upload Logo Delivery',
							'required_features' => [],
							'url' => 'transaction/setting/delivery-upload-image'
						],
						[
							'label' => 'Outlet Availability',
							'required_features' => [],
							'url' => 'transaction/setting/delivery-outlet'
						],
						[
							'label' => 'Import/Export Outlet Availability',
							'required_features' => [],
							'url' => 'transaction/setting/delivery-outlet/import'
						],
						[
							'label' => 'Setting Package Detail Delivery',
							'required_features' => [],
							'url' => 'transaction/setting/package-detail-delivery'
						],
						[
							'label' => '[Forward] WeHelpYou Low Balance',
							'required_features' => [],
							'url' => 'transaction/setting/forward-why-low-balance'
						],
					],
					'icon' => 'fa fa-truck'
				],
				[
					'label' => 'Payment Method',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Category',
							'required_features' => [],
							'url' => 'payment-method-category/create'
						],
						[
							'label' => 'Category List',
							'required_features' => [],
							'url' => 'payment-method-category'
						],
						[
							'label' => 'New Payment Method',
							'required_features' => [],
							'url' => 'payment-method/create'
						],
						[
							'label' => 'Payment Method List',
							'required_features' => [],
							'url' => 'payment-method'
						],
					],
					'icon' => 'fa fa-credit-card'
				],
				[
					'label' => 'Outlet Product Price',
					'required_features' => [],
					'url' => 'product/price',
					'icon' => 'fa fa-tag'
				],
				[
					'label' => 'Outlet Different Price',
					'required_features' => [],
					'url' => 'outlet/different-price',
					'icon' => 'fa fa-check'
				],
				[
					'label' => 'Default Maximum Order',
					'required_features' => [],
					'url' => 'setting/max_order',
					'icon' => 'fa fa-shopping-cart'
				],
				[
					'label' => 'Outlet Maximum Order',
					'required_features' => [],
					'url' => 'outlet/max-order',
					'icon' => 'fa fa-shopping-cart'
				],
				[
					'label' => 'Manual Payment',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Payment Method',
							'required_features' => [],
							'url' => 'transaction/manualpayment/create'
						],
						[
							'label' => 'Payment Method List',
							'required_features' => [],
							'url' => 'transaction/manualpayment'
						],
						[
							'label' => 'Manual Payment Transaction',
							'required_features' => [],
							'url' => 'transaction/manualpayment/list'
						],
						[
							'label' => 'Manual Payment Deals',
							'required_features' => [],
							'url' => 'deals/manualpayment/list'
						],
						[
							'label' => 'Bank List',
							'required_features' => [],
							'url' => 'transaction/manualpayment/banks'
						],
						[
							'label' => 'Payment Method List',
							'required_features' => [],
							'url' => 'transaction/manualpayment/banks/method'
						],
					],
					'icon' => 'fa fa-money'
				],
				[
					'label' => 'Report GoSend',
					'required_features' => [],
					'url' => 'report/gosend',
					'icon' => 'fa fa-truck'
				],
				[
					'label' => 'Report Wehelpyou',
					'required_features' => [],
					'url' => 'report/wehelpyou',
					'icon' => 'fa fa-truck'
				],
				[
					'label' => 'Report Payment',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Midtrans',
							'required_features' => [],
							'url' => 'report/payment/midtrans'
						],
						[
							'label' => 'Xendit',
							'required_features' => [],
							'url' => 'report/payment/xendit'
						],
					],
					'icon' => 'fa fa-credit-card'
				],
				[
					'label' => 'User Rating',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'User Rating List',
							'required_features' => [],
							'url' => 'user-rating'
						],
						[
							'label' => 'User Rating Setting',
							'required_features' => [],
							'url' => 'user-rating/setting'
						],
						[
							'label' => 'User Rating Report Outlet',
							'required_features' => [],
							'url' => 'user-rating/report/outlet'
						],
						[
							'label' => 'User Rating Report Hairstylist',
							'required_features' => [],
							'url' => 'user-rating/report/hairstylist'
						],
						[
							'label' => '[Response] Rating Outlet',
							'required_features' => [],
							'url' => 'user-rating/autoresponse/outlet'
						],
						[
							'label' => '[Response] Rating Hairstylist',
							'required_features' => [],
							'url' => 'user-rating/autoresponse/hairstylist'
						],
					],
					'icon' => 'fa fa-star-o'
				],
				[
					'label' => 'Home Service',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Setting',
							'required_features' => [],
							'url' => 'transaction/setting/home-service'
						],
						[
							'label' => '[Response] HS - Get Order',
							'required_features' => [],
							'url' => 'autoresponse/home-service/home-service-mitra-get-order'
						],
						[
							'label' => '[Response] Update Status',
							'required_features' => [],
							'url' => 'autoresponse/home-service/home-service-update-status'
						],
					],
					'icon' => 'fa fa-cut'
				],
				[
					'label' => 'Academy',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Setting Banner',
							'required_features' => [],
							'url' => 'academy/setting/banner'
						],
						[
							'label' => 'Setting Installment',
							'required_features' => [],
							'url' => 'academy/setting/installment'
						],
						[
							'label' => 'Student List',
							'required_features' => [],
							'url' => 'academy/transaction/user/schedule'
						],
						[
							'label' => 'Course',
							'required_features' => [],
							'url' => 'academy/transaction/outlet/course'
						],
						[
							'label' => 'Day Off',
							'required_features' => [],
							'url' => 'academy/transaction/user/schedule/day-off'
						],
						[
							'label' => 'Installment Deadline Date',
							'required_features' => [],
							'url' => 'transaction/setting/academy'
						],
						[
							'label' => '[Response] Academy Course Reminder',
							'required_features' => [],
							'url' => 'autoresponse/academy/academy-course-reminder'
						],
						[
							'label' => '[Response] Approve Day Off',
							'required_features' => [],
							'url' => 'autoresponse/academy/approve-day-off-user-academy'
						],
						[
							'label' => '[Response] Reject Day Off',
							'required_features' => [],
							'url' => 'autoresponse/academy/reject-day-off-user-academy'
						],
						[
							'label' => '[Response] Payment Academy Installment Completed',
							'required_features' => [],
							'url' => 'autoresponse/academy/payment-academy-installment-completed'
						],
						[
							'label' => '[Response] Payment Academy Installment Cancelled',
							'required_features' => [],
							'url' => 'autoresponse/academy/payment-academy-installment-cancelled'
						],
						[
							'label' => '[Response] Payment Academy Installment Reminder',
							'required_features' => [],
							'url' => 'autoresponse/academy/payment-academy-installment-reminder'
						],
						[
							'label' => '[Response] Payment Academy Installment Due Date',
							'required_features' => [],
							'url' => 'autoresponse/academy/payment-academy-installment-due-date'
						],
					],
					'icon' => 'fa fa-building-o'
				],
				[
					'label' => 'Online Shop',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => '[Response] Trasaction Online Shope Created',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/transaction-online-shop-created'
						],
						[
							'label' => '[Response] Trasaction Online Shope Cancelled',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/transaction-online-shop-cancelled'
						],
						[
							'label' => '[Response] Trasaction Online Shope Rejected',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/transaction-online-shop-rejected'
						],
						[
							'label' => '[Response] Accepted Online Shop',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/accepted-online-shop'
						],
						[
							'label' => '[Response] Ready Online Shop',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/ready-online-shop'
						],
						[
							'label' => '[Response] Delivery Online Shop Requested',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/delivery-online-shop-requested'
						],
						[
							'label' => '[Response] Transaction Online Shop Complete',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/transaction-online-shop-complete'
						],
						[
							'label' => '[Response] Point Received Online Shop',
							'required_features' => [],
							'url' => 'autoresponse/online-shop/point-received-online-shop'
						],
					],
					'icon' => 'fa fa-ship'
				],
				[
					'label' => 'Export Commision',
					'required_features' => [],
					'url' => 'hair-stylist/commision/filter',
					'icon' => 'fa fa-download'
				],
				[
					'label' => 'Export Sales Report',
					'required_features' => [],
					'url' => 'transaction/report/export/sales',
					'icon' => 'fa fa-download'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Invalid Transaction',
			'children' => [
				[
					'label' => 'Mark as Pending Invalid',
					'required_features' => [],
					'url' => 'transaction/invalid-flag/mark-as-pending-invalid',
					'icon' => 'fa fa-list-ul'
				],
				[
					'label' => 'Mark as Invalid',
					'required_features' => [],
					'url' => 'transaction/invalid-flag/mark-as-invalid',
					'icon' => 'fa fa-list-ul'
				],
				[
					'label' => 'Mark as Valid',
					'required_features' => [],
					'url' => 'transaction/invalid-flag/mark-as-valid',
					'icon' => 'fa fa-list-ul'
				],
				[
					'label' => 'Log Invalid Flag',
					'required_features' => [],
					'url' => 'transaction/log-invalid-flag/list',
					'icon' => 'fa fa-list-ul'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Promo',
			'children' => [
				[
					'label' => 'Deals',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Deals',
							'required_features' => [],
							'url' => 'deals/create'
						],
						[
							'label' => 'Deals List',
							'required_features' => [],
							'url' => 'deals'
						],
						[
							'label' => 'New Point Deals',
							'required_features' => [],
							'url' => 'deals-point/create'
						],
						[
							'label' => 'Deals Point List',
							'required_features' => [],
							'url' => 'deals-point'
						],
						[
							'label' => '[Response] Claim Free Deals Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/claim-free-deals-success',
						],
						[
							'label' => '[Response] Claim Paid Deals Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/claim-paid-deals-success',
						],
						[
							'label' => '[Response] Claim Point Deals Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/claim-point-deals-success',
						],
						[
							'label' => '[Response] Redeems Deals',
							'required_features' => [],
							'url' => 'transaction/autoresponse/redeem-voucher-success',
						],
						[
							'label' => '[Forward] Create Deals',
							'required_features' => [],
							'url' => 'autoresponse/deals/create-deals'
						],
						[
							'label' => '[Forward] Update Deals',
							'required_features' => [],
							'url' => 'autoresponse/deals/update-deals'
						],
					],
					'icon' => 'fa fa-gift'
				],
				[
					'label' => 'Product Bundling',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Bundling Category',
							'required_features' => [],
							'url' => 'product-bundling/category/create'
						],
						[
							'label' => 'Bundling Category List',
							'required_features' => [],
							'url' => 'product-bundling/category'
						],
						[
							'label' => 'New Product Bundling',
							'required_features' => [],
							'url' => 'product-bundling/create'
						],
						[
							'label' => 'Product Bundling List',
							'required_features' => [],
							'url' => 'product-bundling'
						],
						[
							'label' => 'Manage Position',
							'required_features' => [],
							'url' => 'product-bundling/position/assign'
						],
						[
							'label' => 'Setting Name Brand Bundling',
							'required_features' => [],
							'url' => 'product-bundling/setting'
						],
					],
					'icon' => 'icon-present'
				],
				[
					'label' => 'Inject Voucher',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Inject Voucher',
							'required_features' => [],
							'url' => 'inject-voucher/create'
						],
						[
							'label' => 'Inject Voucher List',
							'required_features' => [],
							'url' => 'inject-voucher'
						],
						[
							'label' => '[Response] Receive Inject Voucher',
							'required_features' => [],
							'url' => 'transaction/autoresponse/receive-inject-voucher',
						],
						[
							'label' => '[Forward] Create Inject Voucher',
							'required_features' => [],
							'url' => 'autoresponse/inject-voucher/create-inject-voucher'
						],
						[
							'label' => '[Forward] Update Inject Voucher',
							'required_features' => [],
							'url' => 'autoresponse/inject-voucher/update-inject-voucher'
						],
					],
					'icon' => 'fa fa-birthday-cake'
				],
				[
					'label' => 'Welcome Voucher',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Welcome Voucher',
							'required_features' => [],
							'url' => 'welcome-voucher/create'
						],
						[
							'label' => 'Welcome Voucher List',
							'required_features' => [],
							'url' => 'welcome-voucher'
						],
						[
							'label' => 'Welcome Voucher Setting',
							'required_features' => [],
							'url' => 'welcome-voucher/setting'
						],
						[
							'label' => '[Response] Welcome Voucher',
							'required_features' => [],
							'url' => 'autoresponse/welcome-voucher/receive-welcome-voucher'
						],
						[
							'label' => '[Forward] Create Welcome Voucher',
							'required_features' => [],
							'url' => 'autoresponse/welcome-voucher/create-welcome-voucher'
						],
						[
							'label' => '[Forward] Update Welcome Voucher',
							'required_features' => [],
							'url' => 'autoresponse/welcome-voucher/update-welcome-voucher'
						],
					],
					'icon' => 'fa fa-ticket'
				],
				[
					'label' => 'Deals Transaction',
					'required_features' => [],
					'url' => 'deals/transaction',
					'icon' => 'fa fa-bar-chart'
				],
				[
					'label' => 'Promo Campaign',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Promo Campaign',
							'required_features' => [],
							'url' => 'promo-campaign/create'
						],
						[
							'label' => 'Promo Campaign List',
							'required_features' => [],
							'url' => 'promo-campaign'
						],
						[
							'label' => '[Forward] Create Promo Campaign',
							'required_features' => [],
							'url' => 'autoresponse/promo-campaign/create-promo-campaign'
						],
						[
							'label' => '[Forward] Update Promo Campaign',
							'required_features' => [],
							'url' => 'autoresponse/promo-campaign/update-promo-campaign'
						],
						[
							'label' => 'Share Promo Code Message',
							'required_features' => [],
							'url' => 'promo-campaign/share-promo'
						],
					],
					'icon' => 'fa fa-tag'
				],
				[
					'label' => 'Promo Cashback Setting',
					'required_features' => [],
					'url' => 'promo-setting/cashback',
					'icon' => 'fa fa-money'
				],
				[
					'label' => 'Referral',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Referral Setting',
							'required_features' => [],
							'url' => 'referral/setting'
						],
						[
							'label' => 'Referral Report',
							'required_features' => [],
							'url' => 'referral/report'
						],
					],
					'icon' => 'fa fa-user-plus'
				],
				[
					'label' => 'Reward',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Reward',
							'required_features' => [],
							'url' => 'reward/create'
						],
						[
							'label' => 'Reward List',
							'required_features' => [],
							'url' => 'reward'
						],
					],
					'icon' => 'icon-trophy'
				],
				[
					'label' => 'Spin The Wheel',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Item',
							'required_features' => [],
							'url' => 'spinthewheel/create'
						],
						[
							'label' => 'Item List',
							'required_features' => [],
							'url' => 'spinthewheel/list'
						],
						[
							'label' => 'Setting',
							'required_features' => [],
							'url' => 'spinthewheel/setting'
						],
					],
					'icon' => 'fa fa-circle-o-notch'
				],
				[
					'label' => 'Subscription',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Subscription',
							'required_features' => [],
							'url' => 'subscription/create'
						],
						[
							'label' => 'Subscription List',
							'required_features' => [],
							'url' => 'subscription'
						],
						[
							'label' => 'Subscription Claim Report',
							'required_features' => [],
							'url' => 'subscription/claim-report'
						],
						[
							'label' => 'Subscription Transaction Report',
							'required_features' => [],
							'url' => 'subscription/transaction-report'
						],
						[
							'label' => 'List Export',
							'required_features' => [],
							'url' => 'subscription/list-export'
						],
						[
							'label' => '[Response] Get Free Subscription Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/get-free-subscription-success',
						],
						[
							'label' => '[Response] Buy Paid Subscription Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/buy-paid-subscription-success',
						],
						[
							'label' => '[Response] Buy Point Subscription Success',
							'required_features' => [],
							'url' => 'transaction/autoresponse/buy-point-subscription-success',
						],
					],
					'icon' => 'fa fa-gift'
				],
				[
					'label' => 'Welcome Subscription',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Welcome Subscription',
							'required_features' => [],
							'url' => 'welcome-subscription/create'
						],
						[
							'label' => 'Welcome Subscription List',
							'required_features' => [],
							'url' => 'welcome-subscription'
						],
						[
							'label' => 'Welcome Subscription Setting',
							'required_features' => [],
							'url' => 'welcome-subscription/setting'
						],
						[
							'label' => '[Response] Receive Welcome Subscription',
							'required_features' => [],
							'url' => 'autoresponse/welcome-subscription/receive-welcome-subscription'
						],
						[
							'label' => '[Forward] Create Welcome Subscription',
							'required_features' => [],
							'url' => 'autoresponse/welcome-subscription/create-welcome-subscription'
						],
						[
							'label' => '[Forward] Update Welcome Subscription',
							'required_features' => [],
							'url' => 'autoresponse/welcome-subscription/update-welcome-subscription'
						],
					],
					'icon' => 'fa fa-ticket'
				],
				[
					'label' => 'Achievement',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Achievement',
							'required_features' => [],
							'url' => 'achievement/create'
						],
						[
							'label' => 'Achievement List',
							'required_features' => [],
							'url' => 'achievement'
						],
						[
							'label' => 'Report Achievement',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
							],
						],
						[
							'label' => 'Achievement',
							'required_features' => [],
							'url' => 'achievement/report'
						],
						[
							'label' => 'User Achievement',
							'required_features' => [],
							'url' => 'achievement/report/user-achievement'
						],
						[
							'label' => 'Membership Achievement',
							'required_features' => [],
							'url' => 'achievement/report/membership'
						],
					],
					'icon' => 'fa fa-trophy'
				],
				[
					'label' => 'Quest',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Quest Voucher',
							'required_features' => [],
							'type' => 'tree',
							'children' => [
								[
									'label' => 'New Quest Voucher',
									'required_features' => [],
									'url' => 'quest-voucher/create'
								],
								[
									'label' => 'Quest Voucher List',
									'required_features' => [],
									'url' => 'quest-voucher'
								],
								[
									'label' => '[Forward] Create Quest Voucher',
									'required_features' => [],
									'url' => 'autoresponse/quest-voucher/create-quest-voucher'
								],
								[
									'label' => '[Forward] Update Quest Voucher',
									'required_features' => [],
									'url' => 'autoresponse/quest-voucher/update-quest-voucher'
								],
							],
						],
						[
							'label' => 'New Quest',
							'required_features' => [],
							'url' => 'quest/create'
						],
						[
							'label' => 'Quest List',
							'required_features' => [],
							'url' => 'quest'
						],
						[
							'label' => 'Report Quest',
							'required_features' => [],
							'url' => 'quest/report'
						],
						[
							'label' => '[Response] Quest Completed',
							'required_features' => [],
							'url' => 'autoresponse/quest/quest-completed'
						],
						[
							'label' => '[Response] Receive Quest Point',
							'required_features' => [],
							'url' => 'autoresponse/quest/receive-quest-point'
						],
						[
							'label' => '[Response] Receive Quest Voucher',
							'required_features' => [],
							'url' => 'autoresponse/quest/receive-quest-voucher'
						],
					],
					'icon' => 'fa fa-bullseye'
				],
				[
					'label' => 'Rule Promo Payment Gateway',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Promo Payment Gateway',
							'required_features' => [],
							'url' => 'disburse/rule-promo-payment-gateway/create'
						],
						[
							'label' => 'Promo Payment Gateway List',
							'required_features' => [],
							'url' => 'disburse/rule-promo-payment-gateway'
						],
						[
							'label' => 'Promo Payment Gateway List Transaction',
							'required_features' => [],
							'url' => 'disburse/rule-promo-payment-gateway/list-trx'
						],
						[
							'label' => 'Promo Payment Gateway Validation',
							'required_features' => [],
							'url' => 'disburse/rule-promo-payment-gateway/validation'
						],
						[
							'label' => 'Promo Payment Gateway Validation Report',
							'required_features' => [],
							'url' => 'disburse/rule-promo-payment-gateway/validation/report'
						],
					],
					'icon' => 'fa fa-tag'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'CRM',
			'children' => [
				[
					'label' => 'CRM Setting',
					'required_features' => [],
					'url' => 'autocrm',
					'icon' => 'icon-settings',
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Text Replace',
							'required_features' => [],
							'url' => 'textreplace'
						],
						[
							'label' => 'Email Header & Footer',
							'required_features' => [],
							'url' => 'email-header-footer'
						],
						[
							'label' => 'WhatsApp Setting',
							'required_features' => [],
							'url' => 'setting/whatsapp'
						],
					]
				],
				[
					'label' => 'Contact CS Subject Setting',
					'required_features' => [],
					'url' => 'enquiries/setting/subject',
					'icon' => 'fa fa-phone'
				],
				[
					'label' => 'Enquiries',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Enquiry List',
							'required_features' => [],
							'url' => 'enquiries'
						],
						[
							'label' => '[Response] Kritik, Saran & Keluhan',
							'required_features' => [],
							'url' => 'about/autoresponse/enquiry-kritik,-saran-&-keluhan'
						],
						[
							'label' => '[Response] Pengubahan Data Diri',
							'required_features' => [],
							'url' => 'about/autoresponse/enquiry-pengubahan-data-diri'
						],
						[
							'label' => '[Response] Lain - Lain',
							'required_features' => [],
							'url' => 'about/autoresponse/enquiry-lain-_-lain'
						],
					],
					'icon' => 'icon-action-undo'
				],
				[
					'label' => 'User Feedback',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'User Feedback List',
							'required_features' => [],
							'url' => 'user-feedback'
						],
						[
							'label' => 'User Feedback Setting',
							'required_features' => [],
							'url' => 'user-feedback/setting'
						],
						[
							'label' => 'Report User Feedback',
							'required_features' => [],
							'url' => 'user-feedback/report'
						],
						[
							'label' => '[Response] User Feedback',
							'required_features' => [],
							'url' => 'user-feedback/autoresponse'
						],
					],
					'icon' => 'fa fa-thumbs-o-up'
				],
				[
					'label' => 'Single Campaign',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Campaign',
							'required_features' => [],
							'url' => 'campaign/create'
						],
						[
							'label' => 'Campaign List',
							'required_features' => [],
							'url' => 'campaign'
						],
						[
							'label' => 'Email Outbox',
							'required_features' => [],
							'url' => 'campaign/email/outbox'
						],
						[
							'label' => 'SMS Outbox',
							'required_features' => [],
							'url' => 'campaign/sms/outbox'
						],
						[
							'label' => 'Push Outbox',
							'required_features' => [],
							'url' => 'campaign/push/outbox'
						],
						[
							'label' => 'WhatsApp Outbox',
							'required_features' => [],
							'url' => 'campaign/whatsapp/outbox'
						],
					],
					'icon' => 'icon-speech'
				],
				[
					'label' => 'Promotion',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Deals Promotion',
							'required_features' => [],
							'url' => 'promotion/deals/create'
						],
						[
							'label' => 'Deals Promotion',
							'required_features' => [],
							'url' => 'promotion/deals'
						],
						[
							'label' => 'New Promotion',
							'required_features' => [],
							'url' => 'promotion/create'
						],
						[
							'label' => 'Promotion List',
							'required_features' => [],
							'url' => 'promotion'
						],
					],
					'icon' => 'icon-emoticon-smile'
				],
				[
					'label' => 'Point Injection',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Point Injection',
							'required_features' => [],
							'url' => 'point-injection/create'
						],
						[
							'label' => 'List Point Injection',
							'required_features' => [],
							'url' => 'point-injection'
						],
					],
					'icon' => 'icon-diamond'
				],
				[
					'label' => 'Inbox Global',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Inbox Global',
							'required_features' => [],
							'url' => 'inboxglobal/create'
						],
						[
							'label' => 'Inbox Global List',
							'required_features' => [],
							'url' => 'inboxglobal'
						],
					],
					'icon' => 'icon-feed'
				],
				[
					'label' => 'Annoucement',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Announcement',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/announcement/create'
						],
						[
							'label' => 'Announcement List',
							'required_features' => [],
							'url' => 'recruitment/hair-stylist/announcement'
						],
					],
					'icon' => 'fa fa-bullhorn'
				],
				[
					'label' => 'Redirect Complex',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Redirect Complex',
							'required_features' => [],
							'url' => 'redirect-complex/create'
						],
						[
							'label' => 'Redirect Complex List',
							'required_features' => [],
							'url' => 'redirect-complex'
						],
					],
					'icon' => 'fa fa-external-link'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Settings',
			'children' => [
				[
					'label' => 'Mobile Apps Home',
					'required_features' => [],
					'url' => 'setting/home',
					'icon' => 'icon-screen-tablet '
				],
				[
					'label' => 'Setting Outlet Apps',
					'required_features' => [],
					'url' => 'setting/outletapp',
					'icon' => 'fa fa-tablet'
				],
				[
					'label' => 'Setting Outlet Apps',
					'required_features' => [],
					'url' => 'setting/outletapp',
					'icon' => 'fa fa-tablet'
				],
				[
					'label' => 'Setting Mitra Apps',
					'required_features' => [],
					'url' => 'setting/mitra-apps',
					'icon' => 'fa fa-tablet'
				],
				[
					'label' => 'Setting Phone Number',
					'required_features' => [],
					'url' => 'setting/phone',
					'icon' => 'fa fa-phone'
				],
				[
					'label' => 'Setting Landing Page',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Content Header And Footer Partner',
							'required_features' => [],
							'url' => 'businessdev/setting/partner'
						],
						[
							'label' => 'Content Header And Footer Location',
							'required_features' => [],
							'url' => 'businessdev/setting/location'
						],
						[
							'label' => 'Content Header And Footer Hair Stylist',
							'required_features' => [],
							'url' => 'businessdev/setting/hairstylist'
						],
					],
					'icon' => 'fa fa-user-plus'
				],
				[
					'label' => 'Text Menu',
					'required_features' => [],
					'url' => 'setting/text_menu',
					'icon' => 'fa fa-bars'
				],
				[
					'label' => 'Fraud Detection',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Fraud Detection Settings',
							'required_features' => [],
							'url' => 'setting-fraud-detection'
						],
						[
							'label' => 'Report Fraud Device',
							'required_features' => [],
							'url' => 'fraud-detection/report/device'
						],
						[
							'label' => 'Report Fraud Transaction Day',
							'required_features' => [],
							'url' => 'fraud-detection/report/transaction-day'
						],
						[
							'label' => 'Report Fraud Transaction Week',
							'required_features' => [],
							'url' => 'fraud-detection/report/transaction-week'
						],
						[
							'label' => 'Report Fraud Transaction in Between',
							'required_features' => [],
							'url' => 'fraud-detection/report/transaction-between'
						],
						[
							'label' => 'Report Fraud Referral User',
							'required_features' => [],
							'url' => 'fraud-detection/report/referral-user'
						],
						[
							'label' => 'Report Fraud Referral',
							'required_features' => [],
							'url' => 'fraud-detection/report/referral'
						],
						[
							'label' => 'Report Fraud Promo Code',
							'required_features' => [],
							'url' => 'fraud-detection/report/promo-code'
						],
						[
							'label' => 'List User Fraud',
							'required_features' => [],
							'url' => 'fraud-detection/suspend-user'
						],
						[
							'label' => 'Version Control',
							'required_features' => [],
							'url' => 'version',
							'icon' => 'fa fa-info-circle'
						],
					],
					'icon' => 'fa fa-exclamation'
				],
				[
					'label' => 'Custom Page',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New Custom Page',
							'required_features' => [],
							'url' => 'custom-page/create'
						],
						[
							'label' => 'Custom Page List',
							'required_features' => [],
							'url' => 'custom-page'
						],
					],
					'icon' => 'icon-book-open'
				],
				[
					'label' => 'Intro Apps',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'Intro First Install',
							'required_features' => [],
							'url' => 'setting/intro/first'
						],
						[
							'label' => 'Tutorial In Home',
							'required_features' => [],
							'url' => 'setting/intro/home'
						],
					],
					'icon' => 'icon-screen-tablet'
				],
				[
					'label' => 'Confirmation Messages',
					'required_features' => [],
					'url' => 'setting/confirmation-messages',
					'icon' => 'icon-speech'
				],
				[
					'label' => 'Maintenance Mode',
					'required_features' => [],
					'url' => 'setting/maintenance-mode',
					'icon' => 'icon-wrench'
				],
				[
					'label' => 'Time Expired OTP and Email',
					'required_features' => [],
					'url' => 'setting/time-expired',
					'icon' => 'fa fa-envelope'
				],
				[
					'label' => 'Confirmation Letter Logo',
					'required_features' => [],
					'url' => 'setting/logo-confir',
					'icon' => 'fa fa-image'
				],
				[
					'label' => 'Form Survey',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'List Form Survey',
							'required_features' => [],
							'url' => 'businessdev/form-survey'
						],
						[
							'label' => 'New Form Survey',
							'required_features' => [],
							'url' => 'businessdev/form-survey/new'
						],
					],
					'icon' => 'fa fa-list'
				],
				[
					'label' => 'Icount Setting',
					'required_features' => [],
					'url' => 'setting/setting-icount',
					'icon' => 'fa fa-gear'
				],
				[
					'label' => 'Setting Global Commission',
					'required_features' => [],
					'url' => 'setting/setting-global-commission',
					'icon' => 'fa fa-money'
				],
				[
					'label' => 'Setting Attendances Date',
					'required_features' => [],
					'url' => 'setting/setting-attendances-date',
					'icon' => 'fa fa-location-arrow'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'About',
			'children' => [
				[
					'label' => 'About Us',
					'required_features' => [],
					'url' => 'setting/about',
					'icon' => 'icon-info'
				],
				[
					'label' => 'FAQ',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => 'New FAQ',
							'required_features' => [],
							'url' => 'setting/faq/create'
						],
						[
							'label' => 'List FAQ',
							'required_features' => [],
							'url' => 'setting/faq'
						],
						[
							'label' => 'Sorting FAQ List',
							'required_features' => [],
							'url' => 'setting/faq/sort'
						],
					],
					'icon' => 'icon-question'
				],
				[
					'label' => 'Ketentuan Layanan',
					'required_features' => [],
					'url' => 'setting/tos',
					'icon' => 'icon-note'
				],
				[
					'label' => 'Privacy Policy',
					'required_features' => [],
					'url' => 'setting/privacypolicy',
					'icon' => 'fa fa-lock'
				],
				[
					'label' => 'Delivery Services',
					'required_features' => [],
					'url' => 'delivery-service',
					'icon' => 'icon-social-dropbox'
				],
				[
					'label' => 'Help Desk',
					'required_features' => [],
					'url' => 'enquiries/create',
					'icon' => 'fa fa-phone'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Disburse',
			'children' => [
				[
					'label' => 'Dashboard',
					'required_features' => [],
					'url' => 'disburse/dashboard',
					'icon' => 'fa fa-th'
				],
				[
					'label' => 'List All',
					'required_features' => [],
					'url' => 'disburse/list/all',
					'icon' => 'fa fa-list'
				],
				[
					'label' => 'List Success',
					'required_features' => [],
					'url' => 'disburse/list/success',
					'icon' => 'fa fa-list'
				],
				[
					'label' => 'List Fail',
					'required_features' => [],
					'url' => 'disburse/list/fail-action',
					'icon' => 'fa fa-list'
				],
				[
					'label' => 'List Transaction Online',
					'required_features' => [],
					'url' => 'disburse/list/trx',
					'icon' => 'fa fa-list'
				],
				[
					'label' => 'Settings',
					'required_features' => [],
					'type' => 'tree',
					'children' => [
						[
							'label' => '[Response] Failed Send Disburse',
							'required_features' => [],
							'url' => 'disburse/autoresponse/failed-send-disburse'
						],
						[
							'label' => 'Add Bank Account',
							'required_features' => [],
							'url' => 'disburse/setting/bank-account'
						],
						[
							'label' => 'Edit Bank Account',
							'required_features' => [],
							'url' => 'disburse/setting/edit-bank-account'
						],
						[
							'label' => 'MDR',
							'required_features' => [],
							'url' => 'disburse/setting/mdr'
						],
						[
							'label' => 'Global Setting',
							'required_features' => [],
							'url' => 'disburse/setting/global'
						],
					],
					'icon' => 'fa fa-sliders'
				],
			],
		],
		[
			'type' => 'group',
			'label' => 'Report',
			'children' => [
				[
					'label' => 'Report',
					'required_features' => [],
					'url' => 'report',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Compare Report',
					'required_features' => [],
					'url' => 'report/compare',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Global',
					'required_features' => [],
					'url' => 'report/global',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Customer',
					'required_features' => [],
					'url' => 'report/customer/summary',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Product',
					'required_features' => [],
					'url' => 'report/product',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Outlet',
					'required_features' => [],
					'url' => 'report/outlet',
					'icon' => 'icon-graph'
				],
				[
					'label' => 'Shift',
					'required_features' => [],
					'url' => 'report/shift/summary',
					'icon' => 'icon-graph'
				]
			]
		],
	],
];