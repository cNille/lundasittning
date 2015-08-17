-- SQL init queries for setting up database.

set FOREIGN_KEY_CHECKS = 0;

drop table if exists users;
drop table if exists usertype;
drop table if exists rooms;
drop table if exists roomtype;
drop table if exists issues;
drop table if exists severity;
drop table if exists status;


create table users (
    userId          integer auto_increment,
    userName        varchar(20) not null unique,
    userPassword    varchar(20),
    userEmail       varchar(30),
    userType        varchar(20),
    roomName        varchar(20),
    primary key (userId),
    foreign key (userType) references usertype(userType),
    foreign key (roomName) references rooms(roomName)
);

create table usertype (
    userType        varchar(20),
    primary key(userType)
);

create table rooms (
    roomName        varchar(20),
    roomType        varchar(20),
    private			integer default 0,
    primary key (roomName),
    foreign key(roomType) references roomtype(roomType)
);

create table roomtype (
    roomType        varchar(20),
    primary key (roomType)
);

create table issues (
    issuesId        integer auto_increment,
    title           varchar(30) not null,
    description     text,
    userId          integer,
    severityType    varchar(20),
    statusType      varchar(20) default 'new',
    issueDate		DATE,
    roomName        varchar(20),
    comments		text,
    fixerName		varchar(20),
    active			integer default 1,
    primary key (issuesId),
    foreign key (userId) references users(userId),
    foreign key (severityType) references severity(severityType),
    foreign key (statusType) references status(statusType),
    foreign key (roomName) references rooms(roomName)
);

create table severity (
    severityType    varchar(20),
    primary key (severityType)
);

create table status (
    statusType      varchar(20),
    primary key (statusType)
);

start transaction;

insert into severity values
    ('small'),
    ('medium'),
    ('large');

insert into status values
    ('new'),
    ('ongoing'),
    ('done');

insert into usertype values
    ('inhouse'),
    ('admin'),
    ('nation');

insert into roomtype values
    ('1S'),
    ('1N'),
    ('2S'),
    ('2N'),
    ('3S'),
    ('3N'),
    ('nationrooms'),
    ('public');

insert into rooms values
    ('121', '1S', 1),
    ('122', '1S', 1),
    ('123', '1S', 1),
    ('124', '1S', 1),
    ('125', '1S', 1),
    ('126', '1S', 1),
    ('127', '1S', 1),
    ('128', '1S', 1),
    ('129', '1S', 1),
    ('120', '1N', 1),
    ('110', '1N', 1),
    ('111', '1N', 1),
    ('112', '1N', 1),
    ('113', '1N', 1),
    ('114', '1N', 1),
    ('221', '2S', 1),
    ('222', '2S', 1),
    ('223', '2S', 1),
    ('224', '2S', 1),
    ('225', '2S', 1),
    ('226', '2S', 1),
    ('227', '2S', 1),
    ('228', '2S', 1),
    ('229', '2S', 1),
    ('211', '2N', 1),
    ('212', '2N', 1),
    ('213', '2N', 1),
    ('214', '2N', 1),
    ('215', '2N', 1),
    ('216', '2N', 1),
    ('217', '2N', 1),
    ('218', '2N', 1),
    ('219', '2N', 1),
    ('321', '3S', 1),
    ('322', '3S', 1),
    ('323', '3S', 1),
    ('324', '3S', 1),
    ('325', '3S', 1),
    ('326', '3S', 1),
    ('327', '3S', 1),
    ('328', '3S', 1),
    ('329', '3S', 1),
    ('311', '3N', 1),
    ('312', '3N', 1),
    ('313', '3N', 1),
    ('314', '3N', 1),
    ('315', '3N', 1),
    ('316', '3N', 1),
    ('317', '3N', 1),
    ('318', '3N', 1),
    ('319', '3N', 1),
    ('Korridor 1N', '1N', 0),
    ('Korridor 1S', '1S', 0),
    ('Korridor 2S', '2S', 0),
    ('Korridor 2N', '2N', 0),
    ('Korridor 3S', '3S', 0),
    ('Korridor 3N', '3N', 0),
    ('Kök 1S', '1S', 0),
    ('Kök 2S', '2S', 0),
    ('Kök 2N', '2N', 0),
    ('Kök 3S', '3S', 0),
    ('Kök 3N', '3N', 0),
    ('Lelles', 'public', 0),
    ('Tvättstuga', 'public', 0),
    ('Cykelgången', 'public', 0),
    ('Foajen', 'public', 0),
    ('Poolen', 'public', 0),
    ('Uteplatsen', 'public', 0),
    ('115', 'nationrooms', 0),
    ('Expen', 'nationrooms', 0),
    ('Gillis', 'nationrooms', 0),
    ('Gillis kök', 'nationrooms', 0),
    ('källaren', 'public', 0);


