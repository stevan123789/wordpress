<?php 
/* #Welcome to plugin hooks page.
**
**
*/


/******** Disable update notification for individual plugins *********/
function filter_plugin_updates( $value ) {
    unset( $value->response['akismet/akismet.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

?>
