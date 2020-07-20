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
                        if (count($blocks)) {
                            /** @var Del\Press\Block\BlockInterface $block */
                            foreach ($blocks as $block) {
                                echo '<div class="panel panel-primary page-block">
                                      <div class="panel-heading">
                                          <button type="button" class="close tt" title="Delete ' . $block->getBlockType() . '" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">' . Icon::REMOVE . '</span></button>
                                          <button type="button" class="sort movedown tt" title="Move down" aria-label="Move down"><span aria-hidden="true">' . Icon::ARROW_DOWN . '</span></button>
                                          <button type="button" class="sort moveup tt" title="Move up" aria-label="Move up"><span aria-hidden="true">' . Icon::ARROW_UP . '</span></button>
                                          <h3 class="panel-title">' . $block->getBlockType() . '</h3>
                                      </div>
                                      <div class="panel-body">';
                                echo $block->renderEditor();
                                echo '</div></div><br>';
                            }
                        } else {
                        ?>
                            <p class="no-blocks-found lead">You haven't added any page blocks yet. Why not add one?</p>
                        <?php } ?>
                    </div>
                    <div id="controls">
                        <select id="blockType" class="form-control" name="" id="">
                            <?php foreach ($blockTypes as $blockType => $label) { ?>
                                <option value="<?= $blockType ?>"><?= $label ?></option>
                            <?php } ?>
                        </select>
                        &nbsp;
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

        function addBlock(html)
        {
            if (hasBlocks()) {
                $('.blocks').append(html);
            } else {
                $('.blocks').html(html);
            }
        }

        function hasBlocks()
        {
            let noBlocksDiv = $('.no-blocks-found');

            if (noBlocksDiv.length) {
                return false;
            }

            return true;
        }

        function updateBlocks()
        {
            $('button.moveup').css('display', 'block');
            $('button.movedown').css('display', 'block');
            $('button.moveup').first().css('display', 'none');
            $('button.movedown').last().css('display', 'none');
        }

        $('#add-new-block').click(function(){
            let value = $('#blockType').val();
            let postId = <?= $postId ?>;
            $.post('/api/cms/add-block/' + postId, {class: value}, function( data ) {
                let html = data.html;
                addBlock(html);
            });
        });

        $('#title').on('keyup', function(){
            let text = $('#title').val();
            $('#blog-title').html(text);
        });

        updateBlocks();
    });
</script>
