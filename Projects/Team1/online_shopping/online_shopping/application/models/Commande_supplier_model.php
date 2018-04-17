<?php
require_once dirname(__FILE__) . '/../models/functions.php';
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

class Commande_supplier_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    //订单的信息会在添加/删除产品的时候会进行加/减计算
    //订单在每次进入的时候会进行一次校对

    //计算订单总数
    public function count_commandes(){
        $query = $this->db->query('SELECT rowid FROM llx_commande_fournisseur');
        return $query->num_rows();
    }
    public function fetch_commande($limit,$offset,$statut=-1){
        $this->db->limit($limit,$offset);
        $this->db->select("c.rowid rowid, c.ref, s.nom nom_soc, s.town,c.date_creation, c.date_commande, c.date_livraison, c.total_ht, c.fk_statut
                           ");
        $this->db->from("llx_commande_fournisseur c,llx_societe s, llx_user u, llx_company comp");
        //$this->db->where("u.fk_company = comp.rowid");
        //$this->db->where("comp.rowid",$_SESSION['company_id']);
        $this->db->where("s.rowid=c.fk_soc");
        if($statut!=-1){
            $this->db->where("c.fk_statut",$statut);
        }
        $this->db->group_by('c.rowid');
        //$this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }
    //查找订单是否存在, 如果存在则true,不存在返回false
    public function check_commande($rowid){
        $this->db->select("c.rowid rowid");
        $this->db->from("llx_commande_fournisseur c");
        $this->db->where('c.rowid',$rowid);
        $query=$this->db->get();
        if ($query->result_array()==null){
            return false;
        }
        else {
            return true;
        }
    }

    //通过rowid获得订单信息
    public function get_commande_by_rowid($rowid){
        $this->db->select("c.rowid rowid, c.ref ref, c.ref_supplier, c.fk_statut, c.tva, c.total_ht, c.total_ttc,
                           c.fk_soc fk_soc, s.nom nom_soc");
        $this->db->from("llx_commande_fournisseur c");
        $this->db->from("llx_societe s");
        //$this->db->join("llx_societe so","so.rowid=s.fk_soc","left");
        $this->db->where('c.rowid',$rowid);
        $this->db->where("s.rowid=c.fk_soc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //一个函数两用，如果输入的id为空则添加新订单，如果不为空则更新
    public function replace_commande($rowid=NULL,$fk_soc=NULL)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        if($fk_soc==NULL){
            $fk_soc=$this->input->post('fk_soc');
        }

        //添加新的订单，自动生成订单ref号, 草稿的情况
        if($rowid==null) {
            $this->db->limit(1);
            $this->db->select("ref");
            $this->db->from("llx_commande_fournisseur");
            $this->db->where('fk_statut', 0);
            $this->db->order_by("rowid", "desc");
            $query = $this->db->get();
            $result=$query->result_array();
            if($result!=null){
                foreach ($result as $sum) ;
                $num = substr($sum['ref'], 5);
            }
            else{
                $num=0;
            }
            $num_ref = $num + 1;
            $ref = "(PROV" . $num_ref;
            $ref=$ref.")";
            //echo $ref;
        }
        $data=array(
            'ref'=>$ref,
            'ref_supplier'=>$this->input->post('ref_supplier'),
            'fk_soc'=>$fk_soc,
            'fk_multicurrency'=>1,
            'multicurrency_code'=>'EUR',
            'fk_projet'=>NULL,
            'fk_user_author'=>$_SESSION['rowid'],

            //没弄懂是做什么的
            'source'=>0,
            'billed'=>0,
            'note_public'=>$this->input->post('note_public'),
            'note_private'=>$this->input->post('note_private'),
            'model_pdf'=>'muscadet',
            'date_livraison'=>$this->input->post('date_livraison'),//运输日期
            'fk_cond_reglement'=>$this->input->post('cond_reglement'),
            'fk_mode_reglement'=>$this->input->post('mode_reglement'),
            'fk_incoterms'=>0,

        );
        if($rowid==null) {
            $data['date_creation']=$tms;//创建时间只有在创建产品的时候才会记录
            //$date['fk_statut']=0; 草稿类型
            $data['fk_user_author']=$_SESSION['rowid'];

            $this->db->insert('llx_commande_fournisseur', $data);
            $id = $this->db->insert_id();
        }
        else{
            $this->db->where('rowid', $rowid);
            $data['fk_user_modif']=$_SESSION['rowid'];

            $this->db->update('llx_commande_fournisseur', $data);
        }

        return $id;//返回新创建的订单id
    }

    //将订单状态从"已验证"设置成"已下订单"
    public function change_to_ordered($rowid=null){
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'tms'=>$tms,
            'fk_statut'=>3,
            'fk_user_modif'=>$_SESSION['rowid'],
            'date_commande'=>$this->input->post('dispatching_time'),
            'fk_input_method'=>$this->input->post('input_methode'),
        );
        $this->db->where('rowid', $rowid);

        $this->db->update('llx_commande_fournisseur', $data);
    }
    //将订单状态从已下订单变回已验证 (重新开放)
    public function change_to_re_open($rowid){
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'tms'=>$tms,
            'fk_statut'=>2,
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid);

        $this->db->update('llx_commande_fournisseur', $data);
    }
    //将订单状态从已下订单变为 "部分收到","全部收到"或者"已取消"
    public function change_receive_situation($rowid=null,$fk_statut){
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'tms'=>$tms,
            'fk_statut'=>$fk_statut,
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid);

        $this->db->update('llx_commande_fournisseur', $data);
    }
    //将订单状态从 "部分收到" "全部收到" "已取消" 变回 "已下订单"
    public function reverse_to_ordered($rowid=null){
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'tms'=>$tms,
            'fk_statut'=>3,
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid);

        $this->db->update('llx_commande_fournisseur', $data);
    }

    //获得所有产品的条形码
    //之后如果用barcode来搜索产品的信息，效率太低，所以这里要同时读取rowid
    public function get_list_barcodes($fk_soc){
        $this->db->select("pfp.rowid fourni_rowid, p.barcode barcode, pfp.price");
        $this->db->from("llx_product p");
        $this->db->from("llx_product_fournisseur_price pfp");
        $this->db->where("pfp.fk_product=p.rowid");
        $this->db->where("pfp.fk_soc",$fk_soc);
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得订单里的所有对象列表
    public function get_list_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, IFNULL(c.real_qty,0) real_qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.remise_percent, c.remise,
                           p.rowid rowid_product, p.barcode, p.ref ref, p.label label, p.cost_price,
                           p.barcode_pack, p.barcode_box, p.barcode_bigbox");
        $this->db->from("llx_commande_fournisseurdet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->where("c.fk_commande",$rowid);
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得订单里的单个对象
    public function get_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.remise_percent, c.remise,
                           p.rowid rowid_product, p.barcode, p.ref ref, p.label label, p.cost_price");
        $this->db->from("llx_commande_fournisseurdet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->where("c.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }


    //通过订单号查看该客户是否开启增值税
    //return 1 if yes
    public function if_tva_tx($fk_commande){
        $this->db->select("s.tva_assuj");
        $this->db->from("llx_commande_fournisseur cf, llx_societe s");
        $this->db->where("cf.rowid",$fk_commande);
        $this->db->where("cf.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['tva_assuj'];
    }

    //通过订单号查看该订单的客户是否开启re税(特殊附加税)
    //return 1 if yes
    public function if_re($fk_commande){
        $this->db->select("s.localtax1_assuj");
        $this->db->from("llx_commande_fournisseur cf, llx_societe s");
        $this->db->where("cf.rowid",$fk_commande);
        $this->db->where("cf.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['localtax1_assuj'];
    }

    //增加订单的对象
    public function add_commandedet($fk_commande,$fk_product,$tva_tx,$qty,$remise_percent,$unitprice,$total_ht_all=null,$total_ttc_all=null){
        $subprice=$unitprice;
        $unitprice=$unitprice*(100-$remise_percent)/100;//减去折扣后的单价
        $total_ht=$unitprice*$qty;
        $remise=$subprice*$qty-$total_ht;
        //如果客户没有开启增值税，则税率为0
        if($this->if_tva_tx($fk_commande)!=1){
            $tva_tx=0;
        }
        $total_ttc=$total_ht*(100+$tva_tx)/100;
        $total_tva=$total_ttc-$total_ht;
        $data=array(
            'fk_commande'=>$fk_commande,
            'fk_product'=>$fk_product,
            'tva_tx'=>$tva_tx,
            'qty'=>$qty,
            'remise_percent'=>$remise_percent,
            'remise'=>$remise,
            'subprice'=>$subprice,
            'total_ht'=>$total_ht,
            'total_tva'=>$total_tva,
            'total_ttc'=>$total_ttc,

            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_subprice'=>$subprice,
            'multicurrency_total_ht'=>$total_ht,
            'multicurrency_total_tva'=>$total_tva,
            'multicurrency_total_ttc'=>$total_ttc,

            //不知道做什么的
            'localtax1_type'=>3,
            'localtax2_type'=>5,
        );
        $this->db->insert('llx_commande_fournisseurdet', $data);
        $id = $this->db->insert_id();

        //更新订单总信息
        $tva=$total_ttc-$total_ht;
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,

            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
        );
        $this->db->set('total_ht', 'ifnull(total_ht,0)+'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
        $this->db->set('tva', 'ifnull(tva,0)+'.$tva, FALSE);
        $this->db->set('multicurrency_total_ht', 'ifnull(multicurrency_total_ht,0)+'.$total_ht, FALSE);
        $this->db->set('multicurrency_total_ttc', 'ifnull(multicurrency_total_ttc,0)+'.$total_ttc, FALSE);
        $this->db->set('multicurrency_total_tva', 'ifnull(multicurrency_total_tva,0)+'.$tva, FALSE);

        $this->db->where('rowid', $fk_commande);
        $this->db->update('llx_commande_fournisseur', $data);//更新订单的总价格

        return $id;//返回刚刚添加的订单对象id

    }

    //删除订单里的对象
    public function delete_commandedet($rowid_commandedet,$rowid_commande,$total_ht,$total_ttc,$total_ht_all,$total_ttc_all){

        $total_ht_all=$total_ht_all-$total_ht;//total_ht是单行的total_ht
        $total_ttc_all=$total_ttc_all-$total_ttc;
        $tva=$total_ttc_all-$total_ht_all;
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
            'total_ht' => $total_ht_all,
            'total_ttc' => $total_ttc_all,
            'tva'=>$tva,

            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_total_ht'=>$total_ht_all,
            'multicurrency_total_tva'=>$tva,
            'multicurrency_total_ttc'=>$total_ttc_all,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande_fournisseur', $data);//更新订单的总价格

        $this->db->delete('llx_commande_fournisseurdet',array('rowid'=>$rowid_commandedet));//删除订单的对象
    }

    //验证订单
    public function validate_commande($rowid_commande){

        //如果本身名字是改过的，则不用改名字, 这里我查找该订单号是否曾经被valid
        $this->db->select("ref");
        $this->db->from("llx_commande_fournisseur");
        $this->db->where('date_valid is not null');
        $this->db->where('rowid',$rowid_commande);
        $query = $this->db->get();
        if($query->result_array()==null) {
            //改名字
            $this->db->limit(1);
            $this->db->select("ref");
            $this->db->from("llx_commande_fournisseur");
            $this->db->where('date_valid is not null');
            $this->db->order_by("ref", "desc");
            $query = $this->db->get();
            $result=$query->result_array();
            if($result!=null) {
                foreach ($result as $sum) ;
                //echo $sum['ref'];
                $num = substr($sum['ref'], 7);
            }
            else {
                $num=0;
            }
            $num_ref = $num + 1;
            $num_ref = sprintf("%04d", $num_ref);
            $ref = "PO1710-" . $num_ref;
            echo $ref;
        }
        else
            {
                foreach ($query->result_array() as $sum) ;
                $ref=$sum['ref'];
                echo $ref;
            }

        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'ref'=>$ref,
            'tms' =>$tms,
            'date_valid' => $tms,
            'date_approve'=>$tms,
            'fk_user_valid' => $_SESSION['rowid'],
            'fk_user_approve'=>$_SESSION['rowid'],
            'fk_statut'=>2,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande_fournisseur', $data);
    }

    //取消验证
    public function cancel_validate($rowid_commande){
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
            'date_approve'=>NULL,
            'fk_user_approve'=>NULL,
            'fk_statut'=>0,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande_fournisseur', $data);
    }

    //通过供应商价格rowid获得产品的详细信息
    public function get_info_product($rowid=null,$fk_product=null){
        $this->db->select("pfp.rowid,p.rowid rowid_product, p.ref, p.label, pfp.unitprice unitprice, pfp.quantity, pfp.tva_tx, pfp.remise_percent");
        $this->db->from("llx_product p,llx_product_fournisseur_price pfp");
        $this->db->where("p.rowid=pfp.fk_product");
        if($rowid!=null){
            $this->db->where("pfp.rowid",$rowid);
        }
        else{
            $this->db->where("p.rowid",$fk_product);
        }
        $query=$this->db->get();
        return $query->result_array();
    }

    //通过产品ref号和供货商rowid获得产品的详细信息 //如果一个供应商有两个或两个以上的采购价选取最新添加的采购价
    public function get_info_product_by_ref($ref,$rowid_fourni){
        $this->db->limit(1); //只选第一个
        $this->db->select("pfp.rowid,p.rowid rowid_product, p.ref, p.label, pfp.unitprice unitprice, pfp.quantity, pfp.tva_tx, pfp.remise_percent");
        $this->db->from("llx_product p,llx_product_fournisseur_price pfp");
        $this->db->where("p.rowid=pfp.fk_product");
        $this->db->where("p.ref",$ref);
        $this->db->where("pfp.fk_soc",$rowid_fourni);
        $this->db->order_by("pfp.rowid", "desc"); //获得最新添加的价格
        $query=$this->db->get();
        return $query->result_array();
    }
    //通过产品条形码获得产品详细信息 //如果一个供应商有两个或两个以上的采购价选取最新添加的采购价
    public function get_info_product_by_barcode($barcode,$rowid_fourni){
        $this->db->limit(1); //只选第一个
        $this->db->select("pfp.rowid,p.rowid rowid_product, p.ref, p.label, pfp.unitprice unitprice, pfp.quantity, pfp.tva_tx, pfp.remise_percent");
        $this->db->from("llx_product p,llx_product_fournisseur_price pfp");
        $this->db->where("p.rowid=pfp.fk_product");
        $this->db->where("p.barcode",$barcode);
        $this->db->where("pfp.fk_soc",$rowid_fourni);
        $this->db->order_by("pfp.rowid", "desc"); //获得最新添加的价格
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得产品列表  price是税前价格, price_ttc是含税价格
    /*
    public function get_list_products(){
        $this->db->select("p.rowid,p.ref,p.label,p.price,p.price_ttc");
        $this->db->from("llx_product p");
        $this->db->order_by("p.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }*/

    //获得供应商信息
    public function get_list_supplier(){
        $this->db->select("s.rowid rowid, s.nom nom");
        $this->db->from("llx_societe s");
        $this->db->where("s.fournisseur",1);
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得所有的付款方式
    public function get_mode_reglement(){
        $this->db->select("id, code, libelle");
        $this->db->from("llx_c_paiement");
        $this->db->where("active",1);
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得所有的付款条件
    public function get_cond_reglement(){
        $this->db->select("rowid, code, libelle_facture");
        $this->db->from("llx_c_payment_term");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得运输方式
    public function get_shipping_method(){
        $this->db->select("rowid, code, libelle");
        $this->db->from("llx_c_shipment_mode");
        $this->db->where("active",1);
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得来源列表
    public function get_input_reason(){
        $this->db->select("rowid, code, label");
        $this->db->from("llx_c_input_reason");
        $this->db->where("active",1);
        $query=$this->db->get();
        return $query->result_array();
    }

    /* stock dispatching */
    //获得该订单下的所有产品，并返回已派出数量和还需要分配数量
    public function get_commandedet_with_dispatch($fk_commande){
        //创建第一个临时表 获得该订单下的所有产品
        $sql="CREATE TEMPORARY TABLE commandedet
                SELECT c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.remise_percent, c.remise, c.real_qty,
                       p.rowid rowid_product, p.barcode, p.ref ref, p.label label
                FROM llx_commande_fournisseurdet c, llx_product p
                WHERE 1=1
                AND p.rowid=c.fk_product
                AND c.fk_commande=?;
        ";
        //创建第二个临时表 //获得货运记录 //这里的qty_total是已派送总数
        $sql2 = "CREATE TEMPORARY TABLE dispatch
                    SELECT
                    cfd.fk_commandefourndet, sum(cfd.qty) as sent_qty_total
                    FROM
                    llx_commande_fournisseur_dispatch cfd,
                    llx_product p, 
                    llx_entrepot e
                    WHERE 1 = 1 
                    AND p.rowid=cfd.fk_product
                    AND e.rowid=cfd.fk_entrepot
                    AND cfd.fk_commande= ?
                    GROUP BY cfd.fk_commandefourndet
                    ;";
        //qty是订购数量 sent_qty_total是已派遣数量 qty_left是还需要派遣的数量
        $sql3="select c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.remise_percent, c.remise, c.real_qty,
                      c.rowid_product, c.barcode, c.ref, c.label,c.total_ht,
                      d.sent_qty_total, qty-sent_qty_total as qty_left
               FROM commandedet c
               left join dispatch d on c.rowid=d.fk_commandefourndet
               WHERE 1=1
               ";
        $query = $this->db->query($sql,array($fk_commande));
        $query2 = $this->db->query($sql2,array($fk_commande));
        $query3=$this->db->query($sql3);
        return $query3->result_array();

    }
    //获得该订单的货运记录
    public function get_commande_fournisseur_dispatch($fk_commande){
        $this->db->select("cfd.rowid, cfd.fk_product, cfd.fk_commandefourndet, cfd.qty, cfd.comment,
                            p.ref product_ref, p.label product_label,
                            e.label entrepot_label");
        $this->db->from("llx_commande_fournisseur_dispatch cfd, llx_product p, llx_entrepot e");
        $this->db->where("p.rowid=cfd.fk_product");
        $this->db->where("e.rowid=cfd.fk_entrepot");
        $this->db->where("cfd.fk_commande",$fk_commande);
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得单个commendedet的派送数量
    public function get_qty_dispatch_commandefourndet($fk_commandefourndet){
        $this->db->select("cfd.qty");
        $this->db->from("llx_commande_fournisseur_dispatch cfd");
        $this->db->where("cfd.fk_commandefourndet",$fk_commandefourndet);
    }
    //派遣产品，把产品增加到仓库
    public function add_dispatch(){
        $commandedet_array=$this->input->post('commandedet');
        foreach($commandedet_array as $value){
            $qty_dispatch=$this->input->post('qty_dispatch_'.$value);
            //派遣数量不为0的时候才做
            if($qty_dispatch!=0) {
                $tms=date("Y-m-d h:i::sa");
                $commande_rowid=$this->input->post('commande_rowid');
                $commandedet = $value;
                $product_rowid = $this->input->post('product_id_' . $value);
                $entrepot_rowid = $this->input->post('entrepot_' . $value);
                $product_total_ht = $this->input->post('product_total_ht_' . $value);
                $qty_commande = $this->input->post('qty_commande_' . $value);//订购数量
                $comment=$this->input->post('comment');
                $pmp = $product_total_ht / $qty_commande;//这里的中间价用的是订购的总价除以订购的数量，不是除以派遣的数量
                echo " commande rowid: ".$commande_rowid."<br>";
                echo " commandedet: " . $commandedet . "<br>";
                echo " product_rowid: " . $product_rowid . "<br>";
                echo " qty_dispatch: " . $qty_dispatch . "<br>";
                echo " entrepot: " . $entrepot_rowid . "<br>";
                echo " price total_ht: " . $product_total_ht . "<br>";
                echo " pmp: " . $pmp . "<br>";
                echo " comment: ".$comment."<br>";


                echo "<br>";
                echo "<br>";
                echo "<br>";

                $data = array(
                    //'pmp'=>'pmp'.$pmp,
                    //'fk_user_modif'=>$_SESSION['rowid'],
                );
                //llx_product
                $this->db->set('pmp', '(ifnull(pmp,0)+'.$pmp.')/2', FALSE);//计算pmp
                $this->db->set('stock', 'ifnull(stock,0)+'.$qty_dispatch, FALSE);//增加库存
                $this->db->where('rowid', $product_rowid);
                $this->db->update('llx_product', $data);
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
                //llx_commande_fournisseur_dispatch//收据记录
                $data = array(
                    'fk_commande'=>$commande_rowid,
                    'fk_product'=>$product_rowid,
                    'fk_commandefourndet'=>$commandedet,
                    'qty'=>$qty_dispatch,
                    'fk_entrepot'=>$entrepot_rowid,
                    'fk_user'=>$_SESSION['rowid'],
                    'comment'=>$comment,
                    'status'=>'1',
                    'datec'=>$tms,
                    'tms'=>$tms,
                );
                $this->db->insert('llx_commande_fournisseur_dispatch',$data);

                //llx_stock_mouvement//移动记录
                $data = array(
                    'tms'=>$tms,
                    'datem'=>$tms,
                    'fk_product'=>$product_rowid,
                    'fk_entrepot'=>$entrepot_rowid,
                    'value'=>$qty_dispatch,
                    'price'=>$product_total_ht,
                    'type_mouvement'=>3,
                    'fk_user_author'=>$_SESSION['rowid'],
                    'label'=>$comment,
                    'fk_origin'=>$commande_rowid,
                    'origintype'=>'order_supplier',
                );
                $this->db->insert('llx_stock_mouvement',$data);


            }
            //增加产品库存 llx_product, llx_product_stock 还有产品pmp
            /*$data=array(
                'ref'=>"test",
            );

            $this->db->insert('llx_commande_fournisseur_dispatch', $data);*/

            //增加产品移动记录 stock_mouvment

            //增加收据记录llx_commande_fournisseur_dispatch
            /*$data=array(
                'ref'=>"test",
            );
            $this->db->insert('llx_commande_fournisseur_dispatch', $data);*/
        }

    }
    //导入Excel
    public function import_excel($rowid_commande){
        $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/commande_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
        $sheet=$excel->getSheet(0);//选择第几个表, sheet0,sheet1... 我们只导入第一页
        $data=$sheet->toArray();//把表格的数据转换为数组，注意：这里转换是以行号为数组的外层下标，列号会转成数字为数组内层下标，坐标对应的值只会取字符串保留在这里，图片或链接不会出现在这里。

        $info_commande=$this->get_commande_by_rowid($rowid_commande);
        foreach($info_commande as $value){
        }
        $fk_soc=$value['fk_soc'];//获得fk_soc
        //把整个excel表格遍历
        $errors="";//错误信息，提示没有添加成功的产品

        $i=1;
        while(isset($data[$i][2])){//如果是空数组，则停;; 不能用!=null
            $ref=$data[$i][0];
            $flag=0; //0=按照ref导入产品 1=按照barcode导入产品
            $qty = $data[$i][2];
            if($ref==null){
                $ref=$data[$i][1];
                $flag=1;
                //return "第".$i."行--没有填写条形码号";
            }
            if($ref==null){
                $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有填写ref号--该产品添加失败</font> <br> <br>";
                $i=$i+1;//不要忘记i+1, 否则无法停止
                continue;
            }
            if($flag==0) {
                $info_product = $this->get_info_product_by_ref($ref,$fk_soc);
            }
            else{
                $info_product = $this->get_info_product_by_barcode($ref,$fk_soc);
            }
            if($info_product==null){
                $errors.=" <font color='#8b0000'>错误 :第".$i."行--该产品没有找到--该产品添加失败</font> <br> <br> ";
                $i=$i+1;
                continue;
                //return "第".$i."行--条形码重复";
            }
            foreach($info_product as $value) {
                //$this->db->select("pfp.rowid,p.rowid rowid_product, p.ref, p.label, pfp.unitprice unitprice, pfp.quantity, pfp.tva_tx, pfp.remise_percent");
                //add_commandedet($fk_commande,$fk_product,$tva_tx,$qty,$remise_percent,$unitprice,$total_ht_all=null,$total_ttc_all=null)
                $this->add_commandedet($rowid_commande, $value["rowid_product"], $value["tva_tx"], $qty, 0, $value["unitprice"]);
                //echo "rowid: ".$value['rowid']."; label:".$value['label']."unitprice: ".$value['unitprice'];
                //echo "<br>";
            }
            //$this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price_ttc,$tva_tx);
            $errors.=" <font color='#66CCFF'>第".$i."行--产品添加成功 </font><br> <br>";
            $i=$i+1;
        }
        if($errors==""){
            return "全部产品上传成功!";
        }
        else {
            return $errors;
        }
    }



    //点货
    public function fetch_checked_commande($limit,$offset){
        $statut=3;
        $this->db->limit($limit,$offset);
        $this->db->select("c.rowid rowid, c.ref, s.nom nom_soc, s.town, c.date_commande, c.date_livraison, c.total_ht, c.fk_statut
                           ");
        $this->db->from("llx_commande_fournisseur c,llx_societe s, llx_user u, llx_company comp");
        //$this->db->where("u.fk_company = comp.rowid");
        //$this->db->where("comp.rowid",$_SESSION['company_id']);
        $this->db->where("s.rowid=c.fk_soc");
        //$this->db->where("c.fk_statut",$statut);
        $this->db->group_by('c.rowid');
        //$this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }
    //计算点货订单总数
    public function count_checked_commandes(){
        $query = $this->db->query('SELECT rowid FROM llx_commande_fournisseur WHERE fk_statut=3');
        return $query->num_rows();
    }
    //覆盖之前的真正数量(点货点出来的数量), 因为这里在页面中已经得到数量，为确保和数据库同步，不采用在原本数据上加1的方案
    public function replace_real_qty($fk_commande,$fk_product,$real_qty){
        $this->db->where('fk_commande', $fk_commande);
        $this->db->where('fk_product', $fk_product);
        $data['real_qty']=$real_qty;

        $this->db->update('llx_commande_fournisseurdet', $data);
    }

    public function add_unknow_product_note($fk_commande_supplier,$barcode, $qty){
        $content="未知产品条码".$barcode."  --  数量:".$qty.";    ";
        $this->db->set('note_public', "CONCAT(ifnull(note_public,':'),',','".$content."')", FALSE);
        $this->db->where('rowid', $fk_commande_supplier);
        $this->db->update('llx_commande_fournisseur');//更新订单的总价格
    }
    //导出订单信息excel
    public function export_excel_commande_supplier($fk_commande){
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        //require_once '../Build/PHPExcel.phar';


        // Create new PHPExcel object
        echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        $objPHPExcel = new PHPExcel();

        // Set document properties
        echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        $commande=$this->get_commande_by_rowid($fk_commande);
        $commandedet=$this->get_list_commandedet($fk_commande);
        // Add some data
        echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);//设置宽度

        $i=65;//大写字母A的ASCII码
        //如果没选photo的CheckBox才会显示
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', lang('photo'));
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', lang('num_ref'));
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'ean unidades');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'nombre de productos');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'ean de paquete');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'ean de caja');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'ean de caja transporte');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'cantidad');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'Categoria');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'subcategoria de todos idiomas');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'sdti_es');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'sdti_de');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'sdti_it');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'sdti_en');
        $i=$i+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'sdti_fr');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'precio de unidad');
        $i=$i+1;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($i).'1', 'total');
        $i=$i+1;

        $i=2;
        foreach ($commandedet as $value) {
            $categ_pere=$this->Products_model->get_product_categ_pere($value['rowid_product']);
            if($categ_pere!=null){
                //防止空数组
                $categ_pere=$categ_pere[0]['label'];
            }
            else{
                $categ_pere=null;
            }
            $categ=$this->Products_model->get_product_sous_categ($value['rowid_product']);
            $categ_es=$this->Products_model->get_product_sous_categ($value['rowid_product'],'es_ES');
            $categ_de=$this->Products_model->get_product_sous_categ($value['rowid_product'],'it_IT');
            $categ_it=$this->Products_model->get_product_sous_categ($value['rowid_product'],'de_DE');
            $categ_en=$this->Products_model->get_product_sous_categ($value['rowid_product'],'en_GB');
            $categ_fr=$this->Products_model->get_product_sous_categ($value['rowid_product'],'fr_FR');


            $askii = 65;
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(120);//设置高度
            $askii = $askii + 1;

            //插入图片
            $dir = "../" . $_SESSION['folder'] . "/documents/produit/" . $value['ref'];
            $photos = get_photo_list($dir);
            if ($photos != NULL) {
                foreach ($photos as $photo) {
                }
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('avatar');
                $objDrawing->setDescription('avatar');
                $objDrawing->setPath($_SESSION['path'] . $value['ref'] . "/" . $photo);
                //$objDrawing->setPath('file:///var/www/html/documents/produit/' . $value['ref'] . "/" . $photo);
                $objDrawing->setHeight(157);
                //$objDrawing->setWidth(70);
                $objDrawing->setCoordinates('A' . $i);
                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            }
            //插入产品信息
            /*
             * c.rowid rowid, c.tva_tx, c.qty, IFNULL(c.real_qty,0) real_qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.remise_percent, c.remise,
                           p.rowid rowid_product, p.barcode, p.ref ref, p.label label, p.cost_price
             */

            /*
             *
            ->setCellValue(chr($i).'1', lang('num_ref'));
            ->setCellValue(chr($i).'1', 'ean unidades');
            ->setCellValue(chr($i).'1', 'nombre de productos');
            ->setCellValue(chr($i).'1', 'ean de paquete');
            ->setCellValue(chr($i).'1', 'ean de caja');
            ->setCellValue(chr($i).'1', 'ean de caja transporte');
            ->setCellValue(chr($i).'1', 'cantidad');
            ->setCellValue(chr($i).'1', 'precio de unidad');
            ->setCellValue(chr($i).'1', 'total');
             */
            /*barcode_pack, p.barcode_box, p.barcode_bigbox*/
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $i, $value['ref'])
                ->setCellValue('C' . $i, $value['barcode'])
                ->setCellValue('D' . $i, $value['label'])
                ->setCellValue('E' . $i, $value['barcode_pack'])
                ->setCellValue('F' . $i, $value['barcode_box'])
                ->setCellValue('G' . $i, $value['barcode_bigbox'])
                ->setCellValue('H' . $i, $value['qty'])
                ->setCellValue('I' . $i, $categ_pere)
                ->setCellValue('J' . $i, $categ)
                ->setCellValue('K' . $i, $categ_es)
                ->setCellValue('L' . $i, $categ_de)
                ->setCellValue('M' . $i, $categ_it)
                ->setCellValue('N' . $i, $categ_en)
                ->setCellValue('O' . $i, $categ_fr)
                ->setCellValue('P' . $i, $value['total_ttc'])
                ->setCellValue('Q' . $i, $commande[0]['total_ttc'])/*->setCellValue('L'.$i, $value['weight'].$weight_units)
                ->setCellValue('M'.$i, $value['forma_de_presentacion'])
                ->setCellValue('N'.$i, $value['material'])
                ->setCellValue('O'.$i, $value['costeembalajepack'])
                ->setCellValue('P'.$i, $value['color'])
                ->setCellValue('Q'.$i, $value['propiedad'])
                ->setCellValue('R'.$i, $value['efecto'])
                ->setCellValue('S'.$i, $value['tipoacabado'])
                ->setCellValue('T'.$i, $value['note'])*/
            ;
            $i = $i + 1;
        }


        // Rename worksheet
        echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $dir='documents/excel/'.$_SESSION['rowid'];
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        $objWriter->save($dir.'/info.xlsx');
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

        /*
        // Save Excel5 file
        echo date('H:i:s') , " Write to Excel5 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(str_replace('.php', '.xls', __FILE__));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        */
        // Echo memory usage
        echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


        // Echo memory peak usage
        echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

        // Echo done
        echo date('H:i:s') , " Done writing files" , EOL;
        echo 'Files have been created in ' , getcwd() , EOL;
    }
}