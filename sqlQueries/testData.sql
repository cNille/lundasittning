-- Sets in testdata to the tables
start transaction;

select 'Insert restaurant' as '';
insert into restaurant(name, price, size, summary, nickname, email, telephone, homepage, hours, address) values
    ('Nilles nation', 140, 90, 'EN UPPLEVELSE!', 'NN','c@shapeapp.se','0708342311','www.shapeapp.se','Mån - Fre 11:00-13:00', 'Tornavägen 7'),
    ('Franz nation', 240, 120, 'EN UPPLEVELSE!', 'NN','c@shapeapp.se','0708342311','www.shapeapp.se','Mån - Fre 11:00-13:00', 'Tornavägen 7'),
    ('Malins nation', 40, 50, 'EN UPPLEVELSE!', 'NN','c@shapeapp.se','0708342311','www.shapeapp.se','Mån - Fre 11:00-13:00', 'Tornavägen 7'),
    ('Jennifers nation', 40, 50, 'EN UPPLEVELSE!', 'NN','c@shapeapp.se','0708342311','www.shapeapp.se','Mån - Fre 11:00-13:00', 'Tornavägen 7');


select 'Insert usertype' as '';
insert into usertype values
	('SuperAdmin', 10),
    ('Quratel', 5),
    ('Sittningsförman', 2),
    ('Förman', 1),
    ('Användare', 0);

select 'Insert loginaccount' as '';
insert into loginaccount (fbid, email, telephone) values
    ('3', 'cnilsson_92@hotmail.com', '0708123456'),
    ('10204701878293819', 'franz@hotmail.com', '0708123456'),
    ('10153551242685859', 'cnilsson_92@hotmail.com', '0708123456');

select 'Insert participant' as '';
insert into participant(name, other, loginaccount) values
    ('Nille', 'Annat', 3),
    ('Franz', 'Annat', 2),
    ('Malin', 'Annat', 1);

select 'Insert restaurantparticipant' as '';
insert into restaurantparticipant values
    (1, 'Nilles nation', 'SuperAdmin'),
    (1, 'Franz nation', 'Quratel'),
    (1, 'Malins nation', 'Sittningsförman'),
    (2, 'Nilles nation', 'SuperAdmin'),
    (2, 'Franz nation', 'Quratel'),
    (2, 'Malins nation', 'Sittningsförman'),
    (3, 'Malins nation', 'Quratel');

select 'Insert foodpref' as '';
insert into foodpref values
    ('Laktos'),
    ('Gluten'),
    ('Vegatarian'),
    ('Vegan'),
    ('Nötter');

select 'Insert participantfood' as '';
insert into participantfood values
    (1, 'Laktos'),
    (2, 'Nötter');

select 'Insert sitting' as '';
insert into sitting (sittDate, appetiser, main, desert, resName) values
    ('2015-11-04', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation'),
    ('2015-11-11', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation'),
    ('2015-11-18', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation'),
    ('2015-11-25', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation');

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

select 'Insert party' as '';
insert into party (name, sittId, partyType, interest, message, urlkey) values
    ('NILLE BDAY', 1, 'Öppen', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'aoeu'),
    ('FRANZ BDAY', 1, 'Sluten', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'qjkx'),
    ('MALIN BDAY', 2, 'Öppen', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'pyfg'),
    ('NILLE BDAY', 2, 'Öppen', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'oeui'),
    ('FRANZ BDAY', 3, 'Sluten', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'euid'),
    ('MALIN BDAY', 3, 'Öppen', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'uidh'),
    ('FRANZ BDAY', 4, 'Sluten', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'idht'),
    ('MALIN BDAY', 4, 'Öppen', 40, "Cupcake ipsum dolor sit amet halvah brownie candy.", 'dhtn');

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


select 'Insert partyparticipant' as '';
insert into partyparticipant (partyId, participantId, participantPayed) values
    (1,1,'Nej'),
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


select 'Insert log' as '';
insert into log (participantId, eventText, logDate) values
    (1, 'User created', CURDATE()),
    (2, 'User created', CURDATE()),
    (3, 'User created', CURDATE()),
    (1, 'Sitting created', CURDATE()),
    (2, 'Sitting created', CURDATE()),
    (3, 'Sitting created', CURDATE());

commit;


