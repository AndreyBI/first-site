-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 27 2020 г., 16:12
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `******`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles_en`
--

CREATE TABLE `articles_en` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles_en`
--

INSERT INTO `articles_en` (`id`, `title`, `text`) VALUES
(1, '', '<h2 style= \"font-size: 40px; text-align: center; margin: 0px;\" >Who are we?</h2><p id=\"fir-cont-text\"> In response, you will not hear the standard phrase, \"We are a professional team of software developers. We can do either … or".\"\r\n<br>\r\n Certainly, it also applies to us. BUT we are something more than a team \r\n of Software developers. We are a single mechanism. Andrew Carnegie, an American entrepreneur-multimillionaire said, <i> “Teamwork is the ability to work together toward a common vision. The ability to direct individual accomplishments toward organizational objectives. It is the fuel that allows common people to attain uncommon results”. </i></p>'),
(2, '', '<h2 style= \" font-size: 40px; text-align: center; margin: 0px;\">Software Development</h2><p id= \"sec-cont-text\"> We develop software of any complexity according to the Customers\’ requirements, and solve any task set by them as well. For comfortable work with the developed devices, we create user and service SOFTWARE with a user-friendly interface. We ensure continuous and reliable operation of the devices.</p>'),
(3, '', 'Do you want to start a collaboration or get advice?'),
(4, '', 'Leave a request and we will contact you!'),
(5, '', 'The main thing is to take the first step in the right direction'),
(6, '', 'You are using Internet Explorer, some features may not work. We recommend that you switch to browsers such as Opera, Firefox, and Chrome if you are using IE 10 or lower. We apologize for any inconvenience!'),
(7, '', 'You are using Safari, some features may not work. We apologize for any inconvenience!'),
(8, '', 'You are using a browser that is unknown to us and some functions may not work correctly! In case of any problems, please write to the following email address: \'andrey.i.baykalov@gmail.com\''),
(9, '', 'I hereby confirm that I agree to'),
(10, '', 'the processing of personal data'),
(11, '', 'Policy of the limited liability company \"Hybrik\" regarding the processing of personal data'),
(12, '', 'Creator - Andrey Baykalov <a href=\\\"mailto:baykalov.a.i.tt@gmail.com\\\">[baykalov.a.i.tt@gmail.com]</a>'),
(13, '', 'If you find any problems on the site, please contact us by <a href=\\\"mailto:baykalov.a.i.tt@gmail.com\\\">mail</a>');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles_en`
--
ALTER TABLE `articles_en`
  ADD KEY `id` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
