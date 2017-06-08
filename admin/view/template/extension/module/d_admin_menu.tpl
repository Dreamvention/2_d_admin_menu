<link href="view/stylesheet/d_admin_menu/d_admin_menu.css" type="text/css" rel="stylesheet">
<ul id="menu2">
        <?php foreach ($config['menu'] as $k=>$menu) { ?>
        <li id="" data-sort="<?php echo $k?>">
            <?php if ($menu['link']) { ?>
            <a href="<?php echo $menu['link'].$token; ?>"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                <span><?php echo $menu['text']; ?></span></a>
            <?php } else { ?>
            <a class="parent"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                <span><?php echo $menu['text']; ?></span></a>
            <?php } ?>
            <?php if ($menu['children']) { ?>
            <ul>
                <?php foreach ($menu['children'] as $children_1) { ?>
                <li>
                    <?php if ($children_1['link']) { ?>
                    <a href="<?php echo $children_1['link'].$token; ?>"><?php echo $children_1['text']; ?></a>
                    <?php } else { ?>
                    <a class="parent"><?php echo $children_1['text']; ?></a>
                    <?php } ?>
                    <?php if ($children_1['children']) { ?>
                    <ul>
                        <?php foreach ($children_1['children'] as $children_2) { ?>
                        <li>
                            <?php if ($children_2['link']) { ?>
                            <a href="<?php echo $children_2['link'].$token; ?>"><?php echo $children_2['text']; ?></a>
                            <?php } else { ?>
                            <a class="parent"><?php echo $children_2['text']; ?></a>
                            <?php } ?>
                            <?php if ($children_2['children']) { ?>
                            <ul>
                                <?php foreach ($children_2['children'] as $children_3) { ?>
                                <li><a href="<?php echo $children_3['link'].$token; ?>"><?php echo $children_3['text']; ?></a>
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