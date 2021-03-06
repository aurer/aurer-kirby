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
				'from'    => $validator->get_value('email'),
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
				message::set('mail_error', 'It appears your message cannot be sent right now, many appologies.', 'error');
				go($page->url());
			}
		}
	}
?>

<?= snippet('header') ?>

<div class="section section--contact">
	<div class="section-inner">
		<h1><?= html($page->title()) ?></h1>

		<?php if(s::get('email_sent') !== true) : ?>

			<?= kirbytext($page->text()) ?>

			<?= snippet('messages') ?>

			<form action="<?= $page->url() ?>#contact-form" method="post" id="contact-form" class="form form--contact" >
				<div class="grid grid--padHorizontal">
					<div class="col-lg-1of2">
						<div class="field field-contactname <?= $validator->error_class('contactname'); ?>">
							<label>Name *</label>
							<div class="form-input">
								<input type="text" name="contactname" value="<?= $validator->get_value('contactname'); ?>" />
								<?= $validator->field_error('contactname') ?>
							</div>
						</div>
					</div>
					<div class="col-lg-1of2">
						<div class="field field-email <?= $validator->error_class('email'); ?>">
							<label>Email *</label>
							<div class="form-input">
								<input type="email" name="email" value="<?= $validator->get_value('email'); ?>" />
								<?= $validator->field_error('email') ?>
							</div>
						</div>
					</div>
				</div>
				<div class="field field-subject <?= $validator->error_class('subject'); ?>">
					<label>Subject</label>
					<div class="form-input">
						<input type="text" name="subject" value="<?= $validator->get_value('subject'); ?>" />
						<?= $validator->field_error('subject') ?>
					</div>
				</div>
				<div class="field field-message <?= $validator->error_class('message'); ?>">
					<label>Message *</label>
					<div class="form-input">
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

<?= snippet('content-types/social') ?>

<?= snippet('footer') ?>
<?php s::remove('email_sent'); ?>
