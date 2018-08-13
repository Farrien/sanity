-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 13 2018 г., 16:10
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
-- Структура таблицы `#custom_table_performers_requests`
--

CREATE TABLE `#custom_table_performers_requests` (
  `id` int(20) NOT NULL,
  `performer_phone` varchar(20) NOT NULL,
  `performer_mail` varchar(128) DEFAULT NULL,
  `performer_name` varchar(64) NOT NULL,
  `performer_secondname` varchar(64) NOT NULL,
  `request_message` text NOT NULL,
  `added_time` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `#custom_table_performers_requests`
--

INSERT INTO `#custom_table_performers_requests` (`id`, `performer_phone`, `performer_mail`, `performer_name`, `performer_secondname`, `request_message`, `added_time`) VALUES
(7, '89869761198', 'g-alb-ert@yandex.ru', 'Albert', 'Shtern', 'Это тестовый запрос. IT-услуги', '1528448631'),
(8, '89174672350', 'chulpan@ya.ru', 'Чулпан', 'Шамсиева', 'Парикмахерское искусство', '1531113239'),
(9, '89377584433', 's-dinar@mail.ru', 'Динар', 'Шамсиев', 'Ремонт телефонов', '1531114239');

-- --------------------------------------------------------

--
-- Структура таблицы `app_script_length_stats`
--

CREATE TABLE `app_script_length_stats` (
  `id` int(20) NOT NULL,
  `s_request` varchar(256) DEFAULT NULL,
  `s_mt` varchar(64) DEFAULT NULL,
  `i_request_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `app_script_length_stats`
--

INSERT INTO `app_script_length_stats` (`id`, `s_request`, `s_mt`, `i_request_time`) VALUES
(1, '/index.php -- ', '1.0390598773956', 1532072455),
(2, '/index.php -- ', '0.96699094772339', 1532870882);

-- --------------------------------------------------------

--
-- Структура таблицы `app_stats`
--

CREATE TABLE `app_stats` (
  `id` int(20) NOT NULL,
  `i_ip` varchar(64) DEFAULT NULL,
  `s_request_script` varchar(128) DEFAULT NULL,
  `s_request_options` varchar(256) DEFAULT NULL,
  `i_request_time` int(11) NOT NULL,
  `i_userid` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(20) NOT NULL,
  `sender_id` int(20) NOT NULL,
  `receiver_hookup` int(20) NOT NULL,
  `msg_type` int(1) NOT NULL DEFAULT '1',
  `vision_flag` int(2) NOT NULL DEFAULT '0',
  `msg_inner` text NOT NULL,
  `msg_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pages_categories`
--

CREATE TABLE `pages_categories` (
  `id` int(20) NOT NULL,
  `category_name` varchar(256) DEFAULT 'Без названия'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pages_content`
--

CREATE TABLE `pages_content` (
  `id` int(20) NOT NULL,
  `page_name` varchar(512) NOT NULL,
  `page_inner` text NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `people`
--

CREATE TABLE `people` (
  `id` int(20) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `pass_updated_time` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `second_name` varchar(64) NOT NULL,
  `permissionGroup` int(2) NOT NULL DEFAULT '0',
  `added_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `people`
--

INSERT INTO `people` (`id`, `login`, `pass`, `pass_updated_time`, `name`, `second_name`, `permissionGroup`, `added_time`) VALUES
(1, '80000000000', '12e8cca497f6ae82de94496b8fe83644', 0, 'Admin', '', 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sanity_apps_table_modules`
--

CREATE TABLE `sanity_apps_table_modules` (
  `id` int(11) NOT NULL,
  `link_name` varchar(128) NOT NULL,
  `module_author` varchar(128) NOT NULL,
  `require_vc` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sanity_apps_table_modules`
--

INSERT INTO `sanity_apps_table_modules` (`id`, `link_name`, `module_author`, `require_vc`) VALUES
(1, 'test', '', 0),
(2, 'account', '', 1),
(3, 'pages', '', 0),
(4, 'newtest', '', 0),
(5, 'subject', '', 1),
(6, 'automat', '', 0),
(7, 'new_sub', '', 0),
(8, 'next', '', 0),
(9, 'undefined_module', 'Farrien', 0),
(10, 'what', 'Farrien', 0),
(11, 'what1', 'Farriesn', 0),
(12, 'what2', 'Farriesn', 0),
(13, 'what3', 'Farriesn', 0),
(14, 'naca', 'Farrien', 0),
(15, 'plazma', 'Farrien', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sanity_prop_apps`
--

CREATE TABLE `sanity_prop_apps` (
  `id` int(20) NOT NULL,
  `app_name` varchar(128) NOT NULL DEFAULT 'Без названия',
  `app_tech_path` varchar(256) DEFAULT NULL,
  `app_icon_img` varchar(128) DEFAULT NULL,
  `sort` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sanity_prop_apps`
--

INSERT INTO `sanity_prop_apps` (`id`, `app_name`, `app_tech_path`, `app_icon_img`, `sort`) VALUES
(1, 'Настройки', 'settings/index', 'ui/Settings-2-icon.png', 0),
(2, 'Pages', 'pages/index', 'ui/promo_form_steps_item_01.png', 0),
(3, 'Управление SMS', 'sms/index', 'ui/sms_icon.png', 0),
(4, 'Пользователи', 'users/search', NULL, 0),
(5, 'Управление хранилищем', 'cloud/index', 'ui/cloud_icon.png', 0),
(6, 'Single Page Builder', NULL, NULL, 0),
(7, 'Почта', NULL, NULL, 0),
(8, 'Файлы', 'files/main', 'ui/icon-files.png', 0),
(9, 'Категории услуг', NULL, NULL, 0),
(10, 'Отзывы', '', NULL, 0),
(11, 'Отчеты об ошибках', NULL, NULL, 0),
(12, 'Статистика', NULL, NULL, 0),
(13, 'Обновления', 'settings/updates', 'ui/updates.png', 0),
(14, 'Расширения', 'modules/main', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_callback_requests`
--

CREATE TABLE `shop_callback_requests` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `client_phone` varchar(20) NOT NULL,
  `ip_addr` varchar(64) NOT NULL DEFAULT '192.0.0.1',
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_callback_requests`
--

INSERT INTO `shop_callback_requests` (`id`, `product_id`, `client_phone`, `ip_addr`, `added_time`) VALUES
(1, 16, '89174672350', '192.0.0.1', 1532083250),
(2, 16, '89999990000', '192.0.0.1', 1532083345),
(3, 16, '89999990000', '192.0.0.1', 1532083369),
(4, 16, '899999190000', '192.0.0.1', 1532083399),
(5, 16, '899999900100', '192.0.0.1', 1532083448),
(6, 16, '89919990000', '192.0.0.1', 1532083467),
(7, 16, '892999190000', '192.0.0.1', 1532083481),
(8, 16, '899992290000', '192.0.0.1', 1532083556),
(9, 16, '89174672350', '127.0.0.1', 1532084194);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_goods`
--

CREATE TABLE `shop_goods` (
  `id` int(20) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `articul` int(20) DEFAULT NULL,
  `quantity` int(4) NOT NULL,
  `stock_status` int(2) NOT NULL DEFAULT '1',
  `category_id` int(20) DEFAULT NULL,
  `cost` decimal(15,2) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `added_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_goods`
--

INSERT INTO `shop_goods` (`id`, `product_name`, `articul`, `quantity`, `stock_status`, `category_id`, `cost`, `cover_image`, `added_time`, `updated_time`) VALUES
(1, 'Шампунь &quot;Trichup&quot; - с кератином 200мл', 8471, 1, 1, 3, '269.00', 'agquNZpbybg.jpg', 0, 0),
(2, 'Шампунь &quot;Trichup&quot; - с кератином 200мл', 8472, 1, 1, 3, '269.00', '7hENNVZQ1-A.jpg', 0, 1533656755),
(3, 'Шампунь &quot;Trichup&quot; - против выпадения волос 200мл', 8463, 10, 1, 3, '269.00', '', 0, 1533656741),
(4, 'Шампунь &quot;Trichup&quot; - против выпадения волос 200мл', 8461, 10, 1, 3, '269.00', '', 0, 1533656729),
(5, 'Жидкое мыло &quot;Silk&quot; - Pearl glow (ОАЭ) 500мл', 8515, 10, 1, 5, '179.00', '', 0, 1533656747),
(6, 'Уригамма &quot;Мойра&quot;', NULL, 0, 1, NULL, '0.00', '', 1533656521, 1533656594);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_product_description`
--

CREATE TABLE `shop_product_description` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_product_reviews`
--

CREATE TABLE `shop_product_reviews` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `owner_id` int(20) DEFAULT NULL,
  `review` text NOT NULL,
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `site_reviews`
--

CREATE TABLE `site_reviews` (
  `id` int(20) NOT NULL,
  `module` int(20) NOT NULL,
  `author_id` int(20) DEFAULT NULL,
  `review_message` text NOT NULL,
  `added_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(20) NOT NULL,
  `subject_name` varchar(128) NOT NULL,
  `parent_subject` int(20) DEFAULT NULL,
  `visible` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `parent_subject`, `visible`) VALUES
(1, 'Косметика', NULL, 1),
(2, 'Уход за лицом', 1, 1),
(3, 'Уход за волосами', 1, 1),
(4, 'Парфюмерия', NULL, 1),
(5, 'Жидкое мыло', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `subjects_dependency`
--

CREATE TABLE `subjects_dependency` (
  `id` int(20) NOT NULL,
  `owner_id` int(20) NOT NULL,
  `subject_id` int(20) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `wallet_history`
--

CREATE TABLE `wallet_history` (
  `id` int(20) NOT NULL,
  `initiator_id` int(20) DEFAULT NULL,
  `target_id` int(20) NOT NULL,
  `change_type` tinyint(1) NOT NULL DEFAULT '0',
  `amount` int(20) UNSIGNED DEFAULT NULL,
  `transaction_comment` text NOT NULL,
  `added_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `wallet_info`
--

CREATE TABLE `wallet_info` (
  `id` int(20) NOT NULL,
  `owner_id` int(20) NOT NULL,
  `amount_cached` int(16) DEFAULT NULL,
  `last_update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `#custom_table_performers_requests`
--
ALTER TABLE `#custom_table_performers_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `app_script_length_stats`
--
ALTER TABLE `app_script_length_stats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `app_stats`
--
ALTER TABLE `app_stats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_hookup` (`receiver_hookup`),
  ADD KEY `vision_flag` (`vision_flag`);

--
-- Индексы таблицы `pages_categories`
--
ALTER TABLE `pages_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `pages_content`
--
ALTER TABLE `pages_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Индексы таблицы `sanity_apps_table_modules`
--
ALTER TABLE `sanity_apps_table_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link_name` (`link_name`);

--
-- Индексы таблицы `sanity_prop_apps`
--
ALTER TABLE `sanity_prop_apps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_name` (`app_name`),
  ADD KEY `app_icon_img` (`app_icon_img`);

--
-- Индексы таблицы `shop_callback_requests`
--
ALTER TABLE `shop_callback_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shop_goods`
--
ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `shop_product_description`
--
ALTER TABLE `shop_product_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `title` (`title`);

--
-- Индексы таблицы `shop_product_reviews`
--
ALTER TABLE `shop_product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `site_reviews`
--
ALTER TABLE `site_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Индексы таблицы `subjects_dependency`
--
ALTER TABLE `subjects_dependency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Индексы таблицы `wallet_history`
--
ALTER TABLE `wallet_history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `wallet_info`
--
ALTER TABLE `wallet_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `#custom_table_performers_requests`
--
ALTER TABLE `#custom_table_performers_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `app_script_length_stats`
--
ALTER TABLE `app_script_length_stats`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `app_stats`
--
ALTER TABLE `app_stats`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pages_categories`
--
ALTER TABLE `pages_categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pages_content`
--
ALTER TABLE `pages_content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `people`
--
ALTER TABLE `people`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `sanity_apps_table_modules`
--
ALTER TABLE `sanity_apps_table_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `sanity_prop_apps`
--
ALTER TABLE `sanity_prop_apps`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `shop_callback_requests`
--
ALTER TABLE `shop_callback_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `shop_goods`
--
ALTER TABLE `shop_goods`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `shop_product_description`
--
ALTER TABLE `shop_product_description`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_product_reviews`
--
ALTER TABLE `shop_product_reviews`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `site_reviews`
--
ALTER TABLE `site_reviews`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `subjects_dependency`
--
ALTER TABLE `subjects_dependency`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wallet_history`
--
ALTER TABLE `wallet_history`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wallet_info`
--
ALTER TABLE `wallet_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `pages_content`
--
ALTER TABLE `pages_content`
  ADD CONSTRAINT `pages_content_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `pages_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_goods`
--
ALTER TABLE `shop_goods`
  ADD CONSTRAINT `shop_goods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_product_reviews`
--
ALTER TABLE `shop_product_reviews`
  ADD CONSTRAINT `shop_product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `shop_goods` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `site_reviews`
--
ALTER TABLE `site_reviews`
  ADD CONSTRAINT `site_reviews_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subjects_dependency`
--
ALTER TABLE `subjects_dependency`
  ADD CONSTRAINT `subjects_dependency_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_dependency_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
