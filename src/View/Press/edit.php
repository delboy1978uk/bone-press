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
                    <a href="/cms" class="btn btn-primary pull-right"><?= Icon::BACKWARD ?> Back</a>
                    <h1>Edit Post</h1>
                    <?= $form ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>

