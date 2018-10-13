<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit contactpage</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editcontactpagesubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Phone">Phone</label>
<input type="text" id="Phone" name="phone" value='<?php echo set_value('phone',$before->phone);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Email">Email</label>
<input type="email" id="Email" name="email" value='<?php echo set_value('email',$before->email);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Web">Web</label>
<input type="text" id="Web" name="web" value='<?php echo set_value('web',$before->web);?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Address</label>
<textarea name="address" placeholder="Enter text ..."><?php echo set_value( 'address',$before->address);?></textarea>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewcontactpage"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
