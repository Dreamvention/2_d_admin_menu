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

        // $this->document->addScript('view/javascript/d_admin_menu/libs/jquery/jquery-2.1.1.min.js');
        // $this->document->addScript('view/javascript/d_admin_menu/libs/jquery/jquery-ui/jquery-ui.min.js');
        // $this->document->addStyle('view/javascript/d_admin_menu/libs/jquery/jquery-ui/jquery-ui.min.css');

        // $this->document->addStyle('view/stylesheet/d_admin_menu/libs/bootstrap/bootstrap.css');
        // $this->document->addScript('view/javascript/d_admin_menu/libs/bootstrap/bootstrap-switch/bootstrap-switch.min.js');
        // $this->document->addStyle('view/stylesheet/d_admin_menu/libs/bootstrap/bootstrap-switch/bootstrap-switch.css');
        // $this->document->addScript('view/javascript/d_admin_menu/libs/bootstrap/bootstrap-sortable.js');

        // $this->document->addScript('view/javascript/d_admin_menu/libs/rubaxa-sortable/sortable.js');
        // $this->document->addStyle('view/stylesheet/d_admin_menu/libs/rubaxa-sortable/sortable.css');
        // $this->document->addScript('view/javascript/d_admin_menu/libs/tinysort/jquery.tinysort.min.js');



        // Add more styles, links or scripts to the project if necessary
        $url_params = array();
        $url = '';

        if(isset($this->response->get['store_id'])){
            $url_params['store_id'] = $this->store_id;
        }

        if(isset($this->response->get['config'])){
            $url_params['config'] = $this->response->get['config'];
        }

        // Custom stuff
        if (isset($this->request->get['filter_item_id'])) {
            $url_params['filter_item_id'] = urlencode(html_entity_decode($this->request->get['filter_item_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url_params['filter_name'] = urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_category'])) {
            $url_params['filter_category'] = urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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

        $data['entry_item_id'] = $this->language->get('entry_item_id');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_link'] = $this->language->get('entry_link');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_parent'] = $this->language->get('entry_parent');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_icon'] = $this->language->get('entry_icon');
        $data['entry_status'] = $this->language->get('entry_status');

        // Action
        $data['create'] = $this->model_module_d_admin_menu->ajax($this->route.'/create', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if(VERSION >= '2.3.0.0'){
            $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
        }else{
            $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        }

        // Custom stuff
        $data['column_menu_item_id'] = $this->language->get('column_menu_item_id');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_link'] = $this->language->get('column_link');
        $data['column_category'] = $this->language->get('column_category');
        $data['column_parent'] = $this->language->get('column_parent');
        $data['column_position'] = $this->language->get('column_position');
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

        $filter_item_id = (isset($this->request->get['filter_item_id'])) ? $this->request->get['filter_item_id'] : null;
        $filter_name = (isset($this->request->get['filter_name'])) ? $this->request->get['filter_name'] : null;
        $filter_category = (isset($this->request->get['filter_category'])) ? $this->request->get['filter_category'] : null;
        $filter_parent = (isset($this->request->get['filter_parent'])) ? $this->request->get['filter_parent'] : null;
        $filter_status = (isset($this->request->get['filter_status'])) ? $this->request->get['filter_status'] : null;

        $sort = (isset($this->request->get['sort'])) ? $this->request->get['sort'] : 'code';
        $order = (isset($this->request->get['order'])) ? $this->request->get['order'] : 'ASC';
        $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;

        $data['menu_items'] = array();

        $filter_data = array(
            'filter_item_id'            => $filter_item_id,
            'filter_name'               => $filter_name,
            'filter_category'           => $filter_category,
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

            $delete = $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] . $url, 'SSL');

            $data['menu_items'][] = array(
                'menu_item_id'   => $result['menu_item_id'],
                'name'           => $result['name'],
                'category'       => $result['category'],
                'link'           => $result['link'],
                'parent'         => $result['parent'],
                'position'       => $result['position'],
                'icon'           => $result['icon'],
                'status'         => (isset($result['status'])) ? $result['status'] : 1,
                'delete'         => $delete,
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
        $data['sort_menu_item_id'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=sort_menu_item_id' . $url, 'SSL');
        $data['sort_name'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_category'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=category' . $url, 'SSL');
        $data['sort_parent'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=parent' . $url, 'SSL');
        $data['sort_position'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=position' . $url, 'SSL');
        $data['sort_icon'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&sort=icon' . $url, 'SSL');
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

        $data['filter_item_id'] = $filter_item_id;
        $data['filter_name'] = $filter_name;
        $data['filter_category'] = $filter_category;
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
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'), // why?
            'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        // Categories

        $data['categories'] = array();

        $cat_files = glob(DIR_APPLICATION . 'controller/extension/extension/*.php', GLOB_BRACE);

        foreach ($cat_files as $c_file) {
            $extension = basename($c_file, '.php');

            $this->load->language('extension/extension/' . $extension);

            if ($this->user->hasPermission('access', 'extension/extension/' . $extension)) {
                $cat_files = glob(DIR_APPLICATION . 'controller/{extension/' . $extension . ',' . $extension . '}/*.php', GLOB_BRACE);

                $data['categories'][] = array(
                    'code' => $extension,
                    'text' => $this->language->get('heading_title'),
                    'extra'=> $this->getExtensionList($extension)
                );
            }
        }

        $data['sortable_menu_items'] = $this->getSortableMenuItems();
        $data['gen_menu_data'] = $this->generate_custom_menu();


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
        // $this->load->config('d_admin_menu');

        $data['config'] = $this->generate_custom_menu();
        // $data['config'] = $this->config->get('d_admin_menu');

        $data['token'] = $this->session->data['token'];
        return $this->load->view('module/d_admin_menu', $data);
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
    }

    public function getExtensionList($category_shortname)
    {
        $this->load->model('extension/extension');
        $extensions = $this->model_extension_extension->getInstalled($category_shortname);

        $extra_data = array();

        // Compatibility code for old extension folders
        $files = glob(DIR_APPLICATION . 'controller/{extension/' . $category_shortname . ',' . $category_shortname . '}/*.php', GLOB_BRACE);

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');

                $this->load->language('extension/' . $category_shortname . '/' . $extension);

                $extra_data[] = array(
                    'name'          => $this->language->get('heading_title'),
                    'shortname'     => $extension,
                    'installed'     => in_array($extension, $extensions),
                    'edit'          => 'extension.'. $category_shortname .'.' . $extension
                );
            }
        }

        $sort_order = array();

        foreach ($extra_data as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $extra_data);

        return $extra_data;
    }

    public function edit()
    {
        $menu_item_id = false;
        $result = array();

        $this->load->model('module/d_admin_menu');

        if(isset($this->request->get['menu_item_id'])){
            $menu_item_id = $this->request->get['menu_item_id'];
            $result = $this->model_module_d_admin_menu->getMenuItemById($menu_item_id);
        }

        if($result){
            $delete = $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] , 'SSL');

            $json = array(
                'menu_item_id'  => $result['menu_item_id'],
                'name'          => $result['name'],
                'category'      => $result['category'],
                'parent'        => $result['parent'],
                'position'      => $result['position'],
                'link'          => $this->url->link($result['link'], 'token=' . $this->session->data['token'], 'SSL'),
                'icon'          => $result['icon'],
                'status'        => $result['status'],
                'delete'        => $delete,
                'edit'          => $this->url->link($this->route.'/edit', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] , 'SSL'),
                'save'          => $this->url->link($this->route.'/save', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] , 'SSL')
            );
        }else{
            $json = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function create()
    {
        $menu_item_id = false;
        $menu_item = array();

        $this->load->model('module/d_admin_menu');

        if (isset($this->request->post['item_extra'])) {

            $extra_item_stuff = explode(".", $this->request->post['item_extra']);
            $edit_path = $extra_item_stuff[0] .'/' . $extra_item_stuff[1] . '/' . $extra_item_stuff[2];

            $this->load->language($edit_path);
            $menu_item['name'] = $this->language->get('heading_title');

            $this->load->language('extension/extension/' . $extra_item_stuff[1]);
            $menu_item['category'] = $this->language->get('heading_title');

            if (isset($this->request->post['item_parent'])) {
                $menu_item['parent'] = $this->request->post['item_parent'];
            } else { $menu_item['parent'] = 0; }

            if (isset($this->request->post['item_position'])) {
                $menu_item['position'] = $this->request->post['item_position'];
            } else { $menu_item['position'] = 0; }

            $menu_item['link'] = $edit_path;

            if (isset($this->request->post['item_icon'])) {
                if ($menu_item['parent'] > 0) {
                    $menu_item['icon'] = '>>';
                } else {
                    $menu_item['icon'] = $this->request->post['item_icon'];
                }
            } else { $menu_item['icon'] = ""; }

            $menu_item['status'] = 1;
            $menu_item['menu_item_id'] = $this->model_module_d_admin_menu->addMenuItem($menu_item['name'], $menu_item['category'], $menu_item['parent'], $menu_item['position'], $menu_item['link'], $menu_item['icon'], $menu_item['status']);
        }

        if($menu_item){
            $delete = $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL');

            $json = array(
                'menu_item_id'  => $menu_item['menu_item_id'],
                'name'          => $menu_item['name'],
                'category'      => $menu_item['category'],
                'parent'        => $menu_item['parent'],
                'position'      => $menu_item['position'],
                'link'          => $this->url->link($edit_path, 'token=' . $this->session->data['token'], 'SSL'),
                'icon'          => $menu_item['icon'],
                'status'        => $menu_item['status'],
                'delete'        => $delete,
                'edit'          => $this->url->link($this->route.'/edit', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL'),
                'save'          => $this->url->link($this->route.'/save', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL')
            );

            $json['saved'] = true;
        } else {
            $json['saved'] = false;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function save()
    {
        $menu_item_id = false;
        $menu_item = array();

        $this->load->model('module/d_admin_menu');

        if (isset($this->request->get['menu_item_id'])
        && isset($this->request->post['item_extra'])) {

            $extra_item_stuff = explode(".", $this->request->post['item_extra']);
            $edit_path = $extra_item_stuff[0] .'/' . $extra_item_stuff[1] . '/' . $extra_item_stuff[2];

            $this->load->language($edit_path);
            $menu_item['name'] = $this->language->get('heading_title');

            $this->load->language('extension/extension/' . $extra_item_stuff[1]);
            $menu_item['category'] = $this->language->get('heading_title');

            $menu_item_id = $this->request->get['menu_item_id'];
            $menu_item = $this->model_module_d_admin_menu->getMenuItemById($menu_item_id);

            if (isset($this->request->post['item_parent'])) {
                $menu_item['parent'] = $this->request->post['item_parent'];
            }

            if (isset($this->request->post['item_position'])) {
                $menu_item['position'] = $this->request->post['item_position'];
            }

            if (isset($this->request->post['item_icon'])) {
                if ($menu_item['parent'] > 0) {
                    $menu_item['icon'] = '>>';
                } else {
                    $menu_item['icon'] = $this->request->post['item_icon'];
                }
            }
        }

        if($menu_item){

            $menu_item = $this->model_module_d_admin_menu->updateMenuItem($menu_item_id, $menu_item);

            if ($menu_item) {
                $delete = $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL');

                $json = array(
                    'menu_item_id'  => $menu_item['menu_item_id'],
                    'name'          => $menu_item['name'],
                    'category'      => $menu_item['category'],
                    'parent'        => $menu_item['parent'],
                    'position'      => $menu_item['position'],
                    'link'          => $this->url->link($edit_path, 'token=' . $this->session->data['token'], 'SSL'),
                    'icon'          => $menu_item['icon'],
                    'status'        => $menu_item['status'],
                    'delete'        => $delete,
                    'edit'          => $this->url->link($this->route.'/edit', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL'),
                    'save'          => $this->url->link($this->route.'/save', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $menu_item['menu_item_id'] , 'SSL')
                );

                $json['saved'] = true;
            }else{
                $json['saved'] = false;
            }
        } else {
            $json['saved'] = false;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function delete()
    {
        $json = array();

        $this->load->model('module/d_admin_menu');

        $get_del_id = array();

        if (isset($this->request->post['menu_item_id'])) {
            $get_del_id = $this->request->post['menu_item_id'];
        } elseif (isset($this->request->get['menu_item_id'])) {
            $get_del_id[] = $this->request->get['menu_item_id'];
        }

        if($get_del_id){
            foreach($get_del_id as $menu_item_id){
                $this->model_module_d_admin_menu->deleteMenuItemById($menu_item_id);
            }
            $json['deleted'] = true;
        }else{
            $json['deleted'] = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
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

    public function some_sort(&$some_array)
    {
        usort($some_array, function ($a, $b)
        {
            if ($a['sort_order'] == $b['sort_order']) {
                return 0;
            }
            return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
        });
    }

    public function getSortableMenuItems()
    {
        $this->load->model('module/d_admin_menu');
        $custom_results = $this->model_module_d_admin_menu->getMenuItems();

        // first level
        $custom_menu_data = array();
        foreach ($custom_results as $result) {

            //second level
            $second_step_data = array();
            foreach ($custom_results as $second_result) {
                if ($result['menu_item_id'] == $second_result['parent']) {

                    //third level
                    $third_step_data = array();
                    foreach ($custom_results as $third_result) {
                        if ($second_result['menu_item_id'] == $third_result['parent']) {

                            $third_step_data[] = array(
                                'menu_item_id'=> $third_result['menu_item_id'],
                                'name'        => $third_result['name'],
                                'parent'      => $third_result['parent'],
                                'position'    => $third_result['position'],
                                'link'        => $third_result['link'],
                                'icon'        => $third_result['icon'],
                                'delete'      => $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $third_result['menu_item_id'] , 'SSL'),
                                'children'    => array(),
                                'sort_order'  => (int)$third_result['position']
                            );
                        }
                    }

                    $this->some_sort($third_step_data);
                    $second_step_data[] = array(
                        'menu_item_id'=> $second_result['menu_item_id'],
                        'name'        => $second_result['name'],
                        'parent'      => $second_result['parent'],
                        'position'    => $second_result['position'],
                        'link'        => $second_result['link'],
                        'icon'        => $second_result['icon'],
                        'delete'      => $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $second_result['menu_item_id'] , 'SSL'),
                        'children'    => $third_step_data,
                        'sort_order'  => (int)$second_result['position']
                    );
                }
            }


            if ($result['parent'] == 0) {

                $this->some_sort($second_step_data);
                $custom_menu_data[] = array(
                    'menu_item_id'=> $result['menu_item_id'],
                    'name'        => $result['name'],
                    'parent'      => $result['parent'],
                    'position'    => $result['position'],
                    'link'        => $result['link'],
                    'icon'        => $result['icon'],
                    'delete'      => $this->model_module_d_admin_menu->ajax($this->route.'/delete', 'token=' . $this->session->data['token'] . '&menu_item_id=' . $result['menu_item_id'] , 'SSL'),
                    'children'    => $second_step_data,
                    'sort_order'  => (int)$result['position']
                );
            }
        }

        $this->some_sort($custom_menu_data);

        return $custom_menu_data;
    }

    public function generate_custom_menu()
    {
        // $current_menu_data = $this->generate_curent_menu();
        $this->load->config('d_admin_menu');
        $current_menu_data = $this->config->get('d_admin_menu');

        $this->load->model('module/d_admin_menu');
        $custom_results = $this->model_module_d_admin_menu->getMenuItems();


        // first level
        $custom_menu_data = array();
        foreach ($custom_results as $result) {

            //second level
            $second_step_data = array();
            foreach ($custom_results as $second_result) {
                if ($result['menu_item_id'] == $second_result['parent']) {

                    //third level
                    $third_step_data = array();
                    foreach ($custom_results as $third_result) {
                        if ($second_result['menu_item_id'] == $third_result['parent']) {

                            $third_step_data[] = array(
                                'name'        => $third_result['name'],
                                'href'        => $this->url->link($third_result['link'], 'token=' ),
                                'children'    => array(),
                                'sort_order'  => (int)$third_result['position']
                            );
                        }
                    }

                    $this->some_sort($third_step_data);
                    $second_step_data[] = array(
                        'name'        => $second_result['name'],
                        'href'        => (!$third_step_data) ? $this->url->link($second_result['link'], 'token=' ) : '',
                        'children'    => $third_step_data,
                        'sort_order'  => (int)$second_result['position']
                    );
                }
            }


            if ($result['parent'] == 0) {

                $this->some_sort($second_step_data);
                $custom_menu_data[] = array(
                    'id'          => 'menu-' . $result['menu_item_id'],
                    'icon'        => 'fa-' . $result['icon'],
                    'name'        => $result['name'],
                    'href'        => (!$second_step_data) ? $this->url->link($result['link'], 'token=' ) : '',
                    'children'    => $second_step_data,
                    'sort_order'  => (int)$result['position']
                );
            }
        }

        $this->some_sort($custom_menu_data);

        foreach ($custom_menu_data as $custom_md) {
            $current_menu_data['menus'][] = $custom_md;
        }

        return $current_menu_data;
    }



}
