-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 10 aug 2013 om 14:44
-- Serverversie: 5.5.24-log
-- PHP-versie: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `re`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `properties`
--

INSERT INTO `properties` (`id`, `Agents_id`, `Name`, `Available`, `State`, `Type`, `Province`, `Location_street`, `Location_City`, `Date_posted`, `Date_available`, `Description`, `Price`, `Size`, `Bedrooms`, `Buildyear`) VALUES
(1, 2, '4 bedroom terraced house to rent', 1, 'Rent', 'House', 'Brussel', 'Zespenningenstraat 39', '1000 Brussel', '2013-08-20', '2013-08-22', 'Situated within a desirable location this stunning four bedroomed house offers contemporary accommodation in fantastic condition throughout. The property boasts stunning double reception room with period features, large eat in kitchen with quality fixtures, spacious master bedroom with plenty of storage, three further good size bedrooms, family bathroom and private paved garden. Cornwall Grove is close to the many shops and restaurants on Chiswick High Road and Turnham Green Terrace, Chiswick House and Grounds and the River Thames are within reach and the A4/M4 allows quick and easy routes into London.', 800, 150, 4, 2009),
(2, 2, '6 bedroom flat to rent', 1, 'Rent', 'Apartment', 'Oost-Vlaanderen', 'Dampoortstraat 59', '9000 Gent', '2013-08-21', '2013-08-23', 'The most stunning Penthouse apartment boasting 6 bedrooms and 5 reception rooms in one of the most highly sought after and desirable locations in London. This 10,000 Sq Ft Penthouse apartment has a 150 ft frontage directly overlooking Hyde Park. The Penthouse apartment boasts 5 stunning reception rooms, 2 kitchens, 6 bedrooms including a master bedroom suite with his/her bathrooms and dressing rooms, a fully equipped gymnasium, spa treatment room, six stunning terraces and gardens with amazing 360 degree views over The City, the West End, and the Houses of Parliament. Parking and separate staff accommodations are also available subject to negotiation. There is also a lift that opens directly into a private lobby with stainless steal double tramlines giving a Deco detail to the black Zimbabwe marble floor.', 650, 160, 6, 2006),
(3, 2, '5 bedroom penthouse to rent', 1, 'Rent', 'Apartment', 'West-Vlaanderen', 'Wellingtonstraat 70', '8400 Oostende', '2013-08-19', '2013-08-30', 'This Apartment offers the luxury, discretion and security of a five star hotel whilst combining comfort and a personalised service. This building is arranged over several floors and is available to suit all needs; whether a short let or long term. A selection of one bedroom apartments to five bedroom is available to suit many tastes and needs. The views are spectacular, reaching across the London skyline from its prime position on Park Lane, overlooking Hyde Park. Each property has been interior designed to the highest specification, there is use of a lift as well as use of the hotel facilities. \r\n\r\nThe 4823 sq. ft. five bedroom penthouse apartment comprises of five large double bedrooms, four marble en-suite bathrooms, fully-fitted Poggenpohl kitchen, cinema room, dining room, and four generously sized reception rooms. As this is a penthouse apartment, there are breath-taking views from the balcony as well as televisions, full size amenities and use of a concierge service, butler and maid, gym, and an Aston Martin Car. ', 1300, 550, 5, 2011),
(4, 2, '7 bedroom house to rent', 0, 'Rent', 'House', 'Luxemburg', '4 Faubourg', '4120 Esch-sur-Alzette', '2013-08-24', '2013-08-31', 'SHORT LET. A unique, truly imposing seven bedroomed gated house offering lavish interiors, extensive living space and a beautiful garden with inviting heated swimming pool.\r\n\r\nLocated behind electric gates in the heart of Hampstead moments the High Street and green expanses of the Heath.\r\n\r\n\r\nA very impressive seven bedroomed gated house\r\nLocated in the heart of desirable Hampstead\r\nFrench silk wall coverings, blinds and curtains\r\nHand selected period fireplaces\r\nWell presented garden and outdoor heated swimming pool\r\nCustom built kitchen, gym, steam room, heated garage\r\nVenetian stone walls and stone staircase\r\nMulti-line telephone system with 26 handsets', 950, 1050, 7, 1993),
(5, 2, '7 bedroom house to rent', 1, 'Rent', 'House', 'Limburg', 'Kattegatstraat 1', '3500 Hasselt', '2013-08-14', '2013-08-21', 'We are pleased to present this stunning, well presented and well proportioned seven bedroom house located in the heart of Chelsea benefiting from a lift, swimming pool, garden and roof terrace.\r\n\r\nThe property, which is available furnished or unfurnished, consists of a bright formal double reception room, fully fitted kitchen/breakfast room with all modern appliances and granite work surfaces, further reception/family room leading to a wonderful conservatory and garden, television room, guest bedroom, bathroom and kitchen on the lower ground floor with stairs leading to a stunning swimming pool, master bedroom suite with adjoining bathroom and dressing room, three more double bedrooms each with their own bathroom on the upper floors, roof terrace and finally a large study. \r\n\r\nStand out features would be a large family kitchen, conservatory dining room, basement swimming pool and roof terrace with superb views. Ideally located for walks along the river, shopping on King''s Road and access to central London from Sloane Square.\r\n\r\nThis exceptional property is available for either a short or long term rental. Short lets is now reduced to £19,500', 1300, 600, 7, 2001),
(6, 2, '7 bedroom apartment to rent', 1, 'Rent', 'Apartment', 'Waals-Brabant', 'Avenue des Combattants 2', '1340 Ottignies-Louvain-la-Neuve', '2013-08-24', '2013-08-24', 'This incredible seven bedroom house over nearly 7000 sq ft is situated in a quiet, prestigious Chelsea location. Features include a 15m private garden, indoor swimming pool and roof terrace with views over the River Thames. The accommodation is comprised of three reception rooms, large kitchen/breakfast room, seven bedrooms (including a self-contained nanny flat), four bathrooms, two shower rooms, a large study and conservatory. \r\n\r\nCheyne Place is located moments from the river and is close to the famous King''s Road. The closest Underground Station is Sloane Square (Circle, District & Piccadilly Lines).', 1900, 950, 7, 1995),
(7, 2, 'Retail Property to rent', 1, 'Rent', 'Commercial', 'Oost-Vlaanderen', 'Stationsstraat 40', '9100 Sint-Niklaas', '2013-08-10', '2013-08-19', 'CITY FRINGE NEW BUILD RETAIL/SHOWROOM OPPORTUNITY RENT Ground floor: £80,000 per annum Basement: £40,000 per annum DESCRIPTION Modern development comprising a mixture of residential, office and retail. The retail element is available to rent in shell and core. Nearby retailers include Paddy Power, Lloyds TSB, Tesco, Jennings, Iceland & McDonalds (My Idea Store & Watney Street Market are directly opposite). In addition, the Holiday Inn Hotel is located almost next door and is due to open in the summer of 2012. LOCATION Located in the heart of Commercial Road (A13), close to Cavell Street. A mixture of office, residential and retail developments are now being completed in this location. Historically the centre of London’s clothing ‘Cash and Carry’ sector, Whitechapel is developing into a more mixed occupier sector. TRANSPORT Commercial Road (A13) is well served with numerous bus routes and Whitechapel Underground Station.', 2500, 300, 0, 2002),
(8, 2, 'Commercial Property to rent', 1, 'Rent', 'Commercial', 'Antwerpen', 'Blindestraat 6', '2000 Antwerpen', '2013-08-20', '2013-08-21', 'Ground Floor Shop	\r\nTotal net internal area 62.98 sq m (678 sq ft). Let to Wimbledon Fine Art on a 5 year internal repairing lease from 25/03/2002 (holding over) at a rental of £21,996. \r\n\r\nGround Floor Rear Office \r\nTotal net internal area 48.96 sq m (527 sq ft). Vacant (ERV £15,000 per annum) \r\n\r\nFirst Floor Front Office \r\nTotal net internal area 41.34 sq m (445 sq ft). Let to Mr T Broom T/A Broom Palmer Solicitors on a 3 year internal repairing lease from 01/03/2006 (holding over)	 at a rental of £11,000. \r\n\r\nFirst Floor Rear Office \r\nTotal net internal area 30 sq m (324 sq ft). Let to Restore on a 3 year internal repairing lease from February 2009 (holding over) at a rental of £7,250. \r\n\r\nTotal rent reserved £40,426 pa with vacant possession of 1 office suite. \r\n\r\nIt is considered that the property may be sutiable for conversion to residential, subject to he necessary consents. Itnerested parties must rely on tehir own enquiries to the Lolndon Borough of Merton Planning Department - Tel: 020 8543 6085. ', 3250, 450, 0, 1985),
(9, 2, 'qwret', 1, 'Rent', 'Land', 'Vlaams-Brabant', 'stationstraat 5', '9100 sint-niklaas', '2013-08-10', '2013-08-26', '<p>fsdfsafsafsfsfsfsafsafsfsfsadf</p>', 258, 546, 5, 0000);

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
