<?php
    class Products_model extends CI_Model{
        //用来处理创建产品时的厂家价格类

        public function __construct()
        {
            $this->load->database();
            $this->load->library('session');
            $this->load->model('Fournisseur_product_model');
            $this->load->helper('url');
        }
        /************************************/
        /*获得产品信息*/
        public function get_rowid_by_ref($ref){
            /*$query = $this->db->get_where('llx_product', array('ref' => $ref));
            foreach($query->result_array() as $un_product){
            }
            return $un_product['rowid'];*/
            $this->db->select("rowid");
            $this->db->from("llx_product");
            $this->db->where('ref',$ref);
            $query=$this->db->get();
            if($query->num_rows() == 0){
                return -1;
            }
            foreach($query->result_array() as $value){
            }
            return $value['rowid'];
        }
        public function get_rowid_by_barcode($barcode=NULL){
            /*$query = $this->db->get_where('llx_product', array('ref' => $ref));
            foreach($query->result_array() as $un_product){
            }
            return $un_product['rowid'];*/
            if($barcode==NULL){
                return -1;
            }
            $this->db->select("rowid");
            $this->db->from("llx_product");
            $this->db->where('barcode',$barcode);
            $query=$this->db->get();
            if($query->num_rows() == 0){
                return -1;
            }
            foreach($query->result_array() as $value){
            }
            return $value['rowid'];
        }
        public function get_ref_by_rowid($rowid){
            $query = $this->db->get_where('llx_product', array('rowid' => $rowid));
            foreach($query->result_array() as $un_product){
            }
            return $un_product['ref'];
        }
        //通过产品ref获得条码
        //如果没有查找到产品则返回null
        public function get_ref_by_barcode($barcode){
            $this->db->select('ref');
            $this->db->from('llx_product p');
            $this->db->where('p.barcode',$barcode);
            $query=$this->db->get();
            $result=$query->result_array();
            if($result==null){
                return null;
            }
            else{
                return $result[0]['ref'];
            }
        }
        public function get_all_products(){
            $query=$this->db->get('llx_product');
            return $query->result_array();
        }
        //获得产品基本信息
        public function get_product_basic_info($rowid){
            $this->db->select("llx_product.rowid, llx_product.ref, llx_product.label, llx_product.description, llx_product.price, llx_product.price_ttc, llx_product.tva_tx, llx_product.pmp");
            $this->db->from("llx_product");
            $this->db->join('llx_product_extrafields pe','pe.fk_object=llx_product.rowid','left'); //extrafields
            $this->db->join('llx_c_country cc','cc.rowid=llx_product.fk_country','left'); //产地国
            $this->db->join('llx_brand brand','brand.rowid=pe.brand','left');

            $this->db->where('llx_product.rowid',$rowid);
            $query=$this->db->get();

            return $query->result_array();
        }
        public function get_products_by_rowid($rowid=false){
            //$query = $this->db->get_where('llx_product', array('ref' => $ref));
            $this->db->select("p.rowid, p.ref, p.label, p.description, p.price, p.tva_tx,
                               p.datec, p.tms,
                               p.stock, p.note");
            $this->db->from("llx_product p");
            $this->db->where('p.rowid',$rowid);
            $query=$this->db->get();

            return $query->result_array();
        }

        //用于检查价格(含增值税),和税率是否被改变(没有被改变则不添加价格记录)
        public function get_product_price_by_rowid($rowid=false){
            //$query = $this->db->get_where('llx_product', array('ref' => $ref));
            $this->db->select("llx_product.price_ttc, llx_product.tva_tx");
            $this->db->from("llx_product");
            $this->db->where('llx_product.rowid',$rowid);
            $query=$this->db->get();
            return $query->result_array();
        }
        //用于ajax检查ref是否重复
        public function get_products_by_ref($ref=false){

            //$query = $this->db->get_where('llx_product', array('ref' => $ref));
            $this->db->select("llx_product.rowid");
            $this->db->from("llx_product");
            //$this->db->join('llx_product_extrafields','llx_product_extrafields.fk_object=llx_product.rowid','left'); //extrafields
            $this->db->where('llx_product.ref',$ref);
            $query=$this->db->get();

            return $query->result_array();
        }
        //用于ajax检查条形码是否重复
        public function get_products_by_barcode($barcode){
            $this->db->select("llx_product.rowid");
            $this->db->from("llx_product");
            //$this->db->join('llx_product_extrafields','llx_product_extrafields.fk_object=llx_product.rowid','left'); //extrafields
            $this->db->where('llx_product.barcode',$barcode);
            $query=$this->db->get();

            return $query->result_array();
        }

        //获得产品总数：用于分页
        public function count_products(){
            $query = $this->db->query('SELECT rowid FROM llx_product');
            return $query->num_rows();
        }
        //获得分页的产品
        public function fetch_product($limit,$offset,$categ_id=null){
            $ref=$this->input->get('ref');
            $this->db->limit($limit,$offset);
            $this->db->select("p.rowid, p.ref, p.label, p.description, p.price");
            $this->db->from("llx_product p");
            $this->db->like("p.ref",$ref);
            $this->db->order_by("p.rowid", "desc");
            //$this->db->join('llx_categorie_product cp','cp.fk_product=p.rowid','left'); //标签-产品关系
            //$this->db->join('llx_categorie c','c.rowid=cp.fk_categorie and c.fk_parent=0','left'); //标签
            //$this->db->join('llx_categorie_lang cl','cl.fk_category=c.rowid and cl.lang="zh_CN"','left'); //标签翻译
            $query=$this->db->get();
            $result=$query->result_array();

            return $result;
        }

        public function get_products_by_ref_like(){
            $ref=$this->input->post('ref');
            //$query = $this->db->get_where('llx_product', array('ref' => $ref));
            $this->db->select("*");
            $this->db->from("llx_product");
            $this->db->where("tosell=1");//是可销售和可采购的产品
            $this->db->where("tobuy=1");
            $this->db->like("ref",$ref);
            $this->db->order_by("llx_product.rowid", "desc");
            $query=$this->db->get();

            return $query->result_array();
        }

        //通过标签查询产品
        /*
        public function get_products_by_categ($categ_rowid){
            //$query = $this->db->get_where('llx_product', array('ref' => $ref));
            $this->db->select("llx_product.rowid, llx_product.ref, llx_product.barcode, llx_product.label, llx_product.description, llx_product.price,
                                llx_product.price_min, llx_product.price_min_ttc, llx_product.cost_price, llx_product.note,
                               llx_product.weight, llx_product.volume, ");
            $this->db->from("llx_product,llx_categorie_product");
            $this->db->join('llx_product_extrafields','llx_product_extrafields.fk_object=llx_categorie_product.fk_product','left'); //extrafields
            $this->db->where('llx_categorie_product.fk_product=llx_product.rowid');
            $this->db->where('llx_categorie_product.fk_categorie',$categ_rowid);
            $this->db->where("tosell=1");//是可销售和可采购的产品
            $this->db->where("tobuy=1");
            $this->db->order_by("llx_product.rowid", "desc");
            $query=$this->db->get();
            return $query->result_array();
        }*/

        /*添加或者更新产品*/
        //rowid==null时则添加产品，不为null时则更新该rowid产品 !!
        public function replace_product($rowid=null){
            $price=$this->input->post('price');//因为价格基准是含增值税，所以这里输入的价格是税后价格
            $tva_tx=$this->input->post('tva_tx');

            //获取当前时间，插入数据库时需要
            $tms=date("Y-m-d h:i::sa");
            $surface=$this->input->post('long')*$this->input->post('wide');
            $volume=$this->input->post('hight')*$surface;
            $data = array(
                'ref' => $this->input->post('ref'),
                'label' => $this->input->post('label'),
                'description'=>$this->input->post('description'),
                'price'=>$price,
                'tva_tx'=>$tva_tx,
                'stock'=>$this->input->post('stock'),
                'note'=>$this->input->post('note'),
            );
            if($rowid==null) {
                $data['datec']=$tms;//创建时间只有在创建产品的时候才会记录
                //$data['fk_user_author']=$_SESSION['rowid'];//是哪个用户创建的
                //$data['fk_user_modif']=$_SESSION['rowid'];//是哪个用户改变的
                $this->db->insert('llx_product', $data);
                $id=$this->db->insert_id();//获得刚刚添加的产品的id
            }
            else{
                $this->db->where('rowid', $rowid);
                //$data['fk_user_modif']=$_SESSION['rowid'];//是哪个用户改变的
                $this->db->update('llx_product', $data);
                $id=$rowid;//这里用id就是rowid，加id来区分目的是区分rowid之前是不是null
            }

            return $id;

        }

        //添加多语言 在replace产品函数里使用
        public function add_lang($rowid,$id,$lang,$label,$description,$material,$function,$color,$caution,$ingredient){
            $data = array(
                'fk_product' => $id,
                'lang'=>$lang,
                'label'=>$this->input->post($label),
                'description'=>$this->input->post($description),
                'custommaterial'=>$this->input->post($material),
                'customfunction'=>$this->input->post($function),
                'customcolor'=>$this->input->post($color),
                'customprecautions'=>$this->input->post($caution),
                'customcomposition'=>$this->input->post($ingredient),

            );
            if($rowid==null||$this->get_lang_by_product_id($id,$lang)==null) {
                $this->db->insert('llx_product_lang', $data);
            }
            else{
                //如果本来没有也要添加

                $this->db->where('fk_product', $id);
                $this->db->where('lang="'.$lang.'"');
                $this->db->update('llx_product_lang', $data);
            }
        }
        //在导入Excel时使用, 不用post传值
        public function add_lang_import_excel($rowid,$id,$lang,$label,$description,$material,$function,$color,$caution,$ingredient){
            if($label==null){
                $label="";
            }
            if($description==null){
                $description="";
            }
            if($material==null){
                $material="";
            }
            if($function==null){
                $function="";
            }
            if($color==null){
                $color="";
            }
            if($caution==null){
                $caution="";
            }
            if($ingredient==null){
                $ingredient="";
            }
            $data = array(
                'fk_product' => $id,
                'lang'=>$lang,
                'label'=>$label,
                'description'=>$description,
                'custommaterial'=>$material,
                'customfunction'=>$function,
                'customcolor'=>$color,
                'customprecautions'=>$caution,
                'customcomposition'=>$ingredient,
            );
            if($rowid==null) {
                $this->db->insert('llx_product_lang', $data);
            }
            else{
                $this->db->where('fk_product', $id);
                $this->db->where('lang="'.$lang.'"');
                $this->db->update('llx_product_lang', $data);
            }
        }
        //查找该产品多语言是否存在
        public function get_lang_by_product_id($fk_product,$lang){
            $this->db->select("llx_product_lang.rowid");
            $this->db->from("llx_product_lang");
            $this->db->where('llx_product_lang.fk_product',$fk_product);
            $this->db->where('llx_product_lang.lang',$lang);
            $query=$this->db->get();

            return $query->result_array();
        }


        //用rowid号删除整个产品
        public function delete_by_rowid($rowid){
            //获得该产品的ref
            $ref=$this->get_ref_by_rowid($rowid);//要先获得ref，不然删了就不能获得了
            //删掉供应商的价格
            $this->Fournisseur_product_model->delete_product_fournisseur_price($rowid);

            //删掉产品的categorie关系
            $this->db->delete('llx_categorie_product',array('fk_product'=>$rowid));
            $this->db->delete('llx_product_price', array('fk_product' => $rowid));//需要先删掉价格
            $this->db->delete('llx_product_lang',array('fk_product'=>$rowid));//删掉多语言
            $this->db->delete('llx_product', array('rowid' => $rowid));  // Produces: // DELETE FROM llx_product  // WHERE rowid = $rowid
            //删掉图片
            $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref;
            $photos=get_photo_list($dir);
            if($photos!=NULL) {
                foreach ($photos as $name){
                    unlink($dir.'/'.$name);
                }
            }
            //删掉产品的extrafield
            $this->db->delete('llx_product_extrafields',array('fk_object'=>$rowid));
        }
        //删除多个产品
        public function delete_proudcts(){
            $products=$this->input->post('product_check_box');
            if($products!=null) {
                foreach ($products as $value) {
                    echo " ".$value." ";
                    $this->delete_by_rowid($value);
                }
            }
        }

        //删除产品的标签
        public function delete_categ_product($fk_categorie,$fk_product){
            $this->db->where('fk_categorie',$fk_categorie);
            $this->db->where('fk_product',$fk_product);
            $this->db->delete('llx_categorie_product');
            /*
            $sql = "DELETE FROM `llx_categorie_product`
                    WHERE `llx_categorie_product`.`fk_categorie` = ?
                    ";
            $this->db->query($sql, array($fk_categorie));
            */

        }


        /************************************/

        //获得可选的增值税列表
        public function get_available_tva(){
            //获得系统设置的国家
            $this->db->select("fk_country");
            $this->db->from("llx_company");
            $this->db->where('rowid',$_SESSION['company_id']);
            $query=$this->db->get();
            $fk_country=$query->result_array()[0]['fk_country'];
            //echo $fk_country;
            $this->db->select("taux");
            $this->db->from("llx_c_tva");
            $this->db->where("fk_pays",$fk_country);
            $query=$this->db->get();
            //print_r($query->result_array());
            return $query->result_array();
        }



        //关于categorie
        //替换标签(如果存在则替换，不存在则添加)
        public function replace_categ($rowid,$fk_categorie){
            $data = array(
                'fk_categorie' => $fk_categorie,
                'fk_product'  => $rowid,
            );
            $this->db->replace('llx_categorie_product', $data);
            // Executes: REPLACE INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
        }
        //删除该产品已选的所有标签
        public function delete_all_categ($rowid){
            $this->db->where('fk_product',$rowid);
            $this->db->delete('llx_categorie_product');
        }

        //通过categ名字获得categ的rowid
        public function get_id_categ($nom){
            $this->db->select("rowid");
            $this->db->from("llx_categorie");
            $this->db->where('label',$nom);
            $this->db->where('type',0);
            $query=$this->db->get();
            $rowid=null;
            foreach ($query->result_array() as $value){
                $rowid=$value['rowid'];
            }
            return $rowid;
        }
        //获得该产品已选择的父类categorie
        public function get_product_categ_pere($rowid){
            /*if($_SESSION['language']=='chinese'){
                $sql = "SELECT llx_categorie.rowid, llx_categorie_lang.label,fk_product
                    FROM llx_categorie,llx_categorie_product 
                    LEFT JOIN llx_categorie_lang ON llx_categorie_product.fk_categorie=llx_categorie_lang.fk_category
                    WHERE llx_categorie_product.fk_product=?
                    and llx_categorie.rowid=llx_categorie_product.fk_categorie
                    and llx_categorie.fk_parent=0
                    and lang='zh_CN'";
            }
            else {
                $sql = "SELECT llx_categorie.rowid, llx_categorie.label ,fk_product 
                    FROM llx_categorie,llx_categorie_product 
                    WHERE llx_categorie_product.fk_product=?
                    and llx_categorie.rowid=llx_categorie_product.fk_categorie
                    and llx_categorie.fk_parent=0";
            }*/
            //不导出多语言
            $sql = "SELECT llx_categorie.rowid, llx_categorie.label ,fk_product 
                    FROM llx_categorie,llx_categorie_product 
                    WHERE llx_categorie_product.fk_product=?
                    and llx_categorie.rowid=llx_categorie_product.fk_categorie
                    and llx_categorie.fk_parent=0";
            $query = $this->db->query($sql, array($rowid));
            return $query->result_array();
        }
        //获得该产品已选的子类categ
        public function get_product_sous_categ($rowid,$lang=null){
            $this->db->select("c.label");
            $this->db->from("llx_categorie_product cp");
            if($lang!=null){
                $this->db->from("llx_categorie_lang c, llx_categorie ctg");
                $this->db->where("c.fk_category=cp.fk_categorie");
                $this->db->where("c.fk_category=ctg.rowid");
                $this->db->where("ctg.fk_parent<>0");
                $this->db->where("c.lang",$lang);
            }
            else{
                $this->db->from("llx_categorie c");
                $this->db->where("c.fk_parent<>0");
                $this->db->where("c.rowid=cp.fk_categorie");
            }
            $this->db->where("cp.fk_product",$rowid);
            $query=$this->db->get();
            $result=$query->result_array();
            if($result!=null){
                echo $result[0]['label'];
                return $result[0]['label'];
            }
            return null;
        }

        //获得该产品已选择的所有categorie
        public function get_product_categ($rowid){
            if($_SESSION['language']=='chinese'){
                $sql = "SELECT llx_categorie.rowid, llx_categorie_lang.label, fk_product 
                    FROM llx_categorie,llx_categorie_product 
                    LEFT JOIN llx_categorie_lang ON llx_categorie_product.fk_categorie=llx_categorie_lang.fk_category
                    WHERE llx_categorie_product.fk_product=?
                    and llx_categorie.rowid=llx_categorie_product.fk_categorie
                    and llx_categorie_lang.lang='zh_CN'";
            }
            else {
                $sql = "SELECT llx_categorie.rowid, llx_categorie.label, fk_product 
                    FROM llx_categorie,llx_categorie_product 
                    WHERE llx_categorie_product.fk_product=?
                    and llx_categorie.rowid=llx_categorie_product.fk_categorie";
            }
            $query = $this->db->query($sql, array($rowid));
            return $query->result_array();
        }
        //获得所有的父类categorie
        public function get_pere_categ(){
            if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
                $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
                $this->db->where('type', 0);
                $this->db->where('lang', 'zh_CN');
                $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
                $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
            }
            else {
                $this->db->select('rowid,label');
                $this->db->where('type', 0);
                $query = $this->db->get_where('llx_categorie', array('fk_parent' => '0'));
            }
            return $query->result_array();
        }
        //获得全部子类categorie
        public function get_all_enfant_categ(){
            if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
                $this->db->select('llx_categorie.rowid, llx_categorie_lang.label');
                $this->db->where('type', 0);
                $this->db->where('lang', 'zh_CN');
                $this->db->join('llx_categorie_lang', 'llx_categorie_lang.fk_category = llx_categorie.rowid', 'left');
                $query = $this->db->get_where('llx_categorie', array('fk_parent<>0'));
            }
            else {
                $this->db->select('rowid,label');
                $this->db->where('type', 0);
                $query = $this->db->get_where('llx_categorie', array('fk_parent<>0'));
            }
            return $query->result_array();
        }

        //获得该产品所有子类可选的categorie
        //select rowid, entity, fk_parent, label, type..
        public function get_enfant_categ($rowid){
            if($_SESSION['language']=='chinese') { //中文的情况下，显示lang表格里的中文
                $sql = "SELECT llx_categorie.rowid,llx_categorie_lang.label,fk_product
                    FROM (llx_categorie,llx_categorie_product)
                    LEFT JOIN llx_categorie_lang ON llx_categorie.rowid=llx_categorie_lang.fk_category
                    WHERE llx_categorie_product.fk_product=? 
                    and llx_categorie.fk_parent=llx_categorie_product.fk_categorie 
                    and lang='zh_CN'";
            }
            else {
                $sql = "SELECT llx_categorie.rowid,llx_categorie.label,fk_product
                    FROM llx_categorie,llx_categorie_product 
                    WHERE llx_categorie_product.fk_product=? 
                    and llx_categorie.fk_parent=llx_categorie_product.fk_categorie ";
            }
            $query = $this->db->query($sql, array($rowid));
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

        //获得国家列表
        public function get_list_country(){
            $this->db->select("rowid rowid,label label");
            $this->db->from("llx_c_country");
            $this->db->where("active=1");
            $this->db->order_by("rowid", "desc");
            $query=$this->db->get();
            return $query->result_array();
        }
        //通过国家名字获得国家id
        public function get_country_by_name($name){
            $query = $this->db->get_where('llx_c_country', array('label' => $name));
            $resultat=$query->result_array();
            if($resultat==null){
                return null;
            }
            foreach($resultat as $value){
            }
            return $value['rowid'];
        }

        //获得品牌列表
        public function get_brand(){
            $this->db->select("b.rowid rowid, b.label label");
            $this->db->from("llx_brand b");
            $this->db->order_by("b.rowid", "desc");
            $query=$this->db->get();
            return $query->result_array();
        }
        //添加品牌
        public function add_brand($label=null){
            if($label==""){
                return "不能添加空白";
            }
            $label = strtoupper($label);
            $data = array(
                'label' => $label,
            );
            $this->db->insert('llx_brand', $data);
        }
        public function get_brand_id_by_name($name){
            $query = $this->db->get_where('llx_brand', array('label' => $name));
            $resultat=$query->result_array();
            if($resultat==null){
                return null;
            }
            foreach($resultat as $value){
            }
            return $value['rowid'];
        }

        //获得产品库存
        //输入产品id和仓库id
        //返回该仓库产品库存
        public function get_product_stock($rowid_product,$rowid_warehouse){
            $this->db->select("ps.reel");
            $this->db->from("llx_product_stock ps");
            $this->db->where('fk_product',$rowid_product);
            $this->db->where('fk_entrepot',$rowid_warehouse);
            $query=$this->db->get();
            foreach($query->result_array() as $value);
            return $value['reel'];
        }

        //增加或减去产品库存
        //产品id, 仓库id, 减去数量int, 数量(负数为减，正数为加), 类型
        public function modify_product_stock($rowid_product,$rowid_warehouse,$amount,$type){
            $tms=date("Y-m-d h:i::sa");
            $stock=$this->get_product_stock($rowid_product,$rowid_warehouse);//获得该产品在该仓库库存
            $stock=$stock+$amount;
            $data = array(
                'reel'=>$stock,
                'tms'=>$tms,
            );
            $this->db->where('fk_product', $rowid_product);
            $this->db->where('fk_entrepot',$rowid_warehouse);
            $this->db->update('llx_product_stock', $data);

        }

        //获得产品在已验证供应商订单里的数量 ==指的是已验证，但是还没交货 //计算虚拟库存时用到
        public function get_total_qty_fourni($fk_product){
            $qty_fourni=0;
            $this->db->select('IFNULL(sum(cfd.qty),0) as qty_total');
            //$this->db->select('cf.ref, cf.rowid,  cfd.qty as qty_total');
            $this->db->from('llx_commande_fournisseur cf, llx_commande_fournisseurdet cfd');
            $this->db->where('(cf.fk_statut=2 OR cf.fk_statut=3)'); //是已验证的订单或者已下订单订单  用or语句记得加括号
            $this->db->where('cfd.fk_commande=cf.rowid');
            $this->db->where('cfd.fk_product',$fk_product);
            $this->db->group_by("cfd.fk_product");//这个语句可能会引发问题
            $query=$this->db->get();
            $resultat=$query->result_array();
            foreach($resultat as $value){
                $qty_fourni=$value['qty_total'];
                //echo "<br>ref: ".$value['ref']."----->rowid_commande: ".$value['rowid']."---->qty: ".$value['qty_total']."<br>";
            }
            return $qty_fourni;
        }

        //获得产品虚拟库存
        public function get_virtuel_stock($fk_product){
            //获得产品实际库存
            $stock_reel=0;
            $this->db->select('IFNULL(stock, 0) as stock');
            $this->db->from('llx_product p');
            $this->db->where('p.rowid',$fk_product);
            $query=$this->db->get();
            $resultat=$query->result_array();
            foreach($resultat as $value){
                $stock_reel=$value['stock'];
            }
            //echo $stock_reel;

            $qty_commande=0;
            //获得产品在已验证用户订单里的数量 ==指的是已验证，但是还没交货
            $this->db->select('IFNULL(sum(cd.qty),0) as qty_total');
            $this->db->from('llx_commande c, llx_commandedet cd');
            $this->db->where('c.fk_statut=1'); //是已验证的订单
            $this->db->where('cd.fk_commande=c.rowid');
            $this->db->where('cd.fk_product',$fk_product);
            $this->db->group_by("cd.fk_product");//这个语句可能会引发问题
            $query=$this->db->get();
            $resultat=$query->result_array();
            foreach($resultat as $value){
                $qty_commande=$value['qty_total'];
            }
            //echo "<br>";
            //echo $qty_commande;

            //获得产品在已验证供应商订单里的数量 ==指的是已验证，但是还没交货
            $qty_fourni=0;
            $qty_fourni=$this->get_total_qty_fourni($fk_product);

            //echo "<br>";
            //echo $qty_fourni;
            //echo "<br>";

            $qty_virtuel=$stock_reel-$qty_commande+$qty_fourni;
            //echo $qty_virtuel;

            return $qty_virtuel;

        }

        //获得产品在时间区间内的总销量
        public function get_product_sales_by_date($start_time, $end_time, $fk_product){
            $this->db->select('sum(fd.qty) as total_qty');
            $this->db->from('llx_facture f, llx_facturedet fd, llx_product p');
            $this->db->where('f.rowid=fd.fk_facture');
            $this->db->where('fd.fk_product',$fk_product);
            $this->db->where('p.rowid=fd.fk_product');
            $this->db->where('f.datef >=',$start_time);
            $this->db->where('f.datef <=',$end_time);
            $this->db->where('f.fk_statut<>0');
            $this->db->where('f.fk_statut<>3');

            $this->db->group_by("p.rowid");//这个语句可能会引发问题
            $this->db->order_by("total_qty", "DESC");
            $query=$this->db->get();

            $resultat=$query->result_array();
            if($resultat==NULL){
                return NULL;
            }
            return $resultat[0]['total_qty'];
        }

        /****Excel*****/
        //获得仓库列表
        public function get_entrepot(){
            $query=$this->db->get('llx_entrepot');
            return $query->result_array();
        }
        //获得产品类别
        public function get_categ(){
            $this->db->select('rowid, label, description, fk_parent');
            $this->db->from('llx_categorie c');
            $this->db->order_by("fk_parent", "asc");
            $query=$this->db->get();
            return $query->result_array();
        }
        //通过categ名称获得categ id
        public function get_categ_id_by_name($name){
            //先查找不是不是多语言的标签表，看能不能找到
            $query = $this->db->get_where('llx_categorie', array('label' => $name));
            if($query->result_array()!=null){//如果没有找到标签
                foreach($query->result_array() as $value){}
                //echo $value['rowid']."//";
                return $value['rowid'];
            }
            //如果不能找到，则查找多语言
            $query = $this->db->get_where('llx_categorie_lang', array('label' => $name));
            if($query->result_array()==null)//如果没有找到标签
                return null;
            foreach($query->result_array() as $value){
            }
            return $value['fk_category'];
        }

        ////获得该产品已选择的父类categorie或子类categorie //导出产品库存用
        public function get_product_categ_by_type($fk_product,$type){
            //type=0 => 导出父类   type=1 => 导出子类
            $resultat=array();
            $this->db->select('c.rowid, c.label');
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
                return $resultat;
            }
            return $resultat;
        }

        //获得全部产品的全部信息 //导出Excel的时候使用
        public function get_all_products_with_all_info(){
            $this->db->select("llx_product.rowid, llx_product.ref, llx_product.label, llx_product.description, llx_product.price,
                               llx_product.cost_price, llx_product.note,
                               llx_product.length, llx_product.surface,
                               llx_product.weight, llx_product.volume, llx_product.weight_units, 
                               llx_product.barcode, llx_product.fk_barcode_type,
                               ");
            $this->db->from("llx_product");
            $this->db->join('llx_product_extrafields','llx_product_extrafields.fk_object=llx_product.rowid','left'); //extrafields
            //$this->db->join('llx_brands','llx_brands.rowid=llx_product_extrafields.brand','left'); //brands
            /*$this->db->join('llx_cust_detallesbox_extrafields db','llx_product.rowid=db.fk_object','left'); //sku pack 包细节
            $this->db->join('llx_cust_detallespack_extrafields dp','llx_product.rowid=dp.fk_object','left'); //sku box 箱细节
            $this->db->join('llx_cust_bigbox_extrafields bb','llx_product.rowid=bb.fk_object','left'); //sku box 运输箱细节
            $this->db->join('llx_cust_notasextra_extrafields notas','llx_product.rowid=notas.fk_object','left'); //sku box 运输箱细节*/
            //$this->db->join('llx_cust_precios_competencia_extrafields pc','llx_product.rowid=pc.fk_object','left'); //竞争对手售价 这个用ajax来获得值
            //存在超过一条对应产品的信息时，需要用ajax来取值，不然会重复输出
            $this->db->where("tosell=1");//是可销售和可采购的产品
            $this->db->where("tobuy=1");
            $this->db->where('llx_product.datec >=',$this->input->post('start_time'));
            $this->db->where('llx_product.datec <=',$this->input->post('end_time'));
            $query=$this->db->get();
            return $query->result_array();

        }
        //导出产品信息excel
        public function export_products(){
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

            $products=$this->get_all_products_with_all_info();
            // Add some data
            echo date('H:i:s') , " Add some data" , EOL;
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);//设置宽度

            $i=65;//大写字母A的ASCII码
            //如果没选photo的CheckBox才会显示
            if($this->input->post('photo')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('photo'));
                $i=$i+1;
            }
            if($this->input->post('ref')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('num_ref'));
                $i=$i+1;
            }
            if($this->input->post('label')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('label'));
                $i=$i+1;
            }
            if($this->input->post('description')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('description'));
                $i=$i+1;
            }
            if($this->input->post('barcode')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('barcode_type'));
                $i=$i+1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('barcode'));
                $i=$i+1;
            }
            if($this->input->post('price')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($i).'1', lang('price'));
                $i=$i+1;
            }
            /*
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($i).'1', lang('num_ref'))
                ->setCellValue(chr($i).'1', lang('label'))
                ->setCellValue(chr($i).'1', lang('barcode_type'))
                ->setCellValue(chr($i).'1', lang('barcode'))
                ->setCellValue('F1', lang('price'))
                ->setCellValue('G1', lang('cost_price'))
                ->setCellValue('H1', lang('coste_embalaje_del_producto'))
                /*->setCellValue('E1', lang('supplier'))
                ->setCellValue('E1', lang('suppliers_product_ref'))
                ->setCellValue('E1', lang('suppliers_price'))
                ->setCellValue('E1', lang('tva_tx'))
                ->setCellValue('E1', lang('delivery_time_days'))
                ->setCellValue('E1', lang('minimum_qty'))
                ->setCellValue('I1', lang('long'))
                ->setCellValue('J1', lang('wide'))
                ->setCellValue('K1', lang('hight'))
                ->setCellValue('L1', lang('weight'))
                ->setCellValue('M1', lang('forma_de_presentacion'))
                ->setCellValue('N1', lang('material'))
                ->setCellValue('O1', lang('coste_de_embalaje'))
                ->setCellValue('P1', lang('color'))
                ->setCellValue('Q1', lang('propiedad'))
                ->setCellValue('R1', lang('efecto'))
                ->setCellValue('S1', lang('tipoacabado'))
                ->setCellValue('T1', lang('note'))
            ;*/

            $i=2;
            foreach ($products as $value){
                $askii=65;
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(120);//设置高度
                if($this->input->post('photo')!='on') {
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
                        //$objWriter->save('documents/excel/format_basic.xlsx');
                        //$objDrawing->setPath('file:///var/www/html/documents/produit/' . $value['ref'] . "/" . $photo);
                        $objDrawing->setHeight(157);
                        //$objDrawing->setWidth(70);
                        $objDrawing->setCoordinates('A' . $i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                    } else {
                        /*本来想显示一个表示没图片的图片，但好像有点多余
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('avatar');
                        $objDrawing->setDescription('avatar');
                        //$objDrawing->setPath('file:///Applications/XAMPP/xamppfiles/htdocs/GCCBM-mobi/img/test.png');
                        $objDrawing->setPath('file:///Applications/XAMPP/xamppfiles/htdocs/GCCBM-mobi/assets/img/nophoto.png' );
                        $objDrawing->setHeight(20);
                        //$objDrawing->setWidth(70);get_available_tva
                        $objDrawing->setCoordinates('A'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        */
                    }
                }
                //插入产品信息
                if($value['fk_barcode_type']==6)
                    $barcode_type = 'Code 128';
                else if($value['fk_barcode_type']==2)
                    $barcode_type ='EAN13';
                else if($value['fk_barcode_type']==1)
                    $barcode_type ='EAN8';
                else
                    $barcode_type='unknow';
                $weight_units=null;
                if($value['weight_units']==0){
                    $weight_units='kg';
                }else if($value['weight_units']==-3){
                    $weight_units='g';
                }
                else
                    $weight_units=null;


                if($value['length']==0)
                    $width = 0;
                else
                    $width = number_format($value['surface']/$value['length'],3);

                if($value['length']==0)
                    $length = 0;
                else
                    $length = number_format($value['surface']/$value['length'],3);

                if($value['surface']==0)
                    $height = 0;
                else
                    $height = number_format($value['volume']/$value['surface'],3);
                /*$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$i, $value['ref'])
                    ->setCellValue('C'.$i, $value['label'])
                    ->setCellValue('D'.$i, $barcode_type)
                    ->setCellValue('E'.$i, $value['barcode'])
                    ->setCellValue('F'.$i, $value['price'])
                    ->setCellValue('G'.$i, $value['cost_price'])
                    /*->setCellValue('H'.$i, $value['cajaembajale'])
                    ->setCellValue('I'.$i, $length)
                    ->setCellValue('J'.$i, $width)
                    ->setCellValue('K'.$i, $height)
                    ->setCellValue('L'.$i, $value['weight'].$weight_units)
                    ->setCellValue('M'.$i, $value['forma_de_presentacion'])
                    ->setCellValue('N'.$i, $value['material'])
                    ->setCellValue('O'.$i, $value['costeembalajepack'])
                    ->setCellValue('P'.$i, $value['color'])
                    ->setCellValue('Q'.$i, $value['propiedad'])
                    ->setCellValue('R'.$i, $value['efecto'])
                    ->setCellValue('S'.$i, $value['tipoacabado'])
                    ->setCellValue('T'.$i, $value['note'])
                ;*/
                if($this->input->post('ref')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['ref']);
                    $askii=$askii+1;
                }
                if($this->input->post('label')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['label']);
                    $askii=$askii+1;
                }
                if($this->input->post('description')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['description']);
                    $askii=$askii+1;
                }
                if($this->input->post('barcode')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $barcode_type);
                    $askii=$askii+1;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['barcode']);
                    $askii=$askii+1;
                }
                if($this->input->post('price')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['price']);
                    $askii=$askii+1;
                }

                $i=$i+1;
                /*
                 llx_product.rowid, llx_product.ref, llx_product.label, llx_product.description, llx_product.price,
                               llx_product.cost_price, llx_product.note,
                               llx_product.length, llx_product.surface,
                               llx_product.weight, llx_product.volume, llx_product.weight_units,
                               llx_product.barcode, llx_product.fk_barcode_type,
                               llx_product_extrafields.brand as brand_rowid, llx_product_extrafields.cajaembajale as cajaembajale, llx_product_extrafields.instrucciones, llx_product_extrafields.precaucion,
                               llx_product_extrafields.forma_de_presentacion, llx_product_extrafields.material, llx_product_extrafields.cajaembajale, llx_product_extrafields.color, llx_product_extrafields.propiedad, llx_product_extrafields.efecto, llx_product_extrafields.tipoacabado,
                               llx_brands.label as brand_label,
                               db.box,db.refskubox,db.altobox,db.anchobox,db.largobox,db.pesobox,db.presentacionbox,db.materialbox, db.costeembalajebox, db.eanbox,db.colorbox, db.propiedadbox, db.efectobox, db.notasbox,
                               dp.pack,dp.refskupack,dp.altopack,dp.anchopack,dp.largopack,dp.pesopack,dp.presentacionpack,dp.materialpack, dp.costeembalaje as costeembalajepack, dp.eanpack,dp.colorpack, dp.propiedadpack, dp.efectopack, dp.notaspack,
                               bb.skubigbox as bigbox,bb.refskubigbox,bb.altobigbox,bb.anchobigbox,bb.largobigbox,bb.pesobigbox,bb.presentacionbigbox,bb.materialbigbox, bb.embalajebigbox as costeembalajebigbox, bb.eanbigbox,bb.colorbigbox, bb.propiedadbigbox, bb.efectobigbox, bb.notasbigbox,
                               notas.notasextra
                 */
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

        //获得产品库存信息
        public function get_products_stock($interval=null,$duration=null, $end_time=null){
            /*$this->db->select(" ps.fk_product product_rowid, p.label product_label, p.ref product_ref, p.description product_description, p.fk_barcode_type,
                                p.barcode, barcode, p.price, p.cost_price,
                                ps.reel stock,
                                e.rowid entrepot_rowid, e.label entrepot_label,
                                c.rowid categ_rowid, c.label categ_label
                               ");
            $this->db->from("llx_product_stock ps"); //product_stock是单个仓库的库存
            $this->db->join('llx_product p','p.rowid=ps.fk_product','left'); //products info
            $this->db->join('llx_product_extrafields pe','pe.fk_object=p.rowid','left'); //products extrafields
            $this->db->join('llx_entrepot e','ps.fk_entrepot=e.rowid','left'); //entrepot
            $this->db->join('llx_categorie_product cp','cp.fk_product=p.rowid','left'); //relation categ_product
            $this->db->join('llx_categorie c','c.rowid=cp.fk_categorie','left'); //categ

            //好像不需要时间
            //$this->db->where('ps.tms >=',$this->input->post('start_time'));
            //$this->db->where('ps.tms <=',$this->input->post('end_time'));
            $this->db->order_by("ps.fk_entrepot", "asc");
            $query=$this->db->get();
            return $query->result_array();*/

            //以上的是单个仓库的库存
            //现在只需要导出总库存，不需要知道仓库
            //获得产品的库存，销量
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

            $resultat=array();

            $this->db->select('sum(fd.qty) as total_qty, p.rowid as product_rowid, p.ref as product_ref, p.label product_label,
                               p.description as product_description, p.fk_barcode_type, p.barcode barcode, p.price_ttc as price,
                               p.stock, p.pmp, p.price_ttc, p.desiredstock, p.seuil_stock_alerte,
                               p.productlevel as nivel
                               ');
            $this->db->from('llx_facture f, llx_facturedet fd, llx_product p');
            $this->db->join('llx_product_extrafields pe','pe.fk_object=p.rowid','left'); //llx_product_extrafields
            $this->db->where('f.rowid=fd.fk_facture');
            $this->db->where('p.rowid=fd.fk_product');
            //$this->db->join('llx_user u','sc.fk_user=u.rowid','left'); //销售代表
            $this->db->where('f.datef >=',$start_time);
            $this->db->where('f.datef <=',$end_time);
            $this->db->where('f.fk_statut<>0');
            $this->db->where('f.fk_statut<>3');

            $this->db->group_by("p.rowid");//这个语句可能会引发问题
            $this->db->order_by("total_qty", "DESC");
            $query=$this->db->get();

            $resultat=$query->result_array();
            //获得标签
            foreach($resultat as &$value){
                //初始化。全部设为nul
                $value['entrepot_rowid']=NULL;
                $value['entrepot_label']="全部仓库";
                $value['main_categ_rowid']=NULL;
                $value['main_categ_label']=NULL;
                $value['sous_categ_rowid']=NULL;
                $value['sous_categ_label']=NULL;
                foreach ($this->get_product_categ_by_type($value['product_rowid'],0) as $categ){
                    $value['main_categ_rowid']=$categ['rowid'];
                    $value['main_categ_label']=$categ['label'];
                }
                foreach ($this->get_product_categ_by_type($value['product_rowid'],1) as $categ){
                    $value['sous_categ_rowid']=$categ['rowid'];
                    $value['sous_categ_label']=$categ['label'];
                }
                $value['stock_virtuel']=$this->get_virtuel_stock($value['product_rowid']);
            }
            return $resultat;
        }

        //导出产品库存excel
        public function export_products_stock(){
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

            //时间区间
            $interval=$this->input->post('interval');
            if($interval==0){
                $interval="day";
            }else if($interval==1){
                $interval="week";
            }else if($interval==2){
                $interval="month";
            }else if($interval==3){
                $interval="year";
            }
            //时间长度
            $duration=$this->input->post('duration');
            //结束时间
            $end_time=$this->input->post('end_time');


            $stocks=$this->get_products_stock();
            // Add some data
            echo date('H:i:s') , " Add some data" , EOL;
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);//设置宽度



            $askii=66;//大写字母A的ASCII码
            //如果没选photo的CheckBox才会显示


            if($this->input->post('ref')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', lang('ref'));
                $askii=$askii+1;
            }
            if($this->input->post('barcode')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', lang('barcode'));
                $askii=$askii+1;
            }
            if($this->input->post('label')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', lang('label'));
                $askii=$askii+1;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($askii).'1', "类别");
            $askii=$askii+1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($askii).'1', "小类别");
            $askii=$askii+1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($askii).'1', "产品级别");
            $askii=$askii+1;
            if($this->input->post('stock')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', "最小库存预警");
                $askii=$askii+1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', "最佳库存");
                $askii=$askii+1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', "实际库存");
                $askii=$askii+1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', "虚拟库存");
                $askii=$askii+1;
            }
            if($this->input->post('price')!='on'){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', "pmp");
                $askii=$askii+1;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($askii).'1', "销量");
            $askii=$askii+1;
            //需要显示几个周期
            for($times=0;$times<$duration;$times++){
                $start_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr($askii).'1', $start_time."--".$end_time);
                $askii=$askii+1;
                $end_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));
            }
            $end_time=$this->input->post('end_time');

            $i=2;
            $entrepot=$this->get_entrepot();
            $categ=$this->get_categ();
            /*
            foreach ($stocks as $key => $value) {
                if($value['entrepot_label'] == 'Pinto'){
                    unset($stocks[$key]);
                }
            }*/
            foreach ($stocks as $value){
                $askii=65;
                //$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(120);//设置高度

                //插入库存
                /*
                if($this->input->post('ref')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['ref']);
                    $askii=$askii+1;
                }
                if($this->input->post('label')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['label']);
                    $askii=$askii+1;
                }
                if($this->input->post('barcode')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $barcode_type);
                    $askii=$askii+1;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['barcode']);
                    $askii=$askii+1;
                }
                if($this->input->post('price')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['price']);
                    $askii=$askii+1;
                }
                if($this->input->post('cost_price')!='on'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr($askii).$i, $value['cost_price']);
                    $askii=$askii+1;
                }*/
                //为了知道选了什么类别的产品
                $flag_add=0;//为了防止一个产品有两个标签，显示两次   因为这里循环的是标签列表，如果一个产品包括两个标签，则会显示两次，这里只让他显示一次，如果匹配了其中一个标签，则break
                foreach($categ as $un_categ) {
                    if($flag_add==1)
                        break;
                    if ($this->input->post('categ_' . $un_categ['rowid']) == "on" && ($value['main_categ_rowid'] == $un_categ['rowid']||$value['sous_categ_rowid'] == $un_categ['rowid'])) {
                        //为了知道有什么仓库 被注释的代码可以知道选了哪个仓库，但是不需要显示仓库，只需要显示总的库存
                        /*foreach ($entrepot as $un_enctrepot) {
                            //只显示选择了要显示的仓库
                            if ($this->input->post('entrepot_' . $un_enctrepot['rowid']) == "on" && $value['entrepot_rowid'] == $un_enctrepot['rowid']) {
                                if ($value['fk_barcode_type'] == 6)
                                    $barcode_type = 'Code 128';
                                else if ($value['fk_barcode_type'] == 2)
                                    $barcode_type = 'EAN13';
                                else if ($value['fk_barcode_type'] == 1)
                                    $barcode_type = 'EAN8';

                                if ($this->input->post('ref') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['product_ref']);
                                    $askii = $askii + 1;
                                }
                                if ($this->input->post('barcode') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $barcode_type);
                                    $askii = $askii + 1;
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['barcode']);
                                    $askii = $askii + 1;
                                }
                                if ($this->input->post('label') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['product_label']);
                                    $askii = $askii + 1;
                                }
                                if ($this->input->post('description') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['product_description']);
                                    $askii = $askii + 1;
                                }
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue(chr($askii) . $i, $value['entrepot_label']);
                                $askii = $askii + 1;
                                if ($this->input->post('stock') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['stock']);
                                    $askii = $askii + 1;
                                }
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue(chr($askii) . $i, $value['categ_label']);
                                $askii = $askii + 1;
                                if ($this->input->post('price') != 'on') {
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue(chr($askii) . $i, $value['price']);
                                    $askii = $askii + 1;
                                }


                                $i = $i + 1;
                            }
                        }*/
                        $flag_add=1;//如果该产品大标签或小标签其中一个标签匹配，则只显示一次就够


                        //插入图片
                        $dir = "../" . $_SESSION['folder'] . "/documents/produit/" . $value['product_ref']."/thumbs/";
                        $photos = get_photo_list($dir);
                        if ($photos != NULL) {
                            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(160);//设置高度
                            $objDrawing = new PHPExcel_Worksheet_Drawing();
                            $objDrawing->setName('avatar');
                            $objDrawing->setDescription('avatar');
                            $objDrawing->setPath($_SESSION['path'] . $value['product_ref'] . "/thumbs/" . $photos[0]);
                            //$objDrawing->setPath('file:///var/www/html/documents/produit/' . $value['ref'] . "/" . $photo);
                            $objDrawing->setHeight(157);
                            //$objDrawing->setWidth(70);
                            $objDrawing->setCoordinates(chr($askii) . $i);
                            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        }
                        $askii = $askii + 1;


                        //显示总的库存
                        if ($this->input->post('ref') != 'on') {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['product_ref']);
                            $askii = $askii + 1;
                        }
                        if ($this->input->post('barcode') != 'on') {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['barcode']);
                            $askii = $askii + 1;
                        }
                        if ($this->input->post('label') != 'on') {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['product_label']);
                            $askii = $askii + 1;
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue(chr($askii) . $i, $value['main_categ_label']);
                        $askii = $askii + 1;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue(chr($askii) . $i, $value['sous_categ_label']);
                        $askii = $askii + 1;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue(chr($askii) . $i, $value['nivel']);
                        $askii = $askii + 1;
                        if ($this->input->post('stock') != 'on') {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['seuil_stock_alerte']);
                            $askii = $askii + 1;
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['desiredstock']);
                            $askii = $askii + 1;
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['stock']);
                            $askii = $askii + 1;
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['stock_virtuel']);
                            $askii = $askii + 1;
                        }
                        if ($this->input->post('price') != 'on') {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii) . $i, $value['pmp']);
                            $askii = $askii + 1;
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue(chr($askii) . $i, $value['total_qty']);
                        $askii = $askii + 1;

                        for($times=0;$times<$duration;$times++){
                            $start_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(chr($askii).$i, $this->get_product_sales_by_date($start_time,$end_time,$value['product_rowid']));
                            $askii=$askii+1;
                            $end_time=date('Y-m-d',strtotime("-1".$interval,strtotime($end_time)));
                        }
                        $end_time=$this->input->post('end_time');
                        $i = $i + 1;
                    }
                }

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

            // Echo memory usage
            echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


            // Echo memory peak usage
            echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

            // Echo done
            echo date('H:i:s') , " Done writing files" , EOL;
            echo 'Files have been created in ' , getcwd() , EOL;

            return $stocks;
        }

        /*导入产品，只导入部分信息*/
        public function import_product($ref,$label,$description,$barcode_type,$barcode,$intrastat,$price_ttc,$tva_tx){
            $price_ttc=$price_ttc;//因为价格基准是含增值税，所以这里输入的价格是税后价格
            $tva_tx=$tva_tx;
            if($tva_tx==null){
                $tva_tx=0;
            }
            $price=$price_ttc/(100+$tva_tx)*100;
            $price_base_type='TTC';//价格基准，含税

            $brand=null;
            //获取当前时间，插入数据库时需要
            $tms=date("Y-m-d h:i::sa");
            $data = array(
                'ref' => $ref,
                'label' => $label,
                'description'=>$description,
                'price'=>$price,
                'price_ttc'=>$price_ttc,
                //'cost_price'=>$cost_price,
                //'note'=>$this->input->post('note'),
                'length'=>0,
                'width'=>0,
                'height'=>0,
                'surface'=>0,
                'weight'=>0,
                'volume'=>0,
                'barcode'=>$barcode,
                'fk_barcode_type'=>$barcode_type,
                'fk_user_author'=>$_SESSION['rowid'],//是哪个用户创建的
                'fk_user_modif'=>$_SESSION['rowid'],

                //新添加的元素
                'brand' => $brand,
                'intrastat'=>$intrastat,

                //下面是没用到但是必填的信息
                'datec'=>$tms,
                'customcode'=>'',
                'tva_tx'=>$tva_tx,
                'duration'=>'',
                'accountancy_code_sell'=>'',
                'accountancy_code_buy'=>'',
                //'weight_units'=>$this->input->post('weight_units'), //重量的单位
                'surface_units'=>0,
                'volume_units'=>0,
                'canvas'=>'',
                'length_units'=>0
            );
            $this->db->insert('llx_product', $data);
            //还需要添加价格那一栏
            $id= $this->db->insert_id();//获得刚刚添加的产品的id

            $data = array(

                'price'=>$price,
                'price_ttc'=>$price,
                'fk_product'=>$id,

                //下面是没用到但是必填的信息
                'date_price'=>$tms,
                'price_min'=>0,
                'price_min_ttc'=>0,
                'tva_tx'=>0,
                'fk_user_author'=>$_SESSION['rowid'],

            );
            $this->db->insert('llx_product_price', $data);

            $brand=null;
            $size=null;
            $data = array(
                'fk_object' => $id,
            );
            $this->db->insert('llx_product_extrafields', $data);

        }
        /*导入产品的完整信息*/
        public function import_product_complete($ref,$label,$description,$barcode_type,$barcode,$intrastat,$suppliers_product_ref,$unitprice,$tva_tx_supplier,$quantity,$discount_supplier,$price_ttc,$tva_tx,$price_min_ttc,$seuil_stock_alerte,$desired_stock,$source_country,$brand,$size,$length,$width,$height,$weight,$color,$categ,
                                                $categ1,$categ2,$categ3,$categ4,$categ5,
                                                $barcode_pack,$pack,$barcode_box,$box,$barcode_bigbox,$bigbox,
                                                $material_es,$function_es,$caution_es,$ingredient_es){
            $error='';
            $price_ttc=$price_ttc;//因为价格基准是含增值税，所以这里输入的价格是税后价格
            $tva_tx=$tva_tx;
            if($tva_tx==null){
                $tva_tx=0;
            }
            $price=$price_ttc/(100+$tva_tx)*100;
            $price_base_type='TTC';//价格基准，含税

            $price_min_ttc=$price_min_ttc;//含增值税的最底售价
            $price_min=$price_min_ttc/(100+$tva_tx)*100;

            //获得产地国的rowid
            $fk_country=$this->get_country_by_name($source_country);



            //获取当前时间，插入数据库时需要
            $tms=date("Y-m-d h:i::sa");
            $surface=$length*$width;
            $volume=$height*$surface;
            //获得brand的rowid
            $brand_id=$this->get_brand_id_by_name($brand);
            $data = array(
                'ref' => $ref,
                'label' => $label,
                'description'=>$description,
                'price'=>$price,
                'price_ttc'=>$price_ttc,
                'tva_tx'=>$tva_tx,
                'price_min'=>$price_min,
                'price_min_ttc'=>$price_min_ttc,
                'price_base_type'=>$price_base_type,
                //'cost_price'=>$this->input->post('cost_price'),
                //'note'=>$this->input->post('note'),
                'fk_country'=>$fk_country,
                'length'=>$length,
                'width'=>$width,
                'height'=>$height,
                'surface'=>$surface,
                'weight_units'=>-3, //重量的单位g
                'weight'=>$weight,
                'volume'=>$volume,
                'barcode'=>$barcode,
                'fk_barcode_type'=>$barcode_type,
                'desiredstock'=>$desired_stock,//理想库存
                'seuil_stock_alerte'=>$seuil_stock_alerte,//最小库存预警
                'fk_user_author'=>$_SESSION['rowid'],//是哪个用户创建的
                'fk_user_modif'=>$_SESSION['rowid'],

                //新添加的信息
                'brand' => $brand_id,
                'intrastat'=>$intrastat,

                'pack'=>$pack,
                'box'=>$box,
                'bigbox'=>$bigbox,
                'barcode_pack'=>$barcode_pack,
                'barcode_box'=>$barcode_box,
                'barcode_bigbox'=>$barcode_bigbox,



                //下面是没用到但是必填的信息
                'datec'=>$tms,
                'customcode'=>'',
                'duration'=>'',
                'accountancy_code_sell'=>'',
                'accountancy_code_buy'=>'',
                'surface_units'=>0,
                'volume_units'=>0,
                'canvas'=>'',
                'length_units'=>0
            );
                $this->db->insert('llx_product', $data);
                $id=$this->db->insert_id();//获得刚刚添加的产品的id

            //更新价格信息
            $data = array(
                'price'=>$price,
                'price_ttc'=>$price_ttc,
                'tva_tx'=>$tva_tx,
                'price_min'=>$price_min,
                'price_min_ttc'=>$price_min_ttc,
                'price_base_type'=>$price_base_type,
                'fk_product'=>$id,

                //下面是没用到但是必填的信息
                'date_price'=>$tms,
                'fk_user_author'=>$_SESSION['rowid'],
            );

            //价格信息是没改变一次增加一行
            $this->db->insert('llx_product_price', $data);

            //更新extral_filed
            //如果创建产品时本身没有创建extrafield, 则创建新的extrafield
            $data = array(
                'fk_object' => $id,
            );
            //如果本身有创建这个信息，则更新
            $this->db->insert('llx_product_extrafields', $data);



            //添加产品--供应商价格(只在添加产品的时候使用，编辑产品的时候用ajax编辑)
            $fk_product=$id;
            $fk_soc=$this->input->post("fournisseur");//供应商在上传Excel之前用表单传值，因为特殊符号太多，不能加Excel的值验证
            $suppliers_product_ref=$suppliers_product_ref;
            $unitprice=$unitprice;
            $tva_tx_supplier=$tva_tx_supplier;
            $delivery_time_days=null;
            $quantity=$quantity;
            $discount_supplier=$discount_supplier;
            $error.=$this->Fournisseur_product_model->add_product_fournisseur_price_value($fk_product,$fk_soc,$suppliers_product_ref,$unitprice,$tva_tx_supplier,$delivery_time_days,$quantity,$discount_supplier);


            //更新标签 (先删除之前选择的所有标签，再重新添加标签，仅在更新产品时需要)
            $categ=$this->get_categ_id_by_name($categ);//先获得标签的id
            if($categ!=null){
                $this->replace_categ($id, $categ);
            }
            //小标签
            $categ1=$this->get_categ_id_by_name($categ1);//先获得标签的id
            if($categ1!=null){
                $this->replace_categ($id, $categ1);
            }
            $categ2=$this->get_categ_id_by_name($categ2);//先获得标签的id
            if($categ2!=null){
                $this->replace_categ($id, $categ2);
            }
            $categ3=$this->get_categ_id_by_name($categ3);//先获得标签的id
            if($categ3!=null){
                $this->replace_categ($id, $categ3);
            }
            $categ4=$this->get_categ_id_by_name($categ4);//先获得标签的id
            if($categ4!=null){
                $this->replace_categ($id, $categ4);
            }
            $categ5=$this->get_categ_id_by_name($categ5);//先获得标签的id
            if($categ5!=null){
                $this->replace_categ($id, $categ5);
            }

            /*if($sous_categ!=null) {
                foreach ($sous_categ as $value) {
                    $this->replace_categ($id, $value);
                }
            }*/

            //多语言

            //if($this->input->post('language')==0){//如果用户选择中文
            $this->add_lang_import_excel(null,$id,"zh_CN",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);//中文
            //}
            if($this->input->post('language')==1){//如果用户选西班牙语
                $this->add_lang_import_excel(null,$id,"es_ES",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
            }
            if($this->input->post('language')==2){//如果用户选意大利语
                $this->add_lang_import_excel(null,$id,"it_IT",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
            }
            if($this->input->post('language')==3){//如果用户选德语
                $this->add_lang_import_excel(null,$id,"de_DE",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
            }
            if($this->input->post('language')==4){//如果用户选英语
                $this->add_lang_import_excel(null,$id,"en_GB",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
            }
            if($this->input->post('language')==5){//如果用户选法语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
            }
            //$this->add_lang_import_excel(null,$id,"it_IT","label_it","description_it","material_it","function_it","color_it","caution_it","ingredient_it");//意大利语
            //$this->add_lang_import_excel(null,$id,"de_DE","label_de","description_de","material_de","function_de","color_de","caution_de","ingredient_de");//德语
            //$this->add_lang_import_excel(null,$id,"en_GB","label_en","description_en","material_en","function_en","color_en","caution_en","ingredient_en");//英语
            //$this->add_lang_import_excel(null,$id,"fr_FR","label_fr","description_fr","material_fr","function_fr","color_fr","caution_fr","ingredient_fr");//法语
            return $id;
        }
        //添加剩下的多语言
        //option是用户选择添加的多语言，用户选择的已经在前面添加了，这里不添加
        public function import_multi_language($id,
                                              $label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es,
                                              $label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it,
                                              $label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de,
                                              $label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb,
                                              $label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr){

            if($this->input->post('language')==0) {//如果用户选择中文
                $this->add_lang_import_excel(null,$id,"es_ES",$label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es);
                $this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                $this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                $this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }
            if($this->input->post('language')==1){//如果用户选西班牙语
                //$this->add_lang_import_excel(null,$id,"es_ES",$label,$description,$material_es,$function_es,$color,$caution_es,$ingredient_es);
                $this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                $this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                $this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }
            if($this->input->post('language')==2){//如果用户选意大利语
                $this->add_lang_import_excel(null,$id,"es_ES",$label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es);
                //$this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                $this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                $this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }
            if($this->input->post('language')==3){//如果用户选德语
                $this->add_lang_import_excel(null,$id,"es_ES",$label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es);
                $this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                //$this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                $this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }
            if($this->input->post('language')==4){//如果用户选英语
                $this->add_lang_import_excel(null,$id,"es_ES",$label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es);
                $this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                $this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                //$this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                $this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }
            if($this->input->post('language')==5){//如果用户选法语
                $this->add_lang_import_excel(null,$id,"es_ES",$label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es);
                $this->add_lang_import_excel(null,$id,"it_IT",$label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it);//意大利语
                $this->add_lang_import_excel(null,$id,"de_DE",$label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de);//德语
                $this->add_lang_import_excel(null,$id,"en_GB",$label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb);//英语
                //$this->add_lang_import_excel(null,$id,"fr_FR",$label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);//法语
            }

        }

        /*导入基本格式的Excel*/
        public function import_basic_excel(){
            $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/porducts_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
            $sheet=$excel->getSheet(0);//选择第几个表, sheet0,sheet1... 我们只导入第一页
            $data=$sheet->toArray();//把表格的数据转换为数组，注意：这里转换是以行号为数组的外层下标，列号会转成数字为数组内层下标，坐标对应的值只会取字符串保留在这里，图片或链接不会出现在这里。
            /*取图片*/
            /*
            $objWorksheet = $excel->getSheet(0);
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
            //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $drawing->getPath();
                    $drawing->getDescription();
                    $name="123.png";
                    copy($filename, 'documents/excel/'.$name.$drawing->getDescription());

                }
                echo $i;
            }*/



            //把整个excel表格遍历
            $errors="";//错误信息，提示没有添加成功的产品
            $flag_barcode=array();//用于记录哪个条形码的产品添加成功，成功才能在之后添加图片


            $i=1;
            while(isset($data[$i][1])){//如果是空数组，则停;; 不能用!=null
                $img=$data[$i][0];
                //return "hou a";
                if ($img instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $img->getPath();
                    $img->getDescription();
                    //$name="123.png";
                    //copy($filename, 'documents/excel/'.$name.$img->getDescription());
                }
                $label = $data[$i][1];
                $description = $data[$i][2];
                $barcode_type =  $data[$i][3];
                if($barcode_type=="Code 128"){
                    $barcode_type=6;
                }
                else if($barcode_type=="EAN8"){
                    $barcode_type=1;
                }
                else {
                    $barcode_type=2;
                }
                /*条形码类型可能会填写错误*/
                $barcode = $data[$i][4];
                if($barcode==null){
                    $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有填写条形码号--该产品添加失败</font> <br> <br>";
                    $i=$i+1;//不要忘记i+1, 否则无法停止
                    continue;
                    //return "第".$i."行--没有填写条形码号";
                }
                if($this->get_products_by_barcode($barcode)!=null){
                    $errors.=" <font color='#8b0000'>错误 :第".$i."行--条形码重复--该产品添加失败</font> <br> <br> ";
                    $i=$i+1;
                    continue;
                    //return "第".$i."行--条形码重复";
                }
                $intrastat = $data[$i][5];
                $price_ttc = $data[$i][6];
                $tva_tx = $data[$i][7];


                //$this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price,$cost_price);
                $this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price_ttc,$tva_tx);
                $errors.=" <font color='#66CCFF'>第".$i."行--产品添加成功 </font><br> <br>";
                $flag_barcode[]=$barcode;//如果产品添加成功，则把成功添加的产品记录到list中，用于下面添加图片

                $i=$i+1;
            }

            $i=1;

            //导入图片
            //有一个问题就是如果前面的产品有问题，那图片也无法导入，建议放到前面，但是复杂度变为O^2s
            $objWorksheet = $excel->getSheet(0);
            $this->load->library('image_lib');
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
                //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    list ($startColumn, $startRow) = PHPExcel_Cell::coordinateFromString($drawing->getCoordinates());//获取图片的列与行号
                    $filename = $drawing->getPath();
                    //$drawing->getDescription();
                    $ref=$data[$startRow-1][4];//这里ref号和条形码号相同，所以要从条形码号读取
                    if(in_array($ref,$flag_barcode)==false){//如果该产品没有添加成功，则不添加图片
                        continue;
                    }
                    $name=$ref.".png";//设置图片名字 ->这里无法知道后缀，所以我们使用png 如果将来有错误的话需要注意这里
                    $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref.'/';
                    //如果文件夹不存在则创建
                    if(!file_exists ( $dir )){
                        mkdir($dir, 0777, true);
                    }
                    copy($filename, $dir.$name);


                    //压缩图片
                    $new_image_name=$ref."_mini.png";
                    $config['source_image']	= $dir.$name;
                    $dir=$dir."/thumbs";
                    if(!file_exists ( $dir)){
                        mkdir($dir, 0777, true);
                    }
                    //生成第一个缩略图
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 72;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    //$this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);



                    //$data = array('upload_data' => $this->upload->data());
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='上传成功';
                    //生成第二个缩略图
                    $this->image_lib->clear();
                    $new_image_name=$ref."_small.png";
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 150;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    $this->image_lib->initialize($config);
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='第二个缩略图上传成功';
                }



                //$i=$i+1;

            }
            if($errors==""){
                return "全部产品上传成功!";
            }
            else {
                return $errors;
            }



        }

        /*获得Excel里的array*/
        public function get_basic_excel_array(){
            $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/porducts_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
            $sheet=$excel->getSheet(0);//选择第几个表, sheet0,sheet1... 我们只导入第一页
            $data=$sheet->toArray();//把表格的数据转换为数组，注意：这里转换是以行号为数组的外层下标，列号会转成数字为数组内层下标，坐标对应的值只会取字符串保留在这里，图片或链接不会出现在这里。
            /*取图片*/
            /*
            $objWorksheet = $excel->getSheet(0);
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
            //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $drawing->getPath();
                    $drawing->getDescription();
                    $name="123.png";
                    copy($filename, 'documents/excel/'.$name.$drawing->getDescription());

                }
                echo $i;
            }*/



            //把整个excel表格遍历
            $errors="";//错误信息，提示没有添加成功的产品
            $flag_barcode=array();//用于记录哪个条形码的产品添加成功，成功才能在之后添加图片
            $problem_product_array=array();
            $array_i=0;

            $i=1;
            while(isset($data[$i][1])){//如果是空数组，则停;; 不能用!=null
                $img=$data[$i][0];
                //return "hou a";
                if ($img instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $img->getPath();
                    $img->getDescription();
                    //$name="123.png";
                    //copy($filename, 'documents/excel/'.$name.$img->getDescription());
                }
                $label = $data[$i][1];
                $description = $data[$i][2];
                $barcode_type =  $data[$i][3];
                if($barcode_type=="Code 128"){
                    $barcode_type=6;
                }
                else if($barcode_type=="EAN8"){
                    $barcode_type=1;
                }
                else {
                    $barcode_type=2;
                }
                /*条形码类型可能会填写错误*/
                $barcode = $data[$i][4];
                if($barcode==null){
                    $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有填写条形码号--该产品添加失败</font> <br> <br>";
                    $i=$i+1;//不要忘记i+1, 否则无法停止
                    continue;
                    //return "第".$i."行--没有填写条形码号";
                }
                if($this->get_products_by_ref($barcode)!=null){
                    $errors.=" <font color='#8b0000'>错误 :第".$i."行--条形码重复--该产品添加失败</font> <br> <br> ";
                    $i=$i+1;
                    $problem_product_array[$array_i]['label']=$label;
                    $problem_product_array[$array_i]['description']=$description;
                    $problem_product_array[$array_i]['barcode']=$barcode;
                    $problem_product_array[$array_i]['barcode_type']=$barcode_type;
                    $problem_product_array[$array_i]['intrastat']=$data[$i][5];
                    $problem_product_array[$array_i]['price_ttc']=$data[$i][6];
                    $problem_product_array[$array_i]['tva_tx']=$data[$i][7];
                    $array_i+=1;
                    continue;
                    //return "第".$i."行--条形码重复";
                }
                $intrastat = $data[$i][5];
                $price_ttc = $data[$i][6];
                $tva_tx = $data[$i][7];


                //$this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price,$cost_price);
                $this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price_ttc,$tva_tx);
                $errors.=" <font color='#66CCFF'>第".$i."行--产品添加成功 </font><br> <br>";
                $flag_barcode[]=$barcode;//如果产品添加成功，则把成功添加的产品记录到list中，用于下面添加图片

                $i=$i+1;
            }

            $i=1;

            //导入图片
            //有一个问题就是如果前面的产品有问题，那图片也无法导入，建议放到前面，但是复杂度变为O^2s
            $objWorksheet = $excel->getSheet(0);
            $this->load->library('image_lib');
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
                //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    list ($startColumn, $startRow) = PHPExcel_Cell::coordinateFromString($drawing->getCoordinates());//获取图片的列与行号
                    $filename = $drawing->getPath();
                    //$drawing->getDescription();
                    $ref=$data[$startRow-1][4];//这里ref号和条形码号相同，所以要从条形码号读取
                    if(in_array($ref,$flag_barcode)==false){//如果该产品没有添加成功，则不添加图片
                        continue;
                    }
                    $name=$ref.".png";//设置图片名字 ->这里无法知道后缀，所以我们使用png 如果将来有错误的话需要注意这里
                    $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref.'/';
                    //如果文件夹不存在则创建
                    if(!file_exists ( $dir )){
                        mkdir($dir, 0777, true);
                    }
                    copy($filename, $dir.$name);


                    //压缩图片
                    $new_image_name=$ref."_mini.png";
                    $config['source_image']	= $dir.$name;
                    $dir=$dir."/thumbs";
                    if(!file_exists ( $dir)){
                        mkdir($dir, 0777, true);
                    }
                    //生成第一个缩略图
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 72;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    //$this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);



                    //$data = array('upload_data' => $this->upload->data());
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='上传成功';
                    //生成第二个缩略图
                    $this->image_lib->clear();
                    $new_image_name=$ref."_small.png";
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 150;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    $this->image_lib->initialize($config);
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='第二个缩略图上传成功';
                }



                //$i=$i+1;

            }
            /*if($errors==""){
                return "全部产品上传成功!";
            }
            else {
                return $errors;
            }*/
            return $problem_product_array;



        }

        /*导入完整格式的excel*/
        public function import_excel(){

            //$excel=PHPExcel_IOFactory::load("documents/excel/porducts_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
            $excel=PHPExcel_IOFactory::load("documents/excel/".$_SESSION['rowid']."/porducts_import.xlsx");//把导入的文件目录传入，系统会自动找到对应的解析类
            $sheet=$excel->getSheet(0);//选择第几个表, sheet0,sheet1... 我们只导入第一页
            $data=$sheet->toArray();//把表格的数据转换为数组，注意：这里转换是以行号为数组的外层下标，列号会转成数字为数组内层下标，坐标对应的值只会取字符串保留在这里，图片或链接不会出现在这里。
            /*取图片*/
            /*
            $objWorksheet = $excel->getSheet(0);
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
            //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $drawing->getPath();
                    $drawing->getDescription();
                    $name="123.png";
                    copy($filename, 'documents/excel/'.$name.$drawing->getDescription());

                }
                echo $i;
            }*/



            //把整个excel表格遍历
            $errors="";//错误信息，提示没有添加成功的产品
            $flag_barcode=array();//用于记录哪个条形码的产品添加成功，成功才能在之后添加图片


            $i=1;
            while(isset($data[$i][1])){//如果是空数组，则停;; 不能用!=null
                $img=$data[$i][0];
                //return "hou a";
                if ($img instanceof PHPExcel_Worksheet_Drawing){
                    $filename = $img->getPath();
                    $img->getDescription();
                    //$name="123.png";
                    //copy($filename, 'documents/excel/'.$name.$img->getDescription());
                }
                //return "nooooo you don't !";
                /*$ref = $data[$i][1];
                if($ref==null){
                    return "第".$i."行--没有填写ref号";
                }
                if($this->get_products_by_ref($ref)!=null){
                    return "第".$i."行--ref号重复";
                }*/
                $ref = $data[$i][1];
                if($ref==null){
                    $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有填写ref号--该产品添加失败</font> <br> <br>";
                    $i=$i+1;//不要忘记i+1, 否则无法停止
                    continue;
                    //return "第".$i."行--没有填写条形码号";
                }
                if($this->get_products_by_ref($ref)!=null){
                    $errors.=" <font color='#8b0000'>错误 :第".$i."行--ref重复--该产品添加失败</font> <br> <br> ";
                    $i=$i+1;//不要忘记i+1, 否则无法停止
                    continue;
                    //return "第".$i."行--条形码重复";
                }
                $label = $data[$i][2];
                $description = $data[$i][3];
                $barcode_type =  $data[$i][4];
                if($barcode_type=="Code 128"){
                    $barcode_type=6;
                }
                else if($barcode_type=="EAN8"){
                    $barcode_type=1;
                }
                else {
                    $barcode_type=2;
                }
                /*条形码类型可能会填写错误*/
                $barcode = $data[$i][5];
                if($barcode==null){
                    $errors.=" <font color='#8b0000'>错误: 第".$i."行--没有填写条形码号--该产品添加失败</font> <br> <br>";
                    $i=$i+1;//不要忘记i+1, 否则无法停止
                    continue;
                    //return "第".$i."行--没有填写条形码号";
                }
                if($this->get_products_by_barcode($barcode)!=null){
                    $errors.=" <font color='#8b0000'>错误 :第".$i."行--条形码重复--该产品添加失败</font> <br> <br> ";
                    $i=$i+1;
                    continue;
                    //return "第".$i."行--条形码重复";
                }
                $intrastat = $data[$i][6];
                $suppliers_product_ref = $data[$i][7];
                $unitprice = $data[$i][8];
                $tva_tx_supplier = $data[$i][9];
                $quantity = $data[$i][10];
                $discount_supplier = $data[$i][11];
                /*$product_fournisseur_ref=$this->Fournisseur_product_model->get_by_ref($suppliers_product_ref);
                if($product_fournisseur_ref!=null){
                    $errors.="|| 第".$i."行--供货商ref号重复 || ";
                    $i=$i+1;
                    continue;
                }*///供货商ref号可以重复

                $price_ttc = $data[$i][12];
                $tva_tx = $data[$i][13];
                $price_min_ttc = $data[$i][14];
                $seuil_stock_alerte = $data[$i][15];
                $desired_stock = $data[$i][16];
                $source_country = $data[$i][17];
                $brand = $data[$i][18];
                $size = $data[$i][19];
                $length = $data[$i][20];
                $width = $data[$i][21];
                $height = $data[$i][22];
                $weight = $data[$i][23];
                $color = $data[$i][24];
                $categ = $data[$i][25];
                $categ_id=$this->get_categ_id_by_name($categ);//先获得标签的id
                if($categ_id==null){
                    $errors.=" <font color='#AEB404'>Warning 第".$i."行的标签没有找到 </font><br> <br>";
                }
                $categ1 = $data[$i][26];
                $categ2 = $data[$i][27];
                $categ3 = $data[$i][28];
                $categ4 = $data[$i][29];
                $categ5 = $data[$i][30];

                $barcode_pack = $data[$i][31];
                $pack = $data[$i][32];
                $barcode_box = $data[$i][33];
                $box = $data[$i][34];
                $barcode_bigbox = $data[$i][35];
                $bigbox = $data[$i][36];


                //多语言
                //$label_es = $data[$i][24];//这里用的是es，但是根据情况可能是其他语言的, es 在这里代表其他语言的意思
                //$description_es = $data[$i][25];
                $material_es = $data[$i][37];
                $function_es = $data[$i][38];
                //$color_es = $data[$i][28];
                $caution_es = $data[$i][39];
                $ingredient_es = $data[$i][40];

                //$this->import_product($barcode,$label,$description,$barcode_type,$barcode,$intrastat,$price,$cost_price);
                $id=$this->import_product_complete($ref,$label,$description,$barcode_type,$barcode,$intrastat,$suppliers_product_ref,$unitprice,$tva_tx_supplier,$quantity,$discount_supplier,$price_ttc,$tva_tx,$price_min_ttc,$seuil_stock_alerte,$desired_stock,$source_country,$brand,$size,$length,$width,$height,$weight,$color,$categ,
                                                    $categ1,$categ2,$categ3,$categ4,$categ5,
                                                    $barcode_pack,$pack,$barcode_box,$box,$barcode_bigbox,$bigbox,
                                                    $material_es,$function_es,$caution_es,$ingredient_es);

                //更多语言
                $label_es = $data[$i][41];
                $description_es = $data[$i][42];
                $material_es = $data[$i][43];
                $function_es = $data[$i][44];
                $color_es = $data[$i][45];
                $caution_es = $data[$i][46];
                $ingredient_es = $data[$i][47];
                $label_it = $data[$i][48];
                $description_it = $data[$i][49];
                $material_it = $data[$i][50];
                $function_it = $data[$i][51];
                $color_it = $data[$i][52];
                $caution_it = $data[$i][53];
                $ingredient_it = $data[$i][54];
                $label_de = $data[$i][55];
                $description_de = $data[$i][56];
                $material_de = $data[$i][57];
                $function_de = $data[$i][58];
                $color_de = $data[$i][59];
                $caution_de = $data[$i][60];
                $ingredient_de = $data[$i][61];
                $label_gb = $data[$i][62];
                $description_gb = $data[$i][63];
                $material_gb = $data[$i][64];
                $function_gb = $data[$i][65];
                $color_gb = $data[$i][66];
                $caution_gb = $data[$i][67];
                $ingredient_gb = $data[$i][68];
                $label_fr = $data[$i][69];
                $description_fr = $data[$i][70];
                $material_fr = $data[$i][71];
                $function_fr = $data[$i][72];
                $color_fr = $data[$i][73];
                $caution_fr = $data[$i][74];
                $ingredient_fr = $data[$i][75];

                $this->import_multi_language($id,
                    $label_es,$description_es,$material_es,$function_es,$color_es,$caution_es,$ingredient_es,
                    $label_it,$description_it,$material_it,$function_it,$color_it,$caution_it,$ingredient_it,
                    $label_de,$description_de,$material_de,$function_de,$color_de,$caution_de,$ingredient_de,
                    $label_gb,$description_gb,$material_gb,$function_gb,$color_gb,$caution_gb,$ingredient_gb,
                    $label_fr,$description_fr,$material_fr,$function_fr,$color_fr,$caution_fr,$ingredient_fr);
                $errors.=" <font color='#66CCFF'>第".$i."行--产品添加成功 </font><br> <br>";
                $flag_barcode[]=$barcode;//如果产品添加成功，则把成功添加的产品记录到list中，用于下面添加图片

                $i=$i+1;
            }

            $i=1;

            //导入图片
            //有一个问题就是如果前面的产品有问题，那图片也无法导入，建议放到前面，但是复杂度变为O^2s
            $objWorksheet = $excel->getSheet(0);
            $this->load->library('image_lib');
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
                //for XLSX format
                $string = $drawing->getCoordinates();
                $coordinate = PHPExcel_Cell::coordinateFromString($string);
                if ($drawing instanceof PHPExcel_Worksheet_Drawing){
                    list ($startColumn, $startRow) = PHPExcel_Cell::coordinateFromString($drawing->getCoordinates());//获取图片的列与行号
                    $filename = $drawing->getPath();
                    //echo $string;
                    //$drawing->getDescription();
                    $ref=$data[$startRow-1][4];//这里ref号和条形码号相同，所以要从条形码号读取

                    if(in_array($ref,$flag_barcode)==false){//如果该产品没有添加成功，则不添加图片
                        continue;
                    }
                    $name=$ref.".png";//设置图片名字 ->这里无法知道后缀，所以我们使用png 如果将来有错误的话需要注意这里
                    $dir='../'.$_SESSION["folder"].'/documents/produit/'.$ref.'/';
                    //如果文件夹不存在则创建
                    if(!file_exists ( $dir )){
                        mkdir($dir, 0777, true);
                    }
                    copy($filename, $dir.$name);


                    //压缩图片
                    $new_image_name=$ref."_mini.png";
                    $config['source_image']	= $dir.$name;
                    $dir=$dir."/thumbs";
                    if(!file_exists ( $dir)){
                        mkdir($dir, 0777, true);
                    }
                    //生成第一个缩略图
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 72;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    //$this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);



                    //$data = array('upload_data' => $this->upload->data());
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='上传成功';
                    //生成第二个缩略图
                    $this->image_lib->clear();
                    $new_image_name=$ref."_small.png";
                    $config['image_library'] = 'gd2';
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 150;
                    //$config['width'] = 50;
                    $config['new_image'] = $dir."/".$new_image_name;//you should have write permission here..
                    $this->image_lib->initialize($config);
                    if (!$this->image_lib->resize()) {
                        $data['error']= $this->image_lib->display_errors();
                        echo $this->image_lib->display_errors();
                    }
                    else $data['error']='第二个缩略图上传成功';
                }



                //$i=$i+1;

            }
            if($errors==""){
                return "全部产品上传成功!";
            }
            else {
                return $errors;
            }



        }

        /*生成基本的导入Excel模板*/
        public function create_module_excel_basic(){
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);//设置宽度


            for($i=2;$i<999;$i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(100);//设置高度
            }

            $alpha_barcode_type="D";//条形码类型的列
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', "图片")
                ->setCellValue('B1', "产品名字")
                ->setCellValue('C1', "产品描述")
                ->setCellValue('D1', "条码类型")
                ->setCellValue('E1', "条形码")
                ->setCellValue('F1', "intrastat")
                ->setCellValue('G1', "含税售价")
                ->setCellValue('H1', "售价增值税")
                /*->setCellValue('N1', "最底售价")
                ->setCellValue('O1', "最低库存预警")
                ->setCellValue('P1', "最佳库存")*/

            ;
            $objActSheet = $objPHPExcel->getActiveSheet();
            //设置条形码类型输入框限制
            $str='"Code 128,EAN13,EAN8"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_barcode_type . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('条形码');
                //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
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
            $objWriter->save('documents/excel/excel_format_basic.xlsx');
            $callEndTime = microtime(true);
            $callTime = $callEndTime - $callStartTime;

            //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
            //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
            // Echo memory usage
            //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

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
            //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


            // Echo memory peak usage
            //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

            // Echo done
            //echo date('H:i:s') , " Done writing files" , EOL;
            //echo 'Files have been created in ' , getcwd() , EOL;
        }

        /*生成完整的导入Excel的模板*/
        public function create_module_excel(){
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);//设置宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);


            for($i=2;$i<999;$i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(100);//设置高度
            }

            $alpha_barcode_type="E";//条形码类型的列
            $alpha_fourni="G";//供应商的列
            $alpha_pays="R";//产地国的列
            $alpha_brand="S";//品牌的列
            $alpha_categ="Z";//大标签的列
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', "图片")
                ->setCellValue('B1', "ref号")
                ->setCellValue('C1', "产品名字")
                ->setCellValue('D1', "产品描述")
                ->setCellValue($alpha_barcode_type.'1', "条码类型")
                ->setCellValue('F1', "条形码")
                ->setCellValue('G1', "intrastat")
                //->setCellValue($alpha_fourni.'1', "供应商")  //需要设置填写规则 会有错误，因为有特殊符号
                ->setCellValue('H1', "供应商-产品ref")
                ->setCellValue('I1', "起订量价格/个")
                ->setCellValue('J1', "增值税税率")
                ->setCellValue('K1', "起订量")
                ->setCellValue('L1', "折扣")
                ->setCellValue('M1', "含税售价")
                ->setCellValue('N1', "售价增值税")
                ->setCellValue('O1', "最底售价")
                ->setCellValue('P1', "最低库存预警")
                ->setCellValue('Q1', "最佳库存")
                ->setCellValue($alpha_pays.'1', "产地国") //需要设置填写规则
                ->setCellValue($alpha_brand.'1', "品牌")   //需要设置填写规则
                ->setCellValue('T1', "尺寸")
                ->setCellValue('U1', "长/m")
                ->setCellValue('V1', "宽/m")
                ->setCellValue('W1', "高/m")
                ->setCellValue('X1', "重量/g")
                ->setCellValue('Y1', "颜色")
                ->setCellValue($alpha_categ.'1', "大类别")
                ->setCellValue('AA1', "小类别1")
                ->setCellValue('AB1', "小类别2")
                ->setCellValue('AC1', "小类别3")
                ->setCellValue('AD1', "小类别4")
                ->setCellValue('AE1', "小类别5")

                ->setCellValue('AF1', "包条码")
                ->setCellValue('AG1', "包规格")
                ->setCellValue('AH1', "箱条码")
                ->setCellValue('AI1', "箱规格")
                ->setCellValue('AJ1', "运输箱条码")
                ->setCellValue('AK1', "运输箱规格")

            ;
            //多语言的表
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('AL1', "材质")
                ->setCellValue('AM1', "功效")
                ->setCellValue('AN1', "注意事项")
                ->setCellValue('AO1', "成分")

                //其他多语言
                ->setCellValue('AP1', "产品名字ES")
                ->setCellValue('AQ1', "描述ES")
                ->setCellValue('AR1', "材质ES")
                ->setCellValue('AS1', "功效ES")
                ->setCellValue('AT1', "颜色ES")
                ->setCellValue('AU1', "注意事项ES")
                ->setCellValue('AV1', "成分/配方ES")
                ->setCellValue('AW1', "产品名字IT")
                ->setCellValue('AX1', "描述IT")
                ->setCellValue('AY1', "材质IT")
                ->setCellValue('AZ1', "功效IT")
                ->setCellValue('BA1', "颜色IT")
                ->setCellValue('BB1', "注意事项IT")
                ->setCellValue('BC1', "成分/配方IT")
                ->setCellValue('BD1', "产品名字DE")
                ->setCellValue('BE1', "描述DE")
                ->setCellValue('BF1', "材质DE")
                ->setCellValue('BG1', "功效DE")
                ->setCellValue('BH1', "颜色DE")
                ->setCellValue('BI1', "注意事项DE")
                ->setCellValue('BJ1', "成分/配方DE")
                ->setCellValue('BK1', "产品名字EN")
                ->setCellValue('BL1', "描述EN")
                ->setCellValue('BM1', "材质EN")
                ->setCellValue('BN1', "功效EN")
                ->setCellValue('BO1', "颜色EN")
                ->setCellValue('BP1', "注意事项EN")
                ->setCellValue('BQ1', "成分/配方EN")
                ->setCellValue('BR1', "产品名字FR")
                ->setCellValue('BS1', "描述FR")
                ->setCellValue('BT1', "材质FR")
                ->setCellValue('BU1', "功效FR")
                ->setCellValue('BV1', "颜色FR")
                ->setCellValue('BW1', "注意事项FR")
                ->setCellValue('BX1', "成分/配方FR")
            ;
            $objActSheet = $objPHPExcel->getActiveSheet();

            //设置条形码类型输入框限制
            $str='"Code 128,EAN13,EAN8"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_barcode_type . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('条形码');
                //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
            }

            //设置供应商输入框限制 //因为供应商有特殊字符，所以这里不能用
            /*
            $fourni=$this->Fournisseur_product_model->get_all_fournisseur();
            $str='"';
            foreach($fourni as $value){
                $str=$str.",".$value['nom'];
            }
            $str=$str.'"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_fourni . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('供应商');
                //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
            }*/

            //设置大标签输入框限制  //
            /*$pere_categ=$this->get_pere_categ();
            $str='"';
            foreach($pere_categ as $value){
                $str=$str.",".$value['label'];
            }
            $str=$str.'"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_categ . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('标签');
                    //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
            }*/

            //产地国输入限制 //产地国有特殊符号，将来可能会有bug
            /*$pays=$this->get_list_country();
            $str='"';
            foreach($pays as $value){
                $str=$str.",".$value['label'];
            }
            $str=$str.'"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_pays . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('产地国');
                //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
            }*/

            //品牌输入限制
            $brand=$this->get_brand();
            $str='"';
            foreach($brand as $value){
                $str=$str.",".$value['label'];
            }
            $str=$str.'"';
            for($i=2;$i<999;$i++) {
                $objValidation = $objActSheet->getCell($alpha_brand . $i)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(false)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('输入的值有误')
                    ->setError('您输入的值不在下拉框列表内.')
                    ->setPromptTitle('品牌');
                //->setFormula1('"列表项1,列表项2,列表项3"');
                //$test_str = '"abc,bfef,zefze"';
                $objValidation
                    ->setFormula1($str);
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
            $objWriter->save('documents/excel/format_basic.xlsx');
            $callEndTime = microtime(true);
            $callTime = $callEndTime - $callStartTime;

            //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
            //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
            // Echo memory usage
            //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

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
            //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


            // Echo memory peak usage
            //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

            // Echo done
            //echo date('H:i:s') , " Done writing files" , EOL;
            //echo 'Files have been created in ' , getcwd() , EOL;
        }


    }