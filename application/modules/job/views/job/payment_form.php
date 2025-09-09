<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job  <small>Payment</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'job') ?>">Job</a></li>
        <li class="active">Make Payment</li>
    </ol>
</section>
<style type="text/css">

    /* CSS for Credit Card Payment form */
    .credit-card-box .panel-title {
        display: inline;
        font-weight: bold;
    }
    .credit-card-box .form-control.error {
        border-color: red;
        outline: 0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
    }
    .credit-card-box label.error {
        font-weight: bold;
        color: red;
        padding: 2px 8px;
        margin-top: 2px;
    }
    .credit-card-box .payment-errors {
        font-weight: bold;
        /*color: red;*/
        padding: 5px 8px;
        margin-top: 10px;
    }
    .credit-card-box label {
        display: block;
    }
    /* The old "center div vertically" hack */
    .credit-card-box .display-table {
        display: table;
    }
    .credit-card-box .display-tr {
        display: table-row;
    }
    .credit-card-box .display-td {
        display: table-cell;
        vertical-align: middle;
        width: 50%;
    }
    /* Just looks nicer */
    .credit-card-box .panel-heading img {
        min-width: 180px;
    }
   
</style>

<section class="content">
    <?php echo jobTabs($id, 'payment_form'); ?>
    <div class="box no-border">

        <div class="box-header with-border">
            <h3 class="box-title">Payment View</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-5 col-md-offset-3">
                    <!-- CREDIT CARD FORM STARTS HERE -->
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading">
                            <div class="row display-tr">
                                <h3 class="panel-title display-td">Payment Details</h3>
                                <div class="display-td">                            
                                    <img class="img-responsive pull-right" src="assets/admin/dist/img/credit/accepted_c22e0.png">
                                </div>
                            </div>                    
                        </div>
                        <div class="panel-body">
                             <form method="post" id="paymentFrm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="card-num">CARD NUMBER</label>
                                            <div class="input-group">
                                                <input 
                                                    type="text"
                                                    class="form-control number"
                                                    name="card_num"
                                                    id="card-num"
                                                    placeholder="Valid Card Number"
                                                    autocomplete="off"
                                                    maxlength="16"
                                                    required autofocus 
                                                    />
                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <div class="form-group input-group">
                                            <label for="card-expiry-month"><span class="hidden-xs">EXP MONTH</span></label>
                                            <input 
                                                type="text"
                                                class="form-control number" 
                                                name="card-expiry-month"
                                                id="card-expiry-month"
                                                placeholder="MM"
                                                autocomplete="off"
                                                maxlength="2"
                                                required 
                                                />

                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <div class="form-group input-group">
                                            <label for="card-expiry-year"><span class="hidden-xs">EXP YEAR</span></label>
                                            <input 
                                                type="text" 
                                                class="form-control number" 
                                                name="exp_year"
                                                id="card-expiry-year"
                                                placeholder="YYYY"
                                                autocomplete="off"
                                                maxlength="4" 
                                                required 
                                                />
                                        </div>
                                    </div>

                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="card-cvc">CV CODE</label>
                                            <input 
                                                type="text" 
                                                class="form-control number"
                                                name="cvc"
                                                id="card-cvc"
                                                placeholder="CVC"
                                                autocomplete="off"
                                                maxlength="3"
                                                required
                                                />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="email">EMAIL ADDRESS</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $email;?>" />
                                        </div>
                                    </div>                        
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="job_id" value="<?php echo $id; ?>" />
                                        <button class="btn btn-success btn-lg btn-block" id="payBtn" type="submit">Pay <?php echo globalCurrencyFormat($payment_data->price)?></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="payment-errors" id="payment-errors"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>            
                    <!-- CREDIT CARD FORM ENDS HERE -->
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
            $('#payBtn').attr("disabled", "disabled");

            //create single-use token to charge the user
            Stripe.createToken({
                number: $('#card-num').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        });
        
        // only numbers are allowed
        $(".number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+v, Command+V
                (e.keyCode === 118 && ( e.ctrlKey === true || e.metaKey === true ) ) ||

                // Allow: Ctrl+V, Command+V
                (e.keyCode === 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||

                // Allow: Ctrl+A, Command+V
                ((e.keyCode === 65 || e.keyCode === 97 || e.keyCode === 103 || e.keyCode === 99 || e.keyCode === 88 || e.keyCode === 120 )&& ( e.ctrlKey === true || e.metaKey === true ) ) ||

                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
</script>