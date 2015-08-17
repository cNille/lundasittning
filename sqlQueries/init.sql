-- SQL init queries for setting up database.

set FOREIGN_KEY_CHECKS = 0;

drop table if exists users;
drop table if exists usertype;
drop table if exists foodpref;
drop table if exists userFood;
drop table if exists restaurant;
drop table if exists sitting;
drop table if exists sittingforeman;
drop table if exists party;
drop table if exists partytype;
drop table if exists partyuser;
drop table if exists partyguest;
drop table if exists log;
drop table if exists event;

create table users (
	userId			integer auto_increment,
	facebookId		integer,
	userName		varchar(30),
	userEmail		varchar(30),
	userTelephone	varchar(15),
	userType		varchar(20),
	primary key(userId),
	foreign key (userType) references usertype(userType)
);

create table usertype (
	userType		varchar(20),
	primary key(userType)
);

create table foodpref (
	foodPref		varchar(20),
	primary key(foodPref)
);

create table userFood (
	userId			integer,
	foodPref		varchar(20),
	primary key(userId,foodPref),
	foreign key (userId) references users(userId),
	foreign key (foodPref) references foodpref(foodPref)
);

create table restaurant (
	resName			varchar(30),
	resEmail		varchar(30),
	resHours		tinytext,
	resDeposit		integer,
	resPrice		integer,
	resSize			integer,
	resSummary		tinytext,
	primary key(resName)
);

create table sitting (
	sittDate			date not null unique,
	sittAppetiser		varchar(50),
	sittMain			varchar(50),
	sittDesert			varchar(50),
	sittPrelDeadline	date,
	sittPayDeadline		date,
	primary key(sittDate)
);

create table sittingforeman (
	sittDate			date,
	userId				integer,
	primary key(sittDate,userId),
	foreign key (sittDate) references sitting(sittDate),
	foreign key (userId) references users(userId)
);

create table party (
	partyId			integer auto_increment,
	partyName		varchar(30),
	partyType		varchar(20),
	partyInterest	integer,
	partyPrel		integer,
	partyPayed		integer,
	primary key(partyId),
	foreign key(partyType) references partytype(partyType)
);

create table partytype (
	partyType		varchar(20),
	primary key(partyType)
);

create table partyuser (
	partyId			integer,
	userId			integer,
	primary key(partyId,userId),
	foreign key (partyId) references party(partyId),
	foreign key (userId) references users(userId)
);

create table partyguest (
	partyId			integer,
	userId			integer,
	userPayed		tinyint(1),
	primary key(partyId,userId),
	foreign key (partyId) references party(partyId),
	foreign key (userId) references users(userId)
);

create table log (
	logId			integer auto_increment,
	userId			integer,
	eventText		varchar(50),
	date			date,
	primary key(logId),
	foreign key (userId) references users(userId),
	foreign key (eventText) references event(eventText)
);

create table event (
	eventText		varchar(50),
	primary key(eventText)
);

set FOREIGN_KEY_CHECKS = 1;

