<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add this helper function
function lapinopay_get_payment_icon($icon_name, $alt_text) {
    // First, try to get the icon from the media library
    $attachment_id = lapinopay_get_svg_attachment_id($icon_name);
    
    if ($attachment_id) {
        return wp_get_attachment_image(
            $attachment_id,
            'full',
            false,
            array(
                'class' => 'lapinopay-payment-icon',
                'alt'   => esc_attr($alt_text),
                'width' => '24',
                'height'=> '24'
            )
        );
    }

    // If not in media library, handle SVG properly
    $svg_path = plugin_dir_path(dirname(__FILE__)) . 'assets/icons/' . $icon_name . '.svg';
    if (file_exists($svg_path)) {
        // Register and enqueue SVG as an asset
        wp_enqueue_style(
            'lapinopay-icons',
            plugins_url('assets/css/icons.css', dirname(__FILE__)),
            array(),
            filemtime($svg_path)
        );

        // Create an SVG sprite or inline SVG
        $svg_content = file_get_contents($svg_path);
        if ($svg_content) {
            return wp_kses(
                sprintf(
                    '<div class="lapinopay-payment-icon lapinopay-icon-%s" role="img" aria-label="%s">%s</div>',
                    esc_attr($icon_name),
                    esc_attr($alt_text),
                    $svg_content
                ),
                array(
                    'div' => array(
                        'class' => array(),
                        'role' => array(),
                        'aria-label' => array(),
                    ),
                    'svg' => array(
                        'xmlns' => array(),
                        'viewBox' => array(),
                        'width' => array(),
                        'height' => array(),
                        'fill' => array(),
                        'class' => array(),
                    ),
                    'path' => array(
                        'd' => array(),
                        'fill' => array(),
                    ),
                )
            );
        }
    }

    // Fallback if neither method works
    return sprintf(
        '<span class="lapinopay-payment-icon lapinopay-icon-%s" aria-label="%s"></span>',
        esc_attr($icon_name),
        esc_attr($alt_text)
    );
}

// Helper function to get SVG attachment ID
function lapinopay_get_svg_attachment_id($icon_name) {
    $upload_dir = wp_upload_dir();
    $icon_path = plugin_dir_path(dirname(__FILE__)) . 'assets/icons/' . $icon_name . '.svg';
    
    // Try to get the attachment ID by file path
    return attachment_url_to_postid(str_replace(
        $upload_dir['basedir'],
        $upload_dir['baseurl'],
        $icon_path
    ));
}
?>
<style>
    #add_payment_method #payment div.payment_box::before, .woocommerce-cart #payment div.payment_box::before, .woocommerce-checkout #payment div.payment_box::before{
        display: none !important;
    }
    .payment_box.payment_method_lapinopay-instant-payment-gateway-guardarian {
        background-color: transparent !important;
        padding: 0 !important;
        border: none !important;
        margin: 0 !important;
    }
    .form-row.place-order{
        display : none !important;
        padding: 0 !important;
    }
    .woocommerce-terms-and-conditions-wrapper{
        padding: 0 !important;
        background: transparent !important;
        display: none !important;
    }
    .lapinopay-additional-fields{
        display: none !important;
    }
    #payment .payment_methods > li > label,
    #payment .payment_methods > li {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .lapinopay-additional-fields select{
        display: none !important;
    }

    #payment .payment_methods > li:first-child {
        border-top: none !important;
    }

    .lapinopay-payment-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 100%;
        margin: 0;
    }

    .lapinopay-security-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f8f9fa;
        border-radius: 20px;
        color: #1a1a1a;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
    }

    .lapinopay-security-badge img {
        width: 16px;
        height: 16px;
    }

    .lapinopay-payment-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .lapinopay-payment-method {
        position: relative;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .lapinopay-payment-method:hover {
        background: #f8f9fa;
        border-color: #000;
    }

    .lapinopay-payment-method.selected {
        border-color: #000;
        background: #f8f9fa;
    }

    .lapinopay-payment-method input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .lapinopay-payment-method label {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 0;
        cursor: pointer;
    }

    .lapinopay-payment-method-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lapinopay-payment-method-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lapinopay-payment-method-info {
        flex-grow: 1;
    }

    .lapinopay-payment-method-name {
        font-weight: 500;
        color: #1a1a1a;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .lapinopay-payment-method-description {
        font-size: 14px;
        color: #6c757d;
    }

    .lapinopay-radio-check {
        width: 20px;
        height: 20px;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        position: relative;
        transition: all 0.2s ease;
    }

    .lapinopay-payment-method.selected .lapinopay-radio-check {
        border-color: #000;
    }

    .lapinopay-payment-method.selected .lapinopay-radio-check:after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background: #000;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .lapinopay-footer {
        margin-top: 24px;
        font-size: 14px;
        color: #6c757d;
        line-height: 1.5;
    }

    .lapinopay-footer a {
        color: #000;
        text-decoration: underline;
    }
    #place_order {
        display: none !important;
    }

    .lapinopay-place-order {
        width: 100%;
        padding: 16px 24px;
        background: #000000;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 24px;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .lapinopay-place-order:hover {
        background: #333333;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .lapinopay-place-order:active {
        transform: translateY(0);
    }

    .lapinopay-place-order:disabled {
        background: #cccccc;
        cursor: not-allowed;
    }
