<?php
/* Shortcode of Forgot Password Form */
function Aston_ForgotPassword_Form($atts)
{

    $is_url_has_token = '';
    if (isset($_GET) && isset($_GET['reset_password_token'])) {
        $is_url_has_token = $_GET['reset_password_token'];
    }
    $fpassword_html = '';
    $fpassword_html .= '<div class="login-form-section">';
    $fpassword_html .= '<div id="registartion_alert" class="alert"></div>';
    $fpassword_html .= '<form class="login-form" method="post" name="forgot_password_form" id="forgot_password_form">';
    if (empty($is_url_has_token)) {
        $fpassword_html .= '<div class="form-group">';
        $fpassword_html .= '<input type="email" name="emailid" id="emailid" placeholder="Email Address" class="form-control">';
        $fpassword_html .= '</div>';
    } else {

        $fpassword_html .= '<div class="form-group">';
        $fpassword_html .= '<input type="password" name="password" id="password" placeholder="New Password" class="form-control">';
        $fpassword_html .= '</div>';
        $fpassword_html .= '<div class="form-group">';
        $fpassword_html .= '<input type="password" name="cpassword" id="cpassword" placeholder="Confirm New Password" class="form-control">';
        $fpassword_html .= '</div>';
        $fpassword_html .= '<input type="hidden" name="emailid" id="emailid" value="' . $_GET['email'] . '" />';
        $fpassword_html .= '<input type="hidden" name="reset_password_token" id="reset_password_token" value="' . $_GET['reset_password_token'] . '" />';
    }
    $fpassword_html .= '<div class="input-group-submit password-submit">';
    $fpassword_html .= '<input type="hidden" name="forgot_password_nonce" id="forgot_password_nonce" value="' . wp_create_nonce('fp-nonce') . '" />';
    $fpassword_html .= '<input type="hidden" name="current_url" id="current_url" value="' . get_permalink() . '" />';
    $fpassword_html .= '<input type="hidden" name="redirect_url" id="redirect_url" value="' . get_permalink(5) . '" />';
    $fpassword_html .= '<input type="submit" class="submit-btn" id="forgot_password_submit_btn" value="Submit">';
    $fpassword_html .= '</div>';
    $fpassword_html .= '<div class="auth-ajax-loder">';
    $fpassword_html .= '<img src="' . get_template_directory_uri() . '/assets/images/ajax-loader-auth.gif">';
    $fpassword_html .= '</div>';

    $fpassword_html .= '</form>';
    $fpassword_html .= '</div>';

    return $fpassword_html;
}
add_shortcode('forgot_password_form', 'Aston_ForgotPassword_Form');

