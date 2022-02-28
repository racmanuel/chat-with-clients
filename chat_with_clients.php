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

class ChatWithClients {
    public function __construct() {
        // Init properties (in case you need it)
    }

    public function init() {
        add_filter('the_content', array($this, 'append_post_notification'));
    }

    public function append_post_notification($content)
    {
        $notification = __('This message was appended with a Demo Plugin.', 'demo-plugin-locale');
        return $content . $notification;
    }
}
$Object = new ChatWithClients();
$Object->init();