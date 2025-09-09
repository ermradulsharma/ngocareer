<table class="table table-striped table-bordered">
    <tr><td width="200">Payment of </td><td width='5'>:</td><td><?php echo $table; ?></td></tr>
    <tr><td>Ref ID</td><td width='5'>:</td><td><?php echo $ref_id; ?></td></tr>
    <tr><td>Paid Amount</td><td>:</td><td><?php echo $paid_amount; ?></td></tr>    
    <tr><td>Payment Status</td><td>:</td><td><?php echo $payment_status; ?></td></tr>
    <tr><td>Email</td><td>:</td><td><?php echo $email; ?></td></tr>
    <tr><td>Created At</td><td>:</td><td><?php echo $created_at; ?></td></tr>    
</table>
<p><b>Payment Details</b></p>
<?php  echo $response; ?>