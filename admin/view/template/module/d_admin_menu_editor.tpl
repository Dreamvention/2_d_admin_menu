<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="form-inline pull-right">
                <button id="save_and_stay" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
                <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?> <?php echo $version; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <?php if (!empty($error['warning'])) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if (!empty($error['shopunity'])) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $error['shopunity']; ?>
        </div>
        <?php } ?>
        <?php if (!empty($success)) { ?>
        <div class="alert alert-success">
            <i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">

                  <ul  class="nav nav-tabs">
                    <li class="active">
                        <a href="#setting" data-toggle="tab">
                            <span class="fa fa-cog"></span>
                            <?php echo $tab_setting; ?>
                        </a>
                    </li>
                    <li>
                        <a href="#instruction" data-toggle="tab">
                            <span class="fa fa-graduation-cap"></span>
                            <?php echo $tab_instruction; ?>
                        </a>
                    </li>
                  </ul>

                  <div class="tab-content">

                      <div class="tab-pane active" id="setting" >
                          <div class="tab-body">
                            <div class="row">

                              <div class="col-sm-2">
                                <ul class="nav nav-pills s-nav-stacked">
                                  <li>
                                    <a href="#d_home" data-toggle="tab">
                                      <span class="fa fa-home fa-fw"></span> <span><?php echo $text_home; ?></span>
                                    </a>
                                  </li>
                                  <?php if($setting_id) { ?>
                                  <li class="active">
                                    <a href="#d_menu" data-toggle="tab">
                                      <span class="fa fa-bookmark-o fa-fw"></span> <span><?php echo $text_menu; ?></span>
                                    </a>
                                  </li>
                                  <?php } ?>
                                </ul>
                              </div>

                              <div class="col-sm-10">
                                <div class="tab-content">

                                  <div id="d_home" class="tab-pane">
                                    <div class="page-header">
                                        <h3><span class="fa fa-home"></span> <span><?php echo $text_home; ?></span></h3>
                                    </div>
                                    <?php if(!$setting){ ?>
                                    <div class="bs-callout bs-callout-warning"><?php echo $text_intro_create_setting; ?></div>
                                    <?php } ?>
                                    <div class="row">
                                    <!-- HOME CONTENT -->
                                    </div>
                                  </div>

                                  <div id="d_menu" class="tab-pane active">

                                  <div class="form-group">
                                      <div class="btn-group">
                                          <button type="button" class="btn btn-default btn-sm iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
                                          <button type="button" class="icp btn-sm icp-dd btn dropdown-toggle supericon" data-selected="fa-car" data-toggle="dropdown">
                                              <span class="caret"></span>
                                              <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu"></div>
                                      </div>
                                      <input class="form-control superinput" value="333" type="text">
                                  </div>


                                    <div class="col-sm-12">

                                    <!-- STANDART MENU -->
                                    <div class="panel-group col-sm-5">
                                    <h3 class="page-header">
                                        <span class="fa fa-bookmark-o fa-fw"></span> <span><?php echo $text_standart_menu; ?></span>
                                    </h3>
                                    <div id="unallocated">
                                      <div class="dd nestable" id="nestable-standart">
                                        <?php echo $standart_menu; ?>
                                      </div>
                                      <br/><br/><br/><br/>
                                      <textarea id="nestable-output-standart"></textarea>
                                    </div>
                                    </div>

                                    <!-- CUSTOM MENU -->
                                    <div class="panel-group col-sm-7" style="float: right;">
                                    <h3 class="page-header">
                                        <span class="fa fa-bookmark fa-fw"></span> <span><?php echo $text_custom_menu; ?></span>
                                    </h3>
                                    <div id="unallocated">
                                      <div class="dd nestable" id="nestable-custom">
                                        <?php echo $custom_menu; ?>
                                      </div>
                                      <br/><br/><br/><br/>
                                      <textarea id="nestable-output-custom"></textarea>
                                    </div>
                                    </div>

                                    </div>
                                  </div>

                                </div>
                              </div>

                            </div>
                          </div>
                      </div>

                      <div class="tab-pane" id="instruction" >
                          <div class="tab-body">
                              <?php echo $text_instruction; ?>
                          </div>
                      </div>

                  </div>



                </form>
            </div>
        </div>



    </div>

</div>

<template id="add-item-modal">
  <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit menu item <b>{{name}}</b> </h4>
        </div>
        <div class="modal-body">
          <form id="menu_item_form" class="form-horizontal">

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_text"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                  <select name="item_extra" class="form-control input-sm">
                    <?php foreach ($categories as $category) { ?>
                    <optgroup label="<?php echo $category['text']; ?>">
                    <?php if (!$category['extra']) { ?>
                    <!-- ? -->
                    <?php } else { ?>
                    <?php foreach ($category['extra'] as $ex_cat) { ?>
                    <option value="<?php echo $ex_cat['edit']; ?>"><?php echo $ex_cat['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    </optgroup>
                    <?php } ?>
                  </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_text"><?php echo $entry_parent; ?></label>
              <div class="col-sm-10">
                  <select name="item_parent" class="form-control input-sm">
                    <option value="0"></option>
                    <?php if ($menu_items) { ?>
                    <?php foreach ($menu_items as $p_item) { ?>
                    <option value="<?php echo $p_item['menu_item_id']; ?>"><?php echo "(id " . $p_item['menu_item_id'] . ") "; ?><?php echo $p_item['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_action"><?php echo $entry_position; ?></label>
              <div class="col-sm-10">
                <input type="text" name="item_position" value="{{item_position}}" placeholder="<?php echo $entry_position; ?>" id="input-width" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_action"><?php echo $entry_icon; ?></label>
              <div class="col-sm-10">
                <input type="text" name="item_icon" value="{{item_icon}}" placeholder="<?php echo $entry_icon; ?>" id="input-width" class="form-control" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a type="button" class="btn btn-primary save" href="{{save}}" data-menu_item_id="{{menu_item_id}}">Save changes</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  $(document).ready(function()
  {
      var updateOutput = function(e)
      {
          var list   = e.length ? e : $(e.target),
              output = list.data('output');
          if (window.JSON) {
              output.val(window.JSON.stringify(list.nestable_nodrag('serialize')));//, null, 2));
          } else {
              output.val('JSON browser support required for this demo.');
          }
      };

      $('#nestable-standart').nestable_nodrag({maxDepth: '3', group: "standart"})
      .on('change', updateOutput);

      $('#nestable-custom').nestable({maxDepth: '3', group: "custom"})
      .on('change', updateOutput);

      $('#nestable-standart').nestable_nodrag('collapseAll');
      $('#nestable-custom').nestable('collapseAll');

      // output initial serialised data
      updateOutput($('#nestable-standart').data('output', $('#nestable-output-standart')));
      updateOutput($('#nestable-custom').data('output', $('#nestable-output-custom')));

      // collapse-expand buttons
      $('#button-collapse-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('collapseAll'); });

      $('#button-expand-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('expandAll'); });

      $('#button-collapse-custom').on('click', function()
      { $('#nestable-custom').nestable_nodrag('collapseAll'); });

      $('#button-expand-custom').on('click', function()
      { $('#nestable-custom').nestable_nodrag('expandAll'); });
  });


  function handlebar_templating(some_html, some_json)
  {
    var re = /{{([^}}]+)?}}/g, match;
    while(match = re.exec(some_html)) {
        some_html = some_html.replace(match[0], some_json[match[1]]);
    };
    return some_html;
  }

  $(document).ready(function()
  {

    $('#button-add-custom').on('click', function()
    {
      $('#addModal').remove();
      var html = $('#add-item-modal').html();


      html = handlebar_templating(html, json);
    });

  });

  $(document).on('click', '.create', function(){
    var that = this;
    $('#addModal').remove();
    var html = $('#add-item-modal').html();
    var json = {
      menu_item_id: 0,
      item_parent: '',
      item_position: '',
      item_icon: '',
      save: '<?php echo $create; ?>'
    };

    html = handlebar_templating(html, json);

    $('body').append(html);
    $('#addModal').modal('show');
    return false;
  });

  $('.supericon').iconpicker();



  $(function() {

    $('.icp').on('iconpickerSelected', function(e) {
      $('.superinput').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
    });

    // Events sample:
    // This event is only triggered when the actual input value is changed
    // by user interaction
    // $('.icp').on('iconpickerSelected', function(e) {
    //     $('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
    //             e.iconpickerInstance.options.iconBaseClass + ' ' +
    //             e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
    // });
  });



</script>

<?php echo $footer; ?>
