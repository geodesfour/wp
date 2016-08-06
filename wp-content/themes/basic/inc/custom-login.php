<?php 
/**
 * Some functions to personalize wordpress admin login page
 * Auto check remember me
 * Change logo and logo link
 * Add Custom style
 */


if ( ! function_exists( 'custom_login_css' ) ) :

function custom_login_css() {
	?>
	<style>
		body.login {
			background: url(<?=get_template_directory_uri() ?>/assets/img/J3URHssSQyqifuJVcgKu_Wald-2.jpg);
			background-size: cover;
		}
		.login h1 a {
			background-image: url(<?=get_template_directory_uri() ?>/assets/img/logo-citeo.png);
			background-size: 158px 58px;
			width: 158px;
			height: 58px;
		}
		.login #backtoblog a, .login #nav a {
			color: #fff;
		}
		.login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
			color: #fff;
		}
		.login form, .login #login_error, .login .message {
			background: rgba(255, 255, 255, 0.8);
		}
	</style>

	<?php
}
add_action('login_head', 'custom_login_css');

function loginpage_custom_link() {
	return 'http://inovagora.net';
}
add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
	return 'Par Inovagora';
}
add_filter('login_headertitle', 'change_title_on_logo');

function login_checked_remember_me() {
	add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
endif;