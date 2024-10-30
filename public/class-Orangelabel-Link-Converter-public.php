<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://orangelabel.zanox.com/home/
 * @since      1.0.0
 *
 * @package    Orangelabel_Link_Converter
 * @subpackage Orangelabel_Link_Converter/includes
 */

class Orangelabel_Link_Converter_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add the javascript that loads LinkPizza asynchronously and tag any disabled links so the JS doesn't change it.
	 *
	 * @since    1.0.0
	 */
	public function add_olc_head(){
		?><?php
		$postid = get_the_ID();
		$olc_disabled = get_post_meta($postid, '_olc_disabled', true);
		$disabledUrls = get_post_meta($postid, '_olc_disabled_urls', true);
		$disabledCategories = get_option('olc_disabled_categories');
		$categories =  get_the_category();
		$isDisabledCategory = false;


		//loop through categories to check if its enabled
		if (!empty($categories) && !empty($disabledCategories)) {
			if (is_array($categories)) {
				foreach ($categories as $category) {
					if (in_array($category->cat_ID, $disabledCategories)) {
						$isDisabledCategory = true;
					}
				}
			} else {
				if (in_array($categories->cat_ID, $disabledCategories)) {
					$isDisabledCategory = true;
				}
			}
		}



		if (!is_null($disabledUrls)) {
			?>

			<script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    var disabledUrls =<?php echo json_encode($disabledUrls );?>;

                    function contains(a, obj) {
                        var i = a.length;
                        while (i--) {
                            if (a[i] === obj ) {
                                return true;
                            }
                        }
                        return false;
                    }

                    var els = document.getElementsByTagName("a");
                    for (var i = 0, l = els.length; i < l; i++) {
                        var el = els[i];
                        if (contains(disabledUrls,el.getAttribute("href"))) {
                            if (el.className.indexOf("pzz-ignore") ==-1) {
                                el.className += " pzz-ignore";
                            }
                        }
                    }
                });
			</script>
			<?php

		}

		if($olc_disabled != '1') {
			if(!$isDisabledCategory){
				$olc_zanox_id = get_option( 'olc_zanox_id' );
                $olc_awin_id = get_option( 'olc_awin_id' ); ?>
				<script>
                    (function(p,z,Z){
                        z=p.createElement("script");z.async=1;
                        z.src="//dev.pzz.io/pzz"+".js?uid=13003&min=false&host="+p.domain+"<?php if($olc_zanox_id != false) {echo "&-zanox.com=".$olc_zanox_id; }?>"+"<?php if($olc_awin_id != false) {echo "&-affiliatewindow.com=".$olc_awin_id; }?>";
                        (p.head||p.documentElement).insertBefore(z,Z);
                    })(document);
				</script>
				<?php
			}
		}

	}

}
