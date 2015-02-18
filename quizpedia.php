<?php
/**
 * Plugin Name: QuizPedia
 * Plugin URI: http://www.quizpedia.com/wordpress
 * Description: Embed a QuizPedia quiz on your site
 * Version: 1.0
 * Author: quizpedia
 * Author URI: http://www.quizpedia.com
 * License: GPL2
 */
/*  Copyright 2014 QuizPedia

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Add Shortcode
function embed_quiz( $atts ) {
    $options = get_option('qp_plugin_options');
    // Attributes
    $atts = shortcode_atts(
            array(
                'id' => '',
                'w' => '320',
                'h' => '500',
            ), $atts );
    // Code
    if($options['embed_type'] == 'quiz'){
        return '<div data-qid="'.$atts['id'].'" style="width:'.$atts['w'].'px;height:'.$atts['h'].'px" class="qpembed"></div><script type="text/javascript" src="//qp.quizpedia.com/js/embed.js" async="true"></script>';
    }
    return '<script type="text/javascript" src="//qp.quizpedia.com/js/qp-embed.js?d=div&q='.$atts['id'].'&w='.$atts['w'].'" async="true"></script>';
}
function plugin_settings() {
    register_setting( 'qp-settings-group', 'optin' );
    register_setting( 'qp_plugin_options', 'qp_plugin_options', 'qp_plugin_options_validate' );
    add_settings_section('plugin_embed', 'QuizPedia Embed Settings', 'plugin_section_embed', 'qp_plugin');
    add_settings_field('qp-plugin-embed-type', 'Embed full quizzes', 'plugin_embed_type', 'qp_plugin', 'plugin_embed');

}
function qp_create_menu() {
    add_options_page('QuizPedia Plugin Settings', 'QuizPedia Settings', 'manage_options', 'plugin', 'qp_settings_page');
    add_action( 'admin_init', 'plugin_settings' );
}

add_shortcode( 'qp', 'embed_quiz' );
add_action( 'admin_menu', 'qp_create_menu' );


function qp_settings_page() {
    $icon = plugin_dir_path( __FILE__ ).'logo.png';
?>
    <div class="wrap">
        <div style="background-color: black; width: 100%; height: 68px; padding-top: 17px;">
            <img src="<?php echo $icon ?>" />
        </div>

        <form method="post" action="options.php">
            <?php settings_fields( 'qp_plugin_options' ); ?>
            <?php do_settings_sections( 'qp_plugin' ); ?>
            <br  />
            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
            <p>Powered by <a href="//www.quizpedia.com">QuizPedia</a></p>
        </form>
    </div>
<?
}

function plugin_section_embed() {
    echo '<p>Choose wether to embed full QuizPedia quizzes or QuizPedia cards. Embedding full quizzes adds a link to <a href="//www.quizpedia.com">QuizPedia</a><br/>See <a href="//www.quizpedia.com">QuizPedia</a> for more details on sharing quizzes.</p>';
}
function plugin_embed_type() {
    $options = get_option('qp_plugin_options');
    $checked = $options['embed_type'] == 'quiz' ? ' checked="checked"':'';
    echo "<input id='qp-plugin-embed-type' name='qp_plugin_options[embed_type]' value='quiz' type='checkbox'{$checked} />";
}

function qp_plugin_options_validate($input) {
    return $input;
/*    $newinput['embed_type'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
        $newinput['text_string'] = '';
    }
    return $newinput;*/
}
/*
 * [qp id="548edb41333565003eff0000"]
 * */
?>
