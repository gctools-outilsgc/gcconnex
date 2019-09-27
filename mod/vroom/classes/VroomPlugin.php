<?php
/*
    Plugin Name: VroomPlugin
    Plugin URI: http://mitre.org/
    Description: Vroom speeds up elgg
    Version: 1.0
    Author: Michael Jett
    Author URI: http://www.mitre.org/
    Author Email: mjett@mitre.org
    License:

      Copyright 2013 MITRE (mjett@mitre.org)

      This program is free software; you can redistribute it and/or modify
      it under the terms of the GNU General Public License, version 2, as
      published by the Free Software Foundation.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program; if not, write to the Free Software
      Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
class VroomPlugin
{

    /**
     * Class construct
     */
    public function __construct()
    {
        // Initialize hooks
        elgg_register_event_handler('init', 'system', array($this, 'init'));
    }

    /**
     * Called when the elgg system initializes
     */
    public function init()
    {
        /*
         * After elgg finishes an entire system execution, send the output to browser
         * This allows the other system shutdown processes to continue in the background while output gets returned to the user promptly
         */
        elgg_register_event_handler('shutdown', 'system', array($this, 'flushToBrowser'), 0);

    }

    /**
     * Forces output to the browser so additional php functionality can continue in the background
     */
    public function flushToBrowser()
    {
        // Registering a shutdown flag allows other points in jettmail to determine if the state is in shutdown
        $GLOBALS['shutdown_flag'] = 1;

        // Check to see if the headers have been sent or another plugin is sending a different connection header
        if (!headers_sent() && !self::connectionSent()) {

            // Ignore user aborts and allow the script to run forever
            ignore_user_abort(true);
			session_write_close();
            set_time_limit(0);

            // Tell the browser that we are done
            header("Connection: close");
            $size = ob_get_length();
            header("Content-Length: $size");
            ob_end_flush();

            // allow vroom for fastcgi instances
            if (is_callable('fastcgi_finish_request')) {
                 fastcgi_finish_request();
            }

            flush();
        }

    }

    /**
     * Sifts through the headers to see if a connection has been sent
     *
     * This is useful if a plugin wants to keep a connection alive
     * @return bool
     */
    public function connectionSent () {

        $headers = headers_list();

        foreach ($headers as $hdr) {
            if (stripos($hdr, "Connection") === 0) {
                return true;
            }
        }

        return false;
    }


}
