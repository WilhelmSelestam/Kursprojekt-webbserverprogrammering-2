drop table if exists Discs;
drop table if exists Plastics;
drop table if exists Types;
drop table if exists Manufacturers;
drop table if exists Users;



create table Types
(
    TypeId              int auto_increment,
    DiscTypes           tinytext,
    DiscSlugTypes       tinytext,
    DiscTypeDescription mediumtext,
    primary key (TypeId)
);

create table Manufacturers
(
    ManufacturerId          int auto_increment,
    ManufacturerName        tinytext,
    ManufacturerSlugName    tinytext,
    ManufacturerCountry     tinytext,
    ManufacturerDescription mediumtext,
    primary key (ManufacturerId)
);

create table Plastics
(
    PlasticId          int auto_increment,
    PlasticName        tinytext,
    PlasticSlugName    tinytext,
    ManufacturerId     int,
    PlasticDescription text,
    primary key (PlasticId),
    foreign key (ManufacturerId) references Manufacturers (ManufacturerId)
);

create table Discs
(
    DiscId           int auto_increment,
    DiscName         tinytext not null,
    DiscDescription  text,
    Speed            float,
    Glide            float,
    Turn             float,
    Fade             float,
    TypeId           int,
    ManufacturerId   int,
    PlasticId        int,
    Price            int,
    BeginnerFriendly boolean,
    ImageLink        tinytext,
    Validated        boolean,
    primary key (DiscId),
    foreign key (TypeId) references Types (TypeId),
    foreign key (ManufacturerId) references Manufacturers (ManufacturerId),
    foreign key (PlasticId) references Plastics (PlasticId)
);

insert into types
values (1, 'Distance Driver', 'Distance-Driver',
        'The fastest discs around. If you want to throw far, these are the discs for you. With a low and wide rim, they cut to the air at high speeds. They generally have less glide than fairway drivers, and also a significant fade at the end of the flight.'),
       (2, 'Fairway Driver', 'Fairway-Driver',
        'A Fairway Driver is the perfect disc choice when you need both accuracy and distance. A slightly more narrow rim than on a Distance Driver gives you less speed and more control. The extra glide that a lot of our fairway drivers feature can give you almost as much distance as with a Distance Driver. If you are new to disc golf you will find it easier to throw a Fairway Driver.'),
       (3, 'Midrange', 'Midrange',
        'A Midrange disc gives you even more control than a Fairway Driver. With less speed and an even more predictable flight path it can gives you the confidence you need on the course. The Midrange section from Latitude 64° is versatile and can be used in a lot of situations. If you want to start playing disc golf, a straight flying Midrange is definitely the disc you should pick up.'),
       (4, 'Putt and Approach', 'Putt-and-Approach',
        '“Drive for the show and putt for the dough”, they say. It could not be more true. When you are within striking distance of the basket you need a putter you can trust and feel comfortable with. Every player has their own unique playing style and likes to grip the disc in different ways. Therefor our Putt & Approach discs are made in different molds and plastics. Putters flies slow in the air and will give you the most control. So find your favorite putter and hit the chains!');

insert into Manufacturers
values (1, 'Latitude 64', 'Latitude-64', 'Sweden',
        'We make disc golf products with first-class quality and design. Our factory in northern Sweden is one of the largest and most advanced in the industry, and our passion for the sport is always at the forefront of everything we do. We offer world class discs that suit all types of players, from experienced professionals to those who just discovered the sport. Quality matters.'),
       (2, 'Westside Discs', 'Westside-Discs', 'Finland',
        'The finish Westside Golf Discs is the third company ever to produce frisbee golf discs in Europe. Our production takes place in co-operation with Europes biggest, the Swedish Latitude, because of their five year experience in operating frisbee machines. The graphics of the discs come from Finnish National Epic Kalevala.'),
       (3, 'Innova Champion Discs', 'Innova-Champion-Discs', 'United States of America',
        'INNOVA was formed in 1983 to meet the developing equipment needs of disc golfers. In that year, Dave Dunipace created the World''s first disc designed specifically for the sport of Disc Golf. Innova now produces over 60 models of Disc Golf discs and absolutely everything else you need to play Disc Golf.'),
       (4, 'Discraft', 'United States of America', 'Discraft',
        'We were captivated by the flying disc craze of the 1970''s. To interact with a spinning disc and watch it fly is truly a beautiful thing. Our frustration at the time was over the quality of the discs that were available; flight patterns were inconsistent, distance potential was low, and the quality in general was poor. Those discs were manufactured to be toys, and we wanted high performance sports equipment to keep up with the increasing skills of the players. In 1978 we launched Discraft to serve disc sports athletes. Persistent innovation, research, and development met with the highest quality standards and creative graphics has maintained Discraft as a strong leader across 2 major disc sports around the world. Discraft is a manufacture of Disc Golf, Ultimate and Freestyle discs, which are produced to the highest quality.');

