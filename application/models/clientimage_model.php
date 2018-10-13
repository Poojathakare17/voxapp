<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class clientimage_model extends CI_Model
{
public function create($image,$order,$status,$clientid)
{
$data=array("image" => $image,"order" => $order,"status" => $status,"clientid" => $clientid);
$query=$this->db->insert( "voxapp_clientimage", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_clientimage")->row();
return $query;
}
function getsingleclientimage($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_clientimage")->row();
return $query;
}
public function edit($id,$image,$order,$status,$clientid)
{
if($image=="")
{
$image=$this->clientimage_model->getimagebyid($id);
$image=$image->image;
}
$data=array("image" => $image,"order" => $order,"status" => $status,"clientid" => $clientid);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_clientimage", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_clientimage` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_clientimage` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_clientimage` ORDER BY `id` 
                    ASC")->result();
$return=array(
"" => "Select Option"
);
foreach($query as $row)
{
$return[$row->id]=$row->name;
}
return $return;
}
}
?>
