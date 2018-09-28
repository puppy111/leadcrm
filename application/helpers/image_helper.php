<?php
function image_thumb( $image_path, $img_name , $alt_name, $width, $height ) 
{
    // Get the CodeIgniter super object
    $CI =& get_instance();
	
	$ext       = end(explode(".", $img_name));
	$file_name = basename($image_path.$img_name.'/'.$img_name, ".".$ext);

    // Path to image thumbnail
    $image_thumb = $image_path.'cache/'.$file_name.'_'.$width . '_' . $height . '.'.$ext;

    if ( !file_exists( $image_thumb ) ) 
	{
        // LOAD LIBRARY
        $CI->load->library( 'image_lib' );

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path.$img_name;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = FALSE;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize( $config );
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return '<img src="' . $image_thumb . '"  alt="'.$alt_name.'"/>';
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */

//https://jrtashjian.com/2009/02/image-thumbnail-creation-caching-with-codeigniter/