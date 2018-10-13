<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit features</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editfeaturessubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title',$before->title);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Sub Title">Sub Title</label>
<input type="text" id="Sub Title" name="subtitle" value='<?php echo set_value('subtitle',$before->subtitle);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Quote">Quote</label>
<input type="text" id="Quote" name="quote" value='<?php echo set_value('quote',$before->quote);?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s12 m6">
<?php echo form_dropdown("status",$status,set_value('status',$before->status));?>
<label for="Status">Status</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order',$before->order);?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Text</label>
<textarea name="text" placeholder="Enter text ..."><?php echo set_value( 'text',$before->text);?></textarea>
</div>
</div>
<input type="file" id="normal-field" class="form-control" name="banner" value='<?php echo set_value('banner',$before->banner);?>'>
<div class="row">
<div class="file-field input-field col s12 m6">
<span class="img-center big">
NANbanner; ?>" ></span>
<div class="btn blue darken-4">
<span>Banner</span>
<input type="file" name="banner" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('banner',$before->banner);?>'>
<?php if($before->image == "") { } else { ?> <?php } ?>
</div>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Image">Image</label>
<input type="text" id="Image" name="image" value='<?php echo set_value('image',$before->image);?>'>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewfeatures"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
