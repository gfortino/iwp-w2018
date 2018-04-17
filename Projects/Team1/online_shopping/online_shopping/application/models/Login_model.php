<?php
class Login_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    public function verifier_user_right($fk_right){
        return true;

    }

	public function verifie()
    {
        //如果没设置密码 则无论输入什么密码都能登录
        $query = $this->db->get_where('llx_user', array('login' => $this->input->post('account'),
                'pass_crypted2'=>"")
        );
        if($query->result_array()!=NULL){
            return $query->result_array();
        }

        //否则需要输对才行
        $query = $this->db->get_where('llx_user', array('login' => $this->input->post('account'),
                                                        'pass_crypted2'=>hash('md5',$this->input->post('password')))
                                                        );
        return $query->result_array();
        /*
        if($this->input->post('account')=='az5284'&&$this->input->post('password')=='123456'){
            return 'TRUE';
        }
        else return 'FALSE';
        */
    }
    //改密码
    public function change_password(){
        $data = array(
            'pass_crypted2'=>hash('md5',$this->input->post('password')),
        );
        $this->db->where('rowid', $_SESSION['rowid']);
        $this->db->update('llx_user', $data);
    }
    //获得用户权限信息
    public function get_right($rowid){
        $query = $this->db->get_where('llx_user_rights', array('fk_user' => $rowid)
        );
        $this->db->where("entity",$_SESSION['company_id']);
        return $query->result_array();

        /*
        $this->db->select("fk_id");
        $this->db->from("llx_user_rights");
        $this->db->where('fk_user',$rowid);
        $query=$this->db->get();

        return $query->result_array();*/
    }
    public function user_right($rowid){
        /*$query = $this->db->get_where('llx_user_rights', array('fk_id' => 31,
                'fk_id'=>32,'fk_id'=>34,'fk_user'=>$rowid)
        );*/
        //$query = $this->db->get_where('llx_user_rights', array('fk_user'=>$rowid));
        $this->db->select("fk_id");
        $this->db->from("llx_user_rights");
        $this->db->where("fk_user",$rowid);
        $this->db->where("entity",$_SESSION['company_id']);
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得用户选项
    public function get_option(){
        $query = $this->db->get_where('llx_user_option', array('fk_user' => $_SESSION['rowid'])
        );
        return $query->result_array();
    }

    //设置某个选项
    public function set_option($fk_option,$status){
        $data = array(
            'status' => $status,
            'fk_user'=>$_SESSION['rowid'],
            'fk_option'=>$fk_option
        );
        //$this->db->where('fk_user',$_SESSION['rowid']);
        //$this->db->where('fk_option',$fk_option);
        //$this->db->update('llx_user_option', $data);
        $this->db->replace('llx_user_option', $data);
        //这里需要设置两个主键，不需要rowid
    }

    public function replace_categ($rowid,$fk_categorie){
        $data = array(
            'fk_categorie' => $fk_categorie,
            'fk_product'  => $rowid,
        );
        $this->db->replace('llx_categorie_product', $data);
        // Executes: REPLACE INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
    }
    //新增某个选项(某个选项选为yes)
    /*
    public function add_option($fk_user,$fk_option){
        $data = array(
            'fk_user' => $fk_user,
            'fk_option' => $fk_option,
        );
        $this->db->insert('llx_user_option', $data);
    }
    //删除某个选项(某个选项选为no)
    public function delete_option($fk_user,$fk_option){
        $this->db->where('fk_user',$fk_user);
        $this->db->where('fk_option',$fk_option);
        $this->db->delete('llx_user_option');
    }*/
    public function count_note_public(){
        $query = $this->db->query('SELECT rowid FROM llx_note_public');
        return $query->num_rows();
    }
    public function fetch_note_public($limit,$offset,$start_time,$end_time){
        /*$limit=2;
        $offset=1;*/
        //$start_time=$this->input->post('start_time');
        //$end_time=$this->input->post('end_time');
        $this->db->limit($limit,$offset);
        $this->db->select("np.rowid, np.note, np.tms, np.fk_user, u.lastname");
        $this->db->from("llx_note_public np,llx_user u");
        $this->db->where("u.rowid=np.fk_user");
        if($start_time !=NULL){
            $this->db->where("np.tms>=",$start_time);
        }
        if($end_time!=NULL){
            $this->db->where("np.tms<=",$end_time);
        }
        $this->db->order_by("np.tms",'desc');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function add_note_public(){
        $note=$this->input->post("note");
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'fk_user'=>$_SESSION['rowid'],
            'tms'=>$tms,
            'note' => $note,
        );
        $this->db->insert('llx_note_public', $data);
    }

}