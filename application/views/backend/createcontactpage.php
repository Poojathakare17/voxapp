<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create contactpage</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createcontactpagesubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Phone">Phone</label>
<input type="text" id="Phone" name="phone" value='<?php echo set_value('phone');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Email">Email</label>
<input type="email" id="Email" name="email" value='<?php echo set_value('email');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Web">Web</label>
<input type="text" id="Web" name="web" value='<?php echo set_value('web');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s12">
<textarea name="address" class="materialize-textarea" length="400"><?php echo set_value( 'address');?></textarea>
<label>Address</label>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewcontactpage"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
