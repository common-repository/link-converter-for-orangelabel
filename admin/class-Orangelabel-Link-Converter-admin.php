<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://orangelabel.zanox.com/home/
 * @since      1.0.0
 *
 * @package    Orangelabel_Link_Converter
 * @subpackage Orangelabel_Link_Converter/includes
 */


class Orangelabel_Link_Converter_Admin {

	/**
	 *
	 * Adds OrangeLabel Link Converter menu
	 *
	 * Since 1.0.0
	 *
	 */

	function olc_add_admin_menu(  ) {

		add_menu_page( 'Orangelabel Link Converter', 'Orangelabel Link Converter', 'manage_options', 'orangelabel-link-converter', array( &$this, 'render_olc_options_page') ,'dashicons-admin-links');

	}

	/**
	 *
	 * Adds OrangeLabel Link Converter options section
	 *
	 * Since 1.0.0
	 *
	 */

	function render_olc_options_page() {
		if ( isset ( $_GET['tab'] ) ) $this->olc_admin_tabs($_GET['tab']); else $this->olc_admin_tabs('general');

		?>
		<form action='options.php' method='post'>
			<?php
			if (isset ( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
				if($tab == 'advanced') {
					settings_fields('olc_advanced_page');
					do_settings_sections('olc_advanced_page');
					submit_button();
				}
				if($tab == 'general') {
					settings_fields( 'olc_general_page' );
					do_settings_sections( 'olc_general_page' );
					submit_button();
				}
				if($tab == 'help') {
					do_settings_sections( 'olc_help_page' );
				}
			}else {
				settings_fields( 'olc_general_page' );
				do_settings_sections( 'olc_general_page' );
				submit_button();
			}

			?>
		</form>
		<?php

	}

	function olc_admin_tabs( $current = 'homepage' ) {
		$olc_general_string = esc_html__('General', 'orangelabel-link-converter');
		$olc_advanced_string = esc_html__('Advanced', 'orangelabel-link-converter');
		$olc_help_string = esc_html__('Help', 'orangelabel-link-converter');

		$tabs = array('general' => $olc_general_string, 'advanced' => $olc_advanced_string, 'help' => $olc_help_string);
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach ($tabs as $tab => $name) {
			$class = ($tab == $current) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=orangelabel-link-converter&tab=$tab'>$name</a>";

		}
		echo '</h2>';
		if (isset($_GET['settings-updated'])) { ?>
			<div id="message" class="updated">
				<p><strong><?php _e('Settings saved.') ?></strong></p>
			</div>
		<?php }
	}

	function olc_settings_init(  ) {

		register_setting( 'olc_general_page', 'olc_awin_id' );
		register_setting( 'olc_general_page', 'olc_zanox_id' );
		register_setting( 'olc_advanced_page', 'olc_disabled_categories' );
	
		
		//sections


		add_settings_section(
			'olc_general_page_section',
			__( 'General', 'orangelabel-link-converter' ),
			array( &$this, 'olc_general_section_callback'),
			'olc_general_page'
		);

		add_settings_section(
			'olc_advanced_page_section',
			__( 'Advanced', 'orangelabel-link-converter' ),
			array( &$this, 'olc_advanced_page_section_callback'),
			'olc_advanced_page'
		);

		add_settings_section(
			'olc_help_page_section',
			__( 'Help', 'orangelabel-link-converter' ),
			array( &$this, 'olc_help_page_section_callback'),
			'olc_help_page'
		);

		//fields

		add_settings_field(
			'olc_awin_id',
			__( 'Awin Orangelabel ID', 'orangelabel-link-converter' ),
			array( &$this, 'olc_awin_id_render'),
			'olc_general_page',
			'olc_general_page_section'
		);

		add_settings_field(
			'olc_zanox_id',
			__( 'Zanox Orangelabel ID', 'orangelabel-link-converter' ),
			array( &$this, 'olc_zanox_id_render'),
			'olc_general_page',
			'olc_general_page_section'
		);

		add_settings_field(
			'olc_disabled_categories',
			__( 'Disabled Categories', 'orangelabel-link-converter' ),
			array( &$this, 'olc_disabled_categories_render'),
			'olc_advanced_page',
			'olc_advanced_page_section'
		);

	}



	/**
	 *
	 * Adds advanced section description
	 *
	 * Since 1.0.0
	 *
	 */

	function olc_advanced_page_section_callback(  ) {
		_e( "Link Conversion is disabled for these categories:", 'orangelabel-link-converter' );
	}


	/**
	 *
	 * Adds help section description
	 *
	 * Since 1.0.0
	 *
	 */

	function olc_help_page_section_callback(  ) {
		?>
		<dl>
            <dt><b><?php _e( "Where can I find my account numbers?", 'orangelabel-link-converter' ); ?></b></dt>
            <dd><?php _e( "Contact your Awin account manager, your account number will be created and send to you.", 'orangelabel-link-converter' ); ?></dd>
            <dt><b><?php _e( "Where can I see my statistics?", 'orangelabel-link-converter' ); ?></b></dt>
            <dd><?php _e( "These are visible in your Awin dashboard", 'orangelabel-link-converter' ); ?></dd>
            <dt><b><?php _e( "Can I use this tool for my other affiliate links as well?", 'orangelabel-link-converter' ); ?></b></dt>
            <dd><?php _e( "Yes you can, visit <a href='https://linkPizza.com'>LinkPizza.com</a> for more information", 'orangelabel-link-converter' ); ?></dd>
        </dl>
		<?php
	}

	/**
	 *
	 * Adds general section description
	 *
	 * Since 1.0.0
	 *
	 */

	function olc_general_section_callback(  ) {
		_e( "Activate the Orangelabel Link Converter by entering your account details below. These will be supplied by your account manager", 'orangelabel-link-converter' );
	}

	/**
	 *
	 * Renders the input field for the awin ID
	 *
	 * Since 1.0.0
	 *
	 */


	function olc_awin_id_render(  ) {
		?>
		<input type='text' name='olc_awin_id' value='<?php echo get_option('olc_awin_id'); ?>' style="width: 300px"  />
		<?php
	}


	/**
	 *
	 * Renders the input field for the Zanox ID
	 *
	 * Since 1.0.0
	 *
	 */


	function olc_zanox_id_render(  ) {
		?>
		<input type='text' name='olc_zanox_id' value='<?php echo get_option('olc_zanox_id'); ?>' style="width: 300px"  />
		<?php
	}



	/**
	 *
	 * Renders the input field for the disabled categories section
	 *
	 * Since 4.6
	 *
	 */


	function olc_disabled_categories_render(  )
	{
		$disabledCategories = get_option('olc_disabled_categories');
		$categories = get_categories();
		foreach ($categories as $category) { ?>
			<input class="widefat" type="checkbox" name="olc_disabled_categories[<?php echo $category->cat_ID; ?>]"
			       value="<?php echo $category->cat_ID; ?>"
			<?php
			if (is_array($disabledCategories)) {
				echo (in_array($category->cat_ID, $disabledCategories)) ? 'checked="checked"' : ''; ?>  /> <?php
			} else {
				if ($category->cat_ID == $disabledCategories) {
					echo 'checked="checked" />';
				} else {
					echo '/>';
				}
			}
			?><span><?php echo $category->cat_name ?></span><br/><?php
		}
	}





	/**
	 * Create meta box to be displayed on the post editor screen.
	 *
	 * @since     1.0.0
	 *
	 */
	function olc_add_post_meta_boxes() {
		$screens = array( 'post', 'page' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'olc-post-enable',      // Unique ID
				esc_html__( 'Orangelabel Link Converter', 'orangelabel-link-converter' ),    // Title
				array( $this, 'olc_post_enable_meta_box' ),
				$screen,     // Admin page (or post type)
				'normal',         // Context
				'core'         // Priority
			);
		}
		$other_post_types = get_post_types(array('_builtin'=>false));
		foreach ( $other_post_types as $other_post_type ) {
			add_meta_box(
				'olc-post-enable',      // Unique ID
				esc_html__( 'Orangelabel Link Converter', 'orangelabel-link-converter' ),    // Title
				array( $this, 'olc_post_enable_meta_box' ),
				$other_post_type,     // Admin page (or post type)
				'advanced',         // Context
				'low'         // Priority
			);
		}

	}

