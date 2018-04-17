<?php
//用来处理供应商信息
class Contact_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
    }

    //计算联系人总数
    public function count_contacts(){
        $query = $this->db->query('SELECT rowid FROM llx_socpeople');
        return $query->num_rows();
    }
    public function fetch_contact($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("s.rowid rowid, s.lastname, s.firstname, s.civility, s.address, s.zip, s.town, s.poste, s.phone, s.phone_perso, s.phone_mobile, s.fax, s.email, s.skype, s.note_public, 
                           llx_c_country.label pays, llx_c_country.rowid rowid_pays,
                           llx_c_departements.nom departement, llx_c_departements.rowid rowid_departement,
                           ");
        $this->db->from("llx_socpeople s");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }

    //通过rowid获得客户信息
    public function get_contact_by_rowid($rowid=NULL){
        $this->db->select("s.rowid rowid, s.lastname, s.firstname, s.civility, s.address, s.zip, s.town, s.poste, s.phone, s.phone_perso, s.phone_mobile, s.fax, s.email, s.skype, s.note_public,
                           llx_c_country.label pays, llx_c_country.rowid rowid_pays,
                           llx_c_departements.nom departement, llx_c_departements.rowid rowid_departement,
                           so.rowid as societe_rowid, so.nom as societe_nom,
                           ");
        $this->db->from("llx_socpeople s");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe so","so.rowid=s.fk_soc","left");
        $this->db->where('s.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //一个函数两用，如果输入的id为空则添加新联系人，如果不为空则更新
    public function replace_contact($id=null)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        //llx_socpeople
        if($this->input->post('societe')==''){
            $fk_soc=null;//如果不设置这个插入空字符而不是null会因为外键报错
        }else{
            $fk_soc=$this->input->post('societe');
        }
        $data=array(
            'fk_soc'=>$fk_soc,
            'civility'=>$this->input->post('civility'),
            'lastname'=>$this->input->post('last_name'),
            'firstname'=>$this->input->post('first_name'),
            'address'=>$this->input->post('address'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'poste'=>$this->input->post('poste'),
            'phone'=>$this->input->post('phone'),
            'phone_mobile'=>$this->input->post('phone_mobile'),
            'skype'=>$this->input->post('skype'),
            'email'=>$this->input->post('email'),
            'note_public'=>$this->input->post('note'),
        );
        if($id==null) {
            $data['datec']=$tms;
            $data['fk_user_creat']=$_SESSION['rowid'];
            $this->db->insert('llx_socpeople', $data);
            $id = $this->db->insert_id();
        }
        else{
            $this->db->where('rowid', $id);
            $this->db->update('llx_socpeople', $data);
        }

        //如果是用于更新联系人，则删掉之前的标签
        if($id!=null){
            $this->Societe_model->delete_all_categ_contact($id);
        }
        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->Societe_model->replace_categ_contact($id, $value);
            }
        }

        //添加联系人细节
        /*$work_time=$this->input->post('work_time');
        $economic=$this->input->post('economic');
        $pay_cap=$this->input->post('pay_cap');
        $this->replace_detail_contact($id,$work_time,$economic,$pay_cap);*/

        return $id;//返回新创建的联系人id
    }

    //编辑单个信息
    //id-->联系人id
    //element->需要编辑的信息
    public function edit_element($id,$element_name,$value){
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        if($value==""){
            return "不能添加空白";
        }

        $data['tms']=$tms;
        $data[$element_name]=$value;
        $this->db->where('rowid', $id);
        $this->db->update('llx_socpeople', $data);
    }

    //更新联系人细节，如果本身没有则添加新的，有则更新
    /*public function replace_detail_contact($id,$work_time,$economic,$pay_cap){
        $query = $this->db->get_where('llx_cust_detail_contact_extrafields', array('fk_object' => $id));
        $data = array(
            'fk_object' => $id,
            'work_time' => $work_time,
            'economic'=>$economic,
            'pay_cap'=>$pay_cap,
            //'relation'=>$this->input->post('relation'),
        );
        if($query->result_array()==null){
            $this->db->insert('llx_cust_detail_contact_extrafields', $data);
        }
        else{
            $this->db->where('fk_object', $id);
            $this->db->update('llx_cust_detail_contact_extrafields', $data);
        }
    }*/

    //获得销售代表列表
    public function get_list_societe_commerciaux(){
        $this->db->select('rowid, concat(firstname,lastname) as name');
        $query = $this->db->get_where('llx_user');
        return $query->result_array();
    }
    //通过客户rowid获得销售代表
    public function get_societe_commerciaux_by_fk_soc($fk_soc){
        $this->db->select('u.rowid, concat(firstname,lastname) as name');
        $this->db->from("llx_user u, llx_societe_commerciaux sc");
        $this->db->where("u.rowid=sc.fk_user");
        $this->db->where("sc.fk_soc",$fk_soc);
        $query=$this->db->get();
        return $query->result_array();
    }

}