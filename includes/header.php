<SCRIPT LANGUAGE=JAVASCRIPT>
<!--
if (top.frames.length!=0)
  top.location=self.document.location;
// -->
</SCRIPT>
<table id="maintable" cellspacing="0">
	<tr>
		<td class="header" colspan="3" style="">
			<div style="height:207px;background-repeat:no-repeat;position:relative;">
			<div style="clear:both;">
				<div style="clear:both;">
					<img style="display:block;margin: 0 auto;" src="<?php echo $clientRoot; ?>/images/layout/drupal_header.jpg" />
				</div>
			</div>
		</td>
	<tr>
		<td class="menurow" colspan="3">
				<ul class="navlinks">
					<li style="border:0;"><a href="/portal/about.php" title="About">About</a></li>
					<li><a href="/portal" title="Portal">Portal</a></li>
					<li><a href="/portal/membership.php" title="Membership">Membership</a></li>
					<li><a href="/portal/governance.php" title="Governance">Governance</a></li>
					<li><a href="/portal/meetings.php" title="Meetings">Meetings</a></li>
					<!-- <li><a href="http://neherbaria.org/digit_resource" title="Resources">Resources</a></li> -->
				</ul>
		</td>
	<tr>
	</tr>
    <tr>
	<?php 
	if($displayLeftMenu){
		?> 
		<!-- <td class='middleleft'  background="<?php echo $clientRoot;?>/images/layout/leftstrip.gif" style="background-repeat:repeat-y;"> -->
		<td class ='middleleft'>	
			<div>
				<?php include($serverRoot."/leftmenu.php"); ?>
			</div>
		</td>
		<?php 
	}
	else{
		?>
        <!-- 	<td class="middleleftnomenu" background="<?php echo $clientRoot;?>/images/layout/leftstrip.gif"> -->
        		<div style='width:20px;'></div>
        	</td>
        <?php 
	}
	?>
	<td class='middlecenter'>

		