<div class="wrap">
	<h2><?php esc_html_e('Import Dealers', 'lanco-distribuidores') ?></h2>
	<form action="" method="POST" enctype="multipart/form-data">
		<p><?php esc_html_e('Select File', 'lanco-distribuidores') ?></p>
		<p><input type="file" name="file" /></p>
		<p><button class="button button-primary">Import File</button></p>
		<input type="hidden" name="action" value="parse" />
	</form>

</div>