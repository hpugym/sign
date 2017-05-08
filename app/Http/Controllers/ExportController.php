<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/20
 * Time: 17:13
 */
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller{

    /**
     * 详细的的签到列表导出
     * @param $qrcode_code
     */

    public function detailExport($qrcode_code){
        //查询所有的学生信息
        $res = DB::table('signs')
            ->join('students', 'signs.stu_openid', '=', 'students.stu_openid')
            ->join('teachs', 'signs.teachs_code', '=', 'teachs.teachs_code')
            ->where('signs.qrcode_code', '=', $qrcode_code)
            ->select('students.stu_num','students.stu_name','students.stu_class','signs_status')
            ->get();
//        dd($res);
        //查询课程信息
        $res1 = DB::table('signs')
            ->where('signs.qrcode_code', '=', $qrcode_code)
            ->join('teachs', 'signs.teachs_code', '=', 'teachs.teachs_code')
            ->join('courses','courses.course_num', '=', 'teachs.course_num')
            ->groupBy('teachs.teachs_code','courses.course_num','courses.course_name','signs.qrcode_time')
            ->select('courses.course_num','courses.course_name','signs.qrcode_time')
            ->get();
//        dd($res1);

        //查询签到总数
        $res2 = DB::table('signs')
            ->where('signs.qrcode_code', '=', $qrcode_code)
            ->count();
//        dd($res2);

        //查询缺勤人数
        $res3 = DB::table('signs')
            ->whereRaw('qrcode_code=? and signs_status=?', [$qrcode_code,'缺勤'])
            ->count();
//        dd($res3);

        //查询请假人数
        $res4 = DB::table('signs')
            ->whereRaw('qrcode_code=? and signs_status=?', [$qrcode_code,'请假'])
            ->count();
//        dd($res4);

        $all = $res2;
        $leave = $res4;
        $lost = $res3;
        if($all == 0){
            $rate = 0;
        }
        $rate = sprintf("%.3f",($all - $lost)/$all);
        $export_file_name = $res1[0]->course_num."-".date("YmdHis",$res1[0]->qrcode_time)."sign";
        Excel::create($export_file_name, function ($excel) use ($res,$res1,$all,$leave,$lost,$rate){

            // Set the title
            $excel->setTitle('河南理工大学考勤信息表');

            // Chain the setters
            $excel->setCreator('郭月盟')
                ->setCompany('河南理工大学');
            // Call them separately
            $excel->setDescription('考勤记录表');
            $excel->sheet('记录表', function ($sheet) use ($res,$res1,$all,$leave,$lost,$rate) {

                $sheet->appendRow([date("Y年m月d日",$res1[0]->qrcode_time).'考勤记录表']);
                $sheet->appendRow(2, array(
                    '序号','学号','姓名','专业班级','课程号','签到状态'
                ));
                //开始添加数据

                for($i = 0; $i <count($res); $i ++){
                    $sheet->appendRow($i+3, array(
                        $i+1,"".$res[$i]->stu_num."\t",$res[$i]->stu_name,$res[$i]->stu_class,$res1[0]->course_name,$res[$i]->signs_status
                    ));
                    $sheet->cells('A'.($i+3).':F'.($i+3), function($cells) {

                        // manipulate the range of cells
                        $cells->setFont(array(
                            'family'     => '宋体',
                            'size'       => '14',
                        ));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                    });
                    $sheet->setBorder('A'.($i+3).':F'.($i+3), 'thin');//设置边框
                }
                //最后附件详细信息；
                $sheet->appendRow($all+3,array(
                    "签到人数：".$all."\t"."请假：".$leave."\t缺勤：".$lost."出勤率：".$rate
                ));

                $sheet->mergeCells('A1:F1');//合并单元格
                $sheet->mergeCells('A'.($all+3).':F'.($all+3));//合并单元格
                $sheet->setBorder('A1:F2', 'thin');
                $sheet->cells('A1:F1', function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '24',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A2:F2', function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '16',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A'.($all+3).':F'.($all+3), function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '12',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('right');
                });

                $sheet->setWidth(array(
                    'A'     =>  8,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  25,
                    'E'     =>  40,
                    'F'     =>  20
                ));
                $sheet->setHeight(1, 40);
                $sheet->setHeight(($all+3), 40);
            });

        })->download('xlsx');

    }
    public function courseExport($teachs_code){
        //先查询该teachs_code下的所有学生
        $student = DB::table('signs')
            ->where('teachs_code', '=', $teachs_code)
            ->join('students', 'students.stu_openid', '=', 'signs.stu_openid')
            ->groupBy('stu_openid','students.stu_num','students.stu_name','students.stu_sex','students.stu_class')
            ->select('students.stu_num','students.stu_name','students.stu_sex','students.stu_class','students.stu_openid')
            ->get();
//        dd($student);
        //统计学生信息
        for($i = 0; $i <count($student); $i ++){
            $stuInfo[$student[$i]->stu_num] = array('openid' => $student[$i]->stu_openid);
        }
//        dd($stuInfo);
        //查签到信息
        $stuSign = array(array());
        $rates = 0;
        $all = 0;
        foreach ($stuInfo as $key => $val){
            $signs = DB::table('signs')->whereRaw('stu_openid = ? and teachs_code =?',[$val,$teachs_code])->count();
            $leaves = DB::table('signs')->whereRaw('stu_openid = ? and teachs_code = ? and signs_status = ?',[$val,$teachs_code,'请假'])->count();
            $losts = DB::table('signs')->whereRaw('stu_openid = ? and teachs_code = ? and signs_status = ?',[$val,$teachs_code,'缺勤'])->count();
            if($signs == 0){
                $rate = 0;
            }else{
                $rate = sprintf("%.3f",(($signs - $losts)/$signs*100));
            }
            $rates = $rates + $rate;
            $all ++;
            $stuSign[$key] = array('sign' => $signs, 'leave' => $leaves, 'lost' => $losts,'rate' => $rate."%");
        }
        $rates = sprintf("%.4f",$rates/$all);
//        dd($stuSign);

        //查询课程信息
        $courseInfo = DB::table('teachs')->where('teachs_code', '=', $teachs_code)
                      ->join('courses', 'teachs.course_num', '=', 'courses.course_num')
                      ->select('courses.course_num','courses.course_name')
                      ->get();
//        dd($courseInfo);

        //导出数据

        $export_file_name = $courseInfo[0]->course_num."-签到汇总";
        Excel::create($export_file_name, function ($excel) use ($student,$stuSign,$courseInfo,$all,$rates){

            // Set the title
            $excel->setTitle('河南理工大学考勤信息表');

            // Chain the setters
            $excel->setCreator('郭月盟')
                ->setCompany('河南理工大学');
            // Call them separately
            $excel->setDescription('考勤记录表');
            $excel->sheet('汇总表', function ($sheet) use ($student,$stuSign,$courseInfo,$all,$rates) {

                $sheet->appendRow([$courseInfo[0]->course_name.'考勤记录汇总表']);
                $sheet->appendRow(2, array(
                    '序号','学号','姓名','专业班级','签到总数','请假次数','缺勤次数','出勤率'
                ));
                //开始添加数据

                for($i = 0; $i <count($student); $i ++){
                    $sheet->appendRow($i+3, array(
                        $i+1,"".$student[$i]->stu_num."\t",$student[$i]->stu_name,$student[$i]->stu_class,$stuSign[$student[$i]->stu_num]['sign'],$stuSign[$student[$i]->stu_num]['leave'],$stuSign[$student[$i]->stu_num]['lost'],$stuSign[$student[$i]->stu_num]['rate']
                    ));
                    $sheet->cells('A'.($i+3).':H'.($i+3), function($cells) {

                        // manipulate the range of cells
                        $cells->setFont(array(
                            'family'     => '宋体',
                            'size'       => '14',
                        ));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                    });
                    $sheet->setBorder('A'.($i+3).':H'.($i+3), 'thin');//设置边框
                }
                //最后附件详细信息；
                $sheet->appendRow($i+3,array(
                    "签到人数：".$all.",出勤率：".$rates."%"
                ));

                $sheet->mergeCells('A1:H1');//合并单元格
                $sheet->mergeCells('A'.($all+3).':H'.($all+3));//合并单元格
                $sheet->setBorder('A1:H2', 'thin');
                $sheet->cells('A1:H1', function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '24',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A2:H2', function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '16',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A'.($all+3).':H'.($all+3), function($cells) {

                    // manipulate the range of cells
                    $cells->setFont(array(
                        'family'     => '宋体',
                        'size'       => '12',
                        'bold'       =>  true
                    ));
                    $cells->setValignment('center');
                    $cells->setAlignment('right');
                });

                $sheet->setWidth(array(
                    'A'     =>  8,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  25,
                    'E'     =>  15,
                    'F'     =>  15,
                    'G'     =>  15,
                    'H'     =>  15
                ));
                $sheet->setHeight(1, 40);
                $sheet->setHeight(($all+3), 40);
            });

        })->download('xlsx');
    }
}