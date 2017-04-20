-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 20 2017 г., 12:18
-- Версия сервера: 5.5.50
-- Версия PHP: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `itua`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_reg` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `name`, `mail`, `message`, `date_reg`) VALUES
(1, 'testlogin1', 'test name one', 'test1@gmail.com', 'test name1test name1test name1test name1test name1test name1test name1test name1', '2017-04-15'),
(2, 'testlogin2', 'test name two', 'test2@gmail.com', 'test name two test name two test name two test name two test name two test name two test name two test name two', '2017-04-10'),
(3, 'testlogin3', 'test name three', 'test3@gmail.com', 'test name three test name three test name three test name three test name three test name three test name three', '2017-04-20'),
(8, 'pnechushkin', 'Павел', 'pnechushkin@gmail.com', 'Добрый день!\nДамп базы находиться в папке загруженных файлов. Буду благодарен за любую обобранную связь.\ne-mail: pnechushkin@gmail.com тел 093-213-15-35', '2017-04-20');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
