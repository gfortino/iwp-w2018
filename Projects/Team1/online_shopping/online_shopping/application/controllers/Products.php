<?php
require_once dirname(__FILE__) . '/../models/functions.php';
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


class Products extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Fournisseur_product_model');
        $this->load->model('Login_model');
        $this->load->model('Entrepot_model');
        $this->load->model('Categorie_model');
        $this->load->helper('url_helper');
        //$this->config->set_item('language', 'chinese');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        if (!isset($_SESSION['logged_in'])){
            redirect(base_url('/index.php/login/index/'));
        }
        $this->config->set_item('language', $_SESSION['language']);
        $this->lang->load('menu');
        $this->load->helper('language');
    }
    public function show_products()
    {
        //每页显示数量
        $number = 20;
        //添加分页
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php/products/show_products';
        //$config['base_url'] = base_url().'index.php/products/show_products';


        //$config['base_url'] = base_url().'index.php/products/show_products';
        $config['total_rows'] = $this->Products_model->count_products();
        //$config['per_page'] = 50;
        $config['per_page'] = $number;
        // Bootstrap for CodeIgniter pagination.
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['enable_query_strings']=TRUE;
        $config['page_query_string']=TRUE;
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);

        $data['products'] = $this->Products_model->fetch_product($config['per_page'],$this->input->get('per_page', TRUE));
        if($data['products']==null){
            echo 'no result';
            return "no result";
        }
        $this->load->view('templates/header', $data);
        $this->load->view('products/show_products_bg' , $data);
        $this->load->view('templates/footer', $data);
    }

    public function info_product($rowid = NULL){
        $data['rowid']=$rowid;
        $data['products']=$this->Products_model->get_products_by_rowid($rowid);

        $this->load->view('templates/header', $data);
        $this->load->view('products/info_product' , $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit_product($rowid=NULL){
        $data['products']=$this->Products_model->get_products_by_rowid($rowid);
        $data['rowid']=$rowid;
        if($data['products']==null){
            echo "找不到该产品";
            return 0;
        }
        $this->form_validation->set_rules('ref', 'ref', 'required');
        $this->form_validation->set_rules('label','label','required');
        $this->form_validation->set_rules('price', 'price', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('products/edit_product', $data);
            $this->load->view('templates/footer', $data);
        }
        else{
            $this->Products_model->replace_product($rowid);
            $this->load->helper('url');
            redirect(base_url('/index.php/products/info_product/').$rowid);
        }
    }

    public function create_products()
    {
        $data['title'] = 'Create a product';

        $this->form_validation->set_rules('ref', 'Ref', 'required');
        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('products/create_products',$data);
            $this->load->view('templates/footer');
        }
        else
        {
            $rowid=$this->Products_model->replace_product();
            $this->load->helper('url');
            redirect(base_url('/index.php/products/edit_photo/').$rowid);
        }
    }
    //手机页面
    public function create_products_mobi()
    {
        if($this->Login_model->verifier_user_right(32)==false){
            echo "没有权限添加/变更产品";
            return 0;
        }
        $data['title'] = 'Create a product';


        $this->form_validation->set_rules('barcode', 'barcode', 'required');
        $this->form_validation->set_rules('label', 'Label', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('products/create_products_mobi',$data);
            $this->load->view('templates/footer');
        }
        else
        {
            $rowid=$this->Products_model->replace_product();
            $this->load->helper('url');
            redirect(base_url('/index.php/products/edit_photo/').$rowid);
        }
    }

    public function edit_photo($rowid=NULL)
    {
        $this->load->helper(array('form', 'url'));
        $ref=$this->Products_model->get_ref_by_rowid($rowid);
        $data['ref']=$ref;
        $data['rowid']=$rowid;
        $data['error']='';

        $this->load->view('templates/header');
        $this->load->view('products/edit_photo',$data);
        $this->load->view('templates/footer');
    }
    public function do_upload_photo($rowid=NULL){
        if($this->Login_model->verifier_user_right(32)==false){
            echo "没有权限添加/变更产品";
            return 0;
        }
        $ref=$this->Products_model->get_ref_by_rowid($rowid);
        $this->load->helper(array('form', 'url'));
        $this->load->library('image_lib');
        $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref;//这里暂时使用ref，因为dolibarr用的是rowid，将来搞多人的时候要改成rowid
        $photos=get_photo_list($dir);
        $count=0;//计数已有图片数量
        if($photos!=NULL) {
            foreach ($photos as $value) {
                $count=$count+1;
            }
        }
        $config['file_name'] = $ref."_".$count; //给图片重命名 abc_1, abc_2 给图片重命名是因为导入西班牙语图片会无法导出
        $config['upload_path']      = $dir;
        $config['allowed_types']    = 'gif|jpg|png|jpeg';
        $config['max_size']     = 8192;
        $config['max_width']        = 8192;//图片最大宽度
        $config['max_height']       = 8192;//图片最大高度
        $data['ref']=$ref;
        $data['rowid']=$rowid;
        $data['categ_selected']=$this->Products_model->get_product_categ($rowid);
        //如果文件夹不存在则创建
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }

        //上传图片
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('photo'))
        {

            $data['categ']=$this->Products_model->get_enfant_categ($rowid);
            $this->form_validation->set_rules('categ', 'Categ', 'required');
            $data['categ_selected']=$this->Products_model->get_product_categ($rowid);//这个也要在do_upload里添加
            if($this->form_validation->run() === TRUE){
                $this->Products_model->replace_categ($rowid);
                redirect(base_url('/index.php/products/edit_photo/').$rowid);
            }
            $data['error']=$this->upload->display_errors();
            $this->load->view('templates/header');
            $this->load->view('products/edit_photo', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $name=$this->upload->data('file_name');
            //如果是iPhone上传的，翻转图片
            $source_file = $dir."/".$name;
            $data = imagecreatefromstring(file_get_contents($source_file));
            $exif = exif_read_data($source_file);
            if(!empty($exif['Orientation'])) {
                switch($exif['Orientation']) {
                    case 8:
                        $data = imagerotate($data, 90, 0);
                        break;
                    case 3:
                        $data = imagerotate($data, 180, 0);
                        break;
                    case 6:
                        $data = imagerotate($data, -90, 0);
                        break;
                }
                imagejpeg($data, $source_file);
            }
            //压缩图片
            $new_image_name=$this->upload->data('raw_name')."_mini".$this->upload->data('file_ext');
            $config['source_image']	= $dir."/".$name;

            $dir=$dir."/thumbs";
            if(!file_exists ( $dir)){
                mkdir($dir, 0777, true);
            }
            //生成第一个缩略图
            $config['image_library'] = 'gd2';
            //$config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['height']	= 72;
            //$config['width'] = 50;
            $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
            $this->image_lib->initialize($config);


            $data = array('upload_data' => $this->upload->data());
            if (!$this->image_lib->resize()) {
                $data['error']= $this->image_lib->display_errors();
            }
            else $data['error']='上传成功';
            //生成第二个缩略图
            $this->image_lib->clear();
            $new_image_name=$this->upload->data('raw_name')."_small".$this->upload->data('file_ext');
            $config['image_library'] = 'gd2';
            //$config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['height']	= 150;
            //$config['width'] = 50;
            $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                $data['error']= $this->image_lib->display_errors();
            }
            else $data['error']='上传成功';


            /*$data['categ']=$this->Products_model->get_enfant_categ($rowid);
            $data['ref']=$ref;
            $data['rowid']=$this->Products_model->get_rowid_by_ref($ref);
            $data['categ_selected']=$this->Products_model->get_product_categ($rowid);*/
            //$data['error']='上传成功';
            $this->load->view('templates/header');
            $this->load->view('products/edit_photo', $data);
            $this->load->view('templates/footer');
        }
    }

    public function delete_by_rowid($rowid=NULL)
    {
        if($this->Login_model->verifier_user_right(34)==false){
            echo "没有权限删除,哈哈哈哈哈哈";
            return 0;
        }
        $this->Products_model->delete_by_rowid($rowid);
        redirect(base_url('/index.php/products/show_products'));
    }
    //删除多个产品
    public function delete_products()
    {
        if($this->Login_model->verifier_user_right(34)==false){
            echo "没有权限删除";
            return 0;
        }
        $this->Products_model->delete_proudcts();
        redirect(base_url('/index.php/products/show_products'));
    }
    //delete the photo by the name of the photo and the ref of the product //it's now deleted by rowid
    public function delete_photo_by_name($rowid=NULL,$name=NULL){
        $name=urldecode($name);//中文乱码转码
        $ref=$this->Products_model->get_ref_by_rowid($rowid);
        $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref;
        unlink($dir.'/'.$name);
        /*unlink($dir.'/thumbs/'.$name."_mini");
        unlink($dir.'/thumbs/'.$name."_small");*///这个这样写不对，但是好像不用删掉，因为新创建的会覆盖
        redirect(base_url('/index.php/products/edit_photo/'.$rowid));
    }

    //上传产品基本信息
    public function upload_excel_basic(){
        //echo $this->input->post("fournisseur");
        //检测用户是否有导入Excel权限
        if($this->Login_model->verifier_user_right(30000)==false){
            echo "没有权限导入Excel";
            return 0;
        }
        $dir='documents/excel/'.$_SESSION['rowid'];

        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        //删除之前的文件
        if(file_exists ( $dir.'/porducts_import.xlsx')) {
            unlink($dir.'/porducts_import.xlsx');
        }

        $config['upload_path']      = $dir;
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']     = 4096;
        $config['file_name']='porducts_import.xlsx';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $this->generate_basic_format();//生成新的导入模板
            $data['error'] = $this->upload->display_errors();
            $data['products_array']="";
            $this->load->view('templates/header');
            $this->load->view('products/upload_basic',$data);
            $this->load->view('templates/footer');
        }
        else
        {
            /*$data = array('upload_data' => $this->upload->data());
            $data['error']=$this->Products_model->import_basic_excel();
            unlink($dir.'/porducts_import.xlsx');*/

            $data = array('upload_data' => $this->upload->data());
            $data['error']=$this->upload->display_errors();
            $data['products_array']=$this->Products_model->get_basic_excel_array();
            unlink($dir.'/porducts_import.xlsx');

            $this->load->view('templates/header');
            $this->load->view('products/upload_basic',$data);
            $this->load->view('templates/footer');
        }
    }
    //上传产品完整信息
    public function upload_excel(){
        //echo $this->input->post("fournisseur");
        //检测用户是否有导入Excel权限
        if($this->Login_model->verifier_user_right(30000)==false){
            echo "没有权限导入Excel";
            return 0;
        }
        $dir='documents/excel/'.$_SESSION['rowid'];
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        //删除之前的文件
        if(file_exists ( $dir.'/porducts_import.xlsx')) {
            unlink($dir.'/porducts_import.xlsx');
        }

        $config['upload_path']      = $dir;
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']     = 204800;
        $config['file_name']='porducts_import.xlsx';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $this->generate_format();//生成新的导入模板
            $data['error'] = $this->upload->display_errors();
            $this->load->view('templates/header');
            $this->load->view('products/upload',$data);
            $this->load->view('templates/footer');
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $data['error']=$this->Products_model->import_excel();
            unlink($dir.'/porducts_import.xlsx');

            $this->load->view('templates/header');
            $this->load->view('products/upload',$data);
            $this->load->view('templates/footer');
        }
    }
    /*导出Excel*/
    public function export_excel()
    {
        if($this->Login_model->verifier_user_right(38)==false){
            echo "没有权限导出";
            return 0;
        }
        $this->load->view('templates/header' );
        $this->load->view('products/export_excel' );
        $this->load->view('templates/footer');
    }

    public function export_product_list(){
        if($this->Login_model->verifier_user_right(38)==false){
            echo "没有权限导出";
            return 0;
        }
        $this->form_validation->set_rules('start_time', '开始时间', 'required');
        $this->form_validation->set_rules('start_time', '结束时间', 'required');
        $data['categ']=$this->Products_model->get_categ();
        $data['error']='';

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('products/export_product_list', $data);
            $this->load->view('templates/footer', $data);
        }
        else{
            $this->load->view('templates/header', $data);
            $this->load->view('products/export_product_list', $data);
            $this->load->view('templates/footer', $data);
            $this->Products_model->export_products();
            //redirect(base_url('/index.php/products/export_excel/'));
            //redirect(base_url('/index.php/products/export_product_list/'));
        }
    }

    public function download_excel(){
        if($this->Login_model->verifier_user_right(38)==false){
            echo "没有权限导出";
            return 0;
        }
        //$file='file:///Applications/XAMPP/xamppfiles/htdocs/gccbm/documents/excel/demo.xlsx';
        $file='documents/excel/'.$_SESSION['rowid'].'/info.xlsx';
        //$file='file:///var/www/html/gccbm-mobi/application/models/Products_model.xlsx';
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    //生成基本格式文件
    public function generate_basic_format(){
        $this->Products_model->create_module_excel_basic();
    }
    //下载基本格式文件
    public function download_excel_example_basic(){
        //$file='file:///Applications/XAMPP/xamppfiles/htdocs/gccbm/documents/excel/demo.xlsx';
        $file='documents/excel/excel_format_basic.xlsx';
        //$file='file:///var/www/html/gccbm-mobi/application/models/Products_model.xlsx';
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }
    //生成完整格式文件
    public function generate_format(){
        $this->Products_model->create_module_excel();
    }
    //下载完整格式文件
    public function download_excel_example(){
        //$file='file:///Applications/XAMPP/xamppfiles/htdocs/gccbm/documents/excel/demo.xlsx';
        $file='documents/excel/format_basic.xlsx';
        //$file='file:///var/www/html/gccbm-mobi/application/models/Products_model.xlsx';
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    public function test($rowid){
        show_product_photos($rowid);
    }


}