<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class slider_model extends CI_Model
{
public function create($name,$order,$status,$image)
{
$data=array("name" => $name,"order" => $order,"status" => $status,"image" => $image);
$query=$this->db->insert( "voxapp_slider", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_slider")->row();
return $query;
}
function getsingleslider($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_slider")->row();
return $query;
}
public function edit($id,$name,$order,$status,$image)
{
if($image=="")
{
$image=$this->slider_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name,"order" => $order,"status" => $status,"image" => $image);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_slider", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_slider` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_slider` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_slider` ORDER BY `id` 
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
