<?php

/**
 * Adds Podcast widget.
 */
class Podcast_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'podcast_widget', // Base ID
			esc_html__( 'Podcast OurHometown', 'podcast_domain' ), // Name
			array( 'description' => esc_html__( 'Scrapes availble podcast services', 'podcast_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
        
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

        // -- widget content --
        // TODO: figure out how to add widget to main content section 

        // fetch html if enabled
        if ($instance['auto'] == 'enabled') {
            // TODO: make file path dynamic based on url (use refresh option for now)
            $cache_file = dirname(__DIR__, 3).'/uploads/index.cache.php';
            $content ;

            // use cache if set and still fresh
            if($instance['refresh'] == 'cache' && file_exists($cache_file) && filemtime($cache_file) > time()-84600) {
                if ($instance['layout'] == 'vertical') {
                    echo "<div id=podcast-content-vertical>";
                    echo file_get_contents($cache_file);
                    echo "</div>";
                } else {
                    echo "<div id=podcast-content>";
                    echo file_get_contents($cache_file);
                    echo "</div>";
                }
            // cache not set or stale
            } else {
                // TODO: abstract fetching logic into function that returns content
                $ch = curl_init();
        
                // set options and url to scrape
                curl_setopt($ch, CURLOPT_URL, $instance['url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $html = curl_exec($ch);
            
                // load and parse html
                $dom = new DOMDocument();
                $dom->loadHTML($html);

                // xpath of the links in the modal
                $target = '/html/body/div[1]/div[3]/div/div[2]//a';

                $xpath = new DOMXPath($dom);

                // return all the links 
                $links = $xpath->evaluate($target);
                
                // iterate over links and build html 
                foreach($links as $link) {

                    $linkHref = $link->getAttribute('href');
                    $linkText = $link->textContent;
                    $subString = explode(" ", $linkText);

                    // save for later 
                    $content .= "<a id=$subString[0] href=$linkHref> $linkText </a>";
                }
                // display list of podcast services either vertically or horizontally 
                if ($instance['layout'] == 'vertical') {
                    echo "<div id=podcast-content-vertical>";
                    echo $content;
                    echo "</div>";
                } else {
                    echo "<div id=podcast-content>";
                    echo $content;
                    echo "</div>";
                }

                // write file to cache list
                // TODO: create new directory for each url cache
                $handle = fopen($cache_file, 'w+') or die('Unable to open file');
                fwrite($handle, $content);
                fclose($handle);
            }
        // fetching not enabled
        } else {
            echo 'Auto fetching is turned off...';
        }
        
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Podcast Services', 'podcast_domain' );

        $url = ! empty( $instance['url'] ) ? $instance['url'] : esc_html__( '', 'podcast_domain' );

        $auto = ! empty( $instance['auto'] ) ? $instance['auto'] : esc_html__( '', 'podcast_domain' );
        
        $refresh = ! empty( $instance['refresh'] ) ? $instance['refresh'] : esc_html__( '', 'podcast_domain' );

        $layout = ! empty( $instance['layout'] ) ? $instance['layout'] : esc_html__( '', 'podcast_domain' );
        
		?> 
		<p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'podcast_domain' ); ?></label> 
		    
            <input 
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_attr_e( 'URL:', 'podcast_domain' ); ?></label> 
		    
            <input 
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $url ); ?>">
		</p>

        <p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'auto' ) ); ?>"><?php esc_attr_e( 'Auto fetch:', 'podcast_domain' ); ?></label> 
		    
            <select
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'auto' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'auto' ) ); ?>" 
            >
                <option value="enabled" <?php echo ($auto == 'enabled') ? 'selected' : ''; ?>>
                    Enabled
                </option>
                <option value="disabled" <?php echo ($auto == 'disabled') ? 'selected' : ''; ?>>
                    Disabled
                </option>
            </select>
		</p>

        <p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'refresh' ) ); ?>"><?php esc_attr_e( 'Use New Data:', 'podcast_domain' ); ?></label> 
		    
            <select
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'refresh' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'refresh' ) ); ?>" 
            >
                <option value="always" <?php echo ($refresh == 'always') ? 'selected' : ''; ?>>
                    Always
                </option>
                <option value="cache" <?php echo ($refresh == 'cache') ? 'selected' : ''; ?>>
                    Cache Data
                </option>
            </select>
		</p>

        <p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_attr_e( 'Layout:', 'podcast_domain' ); ?></label> 
		    
            <select
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" 
            >
                <option value="vertical" <?php echo ($layout == 'vertical') ? 'selected' : ''; ?>>
                    Vertical
                </option>
                <option value="horizontal" <?php echo ($layout == 'horizontal') ? 'selected' : ''; ?>>
                    Horizontal
                </option>
            </select>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
        // updates fields and updates DB
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? sanitize_text_field( $new_instance['url'] ) : '';

        $instance['auto'] = ( ! empty( $new_instance['auto'] ) ) ? sanitize_text_field( $new_instance['auto'] ) : '';
        
        $instance['refresh'] = ( ! empty( $new_instance['refresh'] ) ) ? sanitize_text_field( $new_instance['refresh'] ) : '';

        $instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? sanitize_text_field( $new_instance['layout'] ) : '';

		return $instance;
	}

} // class Foo_Widget