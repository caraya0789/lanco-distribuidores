<?php

namespace Lanco;

class Distribuidores {

	protected static $_instance;

	public static function get_instance() {
		if(self::$_instance === null)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function hooks() {
		add_action( 'init', [$this, 'init'] );
		add_action( 'admin_menu', [$this, 'routes'] );
		add_action( 'save_post_distribuidor', [$this, 'delete_cache'] );
	}

	public function init() {
		$this->distribuidorPostType = Types\Distribuidor::get_instance();
		$this->rest_routes();
	}

	public function routes() {
		$this->importController = Controllers\Import::get_instance();
		add_submenu_page( 'edit.php?post_type='.Types\Distribuidor::TYPE, 'Import Dealears', 'Import', 'manage_options', 'dealers/import', [ $this->importController, 'index' ] );
	}

	public function rest_routes() {
		$this->restController = Controllers\Rest::get_instance();
		
		add_action( 'wp_ajax_lanco_dealers', [$this->restController, 'dealers'] );
		add_action( 'wp_ajax_nopriv_lanco_dealers', [$this->restController, 'dealers'] );
	}

	public function delete_cache() {
		if ( wp_is_post_revision( $post_id ) )
			return;
		
		$cache_file_en = LANDIST_PATH . '/cache/dealers-en.json';
		$cache_file_es = LANDIST_PATH . '/cache/dealers-es.json';

		if(file_exists($cache_file_en))
			unlink($cache_file_en);
		
		if(file_exists($cache_file_es))
			unlink($cache_file_es);
	}

}