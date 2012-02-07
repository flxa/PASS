
		</div>
		<?php if ($_REQUEST['debug']==1) { ?>
		<div class="debug">
			<?php echo '<h3>Data</h3><pre>'; echo print_r($data); echo '</pre>'; ?>
			<?php echo '<h3>Session</h3><pre>'; echo print_r($_SESSION); echo '</pre>'; ?>
			<?php echo '<h3>Cookie</h3><pre>'; echo print_r($_COOKIE); echo '</pre>'; ?>
			<?php if ($data->db->result) { $x = mysql_fetch_object($data->db->result); } ?>
			<?php echo '<h3>Row</h3><pre>'; echo print_r($x); echo '</pre>'; ?>
		</div>
		<?php } ?>
	</div>
	<footer>
		<span>&copy; <?php echo date('Y',strtotime(now)); ?> Print National</span>
		<div class="layout-icon"></div>
		<div class="browser-details" style="display:none;">
			<div class="browser-details-top">&nbsp;</div>
			<p><b>pass:~ Browser$</b></p>
			<p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
		</div>
	</footer>
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
  <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
  <!--<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>-->
  <!-- scripts concatenated and minified via ant build script -->
  <script src="js/mylibs/helper.js"></script>
  <!-- end concatenated and minified scripts-->
  <script src="js/mylibs/bootstrap-modal.js"></script>
  <script src="js/mylibs/bootstrap-dropdown.js"></script>
  <script src="js/mylibs/bootstrap-tabs.js"></script>
  <script src="js/mylibs/bootstrap-twipsy.js"></script>
  <script src="js/mylibs/bootstrap-popovers.js"></script>
  <script src="js/mylibs/bootstrap-alerts.js"></script>
  <script src="js/myscripts/modal-forms.js"></script>
  <script src="js/myscripts/pass.js"></script>
  <script>
	  $(function () {
	    $('.tabs').tabs()
	  })
  </script>
  <script>
		$(function () { 
			$("a[rel=popover]").popover({ 
				offset: 10 
			}).click(function(e) { 
				e.preventDefault() 
			}) 
		})
  </script>
  <script>
    MBP.scaleFix();
  </script>
  <script src="js/mylibs/bootstrap-datepicker.js"></script>
</body>
</html>
<?php mysql_close($mysql_link); ?>
