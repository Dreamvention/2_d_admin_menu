<?php

class ControllerEventDAdminMenu extends Controller
{

    public function view_column_left_after(&$route, &$data, &$output)
    {
        $html_dom = new d_simple_html_dom();

        $html_dom->load($output, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);

        //hide standard menu
        $html_dom->find('#menu', 0)->style= 'display:none';

        $admin_menu = $this->load->controller('extension/module/d_admin_menu/displayMenu');

        //insert menu after standard menu
        $html_dom->find('#stats', 0)->outertext= $admin_menu;

        $output = (string)$html_dom;

    }
}