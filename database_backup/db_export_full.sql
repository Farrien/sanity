-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 12 2018 г., 09:18
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

-- База данных: `sanity_origin`



-- `custom_app_bigd_strings`

CREATE TABLE `custom_app_bigd_strings` (
  `id` int(20) NOT NULL,
  `unique_name` varchar(128) NOT NULL,
  `string_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `#custom_app_bigd_strings`

INSERT INTO `custom_app_bigd_strings` (`id`, `unique_name`, `string_value`) VALUES
(1, 'greetings', 'Hello world!'),
(2, 'welcome_text', 'Welcome!');



-- `app_script_length_stats`

CREATE TABLE `app_script_length_stats` (
  `id` int(20) NOT NULL,
  `s_request` varchar(256) DEFAULT NULL,
  `s_mt` varchar(64) DEFAULT NULL,
  `i_request_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `app_stats`

CREATE TABLE `app_stats` (
  `id` int(20) NOT NULL,
  `i_ip` varchar(64) DEFAULT NULL,
  `s_request_script` varchar(128) DEFAULT NULL,
  `s_request_options` varchar(256) DEFAULT NULL,
  `i_request_time` int(11) NOT NULL,
  `i_userid` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `custom_app_bigd_construction_progress`

CREATE TABLE `custom_app_bigd_construction_progress` (
  `id` int(11) NOT NULL,
  `photo_path` varchar(128) DEFAULT NULL,
  `thumbnail_path` varchar(128) DEFAULT NULL,
  `year` int(4) NOT NULL DEFAULT '2017',
  `month` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `custom_app_bigd_construction_progress`

INSERT INTO `custom_app_bigd_construction_progress` (`id`, `photo_path`, `thumbnail_path`, `year`, `month`) VALUES
(1, '78592b315b7f9f6300ecfa3f78d2864f-v1538723151_.jpg', '78592b315b7f9f6300ecfa3f78d2864f-v1538723151_thumbnail.jpg', 2018, 10),
(2, 'b8e3d00c1640b5c8dd66d5f20f8163e0-v1538657562_.jpg', 'b8e3d00c1640b5c8dd66d5f20f8163e0-v1538657562_thumbnail.jpg', 2018, 10),
(3, 'b094a9caf25d570ade9b17f346095009-v1538657564_.jpg', 'b094a9caf25d570ade9b17f346095009-v1538657564_thumbnail.jpg', 2018, 10),
(4, 'd6e1141be1a3afa0ab94e8790fc76f25-v1538657565_.jpg', 'd6e1141be1a3afa0ab94e8790fc76f25-v1538657565_thumbnail.jpg', 2018, 10),
(5, 'b521bd09bf11373d0a43c40e20146104-v1538728430_.jpg', 'b521bd09bf11373d0a43c40e20146104-v1538728430_thumbnail.jpg', 0, 0),
(6, 'c41435d3175588b62486c924d05cf4c2-v1538728466_.jpg', 'c41435d3175588b62486c924d05cf4c2-v1538728466_thumbnail.jpg', 0, 0),
(7, '15c8196d1a80e3f8f5b377399661410c-v1538728500_.jpg', '15c8196d1a80e3f8f5b377399661410c-v1538728500_thumbnail.jpg', 2018, 1),
(8, 'd2e7ea719518c43e55507634092fea3d-v1538728547_.jpg', 'd2e7ea719518c43e55507634092fea3d-v1538728547_thumbnail.jpg', 2018, 2);



-- `messages`

CREATE TABLE `messages` (
  `id` int(20) NOT NULL,
  `sender_id` int(20) NOT NULL,
  `receiver_hookup` int(20) NOT NULL,
  `msg_type` int(1) NOT NULL DEFAULT '1',
  `vision_flag` int(2) NOT NULL DEFAULT '0',
  `msg_inner` text NOT NULL,
  `msg_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `pages_categories`

CREATE TABLE `pages_categories` (
  `id` int(20) NOT NULL,
  `category_name` varchar(256) DEFAULT 'Без названия'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `pages_content`

CREATE TABLE `pages_content` (
  `id` int(20) NOT NULL,
  `page_name` varchar(512) NOT NULL,
  `page_inner` text NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `people`

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

-- Дамп данных таблицы `people`

INSERT INTO `people` (`id`, `login`, `pass`, `pass_updated_time`, `name`, `second_name`, `permissionGroup`, `added_time`) VALUES
(1, '80000000000', '6becc52ee8703d6b8130b9b7e2046a0c', 1538540657, 'Admin', '', 2, 0);



-- `sanity_apps_table_modules`

CREATE TABLE `sanity_apps_table_modules` (
  `id` int(11) NOT NULL,
  `link_name` varchar(128) NOT NULL,
  `module_author` varchar(128) NOT NULL,
  `require_vc` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `sanity_apps_table_modules`

INSERT INTO `sanity_apps_table_modules` (`id`, `link_name`, `module_author`, `require_vc`) VALUES
(1, 'new_module', 'Farrien', 0),
(2, 'selection', 'The Big D', 0),
(3, 'documents', 'Farrien', 0),
(4, 'apartment', 'Big D', 0),
(5, 'apartments', 'Big D', 0);



-- `sanity_prop_apps`

CREATE TABLE `sanity_prop_apps` (
  `id` int(20) NOT NULL,
  `app_name` varchar(128) NOT NULL DEFAULT 'Без названия',
  `app_tech_path` varchar(256) DEFAULT NULL,
  `app_icon_img` varchar(128) DEFAULT NULL,
  `sort` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `sanity_prop_apps`

INSERT INTO `sanity_prop_apps` (`id`, `app_name`, `app_tech_path`, `app_icon_img`, `sort`) VALUES
(1, 'Настройки', 'settings/index', 'ui/Settings-2-icon.png', -1),
(2, 'Pages', 'pages/index', 'ui/promo_form_steps_item_01.png', -1),
(3, 'Управление SMS', 'sms/index', 'ui/sms_icon.png', -1),
(4, 'Пользователи', 'users/search', NULL, -1),
(5, 'Управление хранилищем', 'cloud/index', 'ui/cloud_icon.png', -1),
(6, 'Товары', 'shop/products', NULL, 0),
(7, 'Почта', NULL, NULL, -1),
(8, 'Файлы', 'files/main', 'ui/icon-files.png', -1),
(9, 'Категории услуг', NULL, NULL, -1),
(10, 'Отзывы', '', NULL, -1),
(11, 'Отчеты об ошибках', NULL, NULL, -1),
(12, 'Статистика', NULL, NULL, -1),
(13, 'Обновления', 'settings/updates', 'ui/updates.png', -1),
(14, 'Расширения', 'modules/main', NULL, 0),
(15, 'Строки', 'sps/main', NULL, 0),
(16, 'ЖК | Ход строительства', 'bigd/construction', NULL, 0);



-- `shop_callback_requests`

CREATE TABLE `shop_callback_requests` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `client_phone` varchar(20) NOT NULL,
  `ip_addr` varchar(64) NOT NULL DEFAULT '192.0.0.1',
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `shop_callback_requests`

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



-- `shop_goods`

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

-- Дамп данных таблицы `shop_goods`

INSERT INTO `shop_goods` (`id`, `product_name`, `articul`, `quantity`, `stock_status`, `category_id`, `cost`, `cover_image`, `added_time`, `updated_time`) VALUES
(1, 'Шампунь &quot;Trichup&quot; - с кератином 200мл', 8471, 1, 1, 3, '269.00', 'agquNZpbybg.jpg', 0, 0),
(2, 'Шампунь &quot;Trichup&quot; - с кератином 200мл', 8472, 1, 1, 3, '269.00', '7hENNVZQ1-A.jpg', 0, 1533656755),
(3, 'Шампунь &quot;Trichup&quot; - против выпадения волос 200мл', 8463, 10, 1, 3, '269.00', 'LSvtb7cpehw.jpg', 0, 1533656741),
(4, 'Шампунь &quot;Trichup&quot; - против выпадения волос 200мл', 8461, 10, 1, 3, '269.00', 'C5BQzAop4jY.jpg', 0, 1533656729),
(5, 'Жидкое мыло &quot;Silk&quot; - Pearl glow (ОАЭ) 500мл', 8515, 10, 1, 5, '179.00', 'jU0djHrlaJY.jpg', 0, 1533656747),
(6, 'Шампунь Vatika - Black seed (с черным тмином) 200мл', 8547, 1, 1, 3, '220.00', 'd7FPOJN4CXg.jpg', 1533656521, 1538385667),
(7, 'Шампунь &quot;Vatika Lemon and Yoghurt&quot; - против перхоти | Лимон и Йогурт 200мл', 8963, 10, 1, 3, '549.00', 'H11sfBl7LX8.jpg', 1536832163, 0),
(8, 'Жидкое мыло Silk - Cherry Blossom (ОАЭ) 500мл', 8514, 1, 1, 5, '179.00', '37GGnhVvpTI.jpg', 1536835626, 0),
(9, 'Жидкое мыло Silk - Sea minerals (ОАЭ) 500мл', 8511, 1, 1, 5, '179.00', 'FZLf5LJuESc.jpg', 1538313560, 1538385670),
(10, 'Жидкое мыло Silk - Natural Olive (ОАЭ) 500мл', 8516, 1, 1, 5, '179.00', 'nTUK0Rz08Is.jpg', 1538313595, 1538385688),
(11, 'Жидкое мыло Silk - Velvety Peach (ОАЭ) 500мл', 8513, 1, 1, 5, '179.00', 'HAKBbfs6Dks.jpg', 1538313671, 1538385680),
(12, 'Жидкое мыло Silk - Midnight orchid (ОАЭ) 500мл', 8512, 1, 1, 5, '179.00', 'IGJA9PoFmDE.jpg', 1538313685, 1538385672),
(13, 'Шампунь &quot;Trichup&quot; - с черным тмином 200мл', 8462, 15, 1, 3, '269.00', 'K-yb5JuHAFk.jpg', 1538313712, 1539151418),
(14, 'Свободная ячейка', 1, 0, 1, 3, '269.00', '', 1538313767, 0),
(15, NULL, NULL, 0, 1, NULL, '0.00', '', 1538569987, 0),
(16, NULL, NULL, 0, 1, NULL, '0.00', '', 1538569999, 0);



-- `shop_orders`

CREATE TABLE `shop_orders` (
  `id` int(20) NOT NULL,
  `client_id` int(20) DEFAULT NULL,
  `client_phone` varchar(64) DEFAULT NULL,
  `added_time` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `shop_orders`

INSERT INTO `shop_orders` (`id`, `client_id`, `client_phone`, `added_time`) VALUES
(1, 1, '', 0),
(2, 1, NULL, 1538552487),
(3, 1, NULL, 10000),
(4, 1, NULL, 1538552548);



-- `shop_order_product_dependency`

CREATE TABLE `shop_order_product_dependency` (
  `id` int(20) NOT NULL,
  `product_id` int(20) DEFAULT NULL,
  `order_id` int(20) DEFAULT NULL,
  `count` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `shop_order_product_dependency`

INSERT INTO `shop_order_product_dependency` (`id`, `product_id`, `order_id`, `count`) VALUES
(8, 6, 4, 2),
(9, 12, 4, 1),
(10, 12, 1, 1);



-- `shop_product_description`

CREATE TABLE `shop_product_description` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `shop_product_reviews`

CREATE TABLE `shop_product_reviews` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `owner_id` int(20) DEFAULT NULL,
  `review` text NOT NULL,
  `added_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `shop_product_reviews`

INSERT INTO `shop_product_reviews` (`id`, `product_id`, `owner_id`, `review`, `added_time`) VALUES
(1, 1, 1, '', 100000);



-- `site_reviews`

CREATE TABLE `site_reviews` (
  `id` int(20) NOT NULL,
  `module` int(20) NOT NULL,
  `author_id` int(20) DEFAULT NULL,
  `review_message` text NOT NULL,
  `added_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `subjects`

CREATE TABLE `subjects` (
  `id` int(20) NOT NULL,
  `subject_name` varchar(128) NOT NULL,
  `parent_subject` int(20) DEFAULT NULL,
  `visible` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `subjects`

INSERT INTO `subjects` (`id`, `subject_name`, `parent_subject`, `visible`) VALUES
(1, 'Косметика', NULL, 1),
(2, 'Уход за лицом', 1, 1),
(3, 'Уход за волосами', 1, 1),
(4, 'Парфюмерия', NULL, 1),
(5, 'Жидкое мыло', NULL, 1);



-- `subjects_dependency`

CREATE TABLE `subjects_dependency` (
  `id` int(20) NOT NULL,
  `owner_id` int(20) NOT NULL,
  `subject_id` int(20) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `wallet_history`

CREATE TABLE `wallet_history` (
  `id` int(20) NOT NULL,
  `initiator_id` int(20) DEFAULT NULL,
  `target_id` int(20) NOT NULL,
  `change_type` tinyint(1) NOT NULL DEFAULT '0',
  `amount` int(20) UNSIGNED DEFAULT NULL,
  `transaction_comment` text NOT NULL,
  `added_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- `wallet_info`

CREATE TABLE `wallet_info` (
  `id` int(20) NOT NULL,
  `owner_id` int(20) NOT NULL,
  `amount_cached` int(16) DEFAULT NULL,
  `last_update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Индексы сохранённых таблиц

-- `#custom_app_bigd_strings`
ALTER TABLE `#custom_app_bigd_strings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`unique_name`);

-- `app_script_length_stats`
ALTER TABLE `app_script_length_stats`
  ADD PRIMARY KEY (`id`);

-- `app_stats`
ALTER TABLE `app_stats`
  ADD PRIMARY KEY (`id`);

-- `custom_app_bigd_construction_progress`
ALTER TABLE `custom_app_bigd_construction_progress`
  ADD PRIMARY KEY (`id`);

-- `messages`
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_hookup` (`receiver_hookup`),
  ADD KEY `vision_flag` (`vision_flag`);

-- `pages_categories`
ALTER TABLE `pages_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

-- `pages_content`
ALTER TABLE `pages_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

-- `people`
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

-- `sanity_apps_table_modules`
ALTER TABLE `sanity_apps_table_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link_name` (`link_name`);

-- `sanity_prop_apps`
ALTER TABLE `sanity_prop_apps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_name` (`app_name`),
  ADD KEY `app_icon_img` (`app_icon_img`);

-- `shop_callback_requests`
ALTER TABLE `shop_callback_requests`
  ADD PRIMARY KEY (`id`);

-- `shop_goods`
ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

-- `shop_orders`
ALTER TABLE `shop_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client_id`);

-- `shop_order_product_dependency`
ALTER TABLE `shop_order_product_dependency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product_id`),
  ADD KEY `order` (`order_id`);

-- `shop_product_description`
ALTER TABLE `shop_product_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `title` (`title`);

-- `shop_product_reviews`
ALTER TABLE `shop_product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

-- `site_reviews`
ALTER TABLE `site_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `author_id` (`author_id`);

-- `subjects`
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

-- `subjects_dependency`
ALTER TABLE `subjects_dependency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `subject_id` (`subject_id`);

-- `wallet_history`
ALTER TABLE `wallet_history`
  ADD PRIMARY KEY (`id`);

-- `wallet_info`
ALTER TABLE `wallet_info`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT для сохранённых таблиц

-- AUTO_INCREMENT для таблицы `#custom_app_bigd_strings`
ALTER TABLE `#custom_app_bigd_strings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT для таблицы `app_script_length_stats`
ALTER TABLE `app_script_length_stats`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `app_stats`
ALTER TABLE `app_stats`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `custom_app_bigd_construction_progress`
ALTER TABLE `custom_app_bigd_construction_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- AUTO_INCREMENT для таблицы `messages`
ALTER TABLE `messages`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `pages_categories`
ALTER TABLE `pages_categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `pages_content`
ALTER TABLE `pages_content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `people`
ALTER TABLE `people`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT для таблицы `sanity_apps_table_modules`
ALTER TABLE `sanity_apps_table_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT для таблицы `sanity_prop_apps`
ALTER TABLE `sanity_prop_apps`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- AUTO_INCREMENT для таблицы `shop_callback_requests`
ALTER TABLE `shop_callback_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- AUTO_INCREMENT для таблицы `shop_goods`
ALTER TABLE `shop_goods`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- AUTO_INCREMENT для таблицы `shop_orders`
ALTER TABLE `shop_orders`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT для таблицы `shop_order_product_dependency`
ALTER TABLE `shop_order_product_dependency`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- AUTO_INCREMENT для таблицы `shop_product_description`
ALTER TABLE `shop_product_description`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `shop_product_reviews`
ALTER TABLE `shop_product_reviews`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT для таблицы `site_reviews`
ALTER TABLE `site_reviews`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `subjects`
ALTER TABLE `subjects`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT для таблицы `subjects_dependency`
ALTER TABLE `subjects_dependency`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `wallet_history`
ALTER TABLE `wallet_history`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT для таблицы `wallet_info`
ALTER TABLE `wallet_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

-- Ограничения внешнего ключа сохраненных таблиц

-- Ограничения внешнего ключа таблицы `pages_content`
ALTER TABLE `pages_content`
  ADD CONSTRAINT `pages_content_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `pages_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `shop_goods`
ALTER TABLE `shop_goods`
  ADD CONSTRAINT `shop_goods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `shop_orders`
ALTER TABLE `shop_orders`
  ADD CONSTRAINT `shop_orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `shop_order_product_dependency`
ALTER TABLE `shop_order_product_dependency`
  ADD CONSTRAINT `shop_order_product_dependency_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `shop_orders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `shop_order_product_dependency_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `shop_goods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `shop_product_reviews`
ALTER TABLE `shop_product_reviews`
  ADD CONSTRAINT `shop_product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `shop_goods` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `site_reviews`
ALTER TABLE `site_reviews`
  ADD CONSTRAINT `site_reviews_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Ограничения внешнего ключа таблицы `subjects_dependency`
ALTER TABLE `subjects_dependency`
  ADD CONSTRAINT `subjects_dependency_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_dependency_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
