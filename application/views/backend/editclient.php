<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit client</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editclientsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Project Name">Project Name</label>
<input type="text" id="Project Name" name="projectname" value='<?php echo set_value('projectname',$before->projectname);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title',$before->title);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Year">Year</label>
<input type="text" id="Year" name="year" value='<?php echo set_value('year',$before->year);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Media">Media</label>
<input type="text" id="Media" name="media" value='<?php echo set_value('media',$before->media);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Client usp">Client usp</label>
<input type="text" id="Client usp" name="clientusp" value='<?php echo set_value('clientusp',$before->clientusp);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Technology">Technology</label>
<input type="text" id="Technology" name="tect" value='<?php echo set_value('tect',$before->tect);?>'>
</div>
</div>
<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big">
								                    	<?php if($before->image == "") { } else {
									                    ?><img src="<?php echo base_url('uploads')."/".$before->image; ?>">
															<?php } ?>
															</span>
				<div class="btn blue darken-4">
					<span>Image</span>
					<input name="image" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image',$before->image);?>">
				</div>
			</div>
		</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewclient"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
