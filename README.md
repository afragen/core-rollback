# Core Rollback

 * Author:            Andy Fragen
 * Author URI:        https://github.com/afragen
 * Donate link:       https://thefragens.com/github-updater-donate
 * License:           MIT
 * Requires PHP:      5.6
 * Requires at least: 5.0

## Description

Seamless rollback of WordPress Core in your current locale using the Core Update API and Core Update methods.

## Usage

From the Tools menu select `Rollback Core`, select the version you wish to rollback to from the dropdown and click `Re-install`. You will be directed to the `update-core.php` page where you should see a button to re-install your specified version. This has a timeout of a minute.

**WARNING:** Downgrading WordPress Core may leave your site in an unusable state requiring a complete reinstall or a forced reinstall using WP-CLI, `wp core update --force --version=5.5.3`. It may also leave your site broken due to a plugin or theme incompatibility. Use at your own risk.

Rollbacks use your current locale.

PRs are welcome against the `develop` branch.
