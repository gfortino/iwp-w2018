<?php
class Background_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
    }
    //计用户单总数
    public function count_users(){
        $query = $this->db->query('SELECT rowid FROM llx_user');
        return $query->num_rows();
    }
    public function fetch_user($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("u.rowid, u.entity, u.login, u.lastname, u.admin, c.name company_name");
        $this->db->from("llx_user u");
        $this->db->join("llx_company c","c.rowid=u.entity","left");
        $this->db->order_by("c.rowid", "desc");
        //$this->db->group_by("u.rowid,u.fk_company");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }
    //一个函数两用，如果输入的id为空则添加新用户，如果不为空则更新
    public function replace_user($id=null)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        $data=array(
            'firstname'=>$this->input->post('firstname'),
            'lastname'=>$this->input->post('lastname'),
            'admin'=>$this->input->post('admin'),
            'note'=>$this->input->post('note'),
        );
        if($id==null) {
            $data['tms']=$tms;
            //管理员不能修改用户账号
            $data['login']=$this->input->post('login');
            $data['pass_crypted2']=hash('md5',$this->input->post('pass_crypted2'));
            $data['entity']=$_SESSION['company_id']; //用户不能改公司
            $data['fk_user_creat']=$_SESSION['rowid'];
            $this->db->insert('llx_user', $data);
            $id = $this->db->insert_id();
        }
        else{
            $this->db->where('rowid', $id);
            $this->db->update('llx_user', $data);
        }

        return $id;//返回新创建的用户id
    }
    public function check_user($rowid){
        $this->db->select("u.rowid rowid");
        $this->db->from("llx_user u");
        $this->db->where('u.rowid',$rowid);
        $query=$this->db->get();
        if ($query->result_array()==null){
            return false;
        }
        else {
            return true;
        }
    }

    //获得单个用户信息
    public function get_info_user($rowid){
        $this->db->select("u.rowid, u.entity, u.login, u.lastname, u.admin, c.name company_name");
        $this->db->from("llx_user u");
        $this->db->where('u.rowid',$rowid);
        $this->db->join("llx_company c","c.rowid=u.entity","left");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得用户权限
    public function get_user_right($fk_user){
        $this->db->select("ur.fk_id");
        $this->db->from("llx_user_rights ur");
        $this->db->where("ur.fk_user",$fk_user);
        $this->db->where("entity",$_SESSION['company_id']);
        $query=$this->db->get();
        $result= $query->result_array();
        //将二维数组转为一维数组
        foreach($result as $value){
            $rights_array[$value['fk_id']] = 1;
        }
        return $rights_array;
    }

    //增加某个权限
    public function add_right($fk_user,$fk_right){
        $data = array(
            'fk_user' => $fk_user,
            'fk_id' => $fk_right,
            'entity' => $_SESSION['company_id']
        );
        $this->db->insert('llx_user_rights', $data);
    }

    //删除某个权限
    public function delete_right($fk_user,$fk_right){
        $this->db->where('fk_user',$fk_user);
        $this->db->where('fk_id',$fk_right);
        $this->db->where("entity",$_SESSION['company_id']);
        $this->db->delete('llx_user_rights');
    }
    //获得公司信息
    public function get_info_company(){
        $this->db->select("rowid, name, date_limite, fk_country");
        $this->db->from("llx_company c");
        $this->db->where("c.rowid",$_SESSION["company_id"]);
        $query=$this->db->get();
        return $query->result_array();
    }

    //设置公司信息
    public function set_info_company(){
        $data=array(
            'name'=>$this->input->post('name'),
            'fk_country'=>$this->input->post('fk_country')
        );
        $this->db->where('rowid',$_SESSION['company_id']);
        $this->db->update('llx_company', $data);
    }



    //获得可选国家列表
    public function get_available_country(){
        $this->db->select("cc.rowid, cc.label");
        $this->db->from("llx_c_country cc");
        $this->db->where("cc.active=1");
        $query=$this->db->get();
        return $query->result_array();
    }


}