<?php
//用来处理供应商信息
class Fournisseur_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
    }

    //获得所有的供应商列表
    public function get_all_fournisseur(){
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_fournisseur code_fournisseur,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           sp.address address_personnelle, sp.civility,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_departements.nom departement,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           ");
        $this->db->from("llx_societe s");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->where('fournisseur',1);
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }
    //计算总数
    public function count_fournisseur(){
        $query = $this->db->query('SELECT rowid FROM llx_societe where fournisseur=1');
        return $query->num_rows();
    }
    public function fetch_fournisseur($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_fournisseur code_fournisseur,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           sp.address address_personnelle, sp.civility,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_departements.nom departement,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           ");
        $this->db->from("llx_societe s");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->where('fournisseur',1);
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }

    //通过rowid获得供应商信息
    public function get_societe_by_rowid($rowid=false){
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_fournisseur code_fournisseur, s.mode_reglement_supplier,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype, s.tva_assuj, s.tva_intra, s.note_public as note,
                           sp.address address_personnelle, sp.civility, 
                           pt.rowid as cond_reglement_supplier_rowid, pt.libelle_facture cond_reglement_supplier, pt.code as cond_reglement_supplier_code,
                           p.id as mode_reglement_supplier_id, p.code as mode_reglement_supplier_code,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_country.rowid rowid_pays,
                           llx_c_departements.nom departement, llx_c_departements.rowid rowid_departement,
                           t.id as typent_rowid, t.code as typent_code,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           llx_societe_rib.number number, llx_societe_rib.domiciliation,
                           ");
        //$this->db->from("llx_societe soci, llx_socpeople socp, llx_c_departements d, llx_c_country c, llx_c_regions re, llx_societe_rib ri" );
        $this->db->from("llx_societe s");
        $this->db->join("llx_societe_extrafields se","se.fk_object=s.rowid","left");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_c_typent t","t.id=s.fk_typent","left");//经营属性
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->join("llx_c_payment_term pt","pt.rowid=s.cond_reglement_supplier","left");
        $this->db->join("llx_c_paiement p","p.id=s.mode_reglement_supplier","left");
        //$this->db->join("llx_categorie c","pt.rowid=s.cond_reglement_supplier","left");//主打标签
        $this->db->where('s.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }


    //添加新供应商时，需要添加到llx_societe并设置fournisseur为1，
    //添加相同的信息到llx_socpeople因为同时创建了联系人,
    //添加到llx_societe_commerciaux //销售代表
    public function add_fournisseur()
    {
        //$var=sprintf("%04d", 2);//生成4位数，不足前面补0
        //echo $var;//结果为0002
        //获得供应商最后一个添加的code，插入ref号时需要填写
        $this->db->select("code_fournisseur");
        $this->db->from("llx_societe");
        $this->db->where('fournisseur',1);
        $this->db->order_by("rowid", "asc");
        $query=$this->db->get();
        foreach($query->result_array() as $sum);
        $num=substr($sum['code_fournisseur'], 7);
        $num_fourni=$num+1;
        $num_fourni=sprintf("%04d", $num_fourni);
        $ref="SU1706-".$num_fourni;


        $fournisseur_name=$this->input->post('company_name');

        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'nom' => $fournisseur_name,
            'name_alias' => $this->input->post('name_alias'),
            'code_fournisseur'=>$ref,
            'address'=>$this->input->post('address'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
            'skype'=>$this->input->post('skype'),
            'fk_typent'=>$this->input->post('typent'),
            'note_public'=>$this->input->post('note'),
            'cond_reglement_supplier'=>$this->input->post('cond_reglement_supplier'),
            'mode_reglement_supplier'=>$this->input->post('mode_reglement_supplier'),
            'tva_assuj'=>$this->input->post('tva_assuj'),
            'tva_intra'=>$this->input->post('tva_intra'),
            'fk_user_creat'=>$_SESSION['rowid'],//是哪个用户创建的
            'fk_user_modif'=>$_SESSION['rowid'],

            //下面是没用到但是必填的信息
            'datec'=>$tms,
            'fk_effectif'=>1,//
            'fournisseur'=>1,
            'fk_incoterms'=>0,
            'fk_multicurrency'=>0,
            'default_lang'=>'zh_CN',
        );
        $this->db->insert('llx_societe', $data);

        //llx_societe_commerciaux
        $id= $this->db->insert_id();
        /*销售代表，还没添加
        $data = array(
            'fk_soc' => $id,
            'fk_user' => $this->input->post('societe_commerciaux'),
        );
        $this->db->insert('llx_societe_commerciaux', $data);*/

        //添加extrafiled
        $data = array(
            'fk_object' => $id,
        );
        $this->db->insert('llx_societe_extrafields', $data);

        //添加银行账户
        $fk_soc=$id;
        $label=$this->input->post('ban_label');
        $bank=$this->input->post('bank_name');
        $bic=$this->input->post('bic');
        $iban_prefix=$this->input->post('iban_prefix');
        $proprio=$this->input->post('proprio');
        $number=$this->input->post('number');
        $domiciliation=$this->input->post('domiciliation');
        $this->Societe_model->add_rib($fk_soc,$label,$bank,$bic,$iban_prefix,$proprio,$number,$domiciliation);

        //添加categ
        /*
        if($this->input->post('categ')!=null)//如果没有输入值则不添加
            $this->Societe_model->replace_categ($id,$this->input->post('categ'));*/
        /*for($i=1;$i<=$this->input->post('nb_categ');$i++){
            $this->replace_categ($id,$this->input->post('sous_categ['.$i.']'));
        }*/
        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->Societe_model->replace_categ($id, $value);
            }
        }
        return $id;//返回新创建的供货商id
    }

    public function set_societe($rowid){
        $this->load->helper('url');
        //更新公司信息
        $data = array(
            'nom' => $this->input->post('company_name'),
            'name_alias' => $this->input->post('name_alias'),
            'address'=>$this->input->post('address'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
            'skype'=>$this->input->post('skype'),
            'fk_typent'=>$this->input->post('typent'),
            'note_public'=>$this->input->post('note'),
            'cond_reglement_supplier'=>$this->input->post('cond_reglement_supplier'),
            'mode_reglement_supplier'=>$this->input->post('mode_reglement_supplier'),
            'tva_assuj'=>$this->input->post('tva_assuj'),
            'tva_intra'=>$this->input->post('tva_intra'),
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid); //这里可以直接用hidden_post的方法取得rowid，所以不用ref直接用rowid
        $this->db->update('llx_societe', $data);

        //更新extrafiles
        //如果创建供货商时本身没有创建extrafield, 则创建新的extrafield
        $data = array(
            'fk_object'=>$rowid,
        );
        $query = $this->db->get_where('llx_societe_extrafields', array('fk_object' => $rowid));
        if($query->result_array()==null){
            $this->db->insert('llx_societe_extrafields', $data);
        }
        else{
            //如果本身有创建这个信息，则更新
            $this->db->where('fk_object', $rowid);
            $this->db->update('llx_societe_extrafields', $data);
        }


        //更新rib
        //如果本身没有银行账户，则创建
        $rowid_rib=$this->Societe_model->get_rib_by_societe($rowid);
        $data=array(
            'label'=>$this->input->post('ban_label'),
            'bank'=>$this->input->post('bank_name'),
            'bic'=>$this->input->post('bic'),
            'iban_prefix'=>$this->input->post('iban_prefix'),
            'proprio'=>$this->input->post('proprio'),
            'number'=>$this->input->post('number'),
            'domiciliation'=>$this->input->post('domiciliation')
        );
        if($rowid_rib==null){
            $fk_soc=$rowid;
            $label=$this->input->post('ban_label');
            $bank=$this->input->post('bank_name');
            $bic=$this->input->post('bic');
            $iban_prefix=$this->input->post('iban_prefix');
            $proprio=$this->input->post('proprio');
            $number=$this->input->post('number');
            $domiciliation=$this->input->post('domiciliation');
            $this->Societe_model->add_rib($fk_soc,$label,$bank,$bic,$iban_prefix,$proprio,$domiciliation);
        }
        else {
            $this->db->where('rowid', $rowid_rib);
            $this->db->update('llx_societe_rib', $data);
        }
    }



}