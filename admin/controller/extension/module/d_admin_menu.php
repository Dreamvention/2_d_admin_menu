<?php

class ControllerExtensionModuleDAdminMenu extends Controller
{
    private $codename = 'd_admin_menu';
    private $route = 'extension/module/d_admin_menu';

    private $extension = array();
    private $error = array();


    public function index()
    {

        $this->document->addScript('view/javascript/jquery/jquery-2.1.1.min.js');

        $this->load->language($this->route);

        $this->load->model($this->route);
        $this->load->model('setting/setting');

        $this->load->config('d_admin_menu_230');

        $data['config'] = $this->config->get('d_admin_menu');

        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_menu'] = $this->language->get('text_menu');
        $data['text_settings'] = $this->language->get('text_settings');
        $data['text_design'] = $this->language->get('text_design');
        $data['text_instructions'] = $this->language->get('text_instructions');
        $data['text_instructions_full'] = $this->language->get('text_instructions_full');
        $data['text_menu_structure'] = $this->language->get('text_menu_structure');


        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_modules'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('extension/module/d_admin_menu_editor.tpl', $data));
    }

    public function install()
    {
        $this->installEvents();

    }

    public function unistall()
    {
        $this->unistallEvents();
    }


    public function displayMenu()
    {
        $this->load->config('d_admin_menu_230');

        $data['config'] = $this->config->get('d_admin_menu');

        $data['token'] = $this->session->data['token'];
        return $this->load->view('extension/module/d_admin_menu', $data);
    }

    public function installEvents()
    {
        $this->load->model('module/d_event_manager');

        $this->model_module_d_event_manager->addEvent('d_admin_menu', 'admin/view/common/column_left/after', 'event/d_admin_menu/view_column_left_after');
    }

    public function unistallEvents()
    {
        $this->load->model('module/d_event_manager');
        $this->model_module_d_event_manager->deleteEvent('d_admin_menu');
    }
}