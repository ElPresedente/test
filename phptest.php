<?php
//print_r($_POST);
if(isset($_POST['addData'])){
    $key = $_POST['addData'];
    switch($key){
        case 'reg':
        reg();
        //print_r($_POST);
        //print_r($_FILES);
        break;
        case 'load_msg':
        load_msg();
        break;
        case 'msg':
        msg();
        break;
        case 'test':
        echo json_encode($_POST);
        break;
        default:
        echo 'что то пошло не так';
        print_r($_POST);
        break;
    }
}
function reg(){
    if($_FILES['av']['size']){
        if(!exif_imagetype($_FILES['av']['tmp_name'])){
            $miss = "file";
    }}
    else{
        $miss = "file";
    }
    foreach($_POST as $i){
        if($i == ''){
            $miss = 'text';
        }
    }
    if($miss){
        $ans = array('miss'=>$miss);
        echo json_encode($ans);
        return;
    }
    else{
        $fio = $_POST['fio1'].' '.$_POST['fio2'].' '.$_POST['fio3'];
        $image = $_FILES['av'];
        $im_name = $image['name'];
        $uploads_dir = 'uploads';
        //print_r($image['tmp_name']);
        move_uploaded_file($image['tmp_name'],"$uploads_dir/$im_name");
        $path = "$uploads_dir/$im_name";
        $dbc = mysqli_connect('localhost', 'root', '', 'test') or die('Ошибка подключения к MySQL серверу.');
        $zp = "insert into test(fio, date, adres, img) values('{$fio}','{$_POST['date']}','{$_POST['adres']}', '$path')";
        $result=mysqli_query($dbc,$zp);
        //print_r($result);
        if($result){
            $ans = array('success'=> true, 'id'=> mysqli_insert_id($dbc));
            }
        else{
            $ans = array('success'=> false);
            }
        echo json_encode($ans);
    }
}
function msg(){
    //echo json_encode($_POST);
    foreach($_POST as $i){
        if($i == ''){
            $ans = array('miss'=>true);
            echo json_encode($ans);
            return;
        }
    }
    if(!$_POST['id_inp']){
        $ans = array('miss'=>true);
        echo json_encode($ans);
        return;
    }
    $dbc = mysqli_connect('localhost', 'root', '', 'test') or die('Ошибка подключения к MySQL серверу.');
    $zp = "insert into msg(msg, id) values ('{$_POST['msg']}', '{$_POST['id_inp']}')";
    $result=mysqli_query($dbc,$zp);
    $id_msg = mysqli_insert_id($dbc);
    for($i = 0;;$i++){
        $str = 'tag'.strval($i);
        //echo $str;
        //echo $_POST[$str];
        if(isset($_POST[$str])){
            $dbc = mysqli_connect('localhost', 'root', '', 'test') or die('Ошибка подключения к MySQL серверу.');
            //echo $_POST[$str];
            $tag = $_POST[$str];
            $zp = "select `id_tag` from `tags` where `tag` = '$tag'";
            $result=mysqli_query($dbc,$zp);
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if(isset($res[0])){
                $id_tag = $res[0]['id_tag'];
            }
            else{
                $zp = "insert into tags(tag) values ('$tag')";
                $result=mysqli_query($dbc,$zp);
                $id_tag = mysqli_insert_id($dbc);
            }
            $zp = "insert into msg_tags(id_msg, id_tag) values ('$id_msg', '$id_tag')";
            $result=mysqli_query($dbc,$zp);
        }
        else{
            break;
        }
    }
    $zp = 'insert into tags(tag)';

}
function load_msg(){
    $dbc = mysqli_connect('localhost', 'root', '', 'test') or die('Ошибка подключения к MySQL серверу.');
    $zp = "select * from msg limit 10";
    $result=mysqli_query($dbc,$zp);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //echo json_encode($res);
    if(!isset($res[0])){exit;}
    else{
        for($i=0;$i<count($res);$i++){
            $id_msg = $res[$i]['id_msg'];
            $zp = "select tags.tag from msg_tags, tags where msg_tags.id_msg = '$id_msg' and msg_tags.id_tag = tags.id_tag";
            $result=mysqli_query($dbc,$zp);
            $res1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $tags = array();
            for($i1=0;$i1<count($res1);$i1++){
                //echo $res1[$i1];
                array_push($tags,$res1[$i1]['tag']);
            }
            $res[$i]['tags'] = $tags;
            $msg_id = $res[$i]['id'];
            //echo $msg_id;
            $zp = "SELECT * FROM `test` where id='$msg_id'";
            $result=mysqli_query($dbc,$zp);
            $res2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
            //echo json_encode($res2);
            if(!isset($res2[0])){
                $fio = 'Незарагестрированный пользователь';
            }
            else{
                $fio = $res2[0]['fio'];
                $img = $res2[0]['img'];
            }
            $name = array();
            array_push($name,$fio,$img);
            $res[$i]['name'] = $name;
        }
        echo json_encode($res);
    }
}