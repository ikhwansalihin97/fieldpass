<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShellController extends CI_Controller {

    public function executeShellScript() {
        // Execute the shell script
        $output = shell_exec('php /var/www/html/ligakita_apps/euro/artisan calculate:sub > /dev/null 2>/dev/null &');
        
        // Log the output or handle it as needed
        log_message('info', 'Shell script executed. Output: ' . $output);

        // Optionally, you can redirect or send a response
        // redirect('your/success/route');

        // Send a response to indicate success
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['result' => 'success']));
    }
}