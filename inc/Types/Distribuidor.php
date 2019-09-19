<?php

namespace Lanco\Types;

class Distribuidor {

	protected static $_instance;

	const TYPE = 'distribuidor';

	const TAX = 'tipo_distribuidor';

	public static function get_instance() {
		if(self::$_instance === null)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function __construct() {
		$labels = array(
			'name'               => _x( 'Dealers', 'post type general name', 'lanco-distribuidores' ),
			'singular_name'      => _x( 'Dealer', 'post type singular name', 'lanco-distribuidores' ),
			'menu_name'          => _x( 'Dealers', 'admin menu', 'lanco-distribuidores' ),
			'name_admin_bar'     => _x( 'Dealer', 'add new on admin bar', 'lanco-distribuidores' ),
			'add_new'            => _x( 'Add New', 'book', 'lanco-distribuidores' ),
			'add_new_item'       => __( 'Add New Dealer', 'lanco-distribuidores' ),
			'new_item'           => __( 'New Dealer', 'lanco-distribuidores' ),
			'edit_item'          => __( 'Edit Dealer', 'lanco-distribuidores' ),
			'view_item'          => __( 'View Dealer', 'lanco-distribuidores' ),
			'all_items'          => __( 'All Dealers', 'lanco-distribuidores' ),
			'search_items'       => __( 'Search Dealers', 'lanco-distribuidores' ),
			'parent_item_colon'  => __( 'Parent Dealers:', 'lanco-distribuidores' ),
			'not_found'          => __( 'No dealers found.', 'lanco-distribuidores' ),
			'not_found_in_trash' => __( 'No dealers found in Trash.', 'lanco-distribuidores' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => self::TYPE ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'author', 'thumbnail' )
		);

		register_post_type( self::TYPE, $args );

		$this->register_taxonomy();
		$this->register_fields();
	}

	public function register_fields() {
		if(function_exists("register_field_group")){
			register_field_group(array (
				'id' => 'acf_distribuidores',
				'title' => 'Distribuidores',
				'fields' => array (
					array (
						'key' => 'field_59d650833ca23',
						'label' => 'Latitude',
						'name' => 'latitude',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59d650993ca24',
						'label' => 'Longitude',
						'name' => 'longitude',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59d650ad3ca25',
						'label' => 'Address',
						'name' => 'address',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59d650bd3ca26',
						'label' => 'Phone',
						'name' => 'phone',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_dist_country',
						'label' => 'Country',
						'name' => 'country',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_dist_lang',
						'label' => 'Language',
						'name' => 'lang',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => self::TYPE,
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}

		if(function_exists("register_field_group")) {
			register_field_group(array (
				'id' => 'acf_marker',
				'title' => 'Marker',
				'fields' => array (
					array (
						'key' => 'field_59d699bf484ac',
						'label' => 'Marker',
						'name' => 'marker',
						'type' => 'image',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'ef_taxonomy',
							'operator' => '==',
							'value' => self::TAX,
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}


	}

	public function register_taxonomy() {
		$labels = array(
			'name'              => _x( 'Types', 'taxonomy general name', 'lanco-distribuidores' ),
			'singular_name'     => _x( 'Type', 'taxonomy singular name', 'lanco-distribuidores' ),
			'search_items'      => __( 'Search Types', 'lanco-distribuidores' ),
			'all_items'         => __( 'All Types', 'lanco-distribuidores' ),
			'parent_item'       => __( 'Parent Type', 'lanco-distribuidores' ),
			'parent_item_colon' => __( 'Parent Type:', 'lanco-distribuidores' ),
			'edit_item'         => __( 'Edit Type', 'lanco-distribuidores' ),
			'update_item'       => __( 'Update Type', 'lanco-distribuidores' ),
			'add_new_item'      => __( 'Add New Type', 'lanco-distribuidores' ),
			'new_item_name'     => __( 'New Type Name', 'lanco-distribuidores' ),
			'menu_name'         => __( 'Dealer Types', 'lanco-distribuidores' ),
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => self::TAX ),
		);

		register_taxonomy( self::TAX, [ self::TYPE ], $args );
	}

}