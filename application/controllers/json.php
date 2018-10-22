<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getAllSliders()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_slider`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements[1]=new stdClass();
$elements[1]->field="`voxapp_slider`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements[2]=new stdClass();
$elements[2]->field="`voxapp_slider`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="order";
$orderorder="DESC";
}
$data["message1"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_slider`","WHERE `status` =1");
$data["message"]=$data["message1"]->queryresult;
$this->load->view("json",$data);
}
public function getsingleslider()
{
$id=$this->input->get_post("id");
$data["message"]=$this->slider_model->getsingleslider($id);
$this->load->view("json",$data);
}
function getAllFeatures()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_features`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements[1]=new stdClass();
$elements[1]->field="`voxapp_features`.`title`";
$elements[1]->sort="1";
$elements[1]->header="Title";
$elements[1]->alias="title";

$elements[2]=new stdClass();
$elements[2]->field="`voxapp_features`.`subtitle`";
$elements[2]->sort="1";
$elements[2]->header="Sub Title";
$elements[2]->alias="subtitle";

$elements[3]=new stdClass();
$elements[3]->field="`voxapp_features`.`quote`";
$elements[3]->sort="1";
$elements[3]->header="Quote";
$elements[3]->alias="quote";

$elements[4]=new stdClass();
$elements[4]->field="`voxapp_features`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$elements[5]=new stdClass();
$elements[5]->field="`voxapp_features`.`order`";
$elements[5]->sort="1";
$elements[5]->header="Order";
$elements[5]->alias="order";

$elements[6]=new stdClass();
$elements[6]->field="`voxapp_features`.`text`";
$elements[6]->sort="1";
$elements[6]->header="Text";
$elements[6]->alias="text";

$elements[7]=new stdClass();
$elements[7]->field="`voxapp_features`.`banner`";
$elements[7]->sort="1";
$elements[7]->header="Banner";
$elements[7]->alias="banner";

$elements[8]=new stdClass();
$elements[8]->field="`voxapp_features`.`image`";
$elements[8]->sort="1";
$elements[8]->header="Image";
$elements[8]->alias="image";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message1"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_features`");
$data["message"]=$data["message1"]->queryresult;
$this->load->view("json",$data);
}
public function getsinglefeatures()
{
$id=$this->input->get_post("id");
$data["message"]=$this->features_model->getsinglefeatures($id);
$this->load->view("json",$data);
}
function getallform()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_form`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_form`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_form`.`email`";
$elements[2]->sort="1";
$elements[2]->header="Email";
$elements[2]->alias="email";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_form`.`phone`";
$elements[3]->sort="1";
$elements[3]->header="Phone";
$elements[3]->alias="phone";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_form`.`company`";
$elements[4]->sort="1";
$elements[4]->header="Company";
$elements[4]->alias="company";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`voxapp_form`.`tickettype`";
$elements[5]->sort="1";
$elements[5]->header="Ticket Type";
$elements[5]->alias="tickettype";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`voxapp_form`.`message`";
$elements[6]->sort="1";
$elements[6]->header="Message";
$elements[6]->alias="message";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`voxapp_form`.`file`";
$elements[7]->sort="1";
$elements[7]->header="File";
$elements[7]->alias="file";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_form`");
$this->load->view("json",$data);
}
public function getsingleform()
{
$id=$this->input->get_post("id");
$data["message"]=$this->form_model->getsingleform($id);
$this->load->view("json",$data);
}
function getallcontactpage()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_contactpage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_contactpage`.`phone`";
$elements[1]->sort="1";
$elements[1]->header="Phone";
$elements[1]->alias="phone";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_contactpage`.`email`";
$elements[2]->sort="1";
$elements[2]->header="Email";
$elements[2]->alias="email";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_contactpage`.`web`";
$elements[3]->sort="1";
$elements[3]->header="Web";
$elements[3]->alias="web";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_contactpage`.`address`";
$elements[4]->sort="1";
$elements[4]->header="Address";
$elements[4]->alias="address";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_contactpage`");
$this->load->view("json",$data);
}
public function getsinglecontactpage()
{
$id=$this->input->get_post("id");
$data["message"]=$this->contactpage_model->getsinglecontactpage($id);
$this->load->view("json",$data);
}
function getallclient()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_client`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements[1]=new stdClass();
$elements[1]->field="`voxapp_client`.`projectname`";
$elements[1]->sort="1";
$elements[1]->header="Project Name";
$elements[1]->alias="projectname";

