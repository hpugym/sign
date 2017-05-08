<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/10
 * Time: 15:13
 */
namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadingController extends Controller{
    /**
     * 图片上传
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function imageUpload(){
        //这里注意安全的的验证
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            exit(0);
        }


        return view("common/imageupload");
    }
    /**
     * 上传的请求处理
     * @param Request $request
     */
    public function uploadImgAction(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            echo "<script>alert('对不起，请登录后操作');</script>";
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            if(is_uploaded_file(@$_FILES["image_file"]["tmp_name"])){
                //dd($_FILES['image_file']);
                //为了更高效，将信息存放在变量中
                $upfile=@$_FILES["image_file"];//用一个数组类型的字符串存放上传文件的信息
                //dd($upfile);
                $name=$upfile["name"];//便于以后转移文件时命名
                //处理文件名，改为教师的id
                $nameArr = explode('.',$name);
                $len = count($nameArr) - 1;
                //后期这里将使用登陆账号的九位id号码来命名，例如001100000-1位上传原始的名字，裁剪之后的名字变为001100000-2，然后删除原来的


                $name = "101100000-1.".$nameArr[$len];
//                $type=$upfile["type"];//上传文件的类型
//                $size=$upfile["size"];//上传文件的大小
                $tmp_name=$upfile["tmp_name"];//用户上传文件的临时名称

                $error=$upfile["error"];//上传过程中的错误信息
                $dir="./upload/uploadfiles/";
//                $dir="http://sign.goalschina.com/sign/upload/";
                // $fileType= substr($name, strrpos($name,"."),strlen($name)-strrpos($name, "."));
                //strrpos() 函数查找字符串在另一字符串中最后一次出现的位置。
                if($error==0){
                    //调用移动文件函数之前，先进行原来的文件是否存在，如果存在的话，先删除该文件，并更新数据库中的url地址
                    $person = Person::where('teach_id', '=', '101100000')->first();
                    if(file_exists($person->teach_image)){
                        unlink($person->teach_image);
                        $num = Person::where('teach_id', '=', '101100000')->update([
                            'teach_image' => null
                        ]);
                        if($num == 0){
                            echo "<script>alert('操作失败，请重新上传');window.open('','_parent','');window.close();</script>";
                        }
                    }
                    //调用move_uploaded_file（）函数，进行文件转移（从内置临时目录转移到指定目录）
                    move_uploaded_file($tmp_name, $dir.$name);
                    if(file_exists($dir.$name)) {//此处检测文件是否已经上传成功
                        //echo "<script>alert('已成功上传.');</script>";
                        //$image = "upload/uploadfiles/001100000-1.jpg";
                        $image = $dir . $name;
                        $res = $this->thumb($image, false, 1);
                        //dd($res);
                        if ($res == false) {
                            echo "<script>alert('裁剪失败，请重新上传');window.open('','_parent','');window.close();</script>";
                        }else{
                            //更新数据库中的图片地址
                            $num = Person::where('teach_id','=','101100000')->update([
                                'teach_image'=> $res['big']
                            ]);
                            if($num > 0){
                                echo "<script>alert('上传成功！');window.open('','_parent','');window.close();</script>";
                            }else{
                                echo "<script>alert('上传失败，请重试...');window.open('','_parent','');window.close();</script>";
                            }
                        }
//                        elseif (is_array($res)) {
//                            echo '<img src="' . url($res['big']) . '" style="margin:10px;">';
//                        } elseif (is_string($res)) {
//                            echo '<img src="' . url($res) . '">';
//                        }
                    }else {
                        echo "<script>alert('上传失败，请重试...');window.open('','_parent','');window.close();</script>";
                    }
                }else{
                    //如果文件不符合类型或者上传过程中有错误，提示失败
                    echo "<script>alert('failed or not exist!');window.open('','_parent','');window.close();</script>";
                }
            }
        }else{
            echo "<script>alert('错误的请求');</script>";
        }
    }
    //图像的处理
    private function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"		=>$imageInfo[0],
                "height"	=>$imageInfo[1],
                "type"		=>$imageType,
                "size"		=>$imageSize,
                "mime"		=>$imageInfo['mime'],
            );
            return $info;
        }else {
            return false;
        }
    }

    /**
    +----------------------------------------------------------
     * 生成缩略图
    +----------------------------------------------------------
     * @static
     * @access public
    +----------------------------------------------------------
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     * @param boolean $is_save 是否保留原图
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */

    private function thumb($image,$is_save=true,$suofang=0,$type='',$maxWidth=500,$maxHeight=500,$interlace=true){
        // 获取原图信息
        $info  = $this->getImageInfo($image);
        if($info !== false) {
            $srcWidth  = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
            $type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            if ($suofang==1) {
                $width  = $srcWidth;
                $height = $srcHeight;
            } else {
                $scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
                if($scale>=1) {
                    // 超过原图大小不再缩略
                    $width   =  $srcWidth;
                    $height  =  $srcHeight;
                }else{
                    // 缩略图尺寸
                    $width  = (int)($srcWidth*$scale);	//147
                    $height = (int)($srcHeight*$scale);	//199
                }
            }
            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            $srcImg     = $createFun($image);

            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if(function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
            if('gif'==$type || 'png'==$type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
                imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }
            // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	imageinterlace($thumbImg,$interlace);
            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image'.($type);
            $length = strlen("0.".$type) * (-1);
            $_type = substr($image,-4);
            $length = ($type != $_type ? $length+1 : $length);
            //裁剪
            if ($suofang==1) {
                //裁剪的时候生成新的图片，jpeg的格式我要换成jpg的
                if($type === "jpeg"){
                    $type = "jpg";
                }
                $thumbname01 = substr_replace($image,"2.".$type,$length);		//大头像
                $imageFun($thumbImg,$thumbname01,100);

                $thumbImg01 = imagecreatetruecolor(190,195);
                imagecopyresampled($thumbImg01,$thumbImg,0,0,$_POST['x1'],$_POST['y1'],190,195,$_POST['x2'],$_POST['y2']);

                $imageFun($thumbImg01,$thumbname01,100);
//				unlink($image);
                imagedestroy($thumbImg01);
                imagedestroy($thumbImg);
                imagedestroy($srcImg);

                return array('big' => $thumbname01);	//返回头像路径的数组
            }else{
                if($is_save == false){											//缩略图覆盖原图，缩略图的路径还是原图路径
                    $imageFun($thumbImg,$image,100);
                }else{
                    $thumbname03 = substr_replace($image,"03.".$type,$length);	//缩略图与原图同时存在，
                    $imageFun($thumbImg,$thumbname03,100);

                    imagedestroy($thumbImg);
                    imagedestroy($srcImg);
                    return $thumbname03 ;					//返回缩略图的路径，字符串
                }
            }

        }
        return false;
    }
}

