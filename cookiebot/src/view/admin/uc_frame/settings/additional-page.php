<?php
/**
 * @var bool $is_ms
 * @var string $network_scrip_tag_cd_attr
 */
?>
<div class="cb-settings__config__item">
	<div class="cb-settings__config__content">
		<h3 class="cb-settings__config__subtitle">
			<?php esc_html_e( 'Automatic updates', 'cookiebot' ); ?>
		</h3>
		<p class="cb-general__info__text">
			<?php esc_html_e( 'Enable automatic updates whenever we release a new version of the plugin.', 'cookiebot' ); ?>
		</p>
	</div>
	<div class="cb-settings__config__data">
		<div class="cb-settings__config__data__inner">
			<label class="switch-checkbox" for="cookiebot-autoupdate">
				<input id="cookiebot-autoupdate" type="checkbox" name="cookiebot-autoupdate" value="1"
					<?php
					checked(
						1,
						get_option( 'cookiebot-autoupdate', false )
					);
					?>
				/>
				<div class="switcher"></div>
				<?php esc_html_e( 'Automatically update to new version', 'cookiebot' ); ?>
			</label>
		</div>
	</div>
</div>

<div class="cb-settings__config__item">
	<div class="cb-settings__config__content">
		<h3 class="cb-settings__config__subtitle">
			<?php esc_html_e( 'Show banner on site', 'cookiebot' ); ?>
		</h3>
		<p class="cb-general__info__text">
			<?php esc_html_e( 'You can choose to display or hide the consent banner on your website.', 'cookiebot' ); ?>
		</p>
	</div>
	<div class="cb-settings__config__data">
		<div class="cb-settings__config__data__inner">
			<label class="switch-checkbox" for="cookiebot-banner-enabled">
				<?php
				$disabled = false;
				if ( $is_ms && get_site_option( 'cookiebot-banner-enabled' ) ) {
					echo '<input type="checkbox" checked disabled />';
					$disabled = true;
				} else {
					?>
					<input id="cookiebot-banner-enabled" type="checkbox"
							name="cookiebot-banner-enabled" value="1"
						<?php
						checked(
							1,
							get_option( 'cookiebot-banner-enabled', false )
						);
						?>
					/>
					<?php
				}
				?>
				<div class="switcher"></div>
				<?php esc_html_e( 'Show banner on site', 'cookiebot' ); ?>
			</label>
		</div>
	</div>
</div>
