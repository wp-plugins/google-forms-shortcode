<?php
/*
Plugin Name: Google forms shortcode
Description: This plugin makes it simple to embed Google forms iframes to posts and pages
Author: Jules Stuifbergen
Version: 1.0.1
Author URI: http://forwardslash.nl/
Plugin URI: http://forwardslash.nl/google-forms-shortcode-wordpress-plugin/
License: GPL
*/

/*
 * Admin User Interface
 */

if ( ! class_exists( 'GFS_Admin' ) ) {

	class GFS_Admin {

		function add_config_page() {
			global $wpdb;
			if ( function_exists('add_options_page') ) {
				add_options_page('Google forms shortcode Configuration', 'Google forms shortcode', 9, basename(__FILE__), array('GFS_Admin','config_page'));
			}
		} 

		function config_page() {
			if ( $_GET['reset'] == "true") {
				$options['width'] = '500';
				$options['height'] = '600';
				$options['text'] = 'Loading...';
				$options['errormsg'] = '[key missing]';
				update_option('GFSopts',$options);
			}
				
			if ( isset($_POST['submit']) ) {
				if (!current_user_can('manage_options')) die(__('You cannot edit the options.'));
				check_admin_referer('gfsopts-config');

				if (isset($_POST['width']) && is_numeric($_POST['width']))
					$options['width'] = $_POST['width'];
				if (isset($_POST['height']) && is_numeric($_POST['height']))
					$options['height'] = $_POST['height'];
				if (isset($_POST['text']) && $_POST['text'] != "")
					$options['text'] = $_POST['text'];
				if (isset($_POST['errormsg']) && $_POST['errormsg'] != "")
					$options['errormsg'] = $_POST['errormsg'];
				update_option('GFSopts', $options);
			}

			$options  = get_option('GFSopts');
			?>
			<div class="wrap">
				<h2>Google forms Shortcode Configuration</h2>
				<form action="" method="post" id="gfs-conf">
					<table class="form-table" style="width:100%;">
					<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('gfsopts-config');
					?>
					<tr>
						<th scope="row" style="width:400px;" valign="top">
							<label for="width">Default form width</label>
						</th>
						<td>
							<input id="width" name="width" type="text" size="5" value="<?php echo $options['width']; ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /><br/>
						</td>
					</tr>							
					<tr>
						<th scope="row" valign="top">
							<label for="height">Default form height</label><br/>
						</th>
						<td>
							<input id="height" name="height" type="text" size="5" value="<?php echo $options['height']; ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /><br/>
						</td>
					</tr>
					<tr>
						<th scope="row" style="width:400px;" valign="top">
							<label for="text">Default 'loading' text</label>
						</th>
						<td>
							<input id="text" name="text" type="text" size="40" maxlength="99" value="<?php echo $options['text']; ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /><br/>
						</td>
					</tr>
					<tr>
						<th scope="row" style="width:400px;" valign="top">
							<label for="errormsg">Error message text when 'key' is omitted</label>
						</th>
						<td>
							<input id="errormsg" name="errormsg" type="text" size="40" maxlength="99" value="<?php echo $options['errormsg']; ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /><br/>
						</td>
					</tr>
					</table>
					<p style="border:0;" class="submit"><input type="submit" name="submit" value="Update Settings &raquo;" /></p>
				</form>
			</div>
			<?php
			if (isset($options['width']) && isset($options['height']) && isset($options['text']) && isset($options['errormsg'])) {
				update_option('GFSopts',$options);
				if ( isset($_POST['submit']) )
					add_action('admin_footer', array('GFS_Admin','success'));
			} else {
				add_action('admin_footer', array('GFS_Admin','warning'));
			}

		} // end config_page()

		function restore_defaults() {
			$options['width'] = '500';
			$options['height'] = '600';
			$options['text'] = 'Loading...';
			$options['errormsg'] = '[key missing]';
			update_option('GFSopts',$options);
		}
		
		function success() {
			echo "<div id='gfs-alert' class='updated fade-ff0000'><p>All set!</p></div>
			<style type='text/css'>
			#adminmenu { margin-bottom: 7em; }
			</style>";
		} // end success()
		function warning() {
			echo "<div id='gfs-alert' class='updated fade-ff0000'><p>Warning! Not all options set..</p></div>
			<style type='text/css'>
			#adminmenu { margin-bottom: 7em; }
			</style>";
		} // end warning()

	} // end class 

} //endif


/**
 * Finally: the shortcode function.
 */

if ( ! class_exists( 'GFS_Func' ) ) {
        class GFS_Func {

	function googleform_iframe_embed( $opties ) {
		$options  = get_option('GFSopts');
		extract(shortcode_atts(array( 'key' => '',
					      'width' => $options['width'],
					      'height'=> $options['height'],
					      'text'  => $options['text'] ), $opties ));
		if ($key) {
			return "<!-- googleform shortcode plugin by http://jongbelegen.net/ --><iframe src=\"http://spreadsheets.google.com/embeddedform?formkey=$key\" width=\"$width\" height=\"$height\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\">$text</iframe>";
		} else { return "<!-- googleform shortcode plugin by http://jongbelegen.net/ -->".$options['errormsg']; }
	}

	} //end class
} //endif

$options  = get_option('GFSopts',"");

if ($options == "") {
	$options['width'] = '500';
	$options['height'] = '600';
	$options['text'] = 'Loading...';
	$options['errormsg'] = '[key missing]';
	update_option('GFSopts',$options);
}

// adds the menu item to the admin interface
add_action('admin_menu', array('GFS_Admin','add_config_page'));
// adds the shortcode
add_shortcode('googleform', array('GFS_Func','googleform_iframe_embed'));


?>
