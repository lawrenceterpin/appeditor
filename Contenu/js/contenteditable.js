$(function() {
	var content_holder, content;
	var selector = 'article[contenteditable="true"]';
	
	// prevent clicks inside editable area to fire
	// a click event on the body
	// and therefor saving our content before we even edit it
	$(selector).click(function(e) {
		e.stopPropagation();
	});
	
	// initialize the "save" function
	$(selector).focus(function(e) {
		content_holder = $(this);
		content        = content_holder.html();
		
		// one click outside the editable area saves the content
		$('body').one('click', function(e) {
			// but not if the content didn't change
			if ($(e.target).is(selector) || content == content_holder.html()) {
				return;
			}
			
			$.ajax({
				url: content_holder.data('edit-url'),
				type: 'POST',
				dataType: 'json',
				data: { body: content_holder.html() },
				success: function(json) {
					content_holder.effect('highlight', {'color': '#0f0'}, 3000);
				},
				error: function() {
					content_holder.effect('highlight', {'color': '#f00'}, 3000);
					content_holder.html(content);
				}
			});
		});
	});
});
