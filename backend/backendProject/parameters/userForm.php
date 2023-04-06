<?php
function userForm($showSecurity = false)
{
  $return = [
    [
      "position" => "left",
      "section_title" => "User Info",
      "section_elements" => [
        [
          "column" => "first_name",
          "description" => "First Name",
          "required" => true,
          "type" => "text",
          "class" => "col s12 m6"
        ], [
          "column" => "last_name",
          "description" => "Last Name",
          "required" => true,
          "type" => "text",
          "class" => "col s12 m6"
        ],
        [
          "column" => "username",
          "description" => "UserName",
          "required" => true,
          "disabled" => true,
          "type" => "text",
          "class" => "col s12 m6"
        ],
        [
          "column" => "country",
          "description" => "Country",
          "class" => "col s12 m6",
          "type" => "select",
          "source" => "countries",
          "required" => true,
        ],

      ]
    ],
    [
      "position" => "right",
      "section_title" => "Contact Info",
      "section_elements" => [
        [
          "column" => "phone",
          "description" => "Phone Number",
          "class" => "col s12",
          "type" => "text"
        ],
        [
          "column" => "from_admin",
          "value" => "1",
          "type" => "hidden",
          "class" => "hide",
        ],
        [
          "column" => "email",
          "description" => "Email",
          "class" => "col s12 m12",
          "type" => "text",
          "required" => true,
        ]
      ]
    ],

    [
      "position" => "middle",
      "section_title" => "Others",
      "section_elements" => [


        [
          "column" => "address",
          "description" => "Address",
          "class" => "col s12",
          "type" => "textarea",

        ],


      ]
    ],
  ];
  if ($showSecurity) {
    $return = array_merge($return, [
      [
        "position" => "left",
        "section_title" => "Security Settings",
        "section_elements" => [

          [
            "column" => "role",
            "description" => "Assign Admin Role",
            "type" => "select",
            "required" => true,
            "class" => "col s12 m6",
            "source" => "role",
          ],
          [
            "column" => "access_level",
            "description" => "Access Level",
            "type" => "select",
            "required" => true,
            "class" => "col s12 m6",
            "source" => "accessLevel",
          ],
          [
            "column" => "password",
            "description" => "Password",
            "type" => "password",
            "required" => true,
            "class" => "col s12 m6"
          ],
        ]
      ],
      [
        "position" => "right",
        "section_title" => "Photo",
        "section_elements" => [
          [
            "column" => "image",
            "description" => "Profile Photo",
            "class" => "col s12 h--100",
            "type" => "picture",
            "required" => true,
          ],
        ]
      ]
    ]);
  } else {
    $return = array_merge($return, [
      [
        "position" => "center",
        "section_title" => "Security Settings",
        "section_elements" => [

          [
            "column" => "type",
            "description" => "Assign User Type",
            "type" => "select",
            "required" => true,
            "class" => "col s12 m6",
            "source" => "user-category",
          ],
          [
            "column" => "password",
            "description" => "Password",
            "type" => "password",
            "required" => true,
            "class" => "col s12 m6"
          ],
        ]
      ],
    ]);
  }
  return $return;
}
