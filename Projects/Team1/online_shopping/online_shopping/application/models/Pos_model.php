<?php

//这里每次提取银行余额都要计算一次，数据量大的时候会很慢，但是目前系统是这样，以后得给银行增加一个余额条目, 这个很重要
class Pos_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    //订单的信息会在添加/删除产品的时候会进行加/减计算
    //订单在每次进入的时候会进行一次校对
    //检查pos账号
    public function verifie()
    {
        /*$query = $this->db->get_where('llx_user', array(
                'login' => $this->input->post('account'),
                'pass_crypted'=>hash('md5',$this->input->post('password')),
            )
        );
        return $query->result_array();*/
        $this->db->select("u.rowid rowid, u.lastname, u.firstname,
                           pc.rowid pos_rowid,
                           pc.fk_paycash, pc.fk_paybank, pc.fk_warehouse, pc.fk_soc, pc.is_used,
                           pcuse.rowid pcuse");
        $this->db->from("llx_user u,llx_pos_cash pc");
        $this->db->join("llx_pos_cash pcuse","pcuse.fk_user_u=u.rowid","left");//为了验证该用户是否在使用机器
        $this->db->where('u.login',$this->input->post('account'));
        $this->db->where('u.pass_crypted',hash('md5',$this->input->post('password')));
        $this->db->where("pc.rowid",$this->input->post("terminal"));
        $query=$this->db->get();
        $result=$query->result_array();
        if($result==null){
            return -2;//错误代码，没有找到该用户
        }
        foreach($result as $value){
        }
        if($value["pcuse"]!=null){
            return -3;//错误代码，该用户正在使用其他机器
        }
        if($value["is_used"]==1){
            return -1;//错误代码，正在被使用
        }
        $data = array(
            'is_used' =>1,
            'fk_user_u'=>$value['rowid'],//这个时候还没有更新session
        );
        $this->db->where('rowid', $value['pos_rowid']);//这个时候还没有更新session
        $this->db->update('llx_pos_cash', $data);
        return $result;

        /*
        if($this->input->post('account')=='az5284'&&$this->input->post('password')=='123456'){
            return 'TRUE';
        }
        else return 'FALSE';
        */
    }
    public function log_out(){
        $_SESSION['pos_logged_in']=null;
        $data = array(
            'is_used' =>0,
            'fk_user_u'=>0,
        );
        $this->db->where('rowid', $_SESSION['rowid_pos']);
        $this->db->update('llx_pos_cash', $data);
    }
    //计算pos账号总数
    public function count_pos_cashes(){
        $query = $this->db->query('SELECT rowid FROM llx_pos_cash');
        return $query->num_rows();
    }
    //获得全部pos机分页
    public function fetch_pos_cash($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("pc.rowid, pc.name, pc.fk_paycash, pc.fk_paybank, pc.fk_warehouse, pc.fk_soc, pc.fk_user_u, pc.is_closed,pc.is_used,
                            u.lastname,
                            ba_cash.rowid cash_account_rowid, ba_cash.ref cash_account_ref, ba_cash.label cash_account_label,
                            ba_bank.rowid bank_account_rowid, ba_bank.ref bank_account_ref, ba_bank.label bank_account_label,
                            e.rowid warehouse_rowid, e.label entrepot_label,
                            s.rowid soc_rowid, s.nom nom_soc,
                           ");
        $this->db->from("llx_pos_cash pc, llx_bank_account ba_cash, llx_bank_account ba_bank, llx_entrepot e, llx_societe s");
        $this->db->join("llx_user u","pc.fk_user_u=u.rowid","left");
        $this->db->where("pc.fk_paycash=ba_cash.rowid");
        $this->db->where("pc.fk_paybank=ba_bank.rowid");
        $this->db->where("pc.fk_warehouse=e.rowid");
        $this->db->where("pc.fk_soc=s.rowid");

        $this->db->order_by("pc.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }
    //获得全部POS机
    public function get_pos_cash(){
        $this->db->select("pc.rowid, pc.name");
        $this->db->from("llx_pos_cash pc");
        $query=$this->db->get();
        return $query->result_array();
    }
    //创建POS账号
    public function create_pos_cash(){
        $tms=date("Y-m-d h:i::sa");
        $entity=1;
        $code="TPV";
        $name=$this->input->post('ref');
        $tactil=1;
        $barcode=1;
        $fk_paycash=$this->input->post('account_cash');
        $fk_modepaycash=4;
        $fk_paybank=$this->input->post('account_bank');
        $fk_modepaybank=6;
        $fk_modepaybank_extra=-1;
        $fk_paybank_extra=1;
        $fk_warehouse=$this->input->post('warehouse');
        $printer_name="";
        $fk_soc=$this->input->post('client');
        $is_used=0;
        $fk_user_u=0;
        $fk_user_c=$_SESSION['rowid'];
        $fk_user_m=$_SESSION['rowid'];
        $datec=$tms;
        $datea=$tms;
        $is_closed=0;
        $data = array(
            'entity' => $entity,
            'code' => $code,
            'name'=>$name,
            'tactil'=>$tactil,
            "barcode"=>$barcode,
            "fk_paycash"=>$fk_paycash,
            "fk_modepaycash"=>$fk_modepaycash,
            "fk_paybank"=>$fk_paybank,
            "fk_modepaybank"=>$fk_modepaybank,
            "fk_modepaybank_extra"=>$fk_modepaybank_extra,
            "fk_paybank_extra"=>$fk_paybank_extra,
            "fk_warehouse"=>$fk_warehouse,
            "printer_name"=>$printer_name,
            "fk_soc"=>$fk_soc,
            "is_used"=>$is_used,
            "fk_user_u"=>$fk_user_u,
            "fk_user_c"=>$fk_user_c,
            "fk_user_m"=>$fk_user_m,
            "datec"=>$datec,
            "datea"=>$datea,
            "is_closed"=>$is_closed,
        );
        $this->db->insert('llx_pos_cash', $data);
    }
    //让被使用的机器解锁可用
    public function set_cash_free($rowid){
        $data = array(
            'is_used' =>0,
            'fk_user_u' => 0,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_pos_cash', $data);
    }
    //获得正在使用的机器的user id，用于检查该用户是否有权限继续使用
    public function get_user_u(){
        $this->db->select("fk_user_u");
        $this->db->from("llx_pos_cash");
        $this->db->where("rowid",$_SESSION['rowid_pos']);
        $query=$this->db->get();
        foreach($query->result_array() as $value){
        }
        return $value["fk_user_u"];
    }
    //设置POS机账号
    public function set_pos_cash($rowid,$name,$fk_paycash,$fk_paybank,$fk_warehouse,$fk_soc){
    }
    //计算现金账户余额
    public function calculate_balance($fk_account){
        //SELECT sum(amount) FROM `llx_bank` WHERE fk_account=2
        $this->db->select("sum(amount) balance");
        $this->db->from("llx_bank");
        $this->db->where("fk_account",$fk_account);
        $query=$this->db->get();
        foreach($query->result_array() as $value){
        }
        return $value["balance"];
    }
    //arching //员工中间离开
    public function arching_pos($amount_real){
        //添加新的arching，自动生成订单ref号
        $this->db->limit(1);
        $this->db->select("ref");
        $this->db->from("llx_pos_control_cash");
        $this->db->where("type_control=0");
        $this->db->order_by("rowid", "DESC");
        $query = $this->db->get();
        if($query->result_array()!=null) {
            foreach ($query->result_array() as $sum) ;
            //echo $sum["ref"];
            $num = substr($sum['ref'], 7);
            $num_ref = $num + 1;
        }
        else {
            $num_ref = 1;
        }
        $num_ref=sprintf("%04d", $num_ref);
        $y=sprintf("%02d", substr(date("Y"), 2));//生成4位数，不足前面补0
        $m=sprintf("%02d", date("m"));
        $tms=date("Y-m-d h:i::sa");
        //echo "yymm--".$y.$m."<br>";
        $ref = "AR".$y.$m . "-".$num_ref;
        echo $ref;

        $amount_teor=$this->calculate_balance($_SESSION['fk_paycash']);//该账户记录的余额
        $amount_diff=$amount_real-$amount_teor;
        $data=array(
            'ref'=>$ref,
            'entity'=>1,
            'fk_cash'=>$_SESSION['rowid_pos'],
            'fk_user'=>$_SESSION['rowid'],
            'date_c'=>$tms,
            'type_control'=>0,
            'amount_teor'=>$amount_teor, //该账户记录的余额
            'amount_real'=>$amount_real,//真实余额
            'amount_diff'=>$amount_diff,
            'amount_mov_out'=>NULL,
            'amount_mov_int'=>NULL,
            'comment'=>NULL,
        );
        $this->db->insert('llx_pos_control_cash', $data);
        //$id = $this->db->insert_id();
    }

    //关闭钱箱 --清点
    public function close_pos($amount_real){
        //添加新的arching，自动生成订单ref号
        $this->db->limit(1);
        $this->db->select("ref");
        $this->db->from("llx_pos_control_cash");
        $this->db->where("type_control=1");
        $this->db->order_by("rowid", "DESC");
        $query = $this->db->get();
        if($query->result_array()!=null) {
            foreach ($query->result_array() as $sum) ;
            //echo $sum["ref"];
            $num = substr($sum['ref'], 7);
            $num_ref = $num + 1;
        }
        else {
            $num_ref = 1;
        }
        $num_ref=sprintf("%04d", $num_ref);
        $y=sprintf("%02d", substr(date("Y"), 2));//生成4位数，不足前面补0
        $m=sprintf("%02d", date("m"));
        $tms=date("Y-m-d h:i::sa");
        //echo "yymm--".$y.$m."<br>";
        $ref = "CC".$y.$m . "-".$num_ref;
        echo $ref;

        $amount_teor=$this->calculate_balance($_SESSION['fk_paycash']);//该账户记录的余额
        $amount_diff=$amount_real-$amount_teor;
        $data=array(
            'ref'=>$ref,
            'entity'=>1,
            'fk_cash'=>$_SESSION['rowid_pos'],
            'fk_user'=>$_SESSION['rowid'],
            'date_c'=>$tms,
            'type_control'=>1,
            'amount_teor'=>$amount_teor, //该账户记录的余额
            'amount_real'=>$amount_real,//真实余额
            'amount_diff'=>$amount_diff,
            'amount_mov_out'=>NULL,
            'amount_mov_int'=>NULL,
            'comment'=>NULL,
        );
        $this->db->insert('llx_pos_control_cash', $data);
    }



    //获得该用户最新的订单
    public function get_latest_commande(){
        $this->db->select("p.rowid");
        $this->db->from("llx_pos p");
        $this->db->where("p.fk_user_author",$_SESSION['rowid']);
        $this->db->order_by("p.rowid","asc");
        $query=$this->db->get();
        if($query->result_array()==null){
            return 0;
        }
        else {
            foreach ($query->result_array() as $value) {}
            return $value['rowid'];
        }
    }

    //计算订单总数
    public function count_commandes(){
        $query = $this->db->query('SELECT rowid FROM llx_pos');
        return $query->num_rows();
    }
    public function fetch_commande($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("c.rowid rowid, c.ref, s.nom nom_soc, s.town, c.date_commande, c.date_livraison, c.total_ht, c.fk_statut
                           ");
        $this->db->from("llx_pos c, llx_user u, llx_company comp");
        $this->db->where("u.fk_company = comp.rowid");
        $this->db->where("comp.rowid",$_SESSION['company_id']);
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
        $this->db->from("llx_pos c");
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
        $this->db->select("c.rowid rowid, c.ref ref, c.fk_soc, c.fk_statut, c.tva, c.total_ht, c.total_ttc, c.total_buy_price
                           ");
        $this->db->from("llx_pos c");
        //$this->db->join("llx_societe so","so.rowid=s.fk_soc","left");
        $this->db->where('c.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //新建缓存订单
    public function create_commande()
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        //添加新的订单，自动生成订单ref号, 草稿的情况
        $this->db->select("ref");
        $this->db->from("llx_pos");
        $this->db->order_by("rowid", "asc");
        $query = $this->db->get();
        foreach ($query->result_array() as $sum) ;
        $num = substr($sum['ref'], 5);
        $num_ref = $num + 1;
        $ref = "(PROV" . $num_ref;
        $ref=$ref.")";
        //echo $ref;

        $data=array(
            'ref'=>$ref,
            //'ref_supplier'=>$this->input->post('ref_supplier'),
            'fk_soc'=>$_SESSION['fk_soc'],
            'fk_multicurrency'=>1,
            'multicurrency_code'=>'EUR',
            'fk_projet'=>NULL,
            'fk_user_author'=>$_SESSION['rowid'],

            //没弄懂是做什么的
            //'source'=>0,
            //'billed'=>0,
            //'note_public'=>$this->input->post('note_public'),
            //'note_private'=>$this->input->post('note_private'),
            'model_pdf'=>'muscadet',
            //'date_livraison'=>$this->input->post('date_livraison'),//运输日期
            //'fk_cond_reglement'=>$this->input->post('cond_reglement'),
            //'fk_mode_reglement'=>$this->input->post('mode_reglement'),
            'fk_incoterms'=>0,
        );

        $this->db->insert('llx_pos', $data);
        $id = $this->db->insert_id();

        return $id;//返回新创建的订单id
    }

    //获得订单里的所有对象列表
    public function get_list_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.price, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.buy_price_ht,
                           p.rowid fk_product, p.barcode, p.ref ref, p.label label, p.cost_price");
        $this->db->from("llx_posdet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->where("c.fk_commande",$rowid);
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得订单该产品的rowid，如果存在的话  为了之后如果有相同的就在原来基础上+1
    public function get_commandedet_by_fk_product($rowid_commande,$fk_product){
        $this->db->select("c.rowid, fk_product");
        $this->db->from("llx_posdet c,llx_product p");
        $this->db->where("p.rowid=c.fk_product");
        $this->db->where("c.fk_commande",$rowid_commande);
        $this->db->where("c.fk_product",$fk_product);
        $this->db->order_by("c.rowid", "desc");
        $query=$this->db->get();
        $info_commandedet=$query->result_array();
        if($info_commandedet ==NULL){
            return -1;
        }
        foreach ($info_commandedet as $value){
        }
        return $value['rowid'];

    }

    //获得订单里的单个对象
    public function get_commandedet($rowid){
        $this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.price, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.buy_price_ht,
                           p.barcode, p.ref ref, p.label label, p.cost_price");
        $this->db->from("llx_posdet c");
        $this->db->join("llx_product p","p.rowid=c.fk_product","left");
        $this->db->where("c.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //增加订单的对象
    public function add_commandedet($fk_commande,$fk_product,$tva_tx,$qty,$price,$subprice,$buy_price_ht,$total_ht_all,$total_ttc_all,$total_buy_price,$unit=0){
        $total_ht=$subprice*$qty;
        $total_ttc=$price*$qty;
        $total_tva=$total_ttc-$total_ht;

        $commandedet_rowid=$this->get_commandedet_by_fk_product($fk_commande,$fk_product);
        //如果这个产品本身就在订单里，则增加数量和总价钱
        if($commandedet_rowid!=-1){

            $this->db->set('qty', 'ifnull(qty,0)+'.$qty, FALSE);
            $this->db->set('total_ht', 'ifnull(total_ht,0)+'.$total_ht, FALSE);
            $this->db->set('total_tva', 'ifnull(total_tva,0)+'.$total_tva, FALSE);
            $this->db->set('total_ttc', 'ifnull(total_ttc,0)+'.$total_ttc, FALSE);
            $this->db->set('buy_price_ht', 'ifnull(buy_price_ht,0)+'.$buy_price_ht, FALSE);

            $this->db->set('multicurrency_subprice', 'ifnull(multicurrency_subprice,0)+'.$subprice, FALSE);
            $this->db->set('multicurrency_total_ht', 'ifnull(multicurrency_total_ht,0)+'.$total_ht, FALSE);
            $this->db->set('multicurrency_total_tva', 'ifnull(multicurrency_total_tva,0)+'.$total_tva, FALSE);
            $this->db->set('multicurrency_total_ttc', 'ifnull(multicurrency_total_ttc,0)+'.$total_ttc, FALSE);

            $this->db->where('rowid', $commandedet_rowid);
            $this->db->update('llx_posdet');//更新订单的总价格

            $id=$commandedet_rowid;
        }
        else {
            //如果这个产品本身没有在订单里，则添加新的
            $data = array(
                'fk_commande' => $fk_commande,
                'fk_product' => $fk_product,
                'tva_tx' => $tva_tx,
                'qty' => $qty,
                'unit' => $unit,
                'price' => $price,
                'subprice' => $subprice,
                'total_ht' => $total_ht,
                'total_tva' => $total_tva,
                'total_ttc' => $total_ttc,
                'buy_price_ht' => $buy_price_ht,//这里记的是单个的买价，不是总的买价

                'fk_multicurrency' => 1,//货币
                'multicurrency_code' => "EUR",
                'multicurrency_subprice' => $subprice,
                'multicurrency_total_ht' => $total_ht,
                'multicurrency_total_tva' => $total_tva,
                'multicurrency_total_ttc' => $total_ttc,
            );
            $this->db->insert('llx_posdet', $data);
            $id = $this->db->insert_id();
        }

        //更新订单总信息
        $total_ht_all=$total_ht_all+$total_ht;
        $total_ttc_all=$total_ttc_all+$total_ttc;
        $total_buy_price=$total_buy_price+$buy_price_ht*$qty;
        $tms=date("Y-m-d h:i::sa");
        $tva=$total_ttc_all-$total_ht_all;
        $data = array(
            'tms' =>$tms,
            'total_ht' => $total_ht_all,
            'total_ttc' => $total_ttc_all,
            'tva'=>$tva,
            'total_buy_price'=>$total_buy_price,//成本价
        );
        $this->db->where('rowid', $fk_commande);
        $this->db->update('llx_pos', $data);//更新订单的总价格

        return $id;//返回刚刚添加的订单对象id
    }

    //删除订单里的对象
    public function delete_commandedet($rowid_product,$rowid_commande,$total_ht,$total_ttc,$buy_price_ht,$total_ht_all,$total_ttc_all,$total_buy_price){

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
            'total_buy_price'=>$total_buy_price,

            'fk_multicurrency'=>1,//货币
            'multicurrency_code'=>"EUR",
            'multicurrency_tx'=>1,
            'multicurrency_total_ht'=>$total_ht_all,
            'multicurrency_total_tva'=>$tva,
            'multicurrency_total_ttc'=>$total_ttc_all,
        );
        $this->db->where('rowid', $rowid_commande);
        $this->db->update('llx_pos', $data);//更新订单的总价格

        $this->db->delete('llx_posdet',array('rowid'=>$rowid_product));//删除订单的对象
    }

    //新建已支付发票
    public function create_facture($rowid_commande){
        //添加新的发票，自动生成订单ref号
        $this->db->limit(1);
        $this->db->select("f.facnumber");
        $this->db->from("llx_pos_facture pf, llx_facture f");
        $this->db->where("f.rowid=pf.fk_facture");
        //$this->db->where('fk_statut', 0);
        $this->db->order_by("pf.rowid", "DESC");
        $query = $this->db->get();
        if($query->result_array()!=null) {
            foreach ($query->result_array() as $sum) ;
            echo $sum["facnumber"];
            $num = substr($sum['facnumber'], 7);
            $num_ref = $num + 1;
        }
        else {
            $num_ref = 1;
        }
        $num_ref=sprintf("%04d", $num_ref);
        $y=sprintf("%02d", substr(date("Y"), 2));//生成4位数，不足前面补0
        $m=sprintf("%02d", date("m"));
        $tms=date("Y-m-d h:i::sa");
        //echo "yymm--".$y.$m."<br>";
        $facnumber = "FS".$y.$m . "-".$num_ref;
        echo $facnumber;

        //
        $commande_info=$this->get_commande_by_rowid($rowid_commande);
        foreach($commande_info as $value){
        }
        $fk_soc=$value['fk_soc'];
        $tva=$value['tva'];
        $total=$value['total_ht'];
        $total_ttc=$value['total_ttc'];

        $data=array(
            'facnumber'=>$facnumber,
            'entity'=>1,
            'type'=>0,
            'fk_soc'=>$fk_soc,
            'datec'=>$tms,
            'datef'=>$tms,
            'date_valid'=>$tms,
            'tms'=>$tms,
            'paye'=>1,
            'tva'=>$tva,
            'total'=>$total,
            'total_ttc'=>$total_ttc,
            'fk_statut'=>2,
            'commission_statut'=>0,//是否支付佣金 //这个再议
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_user_valid'=>$_SESSION['rowid'],
            'fk_cond_reglement'=>0,
            'fk_mode_reglement'=>4,
            'date_lim_reglement'=>$tms,

            //货币
            'fk_multicurrency'=>0,
            'multicurrency_code'=>'EUR',
            'multicurrency_tx'=>1,
            'multicurrency_total_ht'=>$total,
            'multicurrency_total_tva'=>$tva,
            'multicurrency_total_ttc'=>$total_ttc,
        );
        $this->db->insert('llx_facture', $data);
        $id=$this->db->insert_id();
        //新建pos发票
        //这里我们暂时默认是1号机器开的发票 fk_cash
        $data=array(
            'fk_cash'=>$_SESSION['rowid_pos'],
            'fk_facture'=>$id,
            'customer_pay'=>$total_ttc,
        );
        $this->db->insert('llx_pos_facture', $data);
        return $id;
    }
    //添加发票元素facturedet
    public function add_facturedet($rowid_commande,$rowid_facture){
        $commandedet=$this->get_list_commandedet($rowid_commande);
        foreach($commandedet as $value) {
            /*$this->db->select("c.rowid rowid, c.tva_tx, c.qty, c.subprice, c.total_ht, c.total_tva, c.total_ttc, c.buy_price_ht,
                               p.barcode, p.ref ref, p.label label, p.cost_price");*/
            //$fk_commande,$fk_product,$tva_tx,$qty,$price,$subprice,$buy_price_ht,$total_ht_all,$total_ttc_all,$total_buy_price
            $price = $value['price'];
            $subprice = $value['subprice'];
            $qty = $value['qty'];
            $tva_tx=$value['tva_tx'];
            $total_ht = $subprice * $qty;
            $total_ttc = $price * $qty;
            $total_tva = $total_ttc - $total_ht;
            $data = array(
                'fk_facture' => $rowid_facture,
                'fk_product' => $value['fk_product'],
                'description'=>$value['label'],
                'tva_tx' => $tva_tx,
                'qty' => $qty,
                'price' => $price,
                'subprice' => $subprice,
                'total_ht' => $total_ht,
                'total_tva' => $total_tva,
                'total_ttc' => $total_ttc,
                'buy_price_ht' => $value['buy_price_ht'],//这里记的是单个的买价，不是总的买价

                'fk_multicurrency' => 1,//货币
                'multicurrency_code' => "EUR",
                'multicurrency_subprice' => $subprice,
                'multicurrency_total_ht' => $total_ht,
                'multicurrency_total_tva' => $total_tva,
                'multicurrency_total_ttc' => $total_ttc,
            );
            $this->db->insert('llx_facturedet', $data);
            //$id = $this->db->insert_id();

            //减少产品总库存
            $this->db->set('stock', 'ifnull(stock,0)-'.$qty, FALSE);//减少库存
            $this->db->where('rowid', $value['fk_product']);
            $this->db->update('llx_product');

            //减少产品仓库库存
            //这里暂时假设用的是仓库2
            $entrepot_rowid=$_SESSION['fk_warehouse'];
            $this->db->set('reel', 'ifnull(reel,0)-'.$qty, FALSE);//如果有的话则在原来的基础上增加库存
            $this->db->where('fk_product', $value['fk_product']);
            $this->db->where('fk_entrepot', $entrepot_rowid);
            $this->db->update('llx_product_stock');

            //运输记录
            //llx_stock_mouvement//移动记录
            $qty=-$qty;//这里是减去库存，数量是负数
            $tms=date("Y-m-d h:i::sa");
            $data = array(
                'tms'=>$tms,
                'datem'=>$tms,
                'fk_product'=>$value['fk_product'],
                'fk_entrepot'=>$entrepot_rowid,
                'value'=>$qty,
                'price'=>$total_ht,
                'type_mouvement'=>3,
                'fk_user_author'=>$_SESSION['rowid'],
                'label'=>"pos卖出产品",
                'fk_origin'=>$rowid_facture,
                'origintype'=>'facture',
            );
            $this->db->insert('llx_stock_mouvement',$data);
        }
        //return $id;//返回刚刚添加的订单对象id

    }
    //现金支付金额
    public function pay_by_cash($amount){
        //echo "现金支付: ".$amount."<br>";
        $fk_account=$_SESSION['fk_paycash'];
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'datec'=>$tms,
            'tms'=>$tms,
            'datev'=>$tms,
            'dateo'=>$tms,
            'amount'=>$amount,
            'label'=>"(CustomerInvoicePayment)",
            'fk_account'=>$fk_account,
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_type'=>'LIQ',
            'emetteur'=>89,
        );
        $this->db->insert('llx_bank', $data);
        return $this->db->insert_id();
    }
    //银行卡支付金额
    public function pay_by_card($amount){
        //echo "银行卡支付: ".$amount."<br>";
        $fk_account=$_SESSION['fk_paybank'];
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'datec'=>$tms,
            'tms'=>$tms,
            'datev'=>$tms,
            'dateo'=>$tms,
            'amount'=>$amount,
            'label'=>"(CustomerInvoicePayment)",
            'fk_account'=>$fk_account,
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_type'=>'CB',
            'emetteur'=>89,
        );
        $this->db->insert('llx_bank', $data);
        return $this->db->insert_id();
    }
    //找零金额
    /*public function change($amount){
        //echo "找零: ".$amount."<br>";
    }*/
    //增加付款记录
    public function add_paiement($rowid_facture,$amount,$fk_paiement,$fk_bank){
        //fk_paiement 现金是6 信用卡是4
        $this->db->select("p.ref");
        $this->db->from("llx_paiement p");
        //$this->db->where('fk_statut', 0);
        $this->db->order_by("p.ref", "asc");
        $query = $this->db->get();
        if($query->result_array()!=null) {
            foreach ($query->result_array() as $sum) ;
            $num = substr($sum['ref'], 8);
            $num_ref = $num + 1;
        }
        else {
            $num_ref = 1;
        }
        $num_ref=sprintf("%04d", $num_ref);
        $y=sprintf("%02d", substr(date("Y"), 2));//生成4位数，不足前面补0
        $m=sprintf("%02d", date("m"));
        $tms=date("Y-m-d h:i::sa");
        //echo "yymm--".$y.$m."<br>";
        $ref = "PAY".$y.$m . "-".$num_ref;
        echo $ref;

        //获得发票号码
        $facnumber=$this->get_facnumber($rowid_facture);

        $data=array(
            'ref'=>$ref,
            'entity'=>1,
            'datec'=>$tms,
            'tms'=>$tms,
            'datep'=>$tms,
            'amount'=>$amount,
            'multicurrency_amount'=>$amount,
            'num_paiement'=>'',
            'fk_paiement'=>$fk_paiement,
            'note'=>'用户付款'.$facnumber,
            'fk_bank'=>$fk_bank,
            'fk_user_creat'=>$_SESSION['rowid'],
        );
        $this->db->insert('llx_paiement', $data);
        $paiement_id=$this->db->insert_id();

        //llx_paiement_facture
        $data=array(
            'fk_paiement'=>$paiement_id,
            'fk_facture'=>$rowid_facture,
            'amount'=>$amount,
            'multicurrency_amount'=>$amount,
        );
        $this->db->insert('llx_paiement_facture', $data);

    }


    //确认支付 创建订单+转移库存
    public function confirm_pay($rowid_commande,$amount_pay_by_cash,$amount_pay_by_card){
        //创建发票 llx_facture
        $rowid_facture=$this->create_facture($rowid_commande);
        //创建llx_facturedet //减少产品库存，增加运输记录也在这个函数里
        $this->add_facturedet($rowid_commande,$rowid_facture);

        //增加现金
        if($amount_pay_by_cash>0) {
            $fk_bank=$this->pay_by_cash($amount_pay_by_cash);
            //添加付款记录
            $this->add_paiement($rowid_facture,$amount_pay_by_cash,6,$fk_bank);

        }
        //增加银行金额
        if($amount_pay_by_card>0) {
            $fk_bank=$this->pay_by_card($amount_pay_by_card);
            //添加付款记录
            $this->add_paiement($rowid_facture,$amount_pay_by_card,4,$fk_bank);

        }
        //找零金额 不可能要找钱 银行卡不用找钱 现金总数不变
        //$this->change($amount_change);

        //创建成功之后删除该订单
        $this->db->delete('llx_posdet',array('fk_commande'=>$rowid_commande));
        $this->db->delete('llx_pos',array('rowid'=>$rowid_commande));

        return $rowid_facture;
    }

    //获得所有产品的条形码
    //之后如果用barcode来搜索产品的信息，效率太低，所以这里要同时读取rowid
    public function get_list_barcodes(){
        $rowid_entrepot=$_SESSION['fk_warehouse'];
        $this->db->select("p.rowid, p.barcode");
        $this->db->from("llx_product p, llx_product_stock ps");
        $this->db->where("ps.fk_product=p.rowid");
        $this->db->where("ps.fk_entrepot",$rowid_entrepot);
        $query=$this->db->get();
        return $query->result_array();
    }

    //通过产品条形码获得产品的详细信息
    public function get_info_product_by_barcode($barcode){
        /*$rowid_entrepot=$_SESSION['fk_warehouse'];
        $this->db->select("p.rowid, p.ref, p.label, p.price, p.price_ttc, p.tva_tx, p.pmp cost_price");
        $this->db->from("llx_product p,llx_product_stock ps");
        $this->db->where("ps.fk_product=p.rowid");
        $this->db->where("ps.fk_entrepot",$rowid_entrepot);
        //$this->db->where("ps.reel>0");
        //$this->db->where("p.rowid",$rowid);
        $this->db->where("p.barcode",$barcode);
        $query=$this->db->get();
        return $query->result_array();*/

        //如果是从产品条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product_by_rowid($rowid);
            //如果没有在该仓库找到该产品
            if($info_product==NULL){
                return NULL;
            }
            $info_product[0]['unit']=0;//是二维数组第一个元素
            return $info_product;
        }
        //如果是从产品包条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_pack($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product_by_rowid($rowid);
            //如果没有在该仓库找到该产品
            if($info_product==NULL){
                return NULL;
            }
            $info_product[0]['unit']=1;//是包
            return $info_product;
        }
        //如果是从产品箱条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_box($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product_by_rowid($rowid);
            //如果没有在该仓库找到该产品
            if($info_product==NULL){
                return NULL;
            }
            $info_product[0]['unit']=2;//是箱
            return $info_product;
        }
        //如果是从产品运输箱条码找到的rowid
        $rowid=$this->get_product_rowid_by_barcode_bigbox($barcode);
        if($rowid!=null){
            $info_product=$this->get_info_product_by_rowid($rowid);
            //如果没有在该仓库找到该产品
            if($info_product==NULL){
                return NULL;
            }
            $info_product[0]['unit']=3;//是运输箱
            return $info_product;
        }
    }
    //通过产品rowid获得产品的详细信息
    public function get_info_product_by_rowid($rowid){
        $rowid_entrepot=$_SESSION['fk_warehouse'];
        $this->db->select("p.rowid, p.ref, p.label, p.price, p.price_ttc, p.tva_tx, p.pmp cost_price,
                           pe.pack, pe.box, pe.bigbox");
        $this->db->from("llx_product p,llx_product_stock ps");
        $this->db->join("llx_product_extrafields pe","p.rowid=pe.fk_object","left");//获得包，箱，运输箱数量
        $this->db->where("ps.fk_product=p.rowid");
        $this->db->where("ps.fk_entrepot",$rowid_entrepot);
        //$this->db->where("ps.reel>0");
        //$this->db->where("p.rowid",$rowid);
        $this->db->where("p.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();
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
        $this->db->from("llx_product_extrafields pe");
        $this->db->where("pe.barcode_pack",$barcode);
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
        $this->db->from("llx_product_extrafields pe");
        $this->db->where("pe.barcode_box",$barcode);
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
        $this->db->from("llx_product_extrafields pe");
        $this->db->where("pe.barcode_bigbox",$barcode);
        $query=$this->db->get();
        $info_product=$query->result_array();
        if($info_product==null){
            return null;
        }
        foreach($info_product as $value){
        }
        return $value['rowid'];
    }

    //获得产品列表  price是税前价格, price_ttc是含税价格
    //这个函数需要改进，改成获得该仓库下的产品列表
    public function get_list_products(){
        $rowid_entrepot=$_SESSION['fk_warehouse'];
        $this->db->select("p.rowid,p.ref,p.label,p.price,p.price_ttc");
        $this->db->from("llx_product p, llx_product_stock ps");
        $this->db->where("ps.fk_product=p.rowid");
        $this->db->where("ps.fk_entrepot",$rowid_entrepot);
        $this->db->order_by("p.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }

    public function get_facnumber($rowid_facture){
        $this->db->select("f.facnumber");
        $this->db->from("llx_facture f");
        $this->db->where("f.rowid",$rowid_facture);
        $query = $this->db->get();
        foreach($query as $value){
        }
        return $value['facnumber'];
    }

    //获得所有客户
    public function get_list_client(){
        $this->db->select("s.rowid rowid, s.nom nom");
        $this->db->from("llx_societe s");
        $this->db->where("s.client",1);
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }
    //更新用户
    public function set_client($rowid,$rowid_client){
        $data = array(
            'fk_soc' =>$rowid_client,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_pos_cash', $data);
    }
    //获得所有现金账户
    public function get_list_account_cash(){
        $this->db->select("ba.rowid rowid, ba.ref ref, ba.label label");
        $this->db->from("llx_bank_account ba");
        $this->db->where("ba.courant",2);
        $query=$this->db->get();
        return $query->result_array();
    }
    //更新现金账户
    public function set_account_cash($rowid,$rowid_account){
        $data = array(
            'fk_paycash' =>$rowid_account,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_pos_cash', $data);
    }
    //获得所有银行账户
    public function get_list_account_bank(){
        $courant=1;//信用卡 0是储蓄卡
        $this->db->select("ba.rowid rowid, ba.ref ref, ba.label label");
        $this->db->from("llx_bank_account ba");
        $this->db->where("ba.courant",$courant);
        $query=$this->db->get();
        return $query->result_array();
    }
    //更新银行账户
    public function set_account_bank($rowid,$rowid_account){
        $data = array(
            'fk_paybank' =>$rowid_account,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_pos_cash', $data);
    }
    //获得仓库列表
    public function get_list_warehouse(){
        $this->db->select("e.rowid, e.label");
        $this->db->from("llx_entrepot e");
        $query=$this->db->get();
        return $query->result_array();
    }
    //更新仓库
    public function set_warehouse($rowid,$rowid_warehouse){
        $data = array(
            'fk_warehouse' =>$rowid_warehouse,
        );
        $this->db->where('rowid', $rowid);
        $this->db->update('llx_pos_cash', $data);
    }
    //获得所有用户列表
    public function get_list_user(){
        $this->db->select("u.rowid, u.lastname");
        $this->db->from("llx_user u");
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


    //获得发票信息(打印用)
    public function get_facture($rowid_facture){
        $this->db->select("f.facnumber, f.total, f.total_ttc, f.tva");
        $this->db->from("llx_facture f");
        $this->db->where("f.rowid",$rowid_facture);
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得单张发票里的所有元素
    public function get_facturedet($rowid_facture){
        $this->db->select("fd.qty, fd.total_ttc, 
                           p.barcode, p.label, p.price_ttc");
        $this->db->from("llx_facturedet fd");
        $this->db->from("llx_product p");
        $this->db->where("p.rowid=fd.fk_product");
        $this->db->where("fd.fk_facture",$rowid_facture);
        $query=$this->db->get();
        return $query->result_array();
    }
}