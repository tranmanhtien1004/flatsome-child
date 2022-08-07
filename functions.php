<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION
// 
// Add Font Awesome
function wpb_load_fa() {
	wp_enqueue_style( 'wpb-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );

// add button buy now
add_action('woocommerce_after_add_to_cart_button','devvn_quickbuy_after_addtocart_button');
function devvn_quickbuy_after_addtocart_button(){
    global $product;
?>
    <style>
        .devvn-quickbuy button.single_add_to_cart_button.loading:after {
            display: none;
        }
        .devvn-quickbuy button.single_add_to_cart_button.button.alt.loading {
            color: #fff;
            pointer-events: none !important;
        }
        .devvn-quickbuy button.buy_now_button {
            position: relative;
            color: rgba(255,255,255,0.05);
        }
        .devvn-quickbuy button.buy_now_button:after {
            animation: spin 500ms infinite linear;
            border: 2px solid #fff;
            border-radius: 32px;
            border-right-color: transparent !important;
            border-top-color: transparent !important;
            content: "";
            display: block;
            height: 16px;
            top: 50%;
            margin-top: -8px;
            left: 50%;
            margin-left: -8px;
            position: absolute;
            width: 16px;
        }
    </style>
    <button type="button" class="button buy_now_button">
        <?php _e('Mua ngay', 'devvn'); ?>
    </button>
    <input type="hidden" name="is_buy_now" class="is_buy_now" value="0" autocomplete="off"/>
    <script>
        jQuery(document).ready(function(){
            jQuery('body').on('click', '.buy_now_button', function(e){
                e.preventDefault();
                var thisParent = jQuery(this).parents('form.cart');
                if(jQuery('.single_add_to_cart_button', thisParent).hasClass('disabled')) {
                    jQuery('.single_add_to_cart_button', thisParent).trigger('click');
                    return false;
                }
                thisParent.addClass('devvn-quickbuy');
                jQuery('.is_buy_now', thisParent).val('1');
                jQuery('.single_add_to_cart_button', thisParent).trigger('click');
            });
        });
    </script>
    <?php
}
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_cart_url(); //or wc_get_cart_url()
    }
    return $redirect_url;
}
// ẩn meta
// function remove_version_info() {
// return '';
// }
// add_filter('the_generator', 'remove_version_info');
// hết ẩn meta

// bỏ mặc định giao hàng tới địa chỉ khác
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

// Thêm biểu tượng giảm giá
add_filter('woocommerce_sale_flash', 'my_custom_sales_badge');
function my_custom_sales_badge() {
$img = '<img width="100px" height="100px" src="https://tshop2hand.com/wp-content/uploads/2022/07/sale-icon-products.png"></img>';
return $img;
}

// Add SKU after title product
add_action( 'woocommerce_after_shop_loop_item_title', 'custom_stock_after_title',100);
function custom_stock_after_title() {
    global $product;
    if ( $product-> get_stock_quantity() ) {
        echo 'Còn '.$product-> get_stock_quantity() . ' sản phẩm'.'<br>';
    }
}
// Short code mo ta san pham
function create_shortcode_desc() {
	 global $product;
    if ( $product-> get_description() ) {
        $content_desc = $product-> get_description();
		return $content_desc;
    }
}
add_shortcode( 'create_shortcode_desc', 'create_shortcode_desc' );

// Short code thông tin bổ sung
function thong_tin_bo_sung() {
	 global $product;
        $contet_get_weight = $product-> get_weight();
		$content_get_length = $product->get_length();
		$content_get_width = $product->get_width();
		$content_get_height = $product->get_height();
		ob_start();
		if($contet_get_weight){
			echo '<p>'.'Cân nặng: '.$contet_get_weight.'</p>';
		}
		if($content_get_length){
			echo '<p>'.'Chiều dài: '.$content_get_length.'</p>';
		}
		if($content_get_width){
			echo '<p>'.'Chiều rộng: '.$content_get_width.'</p>';
		}
		if($content_get_height){
			echo '<p>'.'Chiều cao: '.$content_get_height.'</p>';
		}
		$list_post = ob_get_contents();
		ob_end_clean();
		return $list_post;
}
add_shortcode( 'thong_tin_bo_sung', 'thong_tin_bo_sung' );

