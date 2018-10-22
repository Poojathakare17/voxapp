<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
    public function getOrderingDone()
    {
        $orderby=$this->input->get("orderby");
        $ids=$this->input->get("ids");
        $ids=explode(",",$ids);
        $tablename=$this->input->get("tablename");
        $where=$this->input->get("where");
        if($where == "" || $where=="undefined")
        {
            $where=1;
        }
        $access = array(
            '1',
        );
        $this->checkAccess($access);
        $i=1;
        foreach($ids as $id)
        {
            //echo "UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = `$id` AND $where";
            $this->db->query("UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = '$id' AND $where");
            $i++;
            //echo "/n";
        }
        $data["message"]=true;
        $this->load->view("json",$data);
        
    }
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data['gender']=$this->user_model->getgenderdropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');
            
            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            	
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`logintype`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['gender']=$this->user_model->getgenderdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');
            
            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    public function viewcart()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcart";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewcartjson?id=").$this->input->get('id');
$data["title"]="View cart";
$this->load->view("templatewith2",$data);
}
function viewcartjson()
{
    $id=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_cart`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_cart`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_cart`.`quantity`";
$elements[2]->sort="1";
$elements[2]->header="Quantity";
$elements[2]->alias="quantity";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_cart`.`product`";
$elements[3]->sort="1";
$elements[3]->header="Product";
$elements[3]->alias="product";
$elements[4]=new stdClass();
$elements[4]->field="`fynx_cart`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="timestamp";
    
$elements[5]=new stdClass();
$elements[5]->field="`fynx_cart`.`size`";
$elements[5]->sort="1";
$elements[5]->header="Size";
$elements[5]->alias="size";

$elements[6]=new stdClass();
$elements[6]->field="`fynx_cart`.`color`";
$elements[6]->sort="1";
$elements[6]->header="Color";
$elements[6]->alias="color";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_cart`","WHERE `fynx_cart`.`user`='$id'");
$this->load->view("json",$data);
}
    public function viewwishlist()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewwishlist";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewwishlistjson?id=".$this->input->get('id'));
$data["title"]="View wishlist";
$this->load->view("templatewith2",$data);
}
function viewwishlistjson()
{
    $user=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_wishlist`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_wishlist`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_wishlist`.`product`";
$elements[2]->sort="1";
$elements[2]->header="Product";
$elements[2]->alias="product";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_wishlist`.`timestamp`";
$elements[3]->sort="1";
$elements[3]->header="Timestamp";
$elements[3]->alias="timestamp";
    
$elements[4]=new stdClass();
$elements[4]->field="`fynx_product`.`name`";
$elements[4]->sort="1";
$elements[4]->header="Product Name";
$elements[4]->alias="productname";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_wishlist` LEFT OUTER JOIN `fynx_product` ON `fynx_product`.`id`=`fynx_wishlist`.`product`","WHERE `fynx_wishlist`.`user`='$user'");
$this->load->view("json",$data);
}
    
    
    
    
public function viewslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewslider";
$data["base_url"]=site_url("site/viewsliderjson");
$data["title"]="View slider";
$this->load->view("template",$data);
}
function viewsliderjson()
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
$elements[2]->field="`voxapp_slider`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_slider`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_slider`.`image`";
$elements[4]->sort="1";
$elements[4]->header="Image";
$elements[4]->alias="image";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_slider`");
$this->load->view("json",$data);
}

public function createslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createslider";
$data["title"]="Create slider";
$data["status"]=$this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
public function createslidersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createslider";
$data["status"]=$this->user_model->getstatusdropdown();
$data["title"]="Create slider";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
if($this->slider_model->create($name,$order,$status,$image)==0)
$data["alerterror"]="New slider could not be created.";
else
$data["alertsuccess"]="slider created Successfully.";
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}
}
public function editslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editslider";
$data["title"]="Edit slider";
$data["status"]=$this->user_model->getstatusdropdown();
$data["before"]=$this->slider_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editslidersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editslider";
$data["status"]=$this->user_model->getstatusdropdown();
$data["title"]="Edit slider";
$data["before"]=$this->slider_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$image=$this->input->get_post("image");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
if($this->slider_model->edit($id,$name,$order,$status,$image)==0)
$data["alerterror"]="New slider could not be Updated.";
else
$data["alertsuccess"]="slider Updated Successfully.";
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}
}
public function deleteslider()
{
$access=array("1");
$this->checkaccess($access);
$this->slider_model->delete($this->input->get("id"));
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}
public function viewfeatures()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewfeatures";
$data["base_url"]=site_url("site/viewfeaturesjson");
$data["title"]="View features";
$this->load->view("template",$data);
}
function viewfeaturesjson()
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_features`");
$this->load->view("json",$data);
}

