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

        $this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.6.0/Sortable.min.js');
        $this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/tinysort/1.5.6/jquery.tinysort.min.js');

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


        //////////////////////////////////////////////////////////////////////
        //////                       CATEGORIES                         //////
        //////////////////////////////////////////////////////////////////////

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
        // $data['gen_menu_data'] = $this->generate_custom_menu();


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

        $data['config'] = $this->generate_custom_menu();


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
        $current_menu_data = $this->generate_curent_menu();

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

    public function generate_curent_menu()
    {
        $this->load->language('common/column_left');

        $gen_menu_data = array();

        // Create a 3 level menu array
        // Menu
        $gen_menu_data['menus'][] = array(
            'id'       => 'menu-dashboard',
            'icon'     => 'fa-dashboard',
            'name'     => $this->language->get('text_dashboard'),
            'href'     => $this->url->link('common/dashboard', 'token=' ),
            'children' => array()
        );

        // Catalog
        $catalog = array();

        if ($this->user->hasPermission('access', 'catalog/category')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_category'),
                'href'     => $this->url->link('catalog/category', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/product')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_product'),
                'href'     => $this->url->link('catalog/product', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/recurring')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_recurring'),
                'href'     => $this->url->link('catalog/recurring', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/filter')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_filter'),
                'href'     => $this->url->link('catalog/filter', 'token=' ),
                'children' => array()
            );
        }

        // Attributes
        $attribute = array();

        if ($this->user->hasPermission('access', 'catalog/attribute')) {
            $attribute[] = array(
                'name'     => $this->language->get('text_attribute'),
                'href'     => $this->url->link('catalog/attribute', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/attribute_group')) {
            $attribute[] = array(
                'name'     => $this->language->get('text_attribute_group'),
                'href'     => $this->url->link('catalog/attribute_group', 'token=' ),
                'children' => array()
            );
        }

        if ($attribute) {
            $catalog[] = array(
                'name'     => $this->language->get('text_attribute'),
                'href'     => '',
                'children' => $attribute
            );
        }

        if ($this->user->hasPermission('access', 'catalog/option')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_option'),
                'href'     => $this->url->link('catalog/option', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_manufacturer'),
                'href'     => $this->url->link('catalog/manufacturer', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/download')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_download'),
                'href'     => $this->url->link('catalog/download', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/review')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_review'),
                'href'     => $this->url->link('catalog/review', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'catalog/information')) {
            $catalog[] = array(
                'name'     => $this->language->get('text_information'),
                'href'     => $this->url->link('catalog/information', 'token=' ),
                'children' => array()
            );
        }

        if ($catalog) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-catalog',
                'icon'     => 'fa-tags',
                'name'     => $this->language->get('text_catalog'),
                'href'     => '',
                'children' => $catalog
            );
        }


        // Extension
        $extension = array();

        if ($this->user->hasPermission('access', 'extension/installer')) {
            $extension[] = array(
                'name'     => $this->language->get('text_installer'),
                'href'     => $this->url->link('extension/installer', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'extension/extension')) {
            $extension[] = array(
                'name'     => $this->language->get('text_extension'),
                'href'     => $this->url->link('extension/extension', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'extension/modification')) {
            $extension[] = array(
                'name'     => $this->language->get('text_modification'),
                'href'     => $this->url->link('extension/modification', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'extension/event')) {
            $extension[] = array(
                'name'     => $this->language->get('text_event'),
                'href'     => $this->url->link('extension/event', 'token=' ),
                'children' => array()
            );
        }

        if ($extension) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-extension',
                'icon'     => 'fa-puzzle-piece',
                'name'     => $this->language->get('text_extension'),
                'href'     => '',
                'children' => $extension
            );
        }

        // Design
        $design = array();

        if ($this->user->hasPermission('access', 'design/layout')) {
            $design[] = array(
                'name'     => $this->language->get('text_layout'),
                'href'     => $this->url->link('design/layout', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'design/banner')) {
            $design[] = array(
                'name'     => $this->language->get('text_banner'),
                'href'     => $this->url->link('design/banner', 'token=' ),
                'children' => array()
            );
        }

        if ($design) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-design',
                'icon'     => 'fa-television',
                'name'     => $this->language->get('text_design'),
                'href'     => '',
                'children' => $design
            );
        }

        // Sales
        $sale = array();

        if ($this->user->hasPermission('access', 'sale/order')) {
            $sale[] = array(
                'name'     => $this->language->get('text_order'),
                'href'     => $this->url->link('sale/order', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'sale/recurring')) {
            $sale[] = array(
                'name'     => $this->language->get('text_recurring'),
                'href'     => $this->url->link('sale/recurring', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'sale/return')) {
            $sale[] = array(
                'name'     => $this->language->get('text_return'),
                'href'     => $this->url->link('sale/return', 'token=' ),
                'children' => array()
            );
        }

        // Voucher
        $voucher = array();

        if ($this->user->hasPermission('access', 'sale/voucher')) {
            $voucher[] = array(
                'name'     => $this->language->get('text_voucher'),
                'href'     => $this->url->link('sale/voucher', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'sale/voucher_theme')) {
            $voucher[] = array(
                'name'     => $this->language->get('text_voucher_theme'),
                'href'     => $this->url->link('sale/voucher_theme', 'token=' ),
                'children' => array()
            );
        }

        if ($voucher) {
            $sale[] = array(
                'name'     => $this->language->get('text_voucher'),
                'href'     => '',
                'children' => $voucher
            );
        }

        if ($sale) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-sale',
                'icon'     => 'fa-shopping-cart',
                'name'     => $this->language->get('text_sale'),
                'href'     => '',
                'children' => $sale
            );
        }

        // Customer
        $customer = array();

        if ($this->user->hasPermission('access', 'customer/customer')) {
            $customer[] = array(
                'name'     => $this->language->get('text_customer'),
                'href'     => $this->url->link('customer/customer', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'customer/customer_group')) {
            $customer[] = array(
                'name'     => $this->language->get('text_customer_group'),
                'href'     => $this->url->link('customer/customer_group', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'customer/custom_field')) {
            $customer[] = array(
                'name'     => $this->language->get('text_custom_field'),
                'href'     => $this->url->link('customer/custom_field', 'token=' ),
                'children' => array()
            );
        }

        if ($customer) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-customer',
                'icon'     => 'fa-user',
                'name'     => $this->language->get('text_customer'),
                'href'     => '',
                'children' => $customer
            );
        }

        // Marketing
        $marketing = array();

        if ($this->user->hasPermission('access', 'marketing/marketing')) {
            $marketing[] = array(
                'name'     => $this->language->get('text_marketing'),
                'href'     => $this->url->link('marketing/marketing', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'marketing/affiliate')) {
            $marketing[] = array(
                'name'     => $this->language->get('text_affiliate'),
                'href'     => $this->url->link('marketing/affiliate', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'marketing/coupon')) {
            $marketing[] = array(
                'name'     => $this->language->get('text_coupon'),
                'href'     => $this->url->link('marketing/coupon', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'marketing/contact')) {
            $marketing[] = array(
                'name'     => $this->language->get('text_contact'),
                'href'     => $this->url->link('marketing/contact', 'token=' ),
                'children' => array()
            );
        }

        if ($marketing) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-marketing',
                'icon'     => 'fa-share-alt',
                'name'     => $this->language->get('text_marketing'),
                'href'     => '',
                'children' => $marketing
            );
        }

        // System
        $system = array();

        if ($this->user->hasPermission('access', 'setting/setting')) {
            $system[] = array(
                'name'     => $this->language->get('text_setting'),
                'href'     => $this->url->link('setting/store', 'token=' ),
                'children' => array()
            );
        }

        // Users
        $user = array();

        if ($this->user->hasPermission('access', 'user/user')) {
            $user[] = array(
                'name'     => $this->language->get('text_users'),
                'href'     => $this->url->link('user/user', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'user/user_permission')) {
            $user[] = array(
                'name'     => $this->language->get('text_user_group'),
                'href'     => $this->url->link('user/user_permission', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'user/api')) {
            $user[] = array(
                'name'     => $this->language->get('text_api'),
                'href'     => $this->url->link('user/api', 'token=' ),
                'children' => array()
            );
        }

        if ($user) {
            $system[] = array(
                'name'     => $this->language->get('text_users'),
                'href'     => '',
                'children' => $user
            );
        }

        // Localisation
        $localisation = array();

        if ($this->user->hasPermission('access', 'localisation/location')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_location'),
                'href'     => $this->url->link('localisation/location', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/language')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_language'),
                'href'     => $this->url->link('localisation/language', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/currency')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_currency'),
                'href'     => $this->url->link('localisation/currency', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/stock_status')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_stock_status'),
                'href'     => $this->url->link('localisation/stock_status', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/order_status')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_order_status'),
                'href'     => $this->url->link('localisation/order_status', 'token=' ),
                'children' => array()
            );
        }

        // Returns
        $return = array();

        if ($this->user->hasPermission('access', 'localisation/return_status')) {
            $return[] = array(
                'name'     => $this->language->get('text_return_status'),
                'href'     => $this->url->link('localisation/return_status', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/return_action')) {
            $return[] = array(
                'name'     => $this->language->get('text_return_action'),
                'href'     => $this->url->link('localisation/return_action', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/return_reason')) {
            $return[] = array(
                'name'     => $this->language->get('text_return_reason'),
                'href'     => $this->url->link('localisation/return_reason', 'token=' ),
                'children' => array()
            );
        }

        if ($return) {
            $localisation[] = array(
                'name'     => $this->language->get('text_return'),
                'href'     => '',
                'children' => $return
            );
        }

        if ($this->user->hasPermission('access', 'localisation/country')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_country'),
                'href'     => $this->url->link('localisation/country', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/zone')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_zone'),
                'href'     => $this->url->link('localisation/zone', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/geo_zone')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_geo_zone'),
                'href'     => $this->url->link('localisation/geo_zone', 'token=' ),
                'children' => array()
            );
        }

        // Tax
        $tax = array();

        if ($this->user->hasPermission('access', 'localisation/tax_class')) {
            $tax[] = array(
                'name'     => $this->language->get('text_tax_class'),
                'href'     => $this->url->link('localisation/tax_class', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/tax_rate')) {
            $tax[] = array(
                'name'     => $this->language->get('text_tax_rate'),
                'href'     => $this->url->link('localisation/tax_rate', 'token=' ),
                'children' => array()
            );
        }

        if ($tax) {
            $localisation[] = array(
                'name'     => $this->language->get('text_tax'),
                'href'     => '',
                'children' => $tax
            );
        }

        if ($this->user->hasPermission('access', 'localisation/length_class')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_length_class'),
                'href'     => $this->url->link('localisation/length_class', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'localisation/weight_class')) {
            $localisation[] = array(
                'name'     => $this->language->get('text_weight_class'),
                'href'     => $this->url->link('localisation/weight_class', 'token=' ),
                'children' => array()
            );
        }

        if ($localisation) {
            $system[] = array(
                'name'     => $this->language->get('text_localisation'),
                'href'     => '',
                'children' => $localisation
            );
        }

        // Tools
        $tool = array();

        if ($this->user->hasPermission('access', 'tool/upload')) {
            $tool[] = array(
                'name'     => $this->language->get('text_upload'),
                'href'     => $this->url->link('tool/upload', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'tool/backup')) {
            $tool[] = array(
                'name'     => $this->language->get('text_backup'),
                'href'     => $this->url->link('tool/backup', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'tool/log')) {
            $tool[] = array(
                'name'     => $this->language->get('text_log'),
                'href'     => $this->url->link('tool/log', 'token=' ),
                'children' => array()
            );
        }

        if ($tool) {
            $system[] = array(
                'name'     => $this->language->get('text_tools'),
                'href'     => '',
                'children' => $tool
            );
        }

        if ($system) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-system',
                'icon'     => 'fa-cog',
                'name'     => $this->language->get('text_system'),
                'href'     => '',
                'children' => $system
            );
        }

        // Report
        $report = array();

        // Report Sales
        $report_sale = array();

        if ($this->user->hasPermission('access', 'report/sale_order')) {
            $report_sale[] = array(
                'name'     => $this->language->get('text_report_sale_order'),
                'href'     => $this->url->link('report/sale_order', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/sale_tax')) {
            $report_sale[] = array(
                'name'     => $this->language->get('text_report_sale_tax'),
                'href'     => $this->url->link('report/sale_tax', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/sale_shipping')) {
            $report_sale[] = array(
                'name'     => $this->language->get('text_report_sale_shipping'),
                'href'     => $this->url->link('report/sale_shipping', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/sale_return')) {
            $report_sale[] = array(
                'name'     => $this->language->get('text_report_sale_return'),
                'href'     => $this->url->link('report/sale_return', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/sale_coupon')) {
            $report_sale[] = array(
                'name'     => $this->language->get('text_report_sale_coupon'),
                'href'     => $this->url->link('report/sale_coupon', 'token=' ),
                'children' => array()
            );
        }

        if ($report_sale) {
            $report[] = array(
                'name'     => $this->language->get('text_report_sale'),
                'href'     => '',
                'children' => $report_sale
            );
        }

        // Report Products
        $report_product = array();

        if ($this->user->hasPermission('access', 'report/product_viewed')) {
            $report_product[] = array(
                'name'     => $this->language->get('text_report_product_viewed'),
                'href'     => $this->url->link('report/product_viewed', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/product_purchased')) {
            $report_product[] = array(
                'name'     => $this->language->get('text_report_product_purchased'),
                'href'     => $this->url->link('report/product_purchased', 'token=' ),
                'children' => array()
            );
        }

        if ($report_product) {
            $report[] = array(
                'name'     => $this->language->get('text_report_product'),
                'href'     => '',
                'children' => $report_product
            );
        }

        // Report Customers
        $report_customer = array();

        if ($this->user->hasPermission('access', 'report/customer_online')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_online'),
                'href'     => $this->url->link('report/customer_online', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/customer_activity')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_activity'),
                'href'     => $this->url->link('report/customer_activity', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/customer_search')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_search'),
                'href'     => $this->url->link('report/customer_search', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/customer_order')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_order'),
                'href'     => $this->url->link('report/customer_order', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/customer_reward')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_reward'),
                'href'     => $this->url->link('report/customer_reward', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/customer_credit')) {
            $report_customer[] = array(
                'name'     => $this->language->get('text_report_customer_credit'),
                'href'     => $this->url->link('report/customer_credit', 'token=' ),
                'children' => array()
            );
        }

        if ($report_customer) {
            $report[] = array(
                'name'     => $this->language->get('text_report_customer'),
                'href'     => '',
                'children' => $report_customer
            );
        }

        // Report Marketing
        $report_marketing = array();

        if ($this->user->hasPermission('access', 'report/marketing')) {
            $report_marketing[] = array(
                'name'     => $this->language->get('text_report_marketing'),
                'href'     => $this->url->link('report/marketing', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/affiliate')) {
            $report_marketing[] = array(
                'name'     => $this->language->get('text_report_affiliate'),
                'href'     => $this->url->link('report/affiliate', 'token=' ),
                'children' => array()
            );
        }

        if ($this->user->hasPermission('access', 'report/affiliate_activity')) {
            $report_marketing[] = array(
                'name'     => $this->language->get('text_report_affiliate_activity'),
                'href'     => $this->url->link('report/affiliate_activity', 'token=' ),
                'children' => array()
            );
        }

        if ($report_marketing) {
            $report[] = array(
                'name'     => $this->language->get('text_report_marketing'),
                'href'     => '',
                'children' => $report_marketing
            );
        }

        if ($report) {
            $gen_menu_data['menus'][] = array(
                'id'       => 'menu-report',
                'icon'     => 'fa-bar-chart-o',
                'name'     => $this->language->get('text_reports'),
                'href'     => '',
                'children' => $report
            );
        }

        return $gen_menu_data;
    }

}
