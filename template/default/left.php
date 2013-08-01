<!-- left column -->
<div class="column lsidebar">
	
    <h3 id="main_menu"></h3>
    <ul>
        <li>
        	<a href="board.php"><img src="template/default/images/icons/comment.gif" alt="" /> <?php echo LANG_WALL;?></a>
        </li>
        <li>
        	<a href="home.php"><img src="template/default/images/icons/tables.gif" alt="" /> <?php echo LANG_PROJECTS;?></a>
        </li>
        <li>
        	<a href="date.php?action=list"><img src="template/default/images/icons/date.gif" alt="" /> <?php echo LANG_EVENTS;?></a>
        </li>
    </ul>
    <?php 
    //Non visualizzo il menu delle azioni se non ho selezionato un progetto (per evitare errori)
    if($this->session->data['idproject']>0) {
    ?>
    <h3 id="action"></h3>
    <ul>
        <li><a href="addentry.php?type=3" rel="facebox"><img src="template/default/images/icons/comment_new.gif" /> <?php echo LANG_ADD_MESSAGE;?></a></li>
        <li><a href="addentry.php?type=2" rel="facebox"><img src="template/default/images/icons/icon_link.gif" /> <?php echo LANG_ADD_LINK;?></a></li>
        <li><a href="addentry.php?type=4" rel="facebox"><img src="template/default/images/icons/icon_attachment.gif" /> <?php echo LANG_ADD_ATTACHMENT;?></a></li>
        <li><a href="addentry.php?type=1" rel="facebox"><img src="template/default/images/icons/page_tree.gif" /> <?php echo LANG_ADD_PHOTO;?></a></li>
        <?php 
        if (($this->registry->get('user')->isCollaborator()) || ($this->registry->get('user')->clientOf()==0)) { ?>
        <li><a href="date.php"><img src="template/default/images/icons/date_new.gif"/> <?php echo LANG_ADD_EVENT;?></a></li>
        <?php } ?>
        <li><a href="exportPDF.php" target="_blank"><img src="template/default/images/icons/file_acrobat.gif"/> <?php echo LANG_GENERATE_PDF;?></a></li>
    </ul>
    <?php } ?>
</div>
<!-- left column -->