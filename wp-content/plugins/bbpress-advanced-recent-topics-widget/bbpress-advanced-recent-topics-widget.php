<?php
/*
Plugin Name: bbPress Advanced Recent Topics Widget
Plugin URI: http://www.veebeeglobal.com/wordpress-plugins/bbpress-advanced-recent-topics-widget/
Description: Widget for bbPress which expands the output of Recent Topics to show Forum and Topic Excerpt.
Version: 0.9
Author: VeeBeeGlobal
Author URI: http://www.veebeeglobal.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2014 Vee Bee Global (sales@veebeeglobal.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

class BBP_Recent_Topics_Widget_Advanced extends WP_Widget {

	public function __construct() {

		add_action('init', array($this, 'widget_textdomain'));

//		register_activation_hook(__FILE__, array($this, 'activate'));
//		register_deactivation_hook(__FILE__, array($this, 'deactivate'));

		parent::__construct('widget-bbpress-adv-recent-topics', __('bbPress Advanced Recent Topics', 'bbpress-adv-recent-topics-locale'), array('classname'=>'bbpress_adv_recent_topics', 'description'=>__('bbPress Recent Topics with loads more options and parameters.', 'bbpress-adv-recent-topics-locale')));

//		add_action('admin_print_styles', array($this, 'register_admin_styles'));
//		add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
//		add_action('wp_enqueue_scripts', array($this, 'register_widget_styles'));
//		add_action('wp_enqueue_scripts', array($this, 'register_widget_scripts'));

		add_action('save_post', array($this, 'flush_widget_cache'));
		add_action('deleted_post', array($this, 'flush_widget_cache'));
		add_action('switch_theme', array($this, 'flush_widget_cache'));
	}

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget($args, $instance) {

		$cache = wp_cache_get('widget-bbpress-adv-recent-topics', 'widget');
		if (!is_array($cache)) $cache = array();
		if (!isset($args['widget_id'])) $args['widget_id'] = $this->id;
		if (isset($cache[$args['widget_id']])) return print $cache[$args['widget_id']];

		extract($args, EXTR_SKIP);

		$title = apply_filters('bbp_topic_widget_title', $instance['title'], $instance, $this->id_base);

		$max_shown = (!empty($instance['max_shown'])) ? absint($instance['max_shown']) : 5;
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
		$show_user = isset($instance['show_user']) ? $instance['show_user'] : false;
		$show_forum = isset($instance['show_forum']) ? $instance['show_forum'] : false;
		$show_detail = isset($instance['show_detail']) ? $instance['show_detail'] : false;
		$order_by = (!empty($instance['order_by'])) ? $instance['order_by'] : 'freshness';

		$parent_forum = 'any';

		switch ($order_by) {
			case 'freshness' :  // Order by most recent replies
				$topics_query = array('author'=> 0, 'post_type'=>bbp_get_topic_post_type(), 'post_parent'=>$parent_forum, 'posts_per_page'=>$max_shown, 'post_status'=>join(',', array(bbp_get_public_status_id(), bbp_get_closed_status_id())), 'show_stickes'=>false, 'meta_key'=>'_bbp_last_active_time', 'orderby'=>'meta_value', 'order'=>'DESC', 'meta_query'=>array(bbp_exclude_forum_ids('meta_query')));
				break;
			case 'popular' :  // Order by total number of replies
				$topics_query = array('author'=>0, 'post_type'=>bbp_get_topic_post_type(), 'post_parent'=>$parent_forum, 'posts_per_page'=>$max_shown, 'post_status'=>join(',', array(bbp_get_public_status_id(), bbp_get_closed_status_id())), 'show_stickes'=>false, 'meta_key'=>'_bbp_reply_count', 'orderby'=>'meta_value', 'order'=>'DESC', 'meta_query'=>array(bbp_exclude_forum_ids('meta_query')));
				break;
			case 'newness' :  // Order by which topic was created most recently
			default :
				$topics_query = array('author'=>0, 'post_type'=>bbp_get_topic_post_type(), 'post_parent'=>$parent_forum, 'posts_per_page'=>$max_shown, 'post_status'=>join(',', array(bbp_get_public_status_id(), bbp_get_closed_status_id())), 'show_stickes'=>false, 'order'=>'DESC', 'meta_query'=>array(bbp_exclude_forum_ids('meta_query')));
				break;
		}

		$widget_query = new WP_Query($topics_query);
		if ($widget_query->have_posts()) :
			$widget_output = $before_widget;
			$widget_output .= $before_title . $title . $after_title;
			ob_start();
			include(plugin_dir_path(__FILE__) . 'views/widget.php');
			$widget_output .= ob_get_clean();
			$widget_output .= $after_widget;
			$cache[$args['widget_id']] = $widget_output;
			wp_cache_set('widget-bbpress-adv-recent-topics', $cache, 'widget', 60*60*3);
			print $widget_output;
		endif;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget-bbpress-adv-recent-topics', 'widget');
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$new_instance = wp_parse_args((array) $new_instance, array('title'=>'', 'max_shown'=>5, 'show_date'=>0, 'show_user'=>0, 'show_forum'=>0, 'show_detail'=>0, 'order_by'=>'freshness'));

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['max_shown'] = $new_instance['max_shown'];
		$instance['show_date'] = $new_instance['show_date'] ? 1 : 0;
		$instance['show_user'] = $new_instance['show_user'] ? 1 : 0;
		$instance['show_forum'] = $new_instance['show_forum'] ? 1 : 0;
		$instance['show_detail'] = $new_instance['show_detail'] ? 1 : 0;
		$instance['order_by'] = strip_tags($new_instance['order_by']);

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form($instance) {

		$local_defaults = array('title'=>'Recent Topics', 'max_shown'=>5, 'show_date'=>1, 'show_user'=>1, 'show_forum'=>0, 'show_detail'=>0, 'order_by'=>'freshness');

		$instance = wp_parse_args((array)$instance, $local_defaults);

		$title = strip_tags($instance['title']);
		$max_shown = (int)$instance['max_shown'];
		$show_date = $instance['show_date'] ? 'checked="checked"' : '';
		$show_user = $instance['show_user'] ? 'checked="checked"' : '';
		$show_forum = $instance['show_forum'] ? 'checked="checked"' : '';
		$show_detail = $instance['show_detail'] ? 'checked="checked"' : '';
		$order_by = strip_tags($instance['order_by']);

		include(plugin_dir_path(__FILE__) . 'views/admin.php');
	}

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	public function widget_textdomain() {
		load_plugin_textdomain('bbpress-adv-recent-topics-locale', false, plugin_dir_path(__FILE__) . 'lang/');
	}

	public function activate($network_wide) {
		// TODO define activation functionality here
	}

	public function deactivate($network_wide) {
		// TODO define deactivation functionality here
	}

	public function register_admin_styles() {
		wp_enqueue_style('bbpress-adv-recent-topics-admin-styles', plugins_url('bbpress-advanced-recent-topics/css/admin.css'));
	}

	public function register_admin_scripts() {
		wp_enqueue_script('bbpress-adv-recent-topics-admin-script', plugins_url('bbpress-advanced-recent-topics/js/admin.js'), array('jquery'));
	}

	public function register_widget_styles() {
		wp_enqueue_style('bbpress-adv-recent-topics-widget-styles', plugins_url('bbpress-advanced-recent-topics/css/widget.css'));
	}

	public function register_widget_scripts() {
		wp_enqueue_script('bbpress-adv-recent-topics-script', plugins_url('bbpress-advanced-recent-topics/js/widget.js'), array('jquery'));
	}
}

add_action('widgets_init', create_function('', 'register_widget("BBP_Recent_Topics_Widget_Advanced");'));