<div class="footer-manu">
    <div class="text-center quick_menu">
        <h2 class="text-center">Quick Links</h2>
<!--        <a href="about-us">About Us</a>-->
        <a href="post-an-ngo-event">Post an Event</a>
        <!--<a href="https://www.ngocareer.com/job-search">Job Search</a> -->                  
        <!-- <a href="https://www.ngocareer.com/employers-recruiters">Employers</a> -->
        <a href="https://www.ngocareer.com/employers-recruiters">Employers and Recruiters</a>
        <!--<a href="https://www.ngocareer.com/advertisers">Recruiters</a>-->
        <a href="https://www.ngocareer.com/job-seekers">Job Seekers</a><br>
        <a href="https://www.ngocareer.com/events">Search for NGO Events</a>
        <a href="https://www.ngocareer.com/ngo-career-advice">NGO Career Advice</a>
        <a href="https://www.ngocareer.com/your-guide-to-ngo-jobs">Your Guide to NGO Jobs</a>
        <a href="https://www.ngocareer.com/ngo-job-profiles">NGO Job Profiles</a><br>
        <a href="https://www.ngocareer.com/your-guide-to-international-development-jobs">International Development Jobs</a>
        <a href="https://www.ngocareer.com/understanding-the-ngo-sector">Understanding the NGO Sector</a>
    </div>
</div>
<!-- <div class="footer-manu" style="padding-top: 0;">
    <div class="text-center quick_menu">
        
        
    </div>
</div> -->


<div class="footer hide_on_print">
    <div class="footer-newsletter">
        <div class="container">
            <div class="row">
        <div class="col-sm-6">
            <h3>Subscribe to our newsletter</h3>
        </div>
        <div class="col-sm-6">
             <form name="newsletter" id="newsletter" action="">
                 <div class="row">
                     <div class="col-md-5">
                         <input type="text" name="name" id="name" class="form-control" required="required" placeholder="Name">
                     </div>
                     <div class="col-md-5">
                         <input type="email" name="newsletter_email" id="newsletter_email" class="form-control" placeholder="Email Address" required="required">
                     </div>
                     <div class="col-md-2">
                         <input onclick="newsletterSubscribe()" type="button" class="btn btn-primary" value="Subscribe">
                     </div>
                 </div>

                 

                 <div class="clearfix"></div>
                 <div class="col-sm-12">
                    <div id="newsletter-msg"></div>
                 </div>
             </form>
         </div>
         </div>
         </div>
         </div>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h3>NGO Jobs</h3>
                    <?php echo getFooterMenu(14, 'menu'); ?>
                </div>
                <div class="col-sm-4">
                    <h3>Legal Information</h3>
                    <ul class="menu">
                        <?php echo getFooterMenu(15, 'menu'); ?>
                    </ul>
                </div>
                
                <div class="col-sm-4 emailus">
                    <h3>Contact Us By Email </h3>
                    <!--<P>NGO Career is  operated and own by Qualified Place Limited.</p>
                    <p>Registered Company Number: 10617882. <br>ICO  Ref: ZA612655. </P>
                    <p>Registered Address: 1st Floor, 54-56 The Market Square, London, N9 0TZ. </p> 
                    <p>Tel: <a href="tel:03001237594">030 0123 7594</a></p>-->
                    <P class="emailpra"> NGO Career by Qualified Place Limited.<br>
                    (The Market Square, London, N9 0TZ.)</P>
                    <p>Email : <a href="mailto:contact@ngocareer.com">contact@ngocareer.com</a> or  <a href= "https://www.ngocareer.com/contact">Contact Us  Online </a></p>
                        
                        
                        <h3></h3>
                        <p class="footer-social">
                        <a href="https://www.facebook.com/ngocareer/" target="_blank">
                            <i class="fa fa-facebook fa-2x"></i>                            
                        </a>
                        <a href="https://twitter.com/ngocareer/" target="_blank">
                            <i class="fa fa-twitter fa-2x"></i>                            
                        </a>                        
                    </p> 
                    <?php // echo viewSocialLinksImg(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container text-center">
            <center>
                &copy;
                <?php echo date('Y') . ' ' . getSettingItem('SiteTitle') ?>. All Rights Reserved.
            </center>                    
        </div>
    </div>
</div>
<script src="assets/theme/js/scripts.js"></script>
<script src="assets/lib/common.js"></script>
<script src="assets/lib/toast/toastr.js"></script>
<script type="text/javascript">

    !function(window){
        var $q = function(q, res){
                if (document.querySelectorAll) {
                    res = document.querySelectorAll(q);
                } else {
                    var d=document
                        , a=d.styleSheets[0] || d.createStyleSheet();
                    a.addRule(q,'f:b');
                    for(var l=d.all,b=0,c=[],f=l.length;b<f;b++)
                        l[b].currentStyle.f && c.push(l[b]);

                    a.removeRule(0);
                    res = c;
                }
                return res;
            }
            , addEventListener = function(evt, fn){
                window.addEventListener
                    ? this.addEventListener(evt, fn, false)
                    : (window.attachEvent)
                    ? this.attachEvent('on' + evt, fn)
                    : this['on' + evt] = fn;
            }
            , _has = function(obj, key) {
                return Object.prototype.hasOwnProperty.call(obj, key);
            }
        ;

        function loadImage (el, fn) {
            var img = new Image()
                , src = el.getAttribute('data-src');
            img.onload = function() {
                if (!! el.parent)
                    el.parent.replaceChild(img, el)
                else
                    el.src = src;

                fn? fn() : null;
            }
            img.src = src;
        }

        function elementInViewport(el) {
            var rect = el.getBoundingClientRect()

            return (
                rect.top    >= 0
                && rect.left   >= 0
                && rect.top <= (window.innerHeight || document.documentElement.clientHeight)
            )
        }

        var images = new Array()
            , query = $q('img')
            , processScroll = function(){
                for (var i = 0; i < images.length; i++) {
                    if (elementInViewport(images[i])) {
                        loadImage(images[i], function () {
                            images.splice(i, i);
                        });
                    }
                };
            }
        ;
        // Array.prototype.slice.call is not callable under our lovely IE8
        for (var i = 0; i < query.length; i++) {
            images.push(query[i]);
        };

        processScroll();
        addEventListener('scroll',processScroll);

    }(this);

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
    
    <?php $candidate_id = getLoginCandidatetData('id');?>
    
//    $(document).on('click','.jobalert',function(e) {
//        <?php if($candidate_id){?>
//                location.href = "myaccount/alert";
//        <?php }else{?>
//            toastr.error("Please login first!");
//            return false;
//        <?php }?>        
//    });
</script>

<?php echo cookie(); ?>
</body>
</html>