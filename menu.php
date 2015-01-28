<nav class="navbar navbar-default">
	<ul class="nav navbar-nav">
		<li><a href="/">Histoire</a></li>
<?php
	if(isset($chap))
	{?>
	<li<?php if(isset($correctionMode)) echo ' class="active"';?>><a href="/chapitre-<?php echo $chap;?><?php if(!isset($correctionMode)) echo '/corriger';?>" title="Participer à la correction de ce chapitre">Corriger</a></li>
<?php
	}?>
		<li><a href="/corrections-proposees">Corrections proposées</a></li>
		<li><a href="/ecrivain/regles">Règles</a></li>
		<li><a href="/ecrivain/histoire">Aide à l'écriture</a></li>
		<li><a href="http://zestedesavoir.com/forums/sujet/1206/un-zeste-sans-fin/" target="_blank">Forum</a></li>
		<li><a href="#" onclick="openIRC()">Canal IRC</a></li>
	</ul>
</nav>

<script type="text/javascript">
	function openIRC() {
		window.open("/canal-irc", "ircwindow", "menubar=no,status=no,scrollbars=no,width=700,height=550");
	}
</script>
