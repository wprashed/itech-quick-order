<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       iTech Quick Order
 * Plugin URI:        https://itech-softsolutions.com/plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            iTech Theme
 * Author URI:        https://itech-softsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       itqo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ITQO_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-itqo-activator.php
 */
function activate_itqo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-itqo-activator.php';
    Itqo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-itqo-deactivator.php
 */
function deactivate_itqo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-itqo-deactivator.php';
    Itqo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_itqo');
register_deactivation_hook(__FILE__, 'deactivate_itqo');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-itqo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_itqo()
{

    $plugin = new Itqo();
    $plugin->run();
}

add_action('admin_menu', function () {
    add_menu_page(
        __('Quick Order Create', 'itqo'),
        __('iTech Quick Order', 'itqo'),
        'manage_woocommerce',
        'quick-order-create',
        'itqo_admin_page',
        'dashicons-cart',
        50
    );
});

function itqo_admin_page()
{
?>
    <div class="itqo-form-wrapper">
        <div class="itqo-form-title">
            <h4><?php _e('iTech Quick Order', 'itqo'); ?></h4>
        </div>
        <div class='itqo-form-container'>
            <div class="itqo-form">
                <form action='<?php echo esc_url(admin_url('admin-post.php')); ?>' class='pure-form pure-form-aligned' method='POST'>
                    <fieldset>
                        <input type='hidden' name='customer_id' id='customer_id' value='0'>
                        <div class='pure-control-group'>
                            <?php $label = __('Email Address', 'itqo'); ?>
                            <label for='name'><?php echo esc_html($label); ?></label>
                            <input class='itqo-control' required name='email' id='email' type='email' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group'>
                            <?php $label = __('First Name', 'itqo'); ?>
                            <label for='first_name'><?php echo esc_html($label); ?></label>
                            <input class='itqo-control' required name='first_name' id='first_name' type='text' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group'>
                            <?php $label = __('Last Name', 'itqo'); ?>
                            <label for='last_name'><?php echo esc_html($label); ?></label>
                            <input class='itqo-control' required name='last_name' id='last_name' type='text' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group' id='password_container'>
                            <?php $label = __('Password', 'itqo'); ?>
                            <label for='password'><?php echo esc_html($label); ?></label>
                            <input class='itqo-control-right-gap' name='password' id='password' type='text' placeholder='<?php echo esc_html($label); ?>'>
                            <button type='button' id='itqo_genpw' class="button button-primary button-hero">
                                <?php _e('Generate', 'itqo'); ?>
                            </button>
                        </div>

                        <div class='pure-control-group'>
                            <?php $label = __('Phone Number', 'itqo'); ?>
                            <label for='phone'><?php echo esc_html($label); ?></label>
                            <input class='itqo-control' name='phone' id='phone' type='text' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group'>
                            <?php $label = __('Discount in Taka', 'itqo'); ?>
                            <label id="discount-label" for="discount"><?php echo esc_html($label); ?></label>
                            <input class='itqo-control' name="discount" id="discount" type='text' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group' style="margin-top:20px;margin-bottom:20px;">
                            <?php $label = __('I want to input coupon code', 'itqo'); ?>
                            <label for='coupon'></label>
                            <input type='checkbox' name='coupon' id='coupon' value='1' /><?php echo esc_html($label); ?>
                        </div>

                        <div class='pure-control-group'>
                            <?php $label = __('Product Name', 'itqo'); ?>
                            <label for='item'><?php echo esc_html($label); ?></label>
                            <select class='itqo-control' name='item' id='item'>
                                <option value="0"><?php _e('Select One', 'itqo'); ?></option>
                                <?php
                                $products = wc_get_products(array('post_status' => 'published', 'posts_per_page' => -1));
                                foreach ($products as $product) {
                                ?>
                                    <option value='<?php echo $product->get_ID(); ?>''><?php echo $product->get_Name(); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class=' pure-control-group'>
                                        <?php $label = __('Order Note', 'itqo'); ?>
                                        <label for='note'><?php echo esc_html($label); ?></label>
                                        <input class='itqo-control' name='note' id="note" type='text' placeholder='<?php echo esc_html($label); ?>'>
                        </div>

                        <div class='pure-control-group' style='margin-top:20px;'>
                            <label></label>
                            <button type='submit' name='submit' class='button button-primary button-hero'>
                                <?php _e('Create Order', 'itqo'); ?>
                            </button>
                        </div>
                    </fieldset>
                    <input type="hidden" name="action" value="itqo_form">
                    <input type="hidden" name="itqo_identifier" value="<?php echo md5(time()); ?>">
                    <?php wp_nonce_field('itqo_form', 'itqo_form_nonce'); ?>
                </form>
            </div>
            <div class="itqo-info">
            </div>
            <div class="itqo-clearfix"></div>
        </div>

    </div>
    <div id="itqo-modal">
        <div class="itqo-modal-content">
            <?php
            if (isset($_GET['order_id'])) {
                do_action('itqo_order_processing_complete', sanitize_text_field($_GET['order_id']));
            }
            ?>
        </div>
    </div>

<?php

}
add_action('admin_post_itqo_form', function () {
    if (isset($_POST['submit'])) {
        $order_id =  itqo_process_submission();
        wp_safe_redirect(
            esc_url_raw(
                add_query_arg('order_id', $order_id, admin_url('admin.php?page=quick-order-create'))
            )
        );
    }
});


add_action('wp_ajax_itqo_genpw', function () {
    $nonce = sanitize_text_field($_POST['nonce']);
    $action = 'itqo';
    if (wp_verify_nonce($nonce, $action)) {
        echo wp_generate_password(12);
    }
    die();
});

add_action('wp_ajax_itqo_fetch_user', function () {
    $nonce = sanitize_text_field($_POST['nonce']);
    $email = strtolower(sanitize_text_field($_POST['email']));
    $action = 'itqo';
    if (wp_verify_nonce($nonce, $action)) {
        $user = get_user_by('email', $email);
        if ($user) {
            echo json_encode(array(
                'error' => false,
                'id' => $user->ID,
                'fn' => $user->first_name,
                'ln' => $user->last_name,
                'pn' => get_user_meta($user->ID, 'phone_number', true)
            ));
        } else {
            echo json_encode(array(
                'error' => true,
                'id' => 0,
                'fn' => __('Not Found', 'itqo'),
                'ln' => __('Not Found', 'itqo'),
                'pn' => ''
            ));
        }
    }
    die();
});

function itqo_process_submission()
{
    $itqo_order_identifier = sanitize_text_field($_POST['itqo_identifier']);
    $processed = get_transient("itqo{$itqo_order_identifier}");
    if ($processed) {
        return $processed;
    }
    if (wp_verify_nonce(sanitize_text_field($_POST['itqo_form_nonce']), 'itqo_form')) {
        if (sanitize_text_field($_POST['customer_id']) == 0) {
            $email = strtolower(sanitize_text_field($_POST['email']));
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);
            $password = sanitize_text_field($_POST['password']);
            $phone_number = sanitize_text_field($_POST['phone']);
            $customer = wp_create_user($email, $password, $email);
            update_user_meta($customer, 'first_name', $first_name);
            update_user_meta($customer, 'last_name', $last_name);
            update_user_meta($customer, 'phone_number', $phone_number);
            $customer = new WP_User($customer);
        } else {
            $customer = new WP_User(sanitize_text_field($_POST['customer_id']));
        }
        WC()->frontend_includes();
        WC()->session = new WC_Session_Handler();
        WC()->session->init();
        WC()->customer = new WC_Customer($customer->ID, 1);

        $cart = new WC_Cart();
        WC()->cart = $cart;
        $cart->empty_cart();
        $cart->add_to_cart(sanitize_text_field($_POST['item']), 1);

        $discount = trim(sanitize_text_field($_POST['discount']));
        if ($discount == '') {
            $discount = 0;
        }
        $isCoupon = (isset($_POST['coupon'])) ? true : false;

        $checkout = WC()->checkout();
        $phone = sanitize_text_field($_POST['phone']);
        $order_id = $checkout->create_order(array(
            'billing_phone' => $phone,
            'billing_email' => $customer->user_email,
            'payment_method' => 'cash',
            'billing_first_name' => $customer->first_name,
            'billing_last_name' => $customer->last_name,
        ));

        set_transient("itqo{$itqo_order_identifier}", $order_id, 60);

        $order = wc_get_order($order_id);
        update_post_meta($order_id, '_customer_user', $customer->ID);
        if ($isCoupon) {
            $order->apply_coupon($discount);
        } elseif ($discount > 0) {
            $total = $order->calculate_totals();
            $order->set_discount_total($discount);
            $order->set_total($total - floatval($discount));
        }
        if (isset($_POST['note']) && !empty($_POST['note'])) {
            $order_note = apply_filters('itqo_order_note', sanitize_text_field($_POST['note']), $order_id);
            $order->add_order_note($order_note);
        }
        $order_status = apply_filters('itqo_order_status', 'processing');
        $order->set_status($order_status);
        do_action('itqo_order_complete', $order_id);
        return $order->save();
    }
}
add_action('itqo_order_processing_complete', function ($order_id) {
    $order = wc_get_order($order_id);
    $message =  __("<p>Your order number %s is now complete. Please click the next button to edit this order</p><p>%s</p>", 'itqo');
    $order_button = sprintf("<a target='_blank' href='%s' id='itqo-edit-button' class='button button-primary button-hero'>%s %s</a>", $order->get_edit_order_url(), __('Edit Order # ', 'itqo'), $order_id);

    printf($message, $order_id, $order_button);
});

run_itqo();