function fn_ForgotPassword()
{
    global $wpdb;

    $status                 = false;
    $response               = array();
    $response['code']       = 0;
    $response['redirect']   = $_POST['redirect_url'];
    $response['alert']      = '';

    if (!wp_verify_nonce($_POST['forgot_password_nonce'], 'fp-nonce')) {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    } else {
        $status = true;
    }

    if ($status) :

        if (isset($_POST) && empty($_POST['reset_password_token'])) {

            if (empty($_POST['emailid'])) {
                $status = false;
                $response['alert'] = __('Email address is required.', 'twentytwenty');
            }

            if ($status) :

                $user = get_user_by('email', $_POST['emailid']);

                //check user exists
                if (!empty($user) && $user->ID > 0) {

                    $reset_password_token = '';

                    //check if token already exists
                    $token_exists = get_user_meta($user->ID, 'reset_password_token', true);

                    if ($token_exists) {
                        //send the old token
                        $reset_password_token = $token_exists;
                    } else {
                        //generate new token
                        $reset_password_token = md5(wp_generate_password(26, true));
                        //add new token to usermeta
                        add_user_meta($user->ID, 'reset_password_token', $reset_password_token);
                    }


                    //create info to sent in the email
                    $userdata = array();
                    $userdata['current_url'] = $_POST['current_url'];
                    $userdata['reset_password_token'] = $reset_password_token;
                    $userdata['username'] = $user->data->user_login;
                    $userdata['email'] = $user->data->user_email;


                    $tokens = array(
                        'USERNAME'      => $userdata['username'],
                        'BLOGNAME'      => get_option('blogname'),
                        'USEREMAIL'     => $userdata['email'],
                        'BLOGURL'       => get_site_url(),
                        'RECOVERYLINK'  => esc_url(
                            add_query_arg(
                                array(
                                    'email' => $userdata['email'],
                                    'reset_password_token' => $reset_password_token
                                ),
                                $userdata['current_url']
                            )
                        )
                    );

                    $mail_status = send_reset_password_token($userdata, $tokens);

                    if (true == $mail_status) {

                        $response['code'] = 1;
                        $response['alert'] = __('A link to reset your password has been sent to you.', 'twentytwenty');
                        //create response
                        //wp_send_json( $response );
                    } else {
                        $response['alert'] = __('Password reset link not sent.', 'twentytwenty');
                        //wp_send_json( $response );
                    }
                } else {
                    $response['alert'] = __('We cannot identify any user with this email.', 'twentytwenty');
                    //wp_send_json( $response );
                }

            endif;
        } else if (isset($_POST) && !empty($_POST['reset_password_token'])) {

            if (empty($_POST['password'])) {
                $status = false;
                $response['alert'] = __('Password is required.', 'twentytwenty');
            } else if (strlen($_POST['password']) < 6) {
                $status = false;
                $response['alert'] = __('Password is not less than 6 character.', 'retirement-move');
            } else if (empty($_POST['cpassword'])) {
                $status = false;
                $response['alert'] = __('Confirm password is required.', 'twentytwenty');
            } else if ($_POST['cpassword'] != $_POST['password']) {
                $status = false;
                $response['alert'] = __('Password does not matched.', 'twentytwenty');
            }

            if ($status) :

                $data = array();
                $data['email']                      = $_POST['emailid'];
                $data['reset_password_token']       = $_POST['reset_password_token'];
                $data['password']                   = $_POST['password'];
                $data['cpassword']                  = $_POST['cpassword'];

                $update_status = change_user_password($data);

                if ($update_status == true) {

                    $response['code'] = 2;
                    $response['alert'] = __('Your password has been changed successfully.', 'twentytwenty');
                    //wp_send_json($response);
                }

                if ($update_status == false) {
                    $response['alert'] = __('This token appears to be invalid.', 'twentytwenty');
                    //wp_send_json($response);
                }

            endif;
        }


    endif;

    wp_send_json($response);
}
add_action('wp_ajax_nopriv_fn_ForgotPassword', 'fn_ForgotPassword');
add_action('wp_ajax_fn_ForgotPassword', 'fn_ForgotPassword');

function change_user_password($data)
{

    // checking email and token
    if (isset($data) && $data['reset_password_token'] && $data['email']) {

        $user = get_user_by('email', $data['email']);

        if ($user->ID > 0) {
            $stored_token = get_user_meta($user->ID, 'reset_password_token', true);
        }

        if ($stored_token == $data['reset_password_token']) {
            // preparing user data
            $password = $data['password'];
            $password_reset = wp_set_password($password, $user->ID);

            // removing token on verification
            return delete_user_meta($user->ID, 'reset_password_token');
        }
    }
    return false;
}
/* Shortcode of login form */
function Aston_Login_Form($atts)
{
    $login_frm_html = '';

    $login_frm_html .= '<div class="login-form-section">';
    $login_frm_html .= '<div id="registartion_alert" class="alert"></div>';
    $login_frm_html .= '<form class="login-form" method="post" name="login_form" id="login_form">';
    $login_frm_html .= '<div class="form-group">';
    $login_frm_html .= '<input type="text" name="emailid" id="emailid" placeholder="Email Address" class="form-control">';
    $login_frm_html .= '</div>';
    $login_frm_html .= '<div class="form-group">';
    $login_frm_html .= '<input type="password" name="password" id="password" placeholder="Password" class="form-control">';
    $login_frm_html .= '</div>';
    $login_frm_html .= '<div class="form-group">';
    $login_frm_html .= '<input type="hidden" name="login_nonce" id="login_nonce" value="' . wp_create_nonce('login-nonce') . '" />';
    $login_frm_html .= '<input type="hidden" name="redirect_url" id="redirect_url" value="' . get_field("global_login_redirect", "option") . '" />';
    $login_frm_html .= '<input type="submit" class="submit-btn" id="login_submit_btn" value="' . get_field("login_button_text", "option") . '">';
    $login_frm_html .= '<p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value=""> <label  style="color:#fff; font-weight:normal;" for="rememberme">Remember Me</label></p>';
    $login_frm_html .= '</div>';
    $login_frm_html .= '<div class="auth-ajax-loder">';
    $login_frm_html .= '<img src="' . get_template_directory_uri() . '/assets/images/ajax-loader-auth.gif">';
    $login_frm_html .= '</div>';
    $login_frm_html .= '</form>';
    $login_frm_html .= '</div>';
    $login_frm_html .= '</div>';
    return  $login_frm_html;
}
add_shortcode('login_form', 'Aston_Login_Form');
/* Short code of registertion form */

