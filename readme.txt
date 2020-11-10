# Core Rollback

Contributors: afragen
Tags: core, rollback, downgrade, upgrade
License: MIT
Requires PHP: 5.6
Requires at least: 4.0
Stable tag: main
Tested up to: 5.6

Seamless rollback of WordPress Core to any current release using the Core Update API and core update methods.

## Usage

From the Tools menu select `Rollback Core`, select the version you wish to rollback to from the dropdown and click `Re-install`. You will be directed to the `update-core.php` page where you should see a button to `Re-install Now` your specified version.

In multisite use the Settings menu.

**WARNING:** Downgrading WordPress Core may leave your site in an unusable state requiring a complete reinstall or a forced reinstall using WP-CLI, `wp core update --force --version=5.5.3`. It may also leave your site broken due to a plugin or theme incompatibility. **Use at your own risk.**

Rollbacks use your current locale.

Core version check must run to display the `Re-install Now` link. If it doesn't show it's not a plugin error. Just click the `Check Again` button/link.

PRs are welcome.

## Screenshots

1. Tools menu item
2. Rollback Core action dropdown
3. Re-install Now button for rollback
