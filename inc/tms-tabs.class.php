<?php
	
	class TmsTabs 
	{	
		private $tabs;
		private $active;
		private $addScript;

		/**
		 * Initialises the plugin by registering assets & adding the shortcodes
		 *
		 * @return void		 
		 */

		public function __construct ()
		{	
			$this->enqueueAssets();
			$this->addShortcodes();
			$this->addFilters();
		}

		/**
		 * Adds hooks for assets to be added
		 *
		 * @return void		 
		 */

		public function enqueueAssets ()
		{	
			add_action('wp_enqueue_scripts', array(&$this, 'registerScript'));
		}

		/**
		 * Adds filters for scripts and shortcode character removal
		 *
		 * @return void		 
		 */

		public function addFilters ()
		{
			add_action('wp_footer', array(&$this, 'printScript'));
			add_filter('the_content', array(&$this, 'removeChars'));
		}

		/**
		 * Register the JS Script
		 *
		 * @return void		 
		 */

		public function registerScript ()
		{
			wp_register_script('tms-tabs', plugin_dir_url(__FILE__) . 'assets/js/tms-tabs.min.js', 'jquery', '1.0', true);
			wp_register_style('tms-tabs', plugin_dir_url(__FILE__) . 'assets/css/tms-tabs.css');
		}

		/**
		 * Prints the JS Script
		 *
		 * @return void		 
		 */

		public function printScript ()
		{
			if (!$this->addScript)
			{
				return false;
			}

			wp_enqueue_script('tms-tabs');
			wp_enqueue_style('tms-tabs');
		}

		/**
		 * Adds the shortcodes into Wordpress 'add_shortcode' method
		 *
		 * @return void		 
		 */

		public function addShortcodes ()
		{
			add_shortcode('tabs', array(&$this, 'tabsShortcode'));
			add_shortcode('tab', array(&$this, 'tabShortcode'));
		}

		/**
		 * Tabs callback | Renders shortcode for a set of tabs
		 *
		 * @param array $atts Attributes passed to the shortcode
		 * @param string $content Content passed into the shortcode
		 * @return void		 
		 */

		public function tabsShortcode ($atts, $content = '')
		{	
			$html            = '';
			$this->tabs      = array();
			$this->addScript = true;

			$attributes  = shortcode_atts(array(), $atts);
			$tabsContent = do_shortcode($content);

			$html .= '<div class="tms-tabs" data-tms-tabs>';

				$html .= '<nav><ul>';

				foreach ($this->tabs as $index => $title)
				{
					$html .= '<li '.(($index === 0) ? 'class="active"' : '').'>
								<a data-tab-navigation="'.($index + 1).'">'.$title.'</a>
							  </li>';
				}

				$html .= '</ul></nav>';

				$html .= $tabsContent;

			$html .= '</div>';

			return $html;
		}


		/**
		 * Tab callback | Renders shortcode for a tabbed section
		 *
		 * @param array $atts Attributes passed to the shortcode
		 * @param string $content Content passed into the shortcode
		 * @return void		 
		 */

		public function tabShortcode ($atts, $content = '')
		{	
			$html = '';

			$attributes = shortcode_atts(array(
				'title' => ''
			), $atts);

			array_push($this->tabs, $attributes['title']);

			$html .= '<div '.((count($this->tabs) === 1) ? 'class="active"' : '').' data-tab-container="'.(count($this->tabs)).'">';
				$html .= do_shortcode($content);
			$html .= '</div>';

			return $html;
		}

		/**
		 * Removes <br /> & <p> tags from inside shortcode so formatting can be used
		 *
		 * @param array $content Content of the post
		 * @return String $html content without the troublesome tags		 
		 */

		public function removeChars ($content)
		{
			// array of custom shortcodes requiring the fix 
			$block = join("|",array("tabs", "tab"));

			// opening tag
			$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
				
			// closing tag
			$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

			return $rep;
		}
	}

?>