<?php

class ControllerModuleDAdminMenu extends Controller
{
    private $codename = 'd_admin_menu';
    private $route = 'module/d_admin_menu';
    private $extension = array();
    private $store_id = 0;
    private $error = array();


    public function __construct($registry) {
        parent::__construct($registry);

        $this->d_shopunity = (file_exists(DIR_SYSTEM.'mbooth/extension/d_shopunity.json'));
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM.'mbooth/extension/'.$this->codename.'.json'), true);
        $this->store_id = (isset($this->request->get['store_id'])) ? $this->request->get['store_id'] : 0;
        // if(VERSION >= '2.3.0.0'){
        //     $this->route = 'extension/'.$this->route;
        // }
    }

    public function required(){
        $this->load->language($this->route);

        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_not_found'] = $this->language->get('text_not_found');
        $data['breadcrumbs'] = array();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->request->get['extension'] = $this->codename;
        $this->response->setOutput($this->load->view('error/not_found.tpl', $data));
    }

    public function index()
    {
        if(!$this->d_shopunity){
            $this->response->redirect($this->url->link($this->route.'/required', 'codename=d_shopunity&token='.$this->session->data['token'], 'SSL'));
        }

        $this->load->model('d_shopunity/mbooth');
        $this->model_d_shopunity_mbooth->validateDependencies($this->codename);

        $this->load->language($this->route);
        $this->load->model($this->route);
        $this->load->model('setting/setting');
        $this->load->config('d_admin_menu_230');

        $data['config'] = $this->config->get('d_admin_menu');

        // scripts
        $this->document->addScript('view/javascript/jquery/jquery-2.1.1.min.js');

        // Heading
        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');

        // Variable
        $data['id'] = $this->codename;
        $data['route'] = $this->route;
        $data['version'] = $this->extension['version'];
        $data['token'] =  $this->session->data['token'];
        $data['d_shopunity'] = $this->d_shopunity;

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
            'href' => $this->url->link('module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('module/d_admin_menu_editor.tpl', $data));
    }

    public function install()
    {
        $this->installEvents();

    }

    public function uninstall()
    {
        $this->uninstallEvents();
    }


    public function displayMenu()
    {
        $this->load->config('d_admin_menu_230');

        $data['config'] = $this->config->get('d_admin_menu');

        $data['token'] = $this->session->data['token'];
        return $this->load->view('module/d_admin_menu', $data);
    }

    public function installEvents()
    {
        $this->load->model('module/d_event_manager');

        $this->model_module_d_event_manager->addEvent('d_admin_menu', 'admin/view/common/column_left/after', 'module/d_admin_menu/view_column_left_after');
    }

    public function uninstallEvents()
    {
        $this->load->model('module/d_event_manager');
        $this->model_module_d_event_manager->deleteEvent('d_admin_menu');
    }

    public function view_column_left_after(&$route, &$data, &$output)
    {
        $html_dom = new d_simple_html_dom();

        $html_dom->load($output, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);

        //hide standard menu
        $html_dom->find('#menu', 0)->style= 'display:none';

        $admin_menu = $this->load->controller('module/d_admin_menu/displayMenu');

        //insert menu after standard menu
        $html_dom->find('#stats', 0)->outertext= $admin_menu;

        $output = (string)$html_dom;

    }
}