insert into users (userName, userPassword, userEmail, userType, roomName) values 
    ('nille', '123', 'c@shapeapp.se', 'inhouse', '312'),
    ('quratel', '123', 'expen@krischan.se', 'nation', 'Expen'),
    ('julle', '123', 'feedback@juliankrone.com', 'nation', 'jullesroom'),
    ('houseforeman', '123', 'test@test.com', 'admin', 'källaren'),
    ('110', '110', '', 'inhouse', '110'),
    ('111', '111', '', 'inhouse', '111'),
    ('112', '112', '', 'inhouse', '112'),
    ('113', '113', '', 'inhouse', '113'),
    ('114', '114', '', 'inhouse', '114'),
    ('121', '121', '', 'inhouse', '121'),
    ('122', '122', '', 'inhouse', '122'),
    ('123', '123', '', 'inhouse', '123'),
    ('124', '124', '', 'inhouse', '124'),
    ('125', '125', '', 'inhouse', '125'),
    ('126', '126', '', 'inhouse', '126'),
    ('127', '127', '', 'inhouse', '127'),
    ('128', '128', '', 'inhouse', '128'),
    ('129', '129', '', 'inhouse', '129'),
    ('221', '221', '', 'inhouse', '221'),
    ('222', '222', '', 'inhouse', '222'),
    ('223', '223', '', 'inhouse', '223'),
    ('224', '224', '', 'inhouse', '224'),
    ('225', '225', '', 'inhouse', '225'),
    ('226', '226', '', 'inhouse', '226'),
    ('227', '227', '', 'inhouse', '227'),
    ('228', '228', '', 'inhouse', '228'),
    ('229', '229', '', 'inhouse', '229'),
    ('211', '211', '', 'inhouse', '211'),
    ('212', '212', '', 'inhouse', '212'),
    ('213', '213', '', 'inhouse', '213'),
    ('214', '214', '', 'inhouse', '214'),
    ('215', '215', '', 'inhouse', '215'),
    ('216', '216', '', 'inhouse', '216'),
    ('217', '217', '', 'inhouse', '217'),
    ('218', '218', '', 'inhouse', '218'),
    ('219', '219', '', 'inhouse', '219'),
    ('321', '321', '', 'inhouse', '321'),
    ('322', '322', '', 'inhouse', '322'),
    ('323', '323', '', 'inhouse', '323'),
    ('324', '324', '', 'inhouse', '324'),
    ('325', '325', '', 'inhouse', '325'),
    ('326', '326', '', 'inhouse', '326'),
    ('327', '327', '', 'inhouse', '327'),
    ('328', '328', '', 'inhouse', '328'),
    ('329', '329', '', 'inhouse', '329'),
    ('311', '311', '', 'inhouse', '311'),
    ('312', '312', '', 'inhouse', '312'),
    ('313', '313', '', 'inhouse', '313'),
    ('314', '314', '', 'inhouse', '314'),
    ('315', '315', '', 'inhouse', '315'),
    ('316', '316', '', 'inhouse', '316'),
    ('317', '317', '', 'inhouse', '317'),
    ('318', '318', '', 'inhouse', '318'),
    ('319', '319', '', 'inhouse', '319');


commit;

set FOREIGN_KEY_CHECKS = 1;







