-- SQL init queries for setting up database.

set FOREIGN_KEY_CHECKS = 0;

select 'Drop old tables' as '';
drop table if exists loginaccount;
drop table if exists participant;
drop view if exists participantlogin;
drop table if exists usertype;
drop table if exists foodpref;
drop table if exists participantfood;
drop table if exists restaurant;
drop table if exists restaurantparticipant;
drop table if exists sitting;
drop table if exists sittingforeman;
drop table if exists party;
drop table if exists partytype;
drop table if exists partycreator;
drop table if exists partyparticipant;
drop table if exists paystatus;
drop table if exists log;


select 'Create restaurant' as '';
create table restaurant (
    name			varchar(30),
	nickname		varchar(30),
	email	    	varchar(50),
    telephone       varchar(30),
	homepage        varchar(70),
    hours	    	tinytext,
    address         varchar(70),
	deposit 		integer,
	price   		integer,
	size   			integer,
	summary 		tinytext,
	backgroundimage tinytext,
	loggoimage 		tinytext,
    active          tinyint(1) DEFAULT 1,
    preldate 		integer DEFAULT '14',
    paydate 		integer DEFAULT '10',
	primary key(name)
);

select 'Create loginaccount' as '' ;
create table loginaccount (
    id              integer auto_increment,
    fbid            varchar(30) UNIQUE,
    email           varchar(30),
    telephone       varchar(15),
    primary key(id)
);

select 'Create participant' as '';
create table participant (
    id              integer auto_increment,
    name            varchar(30),
    other           varchar(50),
    loginaccount    integer NULL,
    active          tinyint(1) DEFAULT 1,
    primary key (id),
    foreign key (loginaccount) references loginaccount(id)
); 

select 'Create participantlogin view' as '';
create view participantlogin as SELECT p.id, p.name, l.fbid, l.email, l.telephone, p.other, p.active FROM participant as p JOIN loginaccount as l WHERE p.loginaccount=l.id;

select 'Create usertype' as '';
create table usertype (
	userType		varchar(20),
	accessLevel		integer,
	primary key(userType)
);

select 'Create restaurantparticipant' as '';
create table restaurantparticipant (
	participantId		integer,
	resName		        varchar(30),
	userType	        varchar(20),
	primary key (participantId, resName),
	foreign key (participantId) references participant(id),
	foreign key (userType) references usertype(userType),
	foreign key (resName) references restaurant(name) ON UPDATE CASCADE
);


select 'Create foodpref' as '';
create table foodpref (
	foodPref		varchar(20),
	primary key(foodPref)
);

select 'Create participantfood' as '';
create table participantfood (
	participantId			integer,
	foodPref	        	varchar(20),
	primary key(participantId,foodPref),
	foreign key (participantId) references participant(id),
	foreign key (foodPref) references foodpref(foodPref) ON UPDATE CASCADE
);

select 'Create sitting' as '';
create table sitting (
	id 				    integer auto_increment,
	sittDate		   	date not null,
	appetiser   		varchar(50),
	main       			varchar(50),
	desert	    		varchar(50),
	active				tinyint(1) DEFAULT 1,
	resName				varchar(30),
	primary key(id),
	foreign key(resName) references restaurant(name) ON UPDATE CASCADE
);

select 'Create sittingforeman' as '';
create table sittingforeman (
	sittId				integer,
	participantId				integer,
	primary key(sittId,participantId),
	foreign key (sittId) references sitting(id),
	foreign key (participantId) references participant(id)
);

select 'Create party' as '';
create table party (
	id  			integer auto_increment,
	name    		varchar(30),
	partyType		varchar(20),
	sittId			integer NOT NULL,
	interest    	integer,
	message     	text,
	urlkey			varchar(10) NOT NULL,
	active			tinyint(1) DEFAULT 1,
	primary key(id),
	foreign key(partyType) references partytype(partyType) ON UPDATE CASCADE,
	foreign key(sittId) references sitting(id)
);

select 'Create partytype' as '';
create table partytype (
	partyType		varchar(20),
	primary key(partyType)
);

select 'Create partycreator' as '';
create table partycreator (
	partyId		    	integer,
	participantId		integer,
	primary key(partyId,participantId),
	foreign key (partyId) references party(id),
	foreign key (participantId) references participant(id)
);

select 'Create paystatus' as '';
create table paystatus (
    status          varchar(30),
    accesslevel     integer,
    primary key (status)
);

select 'Create partyparticipant' as '';
create table partyparticipant (
    partyId		    	integer,
    participantId		integer,
    participantPayed   	varchar(30),
    primary key (partyId,participantId),
    foreign key (partyId) references party(id),
    foreign key (participantId) references participant(id),
    foreign key (participantPayed) references paystatus(status)
);

select 'Create log' as '';
create table log (
	id  		    	integer auto_increment,
	participantId		integer,
	eventText	    	varchar(50),
	logDate			    datetime,
	resName		    	varchar(30),
	primary key(id),
	foreign key (participantId) references participant(id),
	foreign key (resName) references restaurant(name) ON UPDATE CASCADE
);


set FOREIGN_KEY_CHECKS = 1;




