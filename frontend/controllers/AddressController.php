<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28 0028
 * Time: 下午 2:59
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\helpers\Json;
use yii\web\Controller;

class AddressController extends Controller
{
    /**
     * @return string
     * 收货地址页面
     *
     */
    public function actionIndex(){
        $adds = Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('index',compact('adds'));
    }

    /**
     * @return string
     * 添加收货地址
     */
    public function actionAdd(){
        if(\Yii::$app->request->isPost){
            $model = new Address();
            $model->load(\Yii::$app->request->post());
            if($model->validate()){
                //给user_id赋值
                $model->user_id = \Yii::$app->user->id;
               if($model->status===null){
                   $model->status=0;
               }else{
                   //将状态设置为1并将其他状态改为0
                   $model->status=1;
                   Address::updateAll(['status'=>0,'user_id'=>$model->user_id]);
               }
                if($model->save()){
                    $result = [
                        'status'=>1,
                        'msg'=>"添加地址成功",
                    ];
                    return Json::encode($result);
                }
            }else{
                $result = [
                    'status'=>0,
                    'msg'=>'注册失败',
                    'data'=>$model->errors
                ];
                return json_encode($result);
            }
        }
        return $this->render('index');
    }
    /**
     * 删除地址
     */
    public function actionDel($id){
        if(Address::find()->where(['id'=>$id,'user_id'=>\Yii::$app->user->id])->one()->delete()){
            return Json::encode([
                'status'=>1,
                'msg'=>'删除成功'
            ]);
        }
    }
    /**
     * 设置默认地址
     */
    public function actionSet($id){
        //找到该条数据  如果他的状态为1 修改为0  如果为0 修改为1
        $add = Address::find()->where(['id'=>$id])->one();
        if($add->status==1){
            $add->status=0;
            $add->save();

        }else{
            //找到状态为1 的数据 将他的状态改为1
            $addold = Address::find()->where(['status'=>1])->one();
            if ($addold){
                $addold->status = 0;
                $addold->save();
            }

            $add->status=1;
            $add->save();

        }

    }
}