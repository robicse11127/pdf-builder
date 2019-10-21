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
}