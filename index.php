<?php

    /*
    version     1.0.1
    developer   Shadow403
    Software    Visual Studio Code
    Environment
    {
        Apache  2.4
        PHP     7.4.5
    }
    */

    $get_T1 = $_GET['t1'];
    if (empty($get_T1))
    {
        exit;
    }

    $get_T3 = $_GET['t3'];
    if (empty($get_T3 ))
    {
        exit;
    }

    function name_API($name_Api_str = '')
    {
        $name_Api = file_get_contents('https://api.usuuu.com/qq/' . $name_Api_str, True);
        $name_Api_json = json_decode($name_Api, True);;
        if ($name_Api_json["code"] == 200)
        {
            $name_Api_str = $name_Api_json['data']['name'];
            return $name_Api_str;
        }
    }

    $get_T1 = match_chinese($get_T1);
    $get_T3 = match_chinese($get_T3);

    function match_chinese($chars,$encoding='utf8')
    {
        $pattern = ($encoding=='utf8')?'/[\x{4e00}-\x{9fa5}a-zA-Z0-9_]/u':'/[\x80-\xFF]/';
        preg_match_all($pattern,$chars,$result);
        $temp = join('',$result[0]);
        return $temp;
    }

    function zh_cn_unum($zh_cn_unum = '')
    {
        $zh_cn_unum_ = findNum($zh_cn_unum);
        $zh_cn_unum = str_replace(str_split($zh_cn_unum_), '', $zh_cn_unum);
        return $zh_cn_unum;
    }

    function zh_en($zh_en = '')
    {
        preg_match_all("/[a-zA-Z]/u", $zh_en, $zh_en_array);
        $zh_en = join('',$zh_en_array[0]);
        return $zh_en;
    }
    
    function zh_cn($zh_cn = '')
    {
        preg_match_all("/[a-zA-Z]/u", $zh_cn, $zh_en_array);
        $zh_en = join('',$zh_en_array[0]);
        $zh_cn = str_replace(str_split($zh_en), '', $zh_cn);
        return $zh_cn;
    }

    function findNum($str = '')
    {
        $str=trim($str);
        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0');
        $result='';
        for($i=0;$i<strlen($str);$i++)
            {
                if(in_array($str[$i],$temp)){
                                                $result.=$str[$i];
                                            }
    
            }
        return $result;
    }

    function extent_zh_cn($extent_zh_cn = '')
    {
        $extent_zh_cn = mb_strlen($extent_zh_cn, 'utf-8');
        $extent_zh_cn = $extent_zh_cn * 20;
        return $extent_zh_cn;
    }

    function extent_zh_en($extent_zh_en = '')
    {
        $extent_zh_en = mb_strlen($extent_zh_en, 'utf-8');
        $extent_zh_en = $extent_zh_en * 12;
        return $extent_zh_en;
    }

    function extent_num($extent_num = '')
    {
        $extent_num = mb_strlen($extent_num, 'utf-8');
        $extent_num = $extent_num * 12;
        return $extent_num;
    }

    function weapon_type($weapon_type = '')
    {
        $weapon_type = mt_rand(1, 52);
        return $weapon_type;
    }

    $get_name_T1 = name_API($get_T1);
    $get_zh_cn_unum_T1 = zh_cn_unum($get_name_T1);
    $get_zh_cn_T1 = zh_cn($get_zh_cn_unum_T1);
    $get_zh_en_T1 = zh_en($get_zh_cn_unum_T1);
    $get_num_T1 = findNum($get_name_T1);

    $get_name_T3 = name_API($get_T3);
    $get_zh_cn_unum_T3 = zh_cn_unum($get_name_T3);
    $get_zh_cn_T3 = zh_cn($get_zh_cn_unum_T3);
    $get_zh_en_T3 = zh_en($get_zh_cn_unum_T3);
    $get_num_T3 = findNum($get_name_T3);

    $width_zh_cn_T1 = extent_zh_cn($get_zh_cn_T1);
    $width_zh_en_T1 = extent_zh_en($get_zh_en_T1);
    $width_num_T1 = extent_num($get_num_T1);

    $width_zh_cn_T3 = extent_zh_cn($get_zh_cn_T3);
    $width_zh_en_T3 = extent_zh_en($get_zh_en_T3);
    $width_num_T3 = extent_num($get_num_T3);

    $weapon = weapon_type();
    $weaponsize = getimagesize("./img/$weapon.png");
    $width_T2 = $weaponsize['0'];

    $width_T1 = $width_zh_cn_T1 + $width_zh_en_T1 + $width_num_T1 + 10;
    $width_T1_T2 = $width_T1 + $width_T2 + 5;
    $width_T3 = $width_zh_cn_T3 + $width_zh_en_T3 + $width_num_T3;
    $fullwidth = $width_zh_cn_T1 + $width_zh_en_T1 + $width_num_T1 + $width_zh_cn_T3 + $width_zh_en_T3 + $width_num_T3 + $width_T2 + 10;
    $fullhight = 50;

    $fonts = realpath('./inc/fonts/msyhbd.ttc');
    $image = imagecreatetruecolor($fullwidth, $fullhight);
    $pen_image = imagecolorallocate($image, 0, 0, 0);
    Imagefill($image, 0, 0, $pen_image);
    $pen_write_T1 = imagecolorallocate($image, 234, 190, 84);
    $pen_write_T3 = imagecolorallocate($image, 111, 156, 230);
    $pen_edge = imagecolorallocate($image, 226, 2, 0);

    imagettftext($image, 15, 0, 10, 32.5, $pen_write_T1, $fonts, $get_name_T1);

    $weaponimg = imagecreatefrompng("./img/$weapon.png");
    imagecopy($image, $weaponimg, $width_T1, 10, 0, 2, $width_T2, 32);
    
    imagettftext($image, 15, 0, $width_T1_T2, 32.5, $pen_write_T3, $fonts, $get_name_T3);

    imagesetthickness($image, 4);
    imagerectangle($image, 0, 1, $fullwidth - 2, 48, $pen_edge);
    
    header("Content-Type: image/png");
    imagepng($image);
    
?>

<?php

    /*

    UPDATA LOG
    {
        Data[2023-01-11]
        Version 1.0.0 --> Create Project
        
        Data[2023-01-12]
        Version 1.0.1 --> Use QQID To Get QQname
    }

    */
?>