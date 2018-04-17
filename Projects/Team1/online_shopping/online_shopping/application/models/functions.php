<?php

    function add($a,$b){
        $c=$a+$b;
        return $c;
    }

    /**
     *
     * 获取图片名称列表
     *
     * @param str $dir 图片路径
     * @return array $photo 图片名称列表
     */
    function get_photo_list($dir)
    {
        if (file_exists($dir)) {
            //获取某目录下所有文件、目录名（不包括子目录下文件、目录名）
            $handler = opendir($dir);
            $files=array();
            while (($filename = readdir($handler))) {//务必使用!==，防止目录下出现类似文件名“0”等情况
                if ($filename != "." && $filename != "..") {
                    $files[] = $filename;
                }
            }
            closedir($handler);
            //去掉不是照片的文件的文件名,得到只有照片名字的文件名 $photo是照片文件名
            $photo=array();
            $i=0;
            if($files!=null) {
                foreach ($files as $un_file) {
                    if ($un_file != "thumbs" && $un_file != ".DS_Store") {
                        $photo[$i] = $un_file;
                        $i = $i + 1;
                    }
                }
            }
            return $photo;
        }
    }
    //显示图片
    function show_product_photos($rowid,$height=null){
        if($height==null){
            $height=20;
        }
        $dir="documents/product/".$rowid;
        $photo_list=get_photo_list($dir);
        if($photo_list==null){
            echo '<img src="'.base_url().'assets/img/nophoto.png'.'" height="'.$height.'" class="img-rounded">';
            return;
        }
        foreach ($photo_list as $value){
            echo '<img src="'.base_url().$dir."/".$value.'" height="'.$height.'" class="img-rounded">';
        }
        //print_r(get_photo_list($dir));
    }
    //压缩图片