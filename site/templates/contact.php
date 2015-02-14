<?php
    
    $validator = new Validator;
    if( isset($_POST['submit']) ){ 
        
        $validator->add_rule('contactname', 'Name', 'required');
        $validator->add_rule('email', 'Email', 'required|email');
        $validator->add_rule('message', 'Message', 'required|min(5)');
        $validator->custom_message('email', 'required', "Please enter your email, this will only be used to respond to your message");
        $validator->custom_message('email', 'email', "Please enter a valid email, this will only be used to respond to your message");
        
        if($validator->run()==true){
            $email = new Email(array(
                'to'      => c::get('site_email'),
                'from'    => 'Aurer emailer <noreply@aurer.co.uk>',
                'subject' => $validator->get_value('subject', 'Response from the Aurer site'),
                'body'    => $validator->get_value('contactname')." sent you a message\n\n".$validator->get_value('message')."\n\n".$validator->get_value('email'),
                'service' => 'mailgun',
                'options' => array(
                    'key'    => c::get('mailgun_key'),
                    'domain' => c::get('mailgun_domain'),
                )
            ));

            if($email->send()) {
                s::set('email_sent', true);
                go($page->url());
            } else {
                s::set('email_sent', false);
                message::set('mail_error', 'It appears your message cannot be sent right now, many appologies.');
                go($page->url());
            }
        }
    }

?>
<?= snippet('header') ?>
    <section class="main">
  		<div class="row">
            <div class="content">

                <h1><?= html($page->title()) ?></h1>
                                
                <?php if(s::get('email_sent') !== true) : ?>

                    <?= kirbytext($page->text()) ?>

                    <?= snippet('messages') ?>

                    <form action="<?= $page->url() ?>#contact-form" method="post" id="contact-form" class="standard contact" >
                        <div class="field field-contactname <?= $validator->error_class('contactname'); ?>">
                            <label>Name *</label>
                            <div class="input">
                                <input type="text" name="contactname" value="<?= $validator->get_value('contactname'); ?>" />
                                <?= $validator->field_error('contactname') ?>
                            </div>
                        </div>
                        <div class="field field-email <?= $validator->error_class('email'); ?>">
                            <label>Email *</label>
                            <div class="input">
                                <input type="email" name="email" value="<?= $validator->get_value('email'); ?>" />
                                <?= $validator->field_error('email') ?>
                            </div>
                        </div>
                        <div class="field field-subject <?= $validator->error_class('subject'); ?>">
                            <label>Subject</label>
                            <div class="input">
                                <input type="text" name="subject" value="<?= $validator->get_value('subject'); ?>" />
                                <?= $validator->field_error('subject') ?>
                            </div>
                        </div>
                        <div class="field field-message <?= $validator->error_class('message'); ?>">
                            <label>Message *</label>
                            <div class="input">                    
                                <textarea name="message" id="in-message" cols="30" rows="10"><?= $validator->get_value('message'); ?></textarea>
                                <?= $validator->field_error('message') ?>
                            </div>
                        </div>
                        <div class="field field-submit">
                            <input type="submit" name="submit" class="btn" value="Send" />
                        </div>
                    </form>
                <?php else: ?>
                    <div class="sent">
                        <h2>Thanks for getting in touch.</h2>
                        <p>I will try to get back you you as soon as possible.</p>
                    </div>
                <?php endif ?>

            </div>
    	</div>
        <script>
        (function(){
            var supportsPlaceholder = function(){
                var i = document.getElementsByTagName('input');
                return i ? 'placeholder' in i[0] : false;
            }
            if (supportsPlaceholder()) {
                var labels = document.querySelectorAll('#contact-form label');
                for(var i = 0; i < labels.length; i++){
                    var label = labels[i];
                    var parent = label.parentNode;
                    var siblings = parent.children;
                    var input = siblings[1].children[0];
                    input.placeholder = label.innerText;
                    label.style.display = 'none';
                }
            };
        }());
        </script>
    </section>
        
<?= snippet('footer') ?>
<?php s::remove('email_sent'); ?>