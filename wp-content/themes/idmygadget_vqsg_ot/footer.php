<?php global $jmwsIdMyGadget; ?>
<div id="footer"
	<?php echo $jmwsIdMyGadget->jqmDataRole['footer'] . ' ' . $jmwsIdMyGadget->jqmDataThemeAttribute ?>>
	<cite>
	&copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url');?>">Matt Beck & Jessica Neuman Beck</a>. All rights reserved.
	</cite>
	<?php if( has_nav_menu('phone-footer-nav') && $jmwsIdMyGadget->phoneFooterNavThisDevice ) : ?>
		<nav data-role="navbar" data-position="fixed">
			<?php wp_nav_menu( array('theme_location' => 'phone-footer-nav','container' => false) ); ?>
		</nav>
	<?php endif; ?>
 </div>
 <?php wp_footer(); ?>

 </div>
 </body>
 </html>