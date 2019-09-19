<?php

namespace Lanco\Controllers;

use Lanco\Types\Distribuidor;

class Import {

	protected static $_instance;

	public static function get_instance() {
		if(self::$_instance === null)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function index() {
		if(!empty($_POST)) {
			switch($_POST['action']) {
				case 'parse':
					return $this->parse();
				case 'import':
					return $this->import();
			}
		}
		include LANDIST_PATH . '/inc/Views/import/index.php';
	}

	public function parse() {
		$errors = '';
		if($_FILES['file']['type'] !== 'text/csv') {
			$error = 'El Archivo no es un csv válido';
			include LANDIST_PATH . '/inc/Views/import/parse.php';
			return;
		}

		if ( ! function_exists( 'wp_handle_upload' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$file = $_FILES['file'];
		$overrides = array( 'test_form' => false );
		$movedfile = wp_handle_upload( $file, $overrides );

		if ( !$movedfile || isset( $movedfile['error'] ) ) {
			$error = $movedfile['error'];
			include LANDIST_PATH . '/inc/Views/import/parse.php';
			return;
		}

		if ( $movedfile['type'] !== 'text/csv' ) {
			unlink( $movedfile['file'] );
			$error = 'El Archivo no es un csv válido';
			include LANDIST_PATH . '/inc/Views/import/parse.php';
			return;
		}

		$distribuidores = $this->_parseCSV( $movedfile['file'] );
		$file = $movedfile['file'];

		// include EFA_PATH . 'views/distribuidores/list.php';
		include LANDIST_PATH . '/inc/Views/import/parse.php';
	}

	protected function _parseCSV( $file ) {
		$distribuidores = array();
		if (($handle = fopen($file, "r")) !== FALSE) {
		    while (($row = fgetcsv($handle)) !== FALSE) {
		    	if(empty($row[2])) {
		    		$loc = explode(',', $row[1]);
		    		if(count($loc) > 1) {
		    			$row[1] = $loc[0];
		    			$row[2] = $loc[1];
		    		}
		    	}
		        $distribuidores[] = $row;
		    }
		    fclose($handle);
		}

		return $distribuidores;
	}

	public function import() {
		$distribuidores = $this->_parseCSV( $_POST['file'] );

		$fields = array(
			'title' => 0,
			'lat' => 1,
			'lng' => 2,
			'address' => 3,
			'phone' => 4,
			'country' => 5,
			'lang' => 6,
			'type' => 7,
		);

		echo '<pre>';

		foreach($distribuidores as $k => $distribuidor) {
			if( isset($_POST['ignore_first']) && $k == 0 )
				continue;

			if(trim($distribuidor[$fields['lang']]) == 'en')
				continue;

			$post = get_posts([
				'post_type' => Distribuidor::TYPE,
				'title' => ucwords(strtolower($distribuidor[$fields['title']])),
				'meta_query' => [
					[
						'key' => 'country',
						'value' => trim($distribuidor[$fields['country']])
					],
					[
						'key' => 'lang',
						'value' => trim($distribuidor[$fields['lang']])
					]
				]
			]);

			if(count($post) > 0)
				continue;

			// Localidad 1
			$type = get_terms( array(
				'name' => ucwords(strtolower($distribuidor[$fields['type']])),
				'taxonomy' => Distribuidor::TAX,
				'parent' => 0,
				'hide_empty' => false
			) );

			if(count($type) === 0) {
				$type = (object) wp_insert_term( ucwords(strtolower($distribuidor[$fields['type']])), Distribuidor::TAX );
			} else {
				$type = current($type);
			}		

			$new_distribuidor = wp_insert_post( array(
				'ID' => 0,
				'post_title' => ucwords(strtolower($distribuidor[$fields['title']])),
				'post_status' => 'publish',
				'post_type' => Distribuidor::TYPE,
				'meta_input' => array(
					'latitude' => trim($distribuidor[$fields['lat']]),
					'longitude' => trim($distribuidor[$fields['lng']]),
					'address' => trim($distribuidor[$fields['address']]),
					'phone' => trim($distribuidor[$fields['phone']]),
					'country' => trim($distribuidor[$fields['country']]),
					'lang' => trim($distribuidor[$fields['lang']])
				)
			) );

			wp_set_object_terms( $new_distribuidor, array($type->term_id), Distribuidor::TAX );
		}

		unlink( $_POST['file'] );

		echo '</pre>';

		die('All Done!');
	}

}