function Aston_Register_Form($atts)
{
    $res_frm_html = '';
    $token_verification = user_verify_token();
    $alert_msg = '';
    $alert_cls = '';
    if (@$token_verification == 1) {
        $alert_cls = 'alert-success';
        $alert_msg = get_field("account_activated", "option");
?>
        <script type="text/javascript">
            //Using setTimeout to execute a function after 5 seconds.
            setTimeout(function() {
                //Redirect with JavaScript
                window.location.href = "<?php echo get_permalink(5); ?>";
            }, 5000);
        </script>
<?php

    } else if (@$token_verification == 2) {
        $alert_cls = 'alert-danger';
        $alert_msg = "Your token is expired!";
    } else {
        $alert_cls = '';
        $alert_msg = '';
    }
    $res_frm_html .= '<div class="register-form-section">';
    $res_frm_html .= '<div id="registartion_alert" class="alert ' . $alert_cls . '">' . $alert_msg . '</div>';
    $res_frm_html .= "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
    $res_frm_html .= '<form class="register-form" method="post" name="register_form" id="register_form">';
    $res_frm_html .= '<div class="row">';
    $res_frm_html .= '<div class="col-sm-6">';
    $res_frm_html .= '<div class="form-group">';
    $res_frm_html .= '<input type="text" name="uname" id="uname" placeholder="Your name" class="form-control">';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="col-sm-6">';
    $res_frm_html .= '<div class="form-group">';
    $res_frm_html .= '<input type="email" name="emailid" id="emailid" placeholder="Your email address" class="form-control">';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="row">';
    $res_frm_html .= '<div class="col-sm-6">';
    $res_frm_html .= '<div class="form-group">';
    $res_frm_html .= '<input type="password" name="password" id="password" placeholder="Password" class="form-control">';

    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="col-sm-6">';
    $res_frm_html .= '<div class="form-group">';
    $res_frm_html .= '<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="form-control">';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="form-group">';
    if (get_field('lbl_privacy_policy_checkbox', 'option')) {
        $res_frm_html .= '<div class="checkbox-col privacy_policy_chk">';
        $res_frm_html .= '<input type="checkbox" name="gdpr" id="gdpr" value="yes">';
        $res_frm_html .= '<label class="label" for="gdpr">';
        $res_frm_html .=  get_field('lbl_privacy_policy_checkbox', 'option');
        $res_frm_html .= '</label>';
        $res_frm_html .= '</div>';
    }
    if (get_field('enable_newsletter_checkbox', 'option')) {
        $res_frm_html .= '<div class="checkbox-col">';
        $res_frm_html .= '<input type="checkbox" name="newsletter" id="newsletter" value="yes" checked>';
        $res_frm_html .= '<label class="label" for="newsletter">';
        $res_frm_html .= get_field('lbl_newsletter_checkbox', 'option');
        $res_frm_html .= '</label>';
        $res_frm_html .= '</div>';
    }
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="inner-col">';
    $res_frm_html .= '<div class="form-group captcha">';
    $res_frm_html .= '<div class="g-recaptcha" data-sitekey="' . RECAPTCHA_SITEKEY . '" data-theme="dark"></div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="form-group">';
    $res_frm_html .= ' <input type="hidden" name="signup_nonce" id="signup_nonce" value="' . wp_create_nonce('signup-nonce') . '" />';
    $res_frm_html .= '<input type="hidden" name="wp_current_url" id="wp_current_url" value="' . get_permalink() . '" />';
    $res_frm_html .= '<input type="submit" class="submit-btn" id="register_submit_btn" value="' . get_field('register_button_text', 'option') . '">';
    $res_frm_html .= '</div>';
    $res_frm_html .= '<div class="auth-ajax-loder">';
    $res_frm_html .= '<img src="' . get_template_directory_uri() . '/assets/images/ajax-loader-auth.gif">';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</form>';
    $res_frm_html .= '</div>';
    $res_frm_html .= '</div>';

    return $res_frm_html;
}
add_shortcode('register_form', 'Aston_Register_Form');

