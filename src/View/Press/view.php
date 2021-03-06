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
                    <?php
                    /** @var \Del\Press\Block\BlockInterface $block */
                    foreach ($blocks as $block) {
                        echo $block->render();
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>

