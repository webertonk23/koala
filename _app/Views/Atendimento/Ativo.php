<?php


?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Ativo</h3>
	</div>
</div>

<div class="card">
	<div class='card-body text-center'>
		<p class='card-text'>
			<label  id="output" style="font-size:100px;">0:00:00</label>
		</p>
	</div>
</div>

<script>
	var n = 1;
	var l = document.getElementById("output");
	window.setInterval(function(){
		var h = parseInt(n/3600);
		var m = parseInt((n%3600)/60);
		var s = n%60;

		if(m < 10){
			m = "0"+m;
			m = m.substr(0, 2);
		}

		if(s <=9){
			s = "0"+s;
		}


		l.innerHTML = "0:" + m + ":" + s;;
		n++;
	},1000);
</script>