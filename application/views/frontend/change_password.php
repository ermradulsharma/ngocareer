<div class="change-password">
    <h3>Change Password</h3>
</div>

<div id="message">
    <?php echo $this->session->flashdata('message'); ?>
</div>

<form method="POST" class="form-horizontal" role="form" id="change_pwd" action="">

    <div class="col-md-12">
        <div class="form-group">
            <div id="ajax_respond"></div>
        </div>

        <div class="form-group">
            <label for="old_pass">Current Password</label>
            <input autocomplete="off" type="password" name="old_pass" id="old_pass" class="form-control">
        </div>

        <div class="form-group">
            <label for="new_pass">New Password</label>
            <input autocomplete="off" type="password" name="new_pass" id="new_pass" class="form-control">
        </div>

        <div class="form-group">
            <label for="con_pass">Confirm Password</label>
            <input autocomplete="off" type="password" name="con_pass" id="con_pass" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="personalSubmit">Update</button>
        </div>
    </div>
</form>


<script type="text/javascript">
    $(document).on('submit', '#change_pwd', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var error = 0;

        var old_pass = $('#old_pass').val();
        if (!old_pass) {
            $('#old_pass').addClass('required');
            error = 1;
        } else {
            $('#old_pass').removeClass('required');
        }

        var new_pass = $('#new_pass').val();
        if (!new_pass) {
            $('#new_pass').addClass('required');
            error = 1;
        } else {
            $('#new_pass').removeClass('required');
        }

        var con_pass = $('#con_pass').val();
        if (!con_pass) {
            $('#con_pass').addClass('required');
            error = 1;
        } else {
            $('#con_pass').removeClass('required');
        }

        if (!error) {
            jQuery.ajax({
                url: 'student_portal/change_password_action',
                type: "POST",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Updating...</p>')
                        .css('display', 'block');
                },
                success: function (jsonRespond) {
                    jQuery('#ajax_respond').html(jsonRespond.Msg);
                    if (jsonRespond.Status === 'OK') {
                        document.getElementById("change_pwd").reset();
                        setTimeout(function () {
                            jQuery('#ajax_respond').slideUp('slow');
                        }, 2000);
                    }
                }
            });
        }
    });
</script>