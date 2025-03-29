<?php

use cybot\cookiebot\lib\Cookiebot_WP;
use cybot\cookiebot\lib\Cookiebot_Frame;
use cybot\cookiebot\settings\pages\Dashboard_Page;
use cybot\cookiebot\settings\pages\Settings_Page;
use cybot\cookiebot\addons\config\Settings_Config;
use cybot\cookiebot\settings\pages\Support_Page;
use cybot\cookiebot\settings\pages\Debug_Page;

/**
 * @var string $active_tab
 */

$isnw = is_network_admin();

$cbid          = Cookiebot_WP::get_cbid();
$user_data     = Cookiebot_WP::get_user_data();
$show_settings = $active_tab === 'settings' || empty( $user_data ) && ! empty( $cbid );
$show_plugins  = ( ! $isnw && Cookiebot_Frame::is_cb_frame_type() !== 'empty' ) || empty( $user_data );
$show_debug    = ( ! $isnw && Cookiebot_Frame::is_cb_frame_type() !== 'empty' ) || empty( $user_data );
$feedback_url  = 'https://form.typeform.com/to/n6ZlunZP';

?>
<div class="cb-main__tabs">
	<?php if ( ! $isnw ) : ?>
		<div class="cb-main__tabs_item <?php echo $active_tab === 'dashboard' ? 'active-item' : ''; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'page', Dashboard_Page::ADMIN_SLUG, admin_url( 'admin.php' ) ) ); ?>"
				class="cb-main__tabs__link">
				<div class="cb-main__tabs__icon dashboard-icon"></div>
				<span><?php esc_html_e( 'Dashboard', 'cookiebot' ); ?></span>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( $show_settings ) : ?>
		<div class="cb-main__tabs_item <?php echo $active_tab === 'settings' ? 'active-item' : ''; ?>">
			<?php if ( $isnw ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'page', 'cookiebot_network', network_admin_url( 'admin.php' ) ) ); ?>"
				class="cb-main__tabs__link">
				<?php else : ?>
				<a href="<?php echo esc_url( add_query_arg( 'page', Settings_Page::ADMIN_SLUG, admin_url( 'admin.php' ) ) ); ?>"
					class="cb-main__tabs__link">
					<?php endif; ?>
					<div class="cb-main__tabs__icon settings-icon"></div>
					<span><?php esc_html_e( 'Settings', 'cookiebot' ); ?></span>
				</a>
		</div>
	<?php endif; ?>

	<?php if ( $show_plugins ) : ?>
		<div class="cb-main__tabs_item <?php echo $active_tab === 'addons' ? 'active-item' : ''; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'page', Settings_Config::ADMIN_SLUG, admin_url( 'admin.php' ) ) ); ?>"
				class="cb-main__tabs__link">
				<div class="cb-main__tabs__icon plugins-icon"></div>
				<span><?php esc_html_e( 'Plugins', 'cookiebot' ); ?></span>
			</a>
		</div>
	<?php endif; ?>
	<div class="cb-main__tabs_item <?php echo $active_tab === 'support' ? 'active-item' : ''; ?>">
		<?php if ( $isnw ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'page', Support_Page::ADMIN_SLUG, network_admin_url( 'admin.php' ) ) ); ?>"
			class="cb-main__tabs__link">
			<?php else : ?>
			<a href="<?php echo esc_url( add_query_arg( 'page', Support_Page::ADMIN_SLUG, admin_url( 'admin.php' ) ) ); ?>"
				class="cb-main__tabs__link">
				<?php endif; ?>
				<div class="cb-main__tabs__icon support-icon"></div>
				<span><?php esc_html_e( 'Support', 'cookiebot' ); ?></span>
			</a>
	</div>
	<?php if ( $show_debug ) : ?>
		<div class="cb-main__tabs_item <?php echo $active_tab === 'debug' ? 'active-item' : ''; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'page', Debug_Page::ADMIN_SLUG, admin_url( 'admin.php' ) ) ); ?>"
				class="cb-main__tabs__link">
				<div class="cb-main__tabs__icon debug-icon"></div>
				<span><?php esc_html_e( 'Debug info', 'cookiebot' ); ?></span>
			</a>
		</div>
	<?php endif; ?>

	<div class="cb-feedback_link">
		<a href="<?php echo esc_url( $feedback_url ); ?>" target="_blank"><?php echo esc_html__( 'Share feedback', 'cookiebot' ); ?></a>
	</div>

</div>
