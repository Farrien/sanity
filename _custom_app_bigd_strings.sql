-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 24 2018 г., 16:55
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sanity_origin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `#custom_app_bigd_strings`
--

CREATE TABLE `#custom_app_bigd_strings` (
  `id` int(20) NOT NULL,
  `unique_name` varchar(128) NOT NULL,
  `string_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `#custom_app_bigd_strings`
--

INSERT INTO `#custom_app_bigd_strings` (`id`, `unique_name`, `string_value`) VALUES
(1, 'greetings', 'Удобные выступы\r\nСжечь!');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `#custom_app_bigd_strings`
--
ALTER TABLE `#custom_app_bigd_strings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`unique_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `#custom_app_bigd_strings`
--
ALTER TABLE `#custom_app_bigd_strings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
