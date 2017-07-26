<link href="view/stylesheet/d_admin_menu/d_admin_menu.css" type="text/css" rel="stylesheet">
<ul id="menu2">
        <?php foreach ($config['menus'] as $k=>$menu) { ?>
        <li id="" data-sort="<?php echo $k?>">
            <?php if ($menu['href']) { ?>
            <a href="<?php echo $menu['href'].$token; ?>"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                <span><?php echo $menu['name']; ?></span></a>
            <?php } else { ?>
            <a class="parent"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                <span><?php echo $menu['name']; ?></span></a>
            <?php } ?>
            <?php if ($menu['children']) { ?>
            <ul>
                <?php foreach ($menu['children'] as $children_1) { ?>
                <li style="<?php echo ($children_1['is_visible'] == 0) ? 'display: none;' : ''; ?>">
                    <?php if ($children_1['href']) { ?>
                    <a href="<?php echo $children_1['href'].$token; ?>"><?php echo $children_1['name']; ?></a>
                    <?php } else { ?>
                    <a class="parent"><?php echo $children_1['name']; ?></a>
                    <?php } ?>
                    <?php if ($children_1['children']) { ?>
                    <ul>
                        <?php foreach ($children_1['children'] as $children_2) { ?>
                        <li style="<?php echo ($children_2['is_visible'] == 0) ? 'display: none;' : ''; ?>">
                            <?php if ($children_2['href']) { ?>
                            <a href="<?php echo $children_2['href'].$token; ?>"><?php echo $children_2['name']; ?></a>
                            <?php } else { ?>
                            <a class="parent"><?php echo $children_2['name']; ?></a>
                            <?php } ?>
                            <?php if ($children_2['children']) { ?>
                            <ul>
                                <?php foreach ($children_2['children'] as $children_3) { ?>
                                <li><a href="<?php echo $children_3['href'].$token; ?>"><?php echo $children_3['name']; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
<script src="view/javascript/d_admin_menu/d_admin_menu.js" type="text/javascript"></script>
