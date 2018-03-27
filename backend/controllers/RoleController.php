<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\AuthAssignment;
use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    /*
     * 角色列表
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //找到所有的角色
        $roles = $auth->getRoles();
        //找到所有的权限
        return $this->render('index',compact('roles'));
    }
    /*
     * 添加角色
     */
    public function actionAdd(){
        //创建模型对象
        $authItem = new AuthItem();
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //得到所有de权限
        $pers = $auth->getPermissions();
        $persArr = ArrayHelper::map($pers,'name','description');
        //判断post提交
        if($authItem->load(\Yii::$app->request->post()) && $authItem->validate()){
            //创建角色
            $role = $auth->createRole($authItem->name);
            //设置角色描述
            $role->description=$authItem->description;
            //角色入库
            if ($auth->add($role)) {
                //判断有没有添加权限
                if ($authItem->permissions){
                    //给当前角色添加权限
                    foreach ($authItem->permissions as $perName){
                        //通过权限名得到权限对象
                        $per = $auth->getPermission($perName);
                        $auth->addChild($role,$per);
                    }
                    \Yii::$app->session->setFlash('success','添加角色'.$authItem->name.'成功');
                    return $this->refresh();
                }
            }
        }
        //视图
        return $this->render('add',compact('authItem','persArr'));
    }
    /*
     * 修改角色
     */
    public function actionEdit($name){
        //创建模型对象
        $authItem = AuthItem::findOne($name);
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //得到所有de权限
        $pers = $auth->getPermissions();
        $persArr = ArrayHelper::map($pers,'name','description');
        //得到当前角色所对应嘚所有权限  array_keys==得到所有嘚key值
        $authItem->permissions = array_keys($auth->getPermissionsByRole($name));
        //判断post提交
        if($authItem->load(\Yii::$app->request->post()) && $authItem->validate()){
            //得到角色
            $role = $auth->getRole(($authItem->name));
            //设置角色描述
            $role->description=$authItem->description;
            //角色入库
            if ($auth->update($authItem->name,$role)) {
                //删除当前角色对应嘚所有权限
                $auth->removeChildren($role);
                if ($authItem->permissions){
                    //给当前角色添加权限
                    foreach ($authItem->permissions as $perName){
                        //通过权限名得到权限对象
                        $per = $auth->getPermission($perName);
                        $auth->addChild($role,$per);
                    }
                }
                \Yii::$app->session->setFlash('success','修改角色'.$authItem->name.'成功');
                return $this->redirect(['index']);
            }
        }
        //视图
        return $this->render('edit',compact('authItem','persArr'));
    }
    /*
     * 角色删除
     */
    public function actionDel($name){
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //得到角色
        $role = $auth->getRole($name);
        //删掉该条数据
        if ($auth->remove($role)){
            \Yii::$app->session->setFlash('danger','删除角色成功');
            return $this->redirect(['index']);
        }
    }
    /*
     * 给用户指派角色
     */
    public function actionAdmin(){
        $ass = new AuthAssignment();
        //获取所有的用户
        $admins = Admin::find()->all();
        $adminArr = ArrayHelper::map($admins,'id','name');
        //获取所有的角色组
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRoles();
        $roleArr = ArrayHelper::map($roles,'name','name');
        if ($ass->load(\Yii::$app->request->post()) && $ass->validate()){
            //通过角色名找到角色对象
            $role = $auth->getRole($ass->item_name);
            //把用户指派给组
            $auth->assign($role,$ass->user_id);
            \Yii::$app->session->setFlash('success','指派成功');
            return $this->redirect(['index']);
        }
        //视图
        return $this->render('admin',compact('ass','adminArr','roleArr'));
    }
}
