<?php 
/**
 * Template della pagina Call To action  
 */

function wwup_layout(){
    $tinyMCE = get_option('wwup_tiny_mce_api_key');
    ?>
    <div class="wp-content">
        <div class="wpbody">
            
            <div class="wpbody-content">
                <h1><?= __('Work with us settings', 'wwup'); ?></h1>
                <p><?= __('Add TinyMCE key to show the editor', 'wwup'); ?></p>
                <div class="wrap">
                    <form onsubmit="save_form_options(event)" id="save_options">
                        <input type="hidden" id="wwup_save_options_nonce" value="<?= wp_create_nonce('wwup_save_options_nonce'); ?>" name="wwup_save_options_nonce" />
                        <input type="hidden" id="action_options" value="wwup_save_options" name="action" />
                        <input type="hidden" id="type_options" value="options" name="type" />
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="wwup_tiny_mce_api_key"><?= __('Copy/paste your TinyMCE Key', 'wwup'); ?></label></th>
                                    <td>
                                        <input type="<?= $tinyMCE ? 'password' : 'text' ?>" id="wwup_tiny_mce_api_key" name="wwup_tiny_mce_api_key" value="<?= $tinyMCE; ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="submit">
                            <button type="submit" name="submit" id="submit-options" class="button button-primary"><?= __('Save option', 'wwup'); ?></button>
                        </p>
                    </form>
                </div>
                <?php if($tinyMCE): ?>
                    <h1><?= __('Call to action text editor', 'wwup'); ?></h1>
                    <p><?= __('Call to action will be shown after the fourth paragraph in the posts tagged "governo".', 'wwup'); ?></p>
                    <div class="wrap">
                        <form onsubmit="save_form_options(event)" id="save_cta">
                            <input type="hidden" id="wwup_save_cta_nonce" value="<?= wp_create_nonce('wwup_save_cta_nonce'); ?>" name="wwup_save_cta_nonce" />
                            <input type="hidden" id="action_cta" value="wwup_save_options" name="action" />
                            <input type="hidden" id="type_cta" value="cta" name="type" />

                            <textarea id="call-to-action" name="wwup_call_to_action">
                                <?php if($cta = get_option('wwup_call_to_action')):
                                    echo $cta; 
                                endif; ?>
                            </textarea>

                            <p class="submit">
                                <button type="submit" name="submit" id="submit-cta" class="button button-primary" OnClientClick="tinyMCE.triggerSave(false,true)"><?= __('Save html', 'wwup'); ?></button>
                            </p>
                        </form>
                        <script>
                            tinymce.init({
                                selector: 'textarea#call-to-action',
                                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                            });
                        </script>
                    </div>    
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php 
}