// Short code đánh giá
function danh_gia(){
	echo 'Xin lỗi chức năng đánh giá đang được thực hiện';
}
add_shortcode( 'danh_gia', 'danh_gia' );
// Sửa hiển thị giá sản phẩm
add_filter('woocommerce_get_price_html', 'custom_price', 99, 2 );
function custom_price(){
?>
<style>
.price_{
		line-height: 22px;
    	height: 22px;
    	font-size: 18px;
   	 	color: #FF5A00;
	}
.price_sale{
		text-decoration: line-through;
    	margin-top: 4px;
    	margin-right: 4px;
    	line-height: 14px;
    	height: 14px;
    	color: #757575;
    	font-size: 12px;
	}
.mod-discount{
    	margin-top: 4px;
    	margin-right: 4px;
    	line-height: 14px;
    	height: 14px;
    	color: #757575;
    	font-size: 12px;
}
</style>
<?php
	global $product;
	$get_price_html = number_format($product->price);
	if($product->is_on_sale()){
		$sale_price = $product->price;
		$regular_price = $product->regular_price;
		$price_regular_html =" <span class='price_sale'>".$regular_price.'₫ </span>'."<span class='mod-discount'>".'-'.round(($regular_price - $sale_price)/$regular_price*100).'%</span>';
	}
	ob_start();
    echo "<span class='price_'>".$get_price_html.'₫</span>';
	echo $price_regular_html;
	$price = ob_get_contents();
	ob_end_clean();
    return $price;
}
// Sửa tiêu đề sản phẩm product_summary
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
function change_title_product_summary(){
	global $product;
	$html = get_the_title();
?>
<style>
	.entry-title__{
		font-weight: 500;
		word-break: break-word;
		overflow-wrap: break-word;
		color: #000;
		font-size: 22px;
	}
</style>
<?php
	 echo "<h1  class='product-title product_title entry-title entry-title__'>".get_the_title().'</h1>';
}
add_action('woocommerce_single_product_summary','change_title_product_summary',5);

// Sửa tiêu đề sản phẩm loop_product_title
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
function change_product_title() {
	global $product;
	$slug__= get_permalink();
?>
<style>
	.woocommerce-loop-product__title{
		position: relative;
    	font-size: 14px;
    	height: 36px;
    	line-height: 18px;
    	color: #212121;
    	white-space: pre-wrap;
	}
</style>
<?php
    echo "<a  class='woocommerce-LoopProduct-link woocommerce-loop-product__link'"."href='$slug__'>"."<span class='woocommerce-loop-product__title'>".get_the_title().'</span>'.'</a>';
}
add_action('woocommerce_shop_loop_item_title','change_product_title');

// Hiển thị sao đánh giá sản phẩm
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action('woocommerce_single_product_summary', 'replace_product_rating', 6 );
add_action( 'woocommerce_get_price_html', 'custom_rating_after_shop_loop_item_title');
function custom_rating_after_shop_loop_item_title() {
    global $product;
    if ($product->get_rating_count() >= 0) {
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        add_action( 'woocommerce_after_shop_loop_item_title', 'replace_product_rating', 101 );
    }

}
// Content function
function replace_product_rating() {
    global $product;
    $rating_count = $product->get_rating_count();
    $average      = $product->get_average_rating();
	$html = "";
    for($i = 0; $i < 5; $i++) {
        	$html .= $i < $average ? '<span class="fa fa-star" style="color:#FFB900;font-size: 12px;"></span>' : '<span class="fa fa-star-o" style="color:#FFB900;font-size: 12px;"></span>';
    }
	echo $html.'('.$rating_count.')';
}
// Chèn lượt xem sản phẩm
add_action('wp', function() {
global $post;
$user_ip = $_SERVER['REMOTE_ADDR'];
$meta = get_post_meta( $post->ID, 'views_count', TRUE );
$meta = '' !== $meta ? explode( ',', $meta ) : array();
$meta = array_filter( array_unique( $meta ) );
if( ! in_array( $user_ip, $meta ) ) {
array_push( $meta, $user_ip );
update_post_meta( $post->ID, 'views_count', implode(',', $meta) );
}
});
// Hiển thị lượt xem sản phẩm
add_action('woocommerce_single_product_summary', 'custom_review_after_shop_loop_item_title', 7 );
add_action( 'woocommerce_after_shop_loop_item_title', 'custom_review_after_shop_loop_item_title',102);
function custom_review_after_shop_loop_item_title(){
	global $product;
        $id = $product->id;         
		$review		  = $product->get_review_count();
        $meta = get_post_meta( $id, 'views_count', TRUE );
        if(empty($meta))
        {
            $result = 0;
        }
        else
        {        
        $result = count(explode(',',$meta)); 
        }       
        echo "<span class='fa fa-eye' style='margin-left:6px;font-size: 12px;color: #285CBD;'> ".$result." </span>";
}

