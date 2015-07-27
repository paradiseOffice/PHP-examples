<?php global $theme; get_header(); ?>

    <div id="main">
    
        <?php $theme->hook('main_before'); ?>
    
        <div id="content">
            
            <?php $theme->hook('content_before'); ?>
        
            <h2 class="page-title"><?php
    
               /* If this is a daily archive */ 
               if (is_day()) { printf( __( 'Daily Archives: <span>%s</span>', 'themater' ), get_the_date() ); 
                
                /* If this is a monthly archive */ 
                } elseif (is_month()) { printf( __( 'Monthly Archives: <span>%s</span>', 'themater' ), get_the_date('F Y') );
                  
                /* If this is a yearly archive */ 
                } elseif (is_year()) { printf( __( 'Yearly Archives: <span>%s</span>', 'themater' ), get_the_date('Y') );
                
                /* If this is a general archive */ 
                } else { _e( 'Blog Archives', 'themater' ); } 
            ?></h2>
        
            <?php 
                $is_post_wrap = 0;
                    if (have_posts()) : while (have_posts()) : the_post();
                     
                    $is_post_wrap++;
                        if($is_post_wrap == '1') {
                            ?><div class="post-wrap clearfix"><?php
                        }
                        get_template_part('post', 'archive');
                        
                        if($is_post_wrap == '2') {
                            $is_post_wrap = 0;
                            ?></div><?php
                        }
                endwhile;
                
                else :
                    get_template_part('post', 'noresults');
                endif; 
                    
                    if($is_post_wrap == '1') {
                        ?></div><?php
                    } 
                
                get_template_part('navigation');
            ?>
            
            <?php $theme->hook('content_after'); ?>
        
        </div><!-- #content -->
    
        <?php get_sidebars(); ?>
        
        <?php $theme->hook('main_after'); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>
