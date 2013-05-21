<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<?php if (!Yii::app()->user->isGuest){?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fancywebsocket.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script>
        var Server;

        function log( text ) {
            $log = $('#perhead');
            //Add text to log
            var val = $log.html();
              
            if(val != text){
                $log.html(($log.val()?"\n":'')+text).addClass('red').fadeOut('fast').fadeIn('fast');
            }else{
             
             //$log.html(($log.val()?"\n":'')+text).removeClass('green').addClass('black');
             $log.html(($log.val()?"\n":'')+text);
            }            
            
            
            $log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
        }
        function over_summary( text ) {
            $log = $('#overall_summary');
            //Add text to log
            var val = $log.html();
              
            if(val != text){
                $log.html(($log.val()?"\n":'')+text).addClass('red').fadeOut('fast').fadeIn('fast');
            }else{
             
             //$log.html(($log.val()?"\n":'')+text).removeClass('green').addClass('black');
             $log.html(($log.val()?"\n":'')+text);
            }            
            
            
            $log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
        }

        function send( text ) {
            Server.send( 'message', text );
            //Server.send( 'summary', text );
        }

        $(document).ready(function() {
            
         
            //log('Connecting...');
            Server = new FancyWebSocket('ws://127.0.0.1:9300');
            
            function sending(){
                send( "update");
            }
            setInterval(sending,1000);
            //Let the user know we're connected
            Server.bind('open', function() {
                //log( "Connected." );
            });

            //OH NOES! Disconnection occurred.
            Server.bind('close', function( data ) {
                //log( "Disconnected." );
            });
            
            //Server.bind('summary', function( summary1 ) {
                //over_summary( summary );
            //   alert(summary1);
            //});
            



            //Log any messages sent from server
            Server.bind('message', function( payload ) {
                log( payload );
            });
            
                        Server.connect();
        });
    </script>
    <?}?>
</head>

<body>
    <?php if (!Yii::app()->user->isGuest){?>
        <div id="perhead" class='red'>
        
        <?php 
           $tot = Controller::total_on_top();
           if(is_array($tot) && count($tot) > 0){
               $b = array();
               foreach($tot as $k => $v){
                    $b[] =  implode(" = ", $v);
               }
               echo trim(implode("<br>", $b), ",");
           }else{
               echo "No Records found!!!";
           }
        ?>
        
        </div><br /><br />
        <div id="overall_summary" class='green'>
            Total Spent : <? $test = Controller::query('select round(sum(amount),2) as total_spent from transaction');?>
            <?php foreach($test as $key=>$val)echo($val['total_spent']);?>
            <br />
            Hisab Completed : <? $test1 = Controller::query('select round(sum(individual_amount),2) as hisab_done from individual');?>
            <?php foreach($test1 as $key=>$val)echo($val['hisab_done']);?>
        </div>
    <?}?>
<div class="container" id="page">
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Transaction', 'url'=>array('/transaction/admin', 'view'=>'about'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Users', 'url'=>array('/user/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Individuals', 'url'=>array('/user/individuals'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div>
	
	
	
	<!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Anuj Patel.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->
</body>
</html>