public function createfeatures()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createfeatures";
$data["title"]="Create features";
$data['status'] = $this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
public function createfeaturessubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("subtitle","Sub Title","trim");
$this->form_validation->set_rules("quote","Quote","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("text","Text","trim");
$this->form_validation->set_rules("banner","Banner","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createfeatures";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Create features";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$subtitle=$this->input->get_post("subtitle");
$quote=$this->input->get_post("quote");
$status=$this->input->get_post("status");
$order=$this->input->get_post("order");
$text=$this->input->get_post("text");

$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
            $filename = "banner";
            $banner = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $banner = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    
                } else {
                    $banner = $this->image_lib->dest_image;
                    
                }
            }
if($this->features_model->create($title,$subtitle,$quote,$status,$order,$text,$banner,$image)==0)
$data["alerterror"]="New features could not be created.";
else
$data["alertsuccess"]="features created Successfully.";
$data["redirect"]="site/viewfeatures";
$this->load->view("redirect",$data);
}
}
public function editfeatures()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editfeatures";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Edit features";
$data["before"]=$this->features_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editfeaturessubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("subtitle","Sub Title","trim");
$this->form_validation->set_rules("quote","Quote","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("text","Text","trim");
$this->form_validation->set_rules("banner","Banner","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editfeatures";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Edit features";
$data["before"]=$this->features_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$subtitle=$this->input->get_post("subtitle");
$quote=$this->input->get_post("quote");
$status=$this->input->get_post("status");
$order=$this->input->get_post("order");
$text=$this->input->get_post("text");
// $banner=$this->input->get_post("banner");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "banner";
            $banner = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $banner = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $banner = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
if($this->features_model->edit($id,$title,$subtitle,$quote,$status,$order,$text,$banner,$image)==0)
$data["alerterror"]="New features could not be Updated.";
else
$data["alertsuccess"]="features Updated Successfully.";
$data["redirect"]="site/viewfeatures";
$this->load->view("redirect",$data);
}
}
public function deletefeatures()
{
$access=array("1");
$this->checkaccess($access);
$this->features_model->delete($this->input->get("id"));
$data["redirect"]="site/viewfeatures";
$this->load->view("redirect",$data);
}
public function viewform()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewform";
$data["base_url"]=site_url("site/viewformjson");
$data["title"]="View form";
$this->load->view("template",$data);
}
function viewformjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_form`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_form`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_form`.`email`";
$elements[2]->sort="1";
$elements[2]->header="Email";
$elements[2]->alias="email";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_form`.`phone`";
$elements[3]->sort="1";
$elements[3]->header="Phone";
$elements[3]->alias="phone";
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_form`.`company`";
$elements[4]->sort="1";
$elements[4]->header="Company";
$elements[4]->alias="company";
$elements[5]=new stdClass();
$elements[5]->field="`voxapp_form`.`tickettype`";
$elements[5]->sort="1";
$elements[5]->header="Ticket Type";
$elements[5]->alias="tickettype";
$elements[6]=new stdClass();
$elements[6]->field="`voxapp_form`.`message`";
$elements[6]->sort="1";
$elements[6]->header="Message";
$elements[6]->alias="message";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_form`");
$this->load->view("json",$data);
}

