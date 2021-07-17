<?php

use yii\helpers\Html;


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset', 'token' => $token]);
?>
<div class="password-reset">
	Здравствуйте <?=Html::encode($user->username)?>
	<br> Чтобы продолжить процедуру восстановления доступа к аккаунту Вам необходимо сгенерировать новый пароль<br><br> Перейдите по указанной ссылке, чтобы сгенерировать новый пароль:<br>
	<?=Html::a(Html::encode($resetLink), $resetLink)?>
</div>