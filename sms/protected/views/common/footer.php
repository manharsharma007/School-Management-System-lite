				<div class="footer"><p>&copy; <?= date('Y') ?>. <?= (isset($institute_logo) && $institute_logo != '') ? '<img src="'.SITE_URL.$institute_logo.'" class="img_logo">' : '' ?> <?= (isset($institute_name)) ? $institute_name : '' ?> <em class="address"><?= (isset($institute_address) && $institute_address != '') ? ' | '.$institute_address : '' ?></em></p></div>
				</div>
			</aside>
		</div>
    </div>


	<?php Loader::addScript('jquery.datetimepicker.js'); ?>
	<?php Loader::addScript('script.js'); ?>
</body>	
</html>