-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : Dim 27 fév. 2022 à 17:50
-- Version du serveur :  5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e-commerce-symfo`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `firstname`, `lastname`, `company`, `address`, `postal`, `city`, `country`, `phone`) VALUES
(2, 2, 'Test', 'fffs', 'Colemansqdf', 'Mcdowell Trujillo Associates', '9 rue Ut qui voluptas nobi', '15554', 'Dolorum voluptas per', 'HN', '+1 (707) 437-6409'),
(3, 18, 'Noelani Hubbard', 'Laura', 'Meadows', 'Miranda and Mathis Plc', 'Rem officiis in sed', 'Voluptas do sed corr', 'Laudantium est ex d', 'MT', '+1 (993) 958-2319'),
(4, 18, 'Keefe Delgado', 'Shaeleigh', 'Banks', 'Hernandez England LLC', 'Dolore sit libero d', 'Illo voluptas quam o', 'Labore veniam culpa', 'QA', '+1 (714) 646-6032');

-- --------------------------------------------------------

--
-- Structure de la table `carrier`
--

CREATE TABLE `carrier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carrier`
--

INSERT INTO `carrier` (`id`, `name`, `description`, `price`) VALUES
(1, 'Chronopost', 'Livraison standard à domicile en 2 jours ouvrés.', 3.9),
(2, 'La Poste', 'Si vous préférez trouver dans votre boite à lettres un avis de passage à la place de votre commande.', 1.49);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'Manteaux'),
(3, 'Echarpes'),
(4, 'Bonnets'),
(5, 'T-shirts');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220216090224', '2022-02-16 09:02:53', 195),
('DoctrineMigrations\\Version20220216094827', '2022-02-16 09:48:41', 54),
('DoctrineMigrations\\Version20220218171218', '2022-02-18 17:12:29', 198),
('DoctrineMigrations\\Version20220219105301', '2022-02-19 10:53:16', 221),
('DoctrineMigrations\\Version20220220215719', '2022-02-20 21:57:28', 237),
('DoctrineMigrations\\Version20220222211707', '2022-02-22 21:17:36', 172),
('DoctrineMigrations\\Version20220226160703', '2022-02-26 16:07:11', 356),
('DoctrineMigrations\\Version20220227163839', '2022-02-27 16:38:48', 677);

-- --------------------------------------------------------

--
-- Structure de la table `oder_details`
--

CREATE TABLE `oder_details` (
  `id` int(11) NOT NULL,
  `binded_order_id` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `carrier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrier_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `image`, `subtitle`, `description`, `price`) VALUES
