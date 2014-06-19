<section class="foot">
	<footer class="row">
		<span class="copyright">
			<?= kirbytext($site->copyright()) ?>
		</span>
		<span class="technology">
			<span class="item">Built with <a target="_blank" href="http://getkirby.com">Kirby</a></span>
			<span class="item">Running on <a target="_blank" href="http://wiki.nginx.org/Main">Nginx</a></span>
			<span class="item">Powered by <a target="_blank" href="https://www.linode.com/">Linode</a></span>
		</span>
	</footer>
</section>
<?= js(asset_path('assets/dist/js', 'build.js')) ?>
<script defer>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-31871536-1');ga('send','pageview');
</script>
