<?php

//si uninstall.php n'est pas appelé par wordpress die
if (!defined('WP_UNINSTALL_PLUGIN'))
{
    die;
}

global $wpdb;
$table_name = $wpdb->prefix.'icms_formulaire';

$squl = $wpdb->query("DROP TABLE IF EXISTS $table_name");