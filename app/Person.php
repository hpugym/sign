<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/10
 * Time: 17:31
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Person extends Model {
    //指定表名
    protected $table = "teachers";
    //指定主键
    protected $primaryKey = "teach_id";
    //指定允许批量赋值
    protected $fillable = ['teach_phone','teach_college','teach_depart','teach_add','teach_name','teach_sex','teach_level','teach_id','teach_image'];
    //自动维护时间戳
    public $timestamps = false;

}