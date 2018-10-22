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
public function submitContactForm($name,$email,$company,$phone,$message,$file,$tickettype)
{
    $data=array("name" => $name,"email" => $email,"company" => $company,"phone" => $phone,"message" => $message,"tickettype" => $tickettype,"file" => $file);
    $query=$this->db->insert( "contact", $data );
    $id=$this->db->insert_id();
        //send email
        $email   = "support@voxpopulime.com";
        $subject = "Support request from ".$company;
        $msg = '<p>Name : '.$name.'</p><p>Email : '.$email.'</p><p>Company : '.$company.'</p><p>Ticket type : '.$tickettype.'</p><p>Message : '.$message.'</p>';
        send_mail($email,$subject,$msg);
        function send_mail($email,$subject,$msg) {
        $api_key="key-577219c50a48fc187b166aa96a949dda";/* Api Key got from https://mailgun.com/cp/my_account */
        $domain ="amanfiroz.com";/* Domain Name you given to Mailgun */
        $parameters = array('from' => 'Voxapp <no-reply@voxmobileapp.com>',
            'to' => $email,
            'subject' => $subject,
            'html' => $msg,
            'attachment[1]' => curl_file_create($filename, 'application/pdf', 'example.pdf'));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/'.$domain.'/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'from' => 'Voxapp <no-reply@voxmobileapp.com>',
            'to' => $email,
            'subject' => $subject,
            'html' => $msg
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        //email sent
    $obj = new stdClass();
    if(!$query){
        $obj ->value=false;
    }
    else{
        $obj ->value=true;
    }
    return  $obj;
}
}
}
?>