public function createform()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createform";
$data["title"]="Create form";
$this->load->view("template",$data);
}
public function createformsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("email","Email","trim");
$this->form_validation->set_rules("phone","Phone","trim");
$this->form_validation->set_rules("company","Company","trim");
$this->form_validation->set_rules("tickettype","Ticket Type","trim");
$this->form_validation->set_rules("message","Message","trim");
$this->form_validation->set_rules("file","File","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createform";
$data["title"]="Create form";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$phone=$this->input->get_post("phone");
$company=$this->input->get_post("company");
$tickettype=$this->input->get_post("tickettype");
$message=$this->input->get_post("message");
$file=$this->input->get_post("file");
if($this->form_model->create($name,$email,$phone,$company,$tickettype,$message,$file)==0)
$data["alerterror"]="New form could not be created.";
else
$data["alertsuccess"]="form created Successfully.";
$data["redirect"]="site/viewform";
$this->load->view("redirect",$data);
}
}
public function editform()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editform";
$data["title"]="Edit form";
$data["before"]=$this->form_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editformsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("email","Email","trim");
$this->form_validation->set_rules("phone","Phone","trim");
$this->form_validation->set_rules("company","Company","trim");
$this->form_validation->set_rules("tickettype","Ticket Type","trim");
$this->form_validation->set_rules("message","Message","trim");
$this->form_validation->set_rules("file","File","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editform";
$data["title"]="Edit form";
$data["before"]=$this->form_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$phone=$this->input->get_post("phone");
$company=$this->input->get_post("company");
$tickettype=$this->input->get_post("tickettype");
$message=$this->input->get_post("message");
$file=$this->input->get_post("file");
if($this->form_model->edit($id,$name,$email,$phone,$company,$tickettype,$message,$file)==0)
$data["alerterror"]="New form could not be Updated.";
else
$data["alertsuccess"]="form Updated Successfully.";
$data["redirect"]="site/viewform";
$this->load->view("redirect",$data);
}
}
public function deleteform()
{
$access=array("1");
$this->checkaccess($access);
$this->form_model->delete($this->input->get("id"));
$data["redirect"]="site/viewform";
$this->load->view("redirect",$data);
}
public function viewcontactpage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcontactpage";
$data["base_url"]=site_url("site/viewcontactpagejson");
$data["title"]="View contactpage";
$this->load->view("template",$data);
}
function viewcontactpagejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_contactpage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_contactpage`.`phone`";
$elements[1]->sort="1";
$elements[1]->header="Phone";
$elements[1]->alias="phone";
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_contactpage`.`email`";
$elements[2]->sort="1";
$elements[2]->header="Email";
$elements[2]->alias="email";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_contactpage`.`web`";
$elements[3]->sort="1";
$elements[3]->header="Web";
$elements[3]->alias="web";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_contactpage`");
$this->load->view("json",$data);
}

