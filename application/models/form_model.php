<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class form_model extends CI_Model
{
public function create($name,$email,$phone,$company,$tickettype,$message,$file)
{
$data=array("name" => $name,"email" => $email,"phone" => $phone,"company" => $company,"tickettype" => $tickettype,"message" => $message,"file" => $file);
$query=$this->db->insert( "voxapp_form", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_form")->row();
return $query;
}
function getsingleform($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_form")->row();
return $query;
}
public function edit($id,$name,$email,$phone,$company,$tickettype,$message,$file)
{
if($image=="")
{
$image=$this->form_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name,"email" => $email,"phone" => $phone,"company" => $company,"tickettype" => $tickettype,"message" => $message,"file" => $file);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_form", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_form` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_form` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_form` ORDER BY `id` 
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
