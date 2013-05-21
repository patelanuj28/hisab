<?php
date_default_timezone_set('America/Los_Angeles');
set_time_limit(0);

require 'class.PHPWebSocket.php';

function wsOnMessage($clientID, $message, $messageLength, $binary) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
	$sql = "select u.name , round(sum(`individual_amount`),2) as give_anuj from individual i, transaction t, user u where i.user_id = u.id and i.transaction_id = t.id group by i.user_id ";
	
	$con = mysql_connect("127.0.0.1", "root", "") or die('Can\'t connect to the database');
	mysql_select_db('hisab', $con);
	$res = mysql_query($sql);
  $response = array();
	while(	$result = mysql_fetch_array($res)){
	  $response[$result[0]] = $result[1];
	}
	$ans = '';
	foreach($response as $key => $val){
	  $ans .= "$key = $val<br>";
	}
	$ans = trim(trim($ans, '<br>'));
	if(!$ans) $ans= "No Records found!!!";
    $Server->log( $ans ); 
	$Server->wsSend($clientID,$ans);
	
}

function wsOnSummary($clientID) {
    global $Server;
    $ip = long2ip( $Server->wsClients[$clientID][6] );
    
    
    $sql = "select round(sum(amount),2) as total_spent from transaction";
    $sql1= "select round(sum(individual_amount),2) as hisab_done from individual";
    $con = mysql_connect("127.0.0.1", "root", "") or die('Can\'t connect to the database');
    mysql_select_db('hisab', $con);
    $res = mysql_query($sql);
    $result = mysql_fetch_array($res);
    $total_spent = ($result['total_spent']);
    $res1 = mysql_query($sql1);
    $result1 = mysql_fetch_array($res1);
    $hisab_done = ($result1['hisab_done']);

    $ans = "Total Spent : ".$total_spent."<br />Hisab Completed : ".$hisab_done;
    
    $Server->log( $ans );
    
    $Server->wsSend($clientID,$ans);
    
}





function wsOnOpen($clientID)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has connected." );

	foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
			$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.");
}

function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has disconnected." );

	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
}

$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
$Server->bind('summary', 'wsOnSummary');
$Server->wsStartServer('127.0.0.1', 9300);

?>
