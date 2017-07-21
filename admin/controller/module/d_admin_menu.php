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
        $this->load->config('d_admin_menu');

        $data['config'] = $this->config->get('d_admin_menu');

        // styles and scripts
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
        $this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

        // Add more styles, links or scripts to the project is necessary
        $url_params = array();
        $url = '';

        if(isset($this->response->get['store_id'])){
            $url_params['store_id'] = $this->store_id;
        }

        if(isset($this->response->get['config'])){
            $url_params['config'] = $this->response->get['config'];
        }

        // Custom stuff
        if (isset($this->request->get['filter_name'])) {
            $url_params['filter_name'] = urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_parent'])) {
            $url_params['filter_parent'] = urlencode(html_entity_decode($this->request->get['filter_parent'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url_params['filter_status'] = urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
        }

        $url = ((!empty($url_params)) ? '&' : '' ) . http_build_query($url_params);


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

        // Tabs
        $data['tab_module'] = $this->language->get('tab_module');
        $data['tab_setting'] = $this->language->get('tab_setting');

        // Button
        $data['button_create'] = $this->language->get('button_create');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_enable'] = $this->language->get('button_enable');
        $data['button_disable'] = $this->language->get('button_disable');
        $data['button_filter'] = $this->language->get('button_filter');

        // Filter
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_link'] = $this->language->get('entry_link');
        $data['entry_parent'] = $this->language->get('entry_parent');
        $data['entry_icon'] = $this->language->get('entry_icon');
        $data['entry_status'] = $this->language->get('entry_status');

        // Custom stuff
        $data['column_name'] = $this->language->get('column_name');
        $data['column_parent'] = $this->language->get('column_parent');
        $data['column_icon'] = $this->language->get('column_icon');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['text_no_results'] = $this->language->get('text_no_results');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

        if (isset($this->session->data['error'])) {
            $data['error']['warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }

        // Custom stuff
        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $filter_name = (isset($this->request->get['filter_name'])) ? $this->request->get['filter_name'] : null;
        $filter_parent = (isset($this->request->get['filter_parent'])) ? $this->request->get['filter_parent'] : null;
        $filter_status = (isset($this->request->get['filter_status'])) ? $this->request->get['filter_status'] : null;

        $sort = (isset($this->request->get['sort'])) ? $this->request->get['sort'] : 'code';
        $order = (isset($this->request->get['order'])) ? $this->request->get['order'] : 'ASC';
        $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;

        $data['menu_items'] = array();

        $filter_data = array(
            'filter_name'               => $filter_name,
            'filter_parent'             => $filter_parent,
            'filter_status'             => $filter_status,
            'sort'                      => $sort,
            'order'                     => $order,
            'start'                     => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                     => $this->config->get('config_limit_admin')
        );

        $menu_items_total = $this->model_module_d_admin_menu->getTotalMenuItems($filter_data);

        $results = $this->model_module_d_admin_menu->getMenuItems($filter_data);

        foreach ($results as $result) {

            $enable = $this->model_module_d_admin_menu->ajax($this->route.'/enable', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] . $url, 'SSL');
            $disable = $this->model_module_d_admin_menu->ajax($this->route.'/disable', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] . $url, 'SSL');

            $data['menu_items'][] = array(
                'menu_item_id'   => $result['menu_item_id'],
                'name'           => $result['name'],
                'link'           => $result['link'],
                'parent'         => $result['parent'],
                'icon'           => $result['icon'],
                'status'         => (isset($result['status'])) ? $result['status'] : 1,
                'enable'         => $enable,
                'disable'        => $disable,
                'edit'           => $this->url->link($this->route.'/edit', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] . $url, 'SSL')
            );
        }

        //sort
        if ($order == 'ASC') {
            $url_params['order'] = 'DESC';
        } else {
            $url_params['order'] = 'ASC';
        }
        unset($url_params['sort']);
        $url = ((!empty($url_params)) ? '&' : '' ) . http_build_query($url_params);
        $data['sort_name'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_parent'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=parent' . $url, 'SSL');
        $data['sort_icon'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_status'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

        //pagination
        if (isset($this->request->get['sort'])) {
            $url_params['sort'] = $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url_params['order'] = $this->request->get['order'];
        }
        unset($url_params['page']);
        $url = ((!empty($url_params)) ? '&' : '' ) . http_build_query($url_params);
        $pagination = new Pagination();
        $pagination->total = $menu_items_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf(
            $this->language->get('text_pagination'),
            ($menu_items_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0,
            ((($page - 1) * $this->config->get('config_limit_admin')) > ($menu_items_total - $this->config->get('config_limit_admin'))) ? $menu_items_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')),
            $menu_items_total,
            ceil($menu_items_total / $this->config->get('config_limit_admin'))
        );

        $data['filter_name'] = $filter_name;
        $data['filter_parent'] = $filter_parent;
        $data['filter_status'] = $filter_status;

        $this->load->model('setting/store');


        $data['sort'] = $sort;
        $data['order'] = $order;


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
        $this->load->model('module/d_admin_menu');
        $this->model_module_d_admin_menu->installDatabase();

        if($this->d_shopunity){
            $this->load->model('d_shopunity/mbooth');
            $this->model_d_shopunity_mbooth->installDependencies($this->codename);
        }

        $this->installEvents();
    }

    public function uninstall()
    {
        $this->uninstallEvents();
    }


    public function displayMenu()
    {
        $this->load->config('d_admin_menu');

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
