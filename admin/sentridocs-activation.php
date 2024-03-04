<?php
function sentridocs_activation() {
    add_option('sentridocs_license_key', '');
    add_option('sentridocs_secret_key', '');
    add_option('sentridocs_activated', false);
}

function sentridocs_show_license_key_form() {
    if(isset($_POST['sentridocs_save_keys'])) {
        $license_key = sanitize_text_field($_POST['license_key']);
        $secret_key = sanitize_text_field($_POST['secret_key']);

        if(validate_license($license_key, $secret_key)) {
            update_option('sentridocs_activated', true);
            update_option('sentridocs_license_key', $license_key);
            update_option('sentridocs_secret_key', $secret_key);
            sentridocs_check_activation();
            wp_redirect(admin_url('admin.php?page=sentridocs_settings'));
            exit();
        } else {
            update_option('sentridocs_activated', false);
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Invalid license key or secret key.</p>
            </div>
            <?php
        }
    }
    ?>
    <div class="wrap">
        <h2>Enter Sentridocs License Keys</h2>
        <p>Please <a href="https://sentridocs.com/account/user/register.php">register</a> to obtain your license key and secret key.</p>
        <form method="post">
            <label for="license_key">License Key:</label>
            <input type="text" name="license_key" id="license_key" value="<?php echo esc_attr(get_option('sentridocs_license_key')); ?>" required><br><br>
            <label for="secret_key">Secret Key:</label>
            <input type="text" name="secret_key" id="secret_key" value="<?php echo esc_attr(get_option('sentridocs_secret_key')); ?>" required><br><br>
            <input type="submit" name="sentridocs_save_keys" value="Save Keys">
        </form>
    </div>
    <?php
}

function validate_license($license_key, $secret_key) {
    $api_url = 'https://sentridocs.com/api/licensevalidation.php';
    $data = array(
        'license_key' => $license_key,
        'secret_key' => $secret_key
    );

    $response = wp_remote_post($api_url, array(
        'body' => json_encode($data),
        'headers' => array('Content-Type' => 'application/json'),
        'timeout' => 20 // Adjust timeout as needed
    ));

    if(is_wp_error($response)) {
        return false; // Error occurred
    } else {
        $response_body = json_decode(wp_remote_retrieve_body($response), true);
        return isset($response_body['status']) && $response_body['status'] === 'success';
    }
}

function check_license($license_key, $secret_key) {
    $api_url = 'https://sentridocs.com/api/checklicense.php';
    $data = array(
        'license_key' => $license_key,
        'secret_key' => $secret_key
    );

    $response = wp_remote_post($api_url, array(
        'body' => json_encode($data),
        'headers' => array('Content-Type' => 'application/json'),
        'timeout' => 20 // Adjust timeout as needed
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $response_body = json_decode(wp_remote_retrieve_body($response), true);

    update_option('sentridocs_activated', isset($response_body['status']) && $response_body['status'] === 'success');

    return isset($response_body['status']) && $response_body['status'] === 'success';
}
?>
