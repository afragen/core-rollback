# Core Rollback

Contributors: afragen
Donate link: https://thefragens.com/github-updater-donate
Tags: core, rollback, downgrade, upgrade
License: MIT
Requires PHP: 5.6
Requires at least: 4.0
Stable tag: 1.1.0
Tested up to: 5.8

Seamless rollback of WordPress Core to latest release or any outdated, secure release using the Core Update API and core update methods. Only latest release and outdated, secure releases are offered.

Refer to https://api.wordpress.org/core/stable-check/1.0/

## Usage

From the Tools menu select `Rollback Core`, select the version you wish to rollback to from the dropdown and click `Rollback`. You will be directed to the `update-core.php` page where you should see a button to `Re-install` your specified version.  If you move away from the `update-core.php` page before clicking the `Re-install` button you will have 15 seconds to return and complete the process or you will need to start over.

In multisite use the Settings menu.

**WARNING:** Downgrading WordPress Core may leave your site in an unusable state requiring a complete reinstall or a forced reinstall using WP-CLI, `wp core update --force --version=5.5.3`. It may also leave your site broken due to a plugin or theme incompatibility. **Use at your own risk.**

Rollbacks use your current locale.

PRs are welcome.

## Screenshots

1. Tools menu item
2. Rollback Core action dropdown
3. Re-install Now button for rollback

## Changelog

#### 1.1.0 / 2021-07-07
* add @10up GitHub Actions for WordPress SVN

#### 1.0.1 / 2020-12-4
* fix text-domain in string, thanks Alex

#### 1.0.0 / 2020-11-17
* initial release to dot org repository
* add `Class Bootstrap` to intiate process
* updated instructions, etc
* add assets, screenshots, banners, icon
* add `readme.txt` and clean up `create_admin_page()`
* add warning notice to settings
* add `force-check` query arg to redirect to more consistently display the `Re-install Now` button.
* limit rollbacks to WP > 4.0, I found some non-recoverable issue in my local testing
* initial release
