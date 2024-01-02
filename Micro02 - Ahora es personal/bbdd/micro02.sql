-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-01-2024 a las 18:57:46
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `micro02`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activitats`
--

CREATE TABLE `activitats` (
  `id_activitat` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `id_skillsActivitat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnes`
--

CREATE TABLE `alumnes` (
  `id_alumne` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `cognoms` varchar(100) NOT NULL,
  `usuari` varchar(50) NOT NULL,
  `contrasenya` varchar(50) NOT NULL,
  `data_naixemente` date NOT NULL,
  `curs` varchar(50) NOT NULL,
  `foto_perfil` longblob NOT NULL,
  `id_projectes` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professors`
--

CREATE TABLE `professors` (
  `id_professor` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `cognoms` varchar(100) NOT NULL,
  `usuari` varchar(50) NOT NULL,
  `contrasenya` varchar(50) NOT NULL,
  `foto_perfil` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projectes`
--

CREATE TABLE `projectes` (
  `id_projecte` int(11) NOT NULL,
  `modul` varchar(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `id_skillsProjecte` varchar(200) NOT NULL,
  `id_activitats` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skills`
--

CREATE TABLE `skills` (
  `id_skill` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `tipus` varchar(50) NOT NULL,
  `icona` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skillsactivitats`
--

CREATE TABLE `skillsactivitats` (
  `id_skillActivitat` int(11) NOT NULL,
  `percentatge` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skillsprojectes`
--

CREATE TABLE `skillsprojectes` (
  `id_skillProjecte` int(11) NOT NULL,
  `percentatge` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activitats`
--
ALTER TABLE `activitats`
  ADD PRIMARY KEY (`id_activitat`);

--
-- Indices de la tabla `alumnes`
--
ALTER TABLE `alumnes`
  ADD PRIMARY KEY (`id_alumne`);

--
-- Indices de la tabla `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`id_professor`);

--
-- Indices de la tabla `projectes`
--
ALTER TABLE `projectes`
  ADD PRIMARY KEY (`id_projecte`);

--
-- Indices de la tabla `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id_skill`);

--
-- Indices de la tabla `skillsactivitats`
--
ALTER TABLE `skillsactivitats`
  ADD PRIMARY KEY (`id_skillActivitat`),
  ADD KEY `skillactivitats_id_skill_fr` (`id_skill`);

--
-- Indices de la tabla `skillsprojectes`
--
ALTER TABLE `skillsprojectes`
  ADD PRIMARY KEY (`id_skillProjecte`),
  ADD KEY `skillprojectes_id_skill_fr` (`id_skill`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activitats`
--
ALTER TABLE `activitats`
  MODIFY `id_activitat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumnes`
--
ALTER TABLE `alumnes`
  MODIFY `id_alumne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `professors`
--
ALTER TABLE `professors`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `projectes`
--
ALTER TABLE `projectes`
  MODIFY `id_projecte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `skills`
--
ALTER TABLE `skills`
  MODIFY `id_skill` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `skillsactivitats`
--
ALTER TABLE `skillsactivitats`
  MODIFY `id_skillActivitat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `skillsprojectes`
--
ALTER TABLE `skillsprojectes`
  MODIFY `id_skillProjecte` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `skillsactivitats`
--
ALTER TABLE `skillsactivitats`
  ADD CONSTRAINT `skillactivitats_id_skill_fr` FOREIGN KEY (`id_skill`) REFERENCES `skills` (`id_skill`);

--
-- Filtros para la tabla `skillsprojectes`
--
ALTER TABLE `skillsprojectes`
  ADD CONSTRAINT `skillprojectes_id_skill_fr` FOREIGN KEY (`id_skill`) REFERENCES `skills` (`id_skill`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
