<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'job') ?>">Job</a></li>
        <li class="active">Make Payment</li>
    </ol>
</section>

<section class="content">
    <?php echo jobTabs($id, 'payment_form'); ?>
    <div class="box no-border">

        <div class="box-header with-border">
            <h3 class="box-title">Payment View</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="card">
                        <div class="card-header bg-success text-white"><h3>Payment Information</h3></div>
                        <div class="card-body bg-light">
                            <div id="payment-errors"></div>  
                            <form method="post" id="paymentFrm" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>  

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="email@you.com" required />
                                </div>
                                <div class="form-group">
                                    <input type="number" name="card_num" id="card_num" class="form-control number" placeholder="Card Number" autocomplete="off" required>
                                </div>

                                <div class="row">

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" name="exp_month" maxlength="2" class="form-control number" id="card-expiry-month" placeholder="MM" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" name="exp_year" class="form-control number" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control number" autocomplete="off" placeholder="CVC" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <input type="hidden" name="job_id" value="<?php $id;?>" />
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                    <button type="submit" id="payBtn" class="btn btn-success">Submit Payment</button>
                                </div>
                            </form>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>    

<script type="text/javascript">

    //set your publishable key
    Stripe.setPublishableKey('pk_test_tRoHr74FuGuljYM10pd7l40X');

    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {

        if (response.error) {
            //enable the submit button
            $('#payBtn').removeAttr("disabled");
            //display the errors on the form
            // $('#payment-errors').attr('hidden', 'false');
            $('#payment-errors').addClass('alert alert-danger');
            $("#payment-errors").html(response.error.message);
        } else {

            var stripeForm = $("#paymentFrm");
            //get token id
            var token = response['id'];
            //insert the token into the form
            stripeForm.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            //submit form to the server
            var dataPost = stripeForm.serialize();

            $.ajax({
                url: '<?php echo site_url('admin/job/make_payment'); ?>',
                type: "post",
                data: dataPost, //this is formData
                dataType: "json",
                cache: false,
                beforeSend: function () {
                    toastr.warning("Please Wait...");
                },
                success: function (response) {
                    // Remove current toasts using animation
                    toastr.clear();
                    if (response.success) {

                        stripeForm[0].reset();
                        $('#payment-errors').addClass('alert alert-success');
                        $('#payment-errors').text(response.message);
                        // Override global options
                        toastr.success(response.message, 'Success');

                    } else {
                        toastr.error(response.message, 'Invalid');
                        toastr.options.escapeHtml = true;

                        $('#payment-errors').addClass('alert alert-danger');
                        $('#payment-errors').text(response.message);
                    }
                }
            });


        }
    }

    $(document).ready(function () {
        //on form submit
        $("#paymentFrm").submit(function (event) {
            //disable the submit button to prevent repeated clicks
//            $('#payBtn').attr("disabled", "disabled");

            //create single-use token to charge the user
            Stripe.createToken({
                number: $('#card_num').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        });

    });
</script>