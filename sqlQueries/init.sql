-- SQL init queries for setting up database.

set FOREIGN_KEY_CHECKS = 0;

select 'Drop old tables' as '';
drop table if exists users;
drop table if exists guestuser;
drop table if exists usertype;
drop table if exists foodpref;
drop table if exists userfood;
drop table if exists guestuserfood;
drop table if exists restaurant;
drop table if exists restaurantuser;
drop table if exists sitting;
drop table if exists sittingforeman;
drop table if exists party;
drop table if exists partytype;
drop table if exists partycreator;
drop table if exists partyguest;
drop table if exists paystatus;
drop table if exists log;
drop table if exists event;


select 'Create restaurant' as '';
create table restaurant (
	resName			varchar(30),
	resNickname		varchar(30),
	resEmail		varchar(30),
	resHours		tinytext,
	resDeposit		integer,
	resPrice		integer,
	resSize			integer,
	resSummary		tinytext,
	primary key(resName)
);

select 'Create users' as '';
create table users (
	userId			integer auto_increment,
	facebookId		varchar(30) UNIQUE,
	userName		varchar(30),
	userEmail		varchar(30),
	userTelephone	varchar(15),
	userOther		varchar(20),
	active			tinyint(1) DEFAULT 1,
	primary key(userId)
);

select 'Create guestuser' as '';
create table guestuser (
	guestId 		integer auto_increment,
	guestName 		varchar(30),
	partyId 		integer,
	guestFoodPref 	tinytext,	
	userPayed		varchar(30),
	primary key (guestId),
    foreign key (userPayed) references paystatus(status)
);

select 'Create usertype' as '';
create table usertype (
	userType		varchar(20),
	accessLevel		integer,
	primary key(userType)
);

select 'Create restaurantuser' as '';
create table restaurantuser (
	userId		integer,
	resName		varchar(30),
	userType	varchar(20),
	primary key (userId, resName),
	foreign key (userId) references users(userId),
	foreign key (userType) references usertype(userType),
	foreign key (resName) references restaurant(resName) ON UPDATE CASCADE
);


select 'Create foodpref' as '';
create table foodpref (
	foodPref		varchar(20),
	primary key(foodPref)
);

select 'Create userfood' as '';
create table userfood (
	userId			integer,
	foodPref		varchar(20),
	primary key(userId,foodPref),
	foreign key (userId) references users(userId),
	foreign key (foodPref) references foodpref(foodPref) ON UPDATE CASCADE
);

select 'Create guestuserfood' as '';
create table guestuserfood (
	guestId			integer,
	foodPref		varchar(20),
	primary key(guestId,foodPref),
	foreign key (guestId) references guestuser(guestId),
	foreign key (foodPref) references foodpref(foodPref) ON UPDATE CASCADE
);

select 'Create sitting' as '';
create table sitting (
	sittId 				integer auto_increment,
	sittDate			date not null,
	sittAppetiser		varchar(50),
	sittMain			varchar(50),
	sittDesert			varchar(50),
	sittPrelDeadline	date,
	sittPayDeadline		date,
	active				tinyint(1) DEFAULT 1,
	resName				varchar(30),
	spotsLeft			tinyint(1) DEFAULT 0,
	primary key(sittId),
	foreign key(resName) references restaurant(resName) ON UPDATE CASCADE
);

select 'Create sittingforeman' as '';
create table sittingforeman (
	sittId				integer,
	userId				integer,
	primary key(sittId,userId),
	foreign key (sittId) references sitting(sittId),
	foreign key (userId) references users(userId)
);

select 'Create party' as '';
create table party (
	partyId			integer auto_increment,
	partyName		varchar(30),
	partyType		varchar(20),
	sittId			integer NOT NULL,
	partyInterest	integer,
	partyPrel		integer DEFAULT 0,
	partyPayed		integer DEFAULT 0,
	partyMessage	text,
	urlkey			varchar(10) NOT NULL,
	primary key(partyId),
	foreign key(partyType) references partytype(partyType) ON UPDATE CASCADE,
	foreign key(sittId) references sitting(sittId)
);

select 'Create partytype' as '';
create table partytype (
	partyType		varchar(20),
	primary key(partyType)
);

select 'Create partycreator' as '';
create table partycreator (
	partyId			integer,
	userId			integer,
	primary key(partyId,userId),
	foreign key (partyId) references party(partyId),
	foreign key (userId) references users(userId)
);

select 'Create partyguest' as '';
create table partyguest (
	partyId			integer,
	userId			integer,
	userPayed		varchar(30),
	primary key (partyId,userId),
	foreign key (partyId) references party(partyId),
	foreign key (userId) references users(userId),
    foreign key (userPayed) references paystatus(status)
);

select 'Create paystatus' as '';
create table paystatus (
    status          varchar(30),
    accesslevel     integer,
    primary key (status)
);

select 'Create log' as '';
create table log (
	logId			integer auto_increment,
	userId			integer,
	eventText		varchar(50),
	date			date,
	resName			varchar(30),
	primary key(logId),
	foreign key (userId) references users(userId),
	foreign key (eventText) references event(eventText) ON UPDATE CASCADE,
	foreign key (resName) references restaurant(resName) ON UPDATE CASCADE
);

select 'Create event' as '';
create table event (
	eventText		varchar(50),
	primary key(eventText)
);

set FOREIGN_KEY_CHECKS = 1;




