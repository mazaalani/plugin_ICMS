<?php

/*
Plugin Name: icms-formulaire
Plugin URI: mon site
Description: remplace chaque instance de la chaîne de caractère [intro-cms-formulaire] dans le contenu WYSIWYG d’une page ou d’un post par un formulaire
Author: Amin Zaalani
Version: 1.0
*/

//creation de table personnalisée a l'activation du plugin
register_activation_hook(__FILE__, 'icmsform_activation');
function icmsform_activation()
{
    global $wpdb;    
    $table_name = $wpdb->prefix.'icms_formulaire';

    if ($wpdb->get_var("SHOW TABLES LIKE'$table_name'") != $table_name)
    {
        $sql = "CREATE TABLE $table_name(
                    id int NOT NULL AUTO_INCREMENT,
                    prenom varchar(50) NOT NULL,
                    nom varchar(50) NOT NULL,
                    courriel varchar(50) NOT NULL,
                    texte text NOT NULL,
                    PRIMARY KEY (id)
                )";

        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/* //suppression de la bd personnalisée a la desactivation du plugin
register_deactivation_hook(__FILE__, 'icmsform_deactivation');
function icmsform_deactivation() 
{
    global $wpdb;
    $table_name = $wpdb->prefix.'icms_formulaire';
    
        $sql = $wpdb->query("DROP TABLE IF EXISTS $table_name");
} */

//import fichiers style et scripts
add_action( 'init','icmsform_ajout_styles','',1,true);
function icmsform_ajout_styles() {
    wp_register_style('icmsform-styles', plugins_url('styles/styles.css',__FILE__ ));
    wp_enqueue_style('icmsform-styles');
    wp_register_script('icmsform-class', plugins_url('scripts/icms-class.js',__FILE__ ));
    wp_enqueue_script('icmsform-class');
    wp_register_script('icmsform-script', plugins_url('scripts/icms-script.js',__FILE__ ));
    wp_enqueue_script('icmsform-script');    
}

//ajout du plugin dans le menu de l'interface admin
add_action('admin_menu', 'icmsform_ajout_menu');
function icmsform_ajout_menu() 
{
    add_menu_page(
    'ICMS FORMULAIRE',          // Page title
    'ICMS FORMULAIRE',          // Menu title
    'manage_options',           // Capability
    'icmsform_custom_plugin_page',   // Menu slug
    'icmsform_ajout_formulaire'      // Callable function
    );
}

//link template
function icmsform_ajout_formulaire() {
    ob_start();
    include("templates/info.php");
    $output = ob_get_clean();
    echo $output;
}

//remplacer la chaine [intro-cms-formulaire] dans le contenu des pages et posts
add_filter('the_content', 'icmsform_affiche_form');
function icmsform_affiche_form($text) {
    ob_start();
    include("templates/formulaire.php");
    $output = ob_get_clean();
    return str_replace('[intro-cms-formulaire]', $output, $text);
}



