<div class="well well-sm">
  <div style="float: right;">
    <button type="button" id="button-collapse-custom" class="btn btn-sm" >Collapse All</button>
    <button type="button" id="button-expand-custom" class="btn btn-sm">Expand All</button>
  </div>
  <button type="button" id="button-add-custom" class="btn btn-sm btn-primary" ><i class="fa fa-plus" aria-hidden="true"></i> Item</button>
</div>

<?php if(!$custom_menu_data) {?>
<ol class="dd-list dd-nodrag main-custom-list">
</ol>
<?php } ?>


<?php if($custom_menu_data) {  ?>
<ol class="dd-list dd-nodrag main-custom-list">

      <!-- first level -->
      <?php foreach($custom_menu_data as $cmd_first_item) { ?>
      <li id="dd_custom_<?php echo  $cmd_first_item['id']; ?>" class="dd-item dd-nodrag custom-menu-item" data-id="<?php echo $cmd_first_item['id']; ?>">

        <div class="dd-handle">

          <span class="item-icon-picker btn-group">
            <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
            <button type="button" class="icp icp-dd btn dropdown-toggle supericon-yep" data-selected="<?php echo $cmd_first_item['icon']; ?>" data-id="<?php echo $cmd_first_item['id']; ?>" data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <span class="dropdown-menu"></span>
            <input type="hidden" name="custom-menu[<?php echo $cmd_first_item['id']; ?>][icon]" value="<?php echo $cmd_first_item['icon']; ?>">
          </span>

          <span class="item-name" style="margin-left: 20px;">
            <input type="item-name" name="custom-menu[<?php echo $cmd_first_item['id']; ?>][name]" value="<?php echo $cmd_first_item['name']; ?>" class="custom-item-name" placeholder="<?php echo $cmd_first_item['name']; ?>">
          </span>
          <span class="item-link" style="margin-left: 20px;">
            <select name="custom-menu[<?php echo $cmd_first_item['id']; ?>][item_link]" class="input-sm custom-item-link">
              <?php foreach ($modules_for_links as $mfl) { ?>
              <optgroup label="<?php echo $mfl['text']; ?>">
              <?php if (!$mfl['extra']) { ?>
              <!-- ? -->
              <?php } else { ?>
              <?php foreach ($mfl['extra'] as $ex_mfl) { ?>
              <?php preg_match('/=[a-z\/_]+/', $cmd_first_item['href'], $first_match); ?>
              <option <?php echo ($ex_mfl['edit'] == trim($first_match[0], '=')) ? 'selected' : ''; ?> value="<?php echo $ex_mfl['edit']; ?>"><?php echo $ex_mfl['name']; ?></option>
              <?php } ?>
              <?php } ?>
              </optgroup>
              <?php } ?>
            </select>
          </span>
          <span class="item-icons-custom dd-nodrag">
            <span class="fa fa-times fa-lg custom-removebtn" style="color: red;" data-del-id="<?php echo $cmd_first_item['id']; ?>"></span>
          </span>
        </div>


        <!-- second level -->
        <?php if($cmd_first_item['children']) { ?>
        <ol class="dd-list dd-nodrag">
        <?php foreach($cmd_first_item['children'] as $cmd_second_item) { ?>

        <li id="dd_custom_<?php echo $cmd_second_item['id']; ?>" class="dd-item dd-nodrag custom-menu-item" data-id="<?php echo $cmd_second_item['id']; ?>">


          <div class="dd-handle">

            <span class="item-icon-picker btn-group">
              <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
              <button type="button" class="icp icp-dd btn dropdown-toggle supericon-yep" data-selected="<?php echo $cmd_second_item['icon']; ?>" data-id="<?php echo $cmd_second_item['id']; ?>" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <span class="dropdown-menu"></span>
              <input type="hidden" name="custom-menu[<?php echo $cmd_second_item['id']; ?>][icon]" value="<?php echo $cmd_second_item['icon']; ?>">
            </span>

            <span class="item-name" style="margin-left: 20px;">
              <input type="item-name" name="custom-menu[<?php echo $cmd_second_item['id']; ?>][name]" value="<?php echo $cmd_second_item['name']; ?>" class="custom-item-name" placeholder="<?php echo $cmd_second_item['name']; ?>">
            </span>
            <span class="item-link" style="margin-left: 20px;">
              <select name="custom-menu[<?php echo $cmd_second_item['id']; ?>][item_link]" class="input-sm custom-item-link">
                <?php foreach ($modules_for_links as $mfl) { ?>
                <optgroup label="<?php echo $mfl['text']; ?>">
                <?php if (!$mfl['extra']) { ?>
                <!-- ? -->
                <?php } else { ?>
                <?php foreach ($mfl['extra'] as $ex_mfl) { ?>
                <?php preg_match('/=[a-z\/_]+/', $cmd_second_item['href'], $first_match); ?>
                <option <?php echo ($ex_mfl['edit'] == trim($first_match[0], '=')) ? 'selected' : ''; ?> value="<?php echo $ex_mfl['edit']; ?>"><?php echo $ex_mfl['name']; ?></option>
                <?php } ?>
                <?php } ?>
                </optgroup>
                <?php } ?>
              </select>
            </span>
            <span class="item-icons-custom dd-nodrag">
              <span class="fa fa-times fa-lg custom-removebtn" style="color: red;" data-del-id="<?php echo $cmd_second_item['id']; ?>"></span>
            </span>
          </div>


          <!-- third level -->
          <?php if($cmd_second_item['children']) { ?>
          <ol class="dd-list dd-nodrag">
          <?php foreach($cmd_second_item['children'] as $cmd_third_item) { ?>
          <li id="dd_custom_<?php echo $cmd_third_item['id']; ?>" class="dd-item dd-nodrag custom-menu-item" data-id="<?php echo $cmd_third_item['id']; ?>">

            <div class="dd-handle">

              <span class="item-icon-picker btn-group">
                <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
                <button type="button" class="icp icp-dd btn dropdown-toggle supericon-yep" data-selected="<?php echo $cmd_third_item['icon']; ?>" data-id="<?php echo $cmd_third_item['id']; ?>" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <span class="dropdown-menu"></span>
                <input type="hidden" name="custom-menu[<?php echo $cmd_third_item['id']; ?>][icon]" value="<?php echo $cmd_third_item['icon']; ?>">
              </span>

              <span class="item-name" style="margin-left: 20px;">
                <input type="item-name" name="custom-menu[<?php echo $cmd_third_item['id']; ?>][name]" value="<?php echo $cmd_third_item['name']; ?>" class="custom-item-name" placeholder="<?php echo $cmd_third_item['name']; ?>">
              </span>
              <span class="item-link" style="margin-left: 20px;">
                <select name="custom-menu[<?php echo $cmd_third_item['id']; ?>][item_link]" class="input-sm custom-item-link">
                  <?php foreach ($modules_for_links as $mfl) { ?>
                  <optgroup label="<?php echo $mfl['text']; ?>">
                  <?php if (!$mfl['extra']) { ?>
                  <!-- ? -->
                  <?php } else { ?>
                  <?php foreach ($mfl['extra'] as $ex_mfl) { ?>
                  <?php preg_match('/=[a-z\/_]+/', $cmd_third_item['href'], $first_match); ?>
                  <option <?php echo ($ex_mfl['edit'] == trim($first_match[0], '=')) ? 'selected' : ''; ?> value="<?php echo $ex_mfl['edit']; ?>"><?php echo $ex_mfl['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                  </optgroup>
                  <?php } ?>
                </select>
              </span>
              <span class="item-icons-custom dd-nodrag">
                <span class="fa fa-times fa-lg custom-removebtn" style="color: red;" data-del-id="<?php echo $cmd_third_item['id']; ?>"></span>
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

<template id="new_custom_item">
  <li id="dd_custom_{{new_custom_id}}" class="dd-item dd-nodrag custom-menu-item" data-id="{{new_custom_id}}">

      <div class="dd-handle">
          <span class="item-icon-picker btn-group">
            <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-flask"></i></button>
            <button type="button" class="icp icp-dd btn dropdown-toggle supericon-yep" data-selected="fa-flask" data-id="{{new_custom_id}}" data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <span class="dropdown-menu"></span>
            <input type="hidden" name="custom-menu[{{new_custom_id}}][icon]" value="fa-flask">
          </span>

        <span class="item-name" style="margin-left: 20px;">
          <input type="item-name" name="custom-menu[{{new_custom_id}}][name]" value="Shopunity" class="custom-item-name" placeholder="<?php echo $text_phd_item_name; ?>">
        </span>

        <span class="item-link" style="margin-left: 20px;">
          <select name="custom-menu[{{new_custom_id}}][item_link]" class="input-sm custom-item-link">
            <?php foreach ($modules_for_links as $mfl) { ?>
            <optgroup label="<?php echo $mfl['text']; ?>">
            <?php if (!$mfl['extra']) { ?>
            <!-- ? -->
            <?php } else { ?>
            <?php foreach ($mfl['extra'] as $ex_mfl) { ?>
            <option <?php echo ($ex_mfl['edit'] == 'extension/module/d_shopunity') ? 'selected' : ''; ?> value="<?php echo $ex_mfl['edit']; ?>"><?php echo $ex_mfl['name']; ?></option>
            <?php } ?>
            <?php } ?>
            </optgroup>
            <?php } ?>
          </select>
        </span>

        <span class="item-icons-custom dd-nodrag">
          <span class="fa fa-times fa-lg custom-removebtn" style="color: red;" data-del-id="{{new_custom_id}}" aria-hidden="true"></span>
        </span>
      </div>
  </li>
</template>
