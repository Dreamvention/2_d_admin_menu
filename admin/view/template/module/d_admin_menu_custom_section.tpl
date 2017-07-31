
<?php if(!$custom_menu_data) {?>
<ol class="dd-empty">
</ol>
<?php } ?>


<?php if($custom_menu_data) {  ?>
<div class="well well-sm">
  <div style="float: right;">
    <button type="button" id="button-collapse-custom" class="btn btn-sm" >Collapse All</button>
    <button type="button" id="button-expand-custom" class="btn btn-sm">Expand All</button>
  </div>
  <button type="button" id="button-add-custom" class="btn btn-sm btn-primary" ><i class="fa fa-plus" aria-hidden="true"></i> Item</button>
</div>
<ol class="dd-list">

      <!-- first level -->
      <?php foreach($custom_menu_data as $first_key=>$cmd_first_item) { ?>
      <li id="dd_<?php echo $first_key; ?>" class="dd-item" data-id="<?php echo $first_key; ?>"
      data-icon="<?php echo $cmd_first_item['icon']; ?>" data-name="<?php echo $cmd_first_item['name']; ?>">

        <div class="dd-handle">
          <?php if($cmd_first_item['icon'] == '>>') { ?>
          <span class="item-supericon">»</span>
          <?php } else { ?>
            <span class="btn-group">
              <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
              <button type="button" class="icp icp-dd btn dropdown-toggle supericon" data-selected="<?php echo $cmd_first_item['icon']; ?>" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <span class="dropdown-menu"></span>
              <input type="hidden" name="custom-menu[icon]" value="">
            </span>
          <?php } ?>

          <span class="heading-title" style="margin-left: 20px;">
            <input type="item-name" name="custom-menu[name]" value="<?php echo $cmd_first_item['name']; ?>" placeholder="<?php echo $cmd_first_item['name']; ?>">
          </span>
          <span class="item-icons dd-nodrag">
            <?php if(array_key_exists('is_visible', $cmd_first_item)) { ?>
            <?php if($cmd_first_item['is_visible'] === 1) { ?>
            <span class="fa fa-minus-square-o fa-fw" id="hide-product" data-id="<?php echo $first_key; ?>"></span>
            <?php } else { ?>
            <span class="fa fa-minus-square fa-fw" id="hide-product" data-id="<?php echo $first_key; ?>"></span>
            <?php } ?>
            <?php } ?>
          </span>
        </div>


        <!-- second level -->
        <?php if($cmd_first_item['children']) { ?>
        <ol class="dd-list">
        <?php foreach($cmd_first_item['children'] as $second_key=>$cmd_second_item) { ?>

        <li id="dd_<?php echo $second_key; ?>" class="dd-item" data-id="<?php echo $second_key; ?>">

          <div class="dd-handle">
            <?php if($cmd_second_item['icon'] == '>>') { ?>
            <span class="item-supericon">»</span>
            <?php } else { ?>
            <span class="item-supericon fa <?php echo $cmd_second_item['icon']; ?> fa-lg"></span>
            <?php } ?>
            <span class="heading-title"><?php echo $cmd_second_item['name']; ?></span>
            <span class="item-icons dd-nodrag">
              <?php if(array_key_exists('is_visible', $cmd_second_item)) { ?>
              <?php if($cmd_second_item['is_visible'] === 1) { ?>
              <span class="fa fa-minus-square-o fa-fw" id="hide-product" data-id="<?php echo $second_key; ?>"></span>
              <?php } else { ?>
              <span class="fa fa-minus-square fa-fw" id="hide-product" data-id="<?php echo $second_key; ?>"></span>
              <?php } ?>
              <?php } ?>
            </span>
          </div>


          <!-- third level -->
          <?php if($cmd_second_item['children']) { ?>
          <ol class="dd-list">
          <?php foreach($cmd_second_item['children'] as $third_key=>$cmd_third_item) { ?>
          <li id="dd_<?php echo $third_key; ?>" class="dd-item" data-id="<?php echo $third_key; ?>">

            <div class="dd-handle">
              <?php if($cmd_third_item['icon'] == '>>') { ?>
              <span class="item-supericon">»</span>
              <?php } else { ?>
              <span class="item-supericon fa <?php echo $cmd_third_item['icon']; ?> fa-lg"></span>
              <?php } ?>
              <span class="heading-title"><?php echo $cmd_third_item['name']; ?></span>
              <span class="item-icons dd-nodrag">
                <?php if(array_key_exists('is_visible', $cmd_third_item)) { ?>
                <?php if($cmd_third_item['is_visible'] === 1) { ?>
                <span class="fa fa-minus-square-o fa-fw" id="hide-product" data-id="<?php echo $third_key; ?>"></span>
                <?php } else { ?>
                <span class="fa fa-minus-square fa-fw" id="hide-product" data-id="<?php echo $third_key; ?>"></span>
                <?php } ?>
                <?php } ?>
              </span>
            </div>
          </li>
          <?php } ?>
          </ol>
          <?php } ?>


        </li>
        <?php } ?>
        </ol>
        <?php } ?>


      </li>
      <?php } ?>

</ol>
<?php } ?>
