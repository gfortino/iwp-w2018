<?php

class Commande_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Facture_model');
    }

    //通用函数 llx_element_element ee
    //一个元素和另一个元素的关系
    //订单和发票，订单和货运单....
    public function add_element_element($fk_source,$sourcetype,$fk_target,$targettype){
        $data=array(
            'fk_source'=>$fk_source,
            'sourcetype'=>$sourcetype,
            'fk_target'=>$fk_target,
            'targettype'=>$targettype,
        );
        $this->db->insert('llx_element_element', $data);
    }

    //订单的信息会在添加/删除产品的时候会进行加/减计算
    //订单在每次进入的时候会进行一次校对

    //计算订单总数
    public function count_commandes(){
        $query = $this->db->query('SELECT rowid FROM llx_commande');
        return $query->num_rows();
    }
    public function fetch_commande($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("c.rowid rowid, c.ref, s.nom nom_soc, s.town, c.date_commande, c.date_livraison, c.total_ht, c.fk_statut
                           ");
        $this->db->from("llx_commande c");
        //$this->db->where("u.fk_company = comp.rowid");
        //$this->db->where("comp.rowid",$_SESSION['company_id']);
        $this->db->join("llx_societe s","s.rowid=c.fk_soc","left");
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
        $this->db->from("llx_commande c");
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
    public function get_commande_by_rowid($rowid=NULL){
        $this->db->select("c.rowid rowid, c.ref ref, c.fk_statut, c.tva, c.total_ht, c.total_ttc, c.localtax1,
                            c.date_creation, c.fk_soc,
                            so.nom soc_nom,
                            pt.code payment_term_code,
                            u.lastname sales_representative_lastname, u.firstname sales_representative_firstname"); //firstname和lastname是销售代表
        $this->db->from("llx_commande c, llx_societe so");
        $this->db->join("llx_societe_commerciaux sc", "sc.fk_soc=c.fk_soc","left");
        $this->db->join("llx_user u","u.rowid=sc.fk_user","left");
        $this->db->join("llx_c_payment_term pt","pt.rowid=c.fk_cond_reglement","left");
        $this->db->where('c.rowid',$rowid);
        $this->db->where("so.rowid=c.fk_soc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //一个函数两用，如果输入的id为空则添加新订单，如果不为空则更新
    public function replace_commande($rowid=null)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        //添加新的订单，自动生成订单ref号, 草稿的情况
        if($rowid==null) {
            $this->db->limit(1);
            $this->db->select("ref");
            $this->db->from("llx_commande");
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
            'ref_client'=>$this->input->post('ref_client'),
            'fk_soc'=>$this->input->post('fk_soc'),
            'fk_multicurrency'=>1,
            'multicurrency_code'=>'EUR',
            'fk_projet'=>NULL,
            'date_commande'=>$this->input->post('date_commande'), //订单日期
            'date_livraison'=>$this->input->post('date_livraison'),//计划运输日期

            //没弄懂是做什么的
            'source'=>null,
            'note_public'=>$this->input->post('note_public'),
            'note_private'=>$this->input->post('note_private'),
            'model_pdf'=>'einstein',
            'fk_cond_reglement'=>$this->input->post('cond_reglement'),
            'fk_mode_reglement'=>$this->input->post('mode_reglement'),
            'fk_availability'=>$this->input->post('availability_delay'),//交货延迟日期
            'fk_shipping_method'=>$this->input->post('shipping_method'),//运输方式
            'fk_input_reason'=>$this->input->post('source'),
            'fk_incoterms'=>0,

        );
        if($rowid==null) {
            $data['date_creation']=$tms;//创建时间只有在创建产品的时候才会记录
            //$date['fk_statut']=0; 草稿类型
            $data['fk_user_author']=$_SESSION['rowid'];

            $this->db->insert('llx_commande', $data);
            $id = $this->db->insert_id();
        }
        else{
            $this->db->where('rowid', $rowid);
            $data['fk_user_modif']=$_SESSION['rowid'];

            $this->db->update('llx_commande', $data);
        }

        return $id;//返回新创建的订单id
    }

    //更换订单的第三方
    public function change_fk_soc($fk_commande){
        //先获得之前订单添加的产品
        $list_commandedet=$this->get_list_commandedet($fk_commande);
        //更改第三方
        $data['fk_soc']=$this->input->post('fk_soc');
        $data['fk_user_modif']=$_SESSION['rowid'];
        $this->db->where("rowid",$fk_commande);
        $this->db->update('llx_commande', $data);
        //删除之前的所有commandedet, 再添加
        foreach ($list_commandedet as $value){
            //删除
            $this->delete_commandedet($value['rowid'],$fk_commande);
            //重新添加
            $this->add_commandedet($fk_commande,$value['product_rowid'],$value['qty'],$value['unit']);
        }

    }

    //获得该订单的客户id
    public function get_soc_rowid($fk_commande){
        $this->db->select("c.fk_soc");
        $this->db->from("llx_commande c");
        $this->db->where("c.rowid",$fk_commande);
        $query=$this->db->get();
        $result=$query->result_array();
        if($result==NULL){
            return 0;
        }
        $fk_soc=$result[0]["fk_soc"];
        return $fk_soc;
    }

    //查看客户是否有选择价目表
    public function if_price_level($fk_commande,$fk_product){
        $this->db->limit(1);
        $this->db->select("sp.price_level");
        $this->db->from("llx_commande c, llx_societe_prices sp");
        $this->db->where("c.rowid",$fk_commande);
        $this->db->where("c.fk_soc=sp.fk_soc");
        $this->db->order_by("sp.rowid","desc");
        $query=$this->db->get();
        //如果用户没有设置价目表，则用nivel 1的售价
        if($query->result_array()==NULL){
            //return -1;
            $price_level=1;
        }
        else{
            $price_level=$query->result_array()[0]['price_level'];
        }
        //$price_level=$query->result_array()[0]['price_level'];
        //echo $price_level;
        //return $query->result_array()[0]['price_level'];
        //如果有价目表，则返回对应的价格
        $this->db->limit(1);
        $this->db->select("price");
        $this->db->from("llx_product_price pp");
        $this->db->where("fk_product",$fk_product);
        $this->db->where("price_level",$price_level);
        $this->db->order_by("rowid","desc");
        $query=$this->db->get();
        //如果该产品没有该级别价目，则返回0
        if($query->result_array()==NULL){
            return 0;
        }
        return $query->result_array()[0]['price'];
    }

    //通过订单号查看该客户是否开启增值税
    //return 1 if yes
    public function if_tva_tx($fk_commande){
        $this->db->select("s.tva_assuj");
        $this->db->from("llx_commande c, llx_societe s");
        $this->db->where("c.rowid",$fk_commande);
        $this->db->where("c.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['tva_assuj'];
    }

    //通过订单号查看该订单的客户是否开启re税(特殊附加税)
    //return 1 if yes
    public function if_re($fk_commande){
        $this->db->select("s.localtax1_assuj");
        $this->db->from("llx_commande c, llx_societe s");
        $this->db->where("c.rowid",$fk_commande);
        $this->db->where("c.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['localtax1_assuj'];
    }

    //通过订单号和产品号查找该产品在该订单下是否有折扣
    //return taux of discount if yes
    public function if_discount($fk_commande,$fk_product){
        //获得订单的客户
        $fk_soc=$this->get_soc_rowid($fk_commande);
        //echo $fk_soc;
        //获得产品的标签 (如果有小标签则优先显示小标签，否则显示大标签)
        $this->db->select("fk_categorie");
        $this->db->from("llx_categorie_product cp, llx_categorie c");
        $this->db->where("cp.fk_product",$fk_product);
        $this->db->where("c.rowid=cp.fk_categorie");
        $this->db->order_by("c.fk_parent","desc");
        $query=$this->db->get();
        //print_r($query->result_array());
        $result=$query->result_array();
        if($result==NULL){
            return 0;
        }
        $fk_categorie=$query->result_array()[0]["fk_categorie"];
        //echo $fk_categorie;
        //获得客户对应的fare (折扣规则)
        $this->db->select("fk_fare");
        $this->db->from("llx_fd_f2s f2s");
        $this->db->where("f2s.fk_societe",$fk_soc);
        $query=$this->db->get();
        $result=$query->result_array();
        if($result==NULL){
            return 0;
        }
        $fk_fare=$result[0]['fk_fare'];
        //echo $fk_fare;
        //获得产品对应的折扣
        $this->db->select("rate");
        $this->db->from("llx_fd_f2pc f2pc");
        $this->db->where("f2pc.fk_fare",$fk_fare);
        $this->db->where("f2pc.fk_category",$fk_categorie);
        $query=$this->db->get();
        $result=$query->result_array();
        if($result==NULL){
            return 0;
        }
        return $query->result_array()[0]['rate'];
    }

    //获得订单里的所有对象列表 rowid=commande_rowid
    public function get_list_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.buy_price_ht, c.unit, c.total_localtax1, c.remise_percent,
                           p.barcode, p.ref ref, p.label label, p.cost_price, p.rowid product_rowid,
                           p.pack, p.box, p.bigbox");
        $this->db->from("llx_commandedet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->join("llx_product_extrafields pe","pe.fk_object=c.fk_product","left");
        $this->db->where("c.fk_commande",$rowid);
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得订单里的单个对象  rowid=commandedet_rowid
    public function get_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.buy_price_ht, c.unit, c.total_localtax1, c.remise_percent,
                           p.barcode, p.ref ref, p.label label, p.cost_price, p.rowid product_rowid,
                           p.pack, p.box, p.bigbox");
        $this->db->from("llx_commandedet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->join("llx_product_extrafields pe","pe.fk_object=c.fk_product","left");
        $this->db->where("c.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //增加订单的对象
    //$rowid不为null时为添加订单
    public function add_commandedet($fk_commande,$fk_product,$qty,$unit=0,$discount=0,$rowid=NULL){
        $info_product = $this->get_info_product($fk_product);
        if($info_product==null){
            return null;//没找到产品
        }
        foreach($info_product as $value){
        }
        //如果客户没有开启增值税，则税率为0
        if($this->if_tva_tx($fk_commande)!=1){
            $tva_tx=0;
        }
        else{
            $tva_tx=$value["tva_tx"];
        }
        //查看用户是否设置价格级别, 如果设置则返回该产品在该用户价格级别的价格
        $level_price=$this->if_price_level($fk_commande,$fk_product);
        if($level_price!=-1){
            $value["price"]=$level_price;
        }
        $subprice=$value["price"];
        //如果用户没有输入折扣
        if($discount==0) {
            //使用标签对应用户设置的折扣
            $discount = $this->if_discount($fk_commande, $fk_product);
        }
        $subprice=$subprice*(100-$discount)/100;//减去折扣
        $price=$subprice*(100+$tva_tx)/100;
        $buy_price_ht=$value["pmp"];

        if($unit==1){
            $qty=$qty*$value['pack'];
        }else if($unit==2){
            $qty=$qty*$value['box'];
        }
        else if($unit==3){
            $qty=$qty*$value['bigbox'];
        }
        $total_ht=$subprice*$qty;
        $total_ttc=$price*$qty;
        $total_tva=$subprice*$tva_tx/100*$qty;
        $data=array(
            'fk_commande'=>$fk_commande,
            'fk_product'=>$fk_product,
            'tva_tx'=>$tva_tx,
            'qty'=>$qty,
            'unit'=>$unit,
            'remise_percent'=>$discount, //折扣
            'price'=>$value["price_ttc"],
            'subprice'=>$value["price"],
            'total_ht'=>$total_ht,
            'total_tva'=>$total_tva,
            'total_ttc'=>$total_ttc,
            'buy_price_ht'=>$buy_price_ht,//这里记的是单个的买价，不是总的买价

            'localtax1_type'=>3,//这个类型不知道是做什么的
            'localtax2_type'=>5,
            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_subprice'=>$value["price"],
            'multicurrency_total_ht'=>$total_ht,
            'multicurrency_total_tva'=>$total_tva,
            'multicurrency_total_ttc'=>$total_ttc,
        );
        //如果该用户有设置re税，且产品包含增值税则添加
        $total_localtax1=0;
        if($this->if_re($fk_commande)==1&&$tva_tx!=0){
            $total_localtax1=$subprice*0.052*$qty; //0.052是re税率，暂时不知道从哪里来的
            $total_ttc=$total_ttc+$total_localtax1;
            $data['localtax1_tx']=5.2;
            $data['total_localtax1']=$total_localtax1;
            $data['total_ttc']=$total_ttc;
        }
        if($rowid!=NULL){
            $this->db->where("rowid",$rowid);
            $this->db->update('llx_commandedet', $data);
            $id=$rowid;
        }
        else{
            $this->db->insert('llx_commandedet', $data);
            $id = $this->db->insert_id();
        }
        //更新订单总信息
        $tms=date("Y-m-d h:i::sa");
        //$tva=$total_ttc_all-$total_ht_all;
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total_ht', 'ifnull(total_ht,0)+'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)+'.$total_buy_price, FALSE);//找不到成本价的位置！！！
        $this->db->set('tva', 'ifnull(tva,0)+'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)+'.$total_localtax1,FALSE);//RE税

        $this->db->where('rowid', $fk_commande);
        $this->db->update('llx_commande', $data);//更新订单的总价格

        return $id;//返回刚刚添加的订单对象id
    }

    //删除订单里的对象
    /*public function delete_commandedet($rowid_commandedet,$rowid_commande,$total_ht,$total_ttc,$buy_price_ht,$total_ht_all,$total_ttc_all,$total_buy_price){

        $total_ht_all=$total_ht_all-$total_ht;//total_ht是单行的total_ht
        $total_ttc_all=$total_ttc_all-$total_ttc;
        $total_buy_price=$total_buy_price-$buy_price_ht;
        $tva=$total_ttc_all-$total_ht_all;
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
            'total_ht' => $total_ht_all,
            'total_ttc' => $total_ttc_all,
            'tva'=>$tva,
            //'total_buy_price'=>$total_buy_price,

            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_tx'=>1,
            'multicurrency_total_ht'=>$total_ht_all,
            'multicurrency_total_tva'=>$tva,
            'multicurrency_total_ttc'=>$total_ttc_all,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande', $data);//更新订单的总价格

        $this->db->delete('llx_commandedet',array('rowid'=>$rowid_commandedet));//删除订单的对象
    }*/
    public function delete_commandedet($rowid_commandedet,$fk_commande){
        $info_commandedet=$this->get_commandedet($rowid_commandedet);
        foreach($info_commandedet as $value){}
        $total_ht=$value['total_ht'];
        $total_ttc=$value['total_ttc'];
        $total_tva=$value['total_tva'];
        $total_localtax1=$value['total_localtax1'];
        //$buy_price_ht=$value['buy_price_ht'];

        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total_ht', 'ifnull(total_ht,0)-'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)-'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)-'.$buy_price_ht, FALSE);//找不到成本价的位置！！！
        $this->db->set('tva', 'ifnull(tva,0)-'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)-'.$total_localtax1,FALSE);//RE税

        $this->db->where('rowid', $fk_commande);
        $this->db->update('llx_commande', $data);//更新订单的总价格

        $this->db->delete('llx_commandedet',array('rowid'=>$rowid_commandedet));//删除订单的对象

    }

    //验证订单
    public function validate_commande($rowid_commande){
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
            'date_valid' => $tms,
            'fk_user_valid' => $_SESSION['rowid'],
            'fk_statut'=>1,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande', $data);
    }

    //取消验证
    public function cancel_validate($rowid_commande){
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
            'fk_statut'=>0,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_commande', $data);
    }

    //获得所有产品的条形码
    //之后如果用barcode来搜索产品的信息，效率太低，所以这里要同时读取rowid
    public function get_list_barcodes(){
        $this->db->select("rowid, barcode");
        $this->db->from("llx_product");
        //$query=$this->db->get();
        //get_compiled_select() that gives the query string without actually executing the query.
        $query1 = $this->db->get_compiled_select();

        $this->db->select("rowid as rowid, barcode_pack as barcode");
        $this->db->from("llx_product");
        $this->db->where("barcode_pack is not null");
        $this->db->where("barcode_pack <>''");
        //$this->db->where();//pack_barcode!=null
        $query_pack = $this->db->get_compiled_select();

        $this->db->select("rowid as rowid, barcode_box as barcode");
        $this->db->from("llx_product");
        $this->db->where("barcode_box is not null");
        $this->db->where("barcode_box <>''");
        //$this->db->where();//pack_barcode!=null
        $query_box = $this->db->get_compiled_select();

        $this->db->select("rowid as rowid, barcode_bigbox as barcode");
        $this->db->from("llx_product");
        $this->db->where("barcode_bigbox is not null");
        $this->db->where("barcode_bigbox <>''");
        //$this->db->where();//pack_barcode!=null
        $query_bigbox = $this->db->get_compiled_select();

        $query = $this->db->query($query1." UNION ".$query_pack." UNION ".$query_box." UNION ".$query_bigbox);
        //默认地，UNION 操作符选取不同的值。如果允许重复的值，请使用 UNION ALL。
        return $query->result_array();
    }

    //通过产品rowid号获得产品的详细信息
    //fk_commande是用来查看是否有价格级别
    public function get_info_product($rowid,$fk_commande=NULL,$fk_facture=NULL){
        $this->db->select("p.rowid, p.ref, p.label, p.price, p.price_ttc, p.tva_tx, p.pmp,
                            p.pack,p.box,p.bigbox");
        $this->db->from("llx_product p");
        $this->db->join("llx_product_extrafields pe","pe.fk_object=p.rowid","left");
        $this->db->where("p.rowid",$rowid);
        $query=$this->db->get();
        $info_product=$query->result_array();
        //如果pmp为0的情况 最佳买价为成本价
        foreach($info_product as &$value){
            if($value['pmp']==0){
                $value['pmp']=$this->get_best_buying_price($value['rowid']);
            }
            if($fk_commande!=NULL) {
                $level_price = $this->if_price_level($fk_commande, $value['rowid']);
                if ($level_price != -1) {
                    $value["price"] = $level_price;
                }
            }
            if($fk_facture!=NULL){
                $level_price = $this->Facture_model->if_price_level($fk_facture, $value['rowid']);
                if ($level_price != -1) {
                    $value["price"] = $level_price;
                }
            }
        }
        return $info_product;
    }
    //通过产品条码获得产品的详细信息和该ref号对应的单位   如果是从产品找到该条码，则返回unit=0, 如果是从包条码找到,unit=1, 如果是箱,unit=2,运输箱, unit=3
    public function get_info_product_by_barcode($barcode,$fk_commande=NULL,$fk_facture=NULL){
        //如果是从产品条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product($rowid,$fk_commande,$fk_facture);
            $info_product[0]['unit']=0;//是二维数组第一个元素
            return $info_product;
        }
        //如果是从产品包条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_pack($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product($rowid,$fk_commande,$fk_facture);
            $info_product[0]['unit']=1;//是包
            return $info_product;
        }
        //如果是从产品箱条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_box($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product($rowid,$fk_commande,$fk_facture);
            $info_product[0]['unit']=2;//是箱
            return $info_product;
        }
        //如果是从产品运输箱条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_bigbox($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product($rowid,$fk_commande,$fk_facture);
            $info_product[0]['unit']=3;//是运输箱
            return $info_product;
        }
    }
    //通过产品ref返回产品rowid
    public function get_product_rowid_by_ref($ref){
        $this->db->select("p.rowid");
        $this->db->from("llx_product p");
        $this->db->where("p.ref",$ref);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }
    //通过产品barcode返回产品rowid
    public function get_product_rowid_by_barcode($barcode){
        $this->db->select("p.rowid");
        $this->db->from("llx_product p");
        $this->db->where("p.barcode",$barcode);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }
    //通过产品包条码返回产品rowid
    public function get_product_rowid_by_barcode_pack($barcode){
        $this->db->select("pe.fk_object rowid");
        $this->db->from("llx_product p");
        $this->db->where("p.barcode_pack",$barcode);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }
    //通过产品箱条码返回产品rowid
    public function get_product_rowid_by_barcode_box($barcode){
        $this->db->select("pe.fk_object rowid");
        $this->db->from("llx_product p");
        $this->db->where("p.barcode_box",$barcode);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }
    //通过产品运输箱条码返回产品rowid
    public function get_product_rowid_by_barcode_bigbox($barcode){
        $this->db->select("pe.fk_object rowid");
        $this->db->from("llx_product pe");
        $this->db->where("p.barcode_bigbox",$barcode);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }

    //获得产品的最佳买价// 如果pmp为0的情况 最佳买价为成本价
    public function get_best_buying_price($fk_product){
        $this->db->limit(1);
        $this->db->select("pfp.unitprice");
        $this->db->from("llx_product_fournisseur_price pfp, llx_societe s");
        $this->db->where("pfp.fk_product",$fk_product);
        $this->db->where("s.rowid=pfp.fk_soc");
        $this->db->order_by("pfp.unitprice", "ASC");
        $query = $this->db->get();
        $result=$query->result_array();
        if($result==null){
            return 0;
        }
        foreach($result as $value){
        }
        return $value['unitprice'];
    }


    //获得产品列表  price是税前价格, price_ttc是含税价格
    public function get_list_products(){
        $this->db->select("p.rowid,p.ref,p.label,p.price,p.price_ttc");
        $this->db->from("llx_product p");
        $this->db->order_by("p.rowid", "desc");
        //$query=$this->db->get();
        $query1 = $this->db->get_compiled_select();

        $this->db->select("p.rowid,p.ref,p.label,p.price,p.price_ttc");
        $this->db->from("llx_product p");
        $this->db->order_by("p.rowid", "desc");
        $query2 = $this->db->get_compiled_select();
        //Since CodeIgniter 3 it's been introduced in Active Record the function get_compiled_select() that gives the query string without actually executing the query.
        $query = $this->db->query($query1." UNION ".$query2);
        return $query->result_array();
    }

    //获得客户信息
    public function get_list_client(){
        $this->db->select("s.rowid rowid, s.nom nom");
        $this->db->from("llx_societe s");
        $this->db->where("(s.client=1 or s.client=3)");
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
    public function get_cond_reglement($rowid=NULL){
        $this->db->select("rowid, code, libelle_facture, nbjour");
        $this->db->from("llx_c_payment_term");
        if($rowid!=NULL){
            $this->db->where("rowid",$rowid);
        }
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

    //导入Excel
    public function import_excel($rowid_commande){
        $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/commande_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
        $sheet=$excel->getSheet(0);//选择第几个表, sheet0,sheet1... 我们只导入第一页
        $data=$sheet->toArray();//把表格的数据转换为数组，注意：这里转换是以行号为数组的外层下标，列号会转成数字为数组内层下标，坐标对应的值只会取字符串保留在这里，图片或链接不会出现在这里。

        //把整个excel表格遍历
        $errors="";//错误信息，提示没有添加成功的产品
        //$flag=0; //0=按照ref导入产品 1=按照barcode导入产品
        /*if($data[0][0]=="barcode"){
            $flag=1;
        }
        if($data[0][0]=="ref"){
            $flag=0;
        }*/

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
            if($ref==null){ //barcode
                $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有找到产品--该产品添加失败</font> <br> <br>";
                $i=$i+1;//不要忘记i+1, 否则无法停止
                continue;
            }
            if($flag==0) {
                $rowid_product = $this->get_product_rowid_by_ref($ref);
            }
            else{
                $rowid_product = $this->get_product_rowid_by_barcode($ref);
            }

            if($rowid_product==null){
                $errors.=" <font color='#8b0000'>错误 :第".$i."行--该产品没有找到--该产品添加失败</font> <br> <br> ";
                $i=$i+1;
                continue;
                //return "第".$i."行--条形码重复";
            }
            /*echo $ref;
            echo "<br>";
            echo $qty;*/
            $this->add_commandedet($rowid_commande, $rowid_product, $qty);
            $errors.=" <font color='#00008b'>第".$i."行--产品添加成功 </font><br> <br>";
            $i=$i+1;
        }
        if($errors==""){
            return "全部产品上传成功!";
        }
        else {
            return $errors;
        }
    }

    //报表
    //销售代表销售情况(显示每个销售代表的客户)
    public function get_societe_commerciaux_selling_by_date($start_time=null, $end_time=null){
        if($start_time==NULL){
            $start_time=$this->input->post('start_time');
            $end_time=$this->input->post('end_time');
        }

        $this->db->select('sum(c.total_ttc) as total_ttc, count(c.total_ttc) as count_number,
                           s.nom as soc_nom, cd.nom departement_nom, u.lastname, u.firstname, s.rowid soc_rowid,
                           sc.fk_user as sc_fk_user,
                           s.lat, s.lng,
                           ');
        $this->db->from('llx_commande c, llx_societe s');
        $this->db->where('c.fk_soc=s.rowid');
        $this->db->join("llx_c_departements cd","cd.rowid=s.fk_departement","left");//城市
        $this->db->join('llx_societe_commerciaux sc','sc.fk_soc=s.rowid','left');//销售代表
        $this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
        $this->db->where('c.date_valid >=',$start_time);
        $this->db->where('c.date_valid <=',$end_time);
        $this->db->where('c.fk_statut<>0');//草稿
        $this->db->where('c.fk_statut<>-1');//已取消

        $this->db->group_by("s.rowid");//这个语句可能会引发问题
        $this->db->group_by("sc_fk_user");//销售代表
        $this->db->order_by("total_ttc", "DESC");
        $query=$this->db->get();

        $resultat=$query->result_array();
        /*echo "<br><br>------------------------------<br>";
        echo "<table>";
        echo "<tr><td>客户</td><td>总单数</td><td>总金额</td><td>城市</td><td>销售代表</td></tr>";
        foreach($resultat as $value){
            echo "<tr>";
            echo "<td>".$value['soc_nom']." </td>";
            echo "<td>".$value['count_number']."</td>";
            echo "<td> ".number_format($value['total_ttc'],3)."</td><td>".$value['departement_nom']."</td>";
            echo "<td>".$value['lastname']."&nbsp".$value['firstname']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br><br>------------------------------<br>";*/
        //$this->export_client_consume($resultat);

        return $resultat;
    }
    //报表
    //销售代表销售情况(显示总情况)
    public function get_societe_commerciaux_selling_sum_by_date($start_time=null, $end_time=null){
        if($start_time==NULL){
            $start_time=$this->input->post('start_time');
            $end_time=$this->input->post('end_time');
        }

        $this->db->select('sum(c.total_ttc) as total_ttc, count(c.total_ttc) as count_number,
                           u.lastname, u.firstname,
                           sc.fk_user as sc_fk_user,
                           ');
        $this->db->from('llx_commande c, llx_societe s');
        $this->db->where('c.fk_soc=s.rowid');
        $this->db->join("llx_c_departements cd","cd.rowid=s.fk_departement","left");//城市
        $this->db->join('llx_societe_commerciaux sc','sc.fk_soc=s.rowid','left');//销售代表
        $this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
        $this->db->where('c.date_valid >=',$start_time);
        $this->db->where('c.date_valid <=',$end_time);
        $this->db->where('c.fk_statut<>0');//草稿
        $this->db->where('c.fk_statut<>-1');//已取消

        $this->db->group_by("sc_fk_user");//销售代表
        $this->db->order_by("total_ttc", "DESC");
        $query=$this->db->get();

        $resultat=$query->result_array();

        return $resultat;
    }
}