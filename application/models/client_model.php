<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class client_model extends CI_Model
{
public function create($projectname,$title,$year,$media,$clientusp,$tect,$banner)
{
$data=array("projectname" => $projectname,"title" => $title,"year" => $year,"media" => $media,"clientusp" => $clientusp,"tect" => $tect,"banner" => $banner);
$query=$this->db->insert( "voxapp_client", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("voxapp_client")->row();
return $query;
}
function getsingleclient($id){
$this->db->where("id",$id);
$query=$this->db->get("voxapp_client")->row();
return $query;
}
public function edit($id,$projectname,$title,$year,$media,$clientusp,$tect,$banner)
{
if($image=="")
{
$image=$this->client_model->getimagebyid($id);
$image=$image->image;
}
$data=array("projectname" => $projectname,"title" => $title,"year" => $year,"media" => $media,"clientusp" => $clientusp,"tect" => $tect,"banner" => $banner);
$this->db->where( "id", $id );
$query=$this->db->update( "voxapp_client", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `voxapp_client` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `voxapp_client` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `voxapp_client` ORDER BY `id` 
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
