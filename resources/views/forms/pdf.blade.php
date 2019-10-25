<?php 
foreach($form as $item) {
    if( $item->type == 'upload-field' ) {
        echo '<img src="'.public_path('/storage/images').'/'.$item->value.'" />';
    }
    if( $item->type == 'text-field' || $item->type == 'textarea-field' ) {
        echo '<p>'.$item->value.'</p>';
    }
    if( $item->type == 'label-field' ) {
        echo '<p><strong>'.$item->value.'</strong></p>';
    }
    if( $item->type == 'checkbox-field' ) {
        if( $item->value == true ) : $checked = 'checked'; else : $checked = ''; endif;
        echo '<p><input type="checkbox" '.$checked.' /><strong>'.$item->label.'</strong></p>';
    }
}