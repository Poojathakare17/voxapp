<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit form</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editformsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Email">Email</label>
<input type="text" id="Email" name="email" value='<?php echo set_value('email',$before->email);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Phone">Phone</label>
<input type="text" id="Phone" name="phone" value='<?php echo set_value('phone',$before->phone);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Company">Company</label>
<input type="text" id="Company" name="company" value='<?php echo set_value('company',$before->company);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Ticket Type">Ticket Type</label>
<input type="text" id="Ticket Type" name="tickettype" value='<?php echo set_value('tickettype',$before->tickettype);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Message">Message</label>
<input type="text" id="Message" name="message" value='<?php echo set_value('message',$before->message);?>'>
</div>
</div>
<input type="file" id="normal-field" class="form-control" name="file" value='<?php echo set_value('file',$before->file);?>'>
<div class="row">
<div class="file-field input-field col s12 m6">
<span class="img-center big">
NANfile; ?>" ></span>
<div class="btn blue darken-4">
<span>File</span>
<input type="file" name="file" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('file',$before->file);?>'>
<?php if($before->image == "") { } else { ?> <?php } ?>
</div>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewform"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
