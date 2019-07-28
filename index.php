<?php 
if(empty($_SERVER['HTTPS'])) {
    header("Location: https://".$_SERVER['HTTP_HOST']);
    exit;
}

echo '<center><span id="welcome_message"></span></center>';
echo "<center><img src='images/badges_BSM.png'></center>";
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script src="jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<div style="width:560px;margin:auto;border: 1px dotted;" border="1">
	<div style="float:left;border-bottom: 1px dotted;width:100%;">
		<span style="margin-left:10px;" id="users_online"></span>
		<span style="margin-left:10px;"><a href="#" onclick="show_whos_online();">show/hide</a></span>
		<span style="float:right;margin-right:10px;width:330px;" id="winning_players"></span>
		<div id="show_onliners" style="display:none;margin-left:10px;"></div>
	</div>
	<form name="slots">
		<table border="0" cellpadding="3" cellspacing="1" width="560">
			<tr>
				<td>
					<table width="100%">
						<tr align="center">
							<td width="25%"> Burst Balance:<br><input type=box size=5 name="gold" READONLY disabled="disabled" id="gold" size=10></td>
							<td width="25%">Your bet:<br><input type=box size=5 name="bet" value="10" disabled="disabled" size=10></td>
							<td width="25%" title="Enter the amount of Burst you want to use">Auto bet:<br><input type=box size=5 name="betauto" id="betauto" value="0" size=10></td>
							<td width="25%" title="Burst balance for this session">Balance:<br><input type=box size=5 name="bstatus" id="bstatus" value="0" size=10 disabled="disabled"></td>
						</tr>
					</table><hr>
			</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr align="center">
							<td width="25%"><input type=button value="Spin" onclick="rollem();" id="sub"></td>
							<td width="25%"><input type=button value="Auto Start" onclick="autostart();" id="auto"></td>
							<td width="25%"><input type=button value="Auto Stop" onclick="autostop();" id="autos"></td>
							<td width="25%"><input type=button value="Payout" onclick="do_payout();" id="payout"></td>
						</tr>
					</table>
					<br>
				</td>
			</tr>
			<tr><td colspan=2></td></tr>
			<tr>
				<td colspan=2 align="center">
					<table cellspacing=5 cellpadding=2 border=0>
						<tr>
							<td width="260">
								<center>
									<img src="images/13.png" name="slot1" width="75px">
									<img src="images/19.png" name="slot2" width="75px">
									<img src="images/15.png" name="slot3" width="75px">
									<br><br>
								</center>
							</td>
						</tr>
						<tr>
							<td>
								<div style="width:360px;text-align:center;height:28px;border: 1px dotted;" border="1" height="12px;">
									<span name="banner" id="banner" class="blink">
										Spin to win!
									<span>
								</div>							
							</td>
						<tr>
					</table>
				</td>
			</tr>
			<tr align="center">
				<td>
					<center><hr>
						<table width=100% border=0>
							<tr align="center"><td colspan=3><h3><center><a href="https://explorer.burstcoin.network/?action=account&account=<?=$accountID?>" target="_blank"><div id="banksize" title="Bank size">Bank: <?=(int)$jackpot['balance']?> Burst</div></a></center></h3><hr></td></tr>
							<tr align="center"><td colspan=3><h5><span title="Based on current balance"><center>Current High Score</center></span></h5></td></tr>
							<tr align="center"><td><b>1. place</td><td><b>2. place</b></td><td><b>3. place</b></td></tr>
							<tr align="center" id="highscore_from_api"></tr>
							<tr align="center"><td colspan=3><font size=+1><hr><h5><center>Winnings</center></h5></td></tr>							
							<tr align="center"><td><b>Koh-i-Noor<br>Jackpot</b></td><td><img src="images/19.png" width="50px"><img src="images/19.png" width="50px"><img src="images/19.png" width="50px"></td><td><div id="pot75" title="0.00625% chance of winning 75% of the bank"><?=(int)(($jackpot['balance']/100)*75)?> Burst (75%)</div></td></tr>
							<tr align="center"><td>High Gambler</td><td><img src="images/13.png" width="50px"><img src="images/13.png" width="50px"><img src="images/13.png" width="50px"></td><td><div id="pot25" title="0.0125% chance of winning 25% of the bank"><?=(int)($jackpot['balance']/4)?> Burst (25%)</div></td></tr>
							<tr align="center"><td>Three of a kind<br>All icons</td><td><img src="images/15.png" width="50px"><img src="images/15.png" width="50px"><img src="images/15.png" width="50px"></td><td><div id="pot5" title="0.25% chance of winning 5% of the bank"><?=(int)(($jackpot['balance']/100)*5)?> Burst (5%)</div></td></tr>
							<tr align="center"><td>1 Low Gambler<br>1. column</td><td><img src="images/13.png" width="50px"><img src="images/4.png" width="50px"><img src="images/15.png" width="50px"></td><td><div id="pot1" title="5% chance of winning 2% of the bank"><?=(int)(($jackpot['balance']/100)*1)?> Burst (1%)</div></td></tr>
							<tr align="center"><td>Two of a kind<br>All icons/colums</td><td><img src="images/2.png" width="50px"><img src="images/10.png" width="50px"><img src="images/10.png" width="50px"></td><td><div id="pot05" title="10% chance of winning 1% of the bank"><?=(int)(($jackpot['balance']/100)*0.5)?> Burst (0.5%)</div></td></tr>
							
							<tr align="center"><td>None above</td><td><img src="images/6.png" width="50px"><img src="images/3.png" width="50px"><img src="images/1.png" width="50px"></td><td>You Lose</td></tr>
							<tr align="center"><td colspan="3"><center><b>* Only the highest winning is rewarded *</b></center></td><td>
						</table>
					</center>
					<hr>
				</td>
			</tr>
			<tr>
				<td>
					<table width=100% border=0>
						<tr align="center">
							<td>Total payout:<br><input type=text readonly size=10 name="pay_to_user_total" value=0></td>
							<td>Total spent:<br><input type=text readonly size=10 name="spent_by_user_total" value=0></td>
							<td>Payout:<br><input type=text readonly size=10 name="payout_pct" value=0></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr>
					<ul>
						<li>To play: Send Burst to <a href="https://explorer.burstcoin.network/?action=account&account=<?=$accountID?>" target="_blank"><?=$accountRS?></a></li>
						<li>Payments less than 10 Burst and/or with decimals will be discarded/lost</li>
						<li>Payments needs to have 1 confirmation</li>
						<li>You will receive an encrypted message in you BRS wallet with a link</li>
						<li>Payout minimum is 10 Burst</li>
						<li>1 Burst will be substracted for transaction fee (message and payout)</li>
						<li>All transactions for the game is avaliable on the Burst Explorer</li>
						<li>Spin 10 Burst: 99% goes to the Bank, 1% system fee = 99% Payout!</li>
						<li>Payout can be forced by the system due to maintenance (rare occasions)</li>
					</ul>
				</td>
			</tr>
		</table>		
	</form>
