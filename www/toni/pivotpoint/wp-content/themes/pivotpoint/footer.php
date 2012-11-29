<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage PivotPoint
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

            <hr>

            <footer>
                <!-- Begin MailChimp Signup Form -->
                
	               <div id="mc_embed_signup">
    	               <form action="http://bueninvento.us6.list-manage.com/subscribe/post?u=175f0f449832d6f5a2818cc27&amp;id=904730f1ed" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        	               <label for="mce-EMAIL">Subscribe to our mailing list</label>
        	               <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
        	               <div class="clear">
        	                   <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
        	               </div>
        	           </form>
        	       </div>

<!--End mc_embed_signup-->


                <p>&copy; Company 2012</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

        <script src="<?php bloginfo('template_url'); ?>/js/vendor/bootstrap.min.js"></script>

        <script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        <?php wp_footer(); ?>

    </body>
</html>
