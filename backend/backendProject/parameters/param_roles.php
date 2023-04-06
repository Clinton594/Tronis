<?php
$thisyear = date("Y");
$roles = [
  "Organization Setup" => [
    "icon"  => "home",
    "links" => [
      [
        "title" => "Settings",
        "url"   => "form-view/organization"
      ],
      [
        "title" => "Role",
        "url"   => "content-view/role"
      ],
    ]
  ],

  "Users" => [
    "icon"  => "user",
    "links" => [
      [
        "title" => "Administrators",
        "url"   => "level-view/users"
      ],
      [
        "title" => "Members",
        "url"  => "level-view/members"
      ],
    ]
  ],

  "Logistics" => [
    "icon"  => "briefcase",
    "links" => [
      [
        "title" => "Waybills",
        "url"  => "level-view/tracking"
      ],
    ]
  ],
];
