<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h1>Bold</h1>

                <p>
                    <code>Search string: ZieLoNa MiLa|age>30</code>
                </p>
                <?= \app\components\Stats::show_statistics('ZieLoNa MiLa|age>30'); ?>

                <hr>

                <p>
                    <code>Search string: ZiElonA Droga|age<30</code>
                </p>
                <?= \app\components\Stats::show_statistics('ZiElonA Droga|age<30'); ?>

            </div>
        </div>

    </div>
</div>
