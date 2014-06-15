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
<!DOCTYPE html>
<html lang="en">
    <head>
        <?= snippet('head') ?>
    </head>
    <body class="default">
        
        <?= snippet('mast') ?>
    	
        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                    
                    <?php if(empty($_GET['sent'])) : ?>
                        <form action="" method="post" id="contact-form" class="standard" >
                            <p class="field <?php echo $validator->error_class('contactname'); ?>">
                                <label>Name</label>
                                <span class="input">
                                    <input type="text" name="contactname" value="<?php echo $validator->get_value('contactname'); ?>" />
                                    <?php $validator->field_error('contactname', '<span class="error">', '</span>') ?>
                                </span>
                            </p>
                            <p class="field <?php echo $validator->error_class('email'); ?>">
                                <label>Email</label>
                                <span class="input">
                                    <input type="email" name="email" value="<?php echo $validator->get_value('email'); ?>" />
                                    <?php $validator->field_error('email', '<span class="error">', '</span>') ?>
                                </span>
                            </p>
                            <p class="field <?php echo $validator->error_class('subject'); ?>">
                                <label>Subject</label>
                                <span class="input">
                                    <input type="text" name="subject" value="<?php echo $validator->get_value('subject'); ?>" />
                                    <?php $validator->field_error('subject', '<span class="error">', '</span>') ?>
                                </span>
                            </p>
                            <p class="field <?php echo $validator->error_class('message'); ?>">
                                <label>Message</label>
                                <span class="input">                    
                                    <textarea name="message" id="in-message" cols="30" rows="6"><?php echo $validator->get_value('message'); ?></textarea>
                                    <?php $validator->field_error('message', '<span class="error">', '</span>') ?>
                                </span>
                            </p>
                            <p class="field submit">
                                <input type="submit" name="submit" class="btn" value="Send" />
                            </p>
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
        
        <?= snippet('foot') ?>
    
    </body>
</html>