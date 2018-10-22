<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create testimonials</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createtestimonialssubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name');?>'>
</div>
</div>
<div class="row">
			<div class="file-field input-field col m6 s12">
				<div class="btn blue darken-4">
					<span>Image</span>
					<input name="image" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image');?>">
				</div>
			</div>
		</div>
<div class="row">
<div class="input-field col s6">
<label for="Designation">Designation</label>
<input type="text" id="Designation" name="designation" value='<?php echo set_value('designation');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Rating">Rating</label>
<input type="text" id="Rating" name="rating" value='<?php echo set_value('rating');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Text">Text</label>
<input type="text" id="Text" name="text" value='<?php echo set_value('text');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewtestimonials"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
