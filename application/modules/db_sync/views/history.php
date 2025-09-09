<div class="box">
    <div class="box-header">
        <h3 class="box-title">DB Export/Import Record</h3>

        <div class="box-tools">
<!--            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
            </ul>-->
        </div>
    </div>

    <div class="box-body">  
        <div id="jquery-processing"></div>
        <table class="table table-bordered table-striped" id="history">
            <thead>
                <tr>
                    <th width="40">#</th>                    
                    <th>DB Sync Log | Timestamp</th>
                    <th width="90">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($db_sync_data as $db_sync) { ?>
                    <tr id="row_<?php echo $db_sync->id; ?>">
                        <td><?php echo $db_sync->id ?></td>                        
                        <td>			
                            <?php echo $db_sync->event_fired ?><br/>
                            <em class="small hidden"><code><?php echo $db_sync->db ?></code><br/></em>
                            <em class="small"> <?php echo globalDateTimeFormat($db_sync->created); ?></em>
                        </td>
                        <td>
                            <?php echo db_download_btn( $db_sync->file );?>
                            <?php echo db_restore_btn( $db_sync->file, $db_sync->db );?>                            
                            <span class="btn btn-xs btn-danger" onclick="deleteTable(<?php echo $db_sync->id .',\''. $db_sync->file .'\''; ?>);"><i class="fa fa-times"></i></span>                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>