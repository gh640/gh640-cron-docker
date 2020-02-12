<?php
/**
 * Plugin Name:     GH640 cron requests in Docker containers
 * Description:     Prevents WordPress automatic update from failing with
 *                  port fowarding on Docker containers.
 * Version:         0.1.0
 *
 * @package         gh640-cron-docker
 */

$port_guest = getenv('DOCKER_HTTP_PORT_GUEST');
$port_host = getenv('DOCKER_HTTP_PORT_HOST');

if ($port_guest && $port_host) {
  add_filter( 'requests-requests.before_request', function ( &$url, &$headers, &$data ) use ( $port_guest, $port_host ) {
    $siteurl = get_option( 'siteurl' );

    if ( is_string( $url ) && mb_strpos( $url, $siteurl ) === 0 ) {
      $url = mb_ereg_replace( ":${port_host}/" , ":${port_guest}/", $url );
    }
  }, 10, 3 );
}
