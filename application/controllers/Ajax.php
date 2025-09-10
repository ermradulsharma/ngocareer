<?php

class Ajax extends Frontend_controller
{
    function __construct()
    {
        parent::__construct();
        ajaxAuthorized();
    }

    public function send_a_enquiry()
    {
        $user_id    = (int) getLoginUserData('user_id');
        $data = [
            'user_id'   => $user_id,
            'send_to'   => $this->input->post('send_to'),
            'name'      => $this->input->post('name'),
            'email'     => $this->input->post('email'),
            'contact'   => $this->input->post('contact'),
            'subject'   => $this->input->post('subject'),
            'message'   => $this->input->post('message'),
        ];
        echo Modules::run('mail/send_enquiry', $data);
    }

    public function send_to_friend()
    {
        $user_id    = (int) getLoginUserData('user_id');

        $data = [
            'user_id'   => $user_id,
            'invitee_email'   => $this->input->post('invitee_email'),
            'invitee_name'      => $this->input->post('invitee_name'),
            'sender_email'     => $this->input->post('sender_email'),
            'sender_name'   => $this->input->post('sender_name'),
            'url'   => $this->input->post('url')
        ];
        echo Modules::run('mail/send_to_friend', $data);
    }

    public  function get_user_reviews()
    {
        $user_id = $this->input->post('user_id');
        $start = $this->input->post('start');
        $limit = 3;
        $next_start = $start + $limit;

        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'Publish');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $reviews = $this->db->get('reviews')->result();

        $html = '';
        foreach ($reviews as $review) {
            $html .= $this->review_html($review);
        }


