<?php
use Del\Icon;
?>
<section class="intro">
    <div class="pt50">
        <div class="container">
            <div class="spacer"></div>
            <?= isset($message) ? $this->alert($message) : null ?>
            <div class="row">
                <div class="col-md-12">
                    <h1><?= $post->getTitle() ;?></h1>

                </div>
            </div>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>

