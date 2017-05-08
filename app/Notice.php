<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/8
 * Time: 22:40
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model{
    //指定表名
    protected $table = "notices";
    //指定主键
    protected $primaryKey = "notice_id";
    //指定允许批量赋值
    protected $fillable = ['notice_title','notice_content'];
    //自动维护时间戳
    public $timestamps = true;

    /**
     * @param DateTime | int
     * @return string
     */
    public function formDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * @param
     * @return string
     */
    protected function getDateFormat()//指定存储的时间格式
    {
        return time();
    }

    public function pageAction($obj,$page_num,$current_url){
        $data           = $obj->toArray();
        $total          = $data['last_page'];//总共的页数
        $current_page   = $data['current_page'];//当前页数
        $next_page_url  = $data['next_page_url'];//下一页的地址
        $prev_page_url  = $data['prev_page_url'];//上一页的地址
        $tmp = explode('?',$current_url);
        $page_url = $tmp[0];
        $url_list = array();
        if($total > $page_num){//超出显示的范围
            $left  = $current_page;
            $right = $total - $current_page;
            if($left<=4){//左边全部显示
                $h = $current_page+($page_num-$current_page-1);
                $url_list[$h+1] = '…';
                for($i=$h; $i>=1;$i--){
                    $url_tmp =  $page_url.'?page='.$i;
                    $url_list[$i] = $url_tmp;
                }

            }else if($right<=3){
                $l = $current_page - ($page_num - $right - 2);
                for($i=$total; $i>=$l;$i--){
                    $url_tmp =  $page_url.'?page='.$i;
                    $url_list[$i] = $url_tmp;
                }
                $url_list[$l-1] = '…';
            }else{
                $url_list[$current_page+3] = '…';
                for($i=$current_page+2; $i>=$current_page-2; $i--){
                    $url_tmp =  $page_url.'?page='.$i;
                    $url_list[$i] = $url_tmp;
                }
                $url_list[$current_page-3] = '…';
            }
        }else{
            for($i = $total; $i>=1 ;$i--){
                $url_tmp =  $page_url.'?page='.$i;
                $url_list[$i] = $url_tmp;
            }
        }
        $page = [
            'current_page'  =>$current_page,
            'next_page_url' =>$next_page_url == null ? 'javascript:void(0)': $next_page_url,
            'prev_page_url' =>$prev_page_url == null ? 'javascript:void(0)': $prev_page_url,
            'url_list'       =>$url_list,
            'total'          =>$total
        ];
        return $page;
    }
}