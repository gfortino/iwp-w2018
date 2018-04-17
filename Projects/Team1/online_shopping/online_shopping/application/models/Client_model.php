<?php
//用来处理供应商信息
class Client_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('Societe_model');
    }

    //获得所有客户的列表
    public function get_all_client(){
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_client code_client,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           s.lat, s.lng,
                           sp.address address_personnelle, sp.civility,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_departements.nom departement,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,      
                           llx_societe_rib.number, llx_societe_rib.bic bic, llx_societe_rib.proprio proprio,
                           ");
        $this->db->from("llx_societe s");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->where('(client=1 or client=3)');
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        return $query->result_array();
    }
    //计算总数
    public function count_client(){
        $query = $this->db->query('SELECT rowid FROM llx_societe where client=1');
        return $query->num_rows();
    }
    public function fetch_client($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_client code_client,
                           s.address address, s.zip zip, s.town town, s.phone phone, s.fax fax, s.email email, s.skype skype,
                           s.lat, s.lng,
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
        $this->db->where('(client=1 or client=3)');
        $this->db->order_by("s.rowid", "desc");
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return $query->result_array();
        }
    }

    //通过rowid获得客户信息
    public function get_societe_by_rowid($rowid=false){
        $this->db->select("s.rowid rowid,s.nom nom, s.name_alias name_alias, s.code_client code_client, s.mode_reglement,
                           s.address address, s.zip zip, s.town town, s.lat, s.lng,
                           s.phone phone, s.fax fax, s.email email, s.skype skype, s.tva_intra, s.tva_assuj, s.localtax1_assuj,
                           s.note_public as note,
                           sp.address address_personnelle, sp.civility, 
                           pt.rowid as cond_reglement_rowid, pt.libelle_facture cond_reglement, pt.code as cond_reglement_code,
                           p.id as mode_reglement_id, p.code as mode_reglement_code,
                           sp.lastname lastname,sp.firstname firstname, sp.poste,
                           llx_c_country.label pays, llx_c_country.rowid rowid_pays,
                           llx_c_departements.nom departement, llx_c_departements.rowid rowid_departement,llx_societe_rib.number,
                           llx_societe_rib.label bank_label, llx_societe_rib.bank bank_name, llx_societe_rib.iban_prefix iban,
                           llx_societe_rib.bic bic, llx_societe_rib.proprio proprio, llx_societe_rib.domiciliation
                           ");
        //$this->db->from("llx_societe soci, llx_socpeople socp, llx_c_departements d, llx_c_country c, llx_c_regions re, llx_societe_rib ri" );
        $this->db->from("llx_societe s");
        //$this->db->join("llx_societe_commerciaux sc","sc.fk_soc=s.rowid","left");
        $this->db->join("llx_societe_extrafields se","se.fk_object=s.rowid","left");
        $this->db->join("llx_socpeople sp","sp.fk_soc=s.rowid","left");
        $this->db->join("llx_c_country","llx_c_country.rowid=s.fk_pays","left");
        $this->db->join("llx_c_departements","llx_c_departements.rowid=s.fk_departement","left");
        $this->db->join("llx_societe_rib","llx_societe_rib.fk_soc=s.rowid","left");
        $this->db->join("llx_c_payment_term pt","pt.rowid=s.cond_reglement","left");
        $this->db->join("llx_c_paiement p","p.id=s.mode_reglement","left");
        $this->db->where('s.rowid',$rowid);
        $query=$this->db->get();
        return $query->result_array();
    }


    //添加新客户时，需要添加到llx_societe并设置client为1，
    //添加相同的信息到llx_socpeople因为同时创建了联系人,
    //添加到llx_societe_commerciaux（这个不知道是干啥的）
    public function add_client()
    {
        //$var=sprintf("%04d", 2);//生成4位数，不足前面补0
        //echo $var;//结果为0002
        //获得客户的最后一个添加的code_client，插入ref号时需要填写
        $this->db->select("code_client");
        $this->db->from("llx_societe");
        $this->db->where('client',1);
        $this->db->order_by("rowid", "asc");
        $query=$this->db->get();
        foreach($query->result_array() as $sum);
        $num=substr($sum['code_client'], 7);
        $num_client=$num+1;
        $num_client=sprintf("%04d", $num_client);
        $ref="CU1704-".$num_client;


        $client_name=$this->input->post('company_name');

        $this->load->helper('url');
        //获取当前时间，插入数据库时需要
        $tms=date("Y-m-d h:i::sa");
        $data = array(
            'nom' => $client_name,
            'name_alias' => $this->input->post('name_alias'),
            'code_client'=>$ref,
            'address'=>$this->input->post('address'),
            'zip'=>$this->input->post('zip'),
            'town'=>$this->input->post('town'),
            'fk_departement'=>$this->input->post('fk_departement'),
            'fk_pays'=>$this->input->post('fk_pays'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
            'skype'=>$this->input->post('skype'),
            'note_public'=>$this->input->post('note'),
            'cond_reglement'=>$this->input->post('cond_reglement'),
            'mode_reglement'=>$this->input->post('mode_reglement'),
            'tva_assuj'=>$this->input->post('tva_assuj'),
            'localtax1_assuj'=>$this->input->post('localtax1_assuj'),
            'tva_intra'=>$this->input->post('tva_intra'),
            'fk_user_creat'=>$_SESSION['rowid'],//是哪个用户创建的
            'fk_user_modif'=>$_SESSION['rowid'],
            'fk_multicurrency'=>1,//货币是欧元
            'multicurrency_code'=>'EUR',

            //下面是没用到但是必填的信息
            'datec'=>$tms,
            'fk_typent'=>8, //这两个真不知道是干啥的  //好像是合伙人类型
            'fk_effectif'=>1,//
            'client'=>1,
            'fk_incoterms'=>0,
            'default_lang'=>'zh_CN',
        );
        $this->db->insert('llx_societe', $data);

        //llx_societe_commerciaux销售代表
        $id= $this->db->insert_id();
        $data = array(
            'fk_soc' => $id,
            'fk_user' => $this->input->post('societe_commerciaux'),

        );
        $this->db->insert('llx_societe_commerciaux', $data);

        //添加extrafiled  主打标签; 仓库地址
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


        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->Societe_model->replace_categ_client($id, $value);
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
            'lat'=>$this->input->post('lat'),
            'lng'=>$this->input->post('lng'),
            'phone'=>$this->input->post('phone'),
            'fax'=>$this->input->post('fax'),
            'email'=>$this->input->post('email'),
            'skype'=>$this->input->post('skype'),
            'note_public'=>$this->input->post('note'),
            'cond_reglement'=>$this->input->post('cond_reglement'),
            'mode_reglement'=>$this->input->post('mode_reglement'),
            'tva_assuj'=>$this->input->post('tva_assuj'),
            'localtax1_assuj'=>$this->input->post('localtax1_assuj'),
            'tva_intra'=>$this->input->post('tva_intra'),
            'fk_user_modif'=>$_SESSION['rowid'],
        );
        $this->db->where('rowid', $rowid); //这里可以直接用hidden_post的方法取得rowid，所以不用ref直接用rowid
        $this->db->update('llx_societe', $data);

        //更新销售代表
        $data = array(
            'fk_soc' => $rowid,
            'fk_user' => $this->input->post('societe_commerciaux'),

        );
        $query = $this->db->get_where('llx_societe_commerciaux', array('fk_soc' => $rowid));
        if($query->result_array()==null){
            $this->db->insert('llx_societe_commerciaux', $data);
        }
        else{
            $this->db->where('fk_soc', $rowid);
            $this->db->update('llx_societe_commerciaux', $data);
        }
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
            'domiciliation'=>$this->input->post('domiciliation'),
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
            $this->Societe_model->add_rib($fk_soc,$label,$bank,$bic,$iban_prefix,$proprio,$number,$domiciliation);
        }
        else {
            $this->db->where('rowid', $rowid_rib);
            $this->db->update('llx_societe_rib', $data);
        }

        //更新categ
        //这里我打算先删除之前该供应商的所有标签，再重新添加进来
        $this->Societe_model->delete_all_categ_client($rowid);
        /*
        if($this->input->post('categ')!=null)//如果没有输入值则不添加
            $this->Societe_model->replace_categ($rowid,$this->input->post('categ'));*/

        $sous_categ=$this->input->post('sous_categ');
        if($sous_categ!=null) {
            foreach ($sous_categ as $value) {
                $this->Societe_model->replace_categ_client($rowid, $value);
            }
        }
    }



    //供货商细节
    //增加供货商细节
    /*
    public function add_detalles_proveedores($fk_object,$clientela,$main_product,$valoracionprecio,$calidad,$fechaentrega,$actividad,$market){
        $data = array(
            'fk_object' => $fk_object,
            'clientela' => $clientela,
            'main_product'=>$main_product,
            'valoracionprecio'=>$valoracionprecio,
            'calidad'=>$calidad,
            'fechaentrega'=>$fechaentrega,
            'actividad'=>$actividad,
            'market'=>$market,
        );
        $this->db->insert('llx_cust_detalles_proveedores_extrafields', $data);
    }
    //更新供货商细节
    public function set_detalles_proveedores($fk_object,$clientela,$main_product,$valoracionprecio,$calidad,$fechaentrega,$actividad,$market){
        $data=array(
            'clientela' => $clientela,
            'main_product'=>$main_product,
            'valoracionprecio'=>$valoracionprecio,
            'calidad'=>$calidad,
            'fechaentrega'=>$fechaentrega,
            'actividad'=>$actividad,
            'market'=>$market,
        );
        $this->db->where('fk_object', $fk_object);
        $this->db->update('llx_cust_detalles_proveedores_extrafields', $data);
    }*/

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

    //replace客户细节
    //不存在则添加，存在则更新
    public function replace_detail_client($fk_object,$areadeventa,$formatienda,$volumenventamensual,$frecuenciacompra,$implortedecompras,$pagopuntualidad,$leatalddelcliente){
        $data = array(
            'fk_object' => $fk_object,
            'areadeventa' => $areadeventa,
            'formatienda'=>$formatienda,
            'volumenventamensual'=>$volumenventamensual,
            'frecuenciacompra'=>$frecuenciacompra,
            'implortedecompras'=>$implortedecompras,
            'pagopuntualidad'=>$pagopuntualidad,
            'leatalddelcliente'=>$leatalddelcliente,
        );
        $query = $this->db->get_where('llx_cust_detallescliente_extrafields', array('fk_object' => $fk_object));
        if($query->result_array()==null){//不存在则添加
            $this->db->insert('llx_cust_detallescliente_extrafields',$data);//增加修改记录
        }
        else{//存在则更新
            $this->db->where('fk_object', $fk_object);
            $this->db->update('llx_cust_detallescliente_extrafields', $data);
        }
    }



}