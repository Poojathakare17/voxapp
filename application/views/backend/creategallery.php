<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create gallery</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/creategallerysubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image</span>
<input type="file" name="image" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('image');?>'>
</div>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Status">Status</label>
<input type="text" id="Status" name="status" value='<?php echo set_value('status');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Gallery Category">Gallery Category</label>
<input type="text" id="Gallery Category" name="gallerycategory" value='<?php echo set_value('gallerycategory');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewgallery"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
