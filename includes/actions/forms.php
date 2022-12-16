<?php 

add_action('wp_ajax_wwup_save_options', 'wwup_save_options');
add_action('wp_ajax_nopriv_wwup_save_options', 'wwup_save_options');

function wwup_save_options(){
    $data = $_POST;
    $type = $data['type'];

    if(!wp_verify_nonce($data["wwup_save_{$type}_nonce"], "wwup_save_{$type}_nonce")):
        wp_send_json_error(__('Validation error.', 'wwup'));
    endif;
    unset($data["wwup_save_{$type}_nonce"]);
    unset($data['action']);
    unset($data['type']);
    extract($data);

    try{
        foreach($data as $key => $val):
            if($val == 'null' || $val == '' || !$val):
                $delete = delete_option($key);
            else:
                update_option($key, $val);
            endif;
        endforeach;

        wp_send_json(__('Option updated successfully', 'wwup'));
    } catch (Exception $e) {
        wp_send_json_error(__('Something went wrong. Please retry or contact a system administrator.', 'wwup'));
    }
}