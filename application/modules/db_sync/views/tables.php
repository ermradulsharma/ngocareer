<div class="box">
    <div class="box-header with-border">
        <h3 class="panel-title">
            <i class="fa fa-list"></i> <b> Database Table List </b>
        
        
            <button id="backup_full_db" class="btn btn-success pull-right">
                <i class="fa fa-cloud-download"></i> 
                Backup Full DB
            </button>
        </h3>
        
                                
                                                                                             
                 
            
        
    </div>

    <div class="box-body"> 
        
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40">ID</th>                                
                    <th>Table Name</th>
                    <th>Columns</th>
                    <th>Rows</th>
                    <th width="140">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $sl => $table) { ?>
                    <tr>                    
                        <td><?php echo $sl + 1; ?></td>
                        <td><?php echo $table; ?></td>
                        <td><?php echo countColumns($table); ?></td>
                        <td><?php echo countRows($table); ?></td>
                        <td>
                            <button class="btn btn-xs btn-default" onclick="exportTable('<?php echo $table; ?>');"><i class="fa fa-hdd-o"></i> Backup </button>
                             
                            <?php echo getTableTruncateButton( $table );?>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 


