<?php

namespace Lanco\Controllers;

use Lanco\Types\Distribuidor;

class Rest {

	protected static $_instance;

	public static function get_instance() {
		if(self::$_instance === null)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function dealers() {
		$lang = !empty($_GET['lang']) ? $_GET['lang'] : 'es';

		$cache_file = LANDIST_PATH . '/cache/dealers-'.$lang.'.json';

		if(file_exists($cache_file)) {
			return $this->_respond(file_get_contents($cache_file), false);
		}

		global $wpdb;

		$sql = "select 
					p.post_title as title,
					p.ID, 
					pm1.meta_value as latitud,
					pm2.meta_value as longitud,
					pm3.meta_value as phone,
					pm4.meta_value as address,
					pm5.meta_value as country

				from `wp_2_posts` p
					 
					left join `wp_2_postmeta` pm1 on p.ID = pm1.post_id and pm1.meta_key = 'latitude'
					left join `wp_2_postmeta` pm2 on p.ID = pm2.post_id and pm2.meta_key = 'longitude'
					left join `wp_2_postmeta` pm3 on p.ID = pm3.post_id and pm3.meta_key = 'phone'
					left join `wp_2_postmeta` pm4 on p.ID = pm4.post_id and pm4.meta_key = 'address'
					left join `wp_2_postmeta` pm5 on p.ID = pm5.post_id and pm5.meta_key = 'country'

				where p.post_type = 'distribuidor'
					and p.post_status = 'publish';";
					

		$results = $wpdb->get_results($sql);
		
		foreach($results as &$result) {
			$result->type = $this->_getTerm( $result->ID );
			$result->image = get_the_post_thumbnail_url( $result->ID, 'full' );
		}

		file_put_contents($cache_file, json_encode($results));

		return $this->_respond($results);
	}

	protected function _getTerm( $id ) {
		$term = wp_get_object_terms( $id, Distribuidor::TAX );
		if(count($term) == 0)
			return '';

		$term = current($term);
		if(!isset($this->_term_images[$term->term_id])) {
			$this->_term_images[$term->term_id] = get_field( 'marker', Distribuidor::TAX . '-' .$term->term_id );
		}

		return [
			'name' => $this->get_translated($term->name),
			'slug' => $term->slug,
			'image' => $this->_term_images[$term->term_id]
		];

	}

	public function get_translated($label) {
		$label = strtolower(trim($label));

		$labels = [
			'almacenes de distribución' => 'Distribution Warehouses',
			'distribuidores externos' => 'External Distributors',
			'plantas de manufactura' => 'Manufacturing Plants',
			'tiendas retail' => 'Retail Stores'
		];

		if(empty($labels[$label])) {
			return $label;
		}
		return esc_html__($labels[$label], 'paints');
	}

	protected function _respond($object, $encode = true) {
		header('Content-type: Application/json');
		echo $encode ? json_encode($object) : $object; wp_die();
	}

}