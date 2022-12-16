<?php 

add_filter('the_content', 'wwup_call_to_action', 0, 1);

/**
 * Modifica il contenuto dell'articolo in modo tale da visualizzare la call to action dopo il quarto paragrafo, se questo è taggato "governo"
 */

function wwup_call_to_action( $content ){
    if(is_singular('post') &&  in_the_loop() && is_main_query() ):
		global $post;

        if(has_tag('governo', $post)): // verifico se è taggato governo
            $blocks = array_values(array_filter(parse_blocks($content), function($block){
                return $block['blockName'] == 'core/paragraph';
            }));

            $cta = get_option('wwup_call_to_action');

            if($cta && isset($blocks[3])): // verifico se esiste il quarto paragrafo
                $p = $blocks[3]['innerHTML'];
                $pFinal = str_replace('</p>', '</p>'.str_replace('\"', '', $cta), $p); // appendo la call to action al quarto paragrafo
                $content = str_replace($p, $pFinal, $content); 
            endif;
        endif;
    endif;

    return $content; // restituisco il contenuto
}