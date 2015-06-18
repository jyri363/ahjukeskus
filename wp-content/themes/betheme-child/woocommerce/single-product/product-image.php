<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>

<div class="images">

	<?php
	
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' );
		// Valib pildid
		$setImages = get_post_meta( '2572', 'jckpc_images', true );
        //$defaults = get_post_meta( '2572', 'jckpc_defaults', true );
		//html_show_array($setImages);
		//wp_reset_postdata();
		$images = array();
		$imagestypes = array(); 
		$imagescolors = array();
		$imagesheight = array();
		 if( $setImages['background'] && $setImages['background'] != '' ) {
            
            $imgSrc = wp_get_attachment_image_src($setImages['background'], apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
            $images[] = '<img id="jckpc_image_background" src="'.$imgSrc[0].'">';
        
        }
		$img_i = 1;
		
		$i = 1;
		// otsic sobivad pildid valmis
		foreach($setImages['jckpc-pa_vali-ahju-varv'] as $image_id => $attVals) { // looping on user-selected attachment IDs
			$image_attributes = wp_get_attachment_image_src( $attVals , apply_filters( 'single_product_large_thumbnail_size', 'shop_single' )); // returns an array
			$imagescolors[$i] = $image_id;
			$images[$img_i] = '<div id="colors-'.$image_id.'" style="display: none" name="colors-'.$image_id.'" class="jjk-test"><img src="'.$image_attributes[0].'"></div>';
			$img_i++;
			$i++;
		} // end loop
		$i = 1;
		foreach($setImages['jckpc-pa_ukse-tuup'] as $image_id => $attVals) { // looping on user-selected attachment IDs
			$image_attributes = wp_get_attachment_image_src( $attVals , apply_filters( 'single_product_large_thumbnail_size', 'shop_single' )); // returns an array
			$imagestypes[$i] = 'types-'.$image_id;
			$images[$img_i] = '<div id="types-'.$image_id.'" style="display: none" name="types-'.$image_id.'"><img src="'.$image_attributes[0].'"></div>';
			$img_i++;
			$i++;
		} // end loop
		$i = 1;
		foreach($setImages['jckpc-pa_ahju-korgus'] as $image_id => $attVals) { // looping on user-selected attachment IDs
			$imagesheight[$i] = $image_id;
			$i++;
		} // end loop
		
		
		?>
 
<script>

// kuvab alguspildid 
$(document).ready(function(){
	var p = "";
	var text = "";
	var link = "";
	var valC = "";
	var valCS = "";
	var valT = "";
	var valK = "";
	// 
	$('.variation_form_section').one('click', '*', function() {
			$( ".hide_jjk" ).hide();
	})
	// kuvab "RAL-kataloogi" lingi
	$('.jjk_test_pa_vali-ahju-varv').each(function() {
        text = $(this).text();
		link = $(".answer p").html();
        $(this).html(text.replace('RAL-kataloogi', link)); 
    });
	// kuvab valitud pildi
	$('#attribute_pa_vali-ahju-varv').each(function() {
		valC = "jckpc-"+$( this ).attr( "value" );
		valCS = "#colors-"+valC;
		$('#'+valC).addClass("selected");
		$( valCS ).show();
	});
	$('#pa_ukse-tuup option:selected').each(function() {
		valT = "#types-"+$( this ).attr( "id" );
		$( valT ).show();
	});
	$('#attribute_pa_ahju-korgus').each(function() {
		valK = "jckpc-"+$( this ).attr( "value" );
		$('#'+valK).addClass("selected");
	});
})

// valitud uksetüübi kuvamine
$(document).change(function() {
	var str = "";
	var strTitle = "";
	
	$( "#pa_ukse-tuup option:selected" ).each(function() {
	  str += "types-"+$( this ).attr( "id" );
	  strTitle += $( this ).text();
	  <?php foreach($imagestypes as $image) { ?>
		$( "#<?php echo $image ?>" ).hide();
		if (str == jQuery("#<?php echo $image ?>").attr( "name" ))  
			$( "#<?php echo $image ?>" ).show();	
	<?php } ?>	
	});
	$( ".jjk-type" ).text(strTitle);
	$( "#jjk-type-test" ).text(strTitle);
})
// valitud ahju värvi kuvamine
<?php foreach($imagescolors as $image) { ?>
$(document).ready(function(){
	var strv = "";
	var strvTitle = "";
	
	$("#<?php echo $image ?>").click(function(){
		strv = "colors-"+$( this ).attr( "id" );
		strvTitle = $( this ).text();

		$( ".jjk-color" ).text( strvTitle );
		$( "#jjk-color-test" ).text( strv );
		$( ".jjk-test" ).hide();	
		$( "#colors-<?php echo $image ?>" ).show();	
	})
})
<?php } ?>
// valitud ahju kõrguse kuvamine
<?php foreach($imagesheight as $image) { ?>
$(document).ready(function(){
	var strh = "";
	var strhTitle = "";
	//var p = "";
	$("#<?php echo $image ?>").click(function(){
		strh = "height-"+$( this ).attr( "id" );
		strhTitle = $( this ).text();
		$( ".jjk-height" ).text( strhTitle );
		$( "#jjk-height-test" ).text( strh );	
		/*if($( "*" ).hasClass( "price" ) == true){
			p = $( ".price" ).text();
			$( "#test" ).text(p);
		}*/
		
	})
})
<?php } ?>
</script>
<div id='jjk-color-test' style="display: none"></div>
<div id='jjk-type-test' style="display: none"></div>
<div id='jjk-height-test' style="display: none"></div>
<div id='test' ></div>
<?php  
		//print html
		echo '
			<style>
				#jckpc_images {width: 100%;margin-left: auto; margin-right: auto;float: none;margin-top: 0;margin-right: 0;margin-bottom: 0px;margin-left: 0;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;background: none;}#jckpc_thumbnails {margin: 10px -5px -10px;}#jckpc_thumbnails a {float: left;display: inline;width: 33.3333333333%;padding: 0 5px 10px;}#jckpc_image_wrap #jckpc_loading {background: transparent;}#jckpc_image_wrap #jckpc_loading i {font-size: 20px;line-height: 20px;margin-top: -10px;color: #CCCCCC;}@media (max-width: 768px) {#jckpc_images {width: 100%;margin-left: auto; margin-right: auto;float: none;margin-top: 0;margin-right: 0;margin-bottom: 0px;margin-left: 0;}}
			</style>';
		echo '<div id="jckpc_images">';
        
            echo '<div id="jckpc_image_wrap" data-loading="0">';
   		

                foreach($images as $image) {
                    
                    echo $image;
                
                }
                
                echo '<div id="jckpc_loading" style="display: none; opacity: 0;"><i class="jckpc-icn-spin5 animate-spin"></i></div>';	   		
            
            echo '</div>';
        
        echo '</div>';
	
	?>
	

</div>
<div class="single_variation price_v"></div>
<div class="price_v hide_jjk"><span class="price">
<?php echo $product->get_price_html(); ?>
</span></div>