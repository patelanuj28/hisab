<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
    public $demo = false;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    
    public static function SqlGetRows($sql, $cn=null)
    {
        if(null == $cn)
        {
            $cn = Yii::app()->db;
        }
        $command=$cn->createCommand($sql);
        return $command->queryAll();
    }
    
    public static function total_on_top($cn=null)
    {
        if(null == $cn)
        {
            $cn = Yii::app()->db;
        }
        $sql = "select u.name , round(sum(`individual_amount`),2) as give_anuj from individual i, transaction t, user u where i.user_id = u.id and i.transaction_id = t.id group by i.user_id ";
        $command=$cn->createCommand($sql);
        return $command->queryAll();
    }
    
    public static function query($sql, $cn=''){
        if(null == $cn){
            $cn = Yii::app()->db;
        }

        $command=$cn->createCommand($sql);
        return $command->query();

    }
    
}