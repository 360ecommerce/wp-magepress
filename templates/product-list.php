<div class="magepress-product-list">
    <?php if($type != 'grid'): ?>
        <ol class="products-list">
            <?php foreach( $productcollection as $_product ): ?>
                <div class="product">
                    <div class="product-image">
                        <img src="" name="" title="" alt="" />
                    </div>
                    <div class="product-name">
                        <?php echo $_product['name']; ?>
                    </div>
                    <div class="product-price">

                    </div>
                </div>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <?php $i=0; foreach( $productcollection as $_product ): ?>
            <?php if ($i++%$cols==0): ?>
            <ul class="products-grid">
            <?php endif; ?>
                <li class="item<?php if(($i-1)%$cols==0): ?> first<?php elseif($i%$cols==0): ?> last<?php endif; ?>">
                    <?php echo $_product['name']; ?>
                </li>
            <?php if ($i++%$cols==0 || $i == count($productcollection)): ?>
            </ul>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>