<?php
$query5 = "CREATE TABLE IF NOT EXISTS waybill (
 id int(10) NOT NULL AUTO_INCREMENT,
 user_id int(10) NOT NULL,
 parcel_title varchar(50) NOT NULL,
 parcel_weight varchar(50) NOT NULL,
 parcel_charge double NOT NULL DEFAULT 0,
 tracking_number varchar(50) NOT NULL,

 cargo_type varchar(10) NOT NULL,
 sender int(10) NOT NULL,
 receipient int(10) NOT NULL,

 status tinyint(2) NOT NULL DEFAULT 0,
 date_created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 date_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (id),
 UNIQUE KEY (tracking_number)
) ";

$query6 = "CREATE TABLE IF NOT EXISTS tracking (
 id int(10) NOT NULL AUTO_INCREMENT,
 waybill_id int(10) NOT NULL,
 tracking_message varchar(250) NOT NULL,

 status varchar(10) NOT NULL DEFAULT 0,
 date_created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 date_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (id)
) ";
