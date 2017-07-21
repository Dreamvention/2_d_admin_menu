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
          <li class="active"><a href="#tab_module" data-toggle="tab">
            <span class="fa fa-plug"></span>
            <?php echo $tab_module; ?>
          </a></li>

          <li><a href="#tab_setting" data-toggle="tab">
            <span class="fa fa-cog"></span>
            <?php echo $tab_setting; ?>
          </a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_event" >
            <div class="tab-body">

              <div id="filter" class="well">
                <div class="row">
                  <!-- FILTER -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                      <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" data-item="name"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                      <input type="text" name="filter_parent" value="<?php echo $filter_parent; ?>" placeholder="<?php echo $entry_parent; ?>" id="input-parent" class="form-control" data-item="parent"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                      <select name="filter_status" id="input-status" class="form-control">
                        <option value="*"></option>
                        <?php if ($filter_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <?php } ?>
                        <?php if (!$filter_status && !is_null($filter_status)) { ?>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                  </div>
                </div>
              </div>

              <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-event">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'menu_item_id\']').prop('checked', this.checked);" /></td>
                        <td class="text-left">
                          <?php if ($sort == 'name') { ?>
                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
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
                          <?php if ($sort == 'icon') { ?>
                            <a href="<?php echo $sort_icon; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_icon; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_icon; ?>"><?php echo $column_icon; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <?php if ($sort == 'status') { ?>
                            <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                          <?php } ?>
                        </td>
                        <td class="text-right"><?php echo $column_action; ?></td>
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
                          <td class="text-left"><?php echo $m_item['name']; ?></td>
                          <td class="text-left"><?php echo $m_item['parent']; ?></td>
                          <td class="text-left"><?php echo $m_item['icon']; ?></td>
                          <td class="text-left">
                            <span class="label label-success disable" ><?php echo $text_enabled; ?></span>
                            <span class="label label-danger enable" ><?php echo $text_disabled; ?></span>
                          </td>
                          <td class="text-right">
                            <a href="<?php echo $m_item['enable']; ?>" data-toggle="tooltip" title="<?php echo $button_enable; ?>" data-menu_item_id="<?php echo $m_item['menu_item_id']; ?>" class="btn btn-success action enable"><i class="fa fa-thumbs-o-up"></i></a>
                            <a href="<?php echo $m_item['disable']; ?>" data-toggle="tooltip" title="<?php echo $button_disable; ?>" data-menu_item_id="<?php echo $m_item['menu_item_id']; ?>" class="btn btn-danger action disable"><i class="fa fa-thumbs-o-down"></i></a>
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
              <?php echo '<pre>',print_r(''),'</pre>'; ?>

            </div>
          </div>

          <div class="tab-pane" id="tab_setting">
            <div class="tab-body">
              <!-- SETTING TAB -->
            </div>
          </div>

        </div>
      </div>
  </div>
</div>

<template id="modal">
  <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit menu item <b>{{name}}</b> </h4>
        </div>
        <div class="modal-body">
          <form id="event_form" class="form-horizontal">

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_text"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                  <select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control input-sm">
                    <?php foreach ($categories as $category) { ?>
                    <optgroup label="<?php echo $category['text']; ?>">
                    <?php if (!$category['extra']) { ?>
                    <?php } else { ?>
                    <?php foreach ($category['extra'] as $ex_cat) { ?>
                    <option value="<?php echo $ex_cat['shortname']; ?>"><?php echo $ex_cat['name']; ?></option>
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
                <input type="text" name="parent" value="{{parent}}" placeholder="<?php echo $entry_parent; ?>" id="input-width" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input_action"><?php echo $entry_icon; ?></label>
              <div class="col-sm-10">
                <input type="text" name="icon" value="{{icon}}" placeholder="<?php echo $entry_icon; ?>" id="input-width" class="form-control" />
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

  $(document).on('click', '.create', function(){
    var that = this;
    $('#myModal').remove();
    var html = $('#modal').html();
    var json = {
      menu_item_id: 0,
      name: '',
      parent: '',
      icon: '',
      save: '<?php echo $create; ?>'
    };

    //templating like handlebars
      var re = /{{([^}}]+)?}}/g, match;
      while(match = re.exec(html)) {
          html = html.replace(match[0], json[match[1]]);
      };

    $('body').append(html);
    $('#myModal').modal('show');

    return false;

  });

  $(document).on('click', '.action', function() {
    var that = this;
    var $menu_item_id = $(that).data('menu_item_id');
    $.ajax({
      url: $(that).attr('href'),
      dataType: 'json',
      success: function(json) {
        if(json['enabled']){
          $('#menu_item_id_'+$menu_item_id).find('.enable').hide();
          $('#menu_item_id_'+$menu_item_id).find('.disable').show();
        }else{
          $('#menu_item_id_'+$menu_item_id).find('.enable').show();
          $('#menu_item_id_'+$menu_item_id).find('.disable').hide();
        }
      }
    });
    return false;
  });

  // category load
  $('select[name="type"]').on('change', function() {
    $.ajax({
      url: $('select[name="type"]').val(),
      dataType: 'html',
      beforeSend: function() {
        $('.fa-filter').addClass('fa-circle-o-notch fa-spin');
        $('.fa-filter').removeClass('fa-filter');
      },
      complete: function() {
        $('.fa-circle-o-notch').addClass('fa-filter');
        $('.fa-circle-o-notch').removeClass('fa-circle-o-notch fa-spin');
      },
      success: function(html) {
        $('#extension').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });


</script>
<?php echo $footer; ?>
