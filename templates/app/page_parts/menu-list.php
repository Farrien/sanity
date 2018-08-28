<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

return [
	'/'					=> [2, 'Главная'],
	'/catalog/'			=> [2, 'Каталог'],
	'/basket/'			=> [2, 'Корзина'],
	'/search/'			=> [2, 'Поиск'],
	'/orders/'			=> [1, 'Мои заказы'],
	'/account/'			=> [1, 'Настройки'],
	'/login/'			=> [0, 'Войти'],
	'/logout/'			=> [1, 'Выйти']
];