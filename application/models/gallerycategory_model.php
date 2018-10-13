<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class gallerycategory_model extends CI_Model
{
public function create($name,$image,$order,$status)
{
$data=array("name" => $name,"image" => $image,"order" => $order,"status" => $status);
$query=$this->db->insert( "voxapp_gallerycategory", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_gallerycategory")->row();
return $query;
}
function getsinglegallerycategory($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_gallerycategory")->row();
return $query;
}
public function edit($id,$name,$image,$order,$status)
{
if($image=="")
{
$image=$this->gallerycategory_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name,"image" => $image,"order" => $order,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_gallerycategory", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_gallerycategory` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_gallerycategory` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_gallerycategory` ORDER BY `id` 
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
