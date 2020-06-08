<?php
use Del\Icon;
use Del\Press\Page\Page;
?>
<section class="intro">
    <div class="pt50">
        <div class="container">
            <div class="spacer"></div>
            <?= isset($message) ? $this->alert($message) : null ?>
            <div class="row">
                <div class="col-md-12">
                    <h1>Blog Posts</h1>
                    <?php if (count($posts)) { ?>
                        <a href="/cms/new-post" class="btn btn-primary pull-right">
                            <?= Icon::ADD ?> New Post
                        </a>
                        <?= $paginator ;?>
                        <table class="table table-condensed table-striped table-hover table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        <?php
                            /** @var Page $post */
                        foreach ($posts as $post) { ?>
                            <tr>
                                <td><?= $post->getId() ?></td>
                                <td><?= $post->getTitle() ?></td>
                                <td>
                                    <a target="_blank" href="/posts/<?= $post->getSlug() ?>" class="btn btn-sm btn-primary tt" title="view">
                                        <?= Icon::EYE ?>
                                    </a>
                                    <a href="/cms/edit-post/<?= $post->getId() ?>" class="btn btn-sm btn-warning tt" title="edit">
                                        <?= Icon::EDIT ?>
                                    </a>
                                    <a href="/cms/delete-post/<?= $post->getId() ?>" class="btn btn-sm btn-danger tt" title="delete">
                                        <?= Icon::TRASH ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    <?php } else { ?>
                        <p class="lead">No posts have been made. Why not <a href="/cms/new-post">add one</a>?</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="spacer"></div>
<div class="spacer"></div>

