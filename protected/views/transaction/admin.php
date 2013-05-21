<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

function humandate($date){
    //return $date;
    //return "anuj";
    $date1 = explode("/", $date);
    //print_r($date1);
    return date("M", mktime(0, 0, 0, $date1[0], $date1[1], $date1[2])). " ". $date1[1] ." ". $date1[2];
}
function humanday($date){
    //return $date;
    //return "anuj";
    $date1 = explode("/", $date);
    //print_r($date1);
    return date("l", mktime(0, 0, 0, $date1[0], $date1[1], $date1[2]));
}
?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transaction-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate' => false,
	'filter'=>$model,
	'columns'=>array(
		'id',
		'bank_name',
		'tran_date',
		array(
		'header' => 'Human Date',
		'name'=>'tran_date',               
        'value'=> 'humandate($data->tran_date)',
        'htmlOptions' => array(
            'style' => 'text-align: right; font-weight: bold; font-size: 13px;',
            ),
        ),
        array(
        'header' => 'Day',
        'name'=>'tran_date',               
        'value'=> 'humanday($data->tran_date)',
        'htmlOptions' => array(
                'style' => 'text-align: right; font-weight: bold; font-size: 13px;',
                ),
            ),
        
		'description',
		array('name'=>'amount',               
		'value'=> '$data->amount',
		'htmlOptions' => array(
		        'style' => 'text-align: right; font-weight: bold; font-size: 13px;',
			    ),
			),

		/*
		'created_date',
		'updated_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>


<script>
$('#transaction-grid > table > tbody > tr').click(function(){
    
    var tnx_id=$(this).find("td:first-child").text();
    //console.log(tnx_id);
    edit(tnx_id);
    
});

function edit(tnx_id){
    var devide_url = "<?php echo $this->createUrl('individual/devide');?>";
    $.ajax({
            async:true,
            cache:false,
            data: 'partial=true&tnx_id='+tnx_id,
            type:'get',
            url: devide_url,
            beforeSend: function(){
                
            },
            success: function(data) {
                $('#ind_chkbox').html(data).fadeIn('slow').show(true);
            }
        });
}
  

    </script>