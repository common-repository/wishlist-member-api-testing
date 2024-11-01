<?php

require(dirname(__FILE__) . '/wlmapiclass.php');

if (!class_exists('WishlistMemberAPITesting')) {

    class WishlistMemberAPITesting
    {
        var $member_registration_results;


        function __construct () {

            $this->member_registration_results = array();

            add_action ('admin_menu', array ($this, 'add_menu_page'));

            /* Load JS Scripts */
            add_action ('wp_print_scripts' , array ($this, 'scripts'));

            /* Process Member REgistration Tests */
            add_action ('admin_init', array ($this, 'member_registration')) ;

            add_action ('admin_init', array ($this, 'load_scripts')) ;

        }

        function load_scripts() {

            /* check if we are in the right menu screen and only then load js & css */

            $screen = get_current_screen();
            if ($screen->id=='tools_page_wlm-api-testing') {

                add_action ('wp_print_scripts' , array ($this, 'scripts'));

            }

        }

        function scripts () {

                wp_register_script('wlmtest_toggle', plugin_dir_url(__FILE__) . '/js/wlmtest_toggle.js', array('jquery'));
                wp_enqueue_script('wlmtest_toggle');

                wp_register_style('wlmtest_style', plugins_url('/css/style.css', __FILE__));
                wp_enqueue_style('wlmtest_style');

        }

        function add_menu_page() {
            add_management_page( 'Wishlist Member API Testing', 'Wishlist Member API Testing' , 'manage_options', 'wlm-api-testing', array ($this, 'display_api_results'));
        }

        function member_registration() {

            $test_member_data = array(
                "user_login" => 'test_wlmtest_member',
                "user_email" => 'test_member@wlmtest.com',
                "first_name" => 'Test First Name',
                "last_name" => 'Test Last Name',
                "display_name"=>'Test Display Name',
                "user_pass" => '1234567890',
                "Sequential"=> true,
                "SendMail" => 'true',
                "Levels" => array($_POST['wlmtest_level_id'])
            );

            if (isset($_POST['wlmtest_action'] ) && $_POST['wlmtest_action']=="member_registration_internal_api" ) {
                /* Test Member Registration Using Internal API */
                $this->member_registration_results['internal']  = $this->RegisterMemberInternalAPI($test_member_data);
            }

            if (isset($_POST['wlmtest_action'] ) && $_POST['wlmtest_action']=="member_registration_external_api" ) {
                /* Test Member Registration Using External API */
                $this->member_registration_results['external'] = unserialize($this->RegisterMemberExternalAPI($test_member_data));
            }

            if (isset($_POST['wlmtest_action'] ) && $_POST['wlmtest_action']=="delete_test_member" ) {
                /* Test Member Registration Using External API */
                wp_delete_user( $_POST['wlmtest_test_member_id']);
            }
        }

        function display_api_results() { ?>

            <div class="wrap" xmlns="http://www.w3.org/1999/html">
                <h2>Wishlist Member API Testing</h2>
                <p>Here are a list of tests this plugin preform in order to check if Wishlist Member external API is working properly</p>
                <table class="form-table">
                    <tr>
                        <th>Wishlist Member Status</th>
                        <td><?php if ($this->WishlistMemberStatus()) { ?> <span class="wlmtest_success">Activated</span> <?php } else { ?> <span class="wlmtest_fail">Not Activated</span> <?php }?></td>
                    </tr>
                    <?php if ($this->WishlistMemberStatus()) { ?>
                    <tr>
                        <th>Wishlist API Key</th>
                        <td><?php echo $this->getAPIkey();?></td>
                    </tr>
                    <tr>
                        <th>Load Wishlist Member API Results</th>
                        <td><?php var_dump($this->loadAPI());?></td>
                    </tr>
                    <tr>
                        <th>Getting Levels List</th>
                        <td>
                            <?php
                            $api = $this->loadAPI();
                            $response = $api->get('/levels');
                            $response = unserialize($response);
                            ?>

                            Results Using External API -
                                <?php if ($response['success']==1) { ?>
                                    <span class="wlmtest_success">Success</span>
                                <?php } else { ?>
                                    <span class="wlmtest_fail">Failed</span>
                                <?php  } ?>

                            <span class="wlmtest_toogle_trigger"> (Expend / Hide Raw Results)</span>

                            <div class="wlmtest_toogle">
                            <?php
                                echo "<pre>";
                                var_dump ($response);
                                echo "</pre>";
                             ?>
                            </div>

                            <br><br>
                            <?php $response = wlmapi_get_levels(); ?>
                            Results Using Internal API -
                                    <?php if ($response['success']==1) {
                                            $level_id = $response['levels']['level'][0]['id'];
                                        ?>
                                            <span class="wlmtest_success">Success</span>

                                    <?php } else { ?>
                                            <span class="wlmtest_fail">Failed</span>
                                    <?php  } ?>

                            <span class="wlmtest_toogle_trigger"> (Expend / Hide Raw Results)</span>
                            <div class="wlmtest_toogle">
                                <?php
                                $response = wlmapi_get_levels();
                                echo "<pre>";
                                var_dump ($response);
                                echo "</pre>";
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Register a new Member
                        </th>

                        <!-- Check if test member already exist -->

                        <td>
                           <?php $test_member =  get_user_by( 'email', 'test_member@wlmtest.com' );
                                if (!$test_member) { ?>
                                <form method="post">
                                    <input type="submit" class="button-secondary" value="Test Member Registration Using Internal API">
                                    <input type="hidden" name="wlmtest_action" value="member_registration_internal_api">
                                    <input type="hidden" name="wlmtest_level_id" value="<?php echo $level_id; ?>">
                                </form>
                            <?php } ?>
                                <?php if (isset($_POST['wlmtest_action']) && $_POST['wlmtest_action'] == "member_registration_internal_api") { ?>

                                    <p>Test Member Registration using internal API -
                                    <?php if ($this->member_registration_results['internal']['success']==1) { ?>
                                        <span class="wlmtest_success">Success</span><br>
                                    <?php } else { ?>
                                        <span class="wlmtest_fail">Failed</span><br>
                                    <?php  } ?>
                                    </p>

                                    <span class="wlmtest_toogle_trigger"> (Expend / Hide Raw Results)</span>
                                    <div class="wlmtest_toogle">
                                        <?php
                                        echo "Member Registration External API Results:";
                                        echo "<pre>";
                                        var_dump($this->member_registration_results['internal']);
                                        echo "</pre>";
                                        ?>
                                    </div>
                                    <br>
                                <?php } ?>

                                <?php if (!$test_member) { ?>
                                <br>
                                <form method="post">
                                    <input type="submit" class="button-secondary" value="Test Member Registration Using External API">
                                    <input type="hidden" name="wlmtest_action" value="member_registration_external_api">
                                    <input type="hidden" name="wlmtest_level_id" value="<?php echo $level_id; ?>">
                                </form>
                                <?php } ?>
                                <?php if (isset($_POST['wlmtest_action']) && $_POST['wlmtest_action'] == "member_registration_external_api") { ?>

                                    <p>Test Member Registration using Enternal API -
                                    <?php if ($this->member_registration_results['external']['success']==1) { ?>
                                        <span class="wlmtest_success">Success</span><br>
                                    <?php } else { ?>
                                        <span class="wlmtest_fail">Failed</span><br>
                                    <?php  } ?>
                                    </p>
                                    <span class="wlmtest_toogle_trigger"> (Expend / Hide Raw Results)</span>
                                    <div class="wlmtest_toogle">
                                        <?php
                                        echo "Member Registration External API Results:";
                                        echo "<pre>";
                                        var_dump($this->member_registration_results['external']);
                                        echo "</pre>";
                                        ?>
                                    </div>
                                    <br><br>
                                <?php } ?>
                                <?php if ($test_member) { ?>
                                    <?php if (!isset ($_POST['wlmtest_action'])) { ?>
                                        <div class="wlmtest_fail">Test member already exists, please delete it before continue with member registration tests.</div>
                                    <?php } ?>
                                    <br>
                                    <form method="post">
                                        <input type="submit" class="button-secondary" value="Delete Existing Test Member">
                                        <input type="hidden" name="wlmtest_action" value="delete_test_member">
                                        <input type="hidden" name="wlmtest_test_member_id" value="<?php echo $test_member->ID; ?>">
                                    </form>
                                <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </table>

                <?php if (!$this->WishlistMemberStatus()) { ?>
                    <p style="color: red;">Wishlist Member is not activated so we can't check the Wishlist Member API, if you own Wishlist Member please installed activate it.<br>
                        If you don't own Wishlist Member check <a target="_blank" href="http://wlmp.info/recommends/wishlist-member-plugin/">Wishlist Member official product page</a></p>
                <?php } ?>
                <hr>

                <h3>Having Problems with Wishlist Member API?</h3>
                <p>This testing page was created by Wishlist Member API Testing and was intend to only check if Wishlist Member official external API is working properly</p>
                <p>This plugin is offered as it and does not include any support if you are getting false results from the Wishlist Member API please contact <a target="new" href="http://support.wishlistproducts.com">Wishlist Member official support</a>.</p>

                <h3>Looking for Wishlist Member Tips?</h3>
                <p>If you are a Wishlist Member user then our special tips series is just what you need to help your empower your membership site.<br>
                In this special Wishlist Member Tips Series you will find over 60 tips about relevant topics such as: content dripping, registration rates, retention rates and a lot more!<br>
                <strong><a target="_blank" href="http://wishlistmemberplugins.net/wishlist-member-tips-list">Register for FREE and get immediate access to all the previous and upcoming tips!</a></strong></p>

                <h3>Looking for Dedicated Plugins for Wishlist Member?</h3>
                <p>Over 40 Wishlist Member dedicated plugins to empower your membership site with unique features are only a click away!<br>
                <strong><a target="_blank" href="https://happyplugins.com/downloads/category/wishlist-member/?utm_source=plugin-backend&utm_medium=wln-api-testing&utm_campaign=WishlistMemberCategory">Click here to discover all plugins</a></strong></p>

            </div>


        <?php
        }

        function getAPIkey () {
            global $wpdb;
            $table = $wpdb->prefix . 'wlm_options';
            $query = "
				SELECT option_value
				FROM $table
				WHERE option_name = 'WLMAPIKey'
				";
            $key   = $wpdb->get_results($query);
            return $key[0]->option_value;
        }

        function loadAPI () {
                $api = new wlmapiclass(site_url() . '/', $this->getAPIkey());
                $api->return_format = 'php';
                return $api;
        }

        function WishlistMemberStatus () {
            if (class_exists('WishlistMember')) return true;
            return false;
        }

        function RegisterMemberInternalAPI ($member_data) {
            $response =  wlmapi_add_member($member_data);
            return $response;
        }

        function RegisterMemberExternalAPI ($member_data) {
            $api      = $this->loadAPI();
            $response = $api->post ('members/' , $member_data);
            return $response;
        }

    }
}