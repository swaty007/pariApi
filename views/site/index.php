<?php

/* @var $this yii\web\View */

$this->title = 'Pari Match';

use yii\helpers\Html; ?>

<?php if (empty($user_data)) {
    $user_data = array(
        'userId' => "",
        'number' => "",
        'password' => "",
        'step' => 1
    );
};?>
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
            <div id="step_one" class="pari-match__form pari-match__form--number<?=$user_data['step'] === 1 ? ' pari-match__form--active' : ''; ?>">
                <p class="pari-match__form--text">
                    Enter your phone number.
                </p>
                <div class="input">
                    <div class="input__status"></div>
                    <input id="number_mask" type="tel" class="input__el input__el--tel" />
                    <p class="input__error">
                        You entered an phone number.
                    </p>
                </div>

                <button id="number_send" class="pari-btn pari-btn--number" disabled>NEXT</button>

            </div>
            <div class="pari-match__form pari-match__form--code<?=$user_data['step'] === 2 ? ' pari-match__form--active' : ''; ?>">
                <p class="pari-match__form--text">
                    Enter the verification code that you received via SMS.
                </p>
                <div class="input">
                    <div class="input__status"></div>
                    <input id="code_mask" type="text" class="input__el input__el--code" />
                    <input id="user_id" type="hidden" value="<?= $user_data['userId']; ?>">
                    <input id="user_password" type="hidden" value="<?= $user_data['password']; ?>">
                    <input id="user_number" type="hidden" value="<?= $user_data['number']; ?>">
                    <p class="input__error">
                        You entered an verification code.
                    </p>
                </div>
                <button id="step_back" class="pari-btn pari-btn--back" ></button>
                <button id="code_send" class="pari-btn pari-btn--code" disabled>LOG IN</button>
            </div>
        </div>

    </div>
    <div id="complete" class="complete">
        <div class="complete__container">
            <div class="complete__img--block">
                <?= Html::img('@web/img/icon_ok.svg', ['class' => 'complete__img']); ?>
            </div>
            <p class="pari-match__form--text">
                You are authorized.
            </p>
        </div>
    </div>
</section>