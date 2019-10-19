<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Main extends CI_Controller {  
      //functions  
      function login()  
      {  
           //http://localhost/flores/index.php/main/login  
           $data['title'] = 'CodeIgniter Simple Login Form With Sessions';  
           $this->load->view("login", $data);  
      }  
      function login_validation()  
      {  
           $this->load->library('form_validation');  
           $this->form_validation->set_rules('username', 'Username', 'required');  
           $this->form_validation->set_rules('password', 'Password', 'required');  
           if($this->form_validation->run())  
           {  
                //true  
                $username = $this->input->post('username');  
                $password = $this->input->post('password');  
                //model function  
                $this->load->model('main_model');  
                if($this->main_model->can_login($username, $password))  
                {  
                     $session_data = array(  
                          'username'     =>     $username  
                     );  
                     $this->session->set_userdata($session_data);  
                     redirect(base_url() . 'main/enter');  
                }  
                else  
                {  
                     $this->session->set_flashdata('error', 'Invalid Username and Password');  
                     redirect(base_url() . 'main/login');  
                }  
           }  
           else  
           {  
                //false  
                $this->login();  
           }  
      }  
      function enter(){  
           if($this->session->userdata('username') != '')  
           {  
                echo '<h2>Hi - '.$this->session->userdata('username').'</h2>';  
                echo '<label><a href="'.base_url().'main/logout">Logout</a></label>';  
                redirect(base_url() . 'main/image_upload');  
           }  
           else  
           {  
                redirect(base_url() . 'main/login');  
                
           }  
      }  
      function logout()  
      {  
           $this->session->unset_userdata('username');  
           redirect(base_url() . 'main/login');  
      }
      function image_upload()  
      {  
        echo '<h2 >Hi - '.$this->session->userdata('username').'</h2>';  
        echo '<label><a href="'.base_url().'main/logout">Logout</a></label>'; 
           $data['title'] = "Upload Image using Ajax JQuery in CodeIgniter";  
           $this->load->view('image_upload', $data);  
      }  
      function ajax_upload()  
      {  
           if(isset($_FILES["image_file"]["name"]))  
           {  
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('image_file'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
                     echo '<img src="'.base_url().'upload/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';  
                }  
           }  
      }  
 }