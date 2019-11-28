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

        <div class="pari-match__form__wrap">
            <div class="pari-match__form pari-match__form--number pari-match__form--active">
                <p class="pari-match__form--text">
                    Enter your phone number.
                </p>
                <div class="input">
                    <div class="input__status"></div>
                    <input id="number_mask" type="tel" class="input__el input__el--tel" />
                    <p class="input__error">
                        You entered an verification code.
                    </p>
                </div>

                <button id="number_send" class="pari-btn">NEXT</button>

                <!--            <form method="post" action="https://parimatch.co.tz/rest/customer/session/login" enctype="multipart/form-data">-->
                <!--                <input type="hidden" name="login"  value="123223121"/>-->
                <!--                <input type="hidden" name="password" value="qwerty123"/>-->
                <!---->
                <!--                <input type="submit" value="login" />-->
                <!--            </form>-->

            </div>
            <div class="pari-match__form pari-match__form--code">
                <p class="pari-match__form--text">
                    Enter the verification code that you received via SMS.
                </p>
                <div class="input">
                    <div class="input__status"></div>
                    <input id="code_mask" type="text" class="input__el input__el--code" />
                    <input id="user_id" type="hidden">
                    <input id="user_password" type="hidden">
                    <p class="input__error">
                        You entered an verification code.
                    </p>
                </div>

                <button id="code_send" class="pari-btn">LOG IN</button>
            </div>
        </div>

    </div>
    <div id="complete" class="complete">
        <div class="complete__container">
            <div class="complete__img--block">
                <?= Html::img('@web/img/icon_ok.svg.svg', ['class' => 'complete__img']); ?>
            </div>
            <p class="pari-match__form--text">
                You are authorized.
            </p>
        </div>
    </div>
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
