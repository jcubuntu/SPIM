var showModal = function(title, body, footer) {
	var modalId = Math.floor((Math.random() * 10000000) + 100000);
	var html = 
	'<div class="modal fade" id="'+modalId+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' +
	'  <div class="modal-dialog" role="document">' +
	'    <div class="modal-content">' +
	'      <div class="modal-header">' +
	'        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
	'        <h4 class="modal-title" id="myModalLabel">' + title + '</h4>' +
	'      </div>' +
	'      <div class="modal-body">' +
			body +
	'      </div>' +
	'      <div class="modal-footer">' +
	(typeof footer !== 'undefined' ?
			footer
	: 
	'		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
	) + 
	'      </div>' +
	'    </div>' +
	'  </div>' +
	'</div>';

	$('body').append(html);
	$('div#'+modalId).modal('show');

	$('div#'+modalId).on('hidden.bs.modal', function (e) {
	  $(this).remove();
	});
};