<?php
class Categorie_model extends CI_Model{
    //用来处理创建产品时的厂家价格类

    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');

    }
    /************************************/
    /*获得大标签列表*/
    public function get_pere_categ_list(){
        $this->db->select("c.rowid, c.label, c.limit_discount");
        $this->db->from("llx_categorie c");
        $this->db->where("c.fk_parent=0");//是大标签
        //$this->db->join('llx_categorie_lang cl','cl.fk_category=c.rowid and cl.lang="zh_CN"','left'); //标签翻译
        //一个产品有多个标签会显示多次
        //$this->db->group_by('p.rowid');
        $query=$this->db->get();
        return $query->result_array();

    }
    //改变佣金比例
    public function set_ratio_commission($rowid,$limit_discount){
        $data = array(
            'limit_discount'=>$limit_discount,
            'fk_user_modif'=>$_SESSION['rowid']
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_categorie', $data);
    }



}