<?php
//用来处理合伙人信息
//已弃用！！
class Societe_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }
    //通过公司rowid获得联系人rowid
    public function get_socpeople_by_societe($fk_soc){
        $this->db->select("rowid");
        $this->db->from("llx_socpeople");
        $this->db->where('fk_soc',$fk_soc);
        $query=$this->db->get();
        foreach ($query->result_array() as $value){
            $rowid=$value['rowid'];
        }
        return $rowid;
    }
    //通过公司rowid获得银行账户的rowid
    public function get_rib_by_societe($fk_soc){
        $this->db->select("rowid");
        $this->db->from("llx_societe_rib");
        $this->db->where('fk_soc',$fk_soc);
        $query=$this->db->get();
        foreach ($query->result_array() as $value){
            $rowid=$value['rowid'];
        }
        return $rowid;
    }

    //获得所有合伙人信息
    public function get_all_societes(){
        /*
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_fournisseur code_fournisseur, s.fk_typent as typent,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           sp.address address_personnelle, sp.civility,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_departements.nom departement,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           ");*/
        $this->db->select("s.rowid rowid,s.nom as name");
        $this->db->from("llx_societe s");
        //$this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        //$this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        //$this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        //$this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $query=$this->db->get();
        return $query->result_array();
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
        $query=$this->db->get();
        return $query->result_array();
    }

    //通过rowid获得合伙人信息
    public function get_societe_by_rowid($rowid=false){
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_fournisseur code_fournisseur,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           sp.address address_personnelle, sp.civility, 
                           pt.libelle_facture cond_reglement_supplier,
                           p.code,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_country.rowid rowid_pays,
                           llx_c_departements.nom departement, llx_c_departements.rowid rowid_departement,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           ");
        //$this->db->from("llx_societe soci, llx_socpeople socp, llx_c_departements d, llx_c_country c, llx_c_regions re, llx_societe_rib ri" );
        $this->db->from("llx_societe s");
        $this->db->join("llx_societe_extrafields se","se.fk_object=s.rowid","left");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->join("llx_c_payment_term pt","pt.rowid=s.cond_reglement_supplier","left");
        $this->db->join("llx_c_paiement p","p.id=s.mode_reglement_supplier","left");
        $this->db->where('s.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }
    ////获得合伙人的付款信息-->"付款条件","付款方式"等信息
    public function get_info_soc($rowid=null){
        $this->db->select("s.rowid, s.tva_intra, s.email, s.nom,
                            s.cond_reglement, s.cond_reglement_supplier, s.mode_reglement, s.mode_reglement_supplier,
                            t.code typent_code, t.libelle typent_libelle,
                            d.nom departement_nom, s.town");
        $this->db->from("llx_societe s");
        $this->db->join("llx_c_typent t","t.id=s.fk_typent","left");//类型
        $this->db->join("llx_c_departements d","d.rowid=s.fk_departement","left");//城市
        $this->db->where("s.rowid",$rowid);
        $query=$this->db->get();
        return $query->result_array();

    }

    public function get_products_by_rowid($rowid=false){

        //$query = $this->db->get_where('llx_product', array('ref' => $ref));
        $this->db->select("llx_product.rowid, llx_product.ref, llx_product.label, llx_product.description, llx_product.price, 
                               llx_product.cost_price, llx_product.note, 
                               llx_product.weight, llx_product.volume, llx_product.weight_units,
                               llx_product_extrafields.pack, llx_product_extrafields.undscaja,
                               llx_product_extrafields.undscajagrande, llx_product.barcode,
                               llx_product_extrafields.brand as brand_rowid, llx_product_extrafields.cajaembajale as cajaembajale,
                               llx_brands.label as brand_label");
        $this->db->from("llx_product");
        $this->db->join('llx_product_extrafields','llx_product_extrafields.fk_object=llx_product.rowid','left'); //extrafields
        $this->db->join('llx_brands','llx_brands.rowid=llx_product_extrafields.brand','left'); //brands
        $this->db->where('llx_product.rowid',$rowid);
        $query=$this->db->get();

        return $query->result_array();
    }

    //获得所有国家
    public function get_pays(){
        $this->db->select("*");
        $this->db->from("llx_c_country");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得指定国家下的地区列表
    public function get_departement($fk_pays){
        $this->db->select("llx_c_departements.rowid,llx_c_departements.nom");
        $this->db->from("llx_c_departements,llx_c_regions");
        $this->db->where("llx_c_regions.fk_pays",$fk_pays);
        $this->db->where("llx_c_regions.code_region=llx_c_departements.fk_region");
        $query=$this->db->get();
        return $query->result_array();
    }
    //获得所有工作岗位
    public function get_poste(){
        $this->db->select("label");
        $this->db->from("llx_c_hrm_department");
        $query=$this->db->get();
        return $query->result_array();
    }

    //添加新供应商时，需要添加到llx_societe并设置fournisseur为1，
    //添加相同的信息到llx_socpeople因为同时创建了联系人,
    //添加到llx_societe_commerciaux（这个不知道是干啥的）
    public function add_fournisseur()
    {
        //$var=sprintf("%04d", 2);//生成4位数，不足前面补0
        //echo $var;//结果为0002
        //获得供应商的总数，插入ref号时需要填写
        $this->db->select("count(fournisseur)");
        $this->db->from("llx_societe");
        $this->db->where('fournisseur',1);
        $query=$this->db->get();
        foreach($query->result_array() as $sum);
        $sum_fourni=$sum['count(fournisseur)']+1;
        $sum_fourni=sprintf("%04d", $sum_fourni);
        $ref="SU1750-".$sum_fourni;


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
            'cond_reglement_supplier'=>$this->input->post('cond_reglement_supplier'),
            'fk_user_creat'=>$_SESSION['rowid'],//是哪个用户创建的
            'fk_user_modif'=>$_SESSION['rowid'],

            //下面是没用到但是必填的信息
            'datec'=>$tms,
            'fk_typent'=>8, //这两个真不知道是干啥的  //好像是合伙人类型
            'fk_effectif'=>1,//
            'fournisseur'=>1,
            'fk_incoterms'=>0,
            'fk_multicurrency'=>0,
            'default_lang'=>'zh_CN',
        );
        $this->db->insert('llx_societe', $data);

        //llx_societe_commerciaux
        $id= $this->db->insert_id();
        $data = array(
            'fk_soc' => $id,
            'fk_user' => $_SESSION['rowid'],

        );
        $this->db->insert('llx_societe_commerciaux', $data);

        //添加extrafiled  主打标签
        $data = array(
            'fk_object' => $id,
            'productoestrella'=>$this->input->post('main_categ'),
        );
        $this->db->insert('llx_societe_extrafields', $data);

        //llx_socpeople
        $data=array(
            'datec'=>$tms,
            'fk_soc'=>$id,
            'civility'=>$this->input->post('civility'),
            'lastname'=>$this->input->post('last_name'),
            'firstname'=>$this->input->post('first_name'),
            'address'=>$this->input->post('address_personnelle'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'poste'=>$this->input->post('poste'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
            'fk_user_creat'=>$_SESSION['rowid'],
        );
        $this->db->insert('llx_socpeople',$data);

        $fk_soc=$id;
        $label=$this->input->post('ban_label');
        $bank=$this->input->post('bank_name');
        $bic=$this->input->post('bic');
        $iban_prefix=$this->input->post('iban_prefix');
        $proprio=$this->input->post('proprio');
        $this->add_rib($fk_soc,$label,$bank,$bic,$iban_prefix,$proprio);

        //添加categ
        if($this->input->post('categ')!=null)//如果没有输入值则不添加
            $this->replace_categ($id,$this->input->post('categ'));
        /*for($i=1;$i<=$this->input->post('nb_categ');$i++){
            $this->replace_categ($id,$this->input->post('sous_categ['.$i.']'));
        }*/
        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->replace_categ($id, $value);
            }
        }
        //$this->replace_categ($id,$this->input->post('sous_categ'));
        return $id;//返回新创建的供货商id
    }
    //添加银行账户
    public function add_rib($fk_soc,$label,$bank,$bic,$iban_prefix,$proprio=null,$number,$domiciliation){
        $tms=date("Y-m-d h:i::sa");

        $data=array(
            'fk_soc'=>$fk_soc,
            'datec'=>$tms,
            'label'=>$label,
            'bank'=>$bank,
            'bic'=>$bic,
            'iban_prefix'=>$iban_prefix,
            'proprio'=>$proprio,
            'default_rib'=>1,

            //没用的信息
            'code_banque'=>'',
            'code_guichet'=>'',
            'number'=>$number,
            'cle_rib'=>'',
            'domiciliation'=>$domiciliation,
            'owner_address'=>'',
        );
        $this->db->insert('llx_societe_rib',$data);
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
            'cond_reglement_supplier'=>$this->input->post('cond_reglement_supplier'),
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid); //这里可以直接用hidden_post的方法取得rowid，所以不用ref直接用rowid
        $this->db->update('llx_societe', $data);

        //更新extrafiles
        //如果创建供货商时本身没有创建extrafield, 则创建新的extrafield
        $query = $this->db->get_where('llx_societe_extrafields', array('fk_object' => $rowid));
        if($query->result_array()==null){
            $data = array(
                'fk_object'=>$rowid,
                'productoestrella'=>$this->input->post('main_categ'),
            );
            $this->db->insert('llx_societe_extrafields', $data);
        }
        else{
            //如果本身有创建这个信息，则更新
            $data = array(
                'fk_object'=>$rowid,
                'productoestrella'=>$this->input->post('main_categ'),
            );
            $this->db->where('fk_object', $rowid);
            $this->db->update('llx_societe_extrafields', $data);
        }

        //llx_socpeople
        $rowid_socpeople=$this->get_socpeople_by_societe($rowid);
        $data=array(
            'civility'=>$this->input->post('civility'),
            'lastname'=>$this->input->post('last_name'),
            'firstname'=>$this->input->post('first_name'),
            'address'=>$this->input->post('address_personnelle'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'poste'=>$this->input->post('poste'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
        );
        $this->db->where('rowid', $rowid_socpeople);
        $this->db->update('llx_socpeople',$data);

        //更新rib
        $rowid_rib=$this->get_rib_by_societe($rowid);
        $data=array(
            'label'=>$this->input->post('ban_label'),
            'bank'=>$this->input->post('bank_name'),
            'bic'=>$this->input->post('bic'),
            'iban_prefix'=>$this->input->post('iban_prefix'),
            'proprio'=>$this->input->post('proprio'),
        );
        $this->db->where('rowid', $rowid_rib);
        $this->db->update('llx_societe_rib',$data);

        //更新categ
        //$this->replace_categ($rowid,$this->input->post('categ'));
        //$this->replace_categ($rowid,$this->input->post('sous_categ'));

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

    //通过标签id获得付款条件标签信息
    public function get_categ_by_id(){
        $this->db->select("rowid, code, libelle_facture");
        $this->db->from("llx_c_payment_term");
        $query=$this->db->get();
        return $query->result_array();
    }



    //获得所有供应商标签
    public function get_all_categ(){
        if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
            $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
            $this->db->where('type', 1);
            $this->db->where('lang', 'zh_CN');
            $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
            $query = $this->db->get_where('llx_categorie');
        }
        else {
            $this->db->select('rowid,label');
            $this->db->where('type', 1);
            $query = $this->db->get_where('llx_categorie');
        }
        return $query->result_array();
    }


    //获得联系人已选标签
    public function get_contact_categ($rowid){
        if($_SESSION['language']=='chinese'){
            $this->db->select('llx_categorie.rowid, llx_categorie_lang.label, llx_categorie_contact.fk_socpeople');
            $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
            $this->db->where('llx_categorie_lang.lang="zh_CN"');
        }
        else {
            $this->db->select('llx_categorie.rowid, llx_categorie.label, llx_categorie_contact.fk_socpeople');
        }
        $this->db->from("llx_categorie, llx_categorie_contact");
        $this->db->where('llx_categorie_contact.fk_socpeople', $rowid);
        $this->db->where('llx_categorie.rowid=llx_categorie_contact.fk_categorie');
        $query=$this->db->get();
        return $query->result_array();
    }

    //获得供应商所有的父类categorie
    public function get_pere_categ(){
        if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
            $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
            $this->db->where('type', 1);//1指的是给supplier的categ
            $this->db->where('lang', 'zh_CN');
            $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
            $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        }
        else {
            $this->db->select('rowid,label');
            $this->db->where('type', 1);
            $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        }
        return $query->result_array();
    }

    //获得客户的父类标签
    public function get_client_pere_categ(){
        if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
            $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
            $this->db->where('type', 2);//2指的是给client的categ
            $this->db->where('lang', 'zh_CN');
            $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
            $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        }
        else {
            $this->db->select('rowid,label');
            $this->db->where('type', 2);
            $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        }
        return $query->result_array();
    }
    //获得联系人的父类标签
    public function get_contact_pere_categ(){
        if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
            $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
            $this->db->where('lang', 'zh_CN');
            $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
        }
        else {
            $this->db->select('rowid,label');
        }
        $this->db->where('type', 4);//4指的是给contact的categ
        $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
        return $query->result_array();
    }

    //获得该供应商已选的父类categ
    public function get_pere_categ_by_fk_soc($fk_soc){
        if($_SESSION['language']=='chinese'){
            $sql = "SELECT llx_categorie.rowid, llx_categorie_lang.label, llx_categorie_fournisseur.fk_soc 
                    FROM llx_categorie,llx_categorie_fournisseur 
                    LEFT JOIN llx_categorie_lang ON llx_categorie_fournisseur.fk_categorie=llx_categorie_lang.fk_category
                    WHERE llx_categorie_fournisseur.fk_soc=?
                    and llx_categorie.type=1
                    and fk_parent=0
                    and llx_categorie.rowid=llx_categorie_fournisseur.fk_categorie
                    and llx_categorie_lang.lang='zh_CN'";
        }
        else {
            $sql = "SELECT llx_categorie.rowid, llx_categorie.label, llx_categorie_fournisseur.fk_soc 
                    FROM llx_categorie,llx_categorie_fournisseur 
                    WHERE llx_categorie_fournisseur.fk_soc=?
                    and llx_categorie.type=1
                    and fk_parent=0
                    and llx_categorie.rowid=llx_categorie_fournisseur.fk_categorie";
        }
        $query = $this->db->query($sql, array($fk_soc));
        return $query->result_array();
    }

    //用父类的rowid来获得可选的子类的rowid
    public function get_enfant_categ_by_pere($rowid){
        if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
            $sql = "SELECT llx_categorie.rowid,llx_categorie_lang.label 
                    FROM (llx_categorie)
                    LEFT JOIN llx_categorie_lang ON llx_categorie.rowid=llx_categorie_lang.fk_category
                    WHERE fk_parent=?  
                    and lang='zh_CN'";
        }
        else {
            $sql = "SELECT rowid,label,description FROM llx_categorie 
                    WHERE fk_parent=?  ";
        }
        $query = $this->db->query($sql, array($rowid));
        return $query->result_array();
    }
    //查看
    /*
    public function check_exsist_categ(){

    }*/
    //替换供应商标签(如果存在则替换，不存在则添加)
    public function replace_categ($fk_soc,$fk_categorie){
        $data = array(
            'fk_categorie' => $fk_categorie,
            'fk_soc'  => $fk_soc,
        );
        $this->db->replace('llx_categorie_fournisseur', $data);
        // Executes: REPLACE INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
    }
    //删除该供应商的所有标签
    public function delete_all_categ($fk_soc){
        $this->db->delete('llx_categorie_fournisseur',array('fk_soc'=>$fk_soc));
    }


    //替换客户标签(如果存在则替换，不存在则添加)
    public function replace_categ_client($fk_soc,$fk_categorie){
        $data = array(
            'fk_categorie' => $fk_categorie,
            'fk_soc'  => $fk_soc,
        );
        $this->db->replace('llx_categorie_societe', $data);
        // Executes: REPLACE INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
    }
    public function delete_all_categ_client($fk_soc){
        $this->db->delete('llx_categorie_societe',array('fk_soc'=>$fk_soc));
    }

    //替换联系人标签(如果存在则替换，不存在则添加)
    public function replace_categ_contact($fk_socpeople,$fk_categorie){
        $data = array(
            'fk_categorie' => $fk_categorie,
            'fk_socpeople'  => $fk_socpeople,
        );
        $this->db->replace('llx_categorie_contact', $data);
    }
    public function delete_all_categ_contact($fk_socpeople){
        $this->db->delete('llx_categorie_contact',array('fk_socpeople'=>$fk_socpeople));
    }

    //获得经营属性
    public function get_typent(){
        $this->db->select("id, code, libelle");
        $this->db->from("llx_c_typent");
        $this->db->where("active",1);
        $query=$this->db->get();
        return $query->result_array();
    }
}