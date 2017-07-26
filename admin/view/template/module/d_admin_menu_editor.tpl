<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="form-inline pull-right">
        <a data-toggle="tooltip" title="<?php echo $button_create; ?>" class="btn btn-primary create"><i class="fa fa-plus"></i></a>
        <a data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger delete"><i class="fa fa-trash-o"></i></a>
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
    <?php if (!empty($success)) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">

        <ul class="nav nav-tabs">
          <li ><a href="#tab_module" data-toggle="tab">
            <span class="fa fa-plug"></span>
            <?php echo $tab_module; ?>
          </a></li>

          <li class="active"><a href="#tab_setting" data-toggle="tab">
            <span class="fa fa-cog"></span>
            <?php echo $tab_setting; ?>
          </a></li>

          <li><a href="#tab_supertest" data-toggle="tab">
            <span class="fa fa-cog"></span>
            Тестовое полечко
          </a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane" id="tab_module" >
            <div class="tab-body">

              <div id="filter" class="well">
                <div class="row">
                  <!-- FILTER -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label class="control-label" for="input-menu_iten_id"><?php echo $entry_item_id; ?></label>
                      <input type="text" name="filter_item_id" value="<?php echo $filter_item_id; ?>" placeholder="<?php echo $entry_item_id; ?>" id="input-menu_iten_id" class="form-control" data-item="menu_item_id"/>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                      <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" data-item="name"/>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label class="control-label" for="input-parent"><?php echo $entry_category; ?></label>
                      <input type="text" name="filter_category" value="<?php echo $filter_category; ?>" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" data-item="category"/>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label class="control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                      <input type="text" name="filter_parent" value="<?php echo $filter_parent; ?>" placeholder="<?php echo $entry_parent; ?>" id="input-parent" class="form-control" data-item="parent"/>
                    </div>
                    <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                  </div>
                </div>
              </div>

              <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-menu-item">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'menu_item_id\']').prop('checked', this.checked);" /></td>
                        <td class="text-left">
                          <?php if ($sort == 'menu_item_id') { ?>
                            <a href="<?php echo $sort_menu_item_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_menu_item_id; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_menu_item_id; ?>"><?php echo $column_menu_item_id; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <?php if ($sort == 'name') { ?>
                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <?php if ($sort == 'category') { ?>
                            <a href="<?php echo $sort_category; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_category; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_category; ?>"><?php echo $column_category; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <?php if ($sort == 'parent') { ?>
                            <a href="<?php echo $sort_parent; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_parent; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_parent; ?>"><?php echo $column_parent; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <?php if ($sort == 'position') { ?>
                            <a href="<?php echo $sort_position; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_position; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_position; ?>"><?php echo $column_position; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                          <?php if ($sort == 'icon') { ?>
                            <a href="<?php echo $sort_icon; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_icon; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_icon; ?>"><?php echo $column_icon; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-center" style="width: 120px;"><?php echo $column_action; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if ($menu_items) { ?>
                      <?php foreach ($menu_items as $m_item) { ?>
                        <tr id="menu_item_id_<?php echo $m_item['menu_item_id']; ?>" <?php echo ($m_item['status']) ? 'class="enabled"' : '';?>>
                          <td class="text-center">
                            <?php if (in_array($m_item['menu_item_id'], $selected)) { ?>
                              <input type="checkbox" name="menu_item_id[]" value="<?php echo $m_item['menu_item_id']; ?>" checked="checked" />
                            <?php } else { ?>
                              <input type="checkbox" name="menu_item_id[]" value="<?php echo $m_item['menu_item_id']; ?>" />
                            <?php } ?>
                          </td>
                          <td class="text-left"><?php echo $m_item['menu_item_id']; ?></td>
                          <td class="text-left"><?php echo $m_item['name']; ?></td>
                          <td class="text-left"><?php echo $m_item['category']; ?></td>
                          <td class="text-left"><?php echo $m_item['parent']; ?></td>
                          <td class="text-left"><?php echo $m_item['position']; ?></td>
                          <td class="text-center">
                            <?php if ($m_item['parent'] > 0) { ?>
                            <?php echo $m_item['icon']; ?>
                            <?php } else { ?>
                            <i class="fa fa-<?php echo $m_item['icon']; ?> fa-2x"></i>
                            <?php } ?>
                          </td>
                          <td class="text-center">
                            <a href="<?php echo $m_item['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" data-menu_item_id="<?php echo $m_item['menu_item_id']; ?>" class="btn btn-danger action delete"><i class="fa fa-trash-o"></i></a>
                            <a href="<?php echo $m_item['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary edit"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                      <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </form>

              <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
              </div>

              <!-- PRINT SOME STUFF -->
              <?php echo '<pre>',print_r($gen_menu_data),'</pre>'; ?>

            </div>
          </div>

          <div class="tab-pane active" id="tab_setting">
            <div class="tab-body">
              <!-- SETTING TAB -->

              <div class="container-fluid">

              <div id="left-pane" style="float: left; width: 320px; height: 100%; margin-right: 10px;">
              </div>

                <div id="d_test" class="tab-pane">

                  <h3 class="page-header">
                      <span class="fa fa-book fa-fw"></span> <span><?php echo $text_edit; ?></span>
                  </h3>

                  <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th><?php echo $column_name; ?></th>
                        <th><?php echo $column_link; ?></th>
                        <th class="text-center"><?php echo $column_action; ?></th>
                      </tr>
                    </thead>

                    <tbody class="sortable table-sortable">
                    <?php $custom_item_row = 0; ?>
                    <?php foreach($menu_items as $sortable_mi) { ?>
                    <tr id="test_<?php echo $sortable_mi['menu_item_id'] ?>_input" class="sort-item" sort-data="<?php echo $sortable_mi['sort_order']; ?>">

                      <td>
                        <label class="" style="margin-bottom: 0px;">
                          <span class="btn btn-link"><i class="fa fa-bars"></i></span>
                          <span>
                            <?php if ($sortable_mi['parent'] > 0) { ?>
                            <?php echo $sortable_mi['icon']; ?>
                            <?php } else { ?>
                            <i class="fa fa-<?php echo $sortable_mi['icon']; ?> fa-lg"></i>
                            <?php } ?>
                          </span>
                        </label>
                      </td>
                      <td><?php echo $sortable_mi['name']; ?></td>

                      <td>
                        <select name="item_extra" class="form-control input-sm">
                          <?php foreach ($categories as $category) { ?>
                          <optgroup label="<?php echo $category['text']; ?>">
                          <?php if (!$category['extra']) { ?>
                          <!-- ? -->
                          <?php } else { ?>
                          <?php foreach ($category['extra'] as $ex_cat) { ?>
                          <option <?php echo ($ex_cat['edit'] == str_replace("/", ".", $sortable_mi['link'])) ? 'selected' : ''; ?> value="<?php echo $ex_cat['edit']; ?>"><?php echo $ex_cat['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                          </optgroup>
                          <?php } ?>
                        </select>
                      </td>

                      <td class="text-center">
                        <a href="<?php echo $sortable_mi['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" data-menu_item_id="<?php echo $sortable_mi['menu_item_id']; ?>" class="btn btn-danger action delete"><i class="fa fa-trash-o"></i></a>
                      </td>

                    </tr>
                    <?php $custom_item_row++; ?>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <td colspan="3"></td>
                        <td class="text-center"><button type="button" onclick="addNewMItem();" data-toggle="tooltip" title="<?php echo $button_create; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                      </tr>
                    </tfoot>

                  </table>

                  </div>
                </div>
              </div>

                <!-- PRINT SOME STUFF -->
                <?php echo '<pre>',print_r($sortable_menu_items),'</pre>'; ?>

            </div>
          </div>

          <div class="tab-pane" id="tab_supertest" >
            <div class="tab-body">

            <div id="menu_supertest">
            <link href="view/stylesheet/d_admin_menu/d_admin_menu.css" type="text/css" rel="stylesheet">
            <ul id="menu3">
              <?php foreach ($config['menus'] as $k_1=>$menu) { ?>

              <li id="first_<?php echo $k_1?>" data-sort="<?php echo $menu['sort_order']?>">

                  <?php if ($menu['href']) { ?>
                  <a href="<?php echo $menu['href'].$token; ?>"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                      <span><?php echo $menu['name']; ?></span></a>
                  <?php } else { ?>
                  <a class="parent"><i class="fa <?php echo $menu['icon']; ?> fw"></i>
                      <span><?php echo $menu['name']; ?></span></a>
                  <?php } ?>

                  <?php if ($menu['children']) { ?>
                  <ul>
                      <?php foreach ($menu['children'] as $k_2=>$children_1) { ?>
                      <li id="second_<?php echo $k_2?>" style="<?php echo ($children_1['is_visible'] == 0) ? 'display: none;' : ''; ?>" data-sort="<?php echo $children_1['sort_order']?>">
                          <?php if ($children_1['href']) { ?>
                          <a href="<?php echo $children_1['href'].$token; ?>"><?php echo $children_1['name']; ?></a>
                          <?php } else { ?>
                          <a class="parent"><?php echo $children_1['name']; ?></a>
                          <?php } ?>
                          <?php if ($children_1['children']) { ?>
                          <ul>
                              <?php foreach ($children_1['children'] as $k_3=>$children_2) { ?>
                              <li id="third_<?php echo $k_3?>" style="<?php echo ($children_2['is_visible'] == 0) ? 'display: none;' : ''; ?>" data-sort="<?php echo $children_2['sort_order']?>">
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


            </div>
          </div>

        </div>
      </div>
  </div>
</div>

<template id="additional_menu_item">
  <tr id="menu_item_id_<?php echo $m_item['menu_item_id']; ?>" class="{{text_status}}">
    <td class="text-center flash"><input type="checkbox" name="menu_item_id[]" value="{{menu_item_id}}" /></td>
    <td class="text-left flash">{{menu_item_id}}</td>
    <td class="text-left flash">{{name}}</td>
    <td class="text-left flash">{{category}}</td>
    <td class="text-left flash">{{parent}}</td>
    <td class="text-left flash">{{position}}</td>
    <td class="text-center flash">{{icon}}</td>
    <td class="text-center flash">
      <a href="{{delete}}" data-toggle="tooltip" title="<?php echo $button_delete; ?>" data-menu_item_id="{{menu_item_id}}" class="btn btn-danger action delete"><i class="fa fa-trash-o"></i></a>
      <a href="{{edit}}" data-toggle="tooltip" title="<?php echo $button_edit; ?>" data-menu_item_id="{{menu_item_id}}" class="btn btn-primary edit"><i class="fa fa-pencil"></i></a>
    </td>
  </tr>
</template>

<template id="additional_parent_item">
  <option value="{{menu_item_id}}">(id {{menu_item_id}}) {{name}}</option>
</template>

<template id="modal">
  <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
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

<style>
  .disable{
    display: none;
  }
  .enabled .disable{
    display: inline;
  }
  .enabled .enable{
    display: none
  }
  @-webkit-keyframes flash {

      50% {
          background-color: rgba(0,100,0,0.1);
      }

      100% {
          background-color: rgba(0,100,0,0);
      }
  }
  .flash {
      -webkit-animation-name: flash;
      -webkit-animation-duration: 2000ms;
      -webkit-animation-iteration-count: 1;
      -webkit-animation-timing-function: ease-in-out;
  }
  .failed .alert-success{
    display: none
  }
  .failed .alert-danger{
    display: block
  }
</style>

<script type="text/javascript">

  function handlebar_templating(some_html, some_json){
    var re = /{{([^}}]+)?}}/g, match;
    while(match = re.exec(some_html)) {
        some_html = some_html.replace(match[0], some_json[match[1]]);
    };
    return some_html;
  }

  $(document).on('click', '.create', function(){
    var that = this;
    $('#myModal').remove();
    var html = $('#modal').html();
    var json = {
      menu_item_id: 0,
      item_parent: '',
      item_position: '',
      item_icon: '',
      save: '<?php echo $create; ?>'
    };

    html = handlebar_templating(html, json);

    $('body').append(html);
    $('#myModal').modal('show');
    return false;
  });

  $(document).on('click', '.edit', function() {
    var that = this;
    var $menu_item_id = $(that).data('menu_item_id');
    $('#myModal').remove();

    $.ajax({
      url: $(that).attr('href'),
      type: 'get',
      data: '',
      dataType: 'json',
      success: function(json) {
        var html = $('#modal').html();

        html = handlebar_templating(html, json);

        $('body').append(html);
        $('#myModal').modal('show')
      }
    });
    return false;
  });

  $(document).on('click', '.save', function() {
    var that = this;
    var $menu_item_id = $(that).data('menu_item_id');
    var $data = $('#menu_item_form').serialize();

    $.ajax({
      url: $(that).attr('href'),
      type: 'post',
      data: $data,
      dataType: 'json',
      fail: function() {
          alert( "error" );
      },
      success: function(json) {
        console.log(json);
        $('#myModal').modal('hide');
        if(json['status'] == 1) {
          json['text_status'] = 'enabled';
        }else{
          json['text_status'] = '';
        }
        // var main_html = $('#additional_menu_item').html();

        // main_html = handlebar_templating(main_html, json);

        // if($menu_item_id == 0){
        //   $('#form-menu-item tbody').prepend(main_html);
        // }else{
        //   $('#menu_item_id_'+$menu_item_id).html($(main_html).html());
        // }
        location.reload();
      }
    });
    return false;
  });

  $(document).on('click', '.delete', function(){

    var data = $('#form-menu-item').serialize();
    var url_ = '<?php echo $delete; ?>';
    if ($(this).attr('href')) { url_ = $(this).attr('href');};

    $.ajax({
      url: url_,
      type: 'post',
      data: data,
      dataType: 'json',
      success: function(json) {
        if(json['deleted']){
          location.reload();
        }else{
          console.log('error!');
        }
      }
    });
    return false;
  });

  $('.sortable > tr').tsort({attr:'sort-data'});
  $(function () {

    $(".table-sortable").sortable({
        containerSelector: 'table',
        itemPath: '',
        itemSelector: 'tr',
        distance: '10',
        pullPlaceholder: false,
        placeholder: '<tr class="placeholder"><td colspan="5" /></tr>',
        onDragStart: function (item, container, _super) {
            var offset = item.offset(),
                    pointer = container.rootGroup.pointer

            adjustment = {
                left: pointer.left - offset.left,
                top: pointer.top - offset.top
            }

            _super(item, container)
        },
        onDrag: function (item, position) {
            item.css({
                left: position.left - adjustment.left,
                top: position.top - adjustment.top
            })
        },
        onDrop: function  (item, container, _super) {
            item.closest('tbody').find('tr').each(function (i, row) {
                console.log(i)
                $(row).find('.sort').val(i)

            })

            _super(item)
        }
    });
  });

</script>
<?php echo $footer; ?>
