-- Sets in testdata to the tables

start transaction;

insert into usertype values
    ('Quratel'),
    ('Sittningsförman'),
    ('Förman'),
    ('Vanlig');

insert into users(userName, userEmail, userTelephone, userType) values
    ('Nille', 'c@shapeapp.se', '0708342311', 'Quratel'),
    ('Franz', 'franzmail123@gmail.com', '0708123456', 'Sittningsförman'),
    ('Malin', 'cnilsson_92@hotmail.com', '0708123456', 'Förman');

insert into foodpref values
    ('Laktos'),
    ('Gluten'),
    ('Vegatarian'),
    ('Vegan'),
    ('Nötter');

insert into userfood values
    (1, 'Laktos'),
    (2, 'Nötter');

insert into restaurant(resName, resPrice, resSize, resSummary) values
    ('Nilles nation', 140, 90, 'EN UPPLEVELSE!');

insert into sitting (sittDate, sittAppetiser, sittMain, sittDesert) values
    ('2015-09-04', 'Pannkakor', 'Pizza', 'Glass'),
    ('2015-09-11', 'Pannkakor', 'Pizza', 'Glass'),
    ('2015-09-18', 'Pannkakor', 'Pizza', 'Glass'),
    ('2015-09-25', 'Pannkakor', 'Pizza', 'Glass');

insert into sittingforeman values
    ('2015-09-04', 1),
    ('2015-09-11', 2),
    ('2015-09-18', 3);

insert into partytype values
    ('Sluten'),
    ('Öppen');

insert into party (partyName, sittingDate, partyType, partyInterest) values
    ('NILLE BDAY', '2015-09-04', 'Öppen', 40),
    ('FRANZ BDAY', '2015-09-04', 'Sluten', 40),
    ('MALIN BDAY', '2015-09-11', 'Öppen', 40);


insert into partycreator values
    (1,1),
    (2,2),
    (3,3);


insert into partyguest (partyId, userId, userPayed) values
    (1,1,0),
    (2,1,1),
    (3,1,0),
    (1,2,0),
    (2,2,1),
    (3,2,0),
    (1,3,0),
    (2,3,1),
    (3,3,0);

insert into event values
    ('User created'),
    ('Sitting created'),
    ('Sitting deleted'),
    ('User Payed');

insert into log (userId, eventText, date) values
    (1, 'User created', CURDATE()),
    (2, 'User created', CURDATE()),
    (3, 'User created', CURDATE()),
    (1, 'Sitting created', CURDATE()),
    (2, 'Sitting created', CURDATE()),
    (3, 'Sitting created', CURDATE())
    ;


commit;


