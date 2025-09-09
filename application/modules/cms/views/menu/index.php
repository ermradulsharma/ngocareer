<?php load_module_asset('cms','css'); ?>

<link href="assets/lib/plugins/Nestable/style.css" rel="stylesheet" type="text/css"/>

<section class="content-header">
    <h1> Menu Manager  <small>Control panel</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>        
        <li class="active">CMS</li>
    </ol>
</section>



<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Menu</h3>
        </div>

        <form method="post" id="menu_cr" 
              action="<?php echo base_url( Backend_URL . 'cms/menu/add_menu'); ?>" 
              class="form-inline">
           
            <div class="box-body">
                <div id="ajax_respond"></div>
                <?php echo $this->session->flashdata('message'); ?>
                <div class="form-group has-success">
                    <select class="form-control" name="select" id="change_menu_item">
                        <?php echo getMenuOptionData($id); ?>
                    </select>
                </div>

                <span style="cursor:pointer; color:#F00;" class="ajax_delete"
                      onClick="DeleteMenu(<?php echo $id; ?>);"> 
                    &larr; 
                    <i class="fa fa-trash-o"></i> 
                    Delete This Menu
                </span> 
                --Or-- 
                <span style="cursor:pointer; color:#00a65a;">
                    Create New :
                </span>
                
                
                <div class="form-group has-success">
                    <input type="text" name="new_menu" class="form-control" id="new_menu" placeholder="Menu Title" value="" required="required"> 
                </div>

                <div class="form-group has-success">
                    <button type="submit" class="btn btn-flat btn-block btn-success">
                        <i class="fa fa-save"></i> 
                        Create
                    </button>
                </div>
                
            </div>            
        </form> 
    </div>

    <div class="row">        
        <div class="col-md-4">
            <form method="post" id="menu_cr" action="<?php echo base_url( Backend_URL . 'cms/menu/add_page_to_menu'); ?>" class="form-inline">
                <input name="id" id="menu_id" type="hidden" value="<?php echo $id; ?>"/>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <label>
                                <input type="checkbox" id="checkAll"/> 
                                Pages
                            </label>
                        </h3>                        
                    </div>

                    <div class="box-body">
                        <div class="scrolling">                            
                            <?php echo $pages; ?>        
                        </div>                        
                    </div>
                    <div class="box-footer text-right">                                                    
                        <button type="submit" class="btn btn-primary">
                            Add to Menu
                        </button>
                    </div>
                </div>
            </form>

            <div class="clearfix"></div>

            <form method="post" id="menu_ca" action="<?php echo base_url( Backend_URL . 'cms/menu/add_category_to_menu'); ?>" class="form-inline">
                <input name="id" id="menu_id" type="hidden" value="<?php echo $id; ?>"/>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <label>
                                <input type="checkbox" id="catCheckAll"/>
                                Categories
                            </label>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="scrolling">                            
                            <?php echo $categories; ?>
                        </div>                        
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            Add to Menu
                        </button>
                    </div>
                </div>
            </form>

            
            <div class="clearfix"></div>

            <form class="form-horizontal" method="post" id="menu_cl" action="<?php echo base_url( Backend_URL . 'cms/menu/add_custom_link_to_menu'); ?>" class="form-inline">
                <input name="id" id="menu_id" type="hidden" value="<?php echo $id; ?>"/>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Custom Links</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>URL</label>
                            </div>
                            <div class="col-md-9">
                                <input type="url" class="form-control" name="url" id="url" required>
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Link Text</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            Add to Menu
                        </button>
                    </div>
                </div>
            </form>

        </div>


        <div class="col-md-8">
            <div class="box box-primary">
                <form method="post" id="menu_cr_rename" action="#" class="form-inline">
                <div class="box-header with-border">
                    <h3 class="box-title">Drag Drop Menu Builder. <em class="text-red">(Maximum 3 Level Nested Supported)</em></h3>
                </div>
                
                <div class="box-body">
                    <div id="respond_save_order"></div>
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            <?php echo getMenuPages($menus); ?>
                        </ol>
                    </div>
                </div>
                    <div class="box-body hidden">
                        <textarea id="nestable-output"></textarea>
                    </div>
                <div class="box-footer text-right">
                    <button type="button" id="save_menu_order" class="btn btn-primary">
                        Save Ordering
                    </button>
                </div>
                </form>
            </div>	
        </div>
    </div>
    
    <div class="modal fade" id="edit_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="menu_edit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Edit Menu Title</h4>
                    </div>

                    <div class="modal-body">
                        <div class="js_update_respond"></div>
                        <div class="edit_box"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span> Close
                        </button>
                        <button type="button" class="btn btn-primary" id="saveMenuTitle">                            
                            Save                            
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    
</section>

<script src="assets/lib/plugins/Nestable/jquery.nestable.js" type="text/javascript"></script>
<?php load_module_asset('cms','js','menu.js.php');?>