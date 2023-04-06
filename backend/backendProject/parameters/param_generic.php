<?php
require_once("userForm.php");
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
$user_al = isset($_SESSION["accesslevel"]) ? $_SESSION["accesslevel"] : 1;
$actLog = $user_al >= 2 ? "" : ", user_id=$user_id";

$param = [
	"admin_signin" => [ //Signin Parameters
		"table" 			=> "users",
		"primary_key"	=> "id",
		"date_col"	=> "date",
		"page_title" => "Admin Profile",
		"username_col" => "username",
		"password_col" => "password",
		// "password_hash" => "password_hash",
		"name_col"  	=> "first_name",
		"last_name_col"  	=> "last_name",
		"phone_col"  	=> "phone",
		"email_col" 	=> "email",
		"image_col"		=> "image",
		"form"		=> "users",
		"display_fields" => [
			[
				"column" => "date_created",
				"description" => "Registration Date",
				"action" => "datetime",
			],
			[
				"column" => "gender",
				"description" => "Gender",
				"action" => "select",
				"source" => "gender"
			],
			[
				"column" => "dob",
				"description" => "Date of Birth",
				"action" => "date"
			]
		],
		"retrieve_filter"	=> "type=1, status=1",
		"callback" 		=> "signin_log",
	],

	"organization" 	=> [ //The current organization using the code
		"table"				=> "company_info",
		"primary_key"	=> "id",
		"key"	=> 1,
		"page_title"	=> "Settings",
		"form" => [
			"sections" => [
				[
					"position" => "left",
					"section_title" => "Basic Company Info",
					"section_elements" => [
						[
							"column" => "name",
							"description" => "Business Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "email",
							"description" => "Email Address",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "website",
							"description" => "Website",
							"required" => false,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "address",
							"description" => "Address",
							"required" => false,
							"type" => "text",
							"class" => "col s12 m12"
						],
						[
							"column" => "phone",
							"description" => "Phone",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12",
						],

						[
							"column" => "divider",
							"type" => "divider",
							"class" => "col s12 m12",
						],
						[
							"column" => "lock_site",
							"description" => "Disable the Website ?",
							"type" => "switch",
							"source" => "bool",
							"class" => "col s12 m6",
						],
					]
				],
				[
					"position" => "right",
					"section_title" => "Company Logo",
					"section_elements" => [
						[
							"column" => "logo_ref",
							"description" => "Logo",
							"required" => true,
							"type" => "items",
							"value" => 2,
							"class" => "col s12 m12"
						]
					]
				],
				[
					"position" => "right",
					"section_title" => "Social Media",
					"section_elements" => [
						[
							"column" => "branches",
							"description" => "Media Links",
							// "required" => true,
							"type" => "description",
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	"role" => [
		"table" => "roles",
		"primary_key" => "id",
		"page_title" => "Roles",
		"display_fields" => [
			[
				"column" => "rolename",
				"description" => "Role Name",
				"component" => "span",
			]
		],
		"form" => [
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Role Info",
					"section_elements" => [
						[
							"column" => "rolename",
							"description" => "Role Name",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12"
						], [
							"column" => "roledesc",
							"description" => "Role Name",
							"required" => true,
							"type" => "roles",
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	"log" => [
		"table" => "activitylog",
		"primary_key" => "id",
		"page_title" => "log",
		"listFAB" => false,
		"retrieve_filter" => "type='admin' $actLog",
		"sort_col" => "id DESC",
		"display_fields" => [
			[
				"column" => "action",
				"description" => "Action",
				"component" => "span"
			], [
				"column" => "description",
				"description" => "Description",
				"component" => "span"
			], [
				"column" => "date_created",
				"description" => "Time",
				"component" => "span",
				"action" => "datetime"
			]
		],
		"form" => [
			"form_view" => "modal",
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Log Details",
					"section_elements" => [
						[
							"column" => "description",
							"description" => "Description",
							"type" => "textarea",
							"readonly" => true,
							"class" => "col s12"
						]
					]
				]
			]
		]
	],

	"users" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "Admin Users",
		"fixed_values" => "status=1",
		"retrieve_filter" => "status=1, type=1",
		// "pre_submit_function" => "prepare_new_member",
		"listFAB" => ["refresh"],
		// "extension" => ["open_memeber", "referrals"],
		"display_fields" => [
			[
				"column" => "first_name",
				"description" => "First Name",
				"component" => "span",
			],
			[
				"column" => "last_name",
				"description" => "Last Name",
				"component" => "span",
			],
			[
				"column" => "username",
				"description" => "UserName",
				"component" => "span",
			],
			[
				"column" => "date_created",
				"action" => "datetime",
				"description" => "Date",
				"component" => "span",
			]
		],
		"form" => [
			"form_view" => "modal",
			"form_size" => "modal-lg",
			"sections" => userForm(true)
		]
	],

	"members" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "Verified Members",
		"fixed_values" => "status=1",
		// "extension" => ["open_memeber"],
		"listFAB" => ["refresh", "add"],
		"pre_submit_function" => "prepare_new_member",
		"retrieve_filter" => "status=1, type=2",
		"display_fields" => [
			[
				"column" => "first_name",
				"description" => "First Name",
				"component" => "span",
			],
			[
				"column" => "last_name",
				"description" => "Last Name",
				"component" => "span",
			],
			[
				"column" => "username",
				"description" => "UserName",
				"component" => "span",
			],
			[
				"column" => "date_created",
				"action" => "datetime",
				"description" => "Date",
				"component" => "span",
			]
		],
		"form" => [
			"form_view" => "modal",
			"form_size" => "modal-lg",
			"sections" => userForm()
		]
	],

	'tracking' => [
		'table' => 'tracking',
		'primary_key' => 'id',
		'page_title' => 'Tracking',
		"extra_values" => "date_updated=now()",
		'sort' => 'id DESC',
		'display_fields' => [
			[
				'column' => 'tracking_message',
				'description' => 'Tracking Message',
				'component' => 'span',
				'source' => 'tracking_status',
				'action' => 'select',
			],
			[
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'tracking_status',
			]

		],

		'display_level' => [
			'source' => 'waybills',
			'column' => 'waybill_id',
			'loadform' => true
		],


		'form' => [
			"form_view" => "modal",
			"form_action" => "tracking_prepare",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Tracking Details',
					'section_elements' => [
						[
							'column' => 'tracking_message',
							'description' => 'Tracking Message',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'select',
							// 'value' => "value",
							'source' => 'tracking_message',
						],

						[
							'column' => 'status',
							'description' => 'Activation Status',
							'class' => 'left col s12 m12',
							'source' => 'tracking_status',
							'type' => 'select',
						],
					]
				]
			]
		]
	],

	'waybills' => [
		'table' => 'waybill',
		'primary_key' => 'id',
		'page_title' => 'Waybills',
		'sort' => 'id DESC',
		"extra_values" => "date_updated=now()",
		"fixed_values" => "user_id=$user_id",
		'display_fields' => [
			[
				'column' => 'tracking_number',
				'description' => 'Tracking Number',
				'component' => 'span'
			],
			[
				'column' => 'parcel_title',
				'description' => 'Parcel Title',
				'component' => 'span'
			],
			[
				'column' => 'sender',
				'description' => 'Sender',
				"action" => "select",
				"source" => "members",
				'component' => 'span'
			],
			[
				'column' => 'receipient',
				'description' => 'Receipient',
				"action" => "select",
				"source" => "members",
				'component' => 'span'
			],
			[
				'column' => 'date_created',
				'description' => 'Opening Date',
				'component' => 'span',
				'action' => 'datetime'
			],
			[
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'status',
			]
		],

		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Waybill Detail',
					'section_elements' => [
						[
							'column' => 'sender',
							'description' => 'Select Sender',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'select',
							'source' => 'members',
						],
						[
							'column' => 'receipient',
							'description' => 'Select Receipient',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'select',
							'source' => 'members',
						],
						[
							'column' => 'parcel_title',
							'description' => 'Parcel Title',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'text'
						],
						[
							'column' => 'cargo_type',
							'description' => 'Cargo Type',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'select',
							'source' => 'cargo_type',
						],
						[
							'column' => 'parcel_weight',
							'description' => 'Parcel Weight (KG)',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'number',
						],
						[
							'column' => 'parcel_charge',
							'description' => 'Parcel Charge ($)',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'number',
						],
						[
							'column' => 'status',
							'description' => 'Activation Status',
							'class' => 'left col s12 m12',
							'source' => 'status',
							'type' => 'select',
						],
					]
				]
			]
		]
	],

];
