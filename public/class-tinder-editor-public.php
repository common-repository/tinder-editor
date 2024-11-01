<?php

/*
    Copyright (C) 2015 WildFireWeb, Inc

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

	Please note that this license contains additional terms according to 
	section 7 of GPL Version 3. Before making any modifications or redistributing 
	this code please review the license additional terms.

    You should have received a copy of the GNU General Public License and the Additional Terms
    along with this program.  If not, see http://wildfireweb.com//tinder-gpl3-license.html

	This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

class Tinder_Editor_Public {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function editable_title($html) {
		global $post;
		
		if ( !is_admin() && in_the_loop() && is_user_logged_in() && current_user_can('edit_posts') ) {
			$html = "<span class='tinder' id='title_{$post->ID}'>".$html."</span>";
		}

		return $html;

	}

	public function editable_content($html) {
		global $post;

		if ( !is_admin() && in_the_loop() && is_user_logged_in() && current_user_can('edit_posts') ) {
		//if ( !is_admin() && (in_the_loop() || (is_page() && is_main_query())) && is_user_logged_in() && current_user_can('edit_posts') ) {
			$html = <<<END
				<div id='tinder_content_{$post->ID}' class='tinder_content_preview'>$html</div>
END;
			
			$settings = array( 'drag_drop_upload' => true );
		
			echo "<div class='tinder_content_edit' style='display:none'>";
			echo "<div class='tinder_message' id='tinder_message_{$post->ID}'></div>";

			wp_editor( $html, 'tinder_'.$post->ID, $settings );

			echo "</div>";
		}
		return $html;

	}

	public function tinder_tinymce_before_init($args) {
		if (!is_admin()) {
		}
		return $args;
	}
 
	public function tinder_tinymce_buttons_2($buttons) {
		if (!is_admin()) {
			array_unshift( $buttons, 'styleselect' );
		}
		return $buttons;
	}
 

	public function tinder_tinymce_buttons_4($buttons) {
		if (!is_admin()) {
			array_push($buttons, 'cancel', 'save', 'tinder');
		}
		return $buttons;
	}
 

	public function tinder_tinymce_javascript($plugin_array) {
		if (!is_admin()) {
			$plugin_array['tinder'] = plugins_url('../tinymce/',__FILE__ ) . 'tinder/plugin.js';
		}

		return $plugin_array;
	}

	public function tinder_admin_bar( $wp_admin_bar ) {

		if (!is_admin()) {
			$args = array(
				'id'    => 'tinder_admin',
				'title' => '<span class="tinder-icon"></span><span class="tinder-name">Tinder&reg;</span>',
				'href'  => '#',
				'meta'  => array( 'onclick' => 'toggleTinder(); return false;','class' => 'tinder-toolbar' )
			);
			$wp_admin_bar->add_node( $args );

		}

	}
	
	public function enqueue_styles() {

		if ( !is_admin() && is_user_logged_in() && current_user_can('edit_posts') ) {
			wp_enqueue_style( 'tinder_editor_public', plugin_dir_url( __FILE__ ) . 'css/tinder-editor-public.css', array(), $this->version, 'all' );
		}

	}

	public function enqueue_scripts() {

		if ( is_user_logged_in() && current_user_can('edit_posts') ) {
			wp_enqueue_script( 'tinder_editor_public', plugin_dir_url( __FILE__ ) . 'js/tinder-editor-public.js', array( 'jquery' ), $this->version, false );

			$tinder_nonce = wp_create_nonce( 'tinder_editor' );
			$plugin_dir = plugin_dir_url( __FILE__ );

			wp_localize_script( 'tinder_editor_public', 'tinder_data', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'user_id' => get_current_user_id(),
				'nonce'    => $tinder_nonce,
				'tinder_dir' => $plugin_dir
			) );

			wp_enqueue_media();

		}
	}
}