        $response = [
            'reviews' => $html,
            'status' => 'OK',
        ];
        if ($reviews) {
            $response['button'] = "onclick=load_more($user_id, $next_start)";
        }
        if (empty($reviews)) {
            unset($response['button']);
        }
        echo json_encode($response);
    }

    private function review_html($data = null)
    {

        $html  = '<div class="review-box" >';
        $html .= '<div class="media">';
        $html .= '<div class="media-left revieimage">';
        $html .= '<img src="' . getPhoto($data->photo) . '" />';
        $html .= '</div>';
        $html .= '<div class="media-body">';
        $html .= '<h4>' . $data->name . '</h4>';
        $html .= '<p class="time-count">' . time_count($data->created) . '</p>';
        $html .= '<p>' . $data->comment . '</p>';
        $html .= '</div>';
        $html .= '<div class="media-right viewrating">';
        $html .= '<div id="rateYo_' . $data->id . '" data-rate=' . $data->rating . ' ></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<script>';
        $html .= '$(\'[id^="rateYo_"]\').each(function(){';
        $html .= 'var rate = $(this).data(\'rate\');';
        $html .= '$(this).rateYo({rating: rate, starWidth: "20px", ratedFill: "#fdb900", readOnly: true}); ';
        $html .= '});';
        $html .= '</script>';
        $html .= '</div>';
        return $html;
    }

    public function add_review()
    {
        ajaxAuthorized();
        $name       = $this->input->post('name');
        $comment    = $this->input->post('comment');
        $rating     = (int) $this->input->post('rating');
        $user_id    = (int) $this->input->post('user_id');

        $data = [
            'user_id'   => $user_id, // as listing by user id 
            'name'      => $name,
            'comment'   => nl2br($comment),
            'rating'    => $rating,
            'status'    => 'Pending',
            'photo'     => $this->photo_upload($_FILES['photo']),
            'created'   => date('Y-m-d H:i:s'),
            'modified'  => '0000-00-00 00:00:00',
        ];
        $this->db->insert('reviews', $data);
        Modules::run('mail/mailReview', $data);
        echo ajaxRespond('OK', '<p class="ajax_success">Thank you for submitting your review. Your review will publish after admins approval.</p>');
    }

    private function photo_upload($FILES)
    {
        $photo  = '';
        $handle = new \Verot\Upload\Upload($FILES);
        if ($handle->uploaded) {
            $handle->file_new_name_body = uniqid('fm_');
            $handle->image_resize   = true;
            $handle->file_force_extension = true;
            $handle->file_new_name_ext = 'jpg';
            $handle->image_ratio    = true;
            $handle->image_x        = 150;
            $handle->image_y        = 150;
            $handle->jpeg_quality   = 100;
            $handle->Process('uploads/review/' . date('Y/m/'));
            $photo = stripslashes($handle->file_dst_pathname);
            if ($handle->processed) {
                $handle->clean();
            }
        }
        return $photo;
    }

    public function getReviewForm()
    {
        ajaxAuthorized();
        $id = $this->input->post('user_id');
        $html = '';
        $html = '<div class="col-sm-12" style="padding-top:5px;">
                <div id="ajax_respond"></div>
            </div>            
            <form id="addReview" enctype="multipart/form-data">
                <div class="modal-body">
                    <input name="user_id" value="' . $id . '" type="hidden">
                    <div class="form-group">
                        <label for="name">Your Name <em class="note">Max 25 characters</em></label>
                        <input type="text" required="" maxlength="25" class="form-control" name="name" id="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment <em class="note">Max 500 characters</em></label>
                        <textarea name="comment" class="form-control" maxlength="500" id="comment" placeholder="Write your comment..." rows="4"></textarea>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Rate This Company</label>
                                <div class="rateYo"></div>
                                <input type="hidden" class="form-control" name="rating" id="rating" placeholder="Rating"/>
                                <small class="review_check"></small>
                            </div>
                        </div>

                        <div class="col-md-6">    
                            <div class="form-group">
                                <label for="exampleInputFile">Upload Your Photo</label>
                                <input type="file" id="photo" name="photo">                        
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="add_review()" class="btn btn-primary">Submit</button>
                </div>
            </form>';
        $html .= "<script>
        $('.rateYo').each(function (e) {
        $(this).rateYo({
            onSet: function (rating, rateYoInstance) {
                $(this).next().val(rating);
                $('#rating').attr('value', rating);
            },
            rating: 0,
            ratedFill: '#fdb900',
            starWidth: '24px',
            numStars: 5,
            fullStar: true
        });
    });
        </script>
        ";
        echo $html;
    }

    public function getEnqueryForm()
    {
        ajaxAuthorized();
        $id = $this->input->post('user_id');
        $html = '';
        $html .= '<div class="col-sm-12"><div id="response"></div></div>

            <form  id="sendForm" method="post" onsubmit="return send_enquiry(event);">

                <div class="modal-body">
                    <input name="send_to" type="hidden" value="' . $id . '">
                    <div class="form-group">
                        <input type="text" class="form-control"  id="nameX"  name="name"   placeholder="Name">
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email"  name="email"   placeholder="Email">
                    </div>

                    <div class="form-group">
                        <input type="tel"  class="form-control" onkeypress="return DigitOnly(event);"  id="contact"  name="contact" placeholder="Contact">
                    </div>

                    <div class="form-group">
                        <input type="text"  class="form-control"   id="subject"  name="subject" placeholder="Subject">
                    </div>

                    <div class="form-group">
                        <textarea   id="message"   class="form-control"  name="message"  placeholder="Message" rows="4"></textarea>
                    </div>

                </div>
                <div class="modal-footer contact-form-battong">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Send Enquiry</button>
                </div>
            </form>';
        echo $html;
    }

    public  function auto_complete()
    {

        $key = $this->input->post('key');

        $this->db->select('"0" as id, company_name as name');
        $this->db->from('users as ps');
        $this->db->where('status', 'Active');
        $this->db->like('company_name', $key);
        $companyies = $this->db->get_compiled_select();

        $this->db->select('id,name');
        $this->db->from('categories');
        $this->db->where('status', 'Active');
        $this->db->like('name', $key);
        $categories = $this->db->get_compiled_select();


        $result = $this->db->query(
            "SELECT id,name FROM ({$companyies}
                    UNION ALL {$categories})
                    as tmp_table limit 15"
        )->result();

        $html = '<div class="dd-list">';
        foreach ($result as $key) {
            $html .= "<div class=\"dd-item\" data-id=\"{$key->id}\">";
            $html .= strip_tags($key->name);
            $html .= '</div>';
        }
        $html .= '<div>';
        echo $html;
    }
}
