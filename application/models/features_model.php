<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class features_model extends CI_Model
{
public function create($title,$subtitle,$quote,$status,$order,$text,$banner,$image)
{
$data=array("title" => $title,"subtitle" => $subtitle,"quote" => $quote,"status" => $status,"order" => $order,"text" => $text,"banner" => $banner,"image" => $image);
$query=$this->db->insert( "voxapp_features", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_features")->row();
return $query;
}
function getsinglefeatures($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_features")->row();
return $query;
}
public function edit($id,$title,$subtitle,$quote,$status,$order,$text,$banner,$image)
{
if($image=="")
{
$image=$this->features_model->getimagebyid($id);
$image=$image->image;
}
$data=array("title" => $title,"subtitle" => $subtitle,"quote" => $quote,"status" => $status,"order" => $order,"text" => $text,"banner" => $banner,"image" => $image);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_features", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_features` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_features` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_features` ORDER BY `id` 
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
