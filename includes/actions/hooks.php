<?php 

add_filter('the_content', 'wwup_call_to_action', 0, 1);

function wwup_call_to_action( $content ){
    if(is_singular('post') &&  in_the_loop() && is_main_query() ):
		global $post;
        $tags = get_the_tags($post);

		$content = $post->post_content;

		$blocks = array_values(array_filter(parse_blocks($content), function($block){
			return $block['blockName'] == 'core/paragraph';
		}));

        $cta = get_option('wwup_call_to_action');

        if($cta && isset($blocks[3])):
            $p = $blocks[3]['innerHTML'];
			$pFinal = str_replace('</p>', "</p>$cta", $p);
			$content = str_replace($p, $pFinal, $content);
        endif;
    endif;

    return $content;
}