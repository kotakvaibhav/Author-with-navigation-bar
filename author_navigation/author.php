<?php
/**
 * Template Name: Author-list Page
 *
 * @package OceanWP WordPress theme
 */

?>

<?php get_header(); 


?>

<?php 
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
    'post_type' => 'kirjailijat',
    'post_status' => 'publish',
    //'category_name' => 'author-list',
    //'posts_per_page' => 5,
);
$author = new WP_Query( $args ); print_r($author);
//$sort_arr = array(); 
$fullname = array();
$post_id = array(); 
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
        		            <h2 class="heading-title">KIRJAILIJAT</h2>		
        		        </div>
        			</div>
        			<div class="elementor-element elementor-element-2320106 elementor-widget elementor-widget-heading" data-id="2320106" data-element_type="widget" data-widget_type="heading.default">
        			    <div class="elementor-widget-container">
        		            <h2 class="heading-title_after">Aakkosj채rjestyksess채</h2>		
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
                                <article class="card_box">
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
                    						<a class="post__thumbnail__link" href="<?php echo $data->post_name; ?>"><?php echo $data->post_title; ?></a>
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
        


<?php get_footer(); ?>
