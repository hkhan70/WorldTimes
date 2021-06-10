<?php
if ( ! defined( 'WPINC' ) ) die;

global $wpdb;
$id = isset( $_REQUEST['id'] ) ? absint($_REQUEST['id']) : '';
$pagenum = isset( $_REQUEST['paged'] ) ? absint($_REQUEST['paged']) : 0;
$search_orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array('subject', 'email', 'date'))) ? $_REQUEST['orderby'] : ''; 
$search_order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : '';
$search_date = isset ( $_REQUEST['date'] ) ? sanitize_text_field($_REQUEST['date']) : '';
$search_key = isset( $_REQUEST['s'] ) ? sanitize_text_field($_REQUEST['s']) : '';
$search_view = isset( $_REQUEST['view'] ) ? sanitize_text_field($_REQUEST['view']) : 'inbox';
$form_id = isset( $_REQUEST['form'] ) ? absint($_REQUEST['form']) : '';
$back_link = get_admin_url(get_current_blog_id(), 'admin.php?page=sform-submissions') .'&form='.$form_id.'&view='.$search_view.'&paged='.$pagenum.'&order='.$search_order.'&orderby='.$search_orderby.'&date='.$search_date.'&s='.$search_key;
if (!empty($id)) { 
	$item = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}sform_submissions WHERE id = %d", $id), ARRAY_A);
    if ( $item['status'] == 'new') {
	$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->prefix}sform_submissions SET status = 'read' WHERE id = %d", $id) );   
    }
}
add_meta_box('sform_entrie_meta_box', __('Request ID', 'simpleform-contact-form-submissions').': ' . $id, array ($this, 'sform_entrie_meta_box_handler'), 'view_sform_entrie', 'normal', 'default');
$icon = version_compare(get_bloginfo('version'),'5.0', '>=') ? 'dashicons-buddicons-pm' : 'dashicons-media-text';
?>
<div class="wrap"><h1 class="backend2"><span class="dashicons <?php echo $icon; ?>"></span><?php esc_html_e( 'Submitted Message', 'simpleform-contact-form-submissions' );?>
<span class="backlist"><a class="return-list" href="<?php echo esc_url($back_link) ?>">
<?php _e('Back to Submissions list', 'simpleform-contact-form-submissions')?></a></span></h1>  
<input type="hidden" name="id" value="<?php echo esc_attr($item['id']) ?>"/><div class="metabox-holder" id="poststuff"><div id="post-body"><div id="post-body-content">
<?php do_meta_boxes('view_sform_entrie', 'normal', $item); ?></div></div></div></div>