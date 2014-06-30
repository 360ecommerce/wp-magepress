<?php if( ! count( $products ) ) : ?>
    <p class="note-msg"><?php _e( 'There are no products matching the selection.', 'magepress' ) ?></p>
<?php else: ?>
    <div class="magepress-product-list">
        <?php if($type != 'grid'): ?>
            <ol class="products-list">
                <?php foreach( $products as $product ): ?>
                    <div class="product">
                        <div class="product-image">
                            <img src="" name="" title="" alt="" />
                        </div>
                        <div class="product-name">
                            <?php echo $product['name']; ?>
                        </div>
                        <div class="product-price">

                        </div>
                    </div>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            <?php $i=0; foreach( $products as $product ): ?>
                <?php if ($i++%$cols==0): ?>
                <ul class="products-grid">
                <?php endif; ?>
                    <li class="item<?php if(($i-1)%$cols==0): ?> first<?php elseif($i%$cols==0): ?> last<?php endif; ?>">
                        <?php echo $product['name']; ?>
                    </li>
                <?php if ($i++%$cols==0 || $i == count($products)): ?>
                </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>