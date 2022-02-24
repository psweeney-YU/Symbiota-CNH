<div class="menu">
	<div class="menuheader">
<!--
		<a href="<?php echo $CLIENT_ROOT; ?>/index.php">
			<?php echo $DEFAULT_TITLE; ?> Homepage
		</a>
 -->
 		<div style="padding: 0.5em;">
 			Portal Menu
 		</div>
	</div>
	<div class="menuitem">
		<a href="<?php echo $CLIENT_ROOT; ?>/collections/index.php">
			Text-based Search
		</a>
	</div>
	<div class="menuitem">
		<a href="<?php echo $CLIENT_ROOT; ?>/collections/map/index.php">
			Map-guided Search
		</a>
	</div>
	<div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/collections/misc/collprofiles.php">
    		Collections
    	</a>
    </div>
    <div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/checklists/index.php">
    		Species Lists
    	</a>
    </div>
<!--
	<div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/ident/index.php">
    		Identification Keys
    	</a>
    </div>

    <div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/checklists/dynamicmap.php">
    		Dynamic Species List
    	</a>
    </div>

    <div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/imagelib/index.php">
    		Image Library
    	</a>
    </div>
-->
    <div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/sitemap.php">
    		Sitemap
    	</a>
    </div>

    <div class="menuitem">
    	<a href="<?php echo $CLIENT_ROOT; ?>/collections/specprocessor/crowdsource/central.php">
    		Crowdsourcing
    	</a>
    </div>

	<div>
		<hr/>
	</div>
	<?php
	if($USER_DISPLAY_NAME){
		?>
		<div class='menuitem'>
			Welcome <?php echo $USER_DISPLAY_NAME; ?>!
		</div>
		<div class="menuitem">
			<a href="<?php echo $CLIENT_ROOT; ?>/profile/viewprofile.php">My Profile</a>
		</div>
		<div class="menuitem">
			<a href="<?php echo $CLIENT_ROOT; ?>/profile/index.php?submit=logout">Logout</a>
		</div>
		<?php
	}
	else{
		?>
		<div class="menuitem">
			<a href="<?php echo $CLIENT_ROOT."/profile/index.php?refurl=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
				Log In
			</a>
		</div>
		<div class="menuitem">
			<a href="<?php echo $CLIENT_ROOT; ?>/profile/newprofile.php">
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
-->
