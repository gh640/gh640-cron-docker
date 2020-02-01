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
  add_filter( 'cron_request', function ( $cron_request_array, $doing_wp_cron ) use ($port_guest, $port_host) {
    $cron_request_array['url'] = mb_ereg_replace( ":${port_host}/" , ":${port_guest}/", $cron_request_array['url']);

    return $cron_request_array;
  } , 10, 2 );
}
