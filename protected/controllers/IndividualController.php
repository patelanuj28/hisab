<?php

class IndividualController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array('accessControl',   // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array( array('allow', // allow all users to perform 'index' and 'view' actions
        'actions' => array('index', 'view', 'devide', 'save'), 'users' => array('*'), ), array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions' => array('create', 'update', 'devide', 'save'), 'users' => array('@'), ), array('allow', // allow admin user to perform 'admin' and 'delete' actions
        'actions' => array('admin', 'delete', 'devide', 'save'), 'users' => array('admin'), ), array('deny', // deny all users
        'users' => array('*'), ), );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this -> render('view', array('model' => $this -> loadModel($id), ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Individual;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Individual'])) {
            $model -> attributes = $_POST['Individual'];
            if ($model -> save())
                $this -> redirect(array('view', 'id' => $model -> id));
        }

        $this -> render('create', array('model' => $model, ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this -> loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Individual'])) {
            $model -> attributes = $_POST['Individual'];
            if ($model -> save())
                $this -> redirect(array('view', 'id' => $model -> id));
        }

        $this -> render('update', array('model' => $model, ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app() -> request -> isPostRequest) {
            // we only allow deletion via POST request
            $this -> loadModel($id) -> delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this -> redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Individual');
        $this -> render('index', array('dataProvider' => $dataProvider, ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Individual('search');
        $model -> unsetAttributes();
        // clear any default values
        if (isset($_GET['Individual']))
            $model -> attributes = $_GET['Individual'];

        $this -> render('admin', array('model' => $model, ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Individual::model() -> findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'individual-form') {
            echo CActiveForm::validate($model);
            Yii::app() -> end();
        }
    }

    public function actionDevide($tnx_id = 0, $partial = false) {

        if ((int)$tnx_id == "0")
            throw   exception("503", "Invalid data!!");
        $user = User::model() -> findAll();
        $details = $this -> query("select * from individual where transaction_id =" . $tnx_id);
        $saved = array();
        if (null !== $details) {
            foreach ($details as $k => $v) {
                $saved[$tnx_id][$v["user_id"]] = $v["individual_amount"];
            }
        }
        
       $tran = Transaction::model() -> findByPk($tnx_id);
       
        $this -> renderPartial('devide', array('user' => $user, 'tran' => $tran, 'ind' => $saved, 'demo' => Yii::app() -> user), false, true);

    }

    public function actionSave() {
        $values = array();
        if (isset($_GET["tran_id"])) {
            $tran_id = $_GET["tran_id"];
            //echo count($_GET["data"]);

            foreach ($_GET["data"] as $key => $val) {
                $val = (is_numeric($val)) ? $val : 0;
                $values[] = "(" . $tran_id . "," . $key . "," . $val . ")";
            }
            $ins_values = (implode(",", $values));

            //$del_sql = "delete from individual where transaction_id = ". $tran_id;
            //$this->query($del_sql);
            $test = Individual::model() -> deleteAllByAttributes(array('transaction_id' => $tran_id));

            $ins_sql = "insert into individual (transaction_id, user_id, individual_amount)  values " . $ins_values;
            $this -> query($ins_sql);

        }
        /*
        $tot = Controller::total_on_top();
           if(is_array($tot) && count($tot) > 0){
               $b = array();
               foreach($tot as $k => $v){
                    $b[] =  implode(" => ", $v);
               }
               return trim(implode("<br />", $b), ",");
           }else{
               return "No Records found!!!";
           }
        */

    }

}
