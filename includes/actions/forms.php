<?php 

add_action('wp_ajax_wwup_save_options', 'wwup_save_options');
add_action('wp_ajax_nopriv_wwup_save_options', 'wwup_save_options');

/**
 * Gestisce il salvataggio delle opzioni nel database. 
 * 
 * Restituisce una json response.
 */

function wwup_save_options(){
    $data = $_POST;
    $type = $data['type'];

    if(!wp_verify_nonce($data["wwup_save_{$type}_nonce"], "wwup_save_{$type}_nonce")): // verifico il nonce del form
        wp_send_json_error(__('Validation error.', 'wwup'));
    endif;

    /**
     * Rimuovo gli elementi di $data non più necessari
     */

    unset($data["wwup_save_{$type}_nonce"]); 
    unset($data['action']);
    unset($data['type']);

    extract($data); // estraggo le chiavi dall'array $data

    try{
        foreach($data as $key => $val):
            if($val == 'null' || $val == '' || !$val):
                $delete = delete_option($key); // se il valore passato dal form è vuoto o nullo, elimino l'opzione
            else:
                update_option($key, $val); // altrimenti la aggiorno
            endif;
        endforeach;

        wp_send_json(__('Option updated successfully', 'wwup'));
    } catch (Exception $e) {
        wp_send_json_error(__('Something went wrong. Please retry or contact a system administrator.', 'wwup'));
    }
}