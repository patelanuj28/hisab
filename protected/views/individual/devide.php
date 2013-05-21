<h3>Total Price : <?=$tran->amount
?></h3>
<h3>Individuals</h3>
<div id="individual">
    <input type="hidden" value="<?=$tran -> amount;?>" name ="amount" id="amount"/>
    <input type="hidden" value="<?=$tran -> id;?>" name ="tran_id" id="tran_id"/>
    <?php

 foreach ($user as $key => $value) {
     $val = '';
     if(Yii::app()->user->id == "demo"){
        $disable = 'disabled="disabled"';
     }
     else {
         $disable = '';
     }
     $checked = $amt = "";
     if($value->name =="Anuj"){
        $amt = $tran->amount;
         $checked = "checked";
     }
     if(isset($ind[$tran->id][$value->id])){
        $val = $ind[$tran->id][$value->id];
     }
     $val = ($val <= 0)? '':$val;
     if($val >0){
         $checked = "checked";
     }
    ?>
    <div style="width:182px; padding:3px;">
        <input type="checkbox" name="<?=$value->id?>" <?=$disable;?> <?=$checked;?>  value="<?=$value->id?>" style="text-align:left;">
        <?=$value->name
        ?></input>
        <input type="text" <?=$disable;?> name="txt_<?=$value->id?>"  value="<?=($val) ? $val : $amt;?>" style="width:50px; float:right;">
    </div>
    <?
    }
    ?><br />
    <br />
    <input type="button" id="btn_save" name="btn_save"  value="Save" style="width:100px; float:right;">
</div>
<?php

?>
<script>
    function countChecked() {
        var n = $("input:checked").length;
        return n;
    }

    function calculate_individual() {

        var tran_amount = $('#amount').val();
        var tot_checked = countChecked();

        $('input[type=checkbox]').each(function() {
            if(this.checked) {
                var ind_amt = (tran_amount / tot_checked).toFixed(2);
                $(this).next('input').val(ind_amt);
            } else {
                //console.log("chk : false");
                $(this).next('input').val("");
            }
        });
    }

    function get_sql() {
        var tran_ind = {};
        var sql_val = {};
        var tran_id = $('#tran_id').val();
        $('input[type=checkbox]').each(function() {
            var key = $(this).attr('name');
            var val = $(this).next('input').val();
            sql_val[key] = val;
        });
        tran_ind["tran_id"] = tran_id;
        tran_ind["data"] = sql_val;
        //console.log(sql_val);
        //console.log(tran_ind);
        return tran_ind;
    }

    function count_total() {

        var i = 0;
        var arr;
        var cost = $('#amount').val();
        arr = new Array();

        $('#individual').find('div').each(function() {
            var txt_val = $('input[type=text]', this).val();
            if(txt_val) {
                arr[i] = txt_val;
                i++;
            }
        });
        var total = 0;
        //console.log(arr);
        $.each(arr, function() {
            total += parseFloat(this);

        });
        //alert("total : " + total + " cost : " + (parseInt(cost) + 5));
        if((total >= (parseInt(cost) + 30))) {
            alert("individual amount is too high please calculate individual amount carefully!!!");
            calculate_individual();
        } else if((total <= (parseInt(cost) - 30 ))) {
            alert("individual amount is too low please calculate individual amount carefully!!!");
            calculate_individual();
        } else if(total < 0) {
            alert("Enter value is wrong please check individual amount!!!");
        } else {
            //console.log("nothing to calculate");
        }

    }


    $(document).ready(function() {

        $(":checkbox").click(function() {
            calculate_individual();
            count_total();
            //get_sql();

        });

        $('#btn_save').click(function() {
            
            var save_url = "<?php echo $this->createUrl('individual/save');?>";
            var tran = get_sql();
            $.ajax({
            async:true,
            cache:false,
            data: tran,
            type:'get',
            dataType: "json",
            url: save_url,
            beforeSend: function(){
                
            },
            success: function(data) {
                //$('#ind_chkbox').html(data).fadeIn('slow').show(true);
                console.log(data);
            }
        });

        });

        $('input[type=text]').change(function() {
            count_total();

        });
    });

</script>