<?php

class ControllerModuleDAdminMenu extends Controller
{
    private $codename = 'd_admin_menu';
    private $route = 'module/d_admin_menu';
    private $extension = array();
    private $store_id = 0;
    private $error = array();


    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->model('module/d_admin_menu');
        $this->d_shopunity = (file_exists(DIR_SYSTEM.'mbooth/extension/d_shopunity.json'));

        if ($this->d_shopunity) {
            $this->load->model('d_shopunity/mbooth');
            $this->load->model('d_shopunity/setting');
            $this->extension = $this->model_d_shopunity_mbooth->getExtension($this->codename);
        }

        if (isset($this->request->get['store_id'])) {
            $this->store_id = $this->request->get['store_id'];
        }
    }

    public function required()
    {
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

        $this->model_module_d_admin_menu->installDatabase();

        // dependencies
        $this->load->language($this->route);
        $this->load->language($this->route . '_instruction');
        $this->load->model('setting/setting');

        // get config file
        if ((VERSION >= '2.3.0.0')  && (VERSION < '3.0.0.0')) {
            $this->load->config('d_admin_menu/d_admin_menu_230');
        }
        $data['config'] = $this->config->get('d_admin_menu');

        // save post

        // styles and scripts
        if(!file_exists('view/stylesheet/shopunity/')){
          $this->error['shopunity'] = $this->language->get('shopunity_download');
        }
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
        $this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

        $this->document->addScript('view/javascript/shopunity/bootstrap-sortable.js');
        $this->document->addScript('view/javascript/shopunity/tinysort/jquery.tinysort.min.js');
        $this->document->addScript('view/javascript/shopunity/serializeObject/serializeObject.js');

        $url = '';
        $data['module_link'] = HTTPS_SERVER . 'index.php?route=' . $this->route . '&token=' . $this->session->data['token'] . $url;

        if (isset($this->request->get['store_id'])) {
            $url .= '&store_id=' . $this->store_id;
        }

        if (isset($this->request->get['setting_id'])) {
            $url .= '&setting_id=' . $this->request->get['setting_id'];
        } elseif ($this->model_module_d_admin_menu->getCurrentSettingId($this->codename, $this->store_id)) {
            $url .= '&setting_id=' . $this->model_module_d_admin_menu->getCurrentSettingId($this->codename, $this->store_id);
        }

        // if (isset($this->request->get['config'])) {
        //     $url .= '&config=' . $this->request->get['config'];
        // }

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
        );

        if(VERSION < '2.3.0.0'){
            $data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_module'),
                'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
                );
        } else {
            $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'),
            'separator' => ' :: '
            );
        }

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        // Notification
        foreach ($this->error as $key => $error) {
            $data['error'][$key] = $error;
        }

        // Heading
        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_edit'] = $this->language->get('text_edit');

        // Variable
        $data['id'] = $this->codename;
        $data['route'] = $this->route;
        $data['store_id'] = $this->store_id;
        $data['support_email'] = $this->extension['support']['email'];
        $data['version'] = $this->extension['version'];
        $data['token'] = $this->session->data['token'];

        // Tab
        $data['tab_setting'] = $this->language->get('tab_setting');
        $data['tab_instruction'] = $this->language->get('tab_instruction');

        $data['text_home'] = $this->language->get('text_home');
        $data['text_general'] = $this->language->get('text_general');
        $data['text_standart_menu'] = $this->language->get('text_standart_menu');
        $data['text_custom_menu'] = $this->language->get('text_custom_menu');
        $data['text_instruction'] = $this->language->get('text_instruction');

        // Button
        $data['button_save'] = $this->language->get('button_save');
        $data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_clear'] = $this->language->get('button_clear');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_hide'] = $this->language->get('button_hide');

        // Text
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_enable'] = $this->language->get('text_enable');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');

        // action
        $data['action'] = HTTPS_SERVER . 'index.php?route=' . $this->route . '&token=' . $this->session->data['token'] . $url;

        if(VERSION < '2.3.0.0'){
            $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        }else{
            $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
        }

        // success & error
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else { $data['success'] = ''; }

        if (isset($this->session->data['error'])) {
            $data['error']['warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }





        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view($this->route . '.tpl', $data));
    }



    /////////////////////////////////////////////////////////////////////////////////////
    /////////                             ASSISTING                             /////////
    /////////////////////////////////////////////////////////////////////////////////////





    /////////////////////////////////////////////////////////////////////////////////////
    /////////                              INSTALL                              /////////
    /////////////////////////////////////////////////////////////////////////////////////

    private function validate($permission = 'modify')
    {
        $this->language->load($this->route);

        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }
        // if (isset($this->request->post['config'])) {
        //     return false;
        // }

        return true;
    }

    public function install()
    {
        if($this->validate()){
            $this->load->model('module/d_admin_menu');
            $this->model_module_d_admin_menu->installDatabase();

            if($this->d_shopunity){
                $this->load->model('d_shopunity/mbooth');
                $this->model_d_shopunity_mbooth->installDependencies($this->codename);
            }

            $this->installEvents();
        }
    }

    public function uninstall()
    {
        if($this->validate()){
            $this->load->model('module/d_admin_menu');
            $this->model_module_d_admin_menu->uninstallDatabase();

            $this->uninstallEvents();
        }
    }

    public function installEvents()
    {
        $this->load->model('module/d_event_manager');

        $this->model_module_d_event_manager->addEvent('d_admin_menu', 'admin/view/common/column_left/after', 'module/d_admin_menu/view_column_left_after');
        $this->model_module_d_event_manager->addEvent('d_admin_menu_script', 'admin/view/common/header/before', 'module/d_admin_menu/view_column_left_scripts_before');
    }

    public function uninstallEvents()
    {
        $this->load->model('module/d_event_manager');
        $this->model_module_d_event_manager->deleteEvent('d_admin_menu');
        $this->model_module_d_event_manager->deleteEvent('d_admin_menu_script');
    }



    /////////////////////////////////////////////////////////////////////////////////////
    /////////                               VIEW                                /////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function displayMenu()
    {
        //// $this->load->config('d_admin_menu');

        // $data['config'] = $this->generate_custom_menu();
        //// $data['config'] = $this->config->get('d_admin_menu');

        $data['token'] = $this->session->data['token'];
        return $this->load->view('module/d_admin_menu', $data);
    }

    public function view_column_left_after(&$route, &$data, &$output)
    {
        $html_dom = new d_simple_html_dom();

        $html_dom->load($output, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);

        //hide standard menu
        $html_dom->find('#menu', 0)->style = 'display:none';

        $admin_menu = $this->load->controller('module/d_admin_menu/displayMenu');

        //insert menu after standard menu
        $html_dom->find('#stats', 0)->outertext = $admin_menu;

        $output = (string)$html_dom;
    }

    public function view_column_left_scripts_before(&$route, &$data, &$output)
    {
        //add fontawesome icons
        $data['scripts'][] = 'https://use.fontawesome.com/0b3dfb29a7.js';
    }

}
