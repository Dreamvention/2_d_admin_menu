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
                                          <button type="button" class="btn btn-default iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
                                          <button type="button" class="icp icp-dd btn dropdown-toggle supericon" data-selected="fa-car" data-toggle="dropdown">
                                              <span class="caret"></span>
                                              <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu"></div>
                                      </div>
                                  </div>


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
                                      <br/><br/><br/><br/>
                                      <textarea id="nestable-output-standart"></textarea>
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
                          <button id="serializeForm" class="btn btn-success" type="button">CLICK TO SERIALIZE</button>
                              <?php echo $text_instruction; ?>
                          </div>
                      </div>

                  </div>



                </form>
            </div>
        </div>



    </div>

</div>


<script>
  $.fn.serializeObject = function() {
       var o = {};
       var a = this.serializeArray();
       $.each(a, function() {
           if (o[this.name] !== undefined) {
               if (!o[this.name].push) {
                   o[this.name] = [o[this.name]];
               }
               o[this.name].push(this.value || '');
           } else {
               o[this.name] = this.value || '';
           }
       });
       return o;
     };
</script>

<script>

  $(document).ready(function()
  {

      $('#nestable-standart').nestable_nodrag({maxDepth: '3', group: "standart"});

      $('#nestable-custom').nestable({maxDepth: '3', group: "custom"});

      $('#nestable-standart').nestable_nodrag('collapseAll');
      $('#nestable-custom').nestable('collapseAll');

      $('[data-bs="true"]').bootstrapSwitch();
      $('[data-bs="true"]').on('switchChange.bootstrapSwitch', function(event, state) {

        var tmp_vis = 1;
        if (state == true) { tmp_vis = 1; } else { tmp_vis = 0; };
        $(this).val(tmp_vis);

        var jsn = {
          'standart-menu-data': $('#form').serializeObject(),
          'custom-menu-data': ''
        };

        $('#nestable-output-standart').text(JSON.stringify(jsn));

      });



      // collapse-expand buttons
      $('#button-collapse-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('collapseAll'); });

      $('#button-expand-standart').on('click', function()
      { $('#nestable-standart').nestable_nodrag('expandAll'); });

      $('#button-collapse-custom').on('click', function()
      { $('#nestable-custom').nestable_nodrag('collapseAll'); });

      $('#button-expand-custom').on('click', function()
      { $('#nestable-custom').nestable_nodrag('expandAll'); });


      // add new custom element
      $('#button-add-custom').on('click', function()
      {

      });


      // iconpicker
      $('.supericon').iconpicker();
      $('.icp').on('iconpickerSelected', function(e) {
        $('.superinput').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        // Events sample:
        // This event is only triggered when the actual input value is changed
        // by user interaction
        // $('.icp').on('iconpickerSelected', function(e) {
        //     $('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
        //             e.iconpickerInstance.options.iconBaseClass + ' ' +
        //             e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
        // });
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





</script>

<?php echo $footer; ?>
