<div class="wrap">
    <h2><?php _e('SynField Smart Agriculture Plugin', 'synfield-smart-agriculture'); ?></h2>
    <hr>

    <?php if (isset($_GET['synfield-smart-agriculture-cached-cleared'])) { ?>
        <div id="setting-error-settings_updated" class="updated settings-error">
            <p><strong><?php _e('Smart Agriculture Widget Cache Cleared', 'synfield-smart-agriculture'); ?></strong></p>
        </div>
    <?php } ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#manage_settings"><?php _e("Manage Settings", 'synfield-smart-agriculture') ?></a></li>
        <li><a href="#about"><?php _e("About", 'synfield-smart-agriculture') ?></a></li>
    </ul>
    <div class="tab-content">
        <div id="manage_settings" class="tab-pane active">
            <form action="options.php" method="POST">
                <?php
                settings_fields('synfield_settings_group');
                do_settings_sections('synfield-smart-agriculture');
                submit_button();
                ?>
            </form>
        </div>
        <div id="about" class="tab-pane"><?php _e("About", 'synfield-smart-agriculture') ?></div>
    </div>
</div>