</style>

<!-- Hidden select for form submission -->
<select name="lapinopay_payment_category" id="lapinopay_payment_category" class="select" style="display: none;" required>
    <option value="">Select a payment method</option>
    <option value="VISA_MC">Credit Card</option>
    <option value="REVOLUT_PAY">Revolut Pay</option>
    <option value="GOOGLE_PAY">Google Pay</option>
    <option value="APPLE_PAY">Apple Pay</option>
</select>

<div class="lapinopay-payment-container">
    <div class="lapinopay-security-badge">
        <?php echo wp_kses_post(lapinopay_get_payment_icon('shield-check', 'Security')); ?>
        <span>Secure Payment</span>
    </div>

    <div class="lapinopay-payment-methods">
        <div class="lapinopay-payment-method selected">
            <input type="radio" name="lapinopay_payment_method" id="credit-card" value="credit-card" checked>
            <label for="credit-card">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('credit-card', 'Credit Card')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Credit Card</div>
                    <div class="lapinopay-payment-method-description">Pay securely with your credit card</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method">
            <input type="radio" name="lapinopay_payment_method" id="revolut" value="revolut">
            <label for="revolut">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('revolut', 'Revolut')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Revolut Pay</div>
                    <div class="lapinopay-payment-method-description">Fast and secure payment with Revolut</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method">
            <input type="radio" name="lapinopay_payment_method" id="apple-pay" value="apple-pay">
            <label for="apple-pay">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('apple-pay', 'Apple Pay')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Apple Pay</div>
                    <div class="lapinopay-payment-method-description">Quick checkout with Apple Pay</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method">
            <input type="radio" name="lapinopay_payment_method" id="google-pay" value="google-pay">
            <label for="google-pay">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('google-pay', 'Google Pay')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Google Pay</div>
                    <div class="lapinopay-payment-method-description">Easy payment with Google Pay</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>
    </div>

    <div class="lapinopay-footer">
        Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">Privacy policy</a>.
    </div>

    <button type="submit" class="lapinopay-place-order" id="lapinopay-place-order">
        Place order
    </button>
</div>

<script>
jQuery(function($) {
    // Get the hidden select element - Fix the selector to make sure we get the right element
    const payment_field_category = $('#lapinopay_payment_category');
    
    const paymentCategories = {
        'credit-card': 'VISA_MC',
        'revolut': 'REVOLUT_PAY',
        'google-pay': 'GOOGLE_PAY',
        'apple-pay': 'APPLE_PAY'
    };

    function updatePaymentCategory(selectedValue) {
        // Log for debugging
        console.log('Updating payment category to:', paymentCategories[selectedValue]);
        
        // Make sure we have the select element
        if (payment_field_category.length) {
            // Update the value and trigger change event
            payment_field_category.val(paymentCategories[selectedValue]).trigger('change');
        } else {
            console.error('Payment category select element not found');
        }
    }

    // Handle click on payment method container
    $(document).on('click', '.lapinopay-payment-method', function(e) {
        e.preventDefault();
        
        const radio = $(this).find('input[type="radio"]');
        if (radio.length) {
            // Update UI
            $('.lapinopay-payment-method').removeClass('selected');
            $(this).addClass('selected');
            
            // Update radio buttons
            $('.lapinopay-payment-method input[type="radio"]').prop('checked', false);
            radio.prop('checked', true);
            
            // Update hidden select
            updatePaymentCategory(radio.val());
        }
    });

    // Set initial value based on default selected radio
    const defaultSelected = $('.lapinopay-payment-method input[type="radio"]:checked');
    if (defaultSelected.length) {
        updatePaymentCategory(defaultSelected.val());
    }

    // Handle WooCommerce checkout updates
    $(document.body).on('updated_checkout', function() {
        console.log('Checkout updated, re-checking payment methods');
        const selectedRadio = $('.lapinopay-payment-method input[type="radio"]:checked');
        if (selectedRadio.length) {
            updatePaymentCategory(selectedRadio.val());
        }
    });

    // Add click handler for the place order button
    $('#lapinopay-place-order').on('click', function(e) {
        e.preventDefault();
        // Trigger the original place order button
        $('#place_order').trigger('click');
    });
});
</script>
