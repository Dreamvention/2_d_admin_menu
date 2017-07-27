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
                                  <li class="active">
                                    <a href="#d_home" data-toggle="tab">
                                      <span class="fa fa-home fa-fw"></span> <span><?php echo $text_home; ?></span>
                                    </a>
                                  </li>
                                  <?php if($setting_id) { ?>
                                  <li>
                                    <a href="#d_standart_menu" data-toggle="tab">
                                      <span class="fa fa-bookmark-o fa-fw"></span> <span><?php echo $text_standart_menu; ?></span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="#d_custom_menu" data-toggle="tab">
                                      <span class="fa fa-bookmark fa-fw"></span> <span><?php echo $text_custom_menu; ?></span>
                                    </a>
                                  </li>
                                  <?php } ?>
                                </ul>
                              </div>

                              <div class="col-sm-10">
                                <div class="tab-content">

                                  <div id="d_home" class="tab-pane active">
                                    <div class="page-header">
                                        <h3><span class="fa fa-home"></span> <span><?php echo $text_home; ?></span></h3>
                                    </div>
                                    <?php if(!$settings){ ?>
                                    <div class="bs-callout bs-callout-warning"><?php echo $text_intro_create_setting; ?></div>
                                    <?php } ?>
                                    <div class="row">
                                    <!-- HOME CONTENT -->
                                    </div>
                                  </div>

                                  <div id="d_standart_menu" class="tab-pane">
                                    <h3 class="page-header">
                                        <span class="fa fa-truck fa-fw"></span> <span><?php echo $text_standart_menu; ?></span>
                                    </h3>
                                    <div class="table-responsive">

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

<?php echo $footer; ?>
