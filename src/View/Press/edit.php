<?php
use Del\Icon;
/** @var $page \Del\Press\Page\Page */
?>
<section class="intro">
    <div class="pt50">
        <div class="container">
            <div class="spacer"></div>
            <?= isset($message) ? $this->alert($message) : null ?>
            <a href="/cms" class="btn btn-primary pull-right"><?= Icon::BACKWARD ?> Back</a>
            <div class="row">
                <div class="col-md-4">
                    <h1>Edit Post</h1>
                    <?= $form ?>
                </div>
                <div class="col-md-8">
                    <h2 id="blog-title"><?= $page->getTitle() ?></h2>
                    <small>Add and edit page your page blocks below</small>
                    <br>&nbsp;<br>
                    <div class="blocks">
                        <?php
                        if (count($page->getBlocks())) {
                            $blocks = $page->getBlocks();

                            /** @var Del\Press\Block\BlockInterface $block */
                            foreach ($blocks as $block) {
                                echo $block->render();
                            }
                        } else {
                        ?>
                            <p class="no-blocks-found lead">You haven't added any page blocks yet. Why not add one?</p>
                        <?php } ?>
                    </div>
                    <div id="controls">
                        <button id="add-new-block" class="btn btn-primary">
                            <?= Icon::ADD ;?> Add new block
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>
<script type="text/javascript">
    $(document).ready(function(){

        var blockTypes = null;

        $('#add-new-block').click(function(){
            if (blockTypes === null) {
                $.get('/api/cms/get-block-types', function(e) {
                    foreach (e as key => index) {
                        console.log('key is' + key + ' and index is ' + index);
                    }
                });
            } else {
                console.log(blockTypes);
            }
        });

        $('#title').on('keyup', function(){
            let text = $('#title').val();
            $('#blog-title').html(text);
        });
    });
</script>