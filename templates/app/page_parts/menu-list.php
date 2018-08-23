<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

return [
	'/'					=> [2, 'Главная'],
	'/catalog/'			=> [2, 'Каталог'],
	'/basket/'			=> [2, 'Корзина'],
	'/search/'			=> [2, 'Поиск'],
	'/account/'			=> [1, 'Настройки'],
	'/orders/'			=> [1, 'Мои заказы'],
	'/login/'			=> [0, 'Войти'],
	'/logout/'			=> [1, 'Выйти']
];