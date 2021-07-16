<?php

use yii\helpers\Html;


$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/activation/', 'token' => $token]);

?>
<div class="verify-email">
	Здравствуйте, <?=Html::encode($user->username)?>!, Вы успешно зарегистрированы.<br><br> Данные Вашего аккаунта:<br>
	<b>Логин</b>: <?=Html::encode($user->username)?><br> <b>Пароль</b>: <?=Html::encode($password)?>
	<br><br> Перейдите по ссылке, чтобы активировать Ваш аккаунт:<br>
	<?=Html::a(Html::encode($verifyLink), $verifyLink)?>
</div>
