<?php
if (!session_id()) session_start();
// 生成一个PHP数组
$data = array();
$arr=array();

$sn = isset($_GET['teachername']) ? $_GET['teachername'] : "";
$page=isset($_GET['page']) ? $_GET['page'] : "";
$limit=isset($_GET['limit']) ? $_GET['limit'] : "";

require("./controller/mysql_connect.php");

if($sn===""||$page===""||$limit==="")
{
    $sql_select = "SELECT studentname,teachername FROM s_t WHERE state='0'"; //准备sql语句
}
else
{
    $sql_select = "SELECT studentname,teachername FROM s_t WHERE state='0' AND teachername='$sn'"; //准备sql语句
}
// $sql_select = "SELECT studentname,teachername FROM s_t WHERE state='0'"; //准备sql语句
$ret = mysqli_query($conn, $sql_select);//执行SQL语句
$num = mysqli_num_rows($ret);//获得符合查询条件的总数
$data['code']=0;
$data['msg']='';
$data['count']=$num;
$minnum=($page-1)*$limit+1;
$maxnum=$page*$limit;
$i=0;
$j=0;
while($row = mysqli_fetch_array($ret))
{
    ++$j;
    if($j>=$minnum&&$j<=$maxnum)
    {
    $arr[$i] = array('studentname'=>$row['studentname'],'teachername'=>$row['teachername']);
    $i++;
    }
}
mysqli_close($conn);
$data['data']=$arr;
echo json_encode($data);
//$data[1] = array('2','何开','iteye.com');
// 把PHP数组转成JSON字符串
// $json_string = json_encode($data);
// // // 写入文件
// file_put_contents('test.json', $json_string);
// ?>