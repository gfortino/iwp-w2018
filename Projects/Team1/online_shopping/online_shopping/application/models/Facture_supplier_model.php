<?php
/**
 * Created by Zherui.  吼啊!
 */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';//导出Excel插件

//处理发票信息
class Facture_supplier_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Commande_model');

        $this->load->model('Commande_supplier_model');
    }
    //获得所有发票
    public function get_all_factures(){
        $this->db->select("f.rowid rowid, f.ref ref, f.datec datec, s.nom societe, f.total_ttc total_ttc
                           ");
        $this->db->from("llx_facture f");
        $this->db->join("llx_societe s","f.fk_soc=s.rowid","left");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得分页发票
    public function fetch_factures($limit,$offset){
        $ref=$this->input->post('ref');
        $this->db->limit($limit,$offset);
        $this->db->select("f.rowid rowid, f.ref ref, f.datec datec, f.datef datef, s.nom societe, f.total_ttc total_ttc,                            
                           ");
        $this->db->from("llx_facture_fourn f");
        $this->db->join("llx_societe s","f.fk_soc=s.rowid","left");
        $this->db->like("f.ref",$ref);
        $this->db->order_by("f.datec", "DESC");

        $query=$this->db->get();
        return $query->result_array();
    }
    public function count_factures(){
        $query = $this->db->query('SELECT rowid FROM llx_facture_fourn');
        return $query->num_rows();
    }

    //$rowid为null时为添加，不为null时为修改
    //facturedet_array是从订单里创建的发票，把订单里的元素也添加进来，如果为null则是正常创建的发票
    public function replace_facture($rowid=NULL,$fk_commande=NULL)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        //添加新的发票，自动生成订单facnumber号, 草稿的情况
        if($rowid==null) {
            $this->db->limit(1);
            $this->db->select("ref");
            $this->db->from("llx_facture_fourn");
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
            $num_facnumber = $num + 1;
            $facnumber = "(PROV" . $num_facnumber;
            $facnumber=$facnumber.")";
            echo $facnumber;
        }
        $datef=$this->input->post('datef');
        //获得付款条件天数长度
        $cond_reglement=$this->input->post('cond_reglement');
        $nbjour = $this->Commande_model->get_cond_reglement($cond_reglement)[0]['nbjour'];
        $date_lim_reglement=date('Y-m-d',strtotime("+".$nbjour."days",strtotime($datef)));

        $data=array(
            'entity'=>1,
            'ref_supplier'=>$this->input->post('ref_supplier'),
            'type'=>0,
            'datef'=>$datef,
            'tms'=>$tms,
            'fk_multicurrency'=>1,
            'multicurrency_code'=>'EUR',
            'fk_projet'=>NULL,

            'note_public'=>$this->input->post('note_public'),
            'note_private'=>$this->input->post('note_private'),
            'fk_cond_reglement'=>$this->input->post('cond_reglement'),
            'fk_mode_reglement'=>$this->input->post('mode_reglement'),
            'date_lim_reglement'=>$date_lim_reglement,

        );
        if($rowid==null) {
            $data['fk_soc']=$this->input->post('fk_soc');
            $data['ref']=$facnumber;
            $data['datec']=$tms;//创建时间只有在创建产品的时候才会记录
            $data['paye']=0;
            $data['model_pdf']='crabe';
            $data['fk_incoterms']=0;
            $data['fk_statut']=0;
            //$date['fk_statut']=0; 草稿类型
            $data['fk_user_author']=$_SESSION['rowid'];

            $this->db->insert('llx_facture_fourn', $data);
            $id = $this->db->insert_id();
        }
        else{
            $id=$rowid;
            $this->db->where('rowid', $rowid);
            $data['fk_user_modif']=$_SESSION['rowid'];
            $this->db->update('llx_facture_fourn', $data);
        }

        if($fk_commande!=NULL){
            //增加发票和订单的对应关系
            //llx_element_element ee
            $data=array(
                'fk_source'=>$fk_commande,
                'sourcetype'=>'order_supplier',
                'fk_target'=>$id,
                'targettype'=>'invoice_supplier'
            );
            $this->db->insert('llx_element_element', $data);

            //添加订单里的产品
            $products_rowid=$this->input->post('product_check_box');
            echo "我日你";
            print_r($products_rowid);
            if($products_rowid!=null) {
                foreach ($products_rowid as $value) {
                    $qty=$this->input->post('real_qty_'.$value);
                    $this->add_facturedet($id,null,$value,$qty);
                    echo "wori";
                }
            }
        }


        return $id;//返回新创建的订单id
    }


    public function get_facture_by_rowid($rowid){
        $this->db->select("ff.rowid rowid, ff.ref ref, ff.datec datec, ff.total total, ff.total_ttc total_ttc, ff.total_tva total_tva, ff.localtax1,
                            ff.datef, ff.date_lim_reglement,
                            s.nom soc_name,
                            t.code typent_code, t.libelle typent_libelle,
                            d.nom departement_nom, s.town
                           ");
        $this->db->from("llx_facture_fourn ff, llx_societe s");
        $this->db->join("llx_c_typent t","t.id=s.fk_typent","left");//合伙人类型
        $this->db->join("llx_c_departements d","d.rowid=s.fk_departement","left");//合伙人城市
        $this->db->where("s.rowid=ff.fk_soc");
        $this->db->where('ff.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得发票里的单个对象  rowid=facturedet_rowid
    public function get_facturedet($rowid){
        $this->db->select("f.rowid rowid, f.remise_percent,, f.qty qty, f.unit, f.tva_tx, f.total_ttc total_ttc, f.total_ht, f.total_tva, f.total_localtax1,
                           p.rowid product_rowid, p.barcode barcode, p.label label, p.price_ttc,
                           ");
        $this->db->from("llx_facture_fourn_det f");
        $this->db->join("llx_product p","f.fk_product=p.rowid","left");
        //$this->db->where("f.fk_product=p.rowid");
        $this->db->where("f.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //用发票rowid获得发票里的元素facturedet
    //原生版本的get facturedet
    public function get_facturedet_by_facture_rowid($rowid){
        $this->db->select("ffd.rowid rowid, ffd.remise_percent, ffd.qty qty, ffd.tva_tx, ffd.total_ttc total_ttc, ffd.total_ht,
                            ffd.description, ffd.localtax1_tx,
                            p.rowid product_rowid, p.barcode barcode, p.label label, p.price_ttc,
                           ");
        $this->db->from("llx_facture_fourn_det ffd");
        $this->db->join("llx_product p","ffd.fk_product=p.rowid","left");

        $this->db->where("ffd.fk_facture_fourn",$rowid);
        //$this->db->group_by("f.rowid");//这个语句可能会引发问题
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得该订单的客户id
    public function get_soc_rowid($fk_facture){
        $this->db->select("f.fk_soc");
        $this->db->from("llx_facture f");
        $this->db->where("f.rowid",$fk_facture);
        $query=$this->db->get();
        $result=$query->result_array();
        if($result==NULL){
            return 0;
        }
        $fk_soc=$result[0]["fk_soc"];
        return $fk_soc;
    }

    //查看客户是否有选择价目表
    /*public function if_price_level($fk_facture,$fk_product){
        $this->db->limit(1);
        $this->db->select("sp.price_level");
        $this->db->from("llx_facture f, llx_societe_prices sp");
        $this->db->where("f.rowid",$fk_facture);
        $this->db->where("f.fk_soc=sp.fk_soc");
        $this->db->order_by("sp.rowid","desc");
        $query=$this->db->get();
        //如果用户没有设置价目表，则用level 1的售价
        if($query->result_array()==NULL){
            //return -1;
            $price_level=1;
        }
        else{
            $price_level=$query->result_array()[0]['price_level'];
        }
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
    }*/


    //通过发票号查看该客户是否开启增值税
    //return 1 if yes
    public function if_tva_tx($fk_facture){
        $this->db->select("s.tva_assuj");
        $this->db->from("llx_facture_fourn ff, llx_societe s");
        $this->db->where("ff.rowid",$fk_facture);
        $this->db->where("ff.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['tva_assuj'];
    }

    //通过供货商发票号查看该发票的客户是否开启re税(特殊附加税)
    //return 1 if yes
    public function if_re($fk_facture){
        $this->db->select("s.localtax1_assuj");
        $this->db->from("llx_facture_fourn ff, llx_societe s");
        $this->db->where("ff.rowid",$fk_facture);
        $this->db->where("ff.fk_soc=s.rowid");
        $query=$this->db->get();
        echo $query->result_array()[0]['localtax1_assuj'];
        return $query->result_array()[0]['localtax1_assuj'];
    }

    //添加facturedet
    //增加供应商发票的对象
    public function add_facturedet($fk_facture,$price_rowid=null,$fk_product=null,$qty,$unit=0,$discount=0){
        if($price_rowid!=null&&$price_rowid!='null'){
            //如果选的是产品和供应商价格的rowid，则直接读取价格
            $info_product = $this->Commande_supplier_model->get_info_product($price_rowid);
        }
        else{
            //如果选的是产品的rowid，则选择该产品对应供应商价格的第一个价格
            $info_product = $this->Commande_supplier_model->get_info_product(null,$fk_product);
        }
        if($info_product==null){
            echo "没找到产品";
            return "没找到产品";//没找到产品
        }
        foreach($info_product as $value){
        }
        //如果客户没有开启增值税，则税率为0
        if($this->if_tva_tx($fk_facture)!=1){
            $tva_tx=0;
        }
        else{
            $tva_tx=$value["tva_tx"];
        }
        $subprice=$value["unitprice"];
        $subprice=$subprice*(100-$discount)/100;//减去折扣
        $price=$subprice*(100+$tva_tx)/100;
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
            'fk_facture_fourn'=>$fk_facture,
            'fk_product'=>$value['rowid_product'],
            'tva_tx'=>$tva_tx,
            'qty'=>$qty,
            //'unit'=>$unit,
            'remise_percent'=>$discount, //折扣
            'pu_ht'=>$value["unitprice"],
            'pu_ttc'=>$price,
            'total_ht'=>$total_ht,
            'tva'=>$total_tva,
            'total_ttc'=>$total_ttc,
            //'fk_user_author'=>$_SESSION['rowid'],
            //'fk_user_modif'=>$_SESSION['rowid'],

            'localtax1_type'=>0,
            'localtax2_type'=>0,
            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_subprice'=>$value["unitprice"],
            'multicurrency_total_ht'=>$total_ht,
            'multicurrency_total_tva'=>$total_tva,
            'multicurrency_total_ttc'=>$total_ttc,
        );
        //如果该用户有设置re税，且产品包含增值税则添加
        $total_localtax1=0;
        if($this->if_re($fk_facture)==1&&$tva_tx!=0){
            $price=$price+$subprice*0.052;
            $data['pu_ttc']=$price;
            $total_localtax1=$subprice*0.052*$qty; //0.052是re税率，暂时不知道从哪里来的
            $total_ttc=$total_ttc+$total_localtax1;
            $data['localtax1_tx']=5.2;
            $data['total_localtax1']=$total_localtax1;
            $data['total_ttc']=$total_ttc;
            $data['multicurrency_total_ttc']=$total_ttc;
        }
        $this->db->insert('llx_facture_fourn_det', $data);
        $id = $this->db->insert_id();

        //更新订单总信息
        $tms=date("Y-m-d h:i::sa");
        //$tva=$total_ttc_all-$total_ht_all;
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total_ht', 'ifnull(total_ht,0)+'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)+'.$total_buy_price, FALSE);//找不到成本价的位置！！！
        $this->db->set('total_tva', 'ifnull(total_tva,0)+'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)+'.$total_localtax1,FALSE);//RE税

        $this->db->set('multicurrency_total_ht', 'ifnull(multicurrency_total_ht,0)+'.$total_ht, FALSE);
        $this->db->set('multicurrency_total_ttc', 'ifnull(multicurrency_total_ttc,0)+'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)+'.$total_buy_price, FALSE);//找不到成本价的位置！！！
        $this->db->set('multicurrency_total_tva', 'ifnull(multicurrency_total_tva,0)+'.$total_tva, FALSE);

        $this->db->where('rowid', $fk_facture);
        $this->db->update('llx_facture_fourn', $data);//更新订单的总价格

        return $id;//返回刚刚添加的订单对象id
    }


    public function delete_facturedet($rowid_facturedet,$fk_facture){
        $info_facturedet=$this->get_facturedet($rowid_facturedet);
        foreach($info_facturedet as $value){}
        $total_ht=$value['total_ht'];
        $total_ttc=$value['total_ttc'];
        $total_tva=$value['total_tva'];
        $total_localtax1=$value['total_localtax1'];
        //$buy_price_ht=$value['buy_price_ht'];

        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total', 'ifnull(total,0)-'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)-'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)-'.$buy_price_ht, FALSE);//找不到成本价的位置！！！
        $this->db->set('tva', 'ifnull(tva,0)-'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)-'.$total_localtax1,FALSE);//RE税

        $this->db->where('rowid', $fk_facture);
        $this->db->update('llx_facture', $data);//更新订单的总价格

        $this->db->delete('llx_facturedet',array('rowid'=>$rowid_facturedet));//删除订单的对象
    }

}