function fn_Registration()
{

    $status                 = false;
    $response                   = array();
    $response['code']        = 0;
    $response['redirect']     = $_POST['wp_current_url'];
    $response['alert']         = '';

    if (!wp_verify_nonce($_POST['signup_nonce'], 'signup-nonce')) {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    } else if (empty($_POST['uname'])) {
        $status = false;
        $response['alert'] = __('Your name is required!', 'twentytwenty');
    } else if (empty($_POST['emailid'])) {
        $status = false;
        $response['alert'] = __('Emailid is required!', 'twentytwenty');
    } else if (empty($_POST['gdpr'])) {
        $status = false;
        $response['alert'] = __('GDPR is required!', 'twentytwenty');
    } else if (empty($_POST['password'])) {
        $status = false;
        $response['alert'] = __('Password is required.', 'twentytwenty');
    } else if (strlen($_POST['password']) < 6) {
        $status = false;
        $response['alert'] = __('Password is not less than 6 character.', 'retirement-move');
    } else if (empty($_POST['cpassword'])) {
        $status = false;
        $response['alert'] = __('Confirm password is required.', 'twentytwenty');
    } else if ($_POST['cpassword'] != $_POST['password']) {
        $status = false;
        $response['alert'] = __('Password does not matched.', 'twentytwenty');
    } else if (empty($_POST['g-recaptcha-response'])) {
        $status = false;
        $response['alert'] = __('Please check the reCAPTCHA.', 'twentytwenty');
    } else {
        $status = true;
    }
    if ($status) {

        if (email_exists($_POST['emailid']) != null) {
            $response['code'] = 0;
            $response['alert'] = "Email already exists";
        } else {
            $secretKey = RECAPTCHA_SECRETKEY;
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($_POST['g-recaptcha-response']);
            $captcha_response = file_get_contents($url);
            $responseKeys = json_decode($captcha_response, true);

            if ($responseKeys["success"]) {
                $new_user_id = wp_insert_user(array(
                    'first_name'         => ucfirst($_POST['uname']),
                    'user_email'         => $_POST['emailid'],
                    'user_login'         => $_POST['uname'],
                    'user_pass'         => $_POST['password'],
                    'role'                  => get_option('default_role'),
                    'user_registered'     => date('Y-m-d H:i:s')
                ));

                if (!is_wp_error($new_user_id)) {
                    if ($new_user_id) {
                        $activation_token         = generateRandomString();

                        update_user_meta($new_user_id, 'user_email_verification_token', $activation_token);
                        update_user_meta($new_user_id, 'user_active_status', 'registered');

                        update_user_meta($new_user_id, 'user_gdpr', $_POST['gdpr']);
                        update_user_meta($new_user_id, 'user_newsletter', $_POST['gdpr']);
                        $tokens = array(
                            'USERNAME'      => $_POST['uname'],
                            'BLOGNAME'      => get_option('blogname'),
                            'EMAIL'         => $_POST['emailid'],
                            'BLOGURL'       => get_site_url(),
                            'PASSWORD'      => __('As choosen at time of registration'),
                            'ACTIVATIONLINK' => add_query_arg(
                                array(
                                    'email' => $_POST['emailid'],
                                    'verification_token' => $activation_token
                                ),
                                $_POST['wp_current_url']
                            )
                        );
                        /******* User Email Template Start *********/
                        user_send_email_verification_token($_POST, $tokens);

                        $response['code'] = 1;
                        $response['alert'] = get_field("account_not_activated", "option");
                    } else {
                        $response['code'] = 0;
                        $response['alert'] = __($new_user_id->get_error_message(), 'twentytwenty');
                    }
                } else {
                    $response['alert'] = __($new_user_id->get_error_message(), 'twentytwenty');
                }
            } else {
                $response['code'] = 0;
                $response['alert'] = "Please select captcha again!";
            }
        }
    }
    echo json_encode($response);
    wp_die();
}
add_action('wp_ajax_nopriv_fn_Registration', 'fn_Registration');
add_action('wp_ajax_fn_Registration', 'fn_Registration');

