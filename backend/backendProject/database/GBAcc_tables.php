<?php

$query1 = "CREATE table IF NOT EXISTS company_info (
	id int unsigned not null auto_increment,
	primary key (id),
	name varchar(250) null,
	logo_ref varchar(250) null,
	website varchar(250) null,
	email varchar(250) null,
	phone varchar(15) null,
	address varchar(250) null,
	other text null,
	slider text DEFAULT NULL,
	branches text,

	lock_site tinyint DEFAULT 0

)";

$query2 = "CREATE table if not exists roles (
	id int unsigned not null auto_increment,
	primary key (id),
	transcid varchar(50),
	rolename varchar(255),
	roledesc text DEFAULT NULL
)";

$query3 = "CREATE table if not exists activitylog (
	id int(11) unsigned not null auto_increment,
	primary key (id),
	user_id int(50),
	action varchar(250),
	type varchar(10) default 'admin',
	location varchar(250),
	location_id varchar(50),
	description varchar(250),
	date_updated DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	date_created DATETIME NULL DEFAULT CURRENT_TIMESTAMP
)";

$query4 = "CREATE table if not exists users (
	id int unsigned not null auto_increment,
	primary key (id),
	first_name varchar(50) default null,
	last_name varchar(50) default null,
	phone varchar(50) default null,
	email varchar(50) default null,
	username varchar(50) default null,
	country varchar(50) default null,
	image varchar(250) default null,
	address varchar(250) default null,
	password text not null,
	type tinyint default 0,
	status tinyint default 0,
	role tinyint default 0,
	access_level tinyint default 0,
	date_updated DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	date_created DATETIME NULL DEFAULT CURRENT_TIMESTAMP
)";
