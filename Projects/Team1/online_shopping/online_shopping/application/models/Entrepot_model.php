<?php
//用来处理仓库信息
class Entrepot_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
        $this->load->model('Products_model');
        $this->load->model('Fournisseur_product_model');
        $this->load->model('Commande_supplier_model');
    }

    public function get_list_entrepot(){
        $this->db->select("e.rowid rowid, e.label, e.description, e.lieu");
        $this->db->from("llx_entrepot e");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得仓库列表，包括详细信息
    public function get_info_list_entrepot(){
        $this->db->select("distinct(e.rowid) rowid, e.label, e.description, e.lieu, sum(reel) reel");
        $this->db->from("llx_entrepot e");
        $this->db->join('llx_product_stock ps','e.rowid=ps.fk_entrepot','left');
        $this->db->group_by('e.rowid');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function get_info_entrepot($rowid){
        $this->db->select("e.rowid rowid, e.label, e.description, e.lieu, sum(reel) reel, count(ps.fk_product) count_product,
                            c.code pays_code, c.label pays_label");
        $this->db->from("llx_entrepot e");
        $this->db->where("e.rowid",$rowid);
        $this->db->join('llx_product_stock ps','e.rowid=ps.fk_entrepot','left');
        $this->db->join('llx_c_country c','c.rowid=e.fk_pays','left');
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得该仓库的产品库存
    public function get_product_stock($rowid_entrepot){
        $this->db->select("p.rowid, p.barcode, p.label, ps.reel, p.pmp");
        $this->db->from("llx_product_stock ps, llx_product p");
        $this->db->where("ps.fk_product=p.rowid");
        $this->db->where("ps.fk_entrepot",$rowid_entrepot);
        $query=$this->db->get();
        return $query->result_array();
    }



    //获得分页库存转移记录 //还要获得是该记录从哪里来，这个需要之后再写
    public function fetch_stock_mouvement($fk_entrepot,$limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("sm.tms, sm.value, sm.label,
                           p.rowid product_rowid,p.barcode product_barcode, p.label product_label,
                           ");
        $this->db->from("llx_stock_mouvement sm");
        $this->db->where("sm.fk_entrepot",$fk_entrepot);
        $this->db->join("llx_product p","sm.fk_product=p.rowid","left");

        $query=$this->db->get();
        return $query->result_array();
    }
    public function count_factures($fk_entrepot){
        $this->db->select("sm.rowid");
        $this->db->from("llx_stock_mouvement sm");
        $this->db->where("sm.fk_entrepot",$fk_entrepot);
        $query=$this->db->get();
        return $query->num_rows();
    }

    //增加产品库存
    public function add_product_stock($product_rowid,$entrepot_rowid,$qty_dispatch){
        //llx_product
        //增加产品的总库存
        $data = array();
        $this->db->set('stock', 'ifnull(stock,0)+'.$qty_dispatch, FALSE);//增加库存
        $this->db->where('rowid', $product_rowid);
        $this->db->update('llx_product', $data);

        //增加产品的仓库库存

        //llx_product_stock
        //检查该产品在该仓库下是否有库存
        $this->db->select("rowid");
        $this->db->from("llx_product_stock");
        $this->db->where("fk_product",$product_rowid);
        $this->db->where("fk_entrepot",$entrepot_rowid);
        $query=$this->db->get();
        if($query->result_array()==null){
            //如果没有则添加
            $data = array(
                'fk_product'=>$product_rowid,
                'fk_entrepot'=>$entrepot_rowid,
                'reel'=>$qty_dispatch,
            );
            $this->db->insert('llx_product_stock',$data);
        }
        else{
            $this->db->set('reel', 'ifnull(reel,0)+'.$qty_dispatch, FALSE);//如果有的话则在原来的基础上增加库存
            $this->db->where('fk_product', $product_rowid);
            $this->db->where('fk_entrepot', $entrepot_rowid);
            $this->db->update('llx_product_stock',$data);
        }

    }

    //$this->Products_model->get_virtuel_stock($value['product_rowid']);

    //获得需要返单的产品
    public function fetch_replenish_product($limit,$offset){
        $result=array();
        $this->db->limit($limit,$offset);
        $this->db->select("p.rowid,p.label, p.ref, p.barcode, ifnull(p.stock,0) stock, p.seuil_stock_alerte, p.desiredstock,
                          ");
        $this->db->from("llx_product p");
        //$this->db->join("llx_categorie_product cp", "cp.fk_product=p.rowid","left");
        //$this->db->join("llx_categorie c","c.rowid=cp.fk_categorie","left");

        $this->db->where("ifnull(p.stock,0) < p.desiredstock");
        $query=$this->db->get();
        $result=$query->result_array();
        /*foreach($result as $value){
            echo "<br>";
            echo "ref: ".$value['ref']."stock: ".$value['stock']." desiredstock: ".$value['desiredstock'];
        }*/
        foreach($result as &$value){
            $value['total_qty_fourni']=$this->Products_model->get_total_qty_fourni($value['rowid']);
            $value['fournisseur_price']=$this->Fournisseur_product_model->get_selected_fournisseur($value['rowid']);
        }
        return $result;
    }

    //创建返单订单
    public function create_replenish_commande(){
        $flag_create=0;
        $fk_soc_array=array();//用于记录产品是否有同样的供货商，有同样的供货商则不需要再创建订单   第一维用于记录供货商id，第二维用于记录由该供货商id创建的订单id
        $products_rowid=$this->input->post('product_check_box');
        if($products_rowid!=null) {
            foreach ($products_rowid as $value) {
                $qty=$this->input->post('need_to_order_'.$value);
                $fourni_product=$this->input->post('fourni_product_id_'.$value);
                $fourni_product = explode(',', $fourni_product);//把逗号分隔符转为数组
                //0 = fournisseur_product_rowid, 1 = fournisseur_rowid
                //echo $fourni_product[0]."--".$fourni_product[1];
                $fk_soc=$fourni_product[1];
                $rowid_product_fourni=$fourni_product[0];
                //如果产品有供应商，则添加订单
                if($fk_soc!=-1) {
                    //如果产品起订量太少，则不添加
                    $info_fourni_product=$this->Fournisseur_product_model->get_product_fournisseur_price($rowid_product_fourni);
                    if($qty<$info_fourni_product[0]['quantity']){
                        continue;
                    }

                    $flag_create_commande=0;//判断是否还需要创建新的订单
                    if(isset($fk_soc_array[$fk_soc])){
                        //不需要再添加新的订单，直接在刚刚创建的订单上增加产品
                        $flag_create_commande=1;
                        $rowid_commande=$fk_soc_array[$fk_soc];
                    }
                    if($flag_create_commande==0) {
                        $fk_soc_array[$fk_soc] = $this->Commande_supplier_model->replace_commande(NULL, $fk_soc);
                        $rowid_commande=$fk_soc_array[$fk_soc];
                    }
                    echo $rowid_commande;
                    $this->Commande_supplier_model->add_commandedet($rowid_commande,$value,$info_fourni_product[0]['tva_tx'],$qty,0,$info_fourni_product[0]['unitprice']);
                    $flag_create=1;
                }
                //$this->Commande_supplier_model->add_commandedet($fk_commande,$fk_product,$tva_tx,$qty,$remise_percent,$unitprice);
                //echo " ".$value." ";
            }
        }
        if($flag_create==1)
            return 1; //有产品创建成功
        else
            return 0;
    }

    //获得产品总数：用于分页
    public function count_replenish_product(){
        $this->db->select("p.rowid");
        $this->db->from("llx_product p");
        $this->db->where("ifnull(p.stock,0) < p.desiredstock");
        $query=$this->db->get();

        return $query->num_rows();
    }


}