function fn_Login()
{
    global $wpdb;

    $status                 = false;
    $response               = array();
    $response['code']       = 0;
    $response['redirect']   = $_POST['redirect_url'];
    $response['alert']      = '';

    if (!wp_verify_nonce($_POST['login_nonce'], 'login-nonce')) {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    } else if (empty($_POST['emailid'])) {
        $status = false;
        $response['alert'] = __('Email address is required.', 'twentytwenty');
    } else if (empty($_POST['password'])) {
        $status = false;
        $response['alert'] = __('Password is required.', 'twentytwenty');
    } else {
        $status = true;
    }

    if ($status) :

        $get_username = trim($_POST['emailid']);
        $user = get_user_by('email', $get_username);

        
        // if (!empty($credentials['remember'])) {
        //     $credentials['remember'] = true;
        // } else {
        //     $credentials['remember'] = false;
        // }

        

        

        if (!empty($user->user_login))
            $get_username = $user->user_login;

        // preparing credentials array
        $credentials = array();

        $credentials['user_login'] = $get_username;
        $credentials['user_password'] = trim($_POST['password']);        

        // print_r($credentials['remember']);exit;
        check_user_verified_email_or_not($credentials);

        $credentials['remember'] = 0;
        if(isset($_POST['rememberme'])){
            $credentials['remember'] = 1;
        }

        // auto login the user
        $user = wp_signon($credentials, false);

        // checking for authentication error
        if (is_wp_error($user)) {
            $response['alert'] = __('Username or password is incorrect.', 'twentytwenty');
            $response['code'] = 0;
        } else {
            
            wp_set_auth_cookie($user->data->ID,true);
            // wp_set_auth_cookie( $user->data->ID, $credentials['remember']);
            $expiration = time() + apply_filters( 'auth_cookie_expiration', 14 * DAY_IN_SECONDS, $user->data->ID, $credentials['remember'] );
            $expiration + ( 12 * HOUR_IN_SECONDS );
            // setting current logged in user
            wp_set_current_user($user->data->ID, $user->data->user_login);

            // Adding hook so that anyone can add action on user login
            do_action('set_current_user');
            $response['code'] = 1;
            $response['alert'] = __('You are successfully logged in.', 'twentytwenty');
        }

    endif;

    wp_send_json($response);
}

add_action('wp_ajax_nopriv_fn_Login', 'fn_Login');
add_action('wp_ajax_fn_Login', 'fn_Login');

