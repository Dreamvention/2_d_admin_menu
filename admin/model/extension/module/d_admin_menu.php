<?php

class ModelExtensionModuleDAdminMenu extends Model
{
    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->language($this->route);

        if(!defined('DIR_ROOT')){
            define('DIR_ROOT', substr_replace(DIR_SYSTEM, '/', -8));
        }
    }

    public function installDatabase()
    {
        // install oc_dam_setting ('dam' for 'Dreamvention Admin Menu')
        $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."dam_setting` (
        `setting_id` int(11) NOT NULL AUTO_INCREMENT,
        `store_id` int(11) NOT NULL,
        `name` varchar(32) NOT NULL,
        `value` text NOT NULL,
        PRIMARY KEY (`setting_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    public function uninstallDatabase()
    {
        $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."dam_setting`");
    }

    public function getCurrentSettingId($id, $store_id = 0)
    {
        $this->load->model('setting/setting');
        $setting = $this->model_setting_setting->getSetting($id, $store_id);

        if(isset($this->request->get['setting_id'])){
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
                WHERE store_id = '" . (int)$store_id . "'
                AND setting_id = '" . (int)$this->request->get['setting_id'] . "'" );
                if($query->row){
                    return $query->row['setting_id'];
                }
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
            WHERE store_id = '" . (int)$store_id . "'" );
        if($query->row){
            return $query->row['setting_id'];
        }

        return false;
    }

    public function getSettingName($setting_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
            WHERE setting_id = '" . (int)$setting_id . "'" );
        if(isset($query->row['name'])){
            return $query->row['name'];
        }else{
            return false;
        }
    }

    public function getSetting($setting_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
            WHERE setting_id = '" . (int)$setting_id . "'" );

        $result = $query->row;
        if(isset($result['value'])){
            $result['value'] = json_decode($result['value'], true);
        }

        return $result['value'];
    }

    public function getSettings($store_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
            WHERE store_id = '" . (int)$store_id . "'"  );

        $results = $query->rows;

        foreach ($results as $key => $result) {
            $results[$key]['value'] = json_decode($result['value'], true);
        }

        return $results;
    }

    public function getLastSettingId()
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dam_setting`
            ORDER BY setting_id DESC LIMIT 1");

        $result = $query->row;
        if(isset($result['setting_id'])){
            return (int)$result['setting_id'];
        } else {
            return false;
        }
    }

    public function setSetting($setting_name, $setting_value, $store_id = 0)
    {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "dam_setting`
            SET store_id = '" . (int)$store_id . "',
                `name` = '" . $this->db->escape($setting_name) . "',
                `value` = '" . $this->db->escape(json_encode($setting_value)) . "'");
        return $this->db->getLastId();
    }

    public function editSetting($setting_id, $data)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "dam_setting`
                SET `name` = '" . $this->db->escape($data['name']) . "',
                    `value` = '" . $this->db->escape(json_encode($data)) . "'
                WHERE setting_id = '" . (int)$setting_id . "'");
        return $setting_id;
    }

    public function deleteSetting($setting_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "dam_setting` WHERE setting_id = '" . (int)$setting_id . "'");
    }




    /////////////////////////////////////////////////////////////////////////////////////
    /////////                         HELPER FUNCTIONS                          /////////
    /////////////////////////////////////////////////////////////////////////////////////

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

    public function getAppropriateConfig()
    {
        if ((VERSION >= '2.0.0.0') && (VERSION < '2.0.3.1')) {

            $this->load->config('d_admin_menu/d_admin_menu_201');

        } elseif ((VERSION >= '2.0.3.1') && (VERSION < '2.1.0.0')) {

            $this->load->config('d_admin_menu/d_admin_menu_203');

        } elseif ((VERSION >= '2.1.0.0') && (VERSION < '2.3.0.0')) {

            $this->load->config('d_admin_menu/d_admin_menu_210');

        } elseif ((VERSION >= '2.3.0.0') && (VERSION < '3.0.0.0')) {

            $this->load->config('d_admin_menu/d_admin_menu_230');

        } elseif (VERSION >='3.0.0.0') {

            $this->load->config('d_admin_menu/d_admin_menu_302');
        }
        return $this->config->get('menu_data');
    }

    public function getLanguage($menu_item_lng_name)
    {
        $lang_path = $this->getAppropriateConfig()['lang_path'];

        $lng = new Language();
        $lng->load($lang_path);

        if ($lng->get($menu_item_lng_name) &&
            $lng->get($menu_item_lng_name) != $menu_item_lng_name) {
            return $lng->get($menu_item_lng_name);
        } else {
            return false;
        }
    }

    public function fillMenuWithIds()
    {
        $standart_menu = $this->getAppropriateConfig()['menu'];

        $temp_id = 1;

        foreach ($standart_menu as $sm_key => $sm_value) {
            $standart_menu[$sm_key]['id'] = $temp_id;
            $temp_id = $temp_id + 1;

            foreach ($sm_value['children'] as $sm_key_2 => $sm_value_2) {
                $standart_menu[$sm_key]['children'][$sm_key_2]['id'] = $temp_id;
                $temp_id = $temp_id + 1;

                foreach ($sm_value_2['children'] as $sm_key_3 => $sm_value_3) {
                    $standart_menu[$sm_key]['children'][$sm_key_2]['children'][$sm_key_3]['id'] = $temp_id;
                    $temp_id = $temp_id + 1;
                }
            }
        }

        return $standart_menu;
    }

    public function fillMenuWithLanguage($standart_menu)
    {
        // first level
        foreach ($standart_menu as $sm_key => $sm_value) {

            if (array_key_exists('lng_name', $sm_value)) {
                if ($this->getLanguage($sm_value['lng_name']) !== false) {
                    $standart_menu[$sm_key]['name'] = $this->getLanguage($sm_value['lng_name']);
                }
            }

            if ($sm_value['children']) {

                // second level
                foreach ($sm_value['children'] as $sm_key_2 => $sm_value_2) {

                    if (array_key_exists('lng_name', $sm_value_2)) {
                        if ($this->getLanguage($sm_value_2['lng_name']) !== false) {
                            $standart_menu[$sm_key]['children'][$sm_key_2]['name'] = $this->getLanguage($sm_value_2['lng_name']);
                        }
                    }

                    if ($sm_value_2['children']) {

                        // third level
                        foreach ($sm_value_2['children'] as $sm_key_3 => $sm_value_3) {

                            if (array_key_exists('lng_name', $sm_value_3)) {
                                if ($this->getLanguage($sm_value_3['lng_name']) !== false) {
                                    $standart_menu[$sm_key]['children'][$sm_key_2]['children'][$sm_key_3]['name'] = $this->getLanguage($sm_value_3['lng_name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $standart_menu;
    }

    public function getModulesForLinks()
    {
        $tmp_mdls_data = array();

        // before 230 fix
        $path_fix = (VERSION >= '2.3.0.0') ? 'extension/' : '';

        $cat_files = glob(DIR_APPLICATION . 'controller/extension/'.$path_fix.'*.php', GLOB_BRACE);

        foreach ($cat_files as $c_file) {
            $extension = basename($c_file, '.php');

            // Compatibility code for old extension folders
            $this->load->language('extension/' . $path_fix . $extension);
            if ($this->user->hasPermission('access', 'extension/' . $path_fix . $extension)) {
                $cat_files = glob(DIR_APPLICATION . 'controller/' . $path_fix . $extension . '/*.php', GLOB_BRACE);

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
        $extra_data = array();

        // before 230 fix
        $path_fix = (VERSION >= '2.3.0.0') ? 'extension/' : '';

        // ,' . $category_shortname . '

        // Compatibility code for old extension folders
        $files = glob(DIR_APPLICATION . 'controller/{'. $path_fix . $category_shortname . '}/*.php', GLOB_BRACE);

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');

                $this->load->language($path_fix . $category_shortname . '/' . $extension);

                $extra_data[] = array(
                    'name'          => $this->language->get('heading_title'),
                    'shortname'     => $extension,
                    'edit'          => $path_fix . $category_shortname .'/' . $extension
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
    /////////                           (*)>(*)>(*)>                            /////////
    /////////////////////////////////////////////////////////////////////////////////////

    /*
    *   Format the link to work with ajax requests
    */
    public function ajax($route, $url = '', $ssl = true){
        return str_replace('&amp;', '&', $this->url->link($route, $url, $ssl));
    }

    /*
    *   Get file contents, usualy for debug log files.
    */
    public function getFileContents($file){

        if (file_exists($file)) {
            $size = filesize($file);

            if ($size >= 5242880) {
                $suffix = array(
                    'B',
                    'KB',
                    'MB',
                    'GB',
                    'TB',
                    'PB',
                    'EB',
                    'ZB',
                    'YB'
                    );

                $i = 0;

                while (($size / 1024) > 1) {
                    $size = $size / 1024;
                    $i++;
                }

                return sprintf($this->language->get('error_get_file_contents'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
            } else {
                return file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
            }
        }
    }

    /*
    *   Return name of config file.
    */
    public function getConfigFile($id, $sub_versions){

        if(isset($this->request->post['config'])){
            return $this->request->post['config'];
        }

        $setting = $this->config->get($id.'_setting');

        if(isset($setting['config'])){
            return $setting['config'];
        }

        $full = DIR_SYSTEM . 'config/'. $id . '.php';
        if (file_exists($full)) {
            return $id;
        }

        foreach ($sub_versions as $lite){
            if (file_exists(DIR_SYSTEM . 'config/'. $id . '_' . $lite . '.php')) {
                return $id . '_' . $lite;
            }
        }

        return false;
    }

    /*
    *   Return list of config files that contain the id of the module.
    */
    public function getConfigFiles($id){
        $files = array();
        $results = glob(DIR_SYSTEM . 'config/'. $id .'*');
        foreach($results as $result){
            $files[] = str_replace('.php', '', str_replace(DIR_SYSTEM . 'config/', '', $result));
        }
        return $files;
    }

    /*
    *   Get config file values and merge with config database values
    */
    public function getConfigData($id, $config_key, $store_id, $config_file = false){
        if(!$config_file){
            $config_file = $this->config_file;
        }
        if($config_file){
            $this->config->load($config_file);
        }

        $result = ($this->config->get($config_key)) ? $this->config->get($config_key) : array();

        if(!isset($this->request->post['config'])){
            $this->load->model('setting/setting');
            if (isset($this->request->post[$config_key])) {
                $setting = $this->request->post;
            } elseif ($this->model_setting_setting->getSetting($id, $store_id)) {
                $setting = $this->model_setting_setting->getSetting($id, $store_id);
            }
            if(isset($setting[$config_key])){
                foreach($setting[$config_key] as $key => $value){
                    $result[$key] = $value;
                }
            }

        }
        return $result;
    }


    /**

     MBooth functions

    **/

    /*
    *   Return mbooth file.
    */
    public function getMboothFile($id, $sub_versions){
        $full = DIR_SYSTEM . 'mbooth/xml/mbooth_'. $id .'.xml';
        if (file_exists($full)) {
            return 'mbooth_'. $id . '.xml';
        } else{
            foreach ($sub_versions as $lite){
                if (file_exists(DIR_SYSTEM . 'mbooth/xml/mbooth_'. $id . '_' . $lite . '.php')) {
                    $this->prefix = '_' . $lite;
                    return $this->id . '_' . $lite . '.xml';
                }
            }
        }
        return false;
    }

    /*
    *   Return mbooth file.
    */
    public function getMboothInfo($mbooth_file){
        if(file_exists(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_file)){
            $xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_file));
            return $xml;
        }else{
            return false;
        }
    }

    /*
    *   Get the version of this module
    */
    public function getVersion($mbooth_file){
        if(file_exists(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_file)){
            $xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_file));
            return $xml->version;
        }else{
            return false;
        }
    }

    /*
    *   Check if another extension/module is installed.
    */
    public function isInstalled($code) {
        $extension_data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `code` = '" . $this->db->escape($code) . "'");
        if($query->row) {
            return true;
        }else{
            return false;
        }
    }

    /*
    *   Get extension info by mbooth from server (Check for update)
    */
    public function getUpdateInfo($mbooth_file, $status = 1){
        $result = array();

        $current_version = $this->getVersion($mbooth_file);
        $customer_url = HTTP_SERVER;
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE language_id = " . (int)$this->config->get('config_language_id') );
        $language_code = $query->row['code'];
        $ip = $this->request->server['REMOTE_ADDR'];

        $request = 'http://opencart.dreamvention.com/api/1/index.php?route=extension/check&mbooth=' . $mbooth_file . '&store_url=' . $customer_url . '&module_version=' . $current_version . '&language_code=' . $language_code . '&opencart_version=' . VERSION . '&ip='.$ip . '&status=' .$status;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result['data'] = curl_exec($curl);
        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $result;
    }

    /**

    *   Get the version of this module
    *   Use this function to install dependencies, which are set in your mbooth xml file
    *   under the tag required;

    */
    public function installDependencies($mbooth_file){
        if(!defined('DIR_ROOT')) { define('DIR_ROOT', substr_replace(DIR_SYSTEM, '/', -8)); }

        foreach($this->getDependencies($mbooth_file) as $extension){
            if(isset($extension['codename'])){
                if(!$this->getVersion('mbooth_'.$extension['codename'].'.xml') || ($extension['version'] > $this->getVersion('mbooth_'.$extension['codename'].'.xml'))){
                    $this->downloadExtension($extension['codename'], $extension['version']);
                    $this->extractExtension();
                    if(file_exists(DIR_SYSTEM . 'mbooth/xml/'.$mbooth_file)){
                        $result = $this->backupFilesByMbooth($mbooth_file, 'update');
                    }
                    $this->move_dir(DIR_DOWNLOAD . 'upload/', DIR_ROOT, $result);
                }
            }
        }
    }

    public function getDependencies($mbooth_xml){
        if(file_exists(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_xml)){
            $xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/'. $mbooth_xml));
            $result = array();
            $version = false;

            foreach($xml->required->require as $require){

                foreach($require->attributes() as $key => $value){
                    $version = false;
                    if($key == 'version'){
                        $version = $value;
                    }
                }
                $result[] = array(
                    'codename' => (string)$require,
                    'version' => (string)$version
                );
            }
            return $result;
        }else{
            return false;
        }
    }

    public function downloadExtension($codename, $version, $filename  = false ) {

        if(!$filename){
            $filename = DIR_DOWNLOAD . 'archive.zip';
        }

        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        $ch = curl_init();
        $fp = fopen($filename, "w");
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, 'http://opencart.dreamvention.com/api/1/extension/download/?codename=' . $codename.'&opencart_version='.VERSION.'&extension_version='. $version);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $page = curl_exec($ch);
        if (!$page) {
            exit;
        }
        curl_close($ch);

    }

    public function extractExtension($filename = false, $location = false ) {
        if(!$filename){
            $filename = DIR_DOWNLOAD . 'archive.zip';
        }
        if(!$location){
            $location = DIR_DOWNLOAD;
        }

        $result = array();
        $zip = new ZipArchive;
        if (!$zip) {
            $result['error'][] = 'ZipArchive not working.';
        }

        if($zip->open($filename) != "true") {
            $result['error'][] = $filename;
        }
        $zip->extractTo($location);
        $zip->close();

        unlink($filename);

        return $result;

    }

    public function getMboothFiles($mbooth_url) {

        $xml = new SimpleXMLElement(file_get_contents($mbooth_url));

        if(isset($xml->id)){
            $result['file_name'] =   basename($mbooth_url, '');
            $result['id'] = isset($xml->id) ? (string)$xml->id : '';
            $result['name'] = isset($xml->name) ? (string)$xml->name : '';
            $result['description'] = isset($xml->description) ? (string)$xml->description : '';
            $result['type'] = isset($xml->type) ? (string)$xml->type : '';
            $result['version'] = isset($xml->version) ? (string)$xml->version : '';
            $result['license'] = isset($xml->license) ? (string)$xml->license : '';
            $result['opencart_version'] = isset($xml->opencart_version) ? (string)$xml->opencart_version : '';
            $result['mbooth_version'] = isset($xml->mbooth_version) ? (string)$xml->mbooth_version : '';
            $result['author'] = isset($xml->author) ? (string)$xml->author : '';
            $result['support_email'] = isset($xml->support_email) ? (string)$xml->support_email : '';
            $files = $xml->files;
            $dirs = $xml->dirs;
            $required = $xml->required;
            $updates = $xml->update;

            foreach ($files->file as $file){
               $result['files'][] = (string)$file;
            }

            if (!empty($dirs)) {

                $dir_files = array();

                foreach ($dirs->dir as $dir) {
                    $this->scan_dir(DIR_ROOT . $dir, $dir_files);
                }

                foreach ($dir_files as $file) {
                    $file = str_replace(DIR_ROOT, "", $file);
                    $result['files'][] = (string)$file;
                }
            }

            return $result;
        }else{
            return false;
        }

    }

    public function backupFilesByMbooth($mbooth_xml, $action = 'install'){

        $zip = new ZipArchive();

        if (!file_exists(DIR_SYSTEM . 'mbooth/backup/')) {
            mkdir(DIR_SYSTEM . 'mbooth/backup/', 0777, true);
        }

        $mbooth = $this->getMboothFiles(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml);
        $files = $mbooth['files'];

        $zip->open(DIR_SYSTEM . 'mbooth/backup/' . date('Y-m-d.h-i-s'). '.'. $action .'.'.$mbooth_xml.'.v'.$mbooth['version'].'.zip', ZipArchive::CREATE);


        foreach ($files as $file) {

            if(file_exists(DIR_ROOT.$file)){

                if (is_file(DIR_ROOT.$file)) {
                    $zip->addFile(DIR_ROOT.$file, 'upload/'.$file);
                    $result['success'][] = $file;
                }else{
                    $result['error'][] = $file;
                }
            }else{
                    $result['error'][] = $file;
            }
        }
        $zip->close();
        return $result;

    }

    /*
    *   Dir function
    */
    public function scan_dir($dir, &$arr_files){

        if (is_dir($dir)){
            $handle = opendir($dir);
            while ($file = readdir($handle)){
                    if ($file == '.' or $file == '..') continue;
                    if (is_file($file)) $arr_files[]="$dir/$file";
                    else $this->scan_dir("$dir/$file", $arr_files);
            }
            closedir($handle);
        }else {
            $arr_files[]=$dir;
        }
    }

    public function move_dir($souce, $dest, &$result) {

        $files = scandir($souce);

        foreach($files as $file){

            if($file == '.' || $file == '..' || $file == '.DS_Store') continue;

            if(is_dir($souce.$file)){
                if (!file_exists($dest.$file.'/')) {
                    mkdir($dest.$file.'/', 0777, true);
                }
                $this->move_dir($souce.$file.'/', $dest.$file.'/', $result);
            }elseif (rename($souce.$file, $dest.$file)) {
                $result['success'][] = str_replace(DIR_ROOT, '', $dest.$file);
            }else{
                $result['error'][] = str_replace(DIR_ROOT, '', $dest.$file);
            }
        }

        $this->delete_dir($souce);
    }

    public function delete_dir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") $this->delete_dir($dir."/".$object);
                    else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}

