<?php
class Fournisseur_product_model extends CI_Model{
    //这个model是用于处理增加产品-供应商价格的
    public function __construct()
    {
        $this->load->database();
    }
    //获得所有的供应商列表
    public function get_all_fournisseur(){
        $this->db->select("rowid, nom, code_fournisseur");
        $this->db->from("llx_societe");
        $this->db->where('fournisseur',1);
        $query=$this->db->get();
        return $query->result_array();
    }
    public function get_id_by_name(){
        $this->db->select("rowid");
        $this->db->from("llx_societe");
        $this->db->where('nom',$this->input->post('fournisseur'));
        $query=$this->db->get();
        foreach ($query->result_array() as $value){
            $rowid=$value['rowid'];
        }
        return $rowid;
    }

    //通过供应商———价格的rowid获得这条信息的详细信息，也用于检查ref号是否重复
    public function get_by_ref($str){
        $this->db->select("rowid");
        $this->db->from("llx_product_fournisseur_price");
        $this->db->where('ref_fourn',$str);
        $query=$this->db->get();
        return $query->result_array();
    }

    //增加新的供应商价格
    /*
    public function add_product_fournisseur_price($fk_product){
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        //$quantity=1;//默认起订数量是1
        $quantity=$this->input->post('minimum_qty');
        $unitprice=$this->input->post('suppliers_price');
        $price=$unitprice*$quantity;
        //$fk_soc=$this->get_id_by_name();//因为创建产品填的是供应商的名字，所以要在这里转成id 旧版，已弃用
        $fk_soc=$this->input->post('fournisseur');
        //如果没有输入供货商——产品的ref号填写产品的ref号
        if(($this->input->post('suppliers_product_ref'))==null){
            $suppliers_product_ref=$this->input->post('ref');
        }
        $data = array(
            'fk_product'=>$fk_product,
            'fk_soc'=>$fk_soc,
            'ref_fourn' => $suppliers_product_ref,
            'fk_availability'=>0,
            'price'=>$price,
            'unitprice'=>$unitprice,
            'tva_tx'=>$this->input->post('tva_tx'),
            'fk_user'=>$_SESSION['rowid'],//是哪个用户创建的
            'delivery_time_days'=>$this->input->post('delivery_time_days'),

            //下面是没用到但是必填的信息
            'quantity'=>$quantity,//这里数量默认是1
            'entity'=>1,//是实物
            'datec'=>$tms, //创建这个价钱的时间

        );
        $this->db->insert('llx_product_fournisseur_price', $data);
    }*/

    //用传值的方法增加新的供应商价格
    public function add_product_fournisseur_price_value($fk_product,$fk_soc,$suppliers_product_ref,$unitprice,$tva_tx,$delivery_time_days,$quantity,$discount){
        if($fk_soc==0||$fk_soc==''||$fk_soc==null){ //如果传值错误
            return;
        }
        if($tva_tx==''||$tva_tx==null){ //如果税率没有填写，则设置税率为0
            $tva_tx=0;
        }
        if($discount==''||$discount==null){
            $discount=0;
        }

        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        $price=$unitprice*$quantity;
        //如果没有输入供货商——产品的ref号填写产品的ref号
        $data = array(
            'fk_product'=>$fk_product,
            'fk_soc'=>$fk_soc,
            'ref_fourn' => $suppliers_product_ref,
            'fk_availability'=>0,
            'price'=>$price,
            'unitprice'=>$unitprice,
            'tva_tx'=>$tva_tx,
            'fk_user'=>$_SESSION['rowid'],//是哪个用户创建的
            'delivery_time_days'=>$delivery_time_days,
            'remise_percent'=>$discount,//折扣

            //下面是没用到但是必填的信息
            'quantity'=>$quantity,//这里数量默认是1
            'entity'=>1,//是实物
            'datec'=>$tms, //创建这个价钱的时间
        );
        $this->db->insert('llx_product_fournisseur_price', $data);
        return $this->db->insert_id();//获得刚刚添加的产品的id
    }



