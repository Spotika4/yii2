<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception*/

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">

    <h1 class="display-4 border-bottom mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-warning">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
