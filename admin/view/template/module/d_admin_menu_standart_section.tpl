
<?php if(!$standart_menu_data) {?>
<ol class="dd-empty">
</ol>
<?php } ?>


<?php if($standart_menu_data) {  ?>
<div class="well well-sm">
  <div style="float: right;">
    <button type="button" id="button-collapse-standart" class="btn btn-sm" >Collapse All</button>
    <button type="button" id="button-expand-standart" class="btn btn-sm">Expand All</button>
  </div>
  <button type="button" id="button-restore-standart" class="btn btn-sm btn-success" >Restore default</button>
</div>
<ol class="dd-list dd-nodrag">

      <!-- first level -->
      <?php foreach($standart_menu_data as $smd_first_item) { ?>
      <li id="dd_<?php echo $smd_first_item['id']; ?>" class="dd-item dd-nodrag" data-id="<?php echo $smd_first_item['id']; ?>">

        <div class="dd-handle">
          <?php if($smd_first_item['icon'] == '>>') { ?>
          <span class="item-supericon">»</span>
          <?php } else { ?>
          <span class="item-supericon fa <?php echo $smd_first_item['icon']; ?> fa-lg"></span>
          <?php } ?>
          <span class="heading-title"><?php echo $smd_first_item['name']; ?></span>
          <span class="item-icons dd-nodrag">
            <?php if(array_key_exists('is_visible', $smd_first_item)) { ?>
            <input type="checkbox" name="standart-menu[<?php echo $smd_first_item['id']; ?>][visibility]" value="<?php echo ($smd_first_item['is_visible'] === 1) ? 1 : 0; ?>" data-size="mini" data-label-text="Display" data-bs="true" <?php echo ($smd_first_item['is_visible'] === 1) ? 'checked="checked"' : ''; ?>>
            <?php } ?>
          </span>
        </div>


        <!-- second level -->
        <?php if($smd_first_item['children']) { ?>
        <ol class="dd-list dd-nodrag">
        <?php foreach($smd_first_item['children'] as $smd_second_item) { ?>

        <li id="dd_<?php echo $smd_second_item['id']; ?>" class="dd-item dd-nodrag" data-id="<?php echo $smd_second_item['id']; ?>">

          <div class="dd-handle">
            <?php if($smd_second_item['icon'] == '>>') { ?>
            <span class="item-supericon">»</span>
            <?php } else { ?>
            <span class="item-supericon fa <?php echo $smd_second_item['icon']; ?> fa-lg"></span>
            <?php } ?>
            <span class="heading-title"><?php echo $smd_second_item['name']; ?></span>
            <span class="item-icons dd-nodrag">
              <?php if(array_key_exists('is_visible', $smd_second_item)) { ?>
              <input type="checkbox" name="standart-menu[<?php echo $smd_second_item['id']; ?>][visibility]" value="<?php echo ($smd_second_item['is_visible'] === 1) ? 1 : 0; ?>" data-size="mini" data-label-text="Display" data-bs="true" <?php echo ($smd_second_item['is_visible'] === 1) ? 'checked="checked"' : ''; ?>>
              <?php } ?>
            </span>
          </div>


          <!-- third level -->
          <?php if($smd_second_item['children']) { ?>
          <ol class="dd-list dd-nodrag">
          <?php foreach($smd_second_item['children'] as $smd_third_item) { ?>
          <li id="dd_<?php echo $smd_third_item['id']; ?>" class="dd-item dd-nodrag" data-id="<?php echo $smd_third_item['id']; ?>">

            <div class="dd-handle">
              <?php if($smd_third_item['icon'] == '>>') { ?>
              <span class="item-supericon">»</span>
              <?php } else { ?>
              <span class="item-supericon fa <?php echo $smd_third_item['icon']; ?> fa-lg"></span>
              <?php } ?>
              <span class="heading-title"><?php echo $smd_third_item['name']; ?></span>
              <span class="item-icons dd-nodrag">
                <?php if(array_key_exists('is_visible', $smd_third_item)) { ?>
                <input type="checkbox" name="standart-menu[<?php echo $smd_third_item['id']; ?>][visibility]" value="<?php echo ($smd_third_item['is_visible'] === 1) ? 1 : 0; ?>" data-size="mini" data-label-text="Display" data-bs="true" <?php echo ($smd_third_item['is_visible'] === 1) ? 'checked="checked"' : ''; ?>>
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
