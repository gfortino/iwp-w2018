<?php
//用来处理供应商信息
class Expedition_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        //$this->load->model('Societe_model');
    }

    //计算联系人总数
    public function count_expeditions(){
        $query = $this->db->query('SELECT rowid FROM llx_expedition');
        return $query->num_rows();
    }
    public function fetch_expedition($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("e.rowid, e.tms, e.ref, e.fk_soc, e.ref_customer, e.date_creation, e.fk_user_author, e.fk_user_modif,
                           e.date_valid, e.fk_user_valid, e.date_delivery, e.date_expedition, e.fk_shipping_method, e.fk_statut, 
                           e.billed, e.height, e.width, e.size_units,
                           s.nom soc_nom, s.town, s.zip, e.date_delivery,
                           ");
        $this->db->from("llx_expedition e, llx_societe s");
        $this->db->where("s.rowid=e.fk_soc");
        $ref=$this->input->get('ref', TRUE);//用get方法获得用户搜索的ref
        $this->db->like("e.ref",$ref);
        $this->db->order_by("e.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //通过rowid获得运输信息
    public function get_expedition_by_rowid($rowid){
        $this->db->select("e.rowid, e.tms, e.ref, e.fk_soc, e.ref_customer, e.date_creation, e.fk_user_author, e.fk_user_modif,
                           e.date_valid, e.fk_user_valid, e.date_delivery, e.date_expedition, e.fk_shipping_method, e.fk_statut, 
                           e.billed, e.height, e.width, e.size_units,
                           s.nom soc_nom, s.town, s.zip, e.date_delivery,
                           c.ref ref_commande, c.rowid fk_commande,
                           sm.code shipping_method_code,
                           ");
        //element_element是订单和运输单的关系
        $this->db->from("llx_expedition e, llx_societe s");
        $this->db->join("llx_element_element ee","ee.fk_target=e.rowid and ee.targettype='shipping'","left");
        $this->db->join("llx_commande c","c.rowid=ee.fk_source","left");
        $this->db->join("llx_c_shipment_mode sm", "sm.rowid=e.fk_shipping_method","left");//运输方式
        $this->db->where("s.rowid=e.fk_soc");
        $this->db->where('e.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //通过运输fk_expedition获得运输单里的元素
    public function get_expeditiondet_by_fk_expedition($fk_expedition){
        $this->db->select("edet.rowid, edet.fk_expedition, edet.qty edet_qty, edet.fk_entrepot, 
                           cdet.qty cdet_qty, cdet.unit,
                           p.rowid product_rowid, p.barcode, p.label, p.description,
                           p.pack, p.box, p.bigbox,
                           e.rowid entrepot_rowid, e.label entrepot_label");
        $this->db->from("llx_expeditiondet edet, llx_commandedet cdet, llx_product p, llx_entrepot e");
        $this->db->where("edet.fk_expedition",$fk_expedition);
        $this->db->where("edet.fk_origin_line = cdet.rowid");
        $this->db->where("cdet.fk_product = p.rowid");
        $this->db->where("edet.fk_entrepot = e.rowid");
        $query=$this->db->get();
        return $query->result_array();
    }
}