function fn_Profile_update()
{
    global $wpdb;

    $status                 = false;
    $response               = array();
    $response['code']       = 0;
    $response['alert']      = '';

    if (!wp_verify_nonce($_POST['profile-nonce'], 'profile-nonce')) {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    } else if (empty($_POST['emailid'])) {
        $status = false;
        $response['alert'] = __('Email address is required.', 'twentytwenty');
    } else if (empty($_POST['uname'])) {
        $status = false;
        $response['alert'] = __('Your name is required.', 'twentytwenty');
    } else {
        $status = true;
    }
    if ($status) {
        $update_user_id = wp_update_user(array(
            'ID'                => $_POST['user_id'],
            'first_name'        => ucfirst($_POST['uname']),
            'user_email'        => $_POST['emailid'],
            'user_login'        => $_POST['uname'],
        ));
        if (!is_wp_error($update_user_id)) {
            update_user_meta($update_user_id, 'user_telphone', $_POST['telphone']);
            // update_user_meta( $update_user_id, 'user_address1', $_POST['address1']);
            // update_user_meta( $update_user_id, 'user_address2', $_POST['address2']);
            // update_user_meta( $update_user_id, 'user_town', $_POST['town']);
            update_user_meta($update_user_id, 'user_country', $_POST['country']);
            update_user_meta($update_user_id, 'user_postcode', $_POST['postcode']);
            update_user_meta($update_user_id, 'user_newsletter', $_POST['newsletter']);
            $response['code'] = 1;
            $response['alert'] = "Profile updated successfully!";
        } else {
            $response['alert'] = __($new_user_id->get_error_message(), 'twentytwenty');
        }
        echo json_encode($response);
        wp_die();
    }
}

add_action('wp_ajax_nopriv_fn_Profile_update', 'fn_Profile_update');
add_action('wp_ajax_fn_Profile_update', 'fn_Profile_update');

function fn_reset_password()
{
    global $wpdb;

    $status                 = false;
    $response               = array();
    $response['code']       = 0;
    $response['alert']      = '';
    $response['login_redirect']   = $_POST['login_redirect'];
    if (!wp_verify_nonce($_POST['reset-nonce'], 'reset-nonce')) {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    }else if ($_POST['password'] == '') {
        $status = false;
        $response['alert'] = __('Password is required', 'twentytwenty');
    }else if ($_POST['cpassword'] == '') {
        $status = false;
        $response['alert'] = __('Confirm password is required', 'twentytwenty');
    } else {
        $status = true;
    }
    if($status)
    {
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        
        if ($password == $cpassword) {
            wp_set_password($password, $_POST['user_id']);
            $response['code'] = 1;
            $response['alert'] = __('Your password has been changed successfully.', 'twentytwenty');
            //wp_send_json($response);
        }else
        {
            $response['code'] = 0;
            $response['alert'] = __('Your password has been not changed successfully. Please try again!', 'twentytwenty');
        }


    }
    wp_send_json($response);
    
}
add_action('wp_ajax_nopriv_fn_reset_password', 'fn_reset_password');
add_action('wp_ajax_fn_reset_password', 'fn_reset_password');

function check_user_verified_email_or_not($credentials)
{
    // getting user details
    $user = get_user_by('login', $credentials['user_login']);

    if (!$user->ID) {
        $response['alert'] = __('The username you have entered does not exist.', 'twentytwenty');
    } else {

        $stored_token = get_user_meta($user->ID, 'user_email_verification_token', true);
        if (!$stored_token) {
            return true;
        } else {
            $response['alert'] = __('Your account has not been activated yet, please verify your email first.', 'twentytwenty');
        }
    }

    wp_send_json($response);
}

function make_email_template($mail_content = "", $tokens = array(), $patterns = '')
{
    $pattern = '%%%s%%';

    if (!empty($patterns) && $patterns == 'p') {
        $pattern = '%%%s%%';
    }

    $map = array();

    foreach ($tokens as $var_key => $actual_value) {
        $map[sprintf($pattern, $var_key)] = $actual_value;
    }

    $mail_message = strtr($mail_content, $map);

    return $mail_message;
}