public function createcontactpage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcontactpage";
$data["title"]="Create contactpage";
$this->load->view("template",$data);
}
public function createcontactpagesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("phone","Phone","trim");
$this->form_validation->set_rules("email","Email","trim");
$this->form_validation->set_rules("web","Web","trim");
$this->form_validation->set_rules("address","Address","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcontactpage";
$data["title"]="Create contactpage";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$phone=$this->input->get_post("phone");
$email=$this->input->get_post("email");
$web=$this->input->get_post("web");
$address=$this->input->get_post("address");
if($this->contactpage_model->create($phone,$email,$web,$address)==0)
$data["alerterror"]="New contactpage could not be created.";
else
$data["alertsuccess"]="contactpage created Successfully.";
$data["redirect"]="site/viewcontactpage";
$this->load->view("redirect",$data);
}
}
public function editcontactpage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcontactpage";
$data["title"]="Edit contactpage";
$data["before"]=$this->contactpage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcontactpagesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("phone","Phone","trim");
$this->form_validation->set_rules("email","Email","trim");
$this->form_validation->set_rules("web","Web","trim");
$this->form_validation->set_rules("address","Address","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcontactpage";
$data["title"]="Edit contactpage";
$data["before"]=$this->contactpage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$phone=$this->input->get_post("phone");
$email=$this->input->get_post("email");
$web=$this->input->get_post("web");
$address=$this->input->get_post("address");
if($this->contactpage_model->edit($id,$phone,$email,$web,$address)==0)
$data["alerterror"]="New contactpage could not be Updated.";
else
$data["alertsuccess"]="contactpage Updated Successfully.";
$data["redirect"]="site/viewcontactpage";
$this->load->view("redirect",$data);
}
}
public function deletecontactpage()
{
$access=array("1");
$this->checkaccess($access);
$this->contactpage_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcontactpage";
$this->load->view("redirect",$data);
}
public function viewclient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewclient";
$data["base_url"]=site_url("site/viewclientjson");
$data["title"]="View client";
$this->load->view("template",$data);
}
function viewclientjson()
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
$elements[7]->field="`voxapp_client`.`image`";
$elements[7]->sort="1";
$elements[7]->header="Image";
$elements[7]->alias="image";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_client`");
$this->load->view("json",$data);
}

public function createclient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createclient";
$data["title"]="Create client";
$this->load->view("template",$data);
}
public function createclientsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("projectname","Project Name","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("year","Year","trim");
$this->form_validation->set_rules("media","Media","trim");
$this->form_validation->set_rules("clientusp","Client usp","trim");
$this->form_validation->set_rules("tect","Technology","trim");
$this->form_validation->set_rules("banner","Banner","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createclient";
$data["title"]="Create client";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$projectname=$this->input->get_post("projectname");
$title=$this->input->get_post("title");
$year=$this->input->get_post("year");
$media=$this->input->get_post("media");
$clientusp=$this->input->get_post("clientusp");
$tect=$this->input->get_post("tect");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
if($this->client_model->create($projectname,$title,$year,$media,$clientusp,$tect,$image)==0)
$data["alerterror"]="New client could not be created.";
else
$data["alertsuccess"]="client created Successfully.";
$data["redirect"]="site/viewclient";
$this->load->view("redirect",$data);
}
}
public function editclient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editclient";
$data["title"]="Edit client";
$data["before"]=$this->client_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editclientsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("projectname","Project Name","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("year","Year","trim");
$this->form_validation->set_rules("media","Media","trim");
$this->form_validation->set_rules("clientusp","Client usp","trim");
$this->form_validation->set_rules("tect","Technology","trim");
$this->form_validation->set_rules("banner","Banner","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editclient";
$data["title"]="Edit client";
$data["before"]=$this->client_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$projectname=$this->input->get_post("projectname");
$title=$this->input->get_post("title");
$year=$this->input->get_post("year");
$media=$this->input->get_post("media");
$clientusp=$this->input->get_post("clientusp");
$tect=$this->input->get_post("tect");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    $image = $this->image_lib->dest_image;
                    
                }
            }
if($this->client_model->edit($id,$projectname,$title,$year,$media,$clientusp,$tect,$image)==0)
$data["alerterror"]="New client could not be Updated.";
else
$data["alertsuccess"]="client Updated Successfully.";
$data["redirect"]="site/viewclient";
$this->load->view("redirect",$data);
}
}
public function deleteclient()
{
$access=array("1");
$this->checkaccess($access);
$this->client_model->delete($this->input->get("id"));
$data["redirect"]="site/viewclient";
$this->load->view("redirect",$data);
}
public function viewclientimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewclientimage";
$data["base_url"]=site_url("site/viewclientimagejson");
$data['clientid'] = $this->client_model->getdropdown();
$data["title"]="View clientimage";
$this->load->view("template",$data);
}
function viewclientimagejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_clientimage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_clientimage`.`image`";
$elements[1]->sort="1";
$elements[1]->header="Image";
$elements[1]->alias="image";
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_clientimage`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_clientimage`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_client`.`projectname`";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_clientimage` LEFT JOIN `voxapp_client` ON `voxapp_clientimage`.`clientid`=`voxapp_client`.`id`");
$this->load->view("json",$data);
}

