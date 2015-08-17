-- Sets in testdata to the tables

start transaction;

insert into users values
    ('')
    ;


insert into usertype values
    ('')
    ;

insert into foodpref values
    ('')
    ;

insert into userFood values
    ('')
    ;

insert into restaurant values
    ('')
    ;

insert into sitting values
    ('')
    ;

insert into sittingforeman values
    ('')
    ;

insert into party values
    ('')
    ;

insert into partytype values
    ('')
    ;

insert into partyuser values
    ('')
    ;


insert into partyguest values
    ('')
    ;

insert into log values
    ('')
    ;

insert into event values
    ('')
    ;



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
    ('128', '1S



commit;