	/**
	 * Hide meta box if custom
	 *
	 * @since     1.0.0
	 *
	 */
	function custom_hidden_meta_boxes( $hidden ) {
		if(!in_array(get_post_type(), array('post','page'))){
			$hidden[] = 'linkpizza-post-enable';
			return $hidden;
		}else{
			return $hidden;
		}
	}


	/**
	 * Display the post meta box.
	 *
	 * @since     1.0.0
	 *
	 */
	function olc_post_enable_meta_box($object) { ?>

		<?php
		wp_nonce_field( 'olc_post_custom_box', 'olc_post_enable_nonce' );
		$disabledUrls = get_post_meta($object->ID, '_olc_disabled_urls', true);
		?>


		<div width="100%">
		<b><?php _e( "General", 'orangelabel-link-converter' ); ?></b>
		<p>
			<input class="widefat" type="checkbox" name="olc-disabled" id="olc-disabled" value="1" <?php checked( get_post_meta( $object->ID, '_olc_disabled', true ), 1 ); ?> size="30" />
			<label for="olc-disabled"><?php _e( "Disable link conversion for this specific post or page.", 'orangelabel-link-converter' ); ?></label></br>
		</p>
		<b><?php _e( "Disable specific links", 'orangelabel-link-converter' ); ?></b>
		<p>
			<?php
			if (class_exists('DOMDocument')) {
			$dom_document = new DOMDocument();
			if ($object->post_content != ''){
			$dom_document->loadHTML($object->post_content);
			$dom_document->preserveWhiteSpace = false;

			//use DOMXpath to navigate the html with the DOM

			$elements = $dom_document->getElementsByTagName('a');

			if (!is_null($elements)) {
			?>
		<table class="widefat fixed" cellspacing="2">

			<thead>
			<tr>
				<th id="cb" class="manage-column column-cb check-column" scope="col"></th>
				<th id="linktitle" scope="col"><?php _e("Title", 'orangelabel-link-converter'); ?></th>
				<th id="linkUrl" scope="col"><?php _e("Target", 'orangelabel-link-converter'); ?></th>
			</tr>
			</thead>
			<?php
			foreach ($elements as $element) {
				?>
				<tr>
					<td>
						<input class="widefat" type="checkbox" name="olc-disabled-urls[]"
						       value="<?php echo $element->getAttribute('href'); ?>"
							<?php
							if (is_array($disabledUrls)){
							echo (in_array($element->getAttribute('href'), $disabledUrls)) ? 'checked="checked"' : ''; ?> /> <?php
						} else {
							if ($element->getAttribute('href') == $disabledUrls) {
								echo 'checked="checked" />';
							} else {
								echo '/>';
							}
						}
						?>
					</td>
					<td>
						<?php
						echo $element->nodeValue;
						?>
					</td>
					<td><a target="_blank" href="
						<?php
						echo $element->getAttribute('href');
						?>
								">
							<?php
							echo $element->getAttribute('href');
							?>
						</a></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
		}
		} else {
			?><?php _e("You haven't added any links to your blogpost", 'orangelabel-link-converter');
		}
		}else{
			?>
			<div class="warning">
				<?php	_e("It seems your Wordpress is missing php-xml, please ask your host to install it.", 'orangelabel-link-converter'); ?>
			</div>
			<?php
		}
		?>
		</p>
		</div><?php
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['olc_post_enable_nonce'] ) )
			return $post_id;

		$nonce = $_POST['olc_post_enable_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'olc_post_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		if ( isset( $_POST['olc-disabled'] ) ) {
			$value =  '1';
		} else {
			$value = '';
		}

		if(isset( $_POST['olc-disabled-urls'] )) {
			$custom = $_POST['olc-disabled-urls'];
			$old_meta = get_post_meta($post_id, '_olc_disabled_urls', true);
			// Update post meta
			if(!empty($old_meta)){
				update_post_meta($post_id, '_olc_disabled_urls', $custom);
			} else {
				add_post_meta($post_id, '_olc_disabled_urls', $custom, true);
			}
		}else{
		    update_post_meta($post_id,'_olc_disabled_urls','[]');
        }

		// Update the meta field.
		update_post_meta( $post_id, '_olc_disabled', $value);
	}

	public static function plugin_row_meta($meta, $file) {
		if ($file == ORANGELABEL_LINK_CONVERTER_BASE_FILE) {
			$meta[] = '<a href="admin.php?page=orangelabel-link-converter">' . __('Settings','orangelabel-link-converter') . '</a>';
		}
		return $meta;
	}






}