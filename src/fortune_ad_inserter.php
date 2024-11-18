<?php

/**
 * Plugin Name: フォーチュンアド
 * Description: フォーチュンアドの広告を簡単に設置するWordPressプラグイン
 * Version: 0.0.9
 * Author: Fortune Ad
 * Author URI: https://manager.afiina.jp/admin
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class FortuneAdInserter
{
    private $option_name = 'fortune_ad_code';
    
    private $api_url = 'https://manager.afiina.jp/wp-plugins/fortune-ad-inserter.json';
    
    private $plugin_slug = 'fortune-ad-inserter';
    
    private $plugin_file;
    
    public function __construct()
    {
        $this->plugin_file = plugin_basename( __FILE__ );
        add_filter( 'site_transient_update_plugins', [ $this, 'check_for_update' ] );
        add_filter( 'plugins_api', [ $this, 'provide_plugin_details' ], 10, 3 );
        add_action( 'admin_menu', [ $this, 'create_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'wp_head', [ $this, 'insert_ad_script' ] );
        add_shortcode( 'fortune_ad', [ $this, 'display_ad_content' ] );
    }
    
    // 更新を確認
    public function check_for_update( $transient )
    {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }
        
        $response = wp_remote_get( $this->api_url, [ 'timeout' => 15 ] );
        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
            return $transient;
        }
        
        $plugin_data = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( isset( $plugin_data['new_version'] ) && version_compare( $plugin_data['new_version'], $transient->checked[$this->plugin_file], '>' ) ) {
            $transient->response[$this->plugin_file] = (object)[
                'slug'        => $this->plugin_slug,
                'new_version' => $plugin_data['new_version'],
                'package'     => $plugin_data['download_url'],
            ];
        }
        
        return $transient;
    }
    
    // プラグイン詳細情報を提供
    public function provide_plugin_details( $result, $action, $args )
    {
        if ( $action !== 'plugin_information' || $args->slug !== $this->plugin_slug ) {
            return $result;
        }
        
        $response = wp_remote_get( $this->api_url, [ 'timeout' => 15 ] );
        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
            return $result;
        }
        
        $plugin_data = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( !$plugin_data ) {
            return $result;
        }
        
        return (object)[
            'name'           => $plugin_data['name'],
            'slug'           => $plugin_data['slug'],
            'version'        => $plugin_data['new_version'],
            'author'         => $plugin_data['author'],
            'author_profile' => $plugin_data['author_profile'],
            'requires'       => $plugin_data['requires'],
            'tested'         => $plugin_data['tested'],
            'last_updated'   => $plugin_data['last_updated'],
            'download_link'  => $plugin_data['download_url'],
            'sections'       => [
                'description' => $plugin_data['description'],
                'changelog'   => $plugin_data['changelog'],
            ],
        ];
    }
    
    // 管理画面に設定ページを追加
    public function create_settings_page()
    {
        add_menu_page(
            'フォーチュンアド設定',
            'フォーチュンアド設定',
            'manage_options',
            'fortune-ad-settings',
            [ $this, 'settings_page_html' ]
        );
    }

    // 設定項目の登録
    public function register_settings()
    {
        register_setting( $this->option_name, $this->option_name );
    }
    
    // 広告設定ページのHTML
    public function settings_page_html()
    {
        include __DIR__ . '/template/setting.php';
    }
    
    // 広告スクリプトをヘッダーに挿入
    public function insert_ad_script()
    {
        $options = get_option( $this->option_name );
        if ( !empty( $options['ad_code'] ) && !empty( $options['enable_ad'] ) ) {
            echo '<script async src="https://api.afiina.jp/tracking/js/v2/ad.js?media=' . esc_attr( $options['ad_code'] ) . '&autoload=true"></script>';
        }
    }
    
    // カスタムタグで広告表示
    public function display_ad_content( $atts = [] )
    {
        $attributes = '';
        if ( isset( $atts['id'] ) ) {
            $attributes = 'id="' . esc_attr( $atts['id'] ) . '" ';
        }
        return '<div class="adams-content" ' . $attributes . '></div>';
    }
}

// プラグイン初期化
new FortuneAdInserter();
