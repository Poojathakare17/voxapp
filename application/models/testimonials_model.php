<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class testimonials_model extends CI_Model
{
public function create($name,$image,$designation,$rating,$text)
{
$data=array("name" => $name,"image" => $image,"designation" => $designation,"rating" => $rating,"text" => $text);
$query=$this->db->insert( "voxapp_testimonials", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_testimonials")->row();
return $query;
}
function getsingletestimonials($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_testimonials")->row();
return $query;
}
public function edit($id,$name,$image,$designation,$rating,$text)
{
if($image=="")
{
$image=$this->testimonials_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name,"image" => $image,"designation" => $designation,"rating" => $rating,"text" => $text);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_testimonials", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_testimonials` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_testimonials` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_testimonials` ORDER BY `id` 
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
