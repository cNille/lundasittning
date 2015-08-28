-- Sets in testdata to the tables
start transaction;

insert into restaurant(resName, resPrice, resSize, resSummary) values
    ('Nilles nation', 140, 90, 'EN UPPLEVELSE!'),
    ('Franz nation', 240, 120, 'EN UPPLEVELSE!'),
    ('Malins nation', 40, 50, 'EN UPPLEVELSE!'),
    ('Jennifers nation', 40, 50, 'EN UPPLEVELSE!');

insert into usertype values
	('SuperAdmin'),
    ('Quratel'),
    ('Sittningsförman'),
    ('Förman');

insert into users(userName, facebookId, userEmail, userTelephone) values
    ('Nille', '1', 'c@shapeapp.se', '0708342311'),
    ('Franz', '2', 'franzmail123@gmail.com', '0708123456'),
    ('Malin', '3', 'cnilsson_92@hotmail.com', '0708123456'),
    ('Franz Lang', '10204701878293819', 'cnilsson_92@hotmail.com', '0708123456'),
    ('Christopher Nilsson', '10153551242685859', 'cnilsson_92@hotmail.com', '0708123456');

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

insert into foodpref values
    ('Laktos'),
    ('Gluten'),
    ('Vegatarian'),
    ('Vegan'),
    ('Nötter');

insert into userfood values
    (1, 'Laktos'),
    (2, 'Nötter');

insert into sitting (sittDate, sittAppetiser, sittMain, sittDesert, resName, spotsLeft) values
    ('2015-09-04', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 52),
    ('2015-09-11', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 42),
    ('2015-09-18', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 34),
    ('2015-09-25', 'Pannkakor', 'Pizza', 'Glass', 'Nilles nation', 34);

insert into sittingforeman values
    (1, 1),
    (1, 2),
    (2, 1),
    (2, 2),
    (3, 1),
    (3, 3);

insert into partytype values
    ('Sluten'),
    ('Öppen');

insert into party (partyName, sittId, partyType, partyInterest, partyPrel, partyPayed, partyMessage) values
    ('NILLE BDAY', 1, 'Öppen', 40, 10, 5, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('FRANZ BDAY', 1, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('MALIN BDAY', 2, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('NILLE BDAY', 2, 'Öppen', 40, 10, 5, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('FRANZ BDAY', 3, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('MALIN BDAY', 3, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('FRANZ BDAY', 4, 'Sluten', 40, 3, 20, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. "),
    ('MALIN BDAY', 4, 'Öppen', 40, 23, 10, "Cupcake ipsum dolor sit amet halvah brownie candy. Tart chocolate bar chocolate cake lollipop tootsie roll liquorice. Candy canes toffee wafer tiramisu chocolate cake chupa chups. Marzipan bonbon marshmallow gingerbread danish cake powder cupcake. Pastry bear claw jelly-o marshmallow ice cream. Marzipan toffee dragée caramels chupa chups biscuit cotton candy croissant sesame snaps. Ice cream halvah sugar plum cheesecake bonbon donut. Bear claw carrot cake lemon drops pastry muffin chocolate. Gummies cake cotton candy sweet roll muffin candy muffin lemon drops. Candy tiramisu tootsie roll lemon drops icing brownie. Liquorice sesame snaps soufflé croissant pudding. Tootsie roll chocolate cotton candy icing carrot cake muffin ice cream oat cake. Candy canes jelly beans sweet chocolate apple pie sweet roll brownie. Apple pie ice cream jelly-o brownie chocolate bar liquorice pie. Cookie toffee candy sweet roll chupa chups jujubes marshmallow. Dessert caramels icing cake tootsie roll. Fruitcake sesame snaps dessert pie sweet oat cake. ");

insert into partycreator values
    (1,1),
    (2,2),
    (3,3),
    (4,1),
    (5,2),
    (6,3),
    (7,1),
    (8,2);

insert into partyguest (partyId, userId, userPayed) values
    (1,1,0),
    (2,1,1),
    (3,1,0),
    (4,1,0),
    (5,1,1),
    (6,1,0),
    (7,1,0),
    (8,1,1),
    (1,2,0),
    (2,2,1),
    (3,2,0),
    (4,2,0),
    (5,2,1),
    (6,2,0),
    (7,2,0),
    (8,2,1),
    (1,3,0),
    (2,3,1),
    (3,3,0),
    (4,3,0),
    (5,3,1),
    (6,3,0),
    (7,3,0),
    (8,3,1);

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
    (3, 'Sitting created', CURDATE());

commit;


