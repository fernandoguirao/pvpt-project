				<!-- 3. FOOTER -->

				<footer class="footer">
					<div class="fondo-footer">
					</div>
					<div class="footer-textura">
					</div>
					<div class="contiene-bckg-foot hidden-phone hidden-tablet">
						<img src="<?php bloginfo('template_url'); ?>/img/contenidos/slide01.jpg" class="footbckg" alt="" />
					</div>
					<div class="container">
						<div class="row">
							<div class="span3">
								<img src="<?php bloginfo('template_url'); ?>/img/sprites/logo-invertido.png" alt="Pivot point" class="logo-inv" />
								<img src="<?php bloginfo('template_url'); ?>/img/sprites/foot-img01.jpg" class="hidden-phone" alt="" width="100%" />
								<h3>Pivot point</h3>
								<p>
									Donec ullamcorper nulla non metus auctor fringilla. Cras mattis consectetur purus sit amet fermentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lacinia.
								</p>
								<br />
								<a href="">Política de privacidad</a>
								<a href="">Síguenos en Facebook</a>
								<a href="">Contacto</a>
								<div style="height:1px;width:1px;"></div>
							</div>
							<div class="span3">
								<img src="<?php bloginfo('template_url'); ?>/img/sprites/foot-img02.jpg" class="hidden-phone" style="margin-top: 77px;" width="100%" alt="" />
								<h3>Suscríbete a nuestra lista de correo</h3>
								<p>
									Y te mantendremos actualizad@ con las últimas novedades de nuestros cursos y el bla bla bla bla.
								</p>
								<form action="http://bueninvento.us6.list-manage.com/subscribe/post?u=175f0f449832d6f5a2818cc27&amp;id=904730f1ed" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<fieldset>
									    <input type="email" value="" name="EMAIL" class="email" id="inputEmail" placeholder="Tu email aquí" required>
									    <button type="submit" name="subscribe" class="btn btn-inverse">Enviar</button>
									</fieldset>
									
								</form>
							</div>
							<div class="span3">
								<img src="<?php bloginfo('template_url'); ?>/img/sprites/foot-img03.jpg" class="hidden-phone" style="margin-top: 77px;" width="100%" alt="" />
								<div class="foot-contacto">
									<h3>Contacta con nosotros</h3>
									<form name="envio" action="<?php bloginfo('template_directory'); ?>/email.php" method="post" target="_blank">
										<fieldset>
											<input type="text" placeholder="Nombre" name="frm_nombre">
											<input type="text" placeholder="Email" name="frm_email">
											<input type="text" placeholder="Teléfono" name="frm_telefono">
											<textarea rows="3" placeholder="Mensaje" name="frm_anyadir"></textarea>
											<label class="checkbox">
												<input type="checkbox"> Acepto las condiciones de privacidad
											</label>
											<button type="submit" class="btn btn-inverse">Enviar</button>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="span3">
								<div class="mapa">
									<img alt="" src="<?php bloginfo('template_url'); ?>/img/sprites/foot-img04.jpg" class="hidden-phone" width="100%" style="margin-top: 97px;">
									<br>
									<br>
								</div>
								<h3>Ven a visitarnos</h3>
								<div class="foot-dirección">
									<address>
										<strong>Pivot Point Valencia.</strong><br>
										795 Folsom Ave, Suite 600<br>
										San Francisco, CA 94107<br>
										<abbr title="Phone">P:</abbr> (123) 456-7890
									</address>
								</div>
							</div>
						</div>
					</div>
				</footer> <!-- / FIN DE FOOTER -->

				<!-- 4. SCRIPTS -->

<!--
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
				<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

				<script src="js/vendor/bootstrap.min.js"></script>
				<script src="js/vendor/queryloader2.js" type="text/javascript"></script>
-->
				<script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
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