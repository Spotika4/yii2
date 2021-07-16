<?php

use yii\helpers\Html;


$loginLink = Yii::$app->urlManager->createAbsoluteUrl(['login']);
?>
<div class="password-reset">
	Здравствуйте <?=Html::encode($user->username)?>
	<br> Процедура восстановления пароля завершена. С возвращением.<br><br> Данные Вашего аккаунта:<br>
	<b>Логин</b>: <?=Html::encode($user->username)?><br> <b>Пароль</b>: <?=Html::encode($password)?>
	<br><br> Перейдите по ссылке, чтобы авторизоваться:<br>
	<?=Html::a(Html::encode($loginLink), $loginLink)?>
</div>