(2, 4, 'Bonnet Rouge Pompom', 'bonnet-rouge-pompom', 'e0b7e89b60de57f1e4451fd9831be26a102081e4.jpg', 'Restez au chaud avec style', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum! Provident similique accusantium nemo autem. Veritatis\r\nobcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam\r\nnihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,\r\ntenetur error, harum nesciunt ipsum debitis quas aliquid.', 1800),
(3, 4, 'Bonnet Rouge et Bleu Pompom', 'bonnet-rouge-et-bleu-pompom', '8bf330b14aefcec1ab92b7c3f475290fd7940275.jpg', 'Restez au chaud avec style (encore)', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum! Provident similique accusantium nemo autem. Veritatis\r\nobcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam\r\nnihil, eveniet aliquid culpa officia aut!', 1600),
(4, 3, 'Echarpe Rouge', 'echarpe-rouge', '9ec1111e99942243bf2157e2fbeaa2aec0a485ac.jpg', 'Pour le ski ou la ville', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum!', 1400),
(5, 2, 'Manteau chaud', 'manteau-chaud', '5cf449463c611b07451480da81fa048f208fc974.jpg', 'Pour les hivers rudes', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum! Provident similique accusantium nemo autem. Veritatis\r\nobcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam\r\nnihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,\r\ntenetur error, harum nesciunt ipsum debitis quas aliquid.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit.', 5800),
(6, 5, 'T-shirt Blanc', 't-shirt-blanc', 'ee40d9f7990aead7e8695f2eb4599ea1dbb0b1b1.jpg', 'Simple, basique', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum!', 1800),
(7, 3, 'Echarpe Rayée', 'echarpe-rayee', '2153f235c1175c595860b612a4d2657402184a04.jpg', 'La classe à Annemasse', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum! Provident similique accusantium nemo autem. Veritatis\r\nobcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam\r\nnihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,\r\ntenetur error, harum nesciunt ipsum debitis quas aliquid.', 1500),
(8, 5, 'T-Shirt Moulant', 't-shirt-moulant', '00a9e824e1a5ba119d9964cc2798fdc3e27b9a84.jpg', 'Pour les bogoss\'', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum!', 15800);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1, 'qila@mailinator.com', '[]', '$2y$13$XJ6eO87g5wbbYo1VVGsSa.K3ZoY3nxb/AP7jesP.B4pQ5uCTPnWta', 'Abel', 'Cook'),
(2, 'bewebokyt@mailinator.com', '[]', '$2y$13$hbsvJpSPsTAifkSz7EKdnek5JELREFm7AcAD2waapW.CGbPPb9/Xa', 'Cameran', 'Santana'),
(3, 'zohova@mailinator.com', '[]', '$2y$13$V8gb44ppyH26z1aGFrrrg.YHVwNCrO2uoDCODyAqkKb3IehWYw/de', 'Demetrius', 'Barron'),
(5, 'pybozy@mailinator.com', '[]', '$2y$13$TIqH1opO82k7lhHZIQx3RuJcMOOZd4wgpILAC8BQ7Fm0L31Lhrop2', 'Benedict', 'Parker'),
(6, 'doqyre@mailinator.com', '[]', '$2y$13$aS8uwK/U422zKIQPZVan6.xxXHbKDLe0QBu3BrA6cv3bT8NJydCFi', 'Kaseem', 'Boyd'),
(7, 'admin@admin.com', '[]', '$2y$13$sfixY8eaiATRLoXXOsAPHeONkAzCrsnP9tdIOBRgnpxc3ROBgvREW', 'Sierra', 'Michael'),
(8, 'zofyd@mailinator.com', '[]', '$2y$13$5eh2MdTTmp3saxjVSdSDpuuI1U4OFVbfj9rLOMK0MZOeatvcPciSa', 'Portia', 'Rasmussen'),
(9, 'qijab@mailinator.com', '[]', '$2y$13$kZAwoyXojOm5KZWhSGH3aeAaYe1DU3pBkqHnD7Qz328dpbPHuu1L6', 'Ivana', 'Roberson'),
(10, 'suvymez@mailinator.com', '[]', '$2y$13$ygkBzDRFAqErEjNg84CwEOeN3UjCE.QaaGALDmykqQBvP/WIuKF4.', 'Selma', 'Rice'),
(11, 'lykeho@mailinator.com', '[]', '$2y$13$rYh3reJhPHOthgfaKhz/e..5ghtSb0RgIDZQT98iJLyvjmwRhMl0G', 'Amity', 'Myers'),
(12, 'tygemu@mailinator.com', '[]', '$2y$13$nYHb/cULNrIAdteSAtJSiOy4wkZbxfYeAY4los.C9BOBBczF09P0e', 'Alexis', 'Underwood'),
(14, 'wozowiwydi@mailinator.com', '[]', '$2y$13$AFkNQqYChQC6bDQWuO0eVeIhu9jnEMpSCk4e0bT.Cc6gCGWoXHZEi', 'Dustin', 'Collins'),
(16, 'maqatoked@mailinator.com', '[]', '$2y$13$gxSZ/IWhSlUbOeMJpA.qBejCfpRgj1Zz4YgQ0Q7OII51YwzVFjBpW', 'Imani', 'Hodge'),
(17, 'vimelabe@mailinator.com', '[]', '$2y$13$3kJHAAwcWz8/UY7EBPFeIOkfzwrz9HXv2vOZjiA/veXiZr14XGeTi', 'Imogene', 'Mccormick'),
(18, 'dakyridut@mailinator.com', '[]', '$2y$13$hi0ATGo5E4HiBtd98kjEoud.CYeEwTUg07dP0vZHVayIYttmK0yqy', 'Gregory', 'Garcia');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81A76ED395` (`user_id`);

--
-- Index pour la table `carrier`
--
ALTER TABLE `carrier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `oder_details`
--
ALTER TABLE `oder_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4BC9C1557C78A4E3` (`binded_order_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `carrier`
--
ALTER TABLE `carrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `oder_details`
--
ALTER TABLE `oder_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `oder_details`
--
ALTER TABLE `oder_details`
  ADD CONSTRAINT `FK_4BC9C1557C78A4E3` FOREIGN KEY (`binded_order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