insert into Plastics
values (1, 'Opto Line', 'Opto-Line', 1,
        'Opto Line is made out of some of the world’s most durable plastics. It comes in a variety of beautiful translucent colors. The Opto Line plastic has been developed to withstand severe punishment and extreme conditions better than other plastics.'),
       (2, 'Gold Line', 'Gold-Line', 1,
        'Gold Line is our premium blend plastic. The start of the mix has been the same brand plastics used in Opto Line but we added a different polymer to give it better grip without losing the excellent durability of Opto Line.'),
       (3, 'VIP Line', 'VIP-Line', 2,
        'VIP plastic is our most durable plastic. It comes in a nice see through and opaque appearance. It has a tacky grip nice glossy finish. Designed with super resistant polymers to withstand great force, still hold its shape, and maintain original flight characteristics. No matter what you hit VIP will show great resilience and fly the same the next time you throw it.'),
       (4, 'Tournament Line', 'Tournament-Line', 2,
        'Our Tournament plastic is just what it sounds like. Designed with the experienced tournament player in mind, TP has a tackier grip, and is faster out if the hand. It has a softer feel, thus breaking in easier than VIP. Not all shots are hyzers and sometimes you will have to shape shots. TP plastic will give you the flights you need in those tournament situations.'),
       (5, 'Champion Line', 'Champion-Line', 3,
        'Our Champion line is produced with a hi-tech plastic that provides outstanding performance and durability. Champion discs are distinguished by a beautiful clear appearance. Designed for professional players, Champion line discs are usually a little firmer and more stable than the same model in other plastics. Whether used in heavily wooded situations, or on extremely rugged courses, our Champion line plastic will continue to perform predictably and avoid damage better than any other plastic. Most Champion line discs are available for custom hot stamping.'),
       (6, 'DX Line', 'DX-Line', 3,
        'Our DX line offers the widest selection of models and weights. These discs are affordably priced and provide an excellent grip in a variety of weather situations. DX discs wear in with usage and over time will eventually take on new and varied flight characteristics. Many top pros carry several DX discs of their favorite models to provide different flight patterns for different situations. Some DX discs are available in glow-in-the-dark. Most models are available for custom hot stamping.'),
       (7, 'Z Line', 'Z-Line', 4,
        'Highest durability. - Vibrant translucent colors. - Choice of pros under normal condition - Slow seasoning.'),
       (8, 'ESP Line', 'ESP-Line', 4,
        'Highest durability. - Vibrant translucent colors. - Choice of pros under normal condition - Slow seasoning.');

insert into Discs
values (1, 'Halo',
        'Halo is a high speed long range driver with excellent speed and distance. A perfect fit in many players bags, from pros to amateurs. At a 330ft toss it will be stable and consistent.',
        13, 5, -0.5, 3, 1, 1, 1, 179, false, '/Images/Halo.png', true),
       (2, 'Diamond',
        'Diamond is the choice of disc for beginners, children and players with moderate arm speed. It is only produced in weights between 145g-159g, which makes it easy to throw and control. It has an understable flight path with good glide and slight fade.',
        8, 6, -3, 1, 2, 1, 2, 189, true, '/Images/Diamond.png', true),
       (3, 'King',
        'Westside King is a fast stable driver good for ultimate distance without sacrificing control. It has a solid reliable flight without being too overstable. Westside King has a relatively high and predictable fade. Higher weights are more stable than lower weights. The King is an easy way to get extra meters to your play.',
        14, 5, -1.5, 3, 1, 2, 3, 179, false, '/Images/King.png', true),
       (4, 'Harp',
        'The Harp is our most reliable approach disc. Designed to withstand and type of conditions. It will hold in the wind. In our BT Soft plastic the Harp is very flexible and feels great in your hand. Use the soft in cold weather and it will still have that soft feel. Use the BT stiff in the summer and it will still hold its shape.',
        4, 3, 0, 3, 4, 2, 4, 199, false, '/Images/Harp.png', true),
       (5, 'Mako3',
        'Mako3 has a smooth straight flight path with minimal fade in the end, when thrown with low to moderate amount of power. When thrown with high power, the Mako3 will gradually turn, making it optimal disc for long turning anhyzer shots even on a narrow line.',
        5, 5, 0, 0, 3, 3, 5, 169, true, '/Images/Mako3.png', true),
       (6, 'Leopard',
        'The Leopard should be everyone''s first fairway driver as it is has excellent glide and is easy to throw straight and far. The Leopard is a great turnover disc for players of all skill levels. More experienced players can use the Leopard for throwing distance stretching "Hyzer Flip" shots. The Leopard makes a dependable long range roller.',
        6, 5, -2, 1, 2, 3, 6, 119, true, '/Images/Leopard.png', true),
       (7, 'Buzzz',
        'Buzzz is the best golf disc you can buy, period. It''s an ultra-dependable, straight flying midrange that you''ll reach for again and again. Throw it hard and versatile Buzzz will hold any line you put it on. Discraft''s 30-year reputation for consistency means that if you lose it, just pull out a new one and you''re back in business.',
        5, 4, -1, 1, 3, 4, 7, 169, true, '/Images/Buzzz.png', true),
       (8, 'Undertaker',
        'Most players have one versatile driver they reach for most often, and Undertaker is the new choice. This straight flier fills many needs for many different skill levels: it doesn''t get flippy for power throwers, isn''t hard to control for low-power players. Great glide, smooth finish, nice grip, big wins.',
        9, 5, -1, 2, 1, 4, 8, 189, false, '/Images/Undertaker.png', true);

create table Users
(
    UserId    int auto_increment,
    Username  tinytext,
    Password  tinytext,
    Admin     boolean,
    ColorMode tinyint,
    primary key (UserId)
);

insert into Users(UserId, Username, Password, Admin, ColorMode)
values (1, 'Wilhelm', '1234', true, 1),
       (2, 'Axel', 'korv', true, 2);