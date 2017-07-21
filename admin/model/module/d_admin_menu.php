<?php

class ModelModuleDAdminMenu extends Model
{
    private $codename = 'd_admin_menu';
 //   private $config_file = 'd_admin_menu.tpl';

    public function installModule(){
       // $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "d_adminmenu (menu_id bigint(20) NOT NULL, parent_id bigint(20), sort_order int(5), menu_type TEXT, menu_type_id int(11), url TEXT, target TEXT, icon TEXT, image TEXT, PRIMARY KEY (menu_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    public function uninstallModule(){
       // $this->db->query("DROP TABLE " . DB_PREFIX . "d_adminmenu");
    }


}
