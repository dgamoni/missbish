<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
//var_dump($full_size_image);
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
$missbish_annotated_product_hotspot = get_field('missbish_annotated_product_hotspot',$post->ID);
$missbish_product_image   = wp_get_attachment_image_src( $missbish_annotated_product_hotspot['image'], $thumbnail_size );
//var_dump($missbish_annotated_product_hotspot);
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
	
		<div class="con">
		  <img src="<?php echo $missbish_product_image[0]; ?>" style="width:400px;" />
		  
		  <?php 
			
			foreach ($missbish_annotated_product_hotspot["points"] as $key => $points) {
				$key++;
				$product = wc_get_product( $points["link"]["url"] );
				//var_dump($product);
				echo '<span class="feature points-'.$key.'" style="left:' . $points['x']*100 . '%;top:' . $points['y']*100 . '%;" data-product="'. $points["link"]["url"] .'" data-name="'.$product->name.'" data-link="'.get_permalink( $points["link"]["url"] ).'"></span>';
				echo "<style>.points-".$key.":before{content:'".$key."'}</style>";
			};

		  ?>
		<div class="content" style="left:0%;top:100%;">
		    <h2></h2>
		    <span></span>
	  	</div>

	</figure>
</div>


<style>
	.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images {
	    width: 60%;
	}
	.con { position: relative; width: 400px; height: 400px; }
	.con img { width: 100%; }
	.con .feature,
	.con .content { position: absolute; }

	.feature:before {
	    border-radius: 50%;
	    position: relative;
	    display: block;
	    width: 20px;
	    height: 20px;
	    text-align: center;
	    color: #fff;
	    line-height: 20px;
	    z-index: 10;
	    -webkit-transform: translate(-50%,-50%);
	    transform: translate(-50%,-50%);
	    background: rgba(0,0,0,.25);
	    cursor: pointer;
	}
</style>

<script>
	jQuery(document).ready(function($) {
		$('.feature').click(function() {
			var name = $(this).attr('data-name');
			var link  = $(this).attr('data-link');
		  $('.content h2').text( name );
		  $('.content span').text( link );
		});
	}); 
</script>