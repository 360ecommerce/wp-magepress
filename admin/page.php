<?php $tab = ( isset( $_GET[ 'tab' ] ) ) ? $_GET['tab'] : 'magento'; ?>

<div class="wrap">
    <h2 class="nav-tab-wrapper">
        <a href="<?php echo admin_url( 'options-general.php?page=magepress' ) ?>" class="nav-tab <?php if($tab == 'magento'): ?>nav-tab-active<?php endif; ?>">
            <?php _e( 'Magento', 'magepress' ) ?>
        </a>
        <a href="<?php echo admin_url( 'options-general.php?page=magepress&tab=api' ) ?>" class="nav-tab <?php if($tab == 'api'): ?>nav-tab-active<?php endif; ?>">
            <?php _e( 'API', 'magepress' ) ?>
        </a>
        <a href="<?php echo admin_url( 'options-general.php?page=magepress&tab=cache' ) ?>" class="nav-tab <?php if($tab == 'cache'): ?>nav-tab-active<?php endif; ?>">
            <?php _e( 'Cache', 'magepress' ) ?>
        </a>
    </h2>

    <div class="metabox-holder">
        <?php 
            switch( $tab ) :
                case 'cache' :
                    include MAGEPRESS_DIR . '/admin/cache.php';
                break;
                case 'api' :
                    include MAGEPRESS_DIR . '/admin/api.php';
                break;
                case 'magento' :
                    include MAGEPRESS_DIR . '/admin/magento.php';
                break;
            endswitch;
        ?>
    </div>
</div>