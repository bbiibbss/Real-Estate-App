-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2017 at 04:08 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verde_mar`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_type`
--

CREATE TABLE `business_type` (
  `business_type_id` int(11) NOT NULL,
  `business_type_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_type`
--

INSERT INTO `business_type` (`business_type_id`, `business_type_name`) VALUES
(1, 'Venda'),
(2, 'Arrendamento'),
(3, 'Permuta');

-- --------------------------------------------------------

--
-- Table structure for table `county`
--

CREATE TABLE `county` (
  `county_id` int(11) NOT NULL,
  `county_name` varchar(45) NOT NULL,
  `PK_island_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `county`
--

INSERT INTO `county` (`county_id`, `county_name`, `PK_island_id`) VALUES
(1, 'Ponta Delgada', 1),
(2, 'Ribeira Grande', 1),
(3, 'Nordeste', 1),
(4, 'Santa Cruz', 8),
(5, 'Angra do Heroísmo', 3),
(6, 'Companhia de Baixo', 5),
(7, 'Lagoa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `featured`
--

CREATE TABLE `featured` (
  `PK_property_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `featured`
--

INSERT INTO `featured` (`PK_property_id`) VALUES
(8),
(9),
(10);

-- --------------------------------------------------------

--
-- Table structure for table `featured_suggestions`
--

CREATE TABLE `featured_suggestions` (
  `PK_property_id` int(11) NOT NULL,
  `PK_fs_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `featured_suggestions`
--

INSERT INTO `featured_suggestions` (`PK_property_id`, `PK_fs_user_id`) VALUES
(14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `island`
--

CREATE TABLE `island` (
  `island_id` int(11) NOT NULL,
  `island_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `island`
--

INSERT INTO `island` (`island_id`, `island_name`) VALUES
(1, 'São Miguel'),
(2, 'Santa Maria'),
(3, 'Terceira'),
(4, 'Graciosa'),
(5, 'Pico'),
(6, 'Faial'),
(7, 'São Jorge'),
(8, 'Flores'),
(9, 'Corvo');

-- --------------------------------------------------------

--
-- Table structure for table `parish`
--

CREATE TABLE `parish` (
  `parish_id` int(11) NOT NULL,
  `parish_name` varchar(45) NOT NULL,
  `PK_county_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `parish`
--

INSERT INTO `parish` (`parish_id`, `parish_name`, `PK_county_id`) VALUES
(1, 'Conceição', 2),
(2, 'Maia', 2),
(3, 'Rabo de Peixe', 2),
(4, 'Pico da Pedra', 2),
(5, 'São Pedro', 1),
(6, 'Santa Cruz das Flores', 4),
(7, 'Ribeira Seca', 2),
(8, 'São Vicente de Ferreira', 1),
(9, 'Porto Judeu', 5),
(10, 'São João', 6),
(11, 'Caloura', 7),
(12, 'Livramento', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(11) NOT NULL,
  `PK_user_id` int(11) NOT NULL,
  `business_types` varchar(500) DEFAULT NULL,
  `property_types` varchar(500) DEFAULT NULL,
  `property_typologies` varchar(500) DEFAULT NULL,
  `parishes` varchar(500) DEFAULT NULL,
  `max_value` varchar(20) DEFAULT NULL,
  `min_value` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `PK_user_id`, `business_types`, `property_types`, `property_typologies`, `parishes`, `max_value`, `min_value`) VALUES
(11, 1, 'Venda</br>', 'Vivenda</br>', 'T5</br>', 'Ribeira Seca - Ribeira Grande - São Miguel</br> São João - Companhia de Baixo - Pico</br>', '2131232323', '213213');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `property_id` int(1) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_description` text NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `PK_property_type_id` int(11) NOT NULL,
  `PK_property_typology_id` int(11) DEFAULT NULL,
  `PK_parish_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `area` float NOT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `latitude` varchar(45) NOT NULL,
  `longitude` varchar(45) NOT NULL,
  `PK_business_type_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `PK_user_id` int(11) DEFAULT NULL,
  `PK_property_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `property_name`, `property_description`, `photo_path`, `PK_property_type_id`, `PK_property_typology_id`, `PK_parish_id`, `address`, `area`, `bedrooms`, `bathrooms`, `latitude`, `longitude`, `PK_business_type_id`, `price`, `PK_user_id`, `PK_property_status_id`) VALUES
(8, 'Moradia T3', 'Moradia t3 com magnifica vista sobre o mar localizada na freguesia da Bretanha. \r\nInserida em terreno com 730m2 com pequena casa de pedra, esta moradia divide-se por dois pisos e é composta no rés do chão por sala e cozinha em open space, w.c., entrada lateral, logradouro, casa de arrumos e uma vista soberba em seu redor. O 1º piso é composto por 3 quartos de cama e w.c. Moradia em excelente estado de conservação como poderão comprovar pelas fotos.', '../images/properties/ppt1.jpg', 2, 3, 12, 'Ponta Delgada - Ajuda da Bretanha', 730, 3, 2, '37.781109', '-25.495996', 1, 135, 3, 1),
(9, 'Moradia T3', 'Facilidades de Financiamento. \r\nMoradia isolada com 1 piso e aproveitamento de sótão, inserida num terreno com 196 m2, sita na freguesia de Santa Cruz das Flores (Ilha das Flores - Açores). Localiza-se, numa zona rural litoral, na 1ª periferia ao centro da vila de Santa Cruz das Flores (a menos de 1 Km do aeroporto), em zona onde predominam moradias isoladas, terrenos agrícolas e pastagens. Beneficia na envolvente de razoável nível de acessos, estacionamentos e infraestruturas básicas. Em termos de compartimentação, a moradia possui ao nível do RC: sala, cozinha, 2 quartos, Casa de Banho e arrumos, e ao nível do Sótão: sala (divisão ampla). \r\nCategoria Energética: C', '../images/properties/ppt10.jpg', 2, 3, 6, 'Santa Cruz - Santa Cruz das Flores', 196, 2, 1, '39.463514', '-31.137771', 2, 23000, 3, 1),
(10, 'Apartamento T3', 'Apartamento T3 situado na freguesia de Ribeira Seca, concelho de Ribeira Grande. \r\nConstituido por Hall de entrada com arrumações, 3 quartos de cama, sala comum com varanda, 2 wc`s, corredor, cozinha com zona de máquinas e lugar de garagem em cave. \r\nMuito próximo do Areal de Santa Bárbara e do centro da Ribeira Grande. \r\nZona calma e com boas acessibilidades.', '../images/properties/ppt2.jpg', 1, 3, 7, 'Ribeira Grande - Ribeira Seca,', 111, 3, 2, '37.807271', '-25.543264', 1, 90000, 3, 1),
(11, 'Lote', 'Lote com 3000m2 situado na Quinta da Magnólia, freguesia do Pico da Pedra, concelho de Ribeira Grande. \r\nEm zona calma e em expansão, com Moradias de construção recente. \r\nImplantação de 20%, ou seja, implantação no máximo de 600m2 e possibilidade de fazer 2 pisos. \r\nLote todo Murado e com ligações de água e electricidade.', '../images/properties/ppt3.jpg', 6, 7, 4, 'Ribeira Grande - Pico da Pedra,', 3000, 0, 0, '37.806610', '-25.623945', 1, 87500, 3, 1),
(12, 'Vivenda T4', 'Espetacular moradia T4 com 2 suites, garagem 2 viaturas, piscina e anexo de apoio á piscina.Grandes áreas de varandas. Acabamentos de primeira em cerejeira, carvalho e granitos. Singular vista panorâmica.', '../images/properties/ppt8.jpg', 3, 4, 8, 'Ponta Delgada - São Vicente Ferreira,', 1340, 4, 2, '37.781419', '-25.496283', 3, 380000, 3, 3),
(13, 'Moradia T4', 'Moradia T4 localizada no concelho de Angra do Heroísmo freguesia de Porto Judeu. \r\nComposta por 4 quartos de cama sendo 1 deles uma suite e todos virados para o mar, cozinha, zona de refeições, arrecadação, sala comum, 4 casas de banho, garagem para 2 viaturas, piscina, alpendre e 2 anexos. \r\nElectrodomésticos e algumas mobílias.', '../images/properties/ppt6.jpg', 2, 4, 9, 'Angra do Heroísmo - Porto Judeu,', 1452, 4, 4, '38.648001', '-27.120622', 1, 800000, 3, 2),
(14, 'Quinta T6', 'Quinta com 34.000 m2, localizada em zona Turística de micro-clima. Casa principal composta por 4 quartos (2 suites); 2 Salas; 5 wc; 1 cozinha e alpendre coberto. Existência de uma 2ª casa de tipologia T2, (1 suite), 2 Salas, 1 wc e 1 cozinha. Propriedade com nascente de água, Lago e Rega. Totalmente recuperada com excepção das Arribanas (Antigas Adegas de vinho e Arrumos).', '../images/properties/ppt5.jpg', 5, 6, 10, 'São João - Companhia de Baixo - Pico', 34000, 6, 5, '38.416555', '-28.332647', 1, 4000000, 3, 1),
(15, 'Quinta, Com casa', 'Quinta com características únicas e magníficas, que conjuga natureza com o aconchego de uma vivenda de traça rústica. Esta propriedade é composta por diversas árvores de fruto e centenárias e espaços de lazer. A vivenda é de arquitectura rústica e com características singulares, quer pela qualidade de acabamentos, quer pelas suas generosas áreas interiores, bem como uma vista deslumbrante sobre o mar e a serra. Quinta com excelente localização, onde pode desfrutar de uma excelente zona balnear e do sossego do campo. Grande oportunidade!', '../images/properties/quinta-lamosa-agro-turismo.jpg', 5, 4, 11, 'Vila de Água de Pau, Lagoa, São Miguel', 9275, 4, 3, '37.713403', '-25.506636', 1, 13212100000, 3, 1),
(21, 'Vivenda T2 em Ponta Delgada', 'refdgfgfdgsdfg', '../images/properties/Vivenda T2 em Ponta Delgada_sdfdfdfsafsdfdsa/Alojamentos-turisticos-luxo-Albufeira-Vivenda-de-luxo_1.jpeg', 3, 3, 6, 'sdfdfdfsafsdfdsa', 23324, 3, 2, '37.749398', '-25.615920', 2, 21321, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_status`
--

CREATE TABLE `property_status` (
  `property_status_id` int(11) NOT NULL,
  `property_status_name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `property_status`
--

INSERT INTO `property_status` (`property_status_id`, `property_status_name`) VALUES
(1, 'Disponível'),
(2, 'Arrendada'),
(3, 'Vendida');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `property_type_id` int(11) NOT NULL,
  `property_type_name` varchar(45) NOT NULL,
  `pin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`property_type_id`, `property_type_name`, `pin`) VALUES
(1, 'Apartamento', 'pin1.png'),
(2, 'Moradia', 'pin2.png'),
(3, 'Vivenda', 'pin3.png'),
(4, 'Garagem', 'pin4.png'),
(5, 'Quinta', 'pin5.png'),
(6, 'Lote', 'pin6.png');

-- --------------------------------------------------------

--
-- Table structure for table `property_typology`
--

CREATE TABLE `property_typology` (
  `property_typology_id` int(11) NOT NULL,
  `property_typology_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_typology`
--

INSERT INTO `property_typology` (`property_typology_id`, `property_typology_name`) VALUES
(1, 'T1'),
(2, 'T2'),
(3, 'T3'),
(4, 'T4'),
(5, 'T5'),
(6, 'T6'),
(7, 'n/a');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `PK_property_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`PK_property_id`, `date`) VALUES
(13, '2017-07-03');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `PK_property_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_value` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`PK_property_id`, `sale_date`, `sale_value`) VALUES
(8, '2017-07-03', 135),
(12, '2017-07-03', 380000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `PK_user_type_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `phone_number` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `PK_user_type_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`) VALUES
(1, 1, 'Beatriz', 'Vieira', 'bia.v.a@hotmail.com', '35dbf998988376dbd5e25604830afced', 111222333),
(2, 3, 'admin', 'admin', 'admin@gmail.com', '35dbf998988376dbd5e25604830afced', 1234345),
(3, 2, 'manager', 'manager', 'manager@gmail.com', '35dbf998988376dbd5e25604830afced', 123131),
(4, 1, 'Jane', 'Doe', 'jane_doe@gmail.com', '35dbf998988376dbd5e25604830afced', 123456789),
(5, 1, 'Joe', 'Doe', 'joe_doe@gmail.com', '35dbf998988376dbd5e25604830afced', 2147483647),
(6, 1, 'Bia', 'A', 'avzirtaeb@gmail.com', '35dbf998988376dbd5e25604830afced', 32123121);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'Cliente'),
(2, 'Gestor'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `id_visit` int(11) NOT NULL,
  `PK_property_id` int(11) NOT NULL,
  `PK_client_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `client_observations` text NOT NULL,
  `manager_observations` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`id_visit`, `PK_property_id`, `PK_client_id`, `date_time`, `client_observations`, `manager_observations`) VALUES
(1, 8, 1, '2017-07-13 15:56:00', 'dfddsgdfgsdfgfdsgdfg', ''),
(2, 14, 1, '2017-07-04 17:30:00', 'fdfdfgdfgdfgsdfg', '');

-- --------------------------------------------------------

--
-- Table structure for table `visit_request`
--

CREATE TABLE `visit_request` (
  `id_visit_request` int(11) NOT NULL,
  `PK_property_id` int(11) NOT NULL,
  `PK_client_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `observations` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visit_request`
--

INSERT INTO `visit_request` (`id_visit_request`, `PK_property_id`, `PK_client_id`, `date_time`, `observations`) VALUES
(3, 21, 1, '2017-07-27 21:11:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_type`
--
ALTER TABLE `business_type`
  ADD PRIMARY KEY (`business_type_id`);

--
-- Indexes for table `county`
--
ALTER TABLE `county`
  ADD PRIMARY KEY (`county_id`),
  ADD KEY `PK_island_id` (`PK_island_id`);

--
-- Indexes for table `featured`
--
ALTER TABLE `featured`
  ADD UNIQUE KEY `PK_property_id_2` (`PK_property_id`),
  ADD KEY `PK_property_id` (`PK_property_id`);

--
-- Indexes for table `featured_suggestions`
--
ALTER TABLE `featured_suggestions`
  ADD PRIMARY KEY (`PK_property_id`),
  ADD KEY `PK_property_id` (`PK_property_id`),
  ADD KEY `PK_user_id` (`PK_fs_user_id`);

--
-- Indexes for table `island`
--
ALTER TABLE `island`
  ADD PRIMARY KEY (`island_id`);

--
-- Indexes for table `parish`
--
ALTER TABLE `parish`
  ADD PRIMARY KEY (`parish_id`),
  ADD KEY `PK_county_id` (`PK_county_id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PK_user_id` (`PK_user_id`),
  ADD KEY `PK_property_type_id` (`property_types`),
  ADD KEY `PK_parish_id` (`parishes`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `PK_property_type_id` (`PK_property_type_id`),
  ADD KEY `PK_parish_id` (`PK_parish_id`),
  ADD KEY `PK_user_id` (`PK_user_id`),
  ADD KEY `PK_property_typology_id` (`PK_property_typology_id`),
  ADD KEY `PK_business_type_id` (`PK_business_type_id`),
  ADD KEY `PK_property_status_id` (`PK_property_status_id`);

--
-- Indexes for table `property_status`
--
ALTER TABLE `property_status`
  ADD PRIMARY KEY (`property_status_id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`property_type_id`);

--
-- Indexes for table `property_typology`
--
ALTER TABLE `property_typology`
  ADD PRIMARY KEY (`property_typology_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD KEY `PK_property_id` (`PK_property_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD KEY `PK_property_id` (`PK_property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `PK_user_type_id` (`PK_user_type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id_visit`),
  ADD KEY `PK_property_id` (`PK_property_id`),
  ADD KEY `PK_user_id` (`PK_client_id`);

--
-- Indexes for table `visit_request`
--
ALTER TABLE `visit_request`
  ADD PRIMARY KEY (`id_visit_request`),
  ADD KEY `PK_property_id` (`PK_property_id`),
  ADD KEY `PK_client_id` (`PK_client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_type`
--
ALTER TABLE `business_type`
  MODIFY `business_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `county`
--
ALTER TABLE `county`
  MODIFY `county_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `island`
--
ALTER TABLE `island`
  MODIFY `island_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `parish`
--
ALTER TABLE `parish`
  MODIFY `parish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `property_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `property_status`
--
ALTER TABLE `property_status`
  MODIFY `property_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `property_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `property_typology`
--
ALTER TABLE `property_typology`
  MODIFY `property_typology_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `id_visit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `visit_request`
--
ALTER TABLE `visit_request`
  MODIFY `id_visit_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `county`
--
ALTER TABLE `county`
  ADD CONSTRAINT `county_ibfk_1` FOREIGN KEY (`PK_island_id`) REFERENCES `island` (`island_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `featured`
--
ALTER TABLE `featured`
  ADD CONSTRAINT `featured_ibfk_1` FOREIGN KEY (`PK_property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `featured_suggestions`
--
ALTER TABLE `featured_suggestions`
  ADD CONSTRAINT `featured_suggestions_ibfk_1` FOREIGN KEY (`PK_property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `featured_suggestions_ibfk_2` FOREIGN KEY (`PK_fs_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parish`
--
ALTER TABLE `parish`
  ADD CONSTRAINT `parish_ibfk_1` FOREIGN KEY (`PK_county_id`) REFERENCES `county` (`county_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`PK_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`PK_property_type_id`) REFERENCES `property_type` (`property_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_ibfk_2` FOREIGN KEY (`PK_parish_id`) REFERENCES `parish` (`parish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_ibfk_3` FOREIGN KEY (`PK_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_ibfk_4` FOREIGN KEY (`PK_property_typology_id`) REFERENCES `property_typology` (`property_typology_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_ibfk_5` FOREIGN KEY (`PK_business_type_id`) REFERENCES `business_type` (`business_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`PK_user_type_id`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`PK_property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_ibfk_2` FOREIGN KEY (`PK_client_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visit_request`
--
ALTER TABLE `visit_request`
  ADD CONSTRAINT `visit_request_ibfk_1` FOREIGN KEY (`PK_client_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_request_ibfk_2` FOREIGN KEY (`PK_property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