    //删除供应商价格 用产品的id
    public function delete_product_fournisseur_price($fk_product){
        $this->db->delete('llx_product_fournisseur_price',array('fk_product'=>$fk_product));
    }

    //用产品——价格rowid来删除
    public function delete_product_fournisseur_price_by_rowid($rowid){
        $this->db->delete('llx_product_fournisseur_price',array('rowid'=>$rowid));
    }

    //更新供应商价格
    public function set_product_fournisseur_price(){
        //供应商，编码，起订量不能更改
        //默认情况是qty（起订量）等于1
        $qty=$this->input->post('minimum_qty');
        //$unitprice=$this->input->post('suppliers_price')/$qty;
        $unitprice=$this->input->post('suppliers_price');
        $price=$unitprice*$qty;
        $this->load->helper('url');
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms'=>$tms,//更新时间
            'price'=>$price,
            'quantity'=>$qty,
            'unitprice'=>$unitprice,
            'tva_tx'=>$this->input->post('tva_tx'),
            'delivery_time_days'=>$this->input->post('delivery_time_days'),
        );
        $this->db->where('rowid', $this->input->post('rowid_price_product'));
        $this->db->update('llx_product_fournisseur_price', $data);
    }

    //更新供应商价格（传值的方法）
    public function set_product_fournisseur_price_value($rowid,$qty,$unitprice,$tva_tx,$delivery_time_days){
        //供应商，编码，起订量不能更改
        //$unitprice=$this->input->post('suppliers_price')/$qty;
        $price=$unitprice*$qty;
        $this->load->helper('url');
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms'=>$tms,//更新时间
            'price'=>$price,
            'quantity'=>$qty,
            'unitprice'=>$unitprice,
            'tva_tx'=>$tva_tx,
            'delivery_time_days'=>$delivery_time_days,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_product_fournisseur_price', $data);
    }

    //通过供应商--产品rowid获得供应商--产品信息
    public function get_product_fournisseur_price($rowid){
        $this->db->select("llx_product_fournisseur_price.rowid,llx_product_fournisseur_price.ref_fourn, llx_product_fournisseur_price.quantity,
                            llx_product_fournisseur_price.price, llx_product_fournisseur_price.unitprice unitprice, llx_product_fournisseur_price.remise_percent,
                            llx_product_fournisseur_price.delivery_time_days,
                            llx_product_fournisseur_price.supplier_reputation,llx_product_fournisseur_price.tva_tx,
                            llx_societe.nom as fournisseur,llx_societe.rowid as fournisseur_id
                            ");
        $this->db->from("llx_product_fournisseur_price,llx_societe");
        $this->db->where('llx_product_fournisseur_price.rowid',$rowid);
        $where="llx_product_fournisseur_price.fk_soc=llx_societe.rowid";
        $this->db->where($where);
        $this->db->order_by("llx_product_fournisseur_price.price", "asc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得已经选择的供应商的价格
    public function get_selected_fournisseur($fk_product){
        $this->db->select("llx_product_fournisseur_price.rowid, llx_product_fournisseur_price.ref_fourn, llx_product_fournisseur_price.quantity,
                            llx_product_fournisseur_price.price, llx_product_fournisseur_price.unitprice unitprice, llx_product_fournisseur_price.remise_percent,
                            llx_product_fournisseur_price.delivery_time_days,
                            llx_product_fournisseur_price.supplier_reputation,llx_product_fournisseur_price.tva_tx,
                            llx_societe.nom as fournisseur,llx_societe.rowid as fournisseur_id
                            ");
        $this->db->from("llx_product_fournisseur_price,llx_societe");
        $this->db->where('llx_product_fournisseur_price.fk_product',$fk_product);
        $where="llx_product_fournisseur_price.fk_soc=llx_societe.rowid";
        $this->db->where($where);
        $this->db->order_by("llx_product_fournisseur_price.unitprice", "ASC");
        $query=$this->db->get();
        return $query->result_array();
    }


}