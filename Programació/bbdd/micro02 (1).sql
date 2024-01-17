-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2024 a las 21:54:46
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
  `data_entrega` date NOT NULL,
  `activa` char(1) NOT NULL,
  `id_projecte` int(11) NOT NULL
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
  `data_naixement` date NOT NULL,
  `curs` varchar(50) NOT NULL,
  `foto_perfil` longblob NOT NULL,
  `tipus_foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnes_projectes`
--

CREATE TABLE `alumnes_projectes` (
  `id_alumne_projecte` int(11) NOT NULL,
  `nota_projecte` int(11) NOT NULL,
  `id_alumne` int(11) NOT NULL,
  `id_projecte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_skill_act_alumne`
--

CREATE TABLE `nota_skill_act_alumne` (
  `id_nota_skill_act_alumne` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `id_alumne` int(11) NOT NULL,
  `id_skill_activitat` int(11) NOT NULL
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
  `foto_perfil` longblob NOT NULL,
  `tipus_foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `professors`
--

INSERT INTO `professors` (`id_professor`, `nom`, `cognoms`, `usuari`, `contrasenya`, `foto_perfil`, `tipus_foto`) VALUES
(1, 'admin', '', 'admin', 'admin', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professors_projectes`
--

CREATE TABLE `professors_projectes` (
  `id_professor_projecte` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `id_projecte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projectes`
--

CREATE TABLE `projectes` (
  `id_projecte` int(11) NOT NULL,
  `modul` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skills`
--

CREATE TABLE `skills` (
  `id_skill` int(11) NOT NULL,
  `icona` longblob NOT NULL,
  `tipus_foto` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `tipus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skills_activitats`
--

CREATE TABLE `skills_activitats` (
  `id_skill_activitat` int(11) NOT NULL,
  `id_activitat` int(11) NOT NULL,
  `id_skill_projecte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skills_projectes`
--

CREATE TABLE `skills_projectes` (
  `id_skill_projecte` int(11) NOT NULL,
  `percentatge` int(11) NOT NULL,
  `id_projecte` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuari_actiu_alumne`
--

CREATE TABLE `usuari_actiu_alumne` (
  `id_usuari_actiu_alumne` int(11) NOT NULL,
  `id_alumne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuari_actiu_professor`
--

CREATE TABLE `usuari_actiu_professor` (
  `id_usuari_actiu_professor` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL
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
-- Indices de la tabla `alumnes_projectes`
--
ALTER TABLE `alumnes_projectes`
  ADD PRIMARY KEY (`id_alumne_projecte`),
  ADD KEY `alumne_projecte_id_alumne_fr` (`id_alumne`),
  ADD KEY `alumne_projecte_id_projecte_fr` (`id_projecte`);

--
-- Indices de la tabla `nota_skill_act_alumne`
--
ALTER TABLE `nota_skill_act_alumne`
  ADD PRIMARY KEY (`id_nota_skill_act_alumne`),
  ADD KEY `nota_skill_act_alumne_fr` (`id_skill_activitat`),
  ADD KEY `nota_alumne_skill_act_fr` (`id_alumne`);

--
-- Indices de la tabla `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`id_professor`);

--
-- Indices de la tabla `professors_projectes`
--
ALTER TABLE `professors_projectes`
  ADD PRIMARY KEY (`id_professor_projecte`),
  ADD KEY `professors_projectes_id_professor_fr` (`id_professor`),
  ADD KEY `professors_projectes_id_projecte_fr` (`id_projecte`);

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
-- Indices de la tabla `skills_activitats`
--
ALTER TABLE `skills_activitats`
  ADD PRIMARY KEY (`id_skill_activitat`),
  ADD KEY `skills_activitats_id_activitat_fr` (`id_activitat`),
  ADD KEY `skills_activitats_id_skill_projecte_fr` (`id_skill_projecte`);

--
-- Indices de la tabla `skills_projectes`
--
ALTER TABLE `skills_projectes`
  ADD PRIMARY KEY (`id_skill_projecte`),
  ADD KEY `skills_projectes_id_projecte_fr` (`id_projecte`),
  ADD KEY `skills_projectes_id_skill_fr` (`id_skill`);

--
-- Indices de la tabla `usuari_actiu_alumne`
--
ALTER TABLE `usuari_actiu_alumne`
  ADD PRIMARY KEY (`id_usuari_actiu_alumne`),
  ADD KEY `usuari_actiu_id_alumne_fr` (`id_alumne`);

--
-- Indices de la tabla `usuari_actiu_professor`
--
ALTER TABLE `usuari_actiu_professor`
  ADD PRIMARY KEY (`id_usuari_actiu_professor`),
  ADD KEY `usuari_actiu_id_professor_fr` (`id_professor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activitats`
--
ALTER TABLE `activitats`
  MODIFY `id_activitat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `alumnes`
--
ALTER TABLE `alumnes`
  MODIFY `id_alumne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT de la tabla `alumnes_projectes`
--
ALTER TABLE `alumnes_projectes`
  MODIFY `id_alumne_projecte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `nota_skill_act_alumne`
--
ALTER TABLE `nota_skill_act_alumne`
  MODIFY `id_nota_skill_act_alumne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `professors`
--
ALTER TABLE `professors`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `professors_projectes`
--
ALTER TABLE `professors_projectes`
  MODIFY `id_professor_projecte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `projectes`
--
ALTER TABLE `projectes`
  MODIFY `id_projecte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `skills`
--
ALTER TABLE `skills`
  MODIFY `id_skill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `skills_activitats`
--
ALTER TABLE `skills_activitats`
  MODIFY `id_skill_activitat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `skills_projectes`
--
ALTER TABLE `skills_projectes`
  MODIFY `id_skill_projecte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnes_projectes`
--
ALTER TABLE `alumnes_projectes`
  ADD CONSTRAINT `alumne_projecte_id_alumne_fr` FOREIGN KEY (`id_alumne`) REFERENCES `alumnes` (`id_alumne`),
  ADD CONSTRAINT `alumne_projecte_id_projecte_fr` FOREIGN KEY (`id_projecte`) REFERENCES `projectes` (`id_projecte`);

--
-- Filtros para la tabla `nota_skill_act_alumne`
--
ALTER TABLE `nota_skill_act_alumne`
  ADD CONSTRAINT `nota_alumne_skill_act_fr` FOREIGN KEY (`id_alumne`) REFERENCES `alumnes` (`id_alumne`),
  ADD CONSTRAINT `nota_skill_act_alumne_fr` FOREIGN KEY (`id_skill_activitat`) REFERENCES `skills_activitats` (`id_skill_activitat`);

--
-- Filtros para la tabla `professors_projectes`
--
ALTER TABLE `professors_projectes`
  ADD CONSTRAINT `professors_projectes_id_professor_fr` FOREIGN KEY (`id_professor`) REFERENCES `professors` (`id_professor`),
  ADD CONSTRAINT `professors_projectes_id_projecte_fr` FOREIGN KEY (`id_projecte`) REFERENCES `projectes` (`id_projecte`);

--
-- Filtros para la tabla `skills_activitats`
--
ALTER TABLE `skills_activitats`
  ADD CONSTRAINT `skills_activitats_id_activitat_fr` FOREIGN KEY (`id_activitat`) REFERENCES `activitats` (`id_activitat`),
  ADD CONSTRAINT `skills_activitats_id_skill_projecte_fr` FOREIGN KEY (`id_skill_projecte`) REFERENCES `skills_projectes` (`id_skill_projecte`);

--
-- Filtros para la tabla `skills_projectes`
--
ALTER TABLE `skills_projectes`
  ADD CONSTRAINT `skills_projectes_id_projecte_fr` FOREIGN KEY (`id_projecte`) REFERENCES `projectes` (`id_projecte`),
  ADD CONSTRAINT `skills_projectes_id_skill_fr` FOREIGN KEY (`id_skill`) REFERENCES `skills` (`id_skill`);

--
-- Filtros para la tabla `usuari_actiu_alumne`
--
ALTER TABLE `usuari_actiu_alumne`
  ADD CONSTRAINT `usuari_actiu_id_alumne_fr` FOREIGN KEY (`id_alumne`) REFERENCES `alumnes` (`id_alumne`);

--
-- Filtros para la tabla `usuari_actiu_professor`
--
ALTER TABLE `usuari_actiu_professor`
  ADD CONSTRAINT `usuari_actiu_id_professor_fr` FOREIGN KEY (`id_professor`) REFERENCES `professors` (`id_professor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
