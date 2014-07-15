<form method="post" action="options.php">
	<?php
    	settings_fields( 'magepress_api' );
    	do_settings_sections( 'magepress_api' );
    	submit_button();
    ?>
</form>