$elements[2]=new stdClass();
$elements[2]->field="`voxapp_client`.`title`";
$elements[2]->sort="1";
$elements[2]->header="Title";
$elements[2]->alias="title";

$elements[3]=new stdClass();
$elements[3]->field="`voxapp_client`.`year`";
$elements[3]->sort="1";
$elements[3]->header="Year";
$elements[3]->alias="year";

$elements[4]=new stdClass();
$elements[4]->field="`voxapp_client`.`media`";
$elements[4]->sort="1";
$elements[4]->header="Media";
$elements[4]->alias="media";

$elements[5]=new stdClass();
$elements[5]->field="`voxapp_client`.`clientusp`";
$elements[5]->sort="1";
$elements[5]->header="Client usp";
$elements[5]->alias="clientusp";

$elements[6]=new stdClass();
$elements[6]->field="`voxapp_client`.`tect`";
$elements[6]->sort="1";
$elements[6]->header="Technology";
$elements[6]->alias="tect";

$elements[7]=new stdClass();
$elements[7]->field="`voxapp_client`.`banner`";
$elements[7]->sort="1";
$elements[7]->header="Banner";
$elements[7]->alias="banner";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_client`");
$this->load->view("json",$data);
}
public function getsingleclient()
{
$id=$this->input->get_post("id");
$data["message"]=$this->client_model->getsingleclient($id);
$this->load->view("json",$data);
}
function getallclientimage()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_clientimage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_clientimage`.`image`";
$elements[1]->sort="1";
$elements[1]->header="Image";
$elements[1]->alias="image";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_clientimage`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_clientimage`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_clientimage`.`clientid`";
$elements[4]->sort="1";
$elements[4]->header="Client id";
$elements[4]->alias="clientid";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_clientimage`");
$this->load->view("json",$data);
}
public function getsingleclientimage()
{
$id=$this->input->get_post("id");
$data["message"]=$this->clientimage_model->getsingleclientimage($id);
$this->load->view("json",$data);
}
function getallblog()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_blog`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements[1]=new stdClass();
$elements[1]->field="`voxapp_blog`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements[2]=new stdClass();
$elements[2]->field="`voxapp_blog`.`date`";
$elements[2]->sort="1";
$elements[2]->header="Date";
$elements[2]->alias="date";

$elements[3]=new stdClass();
$elements[3]->field="`voxapp_blog`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$elements[4]=new stdClass();
$elements[4]->field="`voxapp_blog`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$elements[5]=new stdClass();
$elements[5]->field="`voxapp_blog`.`text`";
$elements[5]->sort="1";
$elements[5]->header="Text";
$elements[5]->alias="text";

$elements[6]=new stdClass();
$elements[6]->field="`voxapp_blog`.`image`";
$elements[6]->sort="1";
$elements[6]->header="Image";
$elements[6]->alias="image";

$elements[7]=new stdClass();
$elements[7]->field="`voxapp_blog`.`logoimage`";
$elements[7]->sort="1";
$elements[7]->header="Logo image";
$elements[7]->alias="logoimage";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message1"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_blog`");
$data["message"]=$data["message1"]->queryresult;
$this->load->view("json",$data);
}
public function getsingleblog()
{
$id=$this->input->get_post("id");
$data["message"]=$this->blog_model->getsingleblog($id);
$this->load->view("json",$data);
}
function getAllTestimonials()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_testimonials`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements[1]=new stdClass();
$elements[1]->field="`voxapp_testimonials`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements[2]=new stdClass();
$elements[2]->field="`voxapp_testimonials`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements[3]=new stdClass();
$elements[3]->field="`voxapp_testimonials`.`designation`";
$elements[3]->sort="1";
$elements[3]->header="Designation";
$elements[3]->alias="designation";

$elements[4]=new stdClass();
$elements[4]->field="`voxapp_testimonials`.`rating`";
$elements[4]->sort="1";
$elements[4]->header="Rating";
$elements[4]->alias="rating";

$elements[5]=new stdClass();
$elements[5]->field="`voxapp_testimonials`.`text`";
$elements[5]->sort="1";
$elements[5]->header="Text";
$elements[5]->alias="text";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message1"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_testimonials`");
$data["message"]=$data["message1"]->queryresult;
$this->load->view("json",$data);
}
public function getsingletestimonials()
{
$id=$this->input->get_post("id");
$data["message"]=$this->testimonials_model->getsingletestimonials($id);
$this->load->view("json",$data);
}
function getallgallerycategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_gallerycategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_gallerycategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_gallerycategory`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_gallerycategory`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_gallerycategory`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_gallerycategory`");
$this->load->view("json",$data);
}
public function getsinglegallerycategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->gallerycategory_model->getsinglegallerycategory($id);
$this->load->view("json",$data);
}
function getallgallery()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_gallery`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_gallery`.`image`";
$elements[1]->sort="1";
$elements[1]->header="Image";
$elements[1]->alias="image";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_gallery`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_gallery`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_gallery`.`gallerycategory`";
$elements[4]->sort="1";
$elements[4]->header="Gallery Category";
$elements[4]->alias="gallerycategory";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_gallery`");
$this->load->view("json",$data);
}
public function getsinglegallery()
{
$id=$this->input->get_post("id");
$data["message"]=$this->gallery_model->getsinglegallery($id);
$this->load->view("json",$data);
}
public function fileUpload() {
    $date = new DateTime();
      $imageName = "image-".rand(0, 100000)."-".$date->getTimestamp().".jpg";
      if(move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/".$imageName)){
             $data["message"]=$imageName;
              $this->load->view("json",$data);
      }else{
          $data["message"]=false;
              $this->load->view("json",$data);
      }
    //     $date = new DateTime();
    //     $config['upload_path'] = './uploads/';
    //     $config['allowed_types'] = 'gif|jpg|png|jpeg';
    //     $config['max_size']	= '10000000';
    //     $config['overwrite']	= true;
    //     $config['file_name']	= "image-".rand(0, 100000).$date;
    //     $this->load->library('upload', $config);
    //     if (  $this->upload->do_upload("file"))
    //     {
    //         $uploaddata = $this->upload->data();
    //         $image=$uploaddata['file_name'];
    //         $data["message"]=$image;
    //         $this->load->view("json",$data);
    //     }
    //    else
    //     {
    //         $data["message"]=$this->upload->display_errors();;
    //         $this->load->view("json",$data);
    //     }
   }
   public function submitContactForm()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $name=$data['name'];
    $email=$data['email'];
    $company=$data['company'];
    $phone=$data['phone'];
    $message=$data['message'];
    $file=$data['file'];
    $tickettype=$data['tickettype'];
    if(empty($data)){
    $data['message']=0;
    }
    else{
    $data['message']=$this->form_model->submitContactForm($name,$email,$company,$phone,$message,$file,$tickettype);
    }
    $this->load->view('json',$data);
}
public function getAllClientInfo()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $data['message']=$this->client_model->getAllClientInfo();
    $this->load->view("json",$data);
}
public function getAllGalleryImages()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $data['message']=$this->gallerycategory_model->getAllGalleryImages();
    $this->load->view("json",$data);
}
public function getpass()
{
    $this->load->library('encrypt');
    $pass = $this->encrypt->encode('step@123');
    $pass_decode = $this->encrypt->decode($pass);
    echo "  pass ".$pass;
    echo "  pass decode ".$pass_decode;
}
} ?>