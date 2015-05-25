-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 17 ott, 2014 at 11:28 AM
-- Versione MySQL: 5.1.30
-- Versione PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ardudisplay`
--
CREATE DATABASE `ardudisplay` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `ardudisplay`;

-- --------------------------------------------------------

--
-- Struttura della tabella `frasi`
--

CREATE TABLE IF NOT EXISTS `frasi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Frase` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Stato` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Struttura della tabella `impostazioni`
--

CREATE TABLE IF NOT EXISTS `impostazioni` (
  `Password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DurataFraseDisplay` tinyint(4) NOT NULL,
  `ApprovaFrasi` tinyint(4) NOT NULL,
  `FraseDefault` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VelocitaScroll` tinyint(4) NOT NULL,
  `CicloFrasi` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dump dei dati per la tabella `impostazioni`
--

INSERT INTO `impostazioni` (`Password`, `DurataFraseDisplay`, `ApprovaFrasi`, `FraseDefault`, `VelocitaScroll`) VALUES
('admin', 20, 1, 'Connettiti alla rete ''ArduDisplay'' per inviare messaggi!', 50);
