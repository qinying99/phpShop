<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    /**
     * @return string
     * 权限列表
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //找到所有嘚权限
        $pers  =$auth->getPermissions();
        //视图
        return $this->render('index',compact('pers'));
    }
    /**
     * @return string
     * 添加权限
     */
    public function actionAdd(){
        //创建模型对象
        $authItem = new AuthItem();
        //判断post提交
        if($authItem->load(\Yii::$app->request->post()) && $authItem->validate()){
            //创建auth对象
            $auth = \Yii::$app->authManager;
            //创建权限
            $per = $auth->createPermission($authItem->name);
            //设置权限描述
            $per->description=$authItem->description;
            //权限入库
            if ($auth->add($per)) {
                \Yii::$app->session->setFlash('success','添加权限'.$authItem->name.'成功');
                return $this->refresh();
            }
        }


        //视图
        return $this->render('add',compact('authItem'));
    }
    /**
     * @return string
     * 修改权限
     */
    public function actionEdit($name){
        //找到该条数据
        $authItem =AuthItem::findOne($name);
        //判断post提交
        if($authItem->load(\Yii::$app->request->post()) && $authItem->validate()){
            //创建auth对象
            $auth = \Yii::$app->authManager;
            //得到权限
            $per = $auth->getPermission($authItem->name);
            //设置权限描述
            $per->description=$authItem->description;
            //权限入库
            if ($auth->update($authItem->name,$per)) {
                \Yii::$app->session->setFlash('success','修改权限'.$authItem->name.'成功');
                return $this->refresh();
            }
        }
        //视图
        return $this->render('edit',compact('authItem'));
    }
    /**
     * 删除权限
     */
    public function actionDel($name){
        if(AuthItem::findOne($name)->delete()){
            \Yii::$app->session->setFlash('danger','删除权限'.$name.'成功');
            return $this->redirect(['index']);
        }
    }
}
