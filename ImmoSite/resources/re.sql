-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 14 aug 2013 om 11:53
-- Serverversie: 5.6.12-log
-- PHP-versie: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `re`
--
CREATE DATABASE IF NOT EXISTS `re` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `re`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Company_name` varchar(45) DEFAULT NULL,
  `Contact_name` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `Description` text,
  `Website` varchar(45) DEFAULT NULL,
  `Telephone` varchar(45) DEFAULT NULL,
  `Address_street` varchar(45) DEFAULT NULL,
  `Address_city` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `agents`
--

INSERT INTO `agents` (`id`, `Company_name`, `Contact_name`, `Email`, `Password`, `Description`, `Website`, `Telephone`, `Address_street`, `Address_city`) VALUES
(1, 'Sellicious', 'Jean-Paul', 'info@sellicious.be', '960530d5743b7838d9a54c8a985564a9f449e117', 'The name is synonymous with the sale, purchase and rental of high quality residential property. We are the complete agency and professional consultancy - responding to the needs of residential property owners, buyers, tenants and developers in Belgium.', 'sellicious.be', '03/722.22.22', 'Arenbergstraat 13', '1000 Brussel'),
(2, 'Rentalicious', 'Marie', 'info@rentalicious.be', '778b4cb74a2c8bc3875c1be7b070f8318c44d90a', '<p>We recognise how difficult and demanding moving home can be and as such our aim is to provide you with a service that ensures the process is kept as simple and efficient as possible whilst offering flexibility to meet your needs.</p>', 'rentalicious.be', '03/72.22.27', 'Spoormakersstraat 6', '1000 Brussel');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Agents_id` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Available` tinyint(1) DEFAULT NULL,
  `State` enum('Buy','Rent') DEFAULT NULL,
  `Type` enum('House','Apartment','Bungalows','Land','Commercial') DEFAULT NULL,
  `Province` enum('West-Vlaanderen','Oost-Vlaanderen','Antwerpen','Limburg','Vlaams-Brabant','Waals-Brabant','Brussel','Henegouwen','Namen','Luik','Luxemburg') DEFAULT NULL,
  `Location_street` varchar(45) DEFAULT NULL,
  `Location_City` varchar(45) DEFAULT NULL,
  `Date_posted` date DEFAULT NULL,
  `Date_available` date NOT NULL,
  `Description` text,
  `Price` int(11) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Bedrooms` int(11) DEFAULT NULL,
  `Buildyear` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`Agents_id`),
  KEY `fk_Properties_Agents` (`Agents_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Gegevens worden uitgevoerd voor tabel `properties`
--

INSERT INTO `properties` (`id`, `Agents_id`, `Name`, `Available`, `State`, `Type`, `Province`, `Location_street`, `Location_City`, `Date_posted`, `Date_available`, `Description`, `Price`, `Size`, `Bedrooms`, `Buildyear`) VALUES
(1, 2, '4 bedroom terraced house to rent', 1, 'Rent', 'House', 'Brussel', 'Zespenningenstraat 39', '1000 Brussel', '2013-08-20', '2013-08-22', 'Situated within a desirable location this stunning four bedroomed house offers contemporary accommodation in fantastic condition throughout. The property boasts stunning double reception room with period features, large eat in kitchen with quality fixtures, spacious master bedroom with plenty of storage, three further good size bedrooms, family bathroom and private paved garden. Cornwall Grove is close to the many shops and restaurants on Chiswick High Road and Turnham Green Terrace, Chiswick House and Grounds and the River Thames are within reach and the A4/M4 allows quick and easy routes into London.', 800, 150, 4, 2009),
(2, 2, '6 bedroom flat to rent', 1, 'Rent', 'Apartment', 'Oost-Vlaanderen', 'Dampoortstraat 59', '9000 Gent', '2013-08-21', '2013-08-23', 'The most stunning Penthouse apartment boasting 6 bedrooms and 5 reception rooms in one of the most highly sought after and desirable locations in London. This 10,000 Sq Ft Penthouse apartment has a 150 ft frontage directly overlooking Hyde Park. The Penthouse apartment boasts 5 stunning reception rooms, 2 kitchens, 6 bedrooms including a master bedroom suite with his/her bathrooms and dressing rooms, a fully equipped gymnasium, spa treatment room, six stunning terraces and gardens with amazing 360 degree views over The City, the West End, and the Houses of Parliament. Parking and separate staff accommodations are also available subject to negotiation. There is also a lift that opens directly into a private lobby with stainless steal double tramlines giving a Deco detail to the black Zimbabwe marble floor.', 650, 160, 6, 2006),
(3, 2, '5 bedroom penthouse to rent', 1, 'Rent', 'Apartment', 'West-Vlaanderen', 'Wellingtonstraat 70', '8400 Oostende', '2013-08-19', '2013-08-30', 'This Apartment offers the luxury, discretion and security of a five star hotel whilst combining comfort and a personalised service. This building is arranged over several floors and is available to suit all needs; whether a short let or long term. A selection of one bedroom apartments to five bedroom is available to suit many tastes and needs. The views are spectacular, reaching across the London skyline from its prime position on Park Lane, overlooking Hyde Park. Each property has been interior designed to the highest specification, there is use of a lift as well as use of the hotel facilities. \r\n\r\nThe 4823 sq. ft. five bedroom penthouse apartment comprises of five large double bedrooms, four marble en-suite bathrooms, fully-fitted Poggenpohl kitchen, cinema room, dining room, and four generously sized reception rooms. As this is a penthouse apartment, there are breath-taking views from the balcony as well as televisions, full size amenities and use of a concierge service, butler and maid, gym, and an Aston Martin Car. ', 1300, 550, 5, 2011),
(4, 2, '7 bedroom house to rent', 0, 'Rent', 'House', 'Luxemburg', '4 Faubourg', '4120 Esch-sur-Alzette', '2013-08-24', '2013-08-31', 'SHORT LET. A unique, truly imposing seven bedroomed gated house offering lavish interiors, extensive living space and a beautiful garden with inviting heated swimming pool.\r\n\r\nLocated behind electric gates in the heart of Hampstead moments the High Street and green expanses of the Heath.\r\n\r\n\r\nA very impressive seven bedroomed gated house\r\nLocated in the heart of desirable Hampstead\r\nFrench silk wall coverings, blinds and curtains\r\nHand selected period fireplaces\r\nWell presented garden and outdoor heated swimming pool\r\nCustom built kitchen, gym, steam room, heated garage\r\nVenetian stone walls and stone staircase\r\nMulti-line telephone system with 26 handsets', 950, 1050, 7, 1993),
(5, 2, '7 bedroom house to rent', 1, 'Rent', 'House', 'Limburg', 'Kattegatstraat 1', '3500 Hasselt', '2013-08-14', '2013-08-21', '<p>We are pleased to present this stunning, well presented and well proportioned seven bedroom house located in the heart of Chelsea benefiting from a lift, swimming pool, garden and roof terrace. The property, which is available furnished or unfurnished, consists of a bright formal double reception room, fully fitted kitchen/breakfast room with all modern appliances and granite work surfaces, further reception/family room leading to a wonderful conservatory and garden, television room, guest bedroom, bathroom and kitchen on the lower ground floor with stairs leading to a stunning swimming pool, master bedroom suite with adjoining bathroom and dressing room, three more double bedrooms each with their own bathroom on the upper floors, roof terrace and finally a large study. Stand out features would be a large family kitchen, conservatory dining room, basement swimming pool and roof terrace with superb views. Ideally located for walks along the river, shopping on King''s Road and access to central London from Sloane Square. This exceptional property is available for either a short or long term rental.</p>', 1300, 600, 7, 2001),
(6, 2, '7 bedroom apartment to rent', 1, 'Rent', 'Apartment', 'Waals-Brabant', 'Avenue des Combattants 2', '1340 Ottignies-Louvain-la-Neuve', '2013-08-24', '2013-08-24', 'This incredible seven bedroom house over nearly 7000 sq ft is situated in a quiet, prestigious Chelsea location. Features include a 15m private garden, indoor swimming pool and roof terrace with views over the River Thames. The accommodation is comprised of three reception rooms, large kitchen/breakfast room, seven bedrooms (including a self-contained nanny flat), four bathrooms, two shower rooms, a large study and conservatory. \r\n\r\nCheyne Place is located moments from the river and is close to the famous King''s Road. The closest Underground Station is Sloane Square (Circle, District & Piccadilly Lines).', 1900, 950, 7, 1995),
(7, 2, 'Retail Property to rent', 1, 'Rent', 'Commercial', 'Oost-Vlaanderen', 'Stationsstraat 40', '9100 Sint-Niklaas', '2013-08-14', '2013-08-19', '<p>CITY FRINGE NEW BUILD RETAIL/SHOWROOM OPPORTUNITY RENT Ground floor: &nbsp;DESCRIPTION Modern development comprising a mixture of residential, office and retail. The retail element is available to rent in shell and core. Nearby retailers include Paddy Power, Lloyds TSB, Tesco, Jennings, Iceland &amp; McDonalds (My Idea Store &amp; Watney Street Market are directly opposite). In addition, the Holiday Inn Hotel is located almost next door and is due to open in the summer of 2012. LOCATION Located in the heart of Commercial Road (A13), close to Cavell Street. A mixture of office, residential and retail developments are now being completed in this location. Historically the centre of, Whitechapel is developing into a more mixed occupier sector. TRANSPORT Commercial Road (A13) is well served with numerous bus routes and Whitechapel Underground Station.</p>', 2500, 300, 0, 2002),
(8, 2, 'Commercial Property to rent', 1, 'Rent', 'Commercial', 'Antwerpen', 'Blindestraat 6', '2000 Antwerpen', '2013-08-20', '2013-08-21', 'Ground Floor Shop	\r\nTotal net internal area 62.98 sq m (678 sq ft). Let to Wimbledon Fine Art on a 5 year internal repairing lease from 25/03/2002 (holding over) at a rental of £21,996. \r\n\r\nGround Floor Rear Office \r\nTotal net internal area 48.96 sq m (527 sq ft). Vacant (ERV £15,000 per annum) \r\n\r\nFirst Floor Front Office \r\nTotal net internal area 41.34 sq m (445 sq ft). Let to Mr T Broom T/A Broom Palmer Solicitors on a 3 year internal repairing lease from 01/03/2006 (holding over)	 at a rental of £11,000. \r\n\r\nFirst Floor Rear Office \r\nTotal net internal area 30 sq m (324 sq ft). Let to Restore on a 3 year internal repairing lease from February 2009 (holding over) at a rental of £7,250. \r\n\r\nTotal rent reserved £40,426 pa with vacant possession of 1 office suite. \r\n\r\nIt is considered that the property may be sutiable for conversion to residential, subject to he necessary consents. Itnerested parties must rely on tehir own enquiries to the Lolndon Borough of Merton Planning Department - Tel: 020 8543 6085. ', 3250, 450, 0, 1985),
(12, 2, 'Industrial Park to rent', 1, 'Rent', 'Commercial', 'Antwerpen', 'Kaliebaan 30', '2460 Kasterlee', '2013-08-15', '2013-08-19', 'The units comprise detached, modern warehouse buildings with a steel portal frame and full height block work elevations. The facades are clad with profile steel sheeting. The units have been fully fitted for use as a commercial garage/service centre. There is plenty of private parking within the demise.', 3000, 5600, 0, 1996),
(13, 2, '3 bedroom flat to rent', 1, 'Rent', 'Apartment', 'Oost-Vlaanderen', 'Durmelaan 5', '9160 Lokeren', '2013-08-14', '2013-08-20', '<p>The Presidential Suite - a 3 bedroom apartment is set within an opulent boutique hotel located in a quiet tree-lined square and covers 2 floors, benefiting from its own private entrance. The hotel''s classical Victorian faade hides a wealth of rich colours and modern facilities. Lush brocade upholstery and curtains compliment Murano glass chandeliers, creating a theatrical and glamorous ''stately home'' in the heart of London. It has access to all of the Hotel facilities including consierge, restaurant, gym, room service, library, bar and maid service. Its located within 5 mintues of either the bars and restaurants of Sloane Square and Knigtsbridge`s exlusive shopping district. Administration &amp; referencing charges apply</p>', 2150, 200, 3, 1991),
(14, 2, 'Office to rent', 1, 'Rent', 'Commercial', 'Brussel', 'Dam 30', '1000 Brussel', '2013-08-16', '2013-08-31', 'The property is located in the heart of thriving Clerkenwell, on the corner of Central Street and Seward Street. Clerkenwell is a popular area, home to a number of high profile creative occupiers, prominent showrooms and high quality residential apartments as well as the numerous quality bars and restaurants of Clerkenwell. Old Street Station and Barbican Station are both within a short walking distance, and with numerous bus routes also operating within the immediate vicinity result in excellent transport links throughout London.', 2500, 600, 0, 1998),
(15, 2, '6 bedroom penthouse to rent', 1, 'Rent', 'Apartment', 'Antwerpen', 'Hoge Kaart 195', '2930 Brasschaat', '2013-08-17', '2013-09-27', 'The most spectacular Penthouse apartment in one of the most glamorous locations in the world. The penthouse at 116 Knightsbridge is the only Penthouse currently in existence directly in Hyde Park, Knightsbridge. The 10,000sq.ft., lateral Penthouse apartment has a 150ft. frontage directly into the park overlooking The Serpentine on South Carriage drive, adjacent to the Royal Horse Guards Cavalry. The accommodation boasts five Reception and Entertaining Rooms, two Kitchens, six Bedroom Suites including a Master Bedroom Suite with His and Her Bathrooms and Dressing Rooms - fully equipped Gymnasium, Spa Treatment Room, six Terraces and Roof Gardens. Parking and Separate Staff Accommodation are also available subject to negotiations. In addition, the magnificent 360 degree views take in the Park, the London skyline, The City the West End and Palace of Westminster. Located on the Knightsbridge side of Hyde Park, this elegant Victorian apartment block is uniquely placed on the edge of Hyde Park and a moment`s walk to the world class amenities that Knightsbridge has to offer', 950, 150, 6, 1992),
(16, 2, '4 bedroom flat to rent', 1, 'Rent', 'Apartment', 'Namen', 'Rue Lelievre 22', '5000 Namen', '2013-08-14', '2013-10-31', '<p>Location Grosvenor House Apartments are ideally placed for easy access to locations throughout central London, including London''s main transport hubs. The boutiques, delicatessens, restaurants and galleries of Mount Street are just a short stroll away. Description Originally built in the 1920s and designed by Sir Edward Lutyens, the Grosvenor House Apartments by Jumeirah Living have recently undergone a complete internal rebuild and refurbishment. Highly stylised and contemporary in design, the property''s 133 residences range from studios through to five-bedroom penthouses. All the residences offer exceptional quality, service and attention to detail, coupled with state-of-the-art technology. The interior design combines classic finishes such as dark oak timber flooring with more contemporary detailing, for example tailored wall panelling and oversized bathrooms. Additional features at Grosvenor House Apartments include a spectacular first-floor atrium with a seven-storey vaulted ceiling and a grand over-sized fireplace, hosting all day dining for residents. 24 hour room service is also available, along with a dedicated 24 hour concierge service, valet parking and a host of additional services. Grosvenor House Apartments are situated in Mayfair on the world-renowned Park Lane, with views across Hyde Park, one of the central London''s largest open spaces. This is a location synonymous the world over with luxury, prestige and quality. It affords some of the world''s greatest retail facilities, enjoys some of the finest restaurants in London and is in close proximity to a host of Royal Parks and Gardens. It is, quite simply, an aspirational location offering the ultimate in status. Health Club and Spa at Jumeirah Carlton Tower Accommodation comprises reception room with dining area, open-plan kitchen, four bedroom suites.</p>', 1900, 300, 4, 2001),
(17, 2, 'Light Industrial to rent', 1, 'Rent', 'Commercial', 'West-Vlaanderen', 'Tarwestraat 100', '8400 Oostende', '2013-08-14', '2014-01-31', '<p>Flexible lease terms</p>\r\n<p>Professional management team</p>\r\n<p>24 hour access</p>\r\n<p>CCTV Staffed reception</p>\r\n<p>On-site parking</p>\r\n<p>3 phase power</p>\r\n<p>Roller shutter doors</p>\r\n<p>Good loading access</p>', 2000, 300, 0, 1996),
(18, 1, '5 bedroom flat for sale', 1, 'Buy', 'Apartment', 'Oost-Vlaanderen', 'Dampoortstraat 59', '9000 Gent', '2013-08-15', '2013-08-31', 'This apartment at the iconic ONE HYDE PARK is the only complete floor for sale that is ready to live in immediately. This exceptional apartment occupying the entire floor, boasts magnificent views of both Knightsbridge and Hyde Park.\r\nThe interior design of the apartment responds both to its unique size of over 9,000 sq ft as well as its extraordinary location. The apartment is divided into two wings; the 5 bedrooms can be found in the city wing whilst all the living and entertaining spaces are in the park wing. The impressive 65metre hallway which stretches from the park side to the city side connects both wings, forming the spine of the apartment.\r\nThe Candy & Candy interior design team has taken inspiration from the two diverse perspectives of London, which uniquely combine in this apartment, to provide a truly modern interpretation of sophisticated and luxurious city living. ', 80000000, 845, 5, 2002),
(19, 1, '9 bedroom house for sale', 1, 'Buy', 'House', 'Antwerpen', 'Blindestraat 6', '2000 Antwerpen', '2013-08-16', '2013-09-30', 'A rare opportunity to restore this Grade II Listed detached house and extend it to approx 30,000 sqft. Full planning permission has been granted for the works to include a separate cottage, tennis court and garden pavilion. EPC: F\r\n\r\nThe photographs displayed are computer generated images which project what the property could look like. At the moment it is unmodernised but offers tremendous scope to restore one of the best houses in Kensington. The present owners have already assembled the full professional development team including budget and time frames. The new owner may engage the same team or use his own. \r\n\r\nLocated between Kensington Palace and Holland Park, the mansion enjoys an outlook over it''s private walled garden of around one acre. The planning permission allows for approximately 30,000 sq ft of built up area including a main house with 7 guest bedroom suites and 2 staff bedroom suites; a separate staff cottage with three bedrooms; a tennis court; a garden pavilion and enclosed garage in the garden. In the proposed plans the entertainment areas include several living rooms as well as a spa, 25m swimming pool, bar/night club, gym, sauna, steam room, cinema, squash court, wine cellar and tasting room.', 95000000, 950, 9, 1996),
(20, 1, '6 bedroom flat for sale', 1, 'Buy', 'Apartment', 'Antwerpen', 'Blindestraat 6', '2000 Antwerpen', '2013-08-17', '2013-08-31', 'With the very best roof terraces in London, this magnificent six bedroom duplex penthouse apartment is located directly above The Wolseley restaurant and adjacent to the world famous Ritz Hotel.\r\n\r\nWith interior design by Candy & Candy, the apartment is on the fifth and sixth floors with two roof terraces and unprecedented 360 degree views across London.\r\n\r\nAccommodation: Entrance hall, upper atrium & corridor, formal reception (including games area, library, informal seating area and bar), formal dining, kitchen, chef’s kitchen, media room, study, powder room, master bedroom, master dressing room and master ensuite bathroom, 4 guest bedrooms all with ensuite bathrooms, gymnasium and spa, two roof terraces with stunning 360 degree views over London, internal lift and separate staff accommodation with utility room.\r\nLocated within an iconic London landmark in St James’s. The\r\nWolseley café restaurant occupies the ground floor of the\r\nbuilding, on the corner of Piccadilly and Arlington Street, adjacent\r\nto the world renowned Ritz Hotel.', 85000000, 730, 6, 1985),
(21, 1, 'Retail Property for sale', 1, 'Buy', 'Commercial', 'Brussel', 'Dam 30', '1000 Brussel', '2013-08-15', '2013-11-30', 'Beaufort Park: \r\n\r\nBeaufort Park is North West London''s most exciting new mixed-use development. At Beaufort Park you can work hard and play hard, you can meet clients in one of the many cafes or restaurants while your office team are on hand to offer that necessary back-up. \r\n\r\nBeaufort Park has benefitted from a £7million transport infrastructure redevelopment programme to Aerodrome Road, providing replacement rail bridges, improvement to bus services, pedestrian and cycle access. In addition to those employed in this area, over 350,000 residents currently live within 3 miles of Beaufort Park and on a daily basis, more than 50,000 vehicles flow along the A41. \r\n\r\nTransport: \r\n\r\nBeaufort Park boasts excellent transport links to Central London, A41, A406 (North Circular), M1 and M25. Beaufort Park is well served by public transport with Colindale Underground approximately a 5 minute walk from the development.', 600000, 650, 0, 1987);

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_Properties_Agents` FOREIGN KEY (`Agents_id`) REFERENCES `agents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
