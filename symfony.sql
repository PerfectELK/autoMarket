-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 31 2019 г., 17:16
-- Версия сервера: 5.7.20
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
-- База данных: `symfony`
--

-- --------------------------------------------------------

--
-- Структура таблицы `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `type` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `fuel` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `load_capacity` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_seats` int(11) DEFAULT NULL,
  `master` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `car`
--

INSERT INTO `car` (`id`, `title`, `price`, `type`, `fuel`, `active`, `load_capacity`, `number_of_seats`, `master`, `img`) VALUES
(13, 'lada', 500, '0', '95', 1, '0', 0, 5, '/resources/upload/29.01.2019/A80FCHzUsWLcMu0kbDo6zPlcF1548767395.jpg'),
(14, 'Kalina', 560, '1', '80', 1, '40', NULL, 5, '/resources/upload/29.01.2019/LXMQHu7Z41aWgVkG0rQK3oFhk1548778826.jpg'),
(15, 'ferrarii', 10000, '1', '80', 1, '50', NULL, 3, '/resources/upload/29.01.2019/Ucm2qfA76Xt0fL52PJfOaxzT11548779971.jpg'),
(16, 'hummer', 300, '1', 'ДТ', 1, '400т', NULL, 5, '/resources/upload/29.01.2019/d5qjj1WGKGgc9BLnTyL99TecX1548781424.jpg'),
(17, 'Большай цена', 6666, '0', '95', 1, NULL, 4, 5, '/resources/upload/29.01.2019/SApaVI26qir84ywcvZDO7BvLl1548789881.jpg'),
(18, 'тест 3', 1000000000, '0', '95', 1, '0', 5, 4, '/resources/upload/30.01.2019/51zQVTdazxW7F44KS3Kh2rd141548871982.jpg'),
(19, 'тест', 500000, '0', '95', 0, '0', 5, 5, '/resources/upload/31.01.2019/xLmlu5ZxD8GYXCSHkZBJoHSXY1548936202.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passport` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `driver_num` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `customer`
--

INSERT INTO `customer` (`id`, `name`, `phone`, `type`, `passport`, `driver_num`) VALUES
(1, 'ffff', '7777777', 'tenant', 'fff', 'fffff'),
(2, 'Лосев Андр', '923583509', 'tenant', '38345', '329085'),
(3, 'лол кек чебурек', '999999', 'master', '99999', '88888'),
(4, 'ацулац', '334536436', 'master', '325423оза4ь30', 'ла0342шкела2'),
(5, 'Лосев андрей Викторович', '89103099760', 'master', '5415365110', '3499п2994'),
(6, 'kek', '999999999', 'tenant', 'lol', 'arbidol'),
(7, 'Лол кек чебурек', '3299032525', 'tenant', '540933333', '20-3592-');

-- --------------------------------------------------------

--
-- Структура таблицы `rent`
--

CREATE TABLE `rent` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `beging_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `profit` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `rent`
--

INSERT INTO `rent` (`id`, `car_id`, `beging_time`, `end_time`, `price`, `profit`) VALUES
(1, 13, 1549116000, 1549209600, 500, NULL),
(2, 13, 1551992400, 1552114800, 600, NULL),
(3, 13, 1547740800, 1547740999, 700, 35),
(4, 13, 1548882000, 1548885600, 500, 42),
(5, 13, 1548907140, 1548918060, 500, 129),
(8, 16, 1548882000, 1548885600, 400, 42),
(9, 13, 1546290000, 1546462800, 500, 600),
(10, 16, 1546462800, 1547067600, 50000, 2500);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `rent`
--
ALTER TABLE `rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
