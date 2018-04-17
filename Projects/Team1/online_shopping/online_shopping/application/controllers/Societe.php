<?php
class Societe extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Fournisseur_model');
        $this->load->model('Societe_model');
        $this->load->helper('url_helper');
        $this->load->helper('url');
        //$this->config->set_item('language', 'chinese');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        if (!isset($_SESSION['logged_in'])||$_SESSION['version']!='base'){
            redirect(base_url('/index.php/login/index/'));
        }
        $this->config->set_item('language', $_SESSION['language']);
        $this->lang->load('menu');
        $this->load->helper('language');
    }
    public function show_societes(){
        $data['title']='合伙人列表';
        $data['societe']=$this->Societe_model->get_all_societes();
        $this->load->view('templates/header', $data);
        $this->load->view('societe/show_societes',$data);
        $this->load->view('templates/footer');
    }
    public function create_fournisseur()
    {
        $data['title'] = 'Create a supplier';
        $date['pays']=$this->Societe_model->get_pays();
        //$data['mode_reglement']=$this->Societe_model->get_mode_reglement();
        //$data['cond_reglement']=$this->Societe_model->get_cond_reglement();


        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('last_name', 'last_name', 'required');
        //$this->form_validation->set_rules('label', 'Label', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('societe/create_fournisseur',$data);
            $this->load->view('templates/footer');

        }
        else
        {
            $rowid= $this->Societe_model->add_fournisseur();
            $this->load->helper('url');
            redirect(base_url('/index.php/Societe/info_societe/').$rowid);
        }


    }
    public function create_client(){

    }
    public function info_societe($rowid=null){
        $data['societe']=$this->Societe_model->get_societe_by_rowid($rowid);
        //如果是供应商 if...因为现在还没添加客户界面
        $data['categ_selected']=$this->Societe_model->get_fournisseur_categ($rowid);//获得已经选择的标签


        $this->load->view('templates/header', $data);
        $this->load->view('societe/info_societe' , $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit_societe($rowid=null){
        $data['societe']=$this->Societe_model->get_societe_by_rowid($rowid);
        //如果是供应商 if...因为现在还没添加客户界面
        $data['categ_selected']=$this->Societe_model->get_fournisseur_categ($rowid);//获得已经选择的标签

        $this->form_validation->set_rules('rowid', 'Rowid', 'required');//这个是隐藏标签，加载正确是一定会填写的，加上这个只是为了激活form_validation函数
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('societe/edit_societe', $data);
            $this->load->view('templates/footer', $data);
        }
        else{
            $this->Societe_model->set_societe($rowid);
            $this->load->helper('url');
            redirect(base_url('/index.php/societe/info_societe/').$rowid);
        }

    }

    public function delete_by_rowid($rowid=NULL)
    {
        //$this->Societe_model->delete_by_rowid($rowid);
        //redirect(base_url('/index.php/societe/show_societes'));
    }
    public function test_input_array(){
        $data['titre']="好啊";
        $this->form_validation->set_rules('rowid', 'Rowid', 'required');//这个是隐藏标签，加载正确是一定会填写的，加上这个只是为了激活form_validation函数
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('societe/test_input_array', $data);
            $this->load->view('templates/footer', $data);
        }
        else{

            echo $this->input->post('nb_categ');
            echo "</br>";

            //echo $this->input->post('rowid');
            /*
            for($i=1;$i<=$this->input->post('nb_categ');$i++){
                echo $this->input->post('sous_categ['.$i.']');
                //echo $this->input->post('rowid');
                echo "</br>";
            }*/
            $sous_categ=$this->input->post('sous_categ');
            foreach ($sous_categ as $value){
                echo $value;
            }
            $this->load->helper('url');
            //redirect(base_url('/index.php/societe/info_societe/').$rowid);
        }


    }

}