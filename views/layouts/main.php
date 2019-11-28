<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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

<!--<form action="https://parimatch.co.tz/rest/customer/session/login" method='POST' enctype='application/json'>-->
<!--    <input name='login' value="127746355">-->
<!--    <input name='password' value="Pm12345">-->
<!--    <input type="submit" value="ok">-->
<!--</form>-->
<!--<script>-->
<!--    var myHeaders = new Headers();-->
<!--    myHeaders.append('X-BRAND-DATA', '1');-->
<!--    var xhr = new XMLHttpRequest();-->
<!--    xhr.open("POST", 'https://parimatch.co.tz/rest/customer/session/login', true);-->
<!--    //Передает правильный заголовок в запросе-->
<!--    xhr.setRequestHeader("Content-Type", "application/json");-->
<!--    xhr.setRequestHeader("X-BRAND-DATA", "1");-->
<!--    var data = '{"login":"127746355","password":"Pm12345"}';-->
<!--    xhr.onreadystatechange = function() {//Вызывает функцию при смене состояния.-->
<!--        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {-->
<!--            console.log(JSON.parse(this.response));-->
<!--            // Запрос завершен. Здесь можно обрабатывать результат.-->
<!--        }-->
<!--    }-->
<!--    xhr.send(data);-->
<!--</script>-->
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
