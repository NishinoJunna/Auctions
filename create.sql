drop database if exists cake3Auctions;

create database cake3Auctions default character set utf8;

use cake3Auctions;

drop table if exists users;

create table users(
	id int(11) not null auto_increment,
	email varchar(255) not null,
	password varchar(255) not null,
	modified datetime default null,
	created datetime default null,
	primary key (id),
	unique key email (email)
)engine=InnoDB default charset=utf8;

drop table if exists products;

create table products(
	id int(11) not null auto_increment,
	user_id int(11) not null,
	name varchar(255) not null,
	description varchar(255) not null,
	start_price int(11) not null,
	start_date datetime default null,
	end_date datetime default null,
	status int(11) not null,
	modified datetime default null,
	created datetime default null,
	primary key (id)
)engine=InnoDB default charset=utf8;

drop table if exists bids;

create table bids(
	id int(11) not null auto_increment,
	user_id int(11) not null,
	product_id int(11) not null,
	bid int(11) not null,
	created datetime default null,
	primary key (id)
)engine=InnoDB default charset=utf8;

drop table if exists end_bids;

create table end_bids(
	id int(11) not null auto_increment,
	user_id int(11) not null,
	product_id int(11) not null,
	fixed_price int(11) not null,
	created datetime default null,
	primary key (id)
)engine=InnoDB default charset=utf8;

















