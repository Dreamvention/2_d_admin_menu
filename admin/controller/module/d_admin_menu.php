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
        $this->d_shopunity = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_shopunity.json'));

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
        $data['config_file'] = $this->getAppropriateLanguage();

        // save post

        // styles and scripts
        if(!file_exists('view/stylesheet/shopunity/')){
          $this->error['shopunity'] = $this->language->get('shopunity_download');
        }
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
        $this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

        // $this->document->addScript('view/javascript/shopunity/bootstrap-sortable.js');
        // $this->document->addScript('view/javascript/shopunity/tinysort/jquery.tinysort.min.js');
        // $this->document->addScript('view/javascript/shopunity/serializeObject/serializeObject.js');

        $this->document->addScript('view/javascript/d_admin_menu/library/jquery.nestable.nodrag.js');
        $this->document->addScript('view/javascript/d_admin_menu/library/jquery.nestable.js');

        $this->document->addScript('view/javascript/d_admin_menu/library/alertify.min.js');
        $this->document->addStyle('view/stylesheet/d_admin_menu/library/alertify/alertify.min.css');
        $this->document->addStyle('view/stylesheet/d_admin_menu/library/alertify/bootstrap-theme.cstm.min.css');

        $this->document->addScript('view/javascript/d_admin_menu/library/fontawesome-iconpicker.js');
        $this->document->addStyle('view/stylesheet/d_admin_menu/library/fontawesome-iconpicker.min.css');

        $this->document->addScript('https://use.fontawesome.com/0b3dfb29a7.js');

        $this->document->addStyle('view/stylesheet/d_admin_menu/d_admin_menu_editor.css');

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

        if (isset($this->request->get['config'])) {
            $url .= '&config=' . $this->request->get['config'];
        }

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
        $data['text_menu'] = $this->language->get('text_menu');
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
        $data['button_support_email'] = $this->language->get('button_support_email');

        // Entry
        $data['entry_support'] = $this->language->get('entry_support');
        $data['entry_status'] = $this->language->get('entry_status');


        // Text
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_enable'] = $this->language->get('text_enable');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');

        $data['text_intro_create_setting'] = $this->language->get('text_intro_create_setting');

        // save_and_stay
        $data['save_and_stay'] = $this->model_module_d_admin_menu->ajax($this->route.'/save_and_stay', 'token=' . $this->session->data['token'] . $url, 'SSL');

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

        // create setting if not exist
        $data['setting_id'] = $this->model_module_d_admin_menu->getLastSettingId();
        if ($data['setting_id'] === false) {
            $this->createSetting();
            $data['setting_id'] = $this->model_module_d_admin_menu->getLastSettingId();
        }
        $data['setting'] = $this->model_module_d_admin_menu->getSetting($data['setting_id']);


        $data[$this->codename . '_status'] = $data['setting']['status'];

        $data['standart_menu'] = $this->load->view('module/d_admin_menu_standart_section.tpl', array("standart_menu_data" => $data['setting']['main_menu']['menu_data']));


        $data['custom_menu'] = $this->load->view('module/d_admin_menu_custom_section.tpl', array("custom_menu_data"   => $data['setting']['custom_menu'],
                                                                                                 "modules_for_links"  => $this->getModulesForLinks(),
                                                                                                 "text_phd_item_name" => $this->language->get('text_placeholder_item_name')));


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/d_admin_menu_editor.tpl', $data));
    }



    /////////////////////////////////////////////////////////////////////////////////////
    /////////                             ASSISTING                             /////////
    /////////////////////////////////////////////////////////////////////////////////////

    private function some_sort(&$some_array)
    {
        usort($some_array, function ($a, $b)
        {
            if ($a['sort_order'] == $b['sort_order']) {
                return 0;
            }
            return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
        });
    }

    public function getAppropriateConfig()
    {
        if ((VERSION >= '2.3.0.0')  && (VERSION < '3.0.0.0')) {
            $this->load->config('d_admin_menu/d_admin_menu_230');
        }
        return $this->config->get('d_admin_menu');
    }

    public function getAppropriateMenuName($menu_item_lng_name)
    {
        if ((VERSION >= '2.3.0.0')  && (VERSION < '3.0.0.0')) {
            $lng = new Language();
            $lng->load('common/column_left');

            if ($lng->get($menu_item_lng_name)) {
                return $lng->get($menu_item_lng_name);
            } else {
                return false;
            }
        }
    }

    public function getAppropriateLanguage()
    {
        $standart_menu = $this->getAppropriateConfig();

        // first level
        foreach ($standart_menu as $sm_key => $sm_value) {

            if (array_key_exists('lng_name', $sm_value)) {
                if ($this->getAppropriateMenuName($sm_value['lng_name']) !== false) {
                    $standart_menu[$sm_key]['name'] = $this->getAppropriateMenuName($sm_value['lng_name']);
                }
            }

            if ($sm_value['children']) {

                // second level
                foreach ($sm_value['children'] as $sm_key_2 => $sm_value_2) {

                    if (array_key_exists('lng_name', $sm_value_2)) {
                        if ($this->getAppropriateMenuName($sm_value_2['lng_name']) !== false) {
                            $standart_menu[$sm_key]['children'][$sm_key_2]['name'] = $this->getAppropriateMenuName($sm_value_2['lng_name']);
                        }
                    }

                    if ($sm_value_2['children']) {

                        // third level
                        foreach ($sm_value_2['children'] as $sm_key_3 => $sm_value_3) {

                            if (array_key_exists('lng_name', $sm_value_3)) {
                                if ($this->getAppropriateMenuName($sm_value_3['lng_name']) !== false) {
                                    $standart_menu[$sm_key]['children'][$sm_key_2]['children'][$sm_key_3]['name'] = $this->getAppropriateMenuName($sm_value_3['lng_name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $standart_menu;
    }



    private function createSetting()
    {
        $json = array();

        $setting_name = "default-setting";
        $new_setting = array(
            "name"          => $setting_name,
            "status"        => 1,
            "main_menu"     => array(
                "version"           => VERSION,
                "menu_data"         => $this->getAppropriateLanguage()
            ),
            "custom_menu"   => array(
                "0"                 => array(
                    "id"                    => 1,
                    "icon"                  => "fa-flask",
                    "name"                  => "Shopunity",
                    "href"                  => "index.php?route=extension/module/d_shopunity&token=",
                    "children"              => array(),
                    "sort_order"            => 0
                )
            )
        );

        $setting_id = $this->model_module_d_admin_menu->setSetting($setting_name, $new_setting, $this->store_id);

        $this->load->language($this->route);
        if ($setting_id) {
            $this->session->data['success'] = $this->language->get('success_setting_created');
        } else {
            $json['error'] = $this->language->get('error_setting_not_created');
        }

        $this->response->setOutput(json_encode($json));
    }

    private function getModulesForLinks()
    {
        $tmp_mdls_data = array();
        $cat_files = glob(DIR_APPLICATION . 'controller/extension/extension/*.php', GLOB_BRACE);

        foreach ($cat_files as $c_file) {
            $extension = basename($c_file, '.php');

            $this->load->language('extension/extension/' . $extension);

            if ($this->user->hasPermission('access', 'extension/extension/' . $extension)) {
                $cat_files = glob(DIR_APPLICATION . 'controller/{extension/' . $extension . ',' . $extension . '}/*.php', GLOB_BRACE);

                $tmp_mdls_data[] = array(
                    'code' => $extension,
                    'text' => $this->language->get('heading_title'),
                    'extra'=> $this->getExtensionList($extension)
                );
            }
        }

        return $tmp_mdls_data;
    }

    private function getExtensionList($category_shortname)
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
                    'edit'          => 'extension/'. $category_shortname .'/' . $extension
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





    /////////////////////////////////////////////////////////////////////////////////////
    /////////                              ACTIONS                              /////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function save_and_stay()
    {

        $current_setting = $this->model_module_d_admin_menu->getSetting($this->model_module_d_admin_menu->getLastSettingId());

        if (isset($this->request->post['menus-data'])) {

            $menus_data = $this->request->post['menus-data'];
            $custom_nested_data = $this->request->post['custom-nested-data'];

            // STANDART MENU
            foreach ($current_setting['main_menu']['menu_data'] as $mm_key => $mm_value) {

                // first level
                if (array_key_exists('is_visible', $mm_value)) {
                    foreach ($menus_data as $md_value) {
                        if (('standart-menu[' . $mm_value['id'] . '][visibility]') == trim($md_value['name'])) {
                            $current_setting['main_menu']['menu_data'][$mm_key]['is_visible'] = 1;
                            break;
                        } else {
                            $current_setting['main_menu']['menu_data'][$mm_key]['is_visible'] = 0;
                        }
                    }
                }

                // second level
                if ($mm_value['children']) {

                    foreach ($mm_value['children'] as $mm_key_2 => $mm_value_2) {
                        if (array_key_exists('is_visible', $mm_value_2)) {
                            foreach ($menus_data as $md_value) {
                                if ('standart-menu[' . $mm_value_2['id'] . '][visibility]' == $md_value['name']) {
                                    $current_setting['main_menu']['menu_data'][$mm_key]['children'][$mm_key_2]['is_visible'] = 1;
                                    break;
                                } else {
                                    $current_setting['main_menu']['menu_data'][$mm_key]['children'][$mm_key_2]['is_visible'] = 0;
                                }
                            }
                        }


                        //third level
                        if ($mm_value_2['children']) {

                            foreach ($mm_value_2['children'] as $mm_key_3 => $mm_value_3) {
                                if (array_key_exists('is_visible', $mm_value_3)) {
                                    foreach ($menus_data as $md_value) {
                                        if ('standart-menu[' . $mm_value_3['id'] . '][visibility]' == $md_value['name']) {
                                            $current_setting['main_menu']['menu_data'][$mm_key]['children'][$mm_key_2]['children'][$mm_key_3]['is_visible'] = 1;
                                            break;
                                        } else {
                                            $current_setting['main_menu']['menu_data'][$mm_key]['children'][$mm_key_2]['children'][$mm_key_3]['is_visible'] = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // CUSTOM MENU
            $new_custom_menu = array();

            // first level
            foreach ($custom_nested_data as $cnd_value) {

                $cnd_first_children = array();
                if (array_key_exists('children', $cnd_value)) {

                    // second level
                    foreach ($cnd_value['children'] as $cnd_value_2) {

                        // third level
                        $cnd_second_children = array();
                        if (array_key_exists('children', $cnd_value_2)) {

                            foreach ($cnd_value_2['children'] as $cnd_key_3 => $cnd_value_3) {

                                foreach ($menus_data as $md_value) {
                                    if ('custom-menu[' . $cnd_value_3['id'] . '][icon]' == $md_value['name']) {
                                        $fc_icon = $md_value['value'];
                                    }
                                    if ('custom-menu[' . $cnd_value_3['id'] . '][name]' == $md_value['name']) {
                                        $fc_name = $md_value['value'];
                                    }
                                    if ('custom-menu[' . $cnd_value_3['id'] . '][item_link]' == $md_value['name']) {
                                        $fc_link = $md_value['value'];
                                    }
                                }

                                $cnd_second_children[] = array(
                                    "id"           => $cnd_value_3['id'],
                                    "icon"         => $fc_icon,
                                    "name"         => $fc_name,
                                    "href"         => ('index.php?route=' .$fc_link. '&token='),
                                    "children"     => array(),
                                    "sort_order"   => 0
                                );
                                unset($fc_icon, $fc_name, $fc_link);
                            }
                        }

                        foreach ($menus_data as $md_value) {
                            if ('custom-menu[' . $cnd_value_2['id'] . '][icon]' == $md_value['name']) {
                                $fc_icon = $md_value['value'];
                            }
                            if ('custom-menu[' . $cnd_value_2['id'] . '][name]' == $md_value['name']) {
                                $fc_name = $md_value['value'];
                            }
                            if ('custom-menu[' . $cnd_value_2['id'] . '][item_link]' == $md_value['name']) {
                                $fc_link = $md_value['value'];
                            }
                        }

                        $cnd_first_children[] = array(
                            "id"           => $cnd_value_2['id'],
                            "icon"         => $fc_icon,
                            "name"         => $fc_name,
                            "href"         => ('index.php?route=' .$fc_link. '&token='),
                            "children"     => $cnd_second_children,
                            "sort_order"   => 0
                        );
                        unset($fc_icon, $fc_name, $fc_link);
                    }
                }

                foreach ($menus_data as $md_value) {
                    if ('custom-menu[' . $cnd_value['id'] . '][icon]' == $md_value['name']) {
                        $fc_icon = $md_value['value'];
                    }
                    if ('custom-menu[' . $cnd_value['id'] . '][name]' == $md_value['name']) {
                        $fc_name = $md_value['value'];
                    }
                    if ('custom-menu[' . $cnd_value['id'] . '][item_link]' == $md_value['name']) {
                        $fc_link = $md_value['value'];
                    }
                }

                $new_custom_menu[] = array(
                    "id"           => $cnd_value['id'],
                    "icon"         => $fc_icon,
                    "name"         => $fc_name,
                    "href"         => ('index.php?route=' .$fc_link. '&token='),
                    "children"     => $cnd_first_children,
                    "sort_order"   => 0
                );
                unset($fc_icon, $fc_name, $fc_link);

            }

            $current_setting['custom_menu'] = $new_custom_menu;

            // SET STATUS
            foreach ($menus_data as $md_value) {
                if (($this->codename . '_status') == trim($md_value['name'])) {
                    $current_setting['status'] = 1;
                    break;
                } else {
                    $current_setting['status'] = 0;
                }
            }

            // SAVE SETTING
            $setting_id = $this->model_module_d_admin_menu->editSetting($this->model_module_d_admin_menu->getLastSettingId(), $current_setting);

        } else {

            // feelsbadman
        }

        // ON-OFF MODULE
        $this->uninstallEvents();
        if ($current_setting['status'] == 1) {
            $this->installEvents();
        }
    }





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

        return true;
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
        $this->load->model('module/d_admin_menu');
        $this->model_module_d_admin_menu->uninstallDatabase();

        $this->uninstallEvents();
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
        // create setting if not exist
        $data['setting_id'] = $this->model_module_d_admin_menu->getLastSettingId();
        if ($data['setting_id'] === false) {
            $this->createSetting();
            $data['setting_id'] = $this->model_module_d_admin_menu->getLastSettingId();
        }
        $display_menu_setting = $this->model_module_d_admin_menu->getSetting($data['setting_id']);

        $standart_menu = $display_menu_setting['main_menu']['menu_data'];
        $custom_menu = $display_menu_setting['custom_menu'];

        foreach ($custom_menu as $custom_md) {
            $standart_menu[] = $custom_md;
        }

        $data['config']['menus'] = $standart_menu;

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
