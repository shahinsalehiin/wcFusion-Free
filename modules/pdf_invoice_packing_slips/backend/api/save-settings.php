<?php

$result = array();

/* Check if user has manage option capabilities */
if (current_user_can ('manage_options')) {

    if ($this->base_admin->base_admin->db->getModuleStatus ($this->base_admin->module_slug)) {
        $post_data = array();
        $final_data = array();
        $wfpi_disabled_status = array();

        if (isset($_REQUEST) && $_REQUEST['data']) {

            $post_data = $_REQUEST['data'];

            //generate final post data
            foreach ( $post_data as $item ){
                if( $item['name'] == 'wfpi_disabled_status' ){
                    $wfpi_disabled_status[] =  $item['value'];
                    $final_data[ $item['name'] ] = implode (',', $wfpi_disabled_status);
                } else{
                    $final_data[ $item['name'] ] = $item['value'];
                }
            }

        } else {
            $result = array("status" => 'false');
        }

        if ($this->base_admin->utils->save_settings ($final_data)) {
            $result = array("status" => 'true');
        } else {
            $result = array("status" => 'false');
        }

    } else {
        $result = array("status" => 'false');
    }

} else {
    $result = array("status" => 'false');
}

echo json_encode ($result, JSON_UNESCAPED_UNICODE);