-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 16 2019 г., 17:13
-- Версия сервера: 8.0.12
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `omima_stal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contracts`
--

CREATE TABLE `contracts` (
  `Contract_id` int(4) NOT NULL,
  `Contr_N` int(50) NOT NULL,
  `Stat_1` tinyint(1) NOT NULL DEFAULT '0',
  `DATE` date DEFAULT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Stat_2` tinyint(1) NOT NULL DEFAULT '0',
  `Stat_3` tinyint(1) NOT NULL DEFAULT '0',
  `Cust_id` int(3) NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contracts`
--

INSERT INTO `contracts` (`Contract_id`, `Contr_N`, `Stat_1`, `DATE`, `Link`, `Comments`, `Stat_2`, `Stat_3`, `Cust_id`, `Proj_id`) VALUES
(2, 1483, 0, NULL, 'files/contracts/contract_n3.docx', 'Предварительный вариант договора.', 0, 0, 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `Cust_id` int(3) NOT NULL,
  `Cust_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Cust_tel` varchar(25) NOT NULL,
  `Comments` text NOT NULL,
  `Cont_cust_name` text NOT NULL,
  `E_mail` varchar(50) NOT NULL,
  `Kpp` bigint(50) NOT NULL,
  `OGRN` bigint(50) NOT NULL,
  `Check_acc` bigint(50) NOT NULL,
  `ITN` bigint(50) NOT NULL,
  `Cust_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`Cust_id`, `Cust_name`, `Cust_tel`, `Comments`, `Cont_cust_name`, `E_mail`, `Kpp`, `OGRN`, `Check_acc`, `ITN`, `Cust_address`) VALUES
(1, 'МинСтрой по СПб', '+79999999999', 'Муниципальное учреждение', 'Валерия Анатольевна Пихченко', 'pihchenko@mail.ru', 123456789, 123456789, 123456789, 123456789, 'СПб, Смольный дворец'),
(2, 'ООО Курганы', '+79999999999', 'Партнер', 'Филатова Мария Семеновна', 'info@kurgani.ru', 148398761, 148398761, 148398761, 148398761, 'ЛО, Киевское ш., 15'),
(3, 'ООО Агат', '+79999999999', 'Постоянный заказчик', 'Кирьеченко Алла Семеновна', 'info@agat.ru', 830342528, 830342528, 830342528, 830342528, 'г. Великий Новгород, ул. Марата, 3 ');

-- --------------------------------------------------------

--
-- Структура таблицы `dir_of_dep`
--

CREATE TABLE `dir_of_dep` (
  `Dep_id` int(2) NOT NULL,
  `Dep_name` tinytext NOT NULL,
  `Cont_inf` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dir_of_dep`
--

INSERT INTO `dir_of_dep` (`Dep_id`, `Dep_name`, `Cont_inf`) VALUES
(1, 'Администраторы', 'admin@onimastal.ru'),
(2, 'Генеральная дирекция', 'gen@onimastal.ru'),
(3, 'Отдел расчетов', 'or@onimastal.ru'),
(4, 'Бухгалтерия', 'buh@onimastal.ru'),
(5, 'Дирекция', 'isp@onimastal.ru'),
(6, 'Отдел закупок', 'oz@onimastal.ru'),
(7, 'Конструкторcко-технологический отдел', 'kt@onimastal.ru'),
(8, 'Склад', 'sklad@onimastal.ru'),
(9, 'Производство', 'pr@onimastal.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `dir_of_positions`
--

CREATE TABLE `dir_of_positions` (
  `Pos_id` int(3) NOT NULL,
  `Pos_code` int(5) NOT NULL,
  `Pos_name` tinytext NOT NULL,
  `Comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dir_of_positions`
--

INSERT INTO `dir_of_positions` (`Pos_id`, `Pos_code`, `Pos_name`, `Comments`) VALUES
(1, 20080, 'Администратор системный', 'MYSQL, Apache, php'),
(2, 20541, 'Генеральный директор', 'Ген. директор'),
(3, 27745, 'Экономист по планированию', 'Экономист'),
(4, 20656, 'Главный бухгалтер', 'Бухгалтер'),
(5, 21486, 'Исполнительный директор', 'Исп. директор'),
(6, 24057, 'Менеджер по закупкам', 'Закупки'),
(7, 21009, 'Конструктор-технолог', 'КТ'),
(8, 24912, 'Начальник склада', 'Нач. склада'),
(9, 24841, 'Начальник производства', 'Нач. производства'),
(10, 18549, 'Слесарь по сборке металлоконструкций ', '');

-- --------------------------------------------------------

--
-- Структура таблицы `dir_of_works`
--

CREATE TABLE `dir_of_works` (
  `Work_id` int(3) NOT NULL,
  `Work_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dir_of_works`
--

INSERT INTO `dir_of_works` (`Work_id`, `Work_name`) VALUES
(1, 'Опорные конструкции'),
(2, 'Фундамент для опорных конструкций'),
(3, 'Неразрушаемый контроль');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `TAB_N` int(3) NOT NULL,
  `Surname` tinytext NOT NULL,
  `NAME` tinytext NOT NULL,
  `Pass_s_n` int(4) NOT NULL,
  `Pass_n` int(6) NOT NULL,
  `Pass_inf` text NOT NULL,
  `Sec_name` tinytext NOT NULL,
  `Tel_numb` varchar(25) NOT NULL,
  `Addr` text NOT NULL,
  `Emp_date` date NOT NULL,
  `Dism_date` date DEFAULT NULL,
  `B_date` date NOT NULL,
  `E_mail` varchar(50) NOT NULL,
  `M_t_id` int(3) NOT NULL,
  `Dep_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`TAB_N`, `Surname`, `NAME`, `Pass_s_n`, `Pass_n`, `Pass_inf`, `Sec_name`, `Tel_numb`, `Addr`, `Emp_date`, `Dism_date`, `B_date`, `E_mail`, `M_t_id`, `Dep_id`) VALUES
(1, 'Тихонов', 'Алексей', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Витальевич', '+7(012)3456789', 'Адрес', '2016-01-01', NULL, '1972-01-01', 'tihonov@mail.ru', 1, 1),
(2, 'Белогуров', 'Андрей', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Викторович', '+7(012)3456789', 'Адрес', '2006-01-01', NULL, '1960-01-01', 'belogurov@mail.ru', 2, 2),
(3, 'Коршунов', 'Дмитрий', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Анатольевич', '+7(012)3456789', 'Адрес', '2008-01-01', NULL, '1964-01-01', 'korshunov@mail.ru', 3, 3),
(4, 'Сахно', 'Алла', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Владимировна', '+7(012)3456789', 'Адрес', '2006-01-01', NULL, '1969-01-01', 'sahno@mail.ru', 4, 4),
(5, 'Зимовьев', 'Виктор', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Николаевич', '+7(012)3456789', 'Адрес', '2007-01-01', NULL, '1961-01-01', 'zimovev@mail.ru', 5, 5),
(6, 'Смирнов', 'Виктор', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Семенович', '+7(012)3456789', 'Адрес', '2015-01-01', NULL, '1979-01-01', 'smirnov@mail.ru', 6, 6),
(7, 'Титов', 'Ярослав', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Владиславович', '+7(012)3456789', 'Адрес', '2012-01-01', NULL, '1969-01-01', 'titov@mail.ru', 7, 7),
(8, 'Урманов', 'Сергей', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Константинович', '+7(012)3456789', 'Адрес', '2011-01-01', NULL, '1964-01-01', 'urmanov@mail.ru', 8, 8),
(9, 'Тимашев', 'Виталий', 1230, 123456, 'ТП № ОТДЕЛА УФМС РОССИИ РАЙОНА ПО ГОРОДУ', 'Сергеевич', '+7(012)3456789', 'Адрес', '2006-01-01', NULL, '1969-01-01', 'timashev@mail.ru', 9, 9),
(10, 'Тест', 'Тест', 9988, 998877, 'Тест', 'Тест', '+77776665544', 'Тест', '2019-05-16', '2019-05-16', '2001-05-16', 'test@test.test', 10, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE `equipment` (
  `Equip_id` int(4) NOT NULL,
  `Equip_name` text NOT NULL,
  `Location` tinytext NOT NULL,
  `Dat_st_exp` date NOT NULL,
  `Tem_of_exp` tinytext NOT NULL,
  `Serial_N` varchar(50) NOT NULL,
  `Cost` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `equipment`
--

INSERT INTO `equipment` (`Equip_id`, `Equip_name`, `Location`, `Dat_st_exp`, `Tem_of_exp`, `Serial_N`, `Cost`) VALUES
(1, 'MCLaser 1325V metal', 'Цех 1 - Площадка 1A', '2015-01-01', 'Лазерная трубка 8000-12000 часов, 18 месяцев гарантия', 'MCL13250101113', 1150000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `equip_for_proj`
--

CREATE TABLE `equip_for_proj` (
  `Eq_proj_id` int(2) NOT NULL,
  `Comments` text NOT NULL,
  `Proj_id` int(3) NOT NULL,
  `Equip_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `konstr_doc`
--

CREATE TABLE `konstr_doc` (
  `Konstr_doc_id` int(4) NOT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Prov_id` int(3) NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `manning_table`
--

CREATE TABLE `manning_table` (
  `M_t_id` int(3) NOT NULL,
  `Numb_of_b` int(2) NOT NULL,
  `Salary` float(9,2) NOT NULL,
  `Comments` text NOT NULL,
  `Pos_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `manning_table`
--

INSERT INTO `manning_table` (`M_t_id`, `Numb_of_b`, `Salary`, `Comments`, `Pos_id`) VALUES
(1, 1, 35000.00, 'Срочный договор', 1),
(2, 1, 150000.00, 'Учредитель', 2),
(3, 1, 45000.00, 'Расчеты', 3),
(4, 1, 100000.00, 'Глав. бух', 4),
(5, 1, 110000.00, 'Исполнительный директор', 5),
(6, 1, 50000.00, 'Срочный договор', 6),
(7, 1, 85000.00, 'Конструктор-технолог', 7),
(8, 1, 70000.00, '', 8),
(9, 1, 90000.00, 'Нач. производства', 9),
(10, 2, 50000.00, '', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `mater_for_proj`
--

CREATE TABLE `mater_for_proj` (
  `Mat_proj_id` int(4) NOT NULL,
  `Numb` int(6) NOT NULL,
  `Comments` text NOT NULL,
  `S_section` varchar(6) NOT NULL,
  `Arr_date` date NOT NULL,
  `Del_date` date NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `Proj_id` int(3) NOT NULL,
  `Stat_1` tinyint(1) NOT NULL DEFAULT '0',
  `Comments` text NOT NULL,
  `Stat_2` tinyint(1) NOT NULL DEFAULT '0',
  `Cust_id` int(3) NOT NULL,
  `Work_id` int(3) NOT NULL,
  `Dep_id` int(2) NOT NULL DEFAULT '2',
  `Start_date` date DEFAULT NULL,
  `End_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`Proj_id`, `Stat_1`, `Comments`, `Stat_2`, `Cust_id`, `Work_id`, `Dep_id`, `Start_date`, `End_date`) VALUES
(1, 1, '', 0, 2, 3, 2, '2019-05-06', '2019-05-11'),
(2, 1, 'Срочный заказ', 0, 1, 1, 2, '2019-05-07', '2019-05-10'),
(3, 0, 'Пробный', 0, 3, 2, 2, '2019-05-08', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `project_stages`
--

CREATE TABLE `project_stages` (
  `Stage_id` int(2) NOT NULL,
  `Proj_id` int(3) NOT NULL,
  `F_date_SM` date DEFAULT NULL,
  `P_date_SM` date DEFAULT NULL,
  `Stat_1` tinyint(1) NOT NULL DEFAULT '0',
  `F_date_ZM` date DEFAULT NULL,
  `P_date_ZM` date DEFAULT NULL,
  `Stat_2` tinyint(1) NOT NULL DEFAULT '0',
  `F_date_KTR` date DEFAULT NULL,
  `P_date_KTR` date DEFAULT NULL,
  `Stat_3` tinyint(1) NOT NULL DEFAULT '0',
  `F_date_PR` date DEFAULT NULL,
  `P_date_PR` date DEFAULT NULL,
  `Stat_4` tinyint(1) NOT NULL DEFAULT '0',
  `F_date_OZ` date DEFAULT NULL,
  `P_date_OZ` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `project_stages`
--

INSERT INTO `project_stages` (`Stage_id`, `Proj_id`, `F_date_SM`, `P_date_SM`, `Stat_1`, `F_date_ZM`, `P_date_ZM`, `Stat_2`, `F_date_KTR`, `P_date_KTR`, `Stat_3`, `F_date_PR`, `P_date_PR`, `Stat_4`, `F_date_OZ`, `P_date_OZ`) VALUES
(1, 1, '2019-05-11', '2019-05-12', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL),
(2, 2, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL),
(3, 3, NULL, '2019-05-17', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE `providers` (
  `Prov_id` int(3) NOT NULL,
  `Prov_name` tinytext NOT NULL,
  `Addr` text NOT NULL,
  `Prov_tel` varchar(25) NOT NULL,
  `Comments` text NOT NULL,
  `Contr_prov_name` text NOT NULL,
  `E_mail` varchar(50) NOT NULL,
  `Kpp` int(50) NOT NULL,
  `OGRN` int(50) NOT NULL,
  `Check_acc` int(50) NOT NULL,
  `ITN` int(50) NOT NULL,
  `Work_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pr_contract_docs`
--

CREATE TABLE `pr_contract_docs` (
  `Pr_doc_id` int(6) NOT NULL,
  `TYPE` tinytext NOT NULL,
  `Pr_doc_date` date DEFAULT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pr_contract_docs`
--

INSERT INTO `pr_contract_docs` (`Pr_doc_id`, `TYPE`, `Pr_doc_date`, `Link`, `Comments`, `Proj_id`) VALUES
(1, 'plan', NULL, 'files/plans/plan_n3.doc', 'Исправить', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `specifications`
--

CREATE TABLE `specifications` (
  `Spec_id` int(6) NOT NULL,
  `Spec_date` date NOT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `supplies`
--

CREATE TABLE `supplies` (
  `Supp_id` int(5) NOT NULL,
  `Stat_1` tinyint(4) DEFAULT NULL,
  `Stat_2` tinyint(4) DEFAULT NULL,
  `Stat_3` tinyint(4) DEFAULT NULL,
  `Numb` int(10) NOT NULL,
  `Comments` text NOT NULL,
  `Link` text NOT NULL,
  `Stat_4` int(1) DEFAULT NULL,
  `Proj_id` int(3) NOT NULL,
  `Prov_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `techn_doc`
--

CREATE TABLE `techn_doc` (
  `Techn_doc_id` int(4) NOT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tech_doc`
--

CREATE TABLE `tech_doc` (
  `Tech_doc_id` int(4) NOT NULL,
  `Link` text NOT NULL,
  `Comments` text NOT NULL,
  `Type_doc` tinytext,
  `Proj_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tech_doc`
--

INSERT INTO `tech_doc` (`Tech_doc_id`, `Link`, `Comments`, `Type_doc`, `Proj_id`) VALUES
(1, 'files/techichic_docs/tech_doc_n1.pdf', 'Для конструкторских работ.', 'Схема детали', 3),
(2, 'files/techichic_docs/tech_doc_n2.docx', 'Техническое задание.', 'ТЗ', 3),
(3, 'files/techichic_docs/tech_doc_n3.png', 'Для удаления', 'Удали меня', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `User_id` int(2) NOT NULL,
  `Login` varchar(16) NOT NULL,
  `Pass` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Interface` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TAB_N` int(3) NOT NULL,
  `User_hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`User_id`, `Login`, `Pass`, `Interface`, `TAB_N`, `User_hash`) VALUES
(1, 'admin1', '8b283e8957f744ae5a1a6add05fc354f', 'admin', 1, 'e6594e87c8053c769a1e516e038dc21e'),
(2, 'gen_dir', '975fb5261439322d9739033f832417e2', 'gen_dir', 2, 'd427fce91099820820d620e6957b5cb6'),
(3, 'otdel_rasch', '94e2a8c7f10afdd6e4f680214b34815a', 'otdel_rasch', 3, '085444fa3951533902169f89b9b868d1'),
(4, 'buhgal', '2be82ef3a4b472e6e205da0a597bad0f', 'buhgal', 4, '825c81a17aad353ed098a7a3e48bb6b2'),
(5, 'isp_dir', '4baf868afc8a5386eb9a635b5a357237', 'isp_dir', 5, '16d2fe9153722da54740429ccc4ad624'),
(6, 'otdel_zakupok', '2c2e038e98530c7641d5ec286a4f4142', 'otdel_zakupok', 6, '5660114d77778a1b05a94cf8ce5b39c0'),
(7, 'konstr_tech', 'dc1e41ff2fb110e3ce3b1b81a227d79c', 'konstr_tech', 7, 'c8bce37203002aed5ad3d861c69fad74'),
(8, 'nach_sklada', 'd67dc98ce34c2c9081414a6288a26ebf', 'nach_sklada', 8, '97475f8f5dd8e8ea691f6572f68462da'),
(9, 'nach_proizv', 'be31f639c2a599e6b32fd635acc36798', 'nach_proizv', 9, 'ecc6b41c99b35602149df52ea7c67678');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`Contract_id`),
  ADD UNIQUE KEY `Contr_N` (`Contr_N`),
  ADD UNIQUE KEY `Proj_id_2` (`Proj_id`),
  ADD UNIQUE KEY `Cust_id_2` (`Cust_id`),
  ADD KEY `Cust_id` (`Cust_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Cust_id`),
  ADD UNIQUE KEY `ITN` (`ITN`),
  ADD UNIQUE KEY `Check_acc` (`Check_acc`),
  ADD UNIQUE KEY `Cust_name` (`Cust_name`);

--
-- Индексы таблицы `dir_of_dep`
--
ALTER TABLE `dir_of_dep`
  ADD PRIMARY KEY (`Dep_id`);

--
-- Индексы таблицы `dir_of_positions`
--
ALTER TABLE `dir_of_positions`
  ADD PRIMARY KEY (`Pos_id`);

--
-- Индексы таблицы `dir_of_works`
--
ALTER TABLE `dir_of_works`
  ADD PRIMARY KEY (`Work_id`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`TAB_N`),
  ADD KEY `M_t_id` (`M_t_id`),
  ADD KEY `Dep_id` (`Dep_id`);

--
-- Индексы таблицы `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`Equip_id`);

--
-- Индексы таблицы `equip_for_proj`
--
ALTER TABLE `equip_for_proj`
  ADD PRIMARY KEY (`Eq_proj_id`),
  ADD KEY `Equip_id` (`Equip_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `konstr_doc`
--
ALTER TABLE `konstr_doc`
  ADD PRIMARY KEY (`Konstr_doc_id`),
  ADD KEY `Prov_id` (`Prov_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `manning_table`
--
ALTER TABLE `manning_table`
  ADD PRIMARY KEY (`M_t_id`),
  ADD KEY `Pos_id` (`Pos_id`);

--
-- Индексы таблицы `mater_for_proj`
--
ALTER TABLE `mater_for_proj`
  ADD PRIMARY KEY (`Mat_proj_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`Proj_id`),
  ADD KEY `Cust_id` (`Cust_id`),
  ADD KEY `Work_id` (`Work_id`),
  ADD KEY `Dep_id` (`Dep_id`);

--
-- Индексы таблицы `project_stages`
--
ALTER TABLE `project_stages`
  ADD PRIMARY KEY (`Stage_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`Prov_id`),
  ADD UNIQUE KEY `Work_id_2` (`Work_id`),
  ADD UNIQUE KEY `Check_acc` (`Check_acc`),
  ADD KEY `Work_id` (`Work_id`);

--
-- Индексы таблицы `pr_contract_docs`
--
ALTER TABLE `pr_contract_docs`
  ADD PRIMARY KEY (`Pr_doc_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `specifications`
--
ALTER TABLE `specifications`
  ADD PRIMARY KEY (`Spec_id`),
  ADD UNIQUE KEY `Proj_id_2` (`Proj_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`Supp_id`),
  ADD KEY `Prov_id` (`Prov_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `techn_doc`
--
ALTER TABLE `techn_doc`
  ADD PRIMARY KEY (`Techn_doc_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `tech_doc`
--
ALTER TABLE `tech_doc`
  ADD PRIMARY KEY (`Tech_doc_id`),
  ADD KEY `Proj_id` (`Proj_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD UNIQUE KEY `Login` (`Login`),
  ADD UNIQUE KEY `TAB_N_2` (`TAB_N`),
  ADD UNIQUE KEY `Pass` (`Pass`),
  ADD KEY `TAB_N` (`TAB_N`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contracts`
--
ALTER TABLE `contracts`
  MODIFY `Contract_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `Cust_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `dir_of_dep`
--
ALTER TABLE `dir_of_dep`
  MODIFY `Dep_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `dir_of_positions`
--
ALTER TABLE `dir_of_positions`
  MODIFY `Pos_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `dir_of_works`
--
ALTER TABLE `dir_of_works`
  MODIFY `Work_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `TAB_N` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `equipment`
--
ALTER TABLE `equipment`
  MODIFY `Equip_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `equip_for_proj`
--
ALTER TABLE `equip_for_proj`
  MODIFY `Eq_proj_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `konstr_doc`
--
ALTER TABLE `konstr_doc`
  MODIFY `Konstr_doc_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `manning_table`
--
ALTER TABLE `manning_table`
  MODIFY `M_t_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mater_for_proj`
--
ALTER TABLE `mater_for_proj`
  MODIFY `Mat_proj_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `Proj_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `project_stages`
--
ALTER TABLE `project_stages`
  MODIFY `Stage_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `providers`
--
ALTER TABLE `providers`
  MODIFY `Prov_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pr_contract_docs`
--
ALTER TABLE `pr_contract_docs`
  MODIFY `Pr_doc_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `specifications`
--
ALTER TABLE `specifications`
  MODIFY `Spec_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `supplies`
--
ALTER TABLE `supplies`
  MODIFY `Supp_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `techn_doc`
--
ALTER TABLE `techn_doc`
  MODIFY `Techn_doc_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tech_doc`
--
ALTER TABLE `tech_doc`
  MODIFY `Tech_doc_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`Cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`M_t_id`) REFERENCES `manning_table` (`m_t_id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`Dep_id`) REFERENCES `dir_of_dep` (`dep_id`);

--
-- Ограничения внешнего ключа таблицы `equip_for_proj`
--
ALTER TABLE `equip_for_proj`
  ADD CONSTRAINT `equip_for_proj_ibfk_1` FOREIGN KEY (`Equip_id`) REFERENCES `equipment` (`equip_id`),
  ADD CONSTRAINT `equip_for_proj_ibfk_2` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `konstr_doc`
--
ALTER TABLE `konstr_doc`
  ADD CONSTRAINT `konstr_doc_ibfk_1` FOREIGN KEY (`Prov_id`) REFERENCES `providers` (`prov_id`),
  ADD CONSTRAINT `konstr_doc_ibfk_2` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `manning_table`
--
ALTER TABLE `manning_table`
  ADD CONSTRAINT `manning_table_ibfk_1` FOREIGN KEY (`Pos_id`) REFERENCES `dir_of_positions` (`pos_id`);

--
-- Ограничения внешнего ключа таблицы `mater_for_proj`
--
ALTER TABLE `mater_for_proj`
  ADD CONSTRAINT `mater_for_proj_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`Cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`Work_id`) REFERENCES `dir_of_works` (`work_id`),
  ADD CONSTRAINT `projects_ibfk_3` FOREIGN KEY (`Dep_id`) REFERENCES `dir_of_dep` (`dep_id`);

--
-- Ограничения внешнего ключа таблицы `project_stages`
--
ALTER TABLE `project_stages`
  ADD CONSTRAINT `project_stages_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_ibfk_1` FOREIGN KEY (`Work_id`) REFERENCES `dir_of_works` (`work_id`);

--
-- Ограничения внешнего ключа таблицы `pr_contract_docs`
--
ALTER TABLE `pr_contract_docs`
  ADD CONSTRAINT `pr_contract_docs_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `specifications`
--
ALTER TABLE `specifications`
  ADD CONSTRAINT `specifications_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `supplies`
--
ALTER TABLE `supplies`
  ADD CONSTRAINT `supplies_ibfk_1` FOREIGN KEY (`Prov_id`) REFERENCES `providers` (`prov_id`),
  ADD CONSTRAINT `supplies_ibfk_2` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `techn_doc`
--
ALTER TABLE `techn_doc`
  ADD CONSTRAINT `techn_doc_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `tech_doc`
--
ALTER TABLE `tech_doc`
  ADD CONSTRAINT `tech_doc_ibfk_1` FOREIGN KEY (`Proj_id`) REFERENCES `projects` (`proj_id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TAB_N`) REFERENCES `employees` (`tab_n`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
