<style>
.col-centered {
	float:none;
	margin: 0 auto;
}
</style>

<form id="fileupload" action="fileuploadhandler.php" method="POST" enctype="multipart/form-data">
	<div class="row fileupload-buttonbar">
		<div class="col-lg-7">
			<!-- The fileinput-button span is used to style the file input field as button -->
			<span id="addfilebtn" class="btn btn-success fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Add files...</span>
				<input type="file" name="files[]" multiple>
				<!-- The file input field used as target for the file upload widget -->
				<!--<input id="fileupload" type="file" name="files[]" multiple>-->
			</span>
			<button type="submit" id="fileupload_submit" class="btn btn-primary start">
				<i class="glyphicon glyphicon-upload"></i>
				<span>Post&nbsp;&nbsp;</span>
			</button>
		</div>
	</div>
	<textarea id="micropost_content" name="micropost[content]" placeholder="Give comment ..." style="width:100%"></textarea>			

	<!-- The container for the uploaded files 
	<div id="files" class="files"></div> -->
	
	<!-- The global progress bar -->
	<div id="progress" class="progress">
		<div class="progress-bar progress-bar-success"></div>
	</div>

	<!-- The table listing the files available for upload/download -->
	<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

</form>

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	<div class="slides"></div>
	<h3 class="title"></h3>
	<a class="prev">‹</a>
	<a class="next">›</a>
	<a class="close">×</a>
	<a class="play-pause"></a>
	<ol class="indicator"></ol>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-upload fade">
	<td>
		<span class="preview"></span>
	</td>
	<td>
		<p class="name">{%=file.name%}</p>
		<strong class="error text-danger"></strong>
	</td>
	<td>
		<p class="size">Processing...</p>
		<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
			<div class="progress-bar progress-bar-success" style="width:0%;">
			</div>
		</div>
	</td>
	<td>
	{% if (!i && !o.options.autoUpload) { %}
		<button class="btn btn-primary start" disabled style="display:none">
			<i class="glyphicon glyphicon-upload"></i>
			<span>Start</span>
		</button>
	{% } %}
	</td>
</tr>
{% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-download fade">
		<td>
			<span class="preview">
			{% if (file.thumbnailUrl) { %}
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
			{% } %}
			</span>
		</td>
		<td>
			<p class="name">
			{% if (file.url) { %}
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
			{% } else { %}
				<span>{%=file.name%}</span>
			{% } %}
			</p>
			{% if (file.error) { %}
			<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
		</td>
		<td>
			<span class="size">{%=o.formatFileSize(file.size)%}</span>
		</td>
		<td>
		{% if (file.deleteUrl) { %}
			<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				<i class="glyphicon glyphicon-trash"></i>
				<span>Delete</span>
			</button>
			<input type="checkbox" name="delete" value="1" class="toggle">
		{% } else { %}
			<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
			</button>
		{% } %}
		</td>
	</tr>
{% } %}
</script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="fileupload.js"></script>

