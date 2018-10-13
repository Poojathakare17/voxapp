<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class contactpage_model extends CI_Model
{
public function create($phone,$email,$web,$address)
{
$data=array("phone" => $phone,"email" => $email,"web" => $web,"address" => $address);
$query=$this->db->insert( "voxapp_contactpage", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_contactpage")->row();
return $query;
}
function getsinglecontactpage($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_contactpage")->row();
return $query;
}
public function edit($id,$phone,$email,$web,$address)
{
if($image=="")
{
$image=$this->contactpage_model->getimagebyid($id);
$image=$image->image;
}
$data=array("phone" => $phone,"email" => $email,"web" => $web,"address" => $address);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_contactpage", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_contactpage` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_contactpage` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_contactpage` ORDER BY `id` 
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