function user_send_email_verification_token($usermeta, $tokens)
{


    $to = $usermeta['emailid'];
    $subject = make_email_template(get_field('new_user_act_verify_email_subject', 'option'), $tokens);

    // $user_headers = array('Content-Type: text/html; charset=UTF-8');
    // $user_headers[] = 'From: '. get_bloginfo( 'name' ) . '<'.get_option('admin_email').'>';

    // Always set content-type when sending HTML email
    $user_headers = "MIME-Version: 1.0" . "\r\n";
    $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $user_headers .= 'From: ' . get_bloginfo('name') . '<' . get_option('admin_email') . '>' . "\r\n";



    if (get_field('new_user_act_verify_email_message', 'option')) {
        $mail_content = make_email_template(get_field('new_user_act_verify_email_message', 'option'), $tokens);
    }

    mail($to, $subject, $mail_content, $user_headers);
}
function user_verify_token()
{
    $status = 0;
    // checking email and token
    if (isset($_GET) && isset($_GET['verification_token']) && isset($_GET['email'])) {
        $user = get_user_by('email', $_GET['email']);

        if ($user->ID)
            $stored_token = get_user_meta($user->ID, 'user_email_verification_token', true);
        if ($stored_token == $_GET['verification_token']) {
            // preparing user data
            $userdata = array();
            $userdata['username'] = $user->data->user_login;
            $userdata['email']    = $user->data->user_email;

            // removing token on verification
            delete_user_meta($user->ID, 'user_email_verification_token');

            // sending registration success email
            $tokens = array(
                'USERNAME'      => $userdata['username'],
                'BLOGNAME'      => get_option('blogname'),
                'USEREMAIL'     => $userdata['email'],
                'BLOGURL'       => get_site_url(),

            );
            user_confirm_mail($userdata, $tokens);
            $status = 1;
            return $status;
        } else {
            $status = 2;
            return $status;
        }
    }

    return $status;
}

function user_confirm_mail($usermeta, $tokens)
{

    /* Mail sent to User */

    $user_to = $usermeta['email'];
    $user_subject = make_email_template(get_field('new_user_wel_email_subject', 'option'), $tokens);


    // $user_headers = array('Content-Type: text/html; charset=UTF-8');
    //$user_headers[] = 'From: '. get_bloginfo( 'name' ) . '<'.get_option('admin_email').'>';

    $user_headers = "MIME-Version: 1.0" . "\r\n";
    $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $user_headers .= 'From: ' . get_bloginfo('name') . '<' . get_option('admin_email') . '>' . "\r\n";

    if (get_field('new_user_wel_email_message', 'option')) {
        $user_mail_content = make_email_template(get_field('new_user_wel_email_message', 'option'), $tokens);
    }

    mail($user_to, $user_subject, $user_mail_content, $user_headers);


    /* Mail sent to Admin */

    /*   $admin_to = get_option( 'admin_email', 'option' );
            $admin_subject = make_email_template( get_field( 'admin_email_subject', 'option' ), $tokens );

            $admin_headers = array('Content-Type: text/html; charset=UTF-8');
            $admin_headers[] = 'From: '. get_bloginfo( 'name' ) . '<'.get_option('admin_email').'>';

            
            if( get_field( 'admin_email_message', 'option' ) ){
                $admin_mail_content = make_email_template( get_field( 'admin_email_message', 'option' ), $tokens );
            }
            wp_mail( $admin_to, $admin_subject, $admin_mail_content, $admin_headers );*/
}


function send_reset_password_token($userdata, $tokens)
{
    // configuring email options
    $to = $userdata['email'];

    $subject = make_email_template(get_field('pass_reset_email_subject', 'option'), $tokens);

    // using content type html for emails
    //$headers = array('Content-Type: text/html; charset=UTF-8');
    //$headers[] = 'From:' . get_option('blogname').'<'.get_option('admin_email').'>';

    $user_headers = "MIME-Version: 1.0" . "\r\n";
    $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $user_headers .= 'From: ' . get_bloginfo('name') . '<' . get_option('admin_email') . '>' . "\r\n";

    if (get_field('pass_reset_email_message', 'option')) {
        $message = make_email_template(get_field('pass_reset_email_message', 'option'), $tokens);
    }


    return mail($to, $subject, $message, $user_headers);
}
?>