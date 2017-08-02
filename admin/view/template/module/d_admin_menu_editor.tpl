<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="form-inline pull-right">
                <button id="save_and_stay" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $save_and_stay; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">

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

                                    <div class="col-sm-12">

                                    <!-- STANDART MENU -->
                                    <div class="panel-group col-sm-5">
                                    <h3 class="page-header">
                                        <span class="fa fa-bookmark-o fa-fw"></span> <span><?php echo $text_standart_menu; ?></span>
                                    </h3>
                                    <div id="standart-menu">
                                      <div class="dd nestable" id="nestable-standart">
                                        <?php echo $standart_menu; ?>
                                      </div>
                                    </div>
                                    </div>

                                    <!-- CUSTOM MENU -->
                                    <div class="panel-group col-sm-7" style="float: right;">
                                    <h3 class="page-header">
                                        <span class="fa fa-bookmark fa-fw"></span> <span><?php echo $text_custom_menu; ?></span>
                                    </h3>
                                    <div id="custom-menu">
                                      <div class="dd nestable" id="nestable-custom">
                                        <?php echo $custom_menu; ?>
                                      </div>
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
                              <?php echo "<pre>"; print_r($setting); echo "</pre>"; ?>
                          </div>
                      </div>

                  </div>

                </form>
            </div>
        </div>



    </div>

</div>

<script>

  function handlebar_templating(some_html, some_json)
  {
    var re = /{{([^}}]+)?}}/g, match;
    while(match = re.exec(some_html)) {
        some_html = some_html.replace(match[0], some_json[match[1]]);
    };
    return some_html;
  }

  function updateOutput(e)
  {
      var list   = e.length ? e : $(e.target),
          output = list.data('output');
      if (window.JSON) {
          output.val(window.JSON.stringify(list.nestable('serialize')));
      } else {
          output.val('JSON browser support required for this demo.');
      }
  };

  function changeCustomItemsType(serialize_data)
  {

    for (var i = serialize_data.length - 1; i >= 0; i--) {
      if ("children" in serialize_data[i]) {

        $('#dd_custom_' + serialize_data[i]['id'] + ' > .dd-handle .item-link').css('display', 'none');

        // second children
        for (var ii = serialize_data[i]['children'].length - 1; ii >= 0; ii--) {
          if ("children" in serialize_data[i]['children'][ii]) {
            $('#dd_custom_' + serialize_data[i]['children'][ii]['id'] + ' > .dd-handle .item-link').css('display', 'none');
          } else {
            $('#dd_custom_' + serialize_data[i]['children'][ii]['id'] + ' > .dd-handle .item-link').css('display', 'inline-block');
          }
        }

      } else {
        $('#dd_custom_' + serialize_data[i]['id'] + ' > .dd-handle .item-link').css('display', 'inline-block');
      }

    }
  }

  $(document).ready(function()
  {

      $('#nestable-standart').nestable_nodrag({maxDepth: '3', group: "standart"});

      $('#nestable-custom').nestable({maxDepth: '3', group: "custom"})
      .on('change', function(){
        // updateOutput($('#nestable-custom').data('output', $('#nestable-output-custom')));
        changeCustomItemsType($('#nestable-custom').nestable('serialize'));
      });

      changeCustomItemsType($('#nestable-custom').nestable('serialize'));
      $('#nestable-standart').nestable_nodrag('collapseAll');
      $('#nestable-custom').nestable('collapseAll');

      $('[data-bs="true"]').bootstrapSwitch();
      $('[data-bs="true"]').on('switchChange.bootstrapSwitch', function(event, state) {

        var tmp_vis = 1;
        if (state == true) { tmp_vis = 1; } else { tmp_vis = 0; };
        $(this).val(tmp_vis);

        var jsn = {
          'menus-data': $('#form').serializeObject(),
        };

        // $('#nestable-output-standart').text(JSON.stringify(jsn));
      });

      // restore default setting (standart-menu)
      $('#button-restore-standart').on('click', function() {
        $('[data-bs="true"]').each(function() {
          $(this).bootstrapSwitch('state', true, true);
        });
      });

      // collapse-expand buttons
      $('#button-collapse-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('collapseAll'); });

      $('#button-expand-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('expandAll'); });

      $('#button-collapse-custom').on('click', function()
      { $('#nestable-custom').nestable('collapseAll'); });

      $('#button-expand-custom').on('click', function()
      { $('#nestable-custom').nestable('expandAll'); });


      // add new custom element (button)
      $('#button-add-custom').on('click', function()
      {
        var tmp_new_id = 0;
        $('.custom-removebtn').each(function() {
          if ($(this).data('delId') > tmp_new_id) {
            tmp_new_id = $(this).data('delId');
          }
        });
        tmp_new_id = tmp_new_id + 1;

        var html = $('#new_custom_item').html();
        var tmp_json = {
          new_custom_id: tmp_new_id
        };
        html = handlebar_templating(html, tmp_json);
        $('.main-custom-list').append(html);
        console.log('create custom element ID: ', tmp_new_id);

        // iconpicker re-init
        $('.supericon-yep').each(function() {
          $(this).iconpicker();
        });

        return false;
      });

      // remove custom element
      $(document).on('click','.custom-removebtn', function() {
        $(('#dd_custom_' + $(this).data('delId'))).remove();
        console.log('removing custom element ID: ', $(this).data('delId'));
      });


      // iconpicker init
      $('.supericon-yep').each(function() {
        $(this).iconpicker();
      });

      // icon input update
      $(document).on('iconpickerSelected', '.icp', function(e) {
        $("input[name='custom-menu[" + $(this).data('id') +"][icon]']").val(e.iconpickerValue);
      });


  });

  $(document).on('click', '#save_and_stay', function() {

    var jsn = {
      'menus-data': $('#form').serializeArray(),
      'custom-nested-data': $('#nestable-custom').nestable('serialize')
    };

    $.ajax({
        type: 'post',
        url: $('#form').attr('action') + '&save',
        data: jsn,
        beforeSend: function() {
            $('#form').fadeTo('slow', 0.5);
        },
        complete: function() {
            $('#form').fadeTo('slow', 1);
        },
        success: function(response) {
            console.log(response);
        }
    });
  });


</script>

<?php echo $footer; ?>
