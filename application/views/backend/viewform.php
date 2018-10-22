<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable">
<?php $this->chintantable->createsearch("form");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">ID</th>
<th data-field="name">Name</th>
<th data-field="email">Email</th>
<th data-field="phone">Phone</th>
<th data-field="company">Company</th>
<th data-field="tickettype">Ticket Type</th>
<th data-field="message">Message</th>
<th data-field="file">File</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
</div>
</div>
<script>
function drawtable(resultrow) {
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.email + "</td><td>" + resultrow.phone + "</td><td>" + resultrow.company + "</td><td>" + resultrow.tickettype + "</td><td>" + resultrow.message + "</td><td>" + resultrow.file + "</td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
