<div class="wrap">
    <h1>フォーチュンアド設定</h1>
    <form method="post" action="options.php">
        <?php settings_fields( $this->option_name ); ?>
        <?php $options = get_option( $this->option_name ); ?>

        <table class="form-table">
            <tr>
                <th scope="row" colspan="2">
                    ショートコード : <code>[<?php echo $this->tag_name; ?>]</code>
                </th>
            </tr>
            <tr>
                <th scope="row">広告コード</th>
                <td>
                    <label>
                        <input type="text" name="<?php echo $this->option_name; ?>[ad_code]" value="<?php echo isset( $options['ad_code'] ) ? esc_attr( $options['ad_code'] ) : ''; ?>"/>
                        <a href="https://manager.afiina.jp/admin/network/spaces" target="_blank" style="margin-left: 1rem;">広告コード取得</a>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">広告表示</th>
                <td>
                    <label>
                        <input type="checkbox" name="<?php echo $this->option_name; ?>[enable_ad]" value="1" <?php checked( 1, $options['enable_ad'] ?? 0 ); ?> />
                    </label>
                    有効化
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>