public function createclientimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createclientimage";
$data['status'] = $this->user_model->getstatusdropdown();
$data['clientid'] = $this->client_model->getdropdown();
$data["title"]="Create clientimage";
$this->load->view("template",$data);
}
public function createclientimagesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("clientid","Client id","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createclientimage";
$data['status'] = $this->user_model->getstatusdropdown();
$data['clientid'] = $this->client_model->getdropdown();
$data["title"]="Create clientimage";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$clientid=$this->input->get_post("clientid");
if($this->clientimage_model->create($image,$order,$status,$clientid)==0)
$data["alerterror"]="New clientimage could not be created.";
else
$data["alertsuccess"]="clientimage created Successfully.";
$data["redirect"]="site/viewclientimage";
$this->load->view("redirect",$data);
}
}
public function editclientimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editclientimage";
$data['status'] = $this->user_model->getstatusdropdown();
$data['clientid'] = $this->client_model->getdropdown();
$data["title"]="Edit clientimage";
$data["before"]=$this->clientimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editclientimagesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("clientid","Client id","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editclientimage";
$data["title"]="Edit clientimage";
$data['status'] = $this->user_model->getstatusdropdown();
$data['clientid'] = $this->client_model->getdropdown();
$data["before"]=$this->clientimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$clientid=$this->input->get_post("clientid");
if($this->clientimage_model->edit($id,$image,$order,$status,$clientid)==0)
$data["alerterror"]="New clientimage could not be Updated.";
else
$data["alertsuccess"]="clientimage Updated Successfully.";
$data["redirect"]="site/viewclientimage";
$this->load->view("redirect",$data);
}
}
public function deleteclientimage()
{
$access=array("1");
$this->checkaccess($access);
$this->clientimage_model->delete($this->input->get("id"));
$data["redirect"]="site/viewclientimage";
$this->load->view("redirect",$data);
}
public function viewblog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewblog";
$data["base_url"]=site_url("site/viewblogjson");
$data["title"]="View blog";
$this->load->view("template",$data);
}
function viewblogjson()
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
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_blog`");
$this->load->view("json",$data);
}

public function createblog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createblog";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Create blog";
$this->load->view("template",$data);
}
public function createblogsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("date","Date","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("text","Text","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createblog";
$data["title"]="Create blog";
$data['status'] = $this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$date=$this->input->get_post("date");
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$text=$this->input->get_post("text");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "logoimage";
            $logoimage = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $logoimage = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $logoimage = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
if($this->blog_model->create($name,$date,$order,$status,$text,$image,$logoimage)==0)
$data["alerterror"]="New blog could not be created.";
else
$data["alertsuccess"]="blog created Successfully.";
$data["redirect"]="site/viewblog";
$this->load->view("redirect",$data);
}
}
public function editblog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editblog";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Edit blog";
$data["before"]=$this->blog_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editblogsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("date","Date","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("text","Text","trim");
$this->form_validation->set_rules("image","Image","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editblog";
$data['status'] = $this->user_model->getstatusdropdown();
$data["title"]="Edit blog";
$data["before"]=$this->blog_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$date=$this->input->get_post("date");
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$text=$this->input->get_post("text");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "logoimage";
$logoimage = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $logoimage = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $logoimage = $this->image_lib->dest_image;
        //return false;
        
    }
}
if($this->blog_model->edit($id,$name,$date,$order,$status,$text,$image,$logoimage)==0)
$data["alerterror"]="New blog could not be Updated.";
else
$data["alertsuccess"]="blog Updated Successfully.";
$data["redirect"]="site/viewblog";
$this->load->view("redirect",$data);
}
}
public function deleteblog()
{
$access=array("1");
$this->checkaccess($access);
$this->blog_model->delete($this->input->get("id"));
$data["redirect"]="site/viewblog";
$this->load->view("redirect",$data);
}
public function viewtestimonials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewtestimonials";
$data["base_url"]=site_url("site/viewtestimonialsjson");
$data["title"]="View testimonials";
$this->load->view("template",$data);
}
function viewtestimonialsjson()
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_testimonials`");
$this->load->view("json",$data);
}

