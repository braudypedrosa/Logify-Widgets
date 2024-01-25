<?php ob_start();

include_once(LCW_DIR.'functions.php');

$public_key = get_option('lcw_public_key');

$err = "";

if(isset($_POST['save_settings'])) {

    $public_key = isset($_POST['public_key']) ? $_POST['public_key'] : get_option('lcw_public_key');
    update_option('lcw_public_key', $public_key);

    wp_redirect(admin_url("admin.php?page=lodgify_widgets&status=settings_saved"));
    exit();    
}
?>
<style>

    .lcw-form-input {
        margin-bottom:20px;
    }

    .lcw-form-input span {
        font-size: 14px;
        line-height: 1.5em;
        display: block;
    }

    .lcw-form-input h4 {
        margin-bottom: 0px;
    }

    .lcw-form-input label,
    .lcw-form-input input {
        display:block;
        max-width:500px;
        width:100%;
    }
    .lcw-form-input input[type=submit]{
        max-width:200px;
    }

</style>


<div class="wrap">
    <h2>Settings</h2>

    <?php if(isset($_GET['status']) && $_GET['status'] == "settings_saved"): ?>
        <div class="notice notice-success is-dismissible">
            <p>You have successfully connected to Lodgify API!</p>
        </div>
    <?php endif;?>

    <?php echo !empty($err) ? $err : ""; ?>

    <div class="lcw-settings-content">
        <form method="post">
            <div class="lcw-form-input">
                <h3>Public Key</h3>
                <span>You can get the Public Key in your Lodgify settings page.</span>
                <input type="text" name="public_key" value="<?php echo isset($_POST['public_key'])?$_POST['public_key']: $public_key; ?>"/>
            </div>
            <div class="lcw-form-input">
                <input type="submit" name="save_settings" class="button-primary" value="Save Settings"/>    
            </div>
        </form>


        <div>
            <h3>Usage:</h3>
            <p>[lodgify_calendar listingid="xxxxxx"]<br>
                [lodgify_booking_widget listingid="xxxxxx" minstay="xx"]
                <span style="display: block; font-size: 12px; font-style: italic;">Listing ID can be taken from Lodgify dashboard</span>
            </p>
            

            <p><b>Example:</b></p>
            <pre>[lodgify_calendar listingid="287397"]</pre>
            <pre>[lodgify_booking_widget listingid="287397" minstay="10"]</pre>

            <p><b>Note:</b><br>
            <span style="display: block; font-size: 12px; font-style: italic;">For this version of the plugin would require to add minimum stays attribute</span></p>
        </div>
    </div>

    

</div>