<form method="post" action="options.php">
	<?php
    	settings_fields( 'magepress_magento' );
    	do_settings_sections( 'magepress_magento' );
    	submit_button();
    ?>
</form>