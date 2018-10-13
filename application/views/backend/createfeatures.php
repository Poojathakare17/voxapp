<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create features</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createfeaturessubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Sub Title">Sub Title</label>
<input type="text" id="Sub Title" name="subtitle" value='<?php echo set_value('subtitle');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Quote">Quote</label>
<input type="text" id="Quote" name="quote" value='<?php echo set_value('quote');?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("status",$status,set_value('status'));?>
<label>Status</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s12">
<textarea name="text" class="materialize-textarea" length="400"><?php echo set_value( 'text');?></textarea>
<label>Text</label>
</div>
</div>
<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Banner</span>
<input type="file" name="banner" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('banner');?>'>
</div>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Image">Image</label>
<input type="text" id="Image" name="image" value='<?php echo set_value('image');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewfeatures"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
