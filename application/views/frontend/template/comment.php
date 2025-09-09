<style type="text/css">
    .comment_area {
        color: black;
    }

    .comment_area textarea, .comment_area input {
       
    }

    .comment_area label {
        font-weight: bold;
    }

    .card-inner {
        margin-left: 4rem;
    }

    .reply_cancel_btn {
        cursor: pointer;
        font-size: 14px;
        margin-left: 15px;
        color: red;
    }
</style>

<?php echo getCommentList($post_id); ?>

<div class="comment_area post-content contact-form">
    <div id="comment_ajax_respond"></div>
    <h3 id="comment_header">Leave a Reply</h3>
    <?php if (getSettingItem('LoggedInRequiredForComment') == 'Yes' && getLoginUserData('user_id') == 0): ?>
        <p>You must be <a href="<?php echo site_url('sign-in'); ?>">logged in</a> to post a comment</p>
    <?php else: ?>
        <p>Required fields are marked <sup>*</sup></p>
        <form action="" method="post" id="comment_form">

            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="0">

            <div class="form-group">
                <label for="comment">Comment<sup>*</sup></label>
                <textarea id="comment" name="comment" rows="8" maxlength="2000"
                          class="form-control"></textarea>
            </div>

            <?php if (getLoginUserData('user_id') == 0): ?>

                <div class="form-group">
                    <label for="name">Name<sup>*</sup></label>
                    <input type="text" name="name" id="name" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="email">Email<sup>*</sup></label>
                    <input type="email" name="email" id="email" class="form-control" value="">
                </div>

            <?php endif; ?>

            <div class="clearfix"></div>

            <div class="form-group">
                <button type="button" onclick="addComment();" class="btn btn-primary">Post Comment</button>
            </div>

        </form>
    <?php endif; ?>
</div>

<script type="text/javascript">
    function commentReplyForm(id, name) {
        var namehtml = "Reply to " + name + " <span class='reply_cancel_btn' onclick='commentReplyCancel()'>Cancel reply</span>";
        $('#comment_form #parent_comment_id').val(id);
        $('.comment_area #comment_header').html(namehtml);
    }

    function commentReplyCancel() {
        $('#comment_form #parent_comment_id').val(0);
        $('.comment_area #comment_header').html('Leave a Reply');
    }

    function addComment() {
        var formData = $('#comment_form').serialize();
        var error = 0;

        var comment = $('#comment').val();
        if (!comment) {
            $('#comment').addClass('required');
            error = 1;
        } else {
            $('#comment').removeClass('required');
        }

        <?php if(getLoginUserData('user_id') == 0): ?>
        var name = $('#name').val();
        if (!name) {
            $('#name').addClass('required');
            error = 1;
        } else {
            $('#name').removeClass('required');
        }

        var email = $('#email').val();
        if (!email) {
            $('#email').addClass('required');
            error = 1;
        } else {
            $('#email').removeClass('required');
        }
        <?php endif; ?>

        if (!error) {
            $.ajax({
                type: "POST",
                url: "comment/add_comment",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    $('#comment_ajax_respond').css('display', 'block');
                    $('#comment_ajax_respond').html('<p class="ajax_processing">Processing...</p>');
                },
                success: function (jsonData) {
                    $('#comment_ajax_respond').html(jsonData.Msg);
                    if (jsonData.Status === 'OK') {
                        document.getElementById("comment_form").reset();
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        } else {
            return false;
        }
    }
</script>