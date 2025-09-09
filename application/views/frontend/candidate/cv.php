<h3 class="page-header">CV Attachment</h3>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" name="upload_file" id="upload_file" method="POST">

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">CV Title <span>*</span></label>
                <div class="col-md-6">
                    <input class="form-control" id="title" name="title"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Upload CV <span>*</span></label>
                <div class="col-md-6">
                    <label class="btn btn-info btn-file">
                        Browse..<input type="file" id="upload_cv" name="upload_cv" accept=".doc,.docx,.pdf" onchange="validate_file();">
                    </label>
                    <h3>Standard file uploading guideline.</h3>
                    <span class="help-block">File must be less than 2MB.</span>
                    <span class="help-block">File format should be .pdf, .doc or .docx.</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4" for="title"></label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary text-center"><i class="fa fa-upload"></i> Upload </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="files"></div>
    </div>
</div>

<script type="text/javascript">
    //form validation
    function validate() {
        return validate_file();
    }

    function validate_file() {
        var file_err = 'file_err';
        var upload_cv = $('#upload_cv');
        var file = $('#upload_cv')[0].files[0]; //for single file upload
        //hide previous error
        $("#" + file_err).html("");
        //Multiple File Upload

        if (file === undefined) {
            upload_cv.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please upload CV(.doc, .docx, .pdf) File</p></span>');
            return false;
        } else {
            $("#" + file_err).html("");
        }

        var fileType = file.type; // holds the file types
        var match = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword"]; // defined the file types
        var fileSize = file.size; // holds the file size
        var maxSize = 2 * 1024 * 1024; // defined the file max size

        // Checking the Valid Image file types  
        if (!((fileType === match[0]) || (fileType === match[1]) || (fileType === match[2])))
        {
            upload_cv.val("");
            upload_cv.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please select a valid (.doc, .docx, .pdf) file.</p></span>');
            return false;
        } else {
            $("#" + file_err).html("");
        }
        // Checking the defined image size
        if (fileSize > maxSize)
        {
            upload_cv.val("");
            upload_cv.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please select ' + file.name + ' file less than 2mb of size.</p></span>');
            return false;
        } else {
            $("#" + file_err).html("");
        }

    }

    $('#upload_file').submit(function (e) {
        e.preventDefault();
        var error    = 0;

        var title = jQuery('#title').val();
        if(!title){
            jQuery('#title').addClass('required');
            error = 1;
        } else{
            jQuery('#title').removeClass('required');
        }
        if(!error) {
            $.ajax({
                url: '<?php echo site_url('my_account/cv_upload'); ?>',
                type: "post",
                data: new FormData(this), //this is formData
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function () {
                    toastr.success('Please Wait...');
                },
                success: function (data) {
                    //received this text from a web server:
                    var response = JSON.parse(data);
                    if (response.status !== 'error') {
                        toastr.clear();
                        toastr.success(response.msg);
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.clear();
                        toastr.error(response.msg);
                    }

                }
            });
        }

        return false;
    });

    function refresh_files()
    {
        $.get("<?php echo site_url('my_account/files'); ?>")
                .success(function (data) {
                    $('#files').html(data);
                });
    }
    refresh_files();

    $(document).on('click', '.delete_file_link', function (e) {
        e.preventDefault();
        if (confirm('Are you sure, you want to remove your CV!?')){
            var link = $(this);
            var file_id = link.data('file_id');
            $.ajax({
                url: '<?php echo site_url('my_account/delete_file/'); ?>' + file_id,
                dataType: 'json',
                success: function (data){
                    var files = $("#files");
                    if (data.status === "success"){
                        link.parents('tr').fadeOut('fast', function () {
                            $("#row_" + file_id).closest("tr").remove();
                            if (files.find('tr').length === 0)
                            {
                                files.html('<tr><td>No Files Uploaded</td>tr>');
                            }
                        });
                    } else {
                        $('#respond').html('<p class="ajax_processing">' + data.msg + '</p>');
                    }
                }
            });
        }
    });
</script>