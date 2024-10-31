<?php
/**
 * Plugin Name: Seznam Reporter (Webmaster Tools) plugin
 * Plugin URI: https://karelmares.cz/seznam-reporter-developer-tools-wordpress.html
 * Description: Tento plugin přidá do stránky meta tag pro ověření vlastníka webu při registraci stránky do Seznam Reporter
 * Version: 1.0.0
 * Author: Karel Mareš
 * Author URI: https://karelmares.cz
 * License: GPL2
 */


add_action('admin_menu', 'mares29_reporter_add_admin_menu');
add_action('admin_init', 'mares29_reporter_settings_init');
add_action('wp_head', 'mares29_inject_reporter_meta_tag');


function mares29_inject_reporter_meta_tag()
{
    $val = get_option("mares29_sreporter_settings");
    if (!empty($val["mares29_reporter_meta_tag"])) {
        printf('<meta name="seznam-wmt" content="%s"/>', $val["mares29_reporter_meta_tag"]);
    }
}


function mares29_reporter_add_admin_menu()
{
    add_options_page('Seznam Reportér', 'Seznam Reportér', 'manage_options', 'seznam_reporter', 'mares29_options_page');
}


function mares29_reporter_settings_init()
{
    register_setting('mares29_reporterPage', 'mares29_sreporter_settings');

    add_settings_section(
        'mares29_pluginPage_section',
        __('Přidání META tagu do HTML stránky pro ověření vlastníka webu', 'mares29-reporter-seznam'),
        'mares29_settings_section_callback',
        'mares29_reporterPage'
    );

    add_settings_field(
        'mares29_reporter_meta_tag',
        __('klíč', 'mares29-reporter-seznam'),
        'mares29_reporter_meta_tag_render',
        'mares29_reporterPage',
        'mares29_pluginPage_section'
    );


}


function mares29_reporter_meta_tag_render()
{
    $options = get_option('mares29_sreporter_settings');
    ?>
    <input type='text' name='mares29_sreporter_settings[mares29_reporter_meta_tag]'
           value='<?php echo $options['mares29_reporter_meta_tag']; ?>'>
    <?php
}


function mares29_settings_section_callback()
{
    echo __('Při registraci nové stránky do Seznam Reporter si jako metodu ověření webu zvolte "Přidání meta-tagu na homepage". Z následný obrazovky si zkopírujte textový řetězec, viz obrázek níže.<br><br><img src="https://seznam-reporter.karelmares.cz/29-seznam-reporter.png">', 'mares29-reporter-seznam');
}


function mares29_options_page()
{
    ?>
    <form action='options.php' method='post'>

        <h2>Seznam Reportér | Webmaster tools</h2>

        <?php
        settings_fields('mares29_reporterPage');
        do_settings_sections('mares29_reporterPage');
        submit_button();
        ?>

    </form>
    <?php
}

