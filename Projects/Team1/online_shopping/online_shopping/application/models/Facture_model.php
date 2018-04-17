<?php
/**
 * Created by Zherui.  吼啊!
 */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';//导出Excel插件

//处理发票信息
class Facture_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Commande_model');
    }
    //获得所有发票
    public function get_all_factures(){
        $this->db->select("f.rowid rowid, f.facnumber facnumber, f.datec datec, s.nom societe, f.total_ttc total_ttc
                           ");
        $this->db->from("llx_facture f");
        $this->db->join("llx_societe s","f.fk_soc=s.rowid","left");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得分页发票
    public function fetch_factures($limit,$offset){
        $facnumber=$this->input->post('facnumber');
        $this->db->limit($limit,$offset);
        $this->db->select("f.rowid rowid, f.facnumber facnumber, f.datec datec, f.datef datef, f.date_pay date_pay, s.nom societe, f.total_ttc total_ttc, f.commission_statut,
                            u.rowid sale_representative_rowid, u.lastname sale_representative_last_name,
                            u2.rowid fk_order_user, u2.lastname order_user_last_name,
                            u3.rowid fk_receipt_user, u3.lastname receipt_user_last_name,
                           ");
        $this->db->from("llx_facture f");
        $this->db->join("llx_societe s","f.fk_soc=s.rowid","left");
        $this->db->join('llx_societe_commerciaux sc','sc.fk_soc=f.fk_soc','left');//销售代表
        $this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
        $this->db->join('llx_user u2','fk_order_user=u2.rowid','left');//下单人
        $this->db->join('llx_user u3','fk_receipt_user=u3.rowid','left');//收款人
        $this->db->like("f.facnumber",$facnumber);
        $this->db->order_by("f.datec", "DESC");

        $query=$this->db->get();
        return $query->result_array();
    }
    public function count_factures(){
        $query = $this->db->query('SELECT rowid FROM llx_facture');
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
            $this->db->select("facnumber");
            $this->db->from("llx_facture");
            $this->db->where('fk_statut', 0);
            $this->db->order_by("rowid", "desc");
            $query = $this->db->get();
            $result=$query->result_array();
            if($result!=null){
                foreach ($result as $sum) ;
                $num = substr($sum['facnumber'], 5);
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
            'ref_client'=>$this->input->post('ref_client'),
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
            $data['facnumber']=$facnumber;
            $data['datec']=$tms;//创建时间只有在创建产品的时候才会记录
            $data['paye']=0;
            $data['model_pdf']='crabe';
            $data['fk_incoterms']=0;
            $data['situation_final']=0;
            //$date['fk_statut']=0; 草稿类型
            $data['fk_user_author']=$_SESSION['rowid'];

            $this->db->insert('llx_facture', $data);
            $id = $this->db->insert_id();
        }
        else{
            $id=$rowid;
            $this->db->where('rowid', $rowid);
            $data['fk_user_modif']=$_SESSION['rowid'];
            $this->db->update('llx_facture', $data);
        }

        if($fk_commande!=NULL){
            $facturedet_array = $this->Commande_model->get_list_commandedet($fk_commande);
            //增加发票和订单的对应关系
            //llx_element_element ee
        }
        if($facturedet_array!=NULL){
            foreach($facturedet_array as $value){
                $this->add_facturedet($id,$value['product_rowid'],$value['qty'],$value['unit'],$value['remise_percent']);
            }
        }

        return $id;//返回新创建的订单id
    }


    public function get_facture_by_rowid($rowid){
        $this->db->select("f.rowid rowid, f.facnumber facnumber, f.datec datec, f.total total, f.total_ttc total_ttc, f.tva total_tva, f.localtax1,
                            f.datef,f.datec, f.date_lim_reglement,
                            s.nom soc_name,
                            t.code typent_code, t.libelle typent_libelle,
                            d.nom departement_nom, s.town
                           ");
        $this->db->from("llx_facture f, llx_societe s");
        $this->db->join("llx_c_typent t","t.id=s.fk_typent","left");//合伙人类型
        $this->db->join("llx_c_departements d","d.rowid=s.fk_departement","left");//合伙人城市
        $this->db->where("s.rowid=f.fk_soc");
        $this->db->where('f.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得订单里的单个对象  rowid=commandedet_rowid
    public function get_facturedet($rowid){
        $this->db->select("f.rowid rowid, f.remise_percent, f.subprice, f.qty qty, f.unit, f.tva_tx, f.total_ttc total_ttc, f.total_ht, f.total_tva, f.total_localtax1,
                           p.rowid product_rowid, p.barcode barcode, p.label label, p.price_ttc,
                           ");
        $this->db->from("llx_facturedet f");
        $this->db->join("llx_product p","f.fk_product=p.rowid","left");
        //$this->db->where("f.fk_product=p.rowid");
        $this->db->where("f.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //用发票rowid获得发票里的元素facturedet
    //原生版本的get facturedet
    //如果不加入超期天数，则不计算佣金
    public function get_facturedet_by_facture_rowid($rowid,$delay=null){
        $this->db->select("f.rowid rowid, f.remise_percent, f.subprice, f.qty qty, f.unit, f.tva_tx, f.total_ttc total_ttc, f.total_ht,
                            f.description, f.localtax1_tx,
                            p.rowid product_rowid, p.barcode barcode, p.label label, p.price_ttc,
                           ");
        $this->db->from("llx_facturedet f");
        $this->db->join("llx_product p","f.fk_product=p.rowid","left");

        //计算佣金时才需要加入标签
        if($delay!=NULL){
            $this->db->select("c.rowid fk_categorie, c.label categorie_label, c.limit_discount");
            $this->db->join("llx_categorie_product cp","cp.fk_product=p.rowid","left");//这里用join是因为这个函数不只是给导出发票用的
            $this->db->join("llx_categorie c","cp.fk_categorie=c.rowid and c.fk_parent=0","left");//标签
            $this->db->where("c.fk_parent=0");
        }
        $this->db->where("f.fk_facture",$rowid);
        //$this->db->group_by("f.rowid");//这个语句可能会引发问题
        $query=$this->db->get();
        /*foreach()
        $value['ratio_commission']=$this->get_delay_time_ratio_commission_by_delay($value['delay_time']);*/
        if($delay==null) {
            return $query->result_array();
        }
        else{//如果有输入超期天数的情况，则返回佣金比例
            $facturedet=$query->result_array();
            foreach($facturedet as &$value){
                $reduce_ratio_commission=($value['remise_percent']/100-$value['limit_discount'])/2;//业务员需要减去的佣金比例,如果业务员给出的折扣大于公司给出的最高折扣，则需要减去这个 业务员和公司各承担一半
                //判断是否超过最高折扣
                if($reduce_ratio_commission<0){
                    $reduce_ratio_commission=0;
                }
                $ratio_commission=$this->get_delay_time_ratio_commission_by_delay($value['fk_categorie'],$delay,1)-$reduce_ratio_commission; //需要减去如果给出过高的折扣
                if($ratio_commission==null){
                    $ratio_commission=0;
                }
                $value['reduce_ratio_commission']=$reduce_ratio_commission;//查看折扣是否过高
                $value['ratio_commission']=$ratio_commission;
            }
            return $facturedet;
        }
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
    public function if_price_level($fk_facture,$fk_product){
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
    }


    //通过订单号查看该客户是否开启增值税
    //return 1 if yes
    public function if_tva_tx($fk_facture){
        $this->db->select("s.tva_assuj");
        $this->db->from("llx_facture f, llx_societe s");
        $this->db->where("f.rowid",$fk_facture);
        $this->db->where("f.fk_soc=s.rowid");
        $query=$this->db->get();
        return $query->result_array()[0]['tva_assuj'];
    }

    //通过发票号查看该发票的客户是否开启re税(特殊附加税)
    //return 1 if yes
    public function if_re($fk_facture){
        $this->db->select("s.localtax1_assuj");
        $this->db->from("llx_facture f, llx_societe s");
        $this->db->where("f.rowid",$fk_facture);
        $this->db->where("f.fk_soc=s.rowid");
        $query=$this->db->get();
        echo $query->result_array()[0]['localtax1_assuj'];
        return $query->result_array()[0]['localtax1_assuj'];
    }

    //通过订单号和产品号查找该产品在该订单下是否有折扣
    //return taux of discount if yes
    public function if_discount($fk_facutre,$fk_product){
        //获得发票的客户
        $fk_soc=$this->get_soc_rowid($fk_facutre);
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

    //添加facturedet
    //增加订单的对象
    public function add_facturedet($fk_facture,$fk_product,$qty,$unit=0,$discount=0){
        $info_product = $this->Commande_model->get_info_product($fk_product,NULL,$fk_facture);
        if($info_product==null){
            return null;//没找到产品
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
        $subprice=$value["price"];
        //如果用户没有输入折扣
        if($discount==0||NULL) {
            //使用标签对应用户设置的折扣
            $discount = $this->if_discount($fk_facture, $fk_product);
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
            'fk_facture'=>$fk_facture,
            'fk_product'=>$fk_product,
            'tva_tx'=>$tva_tx,
            'qty'=>$qty,
            'unit'=>$unit,
            'remise_percent'=>$discount, //折扣
            'price'=>$value['price_ttc'],
            'subprice'=>$value["price"],
            'total_ht'=>$total_ht,
            'total_tva'=>$total_tva,
            'total_ttc'=>$total_ttc,
            'buy_price_ht'=>$buy_price_ht,//这里记的是单个的买价，不是总的买价
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_user_modif'=>$_SESSION['rowid'],

            'localtax1_type'=>0,
            'localtax2_type'=>0,
            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_subprice'=>$value["price"],
            'multicurrency_total_ht'=>$total_ht,
            'multicurrency_total_tva'=>$total_tva,
            'multicurrency_total_ttc'=>$total_ttc,
        );
        //如果该用户有设置re税，且产品包含增值税则添加
        $total_localtax1=0;
        if($this->if_re($fk_facture)==1&&$tva_tx!=0){
            $total_localtax1=$subprice*0.052*$qty; //0.052是re税率，暂时不知道从哪里来的
            $total_ttc=$total_ttc+$total_localtax1;
            $data['localtax1_tx']=5.2;
            $data['total_localtax1']=$total_localtax1;
            $data['total_ttc']=$total_ttc;
        }
        $this->db->insert('llx_facturedet', $data);
        $id = $this->db->insert_id();

        //更新订单总信息
        $tms=date("Y-m-d h:i::sa");
        //$tva=$total_ttc_all-$total_ht_all;
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total', 'ifnull(total,0)+'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)+'.$total_buy_price, FALSE);//找不到成本价的位置！！！
        $this->db->set('tva', 'ifnull(tva,0)+'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)+'.$total_localtax1,FALSE);//RE税

        $this->db->where('rowid', $fk_facture);
        $this->db->update('llx_facture', $data);//更新订单的总价格

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
    //添加相对折扣
    public function add_discount_relative($fk_facture,$discount_relative,$discount_tva_tx,$discount_relative_description){
        //获得发票总金额
        $info_facture=$this->get_facture_by_rowid($fk_facture);
        foreach($info_facture as $un_facture){}

        $qty=1;
        $tva_tx=$discount_tva_tx;
        $subprice=-$un_facture['total']*($discount_relative)/100;//需要减去的折扣
        $price=$subprice*(100+$tva_tx)/100;
        $total_ht=$subprice*$qty;
        $total_ttc=$price*$qty;
        $total_tva=$subprice*$tva_tx/100*$qty;
        $data=array(
            'fk_facture'=>$fk_facture,
            'fk_product'=>NULL,
            'description'=>$discount_relative_description,
            'tva_tx'=>$tva_tx,
            'qty'=>$qty,
            'unit'=>0,
            'remise_percent'=>0, //折扣
            'fk_remise_except'=>1,//记得把这个改成1
            'price'=>$subprice,
            'subprice'=>$subprice,
            'total_ht'=>$total_ht,
            'total_tva'=>$total_tva,
            'total_ttc'=>$total_ttc,
            'buy_price_ht'=>0,//这里记的是单个的买价，不是总的买价
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_user_modif'=>$_SESSION['rowid'],
            'info_bits'=>2,
            'rang'=>-1,
            'situation_percent'=>'100',

            'localtax1_type'=>3,//这个类型不知道是做什么的
            'localtax2_type'=>5,
            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_subprice'=>$subprice,
            'multicurrency_total_ht'=>$total_ht,
            'multicurrency_total_tva'=>$total_tva,
            'multicurrency_total_ttc'=>$total_ttc,
        );
        //如果该用户有设置re税，且产品包含增值税则添加
        $total_localtax1=0;
        if($this->if_re($fk_facture)==1&&$tva_tx!=0){
            $total_localtax1=$subprice*0.052*$qty; //0.052是re税率，暂时不知道从哪里来的
            $total_ttc=$total_ttc+$total_localtax1;
            $data['localtax1_tx']=5.2;
            $data['total_localtax1']=$total_localtax1;
            $data['total_ttc']=$total_ttc;
        }
        $this->db->insert('llx_facturedet', $data);
        $id = $this->db->insert_id();

        //更新订单总信息
        $tms=date("Y-m-d h:i::sa");
        //$tva=$total_ttc_all-$total_ht_all;
        $data = array(
            'tms' =>$tms,
        );
        $this->db->set('total', 'ifnull(total,0)+'.$total_ht, FALSE);
        $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
        //$this->db->set('total_buy_price', 'ifnull(total_buy_price,0)+'.$total_buy_price, FALSE);//找不到成本价的位置！！！
        $this->db->set('tva', 'ifnull(tva,0)+'.$total_tva, FALSE);
        $this->db->set('localtax1','ifnull(localtax1,0)+'.$total_localtax1,FALSE);//RE税

        $this->db->where('rowid', $fk_facture);
        $this->db->update('llx_facture', $data);//更新订单的总价格

        return $id;//返回刚刚添加的订单对象id
    }



    //导入Excel
    public function import_excel($rowid_commande){
        $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/facture_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
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
                $rowid_product = $this->Commande_model->get_product_rowid_by_ref($ref);
            }
            else{
                $rowid_product = $this->Commande_model->get_product_rowid_by_barcode($ref);
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
            $this->add_facturedet($rowid_commande, $rowid_product, $qty);
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


    /*********************************///佣金///***********************************************************/

    //设置收款日期
    public function set_date_pay($rowid,$date_pay){
        $data = array(
            //'tms=tms',
            'date_pay'=>$date_pay,
        );
        $this->db->set('tms', 'tms', FALSE);//不更新时间
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_facture', $data);
    }
    //设置下单人
    public function set_order_user($rowid,$rowid_user){
        $data = array(
            //'tms=tms',
            'fk_order_user'=>$rowid_user,
        );
        $this->db->set('tms', 'tms', FALSE);//不更新时间
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_facture', $data);
    }
    //设置收款人
    public function set_receipt_user($rowid,$rowid_user){
        $data = array(
            'fk_receipt_user'=>$rowid_user,
        );
        $this->db->set('tms', 'tms', FALSE);//不更新时间
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_facture', $data);
    }
    //设置佣金结算状态
    public function set_commission_statut($rowid,$commission_statut){
        $data = array(
            'commission_statut'=>$commission_statut,
        );
        $this->db->set('tms', 'tms', FALSE);//不更新时间
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_facture', $data);
    }

    //生成csv文件
    public function generate_csv($rowid){
        $dir="documents/facture_csv/";
        $file = fopen($dir.$rowid.".csv", "w") or die("Unable to open file!");
        $facturedet=$this->get_facturedet_by_rowid($rowid);
        $txt='"ref","label","description","ean","ean producto","Tipo de Acabado","pack","Unds caja","Unds caja grande","total_ttc",';
        $txt.="\n";
        foreach ($facturedet as $value){
            $txt.='"'.$value["ref"].'",';
            $txt.='"'.$value["label"].'",';
            $txt.='"'.$value["description"].'",';
            $txt.='"'.$value["ean"].'",';
            $txt.='"'.$value["eanproduct"].'",';
            $txt.='"'.$value["tipoacabado"].'",';
            $txt.='"'.$value["pack"].'",';
            $txt.='"'.$value["undscaja"].'",';
            $txt.='"'.$value["undscajagrande"].'",';
            $txt.='"'.$value["total_ttc"].'",';

            $txt.="\n";
        }
        fwrite($file,chr(0xEF).chr(0xBB).chr(0xBF));//输出BOM头。不加这个输出中文会乱码
        fwrite($file, $txt);
        fclose($file);
        $file = $dir.$rowid.".csv";
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);

        /*
        $txt.="江主席一来，\n";
        $txt.="天气晴朗";
        fwrite($file, $txt);
        fclose($file);
        */

    }

    //超期天数的佣金比例
    public function get_delay_time_ratio_commission(){
        $this->db->select("c.label, dtrc.rowid, dtrc.fk_categorie, dtrc.delay_time, dtrc.ratio_commission, dtrc.description");
        $this->db->from("llx_delay_time_ratio_commission dtrc, llx_categorie c");
        $this->db->where("c.rowid=dtrc.fk_categorie");
        $this->db->order_by("c.rowid");
        $this->db->order_by("dtrc.delay_time");
        $query=$this->db->get();
        return $query->result_array();
    }
    //添加超期天数
    public function add_delay_time_ratio_commission($fk_categorie,$delay_time,$ratio_commission){
        $data = array(
            'ratio_commission'=>$ratio_commission,
            'fk_categorie'=>$fk_categorie,
            'delay_time'=>$delay_time,
        );
        $this->db->insert('llx_delay_time_ratio_commission', $data);
    }
    //设置超期天数和佣金比例
    public function set_delay_time_ratio_commission($rowid,$delay_time,$ratio_commission){
        $data = array(
            'ratio_commission'=>$ratio_commission,
            'delay_time'=>$delay_time
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_delay_time_ratio_commission', $data);
    }
    //通过超期时间获得扣除佣金比例 //return=1时，返回佣金比例；否则返回超期天数范围;
    //如果设置了最高折扣，则筛选低于最高折扣的佣金比例
    public function get_delay_time_ratio_commission_by_delay($fk_categorie,$delay,$return){
        $this->db->select("dtrc.delay_time, dtrc.ratio_commission, dtrc.description");
        $this->db->from("llx_delay_time_ratio_commission dtrc");
        if($delay>=0){ //如果超期天数不是负数，则选择，如果是负数，则选排列里最底那个 order_by
            $this->db->where("delay_time >=", $delay);
        }
        $this->db->where("fk_categorie",$fk_categorie);
        $this->db->order_by("delay_time", "desc");
        $query=$this->db->get();
        if($query->result_array()!=null) {
            foreach ($query->result_array() as $value) {}
            if($return==1) {
                return $value['ratio_commission'];
            }
            else{
                return $value['delay_time'];
            }
        }
        else { //如果是null说明超期天数是负数，所以我们选最底的那个
            /*$this->db->select("dtrc.delay_time, dtrc.ratio_commission, dtrc.description");
            $this->db->from("llx_delay_time_ratio_commission dtrc");
            $this->db->where("fk_categorie",$fk_categorie);
            $this->db->order_by("delay_time", "desc");
            $query=$this->db->get();
            if($query->result_array()!=null) {
                foreach ($query->result_array() as $value) {}
                if($return==1) {
                    return $value['ratio_commission'];
                }
                else{
                    return $value['delay_time'];
                }
            }
            else{ //如果还是null说明没有设置
                return 0;
            }*/
            return 0;
        }
    }
    public function delete_delay_time_ratio_commission($rowid){
        $this->db->delete('llx_delay_time_ratio_commission',array('rowid'=>$rowid));
    }
    //获得业务员列表
    public function get_user($rowid=null){
        $this->db->select("rowid, lastname, firstname");
        $this->db->from("llx_user");
        if($rowid!=null){
            $this->db->where("rowid",$rowid);
        }
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得指定业务员指定日期内的发票
    public function get_factures_by_user_time($user_rowid,$start_time,$end_time,$commission_statut,$start_time_datec=null,$end_time_detec=null){
        $this->db->select("f.rowid, f.facnumber, f.fk_statut, f.datec, f.datef, f.date_lim_reglement, f.tms, DATEDIFF(tms,date_lim_reglement) as delay_time, commission_statut");//date_lim_reglement是付款日期 //tms是最好一次修改日期 //delay_time 是超期天数(最后修改日期减去说好的付款日期)
        $this->db->from("llx_facture f, llx_societe_commerciaux sc");
        //暂时用的是最后一次修改的日期作为结算日期
        $this->db->where('f.tms >=',$start_time);
        $this->db->where('f.tms <=',$end_time);
        //下面用的是正确的结算日期
        //$this->db->where('f.date_pay >=',$start_time);
        //$this->db->where('f.date_pay <=',$end_time);
        if($start_time_datec!=null&&$end_time_detec!=null){
            $this->db->where('f.datec >=',$start_time_datec);
            $this->db->where('f.datec <=',$end_time_detec);
        }
        $this->db->where("sc.fk_soc=f.fk_soc");
        $this->db->where("sc.fk_user",$user_rowid);
        $this->db->where("(f.fk_statut=2 or f.fk_statut=3)");//是已付款或已废弃发票  //不加distinct为什么会重复？=>or语句一定要加括号
        if($commission_statut==0){//导出未结算的发票
            $this->db->where("f.commission_statut=0");//是未结算的发票
        }
        else if($commission_statut==1){//导出已结算的发票
            $this->db->where("f.commission_statut=1");//是已结算的发票
        }
        $this->db->order_by("f.facnumber");
        $query=$this->db->get();
        //return $query->result_array();

        $factures=$query->result_array();
        //给每个facture添加发票里面的数组元素(facturedet)
        foreach($factures as &$value){ //注意这里加了一个&符号，就是可以改变值
            //$value['delay']=get_delay_time_ratio_commission_by_delay($fk_categorie,$value['delay_time'],$return);
            $value['facturedet']=$this->get_facturedet_by_facture_rowid($value['rowid'],$value['delay_time']);
            //$value["rowid"]=123;
        }
        return $factures;
    }

    //导出佣金
    public function export_commission($user,$start_time,$end_time,$factures){
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        //require_once '../Build/PHPExcel.phar';


        // Create new PHPExcel object
        //echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        $objPHPExcel = new PHPExcel();

        // Set document properties
        //echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        // Add some data
        //echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);//设置宽度

        $commission_total=0;
        $value=null;
        foreach($user as $value);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $value['lastname']." ".$value['firstname'])
            ->setCellValue('B1', $start_time)
            ->setCellValue('C1', $end_time)
        ;
        $i=3;
        foreach ($factures as $un_facture){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "发票编号: ".$un_facture['facnumber'])
            ;
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "创建时间: ".$un_facture['datef'])
            ;
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "预计收款时间: ".$un_facture['date_lim_reglement'])
            ;
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "实际收款时间: ".$un_facture['tms'])
            ;
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "收款天数: ".$un_facture['delay_time'])
            ;
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "条形码")
                ->setCellValue('B'.$i, "产品名字")
                ->setCellValue('C'.$i, "大标签")
                ->setCellValue('D'.$i, "价格")
                ->setCellValue('E'.$i, "销量")
                ->setCellValue('F'.$i, "折扣")
                ->setCellValue('G'.$i, "超出折扣/2")
                ->setCellValue('H'.$i, "税前价格")
                ->setCellValue('I'.$i, "税后价格")
                ->setCellValue('J'.$i, "佣金比例")
                ->setCellValue('K'.$i, "佣金")
            ;
            $commission_un_facture=0;
            foreach($un_facture['facturedet'] as $facturedet){
                $commission=$facturedet['ratio_commission']*$facturedet['total_ttc'];
                $commission_un_facture=$commission_un_facture+$commission;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $facturedet['barcode'])
                    ->setCellValue('B'.$i, $facturedet['label'])
                    ->setCellValue('C'.$i, $facturedet['categorie_label'])
                    ->setCellValue('D'.$i, number_format($facturedet['subprice'],2))
                    ->setCellValue('E'.$i, $facturedet['qty'])
                    ->setCellValue('F'.$i, $facturedet['remise_percent'])
                    ->setCellValue('G'.$i, $facturedet['reduce_ratio_commission']*100)
                    ->setCellValue('H'.$i, number_format($facturedet['total_ht'],3))
                    ->setCellValue('I'.$i, number_format($facturedet['total_ttc'],3))
                    ->setCellValue('J'.$i, $facturedet['ratio_commission']*100)
                    ->setCellValue('K'.$i, $commission)
                ;
                $i+=1;
            }
            $i+=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, "该发票佣金: ".$commission_un_facture);
            $commission_total=$commission_total+$commission_un_facture;//计算总佣金
            $i+=3;
        }
        $i+=2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, "佣金总计: ")
            ->setCellValue('B'.$i, $commission_total);
        ;
        /*$products=$this->get_all_products_with_all_info();

        $i=2;
        foreach ($products as $value){
            //$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(120);//设置高度

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$i, $value['ref'])
                ->setCellValue('C'.$i, $value['label'])
                ->setCellValue('E'.$i, $value['barcode'])
                ->setCellValue('F'.$i, $value['price'])
                ->setCellValue('G'.$i, $value['cost_price'])
                ->setCellValue('H'.$i, $value['cajaembajale'])
                ->setCellValue('M'.$i, $value['forma_de_presentacion'])
                ->setCellValue('N'.$i, $value['material'])
                ->setCellValue('O'.$i, $value['costeembalajepack'])
                ->setCellValue('P'.$i, $value['color'])
                ->setCellValue('Q'.$i, $value['propiedad'])
                ->setCellValue('R'.$i, $value['efecto'])
                ->setCellValue('S'.$i, $value['tipoacabado'])
                ->setCellValue('T'.$i, $value['note'])
            ;
            $i=$i+1;
        }*/


        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        //echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $dir='documents/excel/'.$_SESSION['rowid'];
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        $objWriter->save($dir.'/commission.xlsx');
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

        /*
        // Save Excel5 file
        //echo date('H:i:s') , " Write to Excel5 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(str_replace('.php', '.xls', __FILE__));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        */
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


        // Echo memory peak usage
        //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

        // Echo done
        //echo date('H:i:s') , " Done writing files" , EOL;
        //echo 'Files have been created in ' , getcwd() , EOL;
    }
    //获得所有父类标签
    public function get_all_main_categ(){
        $this->db->select('rowid,label');
        $this->db->where('type', 0);
        $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        return $query->result_array();
    }

    //显示用户消费报表 -- 统计所有用户的消费金额
    public function get_client_consume_by_date($start_time=null, $end_time=null){
        if($start_time==NULL){
            $start_time=$this->input->post('start_time');
            $end_time=$this->input->post('end_time');
        }

        $this->db->select('sum(f.total_ttc) as total_ttc, count(f.total_ttc) as count_number,
                           s.nom as soc_nom, cd.nom departement_nom, u.lastname, u.firstname, s.rowid soc_rowid,
                           s.lat, s.lng,
                           ');
        $this->db->from('llx_facture f, llx_societe s');
        $this->db->where('f.fk_soc=s.rowid');
        $this->db->join("llx_c_departements cd","cd.rowid=s.fk_departement","left");//城市
        $this->db->join('llx_societe_commerciaux sc','sc.fk_soc=s.rowid','left');//销售代表
        $this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
        $this->db->where('f.date_valid >=',$start_time);
        $this->db->where('f.date_valid <=',$end_time);
        $this->db->where('f.fk_statut<>0');
        $this->db->where('f.fk_statut<>3');

        $this->db->group_by("s.rowid");//这个语句可能会引发问题
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
        $this->export_client_consume($resultat);

        return $resultat;
    }


    //导出用户消费报表
    public function export_client_consume($result){
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        //require_once '../Build/PHPExcel.phar';


        // Create new PHPExcel object
        //echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        $objPHPExcel = new PHPExcel();

        // Set document properties
        //echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        // Add some data
        //echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);//设置宽度


        //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);//设置宽度
        //$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);//设置宽度


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "客户")
            ->setCellValue('B1', "总单数")
            ->setCellValue('C1', "总金额")
            ->setCellValue('D1', "城市")
            ->setCellValue('E1', "销售代表")
        ;
        $i=2;
        foreach ($result as $value){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $value['soc_nom'])
                ->setCellValue('B'.$i, $value['count_number'])
                ->setCellValue('C'.$i, str_replace( ',', '', number_format($value['total_ttc'],3) ))//去掉逗号
                ->setCellValue('D'.$i, $value['departement_nom'])
                ->setCellValue('E'.$i, $value['lastname']." ".$value['firstname'])
            ;
            $i+=1;
        }


        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        //echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $dir='documents/excel/'.$_SESSION['rowid'];
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        $objWriter->save($dir.'/client_consume.xlsx');
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

        /*
        // Save Excel5 file
        //echo date('H:i:s') , " Write to Excel5 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(str_replace('.php', '.xls', __FILE__));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        */
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


        // Echo memory peak usage
        //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

        // Echo done
        //echo date('H:i:s') , " Done writing files" , EOL;
        //echo 'Files have been created in ' , getcwd() , EOL;
    }

    //获得该产品已选择的父类categorie或子类categorie //导出产品销售使用
    public function get_product_categ($fk_product,$type){
        //type=0 => 导出父类   type=1 => 导出子类
        $this->db->select('c.label');
        $this->db->from('llx_categorie c, llx_categorie_product cp');
        $this->db->where('c.rowid=cp.fk_categorie');
        $this->db->where('cp.fk_product',$fk_product);
        if($type==0) {
            $this->db->where('c.fk_parent=0');
        }
        else{
            $this->db->where('c.fk_parent<>0');
        }
        $query=$this->db->get();
        $resultat=$query->result_array();
        if($resultat==NULL){
            return NULL;
        }
        foreach ($resultat as $value){
        }
        return $value['label'];
    }

    //获得产品销售 -- 统计所有产品的销售状况
    public function get_product_sales_by_date(){
        $start_time=$this->input->post('start_time');
        $end_time=$this->input->post('end_time');
        $qty_type=$this->input->post('qty_type');//按照发票中的产品数量来计数还是按照库存转移中的数量来计数
        $resultat=array();

        if($qty_type==1) {
            $this->db->select('sum(fd.qty) as total_qty, p.rowid, p.ref, p.barcode, p.stock, p.pmp, p.price_ttc,
                           ');
            $this->db->from('llx_facture f, llx_facturedet fd, llx_product p');
            $this->db->where('f.rowid=fd.fk_facture');
            $this->db->where('p.rowid=fd.fk_product');
            //$this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
            $this->db->where('f.datef >=', $start_time);
            $this->db->where('f.datef <=', $end_time);
            $this->db->where('f.fk_statut<>0');
            $this->db->where('f.fk_statut<>3');
        }
        if($qty_type==2){
            $this->db->select('sum(abs(sm.value)) as total_qty, p.rowid, p.ref, p.barcode, p.stock, p.pmp, p.price_ttc,'); //这里我们把负数变为正数
            $this->db->from('llx_stock_mouvement sm, llx_product p');
            $this->db->where('p.rowid=sm.fk_product');
            $this->db->where('sm.tms >=',$start_time);
            $this->db->where('sm.tms <=',$end_time);
            $this->db->where('sm.type_mouvement=2');//是接收订单的
        }

        $this->db->group_by("p.rowid");//这个语句可能会引发问题
        $this->db->order_by("total_qty", "DESC");
        $query=$this->db->get();

        $resultat=$query->result_array();
        //获得标签
        foreach($resultat as &$value){
            $value['main_categ']=$this->get_product_categ($value['rowid'],0);
            $value['sous_categ']=$this->get_product_categ($value['rowid'],1);
            if($qty_type==1) {
                $value['total_qty_buy'] = $this->get_product_buy_qty_by_date($start_time, $end_time, $value['rowid']);
            }
            if($qty_type==2){
                $value['total_qty_buy'] = $this->get_product_buy_qty_by_stock_mouvement_by_date($start_time, $end_time, $value['rowid']);
            }
        }
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
        $this->export_product_sales($resultat);

        return $resultat;
    }
    //获得单个产品的采购数量 (从供货商发票)
    public function get_product_buy_qty_by_date($start_time,$end_time,$fk_product){
        $this->db->select('sum(ffd.qty) as total_qty');
        $this->db->from('llx_facture_fourn ff, llx_facture_fourn_det ffd');
        $this->db->where('ff.rowid=ffd.fk_facture_fourn');
        $this->db->where('ffd.fk_product',$fk_product);
        $this->db->where('ff.datef >=',$start_time);
        $this->db->where('ff.datef <=',$end_time);
        $this->db->where('ff.fk_statut<>0');
        $this->db->where('ff.fk_statut<>3');
        $this->db->group_by("ffd.fk_product");
        $query=$this->db->get();
        $resultat=$query->result_array();
        if($resultat==NULL){
            return NULL;
        }
        foreach($resultat as $value){
        }
        return $value['total_qty'];
    }
    //获得单个产品的采购数量(按照库存转移)
    public function get_product_buy_qty_by_stock_mouvement_by_date($start_time,$end_time,$fk_product){
        $this->db->select('sum(sm.value) as total_qty');
        $this->db->from('llx_stock_mouvement sm');
        $this->db->where('sm.fk_product',$fk_product);
        $this->db->where('sm.tms >=',$start_time);
        $this->db->where('sm.tms <=',$end_time);
        $this->db->where('sm.type_mouvement=3');//是接收订单的
        $this->db->group_by("sm.fk_product");
        $query=$this->db->get();
        $resultat=$query->result_array();
        if($resultat==NULL){
            return NULL;
        }
        return $resultat[0]['total_qty'];
    }


    //导出用户消费报表
    public function export_product_sales($result){
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        //require_once '../Build/PHPExcel.phar';


        // Create new PHPExcel object
        //echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        $objPHPExcel = new PHPExcel();

        // Set document properties
        //echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        // Add some data
        //echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);//设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);//设置宽度

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "REF")
            ->setCellValue('B1', "Barcode")
            ->setCellValue('C1', "品类")
            ->setCellValue('D1', "小品类")
            ->setCellValue('E1', "销售数量")
            ->setCellValue('F1', "现有库存")
            ->setCellValue('G1', "现有库存价值")
            ->setCellValue('H1', "采购数量")
            ->setCellValue('I1', "PMP")
            ->setCellValue('J1', "销售价")
        ;
        $i=2;
        foreach ($result as $value){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $value['ref'])
                ->setCellValue('B'.$i, $value['barcode'])
                ->setCellValue('C'.$i, $value['main_categ'])
                ->setCellValue('D'.$i, $value['sous_categ'])
                ->setCellValue('E'.$i, $value['total_qty'])
                ->setCellValue('F'.$i, $value['stock'])
                ->setCellValue('G'.$i, str_replace( ',', '', number_format(($value['pmp']*$value['stock']),2) ))//去掉逗号
                ->setCellValue('H'.$i, $value['total_qty_buy'])
                ->setCellValue('I'.$i, number_format($value['pmp'],2))
                ->setCellValue('J'.$i, number_format($value['price_ttc'],2))
            ;
            $i+=1;
        }


        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        //echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $dir='documents/excel/'.$_SESSION['rowid'];
        if(!file_exists ( $dir )){
            mkdir($dir, 0777, true);
        }
        $objWriter->save($dir.'/product_sales.xlsx');
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

        /*
        // Save Excel5 file
        //echo date('H:i:s') , " Write to Excel5 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(str_replace('.php', '.xls', __FILE__));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        */
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


        // Echo memory peak usage
        //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

        // Echo done
        //echo date('H:i:s') , " Done writing files" , EOL;
        //echo 'Files have been created in ' , getcwd() , EOL;
    }


    //获得给定时间内的发票总金额
    public function get_sum_amount_by_date($start_time=null,$end_time=null){
        $this->db->select('COALESCE(sum(total_ttc),0) as sum_amount');
        $this->db->from('llx_facture f');
        $this->db->where('f.date_valid >=',$start_time);
        $this->db->where('f.date_valid <=',$end_time);
        $this->db->where('f.fk_statut<>0');
        $this->db->where('f.fk_statut<>3');
        $query=$this->db->get();
        $resultat=$query->result_array();
        //echo "<h5>ss</h5>";
        //echo "<h5>ss</h5>";
        //print_r($resultat);
        return number_format($resultat[0]['sum_amount'],2,'.','');//没有逗号隔开千位
    }
    //获得区间内发票总金额
    public function get_sum_amount_by_date_duration($interval=null,$duration=null, $end_time=null){
        if($interval==null) {
            $duration = $this->input->post('duration');
            $end_time = $this->input->post('end_time');
            $interval=$this->input->post('interval');
        }
        if($interval==0){
            $interval="day";
        }else if($interval==1){
            $interval="week";
        }else if($interval==2){
            $interval="month";
        }else if($interval==3){
            $interval="year";
        }
        //用于查看时间信息
        //echo "<h5>time_info</h5>";
        //echo "<br>".$end_time."<br>";
        $start_time=date('Y-m-d',strtotime("-".$duration.$interval,strtotime($end_time)));
        //echo "<br>".$start_time."<br>";

        $result=array();
        for($times=0;$times<$duration;$times++){
            /*$start_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));
            $result[$times]=$start_time."--".$end_time.$this->get_sum_amount_by_date($start_time,$end_time);
            $end_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));*/
            $end_time=date('Y-m-d',strtotime("+1".$interval,strtotime($start_time)));
            $result[$times]=$this->get_sum_amount_by_date($start_time,$end_time);
            $start_time=date('Y-m-d',strtotime("+1".$interval,strtotime($start_time)));
        }

        return $result;

    }

    public function test($array){
        echo $array;
    }

}