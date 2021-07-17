<?php

use yii\helpers\Html;


$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['email', 'token' => $token]);
?>
<div class="verify-email">
	Здравствуйте, <?=Html::encode($user->username)?>!<br> Для завершения процедуры смены адреса электронной почты необходимо пройти по ссылке активации.<br><br>

	Перейдите по ссылке, чтобы сменить адрес электронной почты для Вашего аккаунта:<br>
	<?=Html::a(Html::encode($verifyLink), $verifyLink)?>
</div>
