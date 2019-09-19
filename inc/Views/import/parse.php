<div class="wrap">

	<?php if(!empty($error)): ?>
		<p><?php echo $error ?></p>
	<?php else: ?>

		<h2><?php esc_html_e('Import Dealers', 'lanco-distribuidores') ?></h2>
		<p>&nbsp;</p>
		<table class="table widefat striped fixed">
			<thead>
				<tr>
					<th>Item</th>
					<th>Nombre</th>
					<th>Lat</th>
					<th>Lng</th>
					<th>Address</th>
					<th>Phone</th>
					<th>Country</th>
					<th>Lang</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($distribuidores as $k => $distribuidor): ?>
				<tr>
					<td><?php echo $k + 1 ?></td>
					<td><?php echo !empty($distribuidor[0]) ? $distribuidor[0] : '' ?></td>
					<td><?php echo !empty($distribuidor[1]) ? $distribuidor[1] : '' ?></td>
					<td><?php echo !empty($distribuidor[2]) ? $distribuidor[2] : '' ?></td>
					<td><?php echo !empty($distribuidor[3]) ? $distribuidor[3] : '' ?></td>
					<td><?php echo !empty($distribuidor[4]) ? $distribuidor[4] : '' ?></td>
					<td><?php echo !empty($distribuidor[5]) ? $distribuidor[5] : '' ?></td>
					<td><?php echo !empty($distribuidor[6]) ? $distribuidor[6] : '' ?></td> 
					<td><?php echo !empty($distribuidor[7]) ? $distribuidor[7] : '' ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<form method="post">
			<p><label for="ignore_first"><input id="ignore_first" type="checkbox" checked name="ignore_first"> Ignorar Primer Linea</label></p>
			<p>Verifique que todos los campos estén completos y concuerden con las columnas</p>
			<p>En caso contrario verifique que el CSV cumpla con la estructura recomendada y vuelva a interntar</p>
			<p><button class="button button-primary">Importar Distribuidores</button> &nbsp; <a class="button" href="edit.php?post_type=distribuidor&page=dealers%2Fimport">Cancelar</a></p>
			<input type="hidden" name="action" value="import"/>
			<input type="hidden" name="file" value="<?php echo $file ?>"/>
		</form>

	<?php endif ?>

</div>