</div>
</div>
<!-- Body Content End -->

<!-- ./wrapper -->

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        Loading Time <b>{elapsed_time}</b> seconds. App v0.1 & CiF v<?php echo CI_VERSION; ?>
    </div>
    <b>Copyright &copy; <?php echo date('Y'); ?> NGO Career.</b>
    All rights reserved.
</footer>


<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>

<!--Toast message-->
<script src="assets/lib/toast/toastr.js"></script>
<script src="assets/lib/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="assets/lib/iCheck/icheck.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/admin/dist/js/app.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="assets/admin/dist/js/demo.js"></script>
<script src="assets/lib/common.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // toast
        toastr.clear();

        <?php if ($this->session->flashdata('msgs')) { ?>
        toastr.success("<?php echo $this->session->flashdata('msgs'); ?>");
        <?php } ?>

        <?php if ($this->session->flashdata('msge')) { ?>
        toastr.error("<?php echo $this->session->flashdata('msge'); ?>");
        <?php } ?>

        <?php if ($this->session->flashdata('msgw')) { ?>
        toastr.warning("<?php echo $this->session->flashdata('msgw'); ?>");
        <?php } ?>

        <?php if ($this->session->flashdata('msgi')) { ?>
        toastr.info("<?php echo $this->session->flashdata('msgi'); ?>");
        <?php } ?>
    });
</script>
</body>
</html>