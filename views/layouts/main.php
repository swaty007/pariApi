<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<section id="pari-match" class="pari-match">
    <div class="pari-match__left">
        <?= Html::img('@web/img/pari_player.png', ['class' => 'pari-match__left--img']); ?>

        <p class="pari-match--main-text">
            We know how an entertainment looks like. Feel the satisfaction of the game.
        </p>
        <h2 class="pari-match__title pari-match__title--left">
            Bet 10,000
        </h2>
        <h2 class="pari-match__title pari-match__title--right">
            get 20,000
        </h2>
        <?= Html::img('@web/img/rectangle.png', ['class' => 'pari-match__left--background']); ?>
    </div>
    <div class="pari-match__right">
        <?= Html::img('@web/img/logo_on_black.svg', ['class' => 'pari-match__logo']); ?>

        <div class="pari-match__form">
            <p class="pari-match__form--text">
                Enter your phone number.
                Enter the verification code that you received via SMS.
            </p>

            <div class="input">
                <div class="input__close">
                    <?= Html::img('@web/img/logo_on_black.svg', ['class' => 'input__close--img']); ?>
                </div>
                <input type="text" class="input__el">
            </div>


<!--            <form method="post" action="https://parimatch.co.tz/rest/customer/session/login" enctype="multipart/form-data">-->
<!--                <input type="hidden" name="login"  value="123223121"/>-->
<!--                <input type="hidden" name="password" value="qwerty123"/>-->
<!---->
<!--                <input type="submit" value="login" />-->
<!--            </form>-->


        </div>
    </div>
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
