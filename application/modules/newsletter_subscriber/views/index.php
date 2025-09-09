<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Newsletter Subscribers  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Subscribers</li>
    </ol>
</section>

<section class="content">
    <div class="row">    
        
        <div class="col-md-12">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        
        <div class="col-sm-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="box-body">                   
                    <form action="admin/newsletter_subscriber/create_action" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <label for="status">Status: &nbsp;&nbsp;</label>                           
                            <?php echo htmlRadio('status', 'Subscribe', ['Subscribe' => 'Subscribe', 'Unsubscribe' => 'Unsubscribe'])?>
                        </div>
                        
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <button type="reset" class="btn btn-default">Reset</button>                         
                    </form>
                </div>		
            </div>
            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-cloud-download"></i> Download Subscribers as CSV File
                    </h3>
                </div>

                <div class="box-body">                   
                    <form action="admin/newsletter_subscriber/export_csv" method="post">
                         
                        <div class="form-group">
                            <label for="status">Type: &nbsp;&nbsp;</label>                           
                            <?php echo htmlRadio('status', 'All', [
                                'All' => 'All',
                                'Subscribe' => 'Subscribe', 
                                'Unsubscribe' => 'Unsubscribe']
                               ); ?>
                        </div>                                                
                        <button type="submit" class="btn btn-primary">Download CSV</button>                                             
                    </form>
                </div>		
            </div>
            
            
        </div>


        <div class="col-sm-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="box-title">
                                <i class="fa fa-users" aria-hidden="true"></i> 
                                Subscriber List                    
                            </h2>
                        </div>


                        <div class="col-md-5 text-right pull-right">
                            <form action="<?php echo site_url(Backend_URL . 'newsletter_subscriber'); ?>" class="form-inline" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                    <span class="input-group-btn">
                                        <?php if ($q <> '') { ?>
                                            <a href="<?php echo site_url(Backend_URL . 'newsletter_subscriber'); ?>" class="btn btn-default">Reset</a>
                                        <?php } ?>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <div class="box-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50">#ID</th>                                
                                <th>Email</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subscribers as $subscriber) { ?>
                            <tr>
                                <td><?php echo sprintf('%05d',$subscriber->id) ?></td>
                                <td><?php echo $subscriber->email ?></td>
                                <td><?php echo $subscriber->name ?></td>                                
                                <td><?php echo $subscriber->status ?></td>
                                <td><?php echo globalDateFormat($subscriber->created) ?></td>
                                <td><?php echo globalDateFormat($subscriber->modified); ?></td>
                                <td>
                                    <?php
                                            echo anchor(site_url(Backend_URL . 'newsletter_subscriber/update/' . $subscriber->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                            echo anchor(site_url(Backend_URL . 'newsletter_subscriber/delete/' . $subscriber->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                            ?>
                                     
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>               
                </div>
                <div class="box-footer">
                    <div class="col-md-3">
                        <span class="btn btn-primary">Total Subscriber : <?php echo $total_rows ?></span>
                    </div>
                    <div class="col-md-9 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>