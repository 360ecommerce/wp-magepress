<?php if( ! ( count( $categories ) && count( $categories['children'] ) ) ) : ?>
    <p class="note-msg"><?php _e( 'There are no categories matching the selection.', 'magepress' ) ?></p>
<?php else: ?>
    <div class="magepress-category-list">
        <ol class="category-list">
            <?php foreach( $categories['children'] as $category ): ?>
                <div class="category">
                    <div class="category-image">
                        <img src="" name="" title="" alt="" />
                    </div>
                    <div class="category-name">
                        <?php echo $category['name']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </ol>
    </div>
<?php endif; ?>