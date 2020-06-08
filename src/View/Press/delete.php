<?php
use Del\Icon;
?>
<section class="intro">
    <div class="pt50">
        <div class="container">
            <div class="spacer"></div>
            <?php if (isset($message)) {
                echo $this->alert($message); ?>
                <p class="lead">Post successfully delted.</p>
                <a href="/cms" class="btn btn-success">
                    <?= Icon::BACKWARD ?> Back
                </a>
            <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <h1>Delete Post</h1>
                    <p class="lead">Are you sure you wish to delete this post?</p>
                    <p class="lea"><?= $post->getTitle()?></p>
                    <p><?= $post->getSlug() ?></p>
                    <div class="tc">
                        <a href="/cms" class="btn btn-default btn-pull-left">Cancel</a>
                        <form method="post" action="" class="pull-left">
                            <input type="submit" class="btn btn-danger" value="Delete"/>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>

