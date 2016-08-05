<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _tk
 */
?>
			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .main-content -->

<footer id="colophon" class="site-footer" role="contentinfo">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>
	<div class="site-footer-inner">
		<div class="site-info">
			Copyright &copy <?php echo DATE("Y");?>. All rights reserved. Developed by <a class="npk" href="http://www.niketpathak.com" target="_blank">Niket Pathak</a>
		</div>
	</div>
</footer><!-- close #colophon -->

<?php wp_footer(); ?>

</body>
</html>
