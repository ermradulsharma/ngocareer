<?php if (isset($files) && count($files)){?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>CV Title</th>            
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $row = 1;
        foreach ($files as $key => $file) {
            ?>
            <tr id="row_<?php echo $file->id;?>">
                <th scope="row"><?php echo $row;?></th>                
                <td><?php echo $file->orig_name; ?></td>
                <td width="320" class="text-center">
                    <button type="button" class="btn btn-xs btn-danger delete_file_link" 
                            data-file_id="<?php echo $file->id; ?>">
                        <i class="fa fa-times"></i> 
                        Delete
                    </button>
                    
                    <a href="<?php echo site_url('my_account/download/'.$file->id); ?>" 
                       class="btn btn-success btn-xs" data-file_id="<?php echo $file->id?>">
                        <i class="fa fa-download"></i>
                        Download
                    </a>
                    
                    <a href="<?php echo googlePreviewLink( $file->id ); ?>" 
                       class="btn btn-info btn-xs" target="_blank" 
                       data-file_id="<?php echo $file->id; ?>">  
                        <i class="fa fa-external-link"></i> 
                        Preview
                        
                    </a>
                </td>
            </tr>
            <?php
            $row++;
        }
        ?>
    </tbody>
</table>
<?php } ?>