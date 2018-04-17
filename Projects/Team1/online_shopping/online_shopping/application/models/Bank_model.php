<?php
//用来处理供应商信息
class Bank_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
    }

    //获得所有银行列表 用于下拉栏
    public function get_list_bank_account(){
        $this->db->select('rowid, label');
        $this->db->from("llx_bank_account");
        $query=$this->db->get();
        return $query->result_array();
    }
    //计算银行账户总数
    public function count_bank_accounts(){
        $query = $this->db->query('SELECT rowid FROM llx_bank_account');
        return $query->num_rows();
    }
    public function fetch_bank_account($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("ba.rowid rowid, ba.ref, ba.label, ba.bank, ba.code_banque, ba.number, ba.bic, ba.domiciliation, 
                           ba.proprio, ba.owner_address, ba.courant, ba.min_allowed, ba.min_desired, ba.comment,
                           cc.label pays, cc.rowid rowid_pays,
                           cd.nom departement, cd.rowid rowid_departement,
                           ");
        $this->db->from("llx_bank_account ba");
        $this->db->join("llx_c_country cc","cc.rowid=ba.fk_pays","left");//国家
        $this->db->join("llx_c_departements cd","cd.rowid=ba.state_id","left");//地区
        $this->db->order_by("ba.rowid", "desc");
        $query=$this->db->get();
        $result=$query->result_array();
        foreach($result as &$value){
                $value['balance']=$this->calculate_balance($value['rowid']);
        }
        return $result;
    }

    //通过rowid获得银行账户信息
    public function get_bank_account_by_rowid($rowid=NULL){
        $this->db->select("ba.rowid rowid, ba.ref, ba.label, ba.bank, ba.code_banque, ba.number, ba.bic, ba.domiciliation, ba.iban_prefix,
                           ba.proprio, ba.owner_address, ba.courant, ba.min_allowed, ba.min_desired, ba.comment,
                           cc.label pays, cc.rowid rowid_pays,
                           cd.nom departement, cd.rowid rowid_departement,
                           ");
        $this->db->from("llx_bank_account ba");
        $this->db->join("llx_c_country cc","cc.rowid=ba.fk_pays","left");//国家
        $this->db->join("llx_c_departements cd","cd.rowid=ba.state_id","left");//地区
        $this->db->where('ba.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }

    //一个函数两用，如果输入的id为空则添加新银行账户，如果不为空则更新
    public function replace_bank_account($id=null)
    {
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        $data=array(
            'datec'=>$tms,
            'ref'=>$this->input->post('ref'),
            'label'=>$this->input->post('label'),
            'courant'=>$this->input->post('courant'),
            'min_allowed'=>$this->input->post('min_allowed'),
            'min_desired'=>$this->input->post('min_desired'),
            'comment'=>$this->input->post('comment'),
            'bank'=>$this->input->post('bank'),
            'code_banque'=>$this->input->post('code_banque'),
            'number'=>$this->input->post('number'),
            'iban_prefix'=>$this->input->post('iban_prefix'),
            'bic'=>$this->input->post('bic'),
            'owner_address'=>$this->input->post('owner_address'),
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        if($id==null) {
            $this->db->insert('llx_bank_account', $data);
            $id = $this->db->insert_id();
            //添加初期平衡  =添加银行账目
            $amount=$this->input->post('balance');
            $this->add_bank($id,$amount,"初期平衡","SOLD");
        }
        else{
            $this->db->where('rowid', $id);
            $this->db->update('llx_bank_account', $data);
        }

        //如果是用于更新联系人，则删掉之前的标签
        /*if($id!=null){
            $this->Societe_model->delete_all_categ_contact($id);
        }
        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->Societe_model->replace_categ_contact($id, $value);
            }
        }*/

        return $id;//返回新创建的联系人id
    }

    //计算账户余额
    public function calculate_balance($fk_account,$rowid=NULL){
        //SELECT sum(amount) FROM `llx_bank` WHERE fk_account=2
        $this->db->select("sum(amount) balance");
        $this->db->from("llx_bank");
        $this->db->where("fk_account",$fk_account);
        if($rowid!=NULL) {
            //分页的时候只计算前n条总和
            $this->db->where("rowid<=", $rowid);
        }
        $query=$this->db->get();
        $result=$query->result_array();
        return $result[0]["balance"];
    }

    //添加银行账目
    public function add_bank($fk_account,$amount,$label,$fk_type){
        $tms=date("Y-m-d h:i::sa");
        $data=array(
            'datec'=>$tms,
            'tms'=>$tms,
            'datev'=>$tms,
            'dateo'=>$tms,
            'amount'=>$amount,
            'label'=>$label,
            'fk_account'=>$fk_account,
            'fk_user_author'=>$_SESSION['rowid'],
            'fk_type'=>$fk_type,
            'emetteur'=>NULL,
        );
        $this->db->insert('llx_bank', $data);
        return $this->db->insert_id();
    }

    //银行账目总数
    public function count_bank_account_entry($fk_account){
        $this->db->select("b.rowid");
        $this->db->from("llx_bank b");
        $this->db->where("b.fk_account",$fk_account);
        $query=$this->db->get();
        return $query->num_rows();
    }

    //银行账目记录
    public function fetch_bank_account_entry($limit,$offset,$fk_account=NULL){
        $this->db->limit($limit,$offset);
        $this->db->select("b.rowid, b.datec, b.tms, b.datev, b.dateo, b.amount, b.label, b.fk_type,
                           ba.ref as account_ref, ba.label as account_label,
                           s.nom as soc_nom");
        $this->db->from("llx_bank b, llx_bank_account ba");
        $this->db->join("llx_paiement p","p.fk_bank=b.rowid","left");//付款记录
        $this->db->join("llx_paiement_facture pf","pf.fk_paiement=p.rowid","left");//付款记录对应的发票
        $this->db->join("llx_facture f","f.rowid=pf.fk_facture","left");//对应的发票
        $this->db->join("llx_societe s","s.rowid=f.fk_soc","left");//第三方
        $this->db->where('ba.rowid',$fk_account);
        $this->db->where("b.fk_account=ba.rowid");
        $this->db->order_by("b.rowid","desc");
        $query=$this->db->get();
        $result=$query->result_array();
        return $result;
    }
    //银行账目详细信息
    public function get_info_bank_account_entry($rowid){
        $this->db->select("b.rowid, b.datec, b.tms, b.datev, b.dateo, b.amount, b.label, b.fk_type,
                           ba.rowid as account_rowid, ba.ref as account_ref, ba.label as account_label,
                           p.rowid as paiement_rowid, p.ref as paiement_ref,
                           f.rowid as facture_rowid, f.facnumber as facnumber,
                           s.rowid as soc_rowid,s.nom as soc_nom");
        $this->db->from("llx_bank b, llx_bank_account ba");
        $this->db->join("llx_paiement p","p.fk_bank=b.rowid","left");//付款记录
        $this->db->join("llx_paiement_facture pf","pf.fk_paiement=p.rowid","left");//付款记录对应的发票
        $this->db->join("llx_facture f","f.rowid=pf.fk_facture","left");//对应的发票
        $this->db->join("llx_societe s","s.rowid=f.fk_soc","left");//第三方

        $this->db->join("llx_paiementfourn","llx_paiementfourn.fk_bank=b.rowid","left");//供应商付款记录
        $this->db->join("llx_paiementfourn_facturefourn pfff","pfff.fk_paiementfourn=llx_paiementfourn.rowid","left");//付款记录对应的供应商发票
        $this->db->join("llx_facture_fourn ff","ff.rowid=pfff.fk_facturefourn","left");//供应商发票fk_facturefourn

        $this->db->where('b.rowid',$rowid);
        $this->db->where("b.fk_account=ba.rowid");
        $query=$this->db->get();
        $result=$query->result_array();
        return $result;
    }

    //添加或修改银行账目信息
    public function replace_bank_account_entry($id=NULL){
        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");

        $data=array(
            'tms'=>$tms,
            'datev'=>$this->input->post('datev'),
            'dateo'=>$this->input->post('dateo'),
            'amount'=>$this->input->post('amount'),
            'label'=>$this->input->post('label'),
            'fk_type'=>$this->input->post('fk_type'),
        );
        if($id==null) {
            $this->db->insert('llx_bank', $data);
            $id = $this->db->insert_id();
        }
        else{
            $this->db->where('rowid', $id);
            $this->db->update('llx_bank', $data);
        }
        return $id;
    }

    //获得销售代表列表
    public function get_list_societe_commerciaux(){
        $this->db->select('rowid, concat(firstname,lastname) as name');
        $query = $this->db->get_where('llx_user');
        return $query->result_array();
    }
    //通过客户rowid获得销售代表
    public function get_societe_commerciaux_by_fk_soc($fk_soc){
        $this->db->select('u.rowid, concat(firstname,lastname) as name');
        $this->db->from("llx_user u, llx_societe_commerciaux sc");
        $this->db->where("u.rowid=sc.fk_user");
        $this->db->where("sc.fk_soc",$fk_soc);
        $query=$this->db->get();
        return $query->result_array();
    }

}