</div>
<?if($result['transaction_id']){?>
<center><b>Transaction: # <a href="https://explorer.burstcoin.network/?action=transaction&id=<?=$result['transaction_id']?>" target="_blank"><?=$result['transaction_id']?></a></b></center>
<?}?>
<br><br>
<script>
var slotajax = false;
var auto_run = false;
var endless = false;
var startgold = <?Php echo $Burst_balance;?>;
var timer;
var onlineusers = false;
var current_version = false;
var version = false;
var winner_id = false;
var welcome = '<?php echo $welcome;?>';
document.slots.gold.value=startgold;
document.getElementById('autos').disabled = true;

onlinestats();
winnerstats();
loginstats();
balancestats();
document.getElementById("winning_players").innerHTML = '<MARQUEE LOOP="1">' + welcome + '</MARQUEE>';

if(startgold <= 9){
	document.getElementById('sub').disabled = true;
	document.getElementById('auto').disabled = true;
	document.getElementById('betauto').disabled = true;
	document.getElementById('payout').disabled = true;
	document.getElementById('autos').disabled = true;
}

function show_whos_online() {
  var x = document.getElementById("show_onliners");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function versionControl(){
	$.ajax({
		type: 'GET',
		url: 'https://burstcoin.dk/version',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(response) {
			version = response;
			if(current_version!='' && current_version!=version){
				document.slots.gold.value=0;
				document.getElementById('sub').disabled = true;
				document.getElementById('auto').disabled = true;
				document.getElementById('payout').disabled = true;
				document.getElementById('betauto').disabled = true;
				document.getElementById("banner").innerHTML = '<img src="images/264608_alert_256x256.png" width="26px" style="margin-bottom:5px;"> New version avaliable - Please reload <img src="images/264608_alert_256x256.png" width="26px" style="margin-bottom:5px;">';
			}
			current_version = version;
		}
	});
}

function onlinestats(){
	$.ajax({
		type: 'GET',
		url: 'https://burstcoin.dk/ajax_online.php',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(response) {
			onlineusers = response;
			document.getElementById("users_online").innerHTML = 'Users online: ' + onlineusers.online_users.count;
			document.getElementById("show_onliners").innerHTML = onlineusers.online_users_senderRS;
			if(winner_id!='' && winner_id!=onlineusers.w_p_id){
				winner_id=winner_id=onlineusers.w_p_id;
				document.getElementById("winning_players").innerHTML = '<MARQUEE LOOP="1">' + onlineusers.w_p + '</MARQUEE>';
				//console.log(onlineusers);
			}
			if(winner_id==''){
				winner_id=winner_id=onlineusers.w_p_id;
			}
		}
	});
}

function winnerstats(){
	$.ajax({
		type: 'GET',
		url: 'https://burstcoin.dk/ajax_highscore.php',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(response) {
			winners = response;
			document.getElementById("highscore_from_api").innerHTML = winners.highscore;
		}
	});
}


function loginstats(){
	$.ajax({
		type: 'GET',
		url: 'https://burstcoin.dk/ajax_login.php?idk=<?=$_GET['idk']?>',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(response) {
			login = response;
			startgold=login.balance;
			document.getElementById("welcome_message").innerHTML = login.welcome_msg;
			document.slots.gold.value=login.balance;
			
		}
	});
}

function balancestats(){
	$.ajax({
		type: 'GET',
		url: 'https://burstcoin.dk/ajax_balance.php',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(response) {
			api_balance = response;
			document.getElementById("pot75").innerHTML = Math.floor((api_balance.balance.balance/100)*75) + ' Burst (75%)';
			document.getElementById("pot25").innerHTML = Math.floor((api_balance.balance.balance/100)*25) + ' Burst (25%)';
			document.getElementById("pot5").innerHTML = Math.floor((api_balance.balance.balance/100)*5) + ' Burst (5%)';
			document.getElementById("pot1").innerHTML = Math.floor((api_balance.balance.balance/100)*1) + ' Burst (1%)';
			document.getElementById("pot05").innerHTML = Math.floor((api_balance.balance.balance/100)*0.5) + ' Burst (0.5%)';
			
			document.getElementById("banksize").innerHTML = 'Bank: ' + Math.floor(api_balance.balance.balance) + ' Burst';
		}
	});
}

setInterval(function() {
    onlinestats();
	winnerstats();
	versionControl();
}, 15 * 1000); // 60 * 1000 milsec

function do_payout(){
	var pay = confirm('Payout ' + document.slots.gold.value + ' Burst - are you sure?');
	if(pay == true){
		$.ajax({
			type: 'GET',
			url: 'https://burstcoin.dk/ajax.php?idk=<?=$_GET['idk']?>&payout=1',
			dataType: 'json',
			cache: false,
			async: false,
			success: function(result) {
				slotajax_dfv = result;
				document.getElementById("banner").innerHTML = slotajax_dfv.price;
				document.slots.gold.value=0;
				document.getElementById('sub').disabled = true;
				document.getElementById('auto').disabled = true;
				document.getElementById('payout').disabled = true;
				document.getElementById('betauto').disabled = true;
			}
		});
	} else return;
}

function autostop(){
	auto_run = false;
	endless = false;
	document.getElementById('sub').disabled = false;
	document.getElementById('auto').disabled = false;
	document.getElementById('betauto').disabled = false;
	document.getElementById('payout').disabled = false;
	document.getElementById('autos').disabled = true;
	document.slots.betauto.value=0;
}

function autostart(){
	auto_run = true;
	document.getElementById('betauto').disabled = true;
	document.getElementById('autos').disabled = false;
	if(document.slots.betauto.value==0){
		endless = true;
	}
	rollem();
}

function rollem () {
	StopBlinking();
	if (Math.floor(document.slots.gold.value) < Math.floor(document.slots.bet.value)) {
		document.getElementById("banner").innerHTML = "Your out of Burst";
		autostop();
		document.getElementById('sub').disabled = true;
		document.getElementById('auto').disabled = true;
		document.getElementById('betauto').disabled = true;
		if(Math.floor(document.slots.gold.value)<=9){
			document.getElementById('payout').disabled = true;
		}
		return;
	}
	if(auto_run == true && Math.floor(document.slots.betauto.value) < 10 && endless==false){
		autostop();
		return;
	}

	document.getElementById("banner").innerHTML = "";
	counter=0;
	ajaxUpdate();
		
}

function ajaxUpdate(){
 
	$.ajax({
		 type: 'GET',
		 url: 'https://burstcoin.dk/ajax.php?idk=<?=$_GET['idk']?>',
		 dataType: 'json',
		 cache: false,
		 async: false,
		 success: function(result) {
		 slotajax = result;
		spinem();
		}
		});
}

function spinem() {
	document.getElementById('sub').disabled = true;
	document.getElementById('auto').disabled = true;
	document.getElementById('payout').disabled = true;
	document.getElementById('betauto').disabled = true;
	
	if(counter>=6){
		turns1=slotajax.spin1;
	} else {
		turns1=Math.floor(Math.random()*20) + 1;
	}
	for (a=0;a<turns1;a++){
		document.slots.slot1.src="images/"+turns1+".png"; 
	}

	if(counter>=12){
		turns2=slotajax.spin2;
	} else {
		turns2=Math.floor(Math.random()*20) + 1;
	}
	for (b=0;b<turns2;b++){
		document.slots.slot2.src="images/"+turns2+".png";
	}

	if(counter>=18){
		turns3=slotajax.spin3;
	} else {
		turns3=Math.floor(Math.random()*20) + 1;
	}
	for (c=0;c<turns3;c++){
		document.slots.slot3.src="images/"+turns3+".png";
	}
	counter++;
	if (counter<20) {
		setTimeout("spinem(counter);",200);
	} else {
		if(auto_run == false){
			document.getElementById('sub').disabled = false;
			document.getElementById('auto').disabled = false;
			document.getElementById('payout').disabled = false;
			document.getElementById('betauto').disabled = false;
		}	
		document.getElementById("banner").innerHTML = slotajax.price;
		document.slots.gold.value=slotajax.bonus;			
		document.slots.bstatus.value=Math.floor(document.slots.bstatus.value)+slotajax.reward;
						
		document.getElementById("pot75").innerHTML = Math.floor((slotajax.potsize/100)*75) + ' Burst (75%)';
		document.getElementById("pot25").innerHTML = Math.floor((slotajax.potsize/100)*25) + ' Burst (25%)';
		document.getElementById("pot5").innerHTML = Math.floor((slotajax.potsize/100)*5) + ' Burst (5%)';
		document.getElementById("pot1").innerHTML = Math.floor((slotajax.potsize/100)*1) + ' Burst (1%)';
		document.getElementById("pot05").innerHTML = Math.floor((slotajax.potsize/100)*0.5) + ' Burst (0.5%)';
		
		document.getElementById("banksize").innerHTML = 'Bank: ' + Math.floor(slotajax.potsize) + ' Burst';
		
		document.slots.pay_to_user_total.value=slotajax.pay_to_user_total;
		document.slots.spent_by_user_total.value=slotajax.spent_by_user_total;
		document.slots.payout_pct.value=slotajax.payout_pct;
		
		if(auto_run === true){
			if(endless===false){
				document.slots.betauto.value=document.slots.betauto.value-10;
			}
			if(slotajax.reward>=1){
				setTimeout(function(){
					rollem()
				},3500);
			} else {
				setTimeout(function(){rollem()},1000);
			}
			
		}
	}
	if(Math.floor(document.slots.gold.value)<=9){
		document.getElementById('payout').disabled = true;
	}
}

function BlinkingText(){
	if(document.getElementById("banner").value == ""){
		document.getElementById("banner").value = slotajax.price;
	} else {
		document.getElementById("banner").value = "";
	}
	timer = setTimeout("BlinkingText()", 600);
}

function StopBlinking(){
  clearTimeout(timer);
}
</script>