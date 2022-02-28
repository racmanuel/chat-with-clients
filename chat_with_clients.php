<?php
/**
 * Plugin Name:       Chat with Clients
 * Description:       Show a WhatsApp Button in WooCommerce admin orders.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Manuel Ramírez Coronel
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       chat-with-clients
 * Domain Path:       /languages
 */

/**
 * Get the bootstrap!
 * (Update path to use cmb2 or CMB2, depending on the name of the folder.
 * Case-sensitive is important on some systems.)
 */
require_once __DIR__ . '/cmb2/init.php';

class ChatWithClients
{
    public $prefix = 'chat_with_clients_';

    public function __construct()
    {
        // Init properties (in case you need it)
    }

    public function init()
    {
        add_action('cmb2_admin_init', array($this, 'chat_with_clients_register_options_submenu_for_settings'));
        add_action('cmb2_admin_init', array($this, 'chat_with_clients_register_options_submenu_appearance_menu'));
    }

    /**
     * Hook in and register a submenu options page for the Page post-type menu.
     */
    public function chat_with_clients_register_options_submenu_for_settings($prefix)
    {

        /**
         * Registers options page menu item and form.
         */
        $cmb = new_cmb2_box(array(
            'id' => 'chat_with_clients_options_submenu_page',
            'title' => esc_html__('WhatsApp for Orders', 'cmb2'),
            'object_types' => array('options-page'),

            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */

            'option_key' => 'chat_with_clients_page_options', // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug' => 'options-general.php', // Make options page a submenu item of the themes menu.
            'capability' => 'manage_options', // Cap required to view options-page.
            // 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
            // 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
            // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
            // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
            // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
            // 'message_cb'      => 'yourprefix_options_page_message_callback',
        ));
        
        include __DIR__ . '/countries.php';

        $Countries_Options= array_column($Countries, 'name','dial_code');

        //print_r($Countries_Options);

        $cmb->add_field(array(
            'name' => 'Country Code',
            'desc' => 'Select an option',
            'id' => $prefix . 'country_code',
            'type' => 'select',
            'show_option_none' => true,
            'default' => 'custom',
            'options' => $Countries_Options
        ));

        $cmb->add_field(array(
            'name' => __('WhatsApp', 'theme-domain'),
            'desc' => __('Insert your WhatsApp Number without a Country Code.', 'msft-newscenter'),
            'id' => $prefix . 'number',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb' => 'absint',
        ));

    }

    /**
     * Hook in and register a submenu options page for the Appearance menu.
     */
    public function chat_with_clients_register_options_submenu_appearance_menu()
    {

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id' => 'chat_with_clients_options_submenu_appearance_menu',
            'title' => esc_html__('Appearance Options', 'cmb2'),
            'object_types' => array('options-page'),

            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */

            'option_key' => 'chat_with_clients_theme_appearance_options', // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug' => 'themes.php', // Make options page a submenu item of the themes menu.
            // 'capability'      => 'manage_options', // Cap required to view options-page.
            // 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
            // 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
            // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
            // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
            // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
            // 'message_cb'      => 'yourprefix_options_page_message_callback',
        ));

        /**
         * Options fields ids only need
         * to be unique within this box.
         * Prefix is not needed.
         */
        $cmb_options->add_field(array(
            'name' => esc_html__('Site Background Color', 'cmb2'),
            'desc' => esc_html__('field description (optional)', 'cmb2'),
            'id' => 'bg_color',
            'type' => 'colorpicker',
            'default' => '#ffffff',
        ));
    }

}
$Object = new ChatWithClients();
$Object->init();