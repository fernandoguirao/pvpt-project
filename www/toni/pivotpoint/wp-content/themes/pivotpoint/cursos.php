<?php
/*
Template Name: cursos
*/
?>
<?php get_header(); ?>

				<div id="cuerpo" class="cursos">
				
					<!-- TITULAR E IMAGEN -->
					<div class="mini-header">
						<div class="container">
							<div class="captionimg">
								<h2>
									Este es el titular.
								</h2>
								<div class="masinfo">
									<a href="">
										Esto es un botón
									</a>
								</div>
							</div>
						</div> 
						<img src="<?php bloginfo('template_url'); ?>/img/contenidos/diapositiva.png" alt="" width="100%" />
					</div>
					
					<!-- CONTENIDOS -->
					
					<div id="contenido" class="container">
					    <ul class="thumbnails">
							<li class="span3 row1">

					<?php
					       global $teachpress_settings; 
					       global $teachpress_courses;
					       $row = "Select `course_id`, `name`, `comment`, `rel_page`, `image_url`, `visible` FROM " . $teachpress_courses . " WHERE `parent` = '0' AND (`visible` = '1' OR `visible` = '2') ORDER BY `name`";
					       $test = $wpdb->query($row);
					       $row = $wpdb->get_results($row);

					       foreach($row as $row) {
					           $row->name = stripslashes($row->name);
    					       $row->comment = stripslashes($row->comment);

				    ?>
    					       <!-- PRINCIPIO DE CURSO -->
    					       <div class="thumbpadre">
									<a href="#curso-modal-nombrecurso1" class="thumbnail th1" data-toggle="modal">
										<div class="mascara">
    										<img src="<?php echo $row->image_url;?>" width="100%" alt="">
    								    </div>
										<div class="texto-th">
								        <h2><?php echo $row->name;?></h2>
								        <p>
								            <?php echo $row->comment?>
								        </p>
								        <div class="mas-info">
												<i class="icon-eye-open"></i>
												Más información
											</div>
										</div>
									</a>
									<!-- CURSO MODAL -->
									<div id="curso-modal-nombrecurso1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-header">
									    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									    <h3 id="myModalLabel">Título del curso</h3>
									  </div>
									  <div class="modal-body">
									    <p>
												Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Nulla vitae elit libero, a pharetra augue. Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Donec sed odio dui. Vestibulum id ligula porta felis euismod semper. Sed posuere consectetur est at lobortis.
											</p>
											
											<!-- ACORDEÓN -->
											<div class="accordion" id="accordion2">

												<!-- MATERIAL DEL CURSO -->
												<div class="accordion-group">
													<div class="accordion-heading">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
															Material del curso
														</a>
													</div>
													<div id="collapseOne" class="accordion-body collapse">
														<div class="accordion-inner">

															<table class="table table-hover">
																<tr>
																	<td>
																		<p>Algunos apuntes</p>
																	</td>
																	<td>
																		<a href="" class="btn">Descargar pdf</a>
																	</td>
																</tr>
																<tr>
																	<td>
																		<p>Otros apuntes</p>
																	</td>
																	<td>
																		<a href="" class="btn">Descargar pdf</a>
																	</td>
																</tr>
															</table>
														</div>
													</div>
												</div>

												<!-- MULTIMEDIA -->
												<div class="accordion-group">
													<div class="accordion-heading">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
															Contenido multimedia
														</a>
													</div>
													<div id="collapseTwo" class="accordion-body collapse in">
														<div class="accordion-inner">

															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img03.jpg" width="100%" alt="">
															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img01.jpg" width="100%" alt="">
															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img02.jpg" width="100%" alt="">
															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img02.jpg" width="100%" alt="">
															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img03.jpg" width="100%" alt="">
															<img src="<?php bloginfo('template_url'); ?>/img/sprites/img01.jpg" width="100%" alt="">
															<div class="modaliz"></div>
															<div class="modalde"></div>
															<iframe width="100%" height="400px" src="http://www.youtube.com/embed/BrHlQUXFzfw" frameborder="0" allowfullscreen>
															</iframe>

														</div>
													</div>
												</div>
												
											</div> <!-- FIN DE ACORDEÓN -->

										</div> <!-- FIN DE BODY MODAL -->
										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar y volver al resto de cursos</button>
										</div>
									</div> <!-- FIN DE CURSO MODAL -->
								</div> <!-- FIN DE CURSO -->

                    <?php }
                        
                    ?>					
								
							</li>
							<li class="span3 row2">
							</li>
							<li class="span3 row3">
							</li>
							<li class="span3 row4">
							</li>
						</ul>
					</div>
				</div>

<?php get_footer(); ?>