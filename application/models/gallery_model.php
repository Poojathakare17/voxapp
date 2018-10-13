<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class gallery_model extends CI_Model
{
public function create($image,$order,$status,$gallerycategory)
{
$data=array("image" => $image,"order" => $order,"status" => $status,"gallerycategory" => $gallerycategory);
$query=$this->db->insert( "voxapp_gallery", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_gallery")->row();
return $query;
}
function getsinglegallery($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_gallery")->row();
return $query;
}
public function edit($id,$image,$order,$status,$gallerycategory)
{
if($image=="")
{
$image=$this->gallery_model->getimagebyid($id);
$image=$image->image;
}
$data=array("image" => $image,"order" => $order,"status" => $status,"gallerycategory" => $gallerycategory);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_gallery", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_gallery` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_gallery` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_gallery` ORDER BY `id` 
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
