<?php 
	global $post;
	$meta = get_post_custom($post->ID);
	
	$data['dueDate'] = '';
	$data['docs'] = array();

	if (!empty($meta['wpt_assignment_dueDate']))
		$data['dueDate'] = $meta['wpt_assignment_dueDate'][0];
		
	if (!empty($meta['wpt_assignment_docs']))
		$data['docs'] = unserialize($meta['wpt_assignment_docs'][0]);
		
	$data = (object) $data;
?>
<fieldset>
	<input type="hidden" name="post-type" value="assignment" />
	<div>
		<label for="due-date">Due Date:</label>
		<input type="text" name="due-date" id="due-date" value="<?=$data->dueDate?>" />
	</div>
	<div class="files">
		<h4>Assignment Documents</h4>
		<p><em>Push the button to add another document.</em></p>
		<?php if (!empty($data->docs['files'])) : ?>
		<ol>
			<?php $count = 1; ?>
			<?php foreach ($data->docs['files'] as $doc) : ?>
			<li>
				<input type="text" name="assignment[files][<?=($count - 1)?>][name]" class="file" id="assignment-<?=$count?>" value="<?=$doc['name']?>" />
				<input type="hidden" name="assignment[files][<?=($count - 1)?>][link]" id="doc-<?=$count?>" value="<?=$doc['link']?>" />
				<a href="#" class="remove button button-highlighted" title="Remove">x</a>
			</li>
			<?php $count++; ?>
			<?php endforeach; ?>
		</ol>
		<?php else : ?>
		<ol>
			<li>
				<input type="text" name="assignment[files][0][name]" class="file" id="assignment-1" value="" />
				<input type="hidden" name="assignment[files][0][link]" id="doc-1" value="" />
				<a href="#" class="remove button button-highlighted" title="Remove">x</a>
			</li>
		</ol>
		<?php endif; ?>
		<button id="add-file" class="button">Add Another</button>
	</div>
</fieldset>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$("#due-date").datepicker();
	
	$('.files ol > li').each(function (i) {
		$(this).find('input:text').attr('id', 'assignment-' + (i + 1));
		bindElement((i + 1));
	});
	
	$('#add-file').click(function () {
		var count = $('.files ol').children().length + 1;
		$('.files ol').append(
			'<li>' +
				'<input type="text" name="assignment[files]['+(count - 1)+'][name]" class="file" id="assignment-' + count + '" />' +
				'<input type="hidden" name="assignment[files]['+(count - 1)+'][link]" id="doc-'+count+'" />' +
				'<a href="#" class="remove button button-highlighted" title="Remove">x</a>' +
			'</li>'
		);
		bindElement(count);
		return false;
	});
	
	function bindElement (num) {
		$('#assignment-' + num).click(function (event) {
			var obj = $(this);
			var filePath = $(this).next('input:hidden');
			var old_send_to_editor = window.send_to_editor; 
			
			var formfield = jQuery('#assignment-'+num).attr('name');
			tb_show('', 'media-upload.php?post_id='+$('#post_ID').val()+'&TB_iframe=true');
			window.send_to_editor = function(html) {  
				the_url = $(html).attr('href');
				
				//console.log(html,the_url);
				
				filePath.val(the_url);
				obj.val($(html).html());
				
				tb_remove();
				window.send_to_editor = old_send_to_editor; 
			}
			return false; 
		});
		
		$('#assignment-' + num).nextAll('a.remove').click(function () {
			var id = $(this).prevAll('input:text').attr('id').slice(11);
			// Unbind it
			unbindElement(id);
			
			// Remove it
			$(this).parents('li').remove();
			
			updateElements();
			
			return false;
		});
		
	}
	
	function unbindElement (num) {
		$('#assignment-' + num).nextAll('a.remove').unbind('click');
		$('#assignment-' + num).unbind('click');
	}
	
	function updateElements () {
		var count = 1;
		$('.files ol > li').each(function (i) {
			unbindElement((i + 1));
			$(this).find('input:text').attr('id', 'assignment-' + count).next('input:hidden').attr('id', 'doc-' + count);
			bindElement(count);
			count++;
		});
	}
});
</script>