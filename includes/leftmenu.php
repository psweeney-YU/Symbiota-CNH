<div class="menu">
	<div class="menuheader">
<!-- 
		<a href="<?php echo $clientRoot; ?>/index.php">
			<?php echo $defaultTitle; ?> Homepage
		</a>
 -->
 		<div style="padding: 0.5em;">
 			Portal Menu
 		</div>
	</div>
	<div class="menuitem">
		<a href="<?php echo $clientRoot; ?>/collections/index.php">
			Text-based Search
		</a>
	</div>
	<div class="menuitem">
		<a href="<?php echo $clientRoot; ?>/collections/map/mapinterface.php">
			Map-guided Search
		</a>
	</div>		
	<div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/collections/misc/collprofiles.php">
    		Collections
    	</a>
    </div>
    <div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/checklists/index.php">
    		Species Lists
    	</a>
    </div>
<!-- 
	<div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/ident/index.php">
    		Identification Keys
    	</a>
    </div>

    <div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/checklists/dynamicmap.php">
    		Dynamic Species List
    	</a>
    </div>

    <div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/imagelib/index.php">
    		Image Library
    	</a>
    </div>
-->
    <div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/sitemap.php">
    		Sitemap
    	</a>
    </div>
    
    <div class="menuitem">
    	<a href="<?php echo $clientRoot; ?>/collections/specprocessor/crowdsource/central.php">
    		Crowdsourcing
    	</a>
    </div>

	<div>
		<hr/>
	</div>
	<?php
	if($userDisplayName){
	?>
		<div class='menuitem'>
			Welcome <?php echo $userDisplayName; ?>!
		</div>
		<div class="menuitem">
			<a href="<?php echo $clientRoot; ?>/profile/viewprofile.php">My Profile</a>
		</div>
		<div class="menuitem">
			<a href="<?php echo $clientRoot; ?>/profile/index.php?submit=logout">Logout</a>
		</div>
	<?php
	}
	else{
	?>
		<div class="menuitem">
			<a href="<?php echo $clientRoot."/profile/index.php?refurl=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
				Log In
			</a>
		</div>
		<div class="menuitem">
			<a href="<?php echo $clientRoot; ?>/profile/newprofile.php">
				New Account
			</a>
		</div>
	<?php
	}
	?>
</div>
<!--
<div>
	<div style="padding: 0px 20px;font-size:12pt;color:blue;font-weight:bold;"><a href="http://tinyurl.com/WeDigBio-NEVP">WeDigBio @ Yale!</a></div>
</div>
--!>


