-- Sets in testdata to the tables
start transaction;

select 'Insert restaurant' as '';
insert into restaurant(resName, resPrice, resSize, resSummary) values
    ('Nilles nation', 140, 90, 'EN UPPLEVELSE!'),
    ('Franz nation', 240, 120, 'EN UPPLEVELSE!'),
    ('Malins nation', 40, 50, 'EN UPPLEVELSE!'),
    ('Jennifers nation', 40, 50, 'EN UPPLEVELSE!');

select 'Insert usertype' as '';
insert into usertype values
	('SuperAdmin', 10),
    ('Quratel', 5),
    ('Sittningsförman', 2),
    ('Förman', 1),
    ('Användare', 0);

select 'Insert users' as '';
insert into users(userName, facebookId, userEmail, userTelephone) values
    ('Nille', '1', 'c@shapeapp.se', '0708342311'),
    ('Franz', '2', 'franzmail123@gmail.com', '0708123456'),
    ('Malin', '3', 'cnilsson_92@hotmail.com', '0708123456'),
    ('Franz Lang', '10204701878293819', 'cnilsson_92@hotmail.com', '0708123456'),
    ('Christopher Nilsson', '10153551242685859', 'cnilsson_92@hotmail.com', '0708123456');

select 'Insert restaurantuser' as '';
insert into restaurantuser values
    (1, 'Nilles nation', 'Quratel'),
    (2, 'Nilles nation', 'Förman'),
    (3, 'Nilles nation', 'Sittningsförman'),
    (1, 'Franz nation', 'Förman'),
    (4, 'Nilles nation', 'SuperAdmin'),
    (4, 'Franz nation', 'Quratel'),
    (4, 'Malins nation', 'Förman'),
    (4, 'Jennifers nation', 'Sittningsförman'),
    (5, 'Nilles nation', 'SuperAdmin'),
    (5, 'Franz nation', 'Quratel'),
    (5, 'Malins nation', 'Förman'),
    (5, 'Jennifers nation', 'Sittningsförman'),
    (1, 'Malins nation', 'Quratel');

select 'Insert foodpref' as '';
insert into foodpref values
    ('Laktos'),
    ('Gluten'),
    ('Vegatarian'),
    ('Vegan'),
    ('Nötter');

select 'Insert userfood' as '';
insert into userfood values
    (1, 'Laktos'),
    (2, 'Nötter');

select 'Insert sitting' as '';
insert into sitting (sittDate, sittAppetiser, sittMain, sittDesert, resName, spotsLeft) values
    ('2015-11-04', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 52),
    ('2015-11-11', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 42),
    ('2015-11-18', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 34),
    ('2015-11-25', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 34);

select 'Insert sittingforeman' as '';
insert into sittingforeman values
    (1, 1),
    (1, 2),
    (2, 1),
    (2, 2),
    (3, 1),
    (3, 3);

select 'Insert partytype' as '';
insert into partytype values
    ('Sluten'),
    ('Öppen');

select 'Insert user' as '';
insert into party (partyName, sittId, partyType, partyInterest, partyPrel, partyPayed, partyMessage, urlkey) values
    ('NILLE BDAY', 1, 'Öppen', 40, 10, 5, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'aoeu'),
    ('FRANZ BDAY', 1, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'qjkx'),
    ('MALIN BDAY', 2, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'pyfg'),
    ('NILLE BDAY', 2, 'Öppen', 40, 10, 5, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'oeui'),
    ('FRANZ BDAY', 3, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'euid'),
    ('MALIN BDAY', 3, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'uidh'),
    ('FRANZ BDAY', 4, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'idht'),
    ('MALIN BDAY', 4, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'dhtn');

select 'Insert partycreator' as '';
insert into partycreator values
    (1,1),
    (2,2),
    (3,3),
    (4,1),
    (5,2),
    (6,3),
    (7,1),
    (8,2);

select 'Insert paystatus' as '';
insert into paystatus (status, accesslevel) values
    ('Nej', 1),
    ('Insamlat', 1),
    ('Halvt', 5),
    ('Ja', 5);


select 'Insert partyguest' as '';
insert into partyguest (partyId, userId, userPayed) values
    (1,1,'Nej'),
    (2,1,'Nej'),
    (3,1,'Nej'),
    (4,1,'Nej'),
    (5,1,'Nej'),
    (6,1,'Nej'),
    (7,1,'Nej'),
    (8,1,'Nej'),
    (1,2,'Nej'),
    (2,2,'Nej'),
    (3,2,'Nej'),
    (4,2,'Nej'),
    (5,2,'Nej'),
    (6,2,'Nej'),
    (7,2,'Nej'),
    (8,2,'Nej'),
    (1,3,'Nej'),
    (2,3,'Nej'),
    (3,3,'Nej'),
    (4,3,'Nej'),
    (5,3,'Nej'),
    (6,3,'Nej'),
    (7,3,'Nej'),
    (8,3,'Nej');

select 'Insert event' as '';
insert into event values
    ('User created'),
    ('Sitting created'),
    ('Sitting deleted'),
    ('User Payed');

select 'Insert log' as '';
insert into log (userId, eventText, date) values
    (1, 'User created', CURDATE()),
    (2, 'User created', CURDATE()),
    (3, 'User created', CURDATE()),
    (1, 'Sitting created', CURDATE()),
    (2, 'Sitting created', CURDATE()),
    (3, 'Sitting created', CURDATE());

commit;


