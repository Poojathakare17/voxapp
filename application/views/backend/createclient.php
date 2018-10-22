<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create client</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createclientsubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Project Name">Project Name</label>
<input type="text" id="Project Name" name="projectname" value='<?php echo set_value('projectname');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Year">Year</label>
<input type="text" id="Year" name="year" value='<?php echo set_value('year');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Media">Media</label>
<input type="text" id="Media" name="media" value='<?php echo set_value('media');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Client usp">Client usp</label>
<input type="text" id="Client usp" name="clientusp" value='<?php echo set_value('clientusp');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Technology">Technology</label>
<input type="text" id="Technology" name="tect" value='<?php echo set_value('tect');?>'>
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
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewclient"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