public function createtestimonials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createtestimonials";
$data["title"]="Create testimonials";
$this->load->view("template",$data);
}
public function createtestimonialssubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("designation","Designation","trim");
$this->form_validation->set_rules("rating","Rating","trim");
$this->form_validation->set_rules("text","Text","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createtestimonials";
$data["title"]="Create testimonials";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
$designation=$this->input->get_post("designation");
$rating=$this->input->get_post("rating");
$text=$this->input->get_post("text");
if($this->testimonials_model->create($name,$image,$designation,$rating,$text)==0)
$data["alerterror"]="New testimonials could not be created.";
else
$data["alertsuccess"]="testimonials created Successfully.";
$data["redirect"]="site/viewtestimonials";
$this->load->view("redirect",$data);
}
}
public function edittestimonials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edittestimonials";
$data["title"]="Edit testimonials";
$data["before"]=$this->testimonials_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edittestimonialssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("designation","Designation","trim");
$this->form_validation->set_rules("rating","Rating","trim");
$this->form_validation->set_rules("text","Text","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edittestimonials";
$data["title"]="Edit testimonials";
$data["before"]=$this->testimonials_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
$designation=$this->input->get_post("designation");
$rating=$this->input->get_post("rating");
$text=$this->input->get_post("text");
if($this->testimonials_model->edit($id,$name,$image,$designation,$rating,$text)==0)
$data["alerterror"]="New testimonials could not be Updated.";
else
$data["alertsuccess"]="testimonials Updated Successfully.";
$data["redirect"]="site/viewtestimonials";
$this->load->view("redirect",$data);
}
}
public function deletetestimonials()
{
$access=array("1");
$this->checkaccess($access);
$this->testimonials_model->delete($this->input->get("id"));
$data["redirect"]="site/viewtestimonials";
$this->load->view("redirect",$data);
}
public function viewgallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgallerycategory";
$data["base_url"]=site_url("site/viewgallerycategoryjson");
$data["title"]="View gallerycategory";
$this->load->view("template",$data);
}
function viewgallerycategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_gallerycategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_gallerycategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_gallerycategory`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_gallerycategory`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_gallerycategory`");
$this->load->view("json",$data);
}

public function creategallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategallerycategory";
$data["title"]="Create gallerycategory";
$data['status'] = $this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
public function creategallerycategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategallerycategory";
$data["title"]="Create gallerycategory";
$data['status'] = $this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
if($this->gallerycategory_model->create($name,$image,$order,$status)==0)
$data["alerterror"]="New gallerycategory could not be created.";
else
$data["alertsuccess"]="gallerycategory created Successfully.";
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
}
public function editgallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgallerycategory";
$data["title"]="Edit gallerycategory";
$data['status'] = $this->user_model->getstatusdropdown();
$data["before"]=$this->gallerycategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgallerycategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgallerycategory";
$data["title"]="Edit gallerycategory";
$data['status'] = $this->user_model->getstatusdropdown();
$data["before"]=$this->gallerycategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
if($this->gallerycategory_model->edit($id,$name,$image,$order,$status)==0)
$data["alerterror"]="New gallerycategory could not be Updated.";
else
$data["alertsuccess"]="gallerycategory Updated Successfully.";
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
}
public function deletegallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$this->gallerycategory_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
public function viewgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgallery";
$data["base_url"]=site_url("site/viewgalleryjson");
$data['gallerycategory'] = $this->gallerycategory_model->getdropdown();
$data["title"]="View gallery";
$this->load->view("template",$data);
}
function viewgalleryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`voxapp_gallery`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`voxapp_gallery`.`image`";
$elements[1]->sort="1";
$elements[1]->header="Image";
$elements[1]->alias="image";
$elements[2]=new stdClass();
$elements[2]->field="`voxapp_gallery`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";
$elements[3]=new stdClass();
$elements[3]->field="`voxapp_gallery`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";
$elements[4]=new stdClass();
$elements[4]->field="`voxapp_gallerycategory`.`name`";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `voxapp_gallery` LEFT JOIN `voxapp_gallerycategory` ON `voxapp_gallerycategory`.`id`=`voxapp_gallery`.`gallerycategory`");
$this->load->view("json",$data);
}

public function creategallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategallery";
$data['gallerycategory'] = $this->gallerycategory_model->getdropdown();
$data["title"]="Create gallery";
$data['status'] = $this->user_model->getstatusdropdown();
$this->load->view("template",$data);
}
public function creategallerysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("gallerycategory","Gallery Category","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategallery";
$data['status'] = $this->user_model->getstatusdropdown();
$data['gallerycategory'] = $this->gallerycategory_model->getdropdown();
$data["title"]="Create gallery";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $filename = "image";
            $image = "";
            if ($this->upload->do_upload($filename)) {
                $uploaddata = $this->upload->data();
                $image = $uploaddata['file_name'];
                $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE; ///add this
                $config_r['width'] = 800;
                $config_r['height'] = 800;
                $config_r['quality'] = 100;
                //end of configs
                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if (!$this->image_lib->resize()) {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                    
                } else {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image = $this->image_lib->dest_image;
                    //return false;
                    
                }
            }
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$gallerycategory=$this->input->get_post("gallerycategory");
if($this->gallery_model->create($image,$order,$status,$gallerycategory)==0)
$data["alerterror"]="New gallery could not be created.";
else
$data["alertsuccess"]="gallery created Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function editgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data['status'] = $this->user_model->getstatusdropdown();
$data['gallerycategory'] = $this->gallerycategory_model->getdropdown();
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgallerysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("gallerycategory","Gallery Category","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data['status'] = $this->user_model->getstatusdropdown();
$data['gallerycategory'] = $this->gallerycategory_model->getdropdown();
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename = "image";
$image = "";
if ($this->upload->do_upload($filename)) {
    $uploaddata = $this->upload->data();
    $image = $uploaddata['file_name'];
    $config_r['source_image'] = './uploads/' . $uploaddata['file_name'];
    $config_r['maintain_ratio'] = TRUE;
    $config_t['create_thumb'] = FALSE; ///add this
    $config_r['width'] = 800;
    $config_r['height'] = 800;
    $config_r['quality'] = 100;
    //end of configs
    $this->load->library('image_lib', $config_r);
    $this->image_lib->initialize($config_r);
    if (!$this->image_lib->resize()) {
        echo "Failed." . $this->image_lib->display_errors();
        //return false;
        
    } else {
        //print_r($this->image_lib->dest_image);
        //dest_image
        $image = $this->image_lib->dest_image;
        //return false;
        
    }
}
$order=$this->input->get_post("order");
$status=$this->input->get_post("status");
$gallerycategory=$this->input->get_post("gallerycategory");
if($this->gallery_model->edit($id,$image,$order,$status,$gallerycategory)==0)
$data["alerterror"]="New gallery could not be Updated.";
else
$data["alertsuccess"]="gallery Updated Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function deletegallery()
{
$access=array("1");
$this->checkaccess($access);
$this->gallery_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}

}
?>
