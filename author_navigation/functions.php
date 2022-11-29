<?php
/**
 * Plugin Name: blog-naviagation
 * Plugin URI: 
 * Description: Private plugin for import
 * Author: vaibhav
 * Version: 1.0.0
 * Text Domain: blog-naviagation
 */


// 
//custom code

add_action( 'init', 'create_writers' );
function create_writers() {
    register_post_type( 'writers',
        array(
            'labels' => array(
                'name' => 'Writers',
                'singular_name' => 'Writers',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Writers',
                'edit' => 'Edit',
                'edit_item' => 'Edit Writers',
                'new_item' => 'New Writers',
                'view' => 'View',
                'view_item' => 'View Writers',
                'search_items' => 'Search Writers',
                'not_found' => 'No Writers found',
                'not_found_in_trash' => 'No Writers found in Trash',
                'parent' => 'Parent Writers'
            ),
      'public' => true,
            'menu_position' => 4,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'rewrite' => array('slug' => 'writers','with_front' => true),
            'menu_icon' => 'dashicons-buddicons-buddypress-logo',
            'has_archive' => true
          
        )
    );
} 


add_action( 'wp_enqueue_scripts', 'custom_css_and_js' );
function custom_css_and_js() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	// $theme   = wp_get_theme( 'OceanWP' );
	// $version = $theme->get( 'Version' );
	
    wp_enqueue_script( 'custom-script', plugin_dir_url(__FILE__).'custom.js', array( 'jquery' ) );
    wp_enqueue_style('child-style', plugin_dir_url(__FILE__).'custom_style.css' );
    
    $myajax_objet = array('ajax_url' => admin_url( 'admin-ajax.php' ),);

    wp_localize_script( 'custom-script', 'my_object', $myajax_objet );
}


add_action( 'wp_ajax_nopriv_get_char', 'get_alphabet_char' );
add_action( 'wp_ajax_get_char', 'get_alphabet_char' );
function get_alphabet_char(){  
    $args = array(
        'post_type' => 'writers',
        'post_status' => 'publish',
        //'category_name' => 'kirjailijat',
        );
    $author = new WP_Query( $args ); 
    if ( $author->have_posts() ) :
        while ( $author->have_posts() ) :
            $author->the_post();
            $post_id[] = get_the_ID(); 
            $fullname[] = substr(get_the_title(), strpos(get_the_title(), " ") + 1); 
        endwhile;  
           
            
    endif;
    $last_name_arr = array_combine($post_id,$fullname);
    
   
    $alphabet = $_POST['char'];
    $postid = array();
    foreach ($last_name_arr as $key=>$model) {
        $char[] = $model[0];
        if ($model[0] == $alphabet || $model[0] == strtolower($alphabet)) {
            $postid[] = $key;
        }
       
    }
    
    
    $args = array(
    'post__in'    => $postid,
    'post_type'   => 'writers',
    );
    $char_author = new WP_Query( $args );
    $post = array();
    if ( $char_author->have_posts() ) :
        while ( $char_author->have_posts() ) :
            $char_author->the_post();
            $postid = get_the_ID(); 
            $title = get_the_title(); 
            $image = get_the_post_thumbnail($postid);
            $text = get_the_content($postid);
            $post_link = get_post_permalink($postid);
            $posts[] = array('title'=>$title,'image'=>$image,'text'=>$text,'postlink'=>$post_link);
        endwhile;  
    endif;
   
    echo json_encode($posts);
    die();
}

add_shortcode('show_writer_list','display_all_writer_list');
function display_all_writer_list(){
  
    $alphabetUpper = range('A', 'Z'); 

    ?>
    <div class="listing_container" >  
        <div class="structure">  
            <div align="center">  
             <?php  
                  $character = range('A', 'Z');  
                  echo '<ul class="listing">';  
                  foreach($character as $alphabet)  
                  {  
                       echo '<li style="padding: 5px 10px !important; font-size: 20px;" class="alphabet" data-char='.$alphabet.' id="alphabet"><a href="index.php?character='.$alphabet.'">'.$alphabet.'</a></li>';  
                  }  
                  echo '</ul>';  
             ?>  
             </div> 
        </div>
    </div><?php
 
$args = array(
    'post_type' => 'writers',
    'post_status' => 'publish',
    //'posts_per_page' => 5,
);
$author = new WP_Query( $args );
$sort_arr = array(); 
$fullname = array(); 
    if ( $author->have_posts() ) :
        while ( $author->have_posts() ) :
            $author->the_post();
            $post_id[] = get_the_ID(); 
            $fullname[] = substr(get_the_title(), strpos(get_the_title(), " ") + 1); 
        endwhile;  
           
            
    endif;
    $last_name_arr = array_combine($post_id,$fullname);
    $sort = asort($last_name_arr);  ?>


    <section class="elementor-section elementor-top-section elementor-element elementor-element-8cd2da2 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="8cd2da2" data-element_type="section">
        <div class="gap-default">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-889cb19" data-id="889cb19" data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-3b156f7 elementor-widget elementor-widget-heading" data-id="3b156f7" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                            <h2 class="heading-title">WRITERS</h2>      
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-2320106 elementor-widget elementor-widget-heading" data-id="2320106" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                            <h2 class="heading-title_after">In alphabetical order</h2>      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="main_container">
        <div>
            <div>
                <div>
                    <div>
                        <style></style>                                     
                    </div>
                </div>
                <div>
                    <div>
                        <div class="post_container author_data">
                            <?php
                            foreach($last_name_arr as $postid => $last_name){ 
                                $data = get_post($postid); 
                                $author_image = get_the_post_thumbnail($postid); //post_title, post_content
                                ?>
                                <article class="card_box <?php echo 'author_'.substr($last_name,0,1);?>">
                                    <a class="link" href="<?php echo $data->post_name; ?>">
                                        <div class="post_thumbnail">
                                        <?php
                                            if ( $author_image ) :
                                                echo $author_image;
                                            endif;
                                        ?>
                                        </div>
                                    </a>
                                    <div class="post_text">
                                        <h3 class="post_title">
                                            <a class="post__thumbnail__link" href="<?php the_permalink(); ?>"><?php echo $data->post_title; ?></a>
                                        </h3>
                                        <div class="post_excerpt">
                                            <p><?php echo $data->post_content; ?></p>
                                        </div>
                                    </div>
                                </article>      
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}