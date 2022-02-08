[ unreleased ]
* use `sanitize_key()` for nonces

#### 1.3.0 / 2022-01-28
* filter WP versions with significant deprecation notices/errors for newer PHP versions
* add notice about limiting of rollback options for PHP versions

#### 1.2.4 / 2022-01-14
* proper nonce verification of settings page
* remove unneededd `version_compare` check for notice

#### 1.2.3 / 2022-01-11
* I suck and so do typos

#### 1.2.2 / 2022-01-11
* need to use `method_exists` in check to properly function

#### 1.2.1 / 2022-01-11
* add `function_exists( 'is_block_theme' )` check to avoid fatal

#### 1.2.0 / 2022-01-10
* add method to return array of block capable WP versions for rollback

#### 1.1.2 / 2022-01-10
* add notice if currently using block theme, thanks @costdev

#### 1.1.1 / 2021-10-14
* use `sanitize_title_with_dashes()` as `sanitize_file_name()` maybe have attached filter that changes output

#### 1.1.0 / 2021-07-07
* add @10up GitHub Actions for WordPress SVN

#### 1.0.1 / 2020-12-04
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
