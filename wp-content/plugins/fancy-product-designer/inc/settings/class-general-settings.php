<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists('FPD_Settings_General') ) {

	class FPD_Settings_General {

		public static function get_options() {

			return apply_filters('fpd_general_settings', array(

				'general-product-designer' => array(

					array(
						'title' 	=> __( 'Main UI Layout', 'radykal' ),
						'description' 		=> sprintf( __( 'Create and customize UI layouts with the <a href="%s" %s>Composer</a>.', 'radykal' ), 'admin.php?page=fpd_ui_layout_composer', 'style="font-weight: bold;"'),
						'id' 		=> 'fpd_product_designer_ui_layout',
						'default'	=> 'default',
						'type' 		=> 'select',
						'class'		=> 'radykal-select2',
						'css'		=> 'width: 200px',
						'admin_col' => 'five',
						'options'   => self::get_saved_ui_layouts()
					),

					array(
						'title' 	=> __( 'Open Product Designer in...', 'radykal' ),
						'description' 		=> __( 'By default the product designer will display while page is loading. But you can also display it in a lightbox or in the page after the user clicks on a button.', 'radykal' ),
						'id' 		=> 'fpd_product_designer_visibility',
						'default'	=> 'page',
						'type' 		=> 'select',
						'class'		=> 'radykal-select2',
						'css'		=> 'width: 200px',
						'admin_col' => 'five',
						'options'   => self::get_product_designer_visibilities()
					),

					array(
						'title' 	=> __( 'Main Bar Position', 'radykal' ),
						'description' 		=> __( 'You can set a custom position for the main bar. Only sidebar layouts can be used with a custom position.', 'radykal' ),
						'id' 		=> 'fpd_main_bar_position',
						'css' 		=> 'min-width:350px;',
						'default'	=> 'default',
						'type' 		=> 'select',
						'class'		=> 'radykal-select2',
						'css'		=> 'width: 200px',
						'admin_col' => 'five',
						'options'   => self::get_main_bar_positions()
					),

					array(
						'title' 	=> __( 'Customization Required', 'radykal' ),
						'description' 		=> __( 'The user must customize the initial elements of a Product in order to proceed.', 'radykal' ),
						'id' 		=> 'fpd_customization_required',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Replace Initial Elements', 'radykal' ),
						'description'	 	=> __( 'When changing the main product, replace only the initial elements of the Product. Custom-added elements will remain on the canvas.', 'radykal' ),
						'id' 		=> 'fpd_replace_initial_elements',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Lazy Load', 'radykal' ),
						'description'	 	=> __( 'Enable lazy loading for the images in the products and designs containers.', 'radykal' ),
						'id' 		=> 'fpd_lazy_load',
						'default'	=> 'yes',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Improved Image Resize Quality', 'radykal' ),
						'description'	 	=> __( 'Enable a filter that improves the quality of a resized bitmap image. This could take a long time for large images.', 'radykal' ),
						'id' 		=> 'fpd_improvedResizeQuality',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Responsive', 'radykal' ),
						'description'	 	=> __( 'Resizes the canvas and all elements in the canvas, so that all elements are displaying properly in the canvas container. This is useful, when your canvas is larger than the available space in the parent container.', 'radykal' ),
						'id' 		=> 'fpd_responsive',
						'default'	=> 'yes',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Upload zones always on top', 'radykal' ),
						'description'	 	=> __( 'Upload zones will be always on top of all elements.', 'radykal' ),
						'id' 		=> 'fpd_uploadZonesTopped',
						'default'	=> 'yes',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Hide On Smartphones', 'radykal' ),
						'description'	 	=> sprintf(__( 'Hide product designer on smartphones and display an <a href="%s">information</a> instead.', 'radykal'), esc_url(admin_url('admin.php?page=fpd_settings&tab=labels#not_supported_device_info')) ),
						'id' 		=> 'fpd_disable_on_smartphones',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Hide On Tablets', 'radykal' ),
						'description'	 	=> sprintf(__( 'Hide product designer on tablets and display an <a href="%s">information</a> instead.', 'radykal' ), esc_url(admin_url('admin.php?page=fpd_settings&tab=labels#not_supported_device_info')) ),
						'id' 		=> 'fpd_disable_on_tablets',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Unsaved Customizations Alert', 'radykal' ),
						'description'	 => __( 'The user will see a notification alert when he leaves the page without saving or adding the product to the cart.', 'radykal' ),
						'id' 		=> 'fpd_unsaved_customizations_alert',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Hide Dialog On Add', 'radykal' ),
						'description'	 => __( 'The dialog/off-canvas panel will be closed as soon as an element is added to the canvas.', 'radykal' ),
						'id' 		=> 'fpd_hide_dialog_on_add',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Canvas Touch Scrolling', 'radykal' ),
						'description'	 => __( 'Enbale touch gesture to scroll on canvas.', 'radykal' ),
						'id' 		=> 'fpd_canvas_touch_scrolling',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Per-Pixel Detection', 'radykal' ),
						'description'	 => __( 'Object detection happens on per-pixel basis rather than on per-bounding-box. This means transparency of an object is not clickable.', 'radykal' ),
						'id' 		=> 'fpd_canvas_per_pixel_detection',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Fit Images In Canvas', 'radykal' ),
						'description'	 => __( 'If the image (custom uploaded or design) is larger than the canvas, it will be scaled down to fit into the canvas.', 'radykal' ),
						'id' 		=> 'fpd_fitImagesInCanvas',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'In Canvas Text Editing', 'radykal' ),
						'description'	 => __( 'The user can edit the text via double click or tap(mobile).', 'radykal' ),
						'id' 		=> 'fpd_inCanvasTextEditing',
						'default'	=> 'yes',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Open Text Input On Select', 'radykal' ),
						'description'	 => __( 'The textarea in the toolbar to change an editbale text opens when the text is selected.', 'radykal' ),
						'id' 		=> 'fpd_openTextInputOnSelect',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Account Product Storage', 'radykal' ),
						'description'	 => __( 'When the user saves his products, it will be stored in his account and not in the storage of the used browser.', 'radykal' ),
						'id' 		=> 'fpd_accountProductStorage',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Auto Open Info', 'radykal' ),
						'description'	 => __( 'Display the info modal when the product designer is loaded.', 'radykal' ),
						'id' 		=> 'fpd_autoOpenInfo',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Replace Colors In Color Group', 'radykal' ),
						'description'	 => __( ' As soon as an element with a color link group is added, the colours of this element will be used for the color group.', 'radykal' ),
						'id' 		=> 'fpd_replaceColorsInColorGroup',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Show Modal In Designer', 'radykal' ),
						'description'	 => __( 'Display some modals (info, qr-code etc.) in the designer instead in the whole page.', 'radykal' ),
						'id' 		=> 'fpd_openModalInDesigner',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Image Size Tooltip', 'radykal' ),
						'description'	 => __( 'Display the image size in pixels of the current selected image in a tooltip.', 'radykal' ),
						'id' 		=> 'fpd_imageSizeTooltip',
						'default'	=> 'no',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' 	=> __( 'Apply Fill When Replacing', 'radykal' ),
						'description'	 => __( 'When an element is replaced, apply fill(color) from replaced element to added element.', 'radykal' ),
						'id' 		=> 'fpd_applyFillWhenReplacing',
						'default'	=> 'yes',
						'type' 		=> 'checkbox',
						'admin_col' => 'four'
					),

					array(
						'title' => __( 'Zoom-Action: Step', 'radykal' ),
						'description' 		=> __( 'The step for zooming in and out.', 'radykal' ),
						'id' 		=> 'fpd_zoom_step',
						'css' 		=> 'width:60px;',
						'default'	=> '0.2',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 0.1
						)
					),

					array(
						'title' => __( 'Zoom-Action: Maximum', 'radykal' ),
						'description' 		=> __( 'The maximum zoom when zooming in.', 'radykal' ),
						'id' 		=> 'fpd_max_zoom',
						'css' 		=> 'width:60px;',
						'default'	=> '3',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 1,
							'step' 	=> 0.1
						)
					),

					array(
						'title' => __( 'Snap-Action: Grid Width', 'radykal' ),
						'description' 		=> __( 'The width for the grid when snap action is enabled.', 'radykal' ),
						'id' 		=> 'fpd_action_snap_grid_width',
						'css' 		=> 'width:60px;',
						'default'	=> '50',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Snap-Action: Grid Height', 'radykal' ),
						'description' 		=> __( 'The height for the grid when snap action is enabled.', 'radykal' ),
						'id' 		=> 'fpd_action_snap_grid_height',
						'css' 		=> 'width:60px;',
						'default'	=> '50',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Text Control Padding', 'radykal' ),
						'description' 		=> __( 'The padding of the corner controls when a text element is selected.', 'radykal' ),
						'id' 		=> 'fpd_padding_controls',
						'css' 		=> 'width:60px;',
						'default'	=> '10',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Bounding Box Stroke Width', 'radykal' ),
						'description' 		=> __( 'The stroke width of the bounding box when an element is selected.', 'radykal' ),
						'id' 		=> 'fpd_bounding_box_stroke_width',
						'css' 		=> 'width:60px;',
						'default'	=> '1',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Highlight Editable Objects', 'radykal' ),
						'description' 		=> __( 'Highlight objects (editable texts and upload zones) with a dashed border. To enable this just define a hexadecimal color value.', 'radykal' ),
						'id' 		=> 'fpd_highlightEditableObjects',
						'css' 		=> 'width:100px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Watermark Image', 'radykal' ),
						'description' 		=> __( 'Set a watermark image that will be added when the user downloads or prints the product. If the WooCommerce product is downloadable, the watermark will be removed when the customer downloads/prints the completed order.', 'radykal' ),
						'id' 		=> 'fpd_watermark_image',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'upload'
					),

					array(
						'title' => __( 'Button CSS Classes', 'radykal' ),
						'description' 		=> __( 'These CSS clases will be added e.g. to the customisation button. Add class names without the dot.', 'radykal' ),
						'id' 		=> 'fpd_start_customizing_css_class',
						'css' 		=> 'width:500px;',
						'default'	=> 'fpd-blue-btn',
						'type' 		=> 'text'
					),


				), //layout-skin

				'custom-images' => array(

					array(
						'title' => __( 'Save On Server', 'radykal' ),
						'id' 		=> 'fpd_type_of_uploader',
						'default'	=> 'php',
						'type' 		=> 'radio',
						'description'	=>  __( 'If your customers can add multiple or large images, then save images on server, otherwise you may inspect some issues when adding the customized product to the cart. The images will be saved in wp-content/uploads/fancy_products_uploads/ directory.', 'radykal' ),
						'options'	=> array(
							'filereader' => __( 'No', 'radykal' ),
							'php' => __( 'Yes', 'radykal' )
						),
						'relations' => array(
							'filereader' => array(
								'fpd_upload_designs_php_logged_in' => false,
							),
							'php' => array(
								'fpd_upload_designs_php_logged_in' => true,
							)
						)
					),

					array(
						'title' 	=> __( 'Login Required', 'radykal' ),
						'description'	 	=> __( 'Users must create an account in your Wordpress site and need to be logged-in to upload images.', 'radykal' ),
						'id' 		=> 'fpd_upload_designs_php_logged_in',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

					array(
						'title' 	=> __( 'Confirm Image Rights', 'radykal' ),
						'description'	 => __( 'Before the image is uploaded the user needs to confirm an agreement to have the right to use the image.', 'radykal' ),
						'id' 		=> 'fpd_uploadAgreementModal',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

					array(
						'title' => __( 'Allowed Image Types', 'radykal' ),
						'id' 		=> 'fpd_allowedImageTypes',
						'css' 		=> 'width:300px;',
						'default'	=> array('jpeg', 'png', 'svg'),
						'type' 		=> 'multiselect',
						'class'		=> 'radykal-select2',
						'options'   => array(
							"jpeg" => 'JPEG',
							"png" => 'PNG',
							"svg" => 'SVG'
						)
					),

					array(
						'title' => __( 'Facebook App-ID', 'radykal' ),
						'description' 		=> __( 'Enter a Facebook App-ID to enable Facebook photos in the images module.', 'radykal' ),
						'id' 		=> 'fpd_facebook_app_id',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Instagram Client ID', 'radykal' ),
						'description' 		=> __( 'Enter an Instagram Client ID to enable Instagram photos in the images module.', 'radykal' ),
						'id' 		=> 'fpd_instagram_client_id',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Instagram Redirect URI', 'radykal' ),
						'description' 		=> __( 'This is the URI you need to paste into the "OAuth Redirect URI" input when creating a Instagram Client ID. Do not change it!', 'radykal' ),
						'id' 		=> 'fpd_instagram_redirect_uri',
						'css' 		=> 'width:500px;',
						'default'	=> plugins_url( '/assets/templates/instagram_auth.php', FPD_PLUGIN_ROOT_PHP ),
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Pixabay API Key', 'radykal' ),
						'description' 		=> __( 'Enter a Pixabay API key to enable the Pixabay photo library in the images module.', 'radykal' ),
						'id' 		=> 'fpd_pixabayApiKey',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Pixabay High-Res Images', 'radykal' ),
						'description' 		=> __( 'Let your customers add only high resolution images from Pixabay.', 'radykal' ),
						'id' 		=> 'fpd_pixabayHighResImages',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

				),//custom-images

				'sharing' => array(

					array(
						'title' => __( 'Design Share', 'radykal' ),
						'description' 		=> __( 'Allow users to share their designs on social networks.', 'radykal' ),
						'id' 		=> 'fpd_sharing',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

					array(
						'title' => __( 'Add Open graph image meta', 'radykal' ),
						'description' 		=> __( 'If your site does not add an open graph image meta tag, enable this option, otherwise the image of the customized product will not be shared on Facebook.', 'radykal' ),
						'id' 		=> 'fpd_sharing_og_image',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

					array(
						'title' => __( 'Cache Days', 'radykal' ),
						'description' 		=> __( 'Whenever an user shares a design, an image and database entry will be created. To delete this data after a certain period of time, you can set the days of caching. A value of 0 will store the data forever.', 'radykal' ),
						'id' 		=> 'fpd_sharing_cache_days',
						'default'	=> 5,
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Social Networks', 'radykal' ),
						'id' 		=> 'fpd_sharing_social_networks',
						'css' 		=> 'width:300px;',
						'default'	=> array('facebook', 'twitter', 'googleplus', 'email'),
						'type' 		=> 'multiselect',
						'class'		=> 'radykal-select2',
						'options'   => array(
							"facebook" => 'Facebook',
							"twitter" => 'Twitter',
							"googleplus" => 'Google Plus',
							"linkedin" => 'Linkedin',
							"pinterest" => 'Pinterest',
							"email" => 'Email',
						)
					),

				),

				//QR-Code
				'qr-code' => array(

					array(
						'title' 	=> __( 'Resize To Width', 'radykal' ),
						'id' 		=> 'fpd_qr_code_prop_resizeToW',
						'css' 		=> 'width:70px;',
						'default'	=> '0',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' 	=> __( 'Resize To Height', 'radykal' ),
						'id' 		=> 'fpd_qr_code_prop_resizeToH',
						'css' 		=> 'width:70px;',
						'default'	=> '0',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Price', 'radykal' ),
						'id' 		=> 'fpd_qr_code_prop_price',
						'css' 		=> 'width:70px;',
						'default'	=> '0',
						'type' 		=> 'text',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Resizable', 'radykal' ),
						'id' 		=> 'fpd_qr_code_prop_resizable',
						'default'	=> 'yes',
						'type' 		=> 'checkbox'
					),

					array(
						'title' => __( 'Draggable', 'radykal' ),
						'id' 		=> 'fpd_qr_code_prop_draggable',
						'default'	=> 'yes',
						'type' 		=> 'checkbox'
					),

				),

				'troubleshooting' => array(

					array(
						'title' 	=> __( 'Debug Mode', 'radykal' ),
						'description' 		=> __( 'Enables Theme-Check modal and loads the unminified Javascript files.', 'radykal' ),
						'id' 		=> 'fpd_debug_mode',
						'default'	=> 0,
						'type' 		=> 'radio',
						'options'   => array(
							1	 => __( 'On', 'radykal' ),
							0	 => __( 'Off', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'jQuery No Conflict Mode', 'radykal' ),
						'description' 		=> __( 'Turns on the jQuery no conflict mode. Turn it on if you are facing some Javascript issues.', 'radykal' ),
						'id' 		=> 'fpd_jquery_no_conflict',
						'default'	=> 0,
						'type' 		=> 'radio',
						'options'   => array(
							1	 => __( 'On', 'radykal' ),
							0	 => __( 'Off', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Test: FabricJS Version', 'radykal' ),
						'description' 		=> __( 'Please test Fancy Product Designer with the latest FabricJS. If you have any bug, please let us know in the support forum.', 'radykal' ),
						'id' 		=> 'fpd_fabric_version',
						'default'	=> '1.6.7',
						'type' 		=> 'radio',
						'options'   => array(
							'1.6.7'	 => __( '1.6.7', 'radykal' ),
							'2.2'	 => __( '2.+', 'radykal' ),
						)
					),

				),

				'purchase-codes' => array(

					array(
						'title' 	=> __( 'Basis Plugin', 'radykal' ),
						'description' 		=> __( 'Enter here the purchase code of the basis plugin - <a href="https://codecanyon.net/item/fancy-product-designer-woocommercewordpress/6318393" target="_blank">Fancy Product Designer | WooCommerce/WordPress</a>.
', 'radykal' ),
						'id' 		=> 'fpd_envato_purchase_code',
						'default'	=> '',
						'type' 		=> 'text',
						'css' 		=> 'width:500px;',
					),

				),

			));
		}

		public static function get_saved_ui_layouts() {

			$saved_layouts = FPD_UI_Layout_Composer::get_layouts();

			if(sizeof($saved_layouts) == 0) {

				return array(
					'default' => __('Default', 'radykal')
				);

			}

			$layouts = array();
			foreach($saved_layouts as $saved_layout) {

				$id = str_replace('fpd_ui_layout_', '', $saved_layout->option_name);
				$name = json_decode(stripslashes($saved_layout->option_value), true);
				$layouts[$id] = $name['name'];

			}

			return $layouts;
		}

		public static function get_product_designer_visibilities() {

			$values = array(
				'page'	=> __( 'Page', 'radykal' ),
				'lightbox'	=> __( 'Lightbox', 'radykal' ),
				'page-customize'	=> __( 'Page after user clicks on the customization button', 'radykal' ),
			);

			return $values;

		}

		public static function get_main_bar_positions() {

			$positions = array(
				'default'	=> __( 'Default', 'radykal' ),
				'shortcode'	=> __( 'Via Shortcode: [fpd_main_bar]', 'radykal' )
			);

			if( function_exists('get_woocommerce_currency') ) {
				$positions['after_product_title']	=  __( 'After Product Title (WooCommerce)', 'radykal' );
				$positions['after_excerpt'] 	=  __( 'After Product Excerpt (WooCommerce)', 'radykal' );
			}

			return $positions;

		}

		public static function get_bounding_box_modi() {

			return array(
				'inside' => __('Inside', 'radyal'),
				'clipping' => __('Clipping', 'radyal'),
				'limitModify' => __('Limit Modification', 'radyal'),
				'none' => __('None', 'radyal'),
			);

		}


		/**
		 * Get the available frame shadows.
		 *
		 */
		public static function get_frame_shadows() {

			return array(
				'fpd-shadow-1'	 => __( 'Shadow 1', 'radykal' ),
				'fpd-shadow-2'	 => __( 'Shadow 2', 'radykal' ),
				'fpd-shadow-3'	 => __( 'Shadow 3', 'radykal' ),
				'fpd-shadow-4'	 => __( 'Shadow 4', 'radykal' ),
				'fpd-shadow-5'	 => __( 'Shadow 5', 'radykal' ),
				'fpd-shadow-7'	 => __( 'Shadow 6', 'radykal' ),
				'fpd-no-shadow'	 => __( 'No Shadow ', 'radykal' ),
			);

		}

	}
}

?>