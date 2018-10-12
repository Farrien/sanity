<?php

use Helper\Users;
use Helper\Userthings;

$PageTitle = $lang['#page_title_account'];

$id = $USER['id'];
$uName = Users::getName($id);
$uLogin = Users::getLogin($id);
$tcons = Userthings::GetPasswordChangeTime($id);
$passwordChangeString = $tcons ? 'Обновлен ' . time_elapsed('@' . $tcons) : 'Никогда не обновлялся';

$userSettings = Users::getPrivateSettings($USER['id']);
