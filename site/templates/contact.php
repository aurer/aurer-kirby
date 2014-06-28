<?php
    $validator = new Validator;
    if( isset($_POST['submit']) ){ 
        
        $validator->add_rule('contactname', 'Name', 'required');
        $validator->add_rule('email', 'Email', 'required|email');
        $validator->add_rule('message', 'Message', 'required|min(5)');
        $validator->custom_message('email', 'required', "Please enter your email, this will only be used to respond to your message");
        $validator->custom_message('email', 'email', "Please enter a valid email, this will only be used to respond to your message");
        
        if($validator->run()==true){
            $send = email(array(
              'to'      => 'Phil Mau <philmau@gmail.com>',
              'from'    => 'Max Musterman <max@musterman.com>',
              'subject' => $validator->get_value('subject', 'Response from the Aurer site'),
              'body'    => $validator->get_value('contactname')." sent you a message\n\n".$validator->get_value('message')."\n\n".$validator->get_value('email'),
            ));

            if(error($send)) {
                header('Location: ' . $page->url() . '?sent=true');
            } else {
                header('Location: ' . $page->url() . '?sent=true');
            }
        }
    } 
?>
<?= snippet('header') ?>
    	
    <section class="main">
  		<div class="row">
            <div class="content">
                <h1><?= html($page->title()) ?></h1>
                <?= kirbytext($page->text()) ?>
                
                <?php if(empty($_GET['sent'])) : ?>
                    <form action="<?= $page->url() ?>#contact-form" method="post" id="contact-form" class="standard contact" >
                        <div class="field <?= $validator->error_class('contactname'); ?>">
                            <label>Name</label>
                            <div class="input">
                                <input type="text" name="contactname" value="<?= $validator->get_value('contactname'); ?>" />
                                <?= $validator->field_error('contactname') ?>
                            </div>
                        </div>
                        <div class="field <?= $validator->error_class('email'); ?>">
                            <label>Email</label>
                            <div class="input">
                                <input type="email" name="email" value="<?= $validator->get_value('email'); ?>" />
                                <?= $validator->field_error('email') ?>
                            </div>
                        </div>
                        <div class="field <?= $validator->error_class('subject'); ?>">
                            <label>Subject</label>
                            <div class="input">
                                <input type="text" name="subject" value="<?= $validator->get_value('subject'); ?>" />
                                <?= $validator->field_error('subject') ?>
                            </div>
                        </div>
                        <div class="field <?= $validator->error_class('message'); ?>">
                            <label>Message</label>
                            <div class="input">                    
                                <textarea name="message" id="in-message" cols="30" rows="10"><?= $validator->get_value('message'); ?></textarea>
                                <?= $validator->field_error('message') ?>
                            </div>
                        </div>
                        <div class="field submit">
                            <input type="submit" name="submit" class="btn" value="Send" />
                        </div>
                    </form>
                <?php else: ?>
                    <div class="sent">
                        <h2>Thanks for getting in touch.</h2>
                        <p>I will try to get back you you as soon as possible.</p>
                        <p><b>Phil.</b></p>
                    </div>
                <?php endif ?>

            </div>
    	</div>
    </section>
        
<?= snippet('footer') ?>