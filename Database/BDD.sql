-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 03 juin 2024 à 08:16
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `axia`
--

-- --------------------------------------------------------

--
-- Structure de la table `ba`
--

CREATE TABLE `ba` (
  `id` int(255) NOT NULL,
  `Ref` text NOT NULL,
  `id_produit` int(255) NOT NULL,
  `id_fournisseur` int(255) NOT NULL,
  `Etat` int(255) NOT NULL,
  `Date_De_Creation` varchar(50) NOT NULL,
  `C_par` text NOT NULL,
  `Qte` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ba`
--

INSERT INTO `ba` (`id`, `Ref`, `id_produit`, `id_fournisseur`, `Etat`, `Date_De_Creation`, `C_par`, `Qte`) VALUES
(1, 'BA24000002', 10, 3, 0, '2024-03-01', '2', 52),
(2, 'BA24000003', 9, 3, 1, '2024-03-03', '2', 85),
(3, 'BA24000004', 3, 4, 1, '2024-03-05', '2', 50),
(4, 'BA24000005', 2, 3, 1, '2024-03-05', '2', 10),
(5, 'BA24000006', 1, 3, 0, '2024-03-10', '2', 15),
(6, 'BA24000007', 7, 5, 1, '2024-03-13', '2', 5),
(7, 'BA24000008', 7, 4, 0, '2024-03-13', '2', 8),
(8, 'BA24000009', 4, 4, 0, '2024-03-15', '2', 15),
(9, 'BA24000010', 6, 6, 0, '2024-03-15', '2', 10),
(10, 'BA24000011', 1, 6, 0, '2024-03-15', '2', 21),
(14, 'BA24000011', 8, 5, 0, '2024-03-21', '2', 85),
(15, 'BA24000015', 1, 4, 1, '2024-03-22', '2', 2850);

-- --------------------------------------------------------

--
-- Structure de la table `be`
--

CREATE TABLE `be` (
  `id` int(255) NOT NULL,
  `Ref` text NOT NULL,
  `id_ba` int(255) NOT NULL,
  `id_magasin` int(11) NOT NULL,
  `date_entree` varchar(50) NOT NULL,
  `date_paiement` varchar(50) NOT NULL,
  `C_par` text NOT NULL,
  `Etat` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `be`
--

INSERT INTO `be` (`id`, `Ref`, `id_ba`, `id_magasin`, `date_entree`, `date_paiement`, `C_par`, `Etat`) VALUES
(1, 'BE24000002', 4, 12, '2024-04-08', '2024-04-02', '2', 1),
(2, 'BE24000003', 1, 12, '2024-03-28', '2024-04-01', '2', 1),
(3, 'BE24000004', 6, 13, '2024-03-02', '2024-04-22', '2', 1),
(4, 'BE24000005', 2, 13, '2024-03-03', '2024-04-17', '2', 1),
(5, 'BE24000006', 6, 14, '2024-03-08', '2024-04-27', '2', 1),
(6, 'BE24000007', 6, 14, '2024-03-09', '2024-04-23', '2', 1),
(7, 'BE24000008', 10, 15, '2024-03-10', '2024-04-28', '2', 1),
(34, 'BE24000008', 5, 14, '2024-04-18', '2024-04-23', '2', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(255) NOT NULL,
  `Titre` text NOT NULL,
  `idParrin` int(11) NOT NULL,
  `Etat` int(255) NOT NULL,
  `Date_de_Creation` varchar(50) NOT NULL,
  `C_par` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `Titre`, `idParrin`, `Etat`, `Date_de_Creation`, `C_par`) VALUES
(1, ' Informatique', 0, 1, '2024-03-06', '2'),
(2, 'Réseaux et Sécurité', 0, 1, '2024-03-01', '1'),
(3, 'Téléphonie', 0, 1, '2024-02-27', '2'),
(4, 'Ordinateur Portable', 1, 1, '2024-03-13', '2'),
(5, 'Serveurs', 1, 1, '2024-03-13', '2'),
(6, 'Caméra de surveillance', 2, 1, '2024-03-03', '1');

-- --------------------------------------------------------

--
-- Structure de la table `magasin`
--

CREATE TABLE `magasin` (
  `id` int(255) NOT NULL,
  `Titre` text NOT NULL,
  `Adresse` text NOT NULL,
  `Date_de_Creation` varchar(50) NOT NULL,
  `C_par` text NOT NULL,
  `Etat` int(255) NOT NULL,
  `id_be` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `magasin`
--

INSERT INTO `magasin` (`id`, `Titre`, `Adresse`, `Date_de_Creation`, `C_par`, `Etat`, `id_be`) VALUES
(12, 'M1', 'Avenue de la République-M\'saken', '2024-04-26', '2', 1, 2),
(13, 'M2', 'Msaken Hai Jedid, Msaken, Sousse', '2024-04-26', '2', 1, 35),
(14, 'M3', 'Centre Commercial - 4070 M’saken', '2024-04-26', '2', 1, 34),
(15, 'M4', ' Avenue Taieb Hachicha, Msaken - 4070', '2024-04-26', '2', 1, 4),
(29, 'M5', 'Avenue de la République-M\'saken1', '2024-05-06', '2', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(255) NOT NULL,
  `Titre` text NOT NULL,
  `Prix` int(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `idCat` int(11) NOT NULL,
  `Date_De_Creation` varchar(50) NOT NULL,
  `C_par` text NOT NULL,
  `Etat` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `Titre`, `Prix`, `Image`, `Description`, `idCat`, `Date_De_Creation`, `C_par`, `Etat`) VALUES
(1, 'PC Portable LENOVO IdeaPad 1 15IGL7 Intel Celeron N4020 4Go 256Go SSD - Gris', 700, 'pc1 .jpg', 'Écran 15.6\" HD - Processeur: Intel Celeron N4020 (1,10 GHz up to 2.80 GHz, 4Mo de mémoire cache, Dual-Core) - Système d`exploitation: Windows 11 Famille - Mémoire RAM: 4 Go DDR4-2400 - Disque Dur: 256 Go SSD - Carte Graphique: Intel UHD 600 Graphics avec Wi-Fi, Bluetooth, 1x USB 2.0, 1x USB 3.2 Gen 1, 1x USB-C 3.2 Gen 1, 1x HDMI 1.4b, 1x prise combo casque/microphone (3,5 mm) et lecteur de carte - Couleur: Gris - Garantie: 1 an', 4, '2024-02-05', '1', 1),
(2, 'PC PORTABLE THOMSON NEO 14 I3 10È GÉN 8GO 256GO SSD - NOIR', 800, 'pc2 .jpg', 'Écran 14.1\" HD - Processeur: Intel Core i3-10110U (2.10 GHz up to 4.10 GHz Turbo max, 4Mo Mémoire cache, Dual-Core) - Système d`exploitation: Windows 11 Famille - Mémoire RAM: 8Go DDR4 - Disque Dur: 256Go SSD - Carte Graphique: Intel UHD Graphics avec Wifi, Bluetooth, 1x USB 3.0, 1x USB 2.0, 1x USB 3.1 (Type-C), 1x Mini HDMI, 1x Prise stéréo 3,5 mm et Micro SD Card - Couleur: Noir - Garantie: 1 an', 4, '2024-02-05', '1', 0),
(3, 'SERVEUR HP PROLIANT DL160 GEN10 INTEL XEON 4208 16GO', 5000, 'serveur1.jpg', 'Serveur HP ProLiant DL160 Gen10 - Format: Rack 1U - Processeur: Intel Xeon 4208 (2.10 GHz up to 3,20 GHz Turbo max, 11Mo, Octa-Core) - Mémoire: 16Go RDIMM - Disque Dur: Sans Disques - Disques durs inclus: 8 SFF - Contrôleur réseau : HPE 332i 1 Gbit 2 ports - Ventilateurs: 3 Ventilateurs changeable à chaud- Alimentation: 500W - Garantie: 3 ans', 5, '2024-02-04', '1', 0),
(4, 'SERVEUR LENOVO SYSTEM X3650 M5 E5-2603 8GO (8871-EBG)', 4200, 'serveur2.jpg', 'Serveur System LENOVO X3650 M5 - Format: Rack 2U - Processeur: Intel Xeon E5-2603 v4 6C (2.1 GHz up to 3.0 GHz, 15 Mo de mémoire cache, 6 cœurs) - Mémoire: 8Go DDR4 2133 MHz - Disque Dur: Sans Disque Dur - Disque Dur Supporté: 8 de base extensible 20 hot-swap 2.5 - Ventilation: Redondante - Interface Réseau: 4x  1 Gb Ethernet, 1x IMM2, 2 x 10 Gb Ethernet - Connecteurs: 1 ports USB 3.0, 2 port 2.0, 1 port VGA DB-15, 1 port internal USB + SD Media - 3 Slots PCIe Extensible à 9 - lecteur/ graver: option - Controleur Raid: M1215 Raid (0,1,10) - Alimentation: 550W HS  Garantie: 3 ans', 5, '2024-02-29', '1', 0),
(5, 'CAMÉRA DE SURVEILLANCE INTERNE MIPVISION RW202P SMART 222', 130, 'camera1.jpg', 'Caméra de Surveillance Interne MIPVISION RW202P - Résolution: 2.0 MP 1080px - Objectif 3.6mm - Rotation 360° - Micro et haut-parleur intègrés - Audio bidirectionnel - Détection de mouvement - Connectivité: WiFi - Emplacement Micro SD - Dimensions: 10.5 x 7cm - Couleur: Blanc - Garantie: 1 an', 6, '2024-02-29', '1', 1),
(6, 'CAMÉRA DE SURVEILLANCE EXTERNE MIPVISION F186 2MP', 75, 'camera2.jpg', 'Caméra Externe MIPVISION F186 - Résolution: 2.0MP - Sortie Vidéo: 1080pixels - Étanche: IP66 - Garantie 1 an', 6, '2024-03-11', '1', 1),
(7, 'IPHONE 15 128GO JAUNE - APPLE', 4500, 'iphone15.jpg', 'Écran 6,1\" OLED Super Retina XDR HDR10, Dolby Vision - Résolution: 2556 x 1179 pixels à 460 ppp - Processeur: Puce A16 Bionic (4nm) Hexa-core (2x3,46 GHz Everest + 4x2,02 GHz en dents de scie) - GPU Apple (graphiques 5 cœurs) - Système d`exploitation: iOS 17 - Mémoire RAM: 6 Go - Stockage: 128Go - Appareil photo Arrière: DualPixels: 48 MP, f/1,6, 26 mm + 12 MP, f/2,4, 13 mm, Zoom numérique jusqu`à 10x - Appareil Avant: 12 MégaPixels, f/1.9 - Vidéo 4K à 24/25/30/60 ip - Son stéréo - Connectivité: 5G NR, Wi‑Fi 6, Bluetooth 5.3, USB Type-C 2.0 - Autonomie jusqu’à 20 heures de lecture vidéo, Streaming vidéo : Jusqu’à 16 heures, Lecture audio : Jusqu’à 80 heures - Batterie: Li-Ion 3349 mAh - Charge rapide, PD2.0, 50% en 30 min - 15W sans fil (MagSafe) - Face ID - Apple Pay - Siri - NFC - Indice de protection IP68 - Détection des accidents - Appel d`urgence - Couleur: Jaune - Garantie: 1 an', 3, '2024-03-11', '1', 1),
(8, 'IPHONE 13 PRO MAX 128GO VERT ALPIN - APPLE', 5000, 'iphone13.jpg', 'Ecran 6,7 OLED Super Retina XDR HDR - Résolution: 2778 x 1284 pixels à 458 ppp - Processeur: Puce A15 Bionic (5 nm) Hexa-core ( 2x3.22 GHz Avalanche + 4xX.X GHz Blizzard) - GPU Graphics Apple 5 Coeurs - Système d`exploitation: iOS 15 - Mémoire RAM: 6 Go - Stockage: 128 Go - Appareil photo Arrière: Trio Pixels: 12 MégaPixels Téléobjectif avec ouverture ƒ/2,8 + 12 MégaPixels Grand‑angle avec ouverture ƒ/1,5 + 12 MégaPixels Ultra grand‑angle avec ouverture ƒ/1,8 et champ de vision de 120° - Appareil Avant: 12 MégaPixels avec Ouverture ƒ/2,2 - Video 4K HDR avec Wifi, Réseau 5G , GPS , NFC et Bluetooth 5.0 - Batterie: Li-Ion 4352 mAh - Face ID - Couleur: Vert alpin - Garantie: 1 an', 3, '2024-03-11', '1', 1),
(9, 'CAPTEUR DE MOUVEMENT KSIX POUR KIT DOMOTIQUE', 70, 'capteur.jpg', 'Capteur De Mouvement KSIX Pour Kit Domotique - Connectivité sans fil: Zigbee - Champs de détection: 7m - Batterie : CR2450 - à la détection d`un changement ou d`un mouvement, il enverra une notification automatique au smartphone - Compatibilité: Appareils Android et iOS - Température de fonctionnement : -10° C - 45° C. Humidité de fonctionnement : 10 % à 95 % RH (sans condensation) - Couleur: Blanc', 2, '2024-02-28', '1', 0),
(10, 'ANTIVOLS DE SÉCURITÉ À CLÉ MANHATTAN 1.4 M', 25, 'antivol.jpg', 'Antivols de Sécurité MANHATTAN - Protégez vos équipements informatiques avec ce câble antivol en acier - Longueur Câble: 1.4 m - Fourni avec un clé - Câble antivol à fixer sur votre PC portable ou écran au système d`encoche universelle - Compatible avec la majorité des ordinateurs portables et écrans', 2, '2024-02-28', '1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reglement`
--

CREATE TABLE `reglement` (
  `id` int(255) NOT NULL,
  `id_ba` int(255) NOT NULL,
  `Date_paiement` date NOT NULL,
  `Date_de_creation` date NOT NULL,
  `C_par` text NOT NULL,
  `Etat` int(255) NOT NULL,
  `Ref` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reglement`
--

INSERT INTO `reglement` (`id`, `id_ba`, `Date_paiement`, `Date_de_creation`, `C_par`, `Etat`, `Ref`) VALUES
(1, 6, '2024-02-26', '2024-03-14', '2', 1, 'REG24000002'),
(2, 10, '2024-02-27', '2024-03-15', '2', 1, 'REG24000003'),
(3, 4, '2024-02-26', '2024-03-16', '2', 1, 'REG24000004'),
(4, 8, '2024-02-27', '2024-03-16', '2', 1, 'REG24000005'),
(5, 7, '2024-02-26', '2024-03-17', '2', 1, 'REG24000006'),
(6, 9, '2024-02-27', '2024-03-17', '2', 1, 'REG24000007'),
(7, 3, '2024-02-26', '2024-03-17', '2', 1, 'REG24000008'),
(8, 5, '2024-02-27', '2024-03-18', '2', 1, 'REG24000009'),
(9, 1, '2024-02-26', '2024-03-18', '2', 1, 'REG24000010'),
(10, 2, '2024-02-27', '2024-03-18', '2', 1, 'REG24000011'),
(11, 1, '2024-03-22', '2024-03-21', '2', 1, 'REG24000011'),
(12, 2, '2024-03-23', '2024-03-21', '2', 1, 'REG24000012'),
(13, 2, '2024-03-22', '2024-03-21', '2', 1, 'REG24000013'),
(14, 2, '2024-03-23', '2024-03-21', '2', 1, 'REG24000014'),
(15, 15, '2024-03-30', '2024-03-22', '2', 1, 'REG24000015'),
(16, 3, '2024-04-05', '2024-04-29', '2', 1, 'REG24000016'),
(17, 4, '2024-04-07', '2024-04-29', '2', 1, 'REG24000017');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(255) NOT NULL,
  `id_magasin` int(255) NOT NULL,
  `id_be` int(255) NOT NULL,
  `Etat` int(255) NOT NULL,
  `Qte` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `id_magasin`, `id_be`, `Etat`, `Qte`) VALUES
(1, 12, 1, 1, 50),
(2, 15, 6, 0, 75),
(3, 13, 3, 1, 100),
(4, 14, 2, 0, 25);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `Login` text NOT NULL,
  `Password` text NOT NULL,
  `Nom` text NOT NULL,
  `Etat` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Date_de_creation` varchar(50) NOT NULL,
  `C_par` text NOT NULL,
  `tel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `Login`, `Password`, `Nom`, `Etat`, `Type`, `Date_de_creation`, `C_par`, `tel`) VALUES
(1, 'Axia2024', 'AXIA123', 'Axia Solutions', 1, 1, '0000-00-00', 'Eya_Ladhri', ''),
(2, 'Axia2024!', 'Axia2024!', 'Axia Solutions 2', 1, 1, '0000-00-00', 'Eya_Ladhri', ''),
(3, 'Axia2024!', 'Axia2024!', 'Kmimech', 1, 2, '2024-03-01', '2', '71102222'),
(4, 'AxiaFournisseur', 'AxiaFournisseur', '  Gloulou', 1, 2, '2024-03-02', '2', '71102220'),
(5, 'AxiaFournisseur', 'AxiaFournisseur', 'Tekaya', 1, 2, '2024-03-02', '2', '71102227'),
(6, 'AxiaFournisseur', 'AxiaFournisseur', 'Landolsi', 0, 2, '2024-03-02', '2', '71102225');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ba`
--
ALTER TABLE `ba`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `be`
--
ALTER TABLE `be`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `magasin`
--
ALTER TABLE `magasin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reglement`
--
ALTER TABLE `reglement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ba`
--
ALTER TABLE `ba`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `be`
--
ALTER TABLE `be`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `magasin`
--
ALTER TABLE `magasin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `reglement`
--
ALTER TABLE `reglement`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
