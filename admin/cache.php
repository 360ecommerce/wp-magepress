<?php
	$registry   = get_option( 'magepress_cache_registry' );
	$table      = new Magepress_Cache_Table();
?>

<form id="magepress-cache-table" method="post">
	<?php 
    	$table->prepare_items(); 
    	$table->display(); 
    ?>
</form>