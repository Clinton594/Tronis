<?php
$user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
$front = [
  "auth" => [
    "table" => "users",
    "primary_key" => "id",
    "unique_key" => "email",
    "password_hash" => "password_hash",

    "date_col"  => "date",
    "page_title" => "User Profile",
    "username_col" => "username",
    "password_col" => "password",
    "name_col"    => "first_name",
    "last_name_col"    => "last_name",
    "phone_col"    => "phone",
    "status_col"    => "type",
    "email_col"   => "email",
    "image_col"    => "picture_ref",
  ]
];
