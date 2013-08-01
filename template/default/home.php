<!-- main column -->
<div class="column main">
    <!-- 
    <h2 id="wall"></h2>
    <h3 id="subwall"> di <a href="#"><?php echo $firstname." ".$lastname?></a> </h3>
    <p id="date"><?php echo date("l d F Y"); ?></p>
     
    <br /><br /><br />
    -->
    <h2 id="projects">Progetti attivi</h2>
    <h3 id="subwall">&nbsp;</h3>
    <p id="date"> <?php echo LANG_OF;?> <a href="#"><?php echo $firstname." ".$lastname?></a></p>
	<?php if($userclientOf==0) {?>	
	<p><?php /* echo LANG_HOME_WELCOME_WITH_PROJECT_LIMIT_1.' '.$userProjectLimit.' '.LANG_HOME_WELCOME_WITH_PROJECT_LIMIT_2;*/ ?></p>
	<?php } ?>
		<?php
        if(sizeof($projectList)>0 ) {
		
			foreach($projectList as $project) {
	            ?>
	        <div class="column main projects"><a href="board.php?idproject=<?php echo $project['idproject']?>">
	            <?php echo $project['project_description']?></a> 
	            
	            <?php if($userclientOf==0) { 
					if($project['corr_user_id']!="")  { echo '<br /><br />'.LANG_PEOPLE.'<br /> ';
						echo $project['customer'];
					}
					else echo LANG_NO_PEOPLE; 
	            }
	            	?>
	        </div>
	  <?php } 
        } else {
        	if ($userclientOf==0)
        	echo '<p> '.LANG_HOME_NO_PROJECT.'</p>';
        	if ($isCollaborator=='1')
        	echo '<p> '.LANG_HOME_NO_PROJECT_COLLABORATORS.'</p>';
        }
        ?>

</div>
<!-- // main column -->